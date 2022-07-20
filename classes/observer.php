<?php

namespace local_autocompleteactivities;
require_once("$CFG->libdir/externallib.php");
defined('MOODLE_INTERNAL') || die();

class observer {
    public static function get_course_module_module_type_name($cm) {
        global $DB;
        return $DB->get_record('modules', array('id'=>$cm->module))->name;
    }
    
    public static function get_course_module_name($cm, $cm_type_name) {
        global $DB;
        $cm_type_specific_record = $DB->get_record($cm_type_name, array('id'=>$cm->instance));
        return $cm_type_name == 'label'? $cm_type_specific_record->intro : $cm_type_specific_record->name;  
    }

    public static function prefix_match($name, $comparison_name) {
        // returns true if name and comparison name share a comon prefix up to the start of a bracket sign, or are exactly the same, else false
        $clean_name = trim(strtolower($name));
        $clean_cmp = trim(strtolower($comparison_name));
        if($clean_name == $clean_cmp) {
            return true; // names are identical
        }
        
        $name_prefix_end = strpos($clean_name, '(');
        $cmp_prefix_end = strpos($clean_cmp, "(");
        if($name_prefix_end === false || $cmp_prefix_end === false) {
            return false; // at least one string does not contain a bracket
        }
        
        $name_prefix = trim(substr($clean_name, 0, $name_prefix_end+1));
        $cmp_prefix = trim(substr($clean_cmp, 0, $cmp_prefix_end+1));
        return $name_prefix == $cmp_prefix;
    }

    public static function forward_event($url, $data){
        $curl = curl_init($url);
        $json = json_encode($data);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
    }

    public static function mark_complete($courseid, $userid, $coursemodule) {
        global $DB;
        // Update course mpdule completion state
        $course = $DB->get_record("course", array("id"=>$courseid));
        $completion = new \completion_info($course);
        $completion->set_module_viewed($coursemodule, $userid);
        $completion->update_state($coursemodule, COMPLETION_COMPLETE, $userid);
        // observer::forward_event('http://193.196.53.252:44123/event', array("COMPLETION STATE UPDATED"));
    }

    public static function get_completion_state($coursemodule, $userid) {
        global $DB;
        if($DB->record_exists('course_modules_completion', array('coursemoduleid'=>$coursemodule->id, 'userid'=>$userid))) {
            return $DB->get_record('course_modules_completion', array('coursemoduleid'=>$coursemodule->id, 'userid'=>$userid))->completionstate;
        }
        return null;
    }

    public static function course_module_completion_updated(\core\event\base $event) {
        global $DB;
        global $CFG;
        $data = $event->get_data();
        $userid = $data['relateduserid'];
        $contextinstanceid = $data['contextinstanceid'];
        $updated_completion_state = $data['other']['completionstate'];

        // observer::forward_event('http://193.196.53.252:44123/event', array("NEW EVENT WITH COMPLETIONSTATE", $updated_completion_state));

        $cm = $DB->get_record('course_modules', array('id'=>$contextinstanceid));
        
        // check if course associated with update is in whitelist specified in settings
        // if not, stop
        $found = false;
        foreach(explode(",", $CFG->local_autocompleteactivities_coursenames) as $allowedcourseid) {
            if(intval($allowedcourseid) == $cm->course) {
                $found = true;
                break;
            }
        }
        if($found == false) {
            return;
        }
        
        // observer::forward_event('http://193.196.53.252:44123/event', $data);
        if($updated_completion_state == 1) {
            $cm_type_name = observer::get_course_module_module_type_name($cm);
            $cm_name = observer::get_course_module_name($cm, $cm_type_name);
            $courseid = $data['courseid'];

            // observer::forward_event('http://193.196.53.252:44123/event', array("ORIGINAL MODULE EVENT", $cm_name, $cm_type_name));

            // only update if completionstate changed (to positive)
            $section_cms = $DB->get_records("course_modules", array('section'=>$cm->section)); // get all course modules in the same section as cm from event
            //  || $cm_type_name == "page"
            $all_done = true;
            $cm_label_kannichschon = null;
            if($cm_type_name == "book" || $cm_type_name == "resource" || $cm_type_name == "url") { // whitelist by module type (labels not included here: clicking e.g. "kann ich schon" should not mark other modules as completed, but the other way around)
                foreach($section_cms as $related_cm) { // get all course modules in the same course section s.t. we don't have to search by name
                    $related_cm_typename = observer::get_course_module_module_type_name($related_cm);
                    $related_cm_name = observer::get_course_module_name($related_cm, $related_cm_typename);
                    
                    if($related_cm->id != $cm->id) { // don't re-trigger event for event source 
                        // observer::forward_event('http://193.196.53.252:44123/event', array("RELATED TYPE NAME", $related_cm_typename, "RELATED NAME", $related_cm_name));
                        //  || $related_cm_typename == "page"
                        if($related_cm_typename == 'book' || $related_cm_typename == 'resource' || $related_cm_typename == 'label' || $related_cm_typename == "url") { // whitelist related course modules from same section by module type
                            if($related_cm_typename == "label" and strpos($related_cm_name, "kann ich schon") !== false) {
                                $cm_label_kannichschon = $related_cm;
                                // observer::forward_event('http://193.196.53.252:44123/event', array("   -> FOUND kann ich schon"));
                            }
                            elseif(observer::prefix_match($cm_name, $related_cm_name)) {
                                observer::mark_complete($courseid, $userid, $related_cm);
                            }
                        }
                    }

                    observer::forward_event('http://193.196.53.252:44123/event', array(" -> RELATED CM", $related_cm_name, $related_cm_typename));
                        if($related_cm_typename != "label" && $related_cm_typename != 'page' && !observer::get_completion_state($related_cm, $userid)) { // labels and pages should not count as non-completed items
                            // observer::forward_event('http://193.196.53.252:44123/event', array("    -> NOT ALL DONE"));
                            $all_done = false; // we can't set "kann ich schon" label to "completed" since not all modules in this course section were completed
                    }
                }
            }

            // mark "kann ich schon" label as "completed" because all course modules in the section are completed
            if($all_done && !is_null($cm_label_kannichschon)) {
                // observer::forward_event('http://193.196.53.252:44123/event', array(" ==> Kann ich schon is marked done"));
                observer::mark_complete($courseid, $userid, $cm_label_kannichschon);
            }
        }
    }
}
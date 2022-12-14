# Autocomplete related activities #

## English Description
**German version please see below**

This plugin allows to provide activities and resources of types URL, file or book as alternative resources. 

If one of the alternatives is marked complete, the plugin automatically marks the remaining alternatives as complete too. 

It considers those activities and resources as alternatives that are within the same section and have identical names up to an opening bracket. Thus, material could be offered as

* example topic (book variant)
* example topic (link to a video variant)
* example topic (as a PDF file)

The plugin then considers them alternatives, and if one is completed, it automatically marks the others as completed too. 

In addition, it is possible to introduce a label that contains the text "kann ich schon". In this case learners can indicate that they don't need to go through any of the alternatives. If such a label is present, it is automatically marked complete if one of the alternatives is completed (assuming that in this case there is also no need to go through the alternatives any more). The automatic marking does not work the other way: if only the label is marked as complete, the alternatives keep their completion status. 

The plugin is only active in those courses for which it is configured (by indicating the respective course IDs in the settings of the plugin).

More details on functionality and configuration of this plugin can be found in the [Wiki](https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/wiki).
 
 
### Installing via Moodle Web Interface

1. Load the .zip file with the newest version from [https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/releases](https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/releases).
2. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
3. Upload the ZIP file with the plugin code and click _Install plugin from the ZIP file_
4. Check the plugin validation report and finish the installation.
5. You are prompted to configure the plugin. Please specify in which courses the plugin should be active by selecting from the list of available courses. For example, you may enter `1,2` to activate the plugin in the courses with the IDs 1 and 2. This concludes the configuration.

If you want to change the configuration later, come back to the plugin page (_Site administration > Plugins_). Click _Category: Local plugins_. You will find the configuration page of the plugin under _Manage Activity Autocompletion Settings_.

### Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/autocomplete_activities

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.


## Deutsche Beschreibung

Dieses Plugin erlaubt es, Aktivit??ten und Arbeitsmaterial vom Typ URL, Datei oder Buch als Alternativen zur Verf??gung zu stellen. 

Wenn eine der Alternativen als abgeschlossen markiert wird, markiert das Plugin automatisch auch die Alternativen in der Datenbank als abgeschlossen. 

Als Alternativen gelten Aktivit??ten und Arbeitsmaterial innerhalb des selben Kursabschnitts, wenn ihre Namen bis zu einer ??ffnenden Klammer identisch sind. So kann man das Material z.B. als 

* Beispielthema (Buchvariante)
* Beispielthema (Link zu Videovariante)
* Beispielthema (als PDF)

zur Verf??gung stellen. Das Plugin erkennt dann, dass es sich um Alternativen handelt, und kennzeichnet bei Erledigung einer Alternative auch die anderen als erledigt. 

Au??erdem ist es m??glich, zus??tzlich ein Textfeld anzulegen, das den Text "kann ich schon" enth??lt. Dadurch k??nnen Lernende selbst??ndig markieren, welches Material sie ??berspringen wollen. Falls so ein Textfeld vorhanden ist, wird es bei der Erledigung der Aktivit??ten in dem Abschnitt automatisch ebenfalls als erledigt gekennzeichnet. Andersherum geschieht das allerdings nicht automatisch: wird nur das Textfeld "kann ich schon" erledigt, behalten die weiteren Materialien ihren Erledigungs-Status. 

Das Plugin wird nur in den Kursen aktiv, f??r die es konfiguriert wurde (durch Angabe der Kurs-IDs der gew??nschten Kurse bei den Einstellungen des Plugins).

Mehr Informationen zu den Funktionen und zur Konfiguration des Plugins sind im [Wiki](https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/wiki) zu finden.

### Installation ??ber das Web-Interface von Moodle

1. Laden Sie unter [https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/releases](https://github.com/SE-Stuttgart/kib3_moodleplugin_autocompleteactivities/releases) das .zip-File mit der neuesten Version.
2. Loggen Sie sich in Ihrem Moodle als Admin ein und gehen Sie zu _Website-Administration > Plugins > Plugin installieren_. 
3. Laden Sie das .zip-File hoch und klicken Sie _Plugin installieren_.
4. ??berpr??fen Sie die Hinweise und schlie??en Sie die Installation ab.
5. Sie bekommen anschlie??end eine Seite zur Konfiguration des Plugins angezeigt. W??hlen Sie hier bitte aus, in welchen Kursen das Plugin aktiv sein darf. Zum Beispiel k??nnen sie `1,2` eingeben um das Plugin in den Kursen mit den IDs 1 und 2 zu aktivieren. Damit ist die Konfiguration abgeschlossen.

Falls die Konfiguration sp??ter ge??ndert werden soll, kommen Sie zur??ck zur Plugin-Seite (_Website-Administration > Plugins_). Sie finden dort unter _Bereich: Lokale Plugins_ den Punkt _Manage Activity Autocompletion Settings_, unter dem Sie das Plugin wie oben erkl??rt konfigurieren k??nnen.

Bitte beachten Sie, dass das Plugin nicht r??ckwirkend funktioniert: es markiert die Alternativen erst ab dem Zeitpunkt, ab dem es f??r einen Kurs konfiguriert wurde, automatisch als erledigt. Alternativen zu bereits fr??her abgeschlossenem Arbeitsmaterial bleiben unerledigt und m??ssen ggf. von Hand erledigt werden. Wenn die Funktionalit??t also gew??nscht wird, sollte das Plugin m??glichst vor Kursbeginn installiert sein.



## License ##

2022 Universtity of Stuttgart <dirk.vaeth@ims.uni-stuttgart.de>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.

## F??rderhinweis
**English version please see Acknowledgement below**

Diese Software wird im Rahmen des Projekts $KI$ $B^3$ -  *K??nstliche Intelligenz in die Berufliche Bildung bringen* als InnoVeET-Projekt aus Mitteln des Bundesministeriums f??r Bildung und Forschung gef??rdert. Projekttr??ger ist das Bundesinstitut f??r Berufsbildung (BIBB). Im Projekt werden eine Zusatzqualifikation (DQR 4) sowie zwei Fortbildungen (auf DQR5- bzw. DQR-6 Level) f??r KI und Maschinelles Lernen entwickelt. Die Software soll die Lehre in diesen Fortbildungen unterst??tzen.

## Acknowledgement
This software is developed in the project $KI$ $B^3$ -  *K??nstliche Intelligenz in die Berufliche Bildung bringen*. The project is funded by the German Federal Ministry of Education and Research (BMBF) as part of the InnoVET funding line, with the Bundesinstitut f??r Berufsbildung (BIBB) as funding organization. The project also develops vocational training programs on Artificial Intelligence and Machine Learning (for DQR levels 4, 5, and 6). The software supports teaching in these programs. 

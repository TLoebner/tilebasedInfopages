<?PHP
/**
 *  Copyright [2016] [Torsten Loebner <loebnert@gmail.com>]
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *				or
 *
 *    https://github.com/TLoebner/tilebasedInfopages/blob/master/LICENSE
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
    $query = "SELECT * FROM commonIncidents WHERE status='new';";
    $res_incidents = $mysqli->query($query);
    $ToDoList['incidents']['num'] = 0;
    $ToDoList['incidents']['num'] += $res_incidents->num_rows;
    $i=0;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        $ToDoList['incidents'][$i] = "<a href=\"index.php?action=ShowFeedback&id=".$incident['pk']."\">Allgemeines Feedback</a>";
        $i++;
    }
    $query = "SELECT * FROM all_incidents WHERE status='new';";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['incidents']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        if ($incident['help_content_pk'] > 0){
            //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['help_content_pk']."\"> Hilfe-Eintrag</a></font></td></tr>";
            $ToDoList['incidents'][$i] = "<a href=\"index.php?action=EditHelp&pk=".$incident['help_content_pk']."\">Hilfe-Eintrag</a>";
            $i++;
        }
        if ($incident['faq_content_pk'] > 0){
            //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_faq.php?pk=".$incident['faq_content_pk']."\"> FAQ-Eintrag</a></font></td></tr>";
            $ToDoList['incidents'][$i] = "<a href=\"index.php?action=EditFaq&pk=".$incident['faq_content_pk']."\">FAQ-Eintrag</a>";
            $i++;
        }
    }}

    $i=0;
    $ToDoList['emptyContent']['num'] = 0;
    $query = "SELECT * FROM `section_count` WHERE count=0";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['emptyContent']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_help_section.php?pk=".$incident['pk']."\">Leere Rubrik im Hilfebereich</a></font></td></tr>";
        $ToDoList['emptyContent'][$i] = "<a href=\"index.php?action=DeleteEmptyHelpSection&pk=".$incident['pk']."\">Leere Rubrik im Hilfebereich</a>";
        $i++;
    }}
    $query = "SELECT * FROM `subsection_count` WHERE count=0";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['emptyContent']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_help_subsection.php?pk=".$incident['pk']."\">Leere Unterrubrik im Hilfebereich</a></font></td></tr>";
        $ToDoList['emptyContent'][$i] = "<a href=\"index.php?action=DeleteEmptyHelpSubSection&pk=".$incident['pk']."\">Leere Unterrubrik im Hilfebereich</a>";
        $i++;
    }}
    $query = "SELECT * FROM `FAQ_section_count` WHERE count=0";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['emptyContent']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_faq_section.php?pk=".$incident['pk']."\">Leere Unterrubrik im FAQ-Bereich</a></font></td></tr>";
        $ToDoList['emptyContent'][$i] = "<a href=\"index.php?action=DeleteEmptyFaqSection&pk=".$incident['pk']."\">Leere Unterrubrik im FAQ-Bereich</a>";
        $i++;
    }}

    $i=0;
    $ToDoList['ContentErrors']['num'] = 0;
    $query = "SELECT * FROM `description_errors`";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['ContentErrors']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['pk']."\"> Beschreibung prüfen</a></font></td></tr>";
        $ToDoList['ContentErrors'][$i] = "<a href=\"index.php?action=EditHelp&pk=".$incident['pk']."\"> Beschreibung prüfen</a>";
        $i++;
    }}
    $query = "SELECT * FROM `show_doubbles`";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['ContentErrors']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"show_doubles.php?pk=".$incident['pk']."\"> Doppeleintrag </a></font></td></tr>";
        $ToDoList['ContentErrors'][$i] = "<a href=\"index.php?action=ShowDoubles&pk=".$incident['pk']."\"> Doppeleintrag </a>";
        $i++;
    }}
    $query = "SELECT * FROM help_contents WHERE http_result='DEAD LINK';";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['ContentErrors']['num'] += $res_incidents->num_rows;
    while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['pk']."\"> Link-Fehler </a></font></td></tr>";
        $ToDoList['ContentErrors'][$i] = "<a href=\"index.php?action=EditHelp&pk=".$incident['pk']."\"> Link-Fehler </a>";
        $i++;
    }}

    $i=0;
    $ToDoList['LinkErrors']['num'] = 0;
    $query = "SELECT * FROM all_help_contents WHERE section_pk IS NULL;";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['LinkErrors']['num'] += $res_incidents->num_rows;
    while ($unsorted = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$unsorted['content_pk']."\">unzugeordneter Eintrag</a></font></td></tr>";
        $ToDoList['LinkErrors'][$i] = "<a href=\"index.php?action=EditHelp&pk=".$unsorted['content_pk']."\">unzugeordneter Eintrag</a>";
        $i++;
    }}
    $query = "SELECT * FROM all_faq_contents WHERE section_pk IS NULL;";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows > 0){
    $ToDoList['LinkErrors']['num'] += $res_incidents->num_rows;
    while ($unsorted = $res_incidents->fetch_array(MYSQLI_ASSOC)){
        //echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_faq.php?pk=".$unsorted['content_pk']."\">unzugeordneter Eintrag</a></font></td></tr>";
        $ToDoList['LinkErrors'][$i] = "<a href=\"index.php?action=EditFaq&pk=".$unsorted['content_pk']."\">unzugeordneter Eintrag</a>";
        $i++;
    }}
?>


   <div class="row">
          ToDo-Liste
        </div>
        <ul class="vertical menu" data-accordion-menu>
          <li><a href="#">Nutzerfeedback (<?PHP echo $ToDoList['incidents']['num'];?>)</a>
            <ul class="menu vertical nested">
            <?PHP
            for ($i=0;$i<$ToDoList['incidents']['num'];$i++){
                echo "<li>".$ToDoList['incidents'][$i]."</li>\n";
            }
            ?>
            </ul>
          </li>
          <li><a href="#">Leere Menüeinträge (<?PHP echo $ToDoList['emptyContent']['num'];?>)</a>
            <ul class="menu vertical nested">
            <?PHP
            for ($i=0;$i<$ToDoList['emptyContent']['num'];$i++){
                echo "<li>".$ToDoList['emptyContent'][$i]."</li>\n";
            }
            ?>
            </ul>
          </li>
          <li><a href="#">Inhaltefehler (<?PHP echo $ToDoList['ContentErrors']['num'];?>)</a>
            <ul class="menu vertical nested">
            <?PHP
            for ($i=0;$i<$ToDoList['ContentErrors']['num'];$i++){
                echo "<li>".$ToDoList['ContentErrors'][$i]."</li>\n";
            }
            ?>
            </ul>
          </li>
          <li><a href="#">unzugeordnete Einträge (<?PHP echo $ToDoList['LinkErrors']['num'];?>)</a>
            <ul class="menu vertical nested">
            <?PHP
            for ($i=0;$i<$ToDoList['LinkErrors']['num'];$i++){
                echo "<li>".$ToDoList['LinkErrors'][$i]."</li>\n";
            }
            ?>
            </ul>
          </li>
        </ul>
      </div>

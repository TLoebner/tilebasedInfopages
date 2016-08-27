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
if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
?>
<div id='scroll_clipper' style='position:absolute; width:150px; height: 500px; overflow:auto'>
<div id='scroll_text' style='background-color:white'>
    <table>
    <tr><td>ToDo Liste:</td></tr>
    <?PHP
        $query = "SELECT * FROM all_incidents WHERE status='new';";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            if ($incident['help_content_pk'] > 0){
                echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['help_content_pk']."\"> Hilfe-Eintrag</a></font></td></tr>";
            }
            if ($incident['faq_content_pk'] > 0){
                echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_faq.php?pk=".$incident['faq_content_pk']."\"> FAQ-Eintrag</a></font></td></tr>";
            }
        }}

        $query = "SELECT * FROM `section_count` WHERE count=0";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_help_section.php?pk=".$incident['pk']."\">Leere Rubrik im Hilfebereich</a></font></td></tr>";
        }}
        $query = "SELECT * FROM `subsection_count` WHERE count=0";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_help_subsection.php?pk=".$incident['pk']."\">Leere Unterrubrik im Hilfebereich</a></font></td></tr>";
        }}
        $query = "SELECT * FROM `FAQ_section_count` WHERE count=0";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"delete_empty_faq_section.php?pk=".$incident['pk']."\">Leere Unterrubrik im FAQ-Bereich</a></font></td></tr>";
        }}
        $query = "SELECT * FROM `description_errors`";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['pk']."\"> Beschreibung prüfen</a></font></td></tr>";
        }}
        $query = "SELECT * FROM `show_doubbles`";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"show_doubles.php?pk=".$incident['pk']."\"> Doppeleintrag </a></font></td></tr>";
        }}
        $query = "SELECT * FROM help_contents WHERE http_result='DEAD LINK';";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$incident['pk']."\"> Link-Fehler </a></font></td></tr>";
        }}
        $query = "SELECT * FROM all_help_contents WHERE section_pk IS NULL;";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($unsorted = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_help.php?pk=".$unsorted['content_pk']."\"> unzugeordneter Eintrag </a></font></td></tr>";
        }}
        $query = "SELECT * FROM all_faq_contents WHERE section_pk IS NULL;";
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($unsorted = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><hr></td></tr><tr><td><font size=\"0.7 rem\"><a href=\"edit_faq.php?pk=".$unsorted['content_pk']."\"> unzugeordneter Eintrag </a></font></td></tr>";
        }}
    ?>
    </table>
</div>
</div>
<?PHP
}
?>

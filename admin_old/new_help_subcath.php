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
require_once 'log.class.php';
$log = new LogFileHandler();
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
foreach ($_POST as $key => $value){
//     echo $key." : ".$value."<br/>\n";
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'new'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
//     echo $key1." : ".$value1."<br/>\n"; 
    if (is_numeric($key1)){
        $query = "INSERT INTO help_subsections (help_section_fk,name,sequence_no) VALUES(".$value1['contents'].",'".$value1['name']."',".$value1['sequenceno'].")";
        $mysqli->query($query);
        $log->InsertItem("new_help_subcath.php -- ".$query);
        $log->WriteLog;
    }
}
$mysqli->close();
require 'admin_header.php';
?>
<table>
<tr valign="top">
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_menu.php';
?>
</div>
</td>
<td valign="top">
<div style="width:600 px;height:100%;overflow-y: auto;overflow-x: auto;">
<form name="new_help_subcath" method="POST" action="new_help_subcath.php">
<table>
<tr>
<td>Teil</td><td>&nbsp;</td><td>Name</td>
</tr>
<?PHP
// Ausgabe der Ergebnisse in HTML
for ($x=0;$x<2;$x++) {
    echo "\t<tr>\n";
    echo "<td><select name=\"new_".(string)$x."_contents\">";
    foreach ($dataTblHelpSections as $key2 => $value2){
	if (is_numeric($key2))echo "<option value=\"".(string)$key2."\">".$value2['name']."</option>";
    }
    echo "</select></td>";
    echo "<td><input type=\"hidden\" value=\"9999\" name=\"new_".(string)$x."_sequenceno\" value=\"\"></td>\n";
    echo "<td><input type=\"text\" name=\"new_".(string)$x."_name\" value=\"\"></td>\n";
    echo "\t</tr>\n";
}
    echo "<tr>";
    echo "<td colspan=\"3\" align=\"center\">";
    echo "<input type=\"submit\" value=\"editieren\">";
    echo "</td>";
    echo "</tr>";
//     echo "\t</tr></table></td></tr>\n";
?>

</table>
</form>
</div>
</td>
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_todoList.php';
?>
</div>
</td>
</tr>
</table>
<script>
$(function() {
    // Replace all textarea's
    // with SCEditor
    $("textarea").sceditor({
        plugins: "bbcode",
        toolbar: "bold,italic,underline|source",
	style: "minified/jquery.sceditor.default.min.css"
    });
});
</script>
<?PHP
require 'admin_footer.php'
?>

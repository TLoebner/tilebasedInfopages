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
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'del'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
    if (is_numeric($key1)){
        $query = "DELETE FROM help_multicontents WHERE help_subsection_fk=".$value1['pk'].";";
        $mysqli->query($query);
        $query = "DELETE FROM help_subsections WHERE pk=".$value1['pk']." AND name='".$value1['rubrik']."';";
        $mysqli->query($query);
        $log->InsertItem("delete_faq.php -- ".$query);
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
<td>
<?PHP
if (isset($_GET['pk'])){
?>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<form name="delete_help_subcath" action="delete_help_subcath.php" method="POST">
<input type="hidden" name="del_1_rubrik" value="<?PHP echo $dataTblHelpSubsections[$_GET['pk']]['name']?>" >
<input type="hidden" name="del_1_pk" value="<?PHP echo $dataTblHelpSubsections[$_GET['pk']]['pk']?>" >
<table align="center" valign="center">
<tr><td> Rubrik "<?PHP echo $dataTblHelpSubsections[$_GET['pk']]['name']?>" wirklich löschen?</td></tr>
</table>
<input type="submit" value="JA">
</form>
<?PHP
}else{
echo "gelöscht";
}
?>
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

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
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
foreach ($_POST as $key => $value){
        $postvarsplit = preg_split('/_/',$key);
        if ($postvarsplit[0] == 'in'){
            $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
        }
    }
    foreach ($ergarray as $key1 => $value1){
        if (is_numeric($key1)){
            $query = "UPDATE configs SET type_text='".$value1['text']."' WHERE name='impressum';";
            $mysqli->query($query);
            $log->InsertItem("edit_screensaver.php -- ".$query);
            $log->WriteLog;
        }
    }
$mysqli->close();
require 'admin_header.php';
$log = new LogFileHandler();
?>
<table>
<tr valign="top">
<td>
<?PHP
require 'admin_menu.php';
?>
</td>
<td valign="top">
<form name="edit_impress" method="POST" action="edit_impress.php">
<?PHP
    $m=1;
    $query = "SELECT * FROM configs WHERE name='impressum';";
    $res_multicontent = $mysqli->query($query);
    if ($res_multicontent->num_rows > 0){
       $line2 = $res_multicontent->fetch_array(MYSQLI_ASSOC);
    }
?>
<textarea name="in_99_text" cols=160 rows=50><?PHP echo $line2['type_text'];?></textarea><br/>
<input type="submit" value="absenden">
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

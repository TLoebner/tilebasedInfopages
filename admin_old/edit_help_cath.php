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
// if(isset($_POST['key']) && isset($_POST['sequence']) && is_numeric($_POST['key']) && is_numeric($_POST['sequence'])){
    foreach ($_POST as $key => $value){
        $postvarsplit = preg_split('/_/',$key);
        if ($postvarsplit[0] == 'in'){
            $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
        }
    }
    foreach ($ergarray as $key1 => $value1){
        if (is_numeric($key1)){
            $query = "UPDATE help_sections SET name='".$value1['name']."', sequence_no=".$value1['reihe'].", fg='".$value1['fg']."' , bg='".$value1['bg']."' WHERE pk=".(string)$key1.";";
            $mysqli->query($query);
        }
        if(isset($_FILES['in_'.$key1.'_image'])){
            if(is_uploaded_file($_FILES['in_'.$key1.'_image']['tmp_name']) && getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']) != false){
                /***  get the image info. ***/
                $size = getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']);
                /*** assign our variables ***/
                $type = $size['mime'];
                $imgfp = fopen($_FILES['in_'.$key1.'_image']['tmp_name'], 'rb');
                $size = $size[3];
                $name = $_FILES['in_'.$key1.'_image']['name'];
                
                $query="UPDATE help_sections SET image='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['in_'.$key1.'_image']['tmp_name']))."' WHERE pk=".(string)$key1.";";
                $mysqli->query($query);

                $log->InsertItem("edit_help_cath.php -- ".$query);
                $log->WriteLog;
//                 echo $query;
            }
        }
    }
//     header("Location: ./edit_main.php");
// }


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
<form enctype="multipart/form-data" name="edit_help_cath" method="POST" action="edit_help_cath.php">
<table>
<tr>
<td>L&ouml;schen</td><td>&nbsp;</td><td>Name</td><td>Vordergrund</td><td>Hintergrund</td><td>Bild</td>
</tr>
<?PHP
foreach ($dataTblHelpSections as $key1 => $value1) {
    if (is_numeric($key1)){
        echo "\t<tr>\n";
        echo "<td align=center><a href=\"delete_help_cath.php?pk=".$key1."\">X</a></td>\n";
        echo "<td align=center><input type=\"hidden\" value=\"9999\" size=5 name=\"in_".$key1."_reihe\" value=\"".(string)$value1['sequence_no']."\"></td>\n";
        echo "<td align=center><input type=\"text\" size=50 style=\"color:".(string)$value1['fg'].";background-color:".(string)$value1['bg'].";\" name=\"in_".$key1."_name\" value=\"".(string)$value1['name']."\"></td>\n";
        echo "<td align=center><input type=\"text\" size=8 name=\"in_".$key1."_fg\" value=\"".(string)$value1['fg']."\"></td>\n";
        echo "<td align=center><input type=\"text\" size=8 name=\"in_".$key1."_bg\" value=\"".(string)$value1['bg']."\"></td>\n";
        echo "<td><input type=\"file\" name=\"in_".$key1."_image\"/></td>\n";
        echo "\t</tr>\n";
    }
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

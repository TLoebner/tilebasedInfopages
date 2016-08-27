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
  //echo $key." : ".$value."<br/>\n";
  $postvarsplit = preg_split('/_/',$key);
  if ($postvarsplit[0] == 'new'){
    $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
  }
}
foreach ($ergarray as $key1 => $value1){
        if ($value1['name'] != ""){
            $query = "INSERT INTO help_contents (name,description,link) VALUES('".$value1['name']."','".$value1['description']."','".$value1['link']."')";
            $mysqli->query($query);
            $help_pk = $mysqli->insert_id;
            for ($m=1;$m<=5;$m++){
            if ($value1['rubrik'.(string)$m] > 0){
                $query = "SELECT * FROM help_multicontents WHERE help_subsection_fk=".$value1['rubrik'.(string)$m]." AND help_content_fk=".$help_pk.";";
                $res_multicontent = $mysqli->query($query);
                $num_rows = 0;
                $num_rows = $res_multicontent->num_rows;
                $uid = uniqid('',true);
                if (!isset($value1['sequence'.(string)$m]))$value1['sequence'.(string)$m]=999;
                if ($res_multicontent->num_rows > 0){
                    $query = "UPDATE help_multicontents set uid='".$uid."', sequence_no=".$value1['sequence'.(string)$m]." WHERE help_subsection_fk=".$value1['rubrik'.(string)$m]." AND help_content_fk=".$help_pk.";";
                }else{
                    $query = "INSERT INTO help_multicontents  ( uid,sequence_no, help_subsection_fk, help_content_fk ) VALUES ( '".$uid."',".$value1['sequence'.(string)$m]." , ".$value1['rubrik'.(string)$m]." , ".$help_pk." );";
                }
                $mysqli->query($query);
                $log->InsertItem("new_help.php -- ".$query);
                $log->WriteLog;
            }
        }
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
<form name="new_help" method="POST" action="new_help.php">
<table>
<?PHP
    $m=1;
    $query = "SELECT * FROM help_multicontents WHERE help_content_fk=".$_GET['pk'];
    $res_multicontent = $mysqli->query($query);
    if ($res_multicontent->num_rows > 0){
       while ($line2 = $res_multicontent->fetch_array(MYSQLI_ASSOC)){
            $section_fk[$m]=$line2['help_subsection_fk'];
            $sequence[$m]=$line2['sequence_no'];
            $m++;
       }
    }
       
    for ($m=1;$m<=5;$m++){
        echo "<tr><td align=\"center\"><select name=\"new_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_rubrik".(string)$m."\">\n";
        echo "<option value=\"0\">unzugeordnet</option>\n";
        foreach ($dataTblHelpSubsections as $key1 => $value1){// FIXME multicontent
            if (is_numeric($key1)){
                if ($key1 == $section_fk[$m]){// FIXME multicontent
                    echo "<option value=\"".(string)$value1['pk']."\" selected>".$value1['name']."</option>\n";
                }else{
                    echo "<option value=\"".(string)$value1['pk']."\">".$value1['name']."</option>\n";
                }
            }
        }
        echo "</select></td><td><input type=\"hidden\" value=\"9999\" name=\"new_".(string)$_GET['pk']."_sequence".(string)$m."\" value=\"".(string)$sequence[$m]."\"></td><tr>\n";
    }
    echo "<tr><td colspan=\"2\" >&nbsp;&nbsp;&nbsp;<a href=\"delete_faq.php?pk=".$_GET['pk']."\">X</a></td></tr>";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    //echo "<td>Reihenfolge</td><td><input type=\"text\" name=\"new_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_reihe\" value=\"".(string)$dataTblFaqContents[$_GET['pk']]['sequence_no']."\" size=\"90\"></td>\n";// FIXME multicontent
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Institution</td><td><input type=\"text\" name=\"new_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_name\"value=\"\" size=\"90\"></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Beschreibung</td><td><textarea cols=\"80\" rows=\"10\"  name=\"new_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_description\"></textarea></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Link</td><td><input type=\"text\" name=\"new_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_link\" value=\"\" size=\"90\"></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td colspan=\"2\"><hr></td>";
    echo "<tr>";
    echo "<td colspan=\"2\" align=\"center\">";
    echo "<input type=\"submit\" value=\"editieren\">";
    echo "</td>";
    echo "</tr>";
//     echo "\t</tr></table></td></tr>\n";
//
//
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

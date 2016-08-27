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
foreach ($_POST as $key => $value){
  //echo $key." : ".$value."<br/>\n";
  $postvarsplit = preg_split('/_/',$key);
  if ($postvarsplit[0] == 'in'){
    $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
  }
}
foreach ($ergarray as $key1 => $value1){
//     echo $key1." : ".$value1."<br/>\n";
    if (is_numeric($key1)){
        $query = "UPDATE help_contents SET name='".$value1['name']."', link='".$value1['link']."', description='".$value1['description']."', http_result=' ' WHERE pk=".$key1;
//         fk_rubrik=".$value1['rubrik'].", reihe=".$value1['reihe'].", question='".$value1['question']."', answer='".$value1['answer']."', link='".$value1['link']."' WHERE pk=".$key1;
        $mysqli->query($query);
        $log->InsertItem("edit_help.php -- ".$query);
        $log->WriteLog;
        $dataTblHelpContents[$key1]['name'] = $value1['name'];
        $dataTblHelpContents[$key1]['link'] = $value1['link'];
        $dataTblHelpContents[$key1]['description'] = $value1['description'];
        /**
         *
         *  create links to cathegories and sequence numbers
         *
        **/
        for ($m=1;$m<=5;$m++){
            if ($value1['rubrik'.(string)$m] > 0){
                $query = "SELECT * FROM help_multicontents WHERE help_subsection_fk=".$value1['rubrik'.(string)$m]." AND help_content_fk=".$key1.";";
                $res_multicontent = $mysqli->query($query);
                $num_rows = 0;
                $num_rows = $res_multicontent->num_rows;
                $uid = uniqid('',true);
                if (!isset($value1['sequence'.(string)$m]))$value1['sequence'.(string)$m]=999;
                if ($res_multicontent->num_rows > 0){
                    $query = "UPDATE help_multicontents set uid='".$uid."', sequence_no=999 WHERE help_subsection_fk=".$value1['rubrik'.(string)$m]." AND help_content_fk=".$key1.";";
                }else{
                    $query = "INSERT INTO help_multicontents  ( uid,sequence_no, help_subsection_fk, help_content_fk ) VALUES ( '".$uid."',999 , ".$value1['rubrik'.(string)$m]." , ".$key1." );";
                }
                $mysqli->query($query);
                $log->InsertItem("edit_help.php -- ".$query);
                $log->WriteLog;
            }
        }
        // close incidents
        $message = "incident automatically closed by user interaction and content update on ".(string)date('l jS \of F Y h:i:s A');
        $query = "SELECT * FROM all_incidents WHERE help_content_pk=".$key1;
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($line1 = $res_incidents->fetch_array(MYSQLI_ASSOC)){
            $query = "UPDATE * help_incidents set comments='".$line1['comments']."<br/>".$message."' status='done' WHERE incident_fk=".$line1['incident_pk'];
            $mysqli->query($query);
        }
        }
    }
}
?>
<form name="edit_help" method="POST" action="index.php?action=EditHelp&pk=<?PHP echo $_GET['pk']?>">
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
    echo "<table>";
    echo "<tr><td colspan=\"3\"><a href=\"index.php?action=DeleteHelp&pk=".$_GET['pk']."\">Kompletten Eintrag löschen</a></td></tr>";
    echo "<tr><td colspan=\"3\">&nbsp;</td></tr></table><table>";
    for ($m=1;$m<=5;$m++){
        echo "<tr><td><a href=\"index.php?action=DeleteHelpMultiConts&sec=".(string)$section_fk[$m]."&cont=".(string)$dataTblHelpContents[$_GET['pk']]['pk']."\">Gruppe löschen</a></td><td align=\"center\"><select name=\"in_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_rubrik".(string)$m."\">\n";
        echo "<option value=\"0\">unzugeordnet</option>\n";
        foreach ($dataTblHelpSubsections as $key1 => $value1){
            if (is_numeric($key1)){
                if ($key1 == $section_fk[$m]){
                    echo "<option value=\"".(string)$value1['pk']."\" selected>".$dataTblHelpSections[$value1['help_section_fk']]['name']." - ".$value1['name']."</option>\n";
                }else{
                    echo "<option value=\"".(string)$value1['pk']."\">".$dataTblHelpSections[$value1['help_section_fk']]['name']." - ".$value1['name']."</option>\n";
                }
            }
        }
        echo "</select></td><td><input type=\"hidden\" value=\"9999\" name=\"in_".(string)$_GET['pk']."_sequence".(string)$m."\" value=\"".(string)$sequence[$m]."\"></td></tr>\n";
    }
    echo "<tr><td colspan=\"3\">&nbsp;</td></tr></table><table>";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Institution</td><td colspan=\"2\"><input type=\"text\" name=\"in_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_name\" value=\"".(string)$dataTblHelpContents[$_GET['pk']]['name']."\" size=\"90\"></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Beschreibung</td><td colspan=\"2\"><textarea cols=\"80\" rows=\"10\"  name=\"in_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_description\">".(string)$dataTblHelpContents[$_GET['pk']]['description']."</textarea></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Link</td><td colspan=\"2\"><input type=\"text\" name=\"in_".(string)$dataTblHelpContents[$_GET['pk']]['pk']."_link\" value=\"".(string)$dataTblHelpContents[$_GET['pk']]['link']."\" size=\"90\"></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td colspan=\"3\"><hr></td>";
    echo "<tr>";
    echo "<td colspan=\"3\" align=\"center\">";
    echo "<input type=\"submit\" value=\"editieren\">";
    echo "</td>";
    echo "</tr>";
//     echo "\t</tr></table></td></tr>\n";
//
//
?>
<!-- <table align="center" valign="top"> -->
<?PHP
if ($dataTblHelpContents[$_GET['pk']]['http_result'] == "DEAD LINK"){
    echo "<tr><td colspan=\"3\"><h2>Der angegebene Link funktioniert nicht. Bitte diesen korrigieren</h2></td></tr>";
}
?>
<tr><td><h2>Nutzer Feedback:<h2></td></tr>
<?PHP
$query = "SELECT * FROM all_incidents WHERE help_content_pk=".$_GET['pk']." AND status='new';";
$res_incidents = $mysqli->query($query);
while ($incident = $res_incidents->fetch_array(MYSQLI_ASSOC)){
    echo "<tr><td colspan=\"3\">".$incident['description']."</td></tr>";
}
?>
<!-- </table> -->
</table>
</form>

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
//     echo $key." : ".$value."<br/>\n";
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'in'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
//     echo $key1." : ".$value1."<br/>\n"; 
    if (is_numeric($key1)){
        $query = "UPDATE faq_contents SET question='".$value1['question']."', answer='".$value1['answer']."', link='".$value1['link']."' WHERE pk=".$key1;
//         fk_rubrik=".$value1['rubrik'].", reihe=".$value1['reihe'].", question='".$value1['question']."', answer='".$value1['answer']."', link='".$value1['link']."' WHERE pk=".$key1;
        $mysqli->query($query);
        /**
         *
         *  create links to cathegories and sequence numbers
         *
        **/
        for ($m=1;$m<=5;$m++){
            if ($value1['rubrik'.(string)$m] > 0){
                $query = "SELECT * FROM faq_multicontents WHERE faq_section_fk=".$value1['rubrik'.(string)$m]." AND faq_content_fk=".$key1.";";
                $res_multicontent = $mysqli->query($query);
                $uid = uniqid('',true);
                $num_rows = 0;
                $num_rows = $res_multicontent->num_rows;
                if ($res_multicontent->num_rows > 0){
                    $query = "UPDATE faq_multicontents set sequence_no=".$value1['sequence'.(string)$m]." uid='".(string)$uid."' WHERE faq_section_fk=".$value1['rubrik'.(string)$m]." AND faq_content_fk=".$key1.";";
                }else{
                    $query = "INSERT INTO faq_multicontents  ( sequence_no, faq_section_fk, faq_content_fk , uid) VALUES ( ".$value1['sequence'.(string)$m]." , ".$value1['rubrik'.(string)$m]." , ".$key1." , '".(string)$uid."');";
                }
                $mysqli->query($query);
            }
        }
        // close incidents 
        $message = "incident automatically closed by user interaction and content update on ".(string)date('l jS \of F Y h:i:s A');
        $query = "SELECT * FROM all_incidents WHERE faq_content_pk=".$key1;
        $res_incidents = $mysqli->query($query);
        if ($res_incidents->num_rows > 0){
        while ($line1 = $res_incidents->fetch_array(MYSQLI_ASSOC)){    
            $query = "UPDATE * faq_incidents SET comments='".$line1['comments']."<br/>".$message."' status='done' WHERE incident_fk=".$line1['incident_pk'];
            $mysqli->query($query);
            $log->InsertItem("edit_faq.php -- ".$query);
            $log->WriteLog;
        }
        }
    }
}
?>
<form name="edit_faq" method="POST" action="edit_faq.php?pk=<?PHP echo $_GET['pk']?>">
<table>
<?PHP
    $m=1;
    $query = "SELECT * FROM faq_multicontents WHERE faq_content_fk=".$_GET['pk'];
    $res_multicontent = $mysqli->query($query);
    if ($res_multicontent->num_rows > 0){
       while ($line2 = $res_multicontent->fetch_array(MYSQLI_ASSOC)){
            $section_fk[$m]=$line2['faq_section_fk'];
            $sequence[$m]=$line2['sequence_no'];
            $m++;
       }
    }
       
    for ($m=1;$m<=5;$m++){
        echo "<tr><td align=\"center\"><select name=\"in_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_rubrik".(string)$m."\">\n";
        echo "<option value=\"0\">unzugeordnet</option>\n";
        foreach ($dataTblFaqSections as $key1 => $value1){// FIXME multicontent
            if (is_numeric($key1)){
                if ($key1 == $section_fk[$m]){// FIXME multicontent
                    echo "<option value=\"".(string)$value1['pk']."\" selected>".$value1['name']."</option>\n";
                }else{
                    echo "<option value=\"".(string)$value1['pk']."\">".$value1['name']."</option>\n";
                }
            }
        }
        echo "</select></td><td><input type=\"hidden\" value=\"9999\" name=\"in_".(string)$_GET['pk']."_sequence".(string)$m."\" value=\"".(string)$sequence[$m]."\"></td><tr>\n";
    }
    echo "<tr><td colspan=\"2\" >&nbsp;&nbsp;&nbsp;<a href=\"delete_faq.php?pk=".$_GET['pk']."\">Kompletten Eintrag löschen</a></td></tr>";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    //echo "<td>Reihenfolge</td><td><input type=\"text\" name=\"in_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_reihe\" value=\"".(string)$dataTblFaqContents[$_GET['pk']]['sequence_no']."\" size=\"90\"></td>\n";// FIXME multicontent
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Frage</td><td><textarea cols=\"80\" rows=\"10\"  name=\"in_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_question\">".(string)$dataTblFaqContents[$_GET['pk']]['question']."</textarea></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Antwort</td><td><textarea cols=\"80\" rows=\"10\"  name=\"in_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_answer\">".(string)$dataTblFaqContents[$_GET['pk']]['answer']."</textarea></td>\n";
    echo "\t</tr><tr style=\"border:1px solid black;\">\n";
    echo "<td>Link</td><td><input type=\"text\" name=\"in_".(string)$dataTblFaqContents[$_GET['pk']]['pk']."_link\" value=\"".(string)$dataTblFaqContents[$_GET['pk']]['link']."\" size=\"90\"></td>\n";
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

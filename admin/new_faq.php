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
    if ($postvarsplit[0] == 'new'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
        if ($value1['question'] != ""){
            $query = "INSERT INTO faq_contents (question,answer,link) VALUES('".$value1['question']."','".$value1['answer']."','".$value1['link']."')";
            $mysqli->query($query);
            $faq_pk = $mysqli->insert_id;
            for ($m=1;$m<=5;$m++){
                if ($value1['rubrik'.(string)$m] > 0){
                    //$query = "SELECT * FROM faq_multicontents WHERE faq_section_fk=".$value1['rubrik'.(string)$m]." AND faq_content_fk=".$faq_pk.";";
                    //$res_multicontent = $mysqli->query($query);
                    $uid = uniqid('',true);
                    //$num_rows = 0;
                    //$num_rows = $res_multicontent->num_rows;
                    //if ($res_multicontent->num_rows > 0){
                    //    $query = "UPDATE faq_multicontents set sequence_no=".$value1['sequence'.(string)$m]." uid='".(string)$uid."' WHERE faq_section_fk=".$value1['rubrik'.(string)$m]." AND faq_content_fk=".$faq_pk.";";
                    //}else{
                        $query = "INSERT INTO faq_multicontents  ( sequence_no, faq_section_fk, faq_content_fk , uid) VALUES ( ".$value1['sequence'.(string)$m]." , ".$value1['rubrik'.(string)$m]." , ".$faq_pk." , '".(string)$uid."');";
                    //}
                    $mysqli->query($query);
                    $log->InsertItem("new_faq.php -- ".$query);
                    $log->WriteLog;
                }
            }
        }
}
?>
<form name="edit_faq" method="POST" action="index.php?action=NewFaq">
<table>
<?PHP
//
//
    for ($z = 0;$z<1;$z++){
        for ($m=1;$m<=5;$m++){
        echo "<tr><td align=\"center\"><select name=\"new_".(string)$z."_rubrik".(string)$m."\">\n";
        echo "<option value=\"0\">unzugeordnet</option>\n";
        foreach ($dataTblFaqSections as $key1 => $value1){
            if (is_numeric($key1)){
                if ($key1 == $section_fk[$m]){
                    echo "<option value=\"".(string)$value1['pk']."\" selected>".$value1['name']."</option>\n";
                }else{
                    echo "<option value=\"".(string)$value1['pk']."\">".$value1['name']."</option>\n";
                }
            }
        }
        echo "</select></td><td><input type=\"hidden\" value=\"9999\" name=\"new_".(string)$z."_sequence".(string)$m."\" value=\"\"></td><tr>\n";
        }
        echo "\t<tr style=\"border:1px solid black;\">\n";
        echo "<td>Frage</td><td><textarea cols=\"80\" rows=\"10\"  name=\"new_".(string)$z."_question\"></textarea></td>\n";
        echo "\t</tr><tr style=\"border:1px solid black;\">\n";
        echo "<td>Antwort</td><td><textarea cols=\"80\" rows=\"10\"  name=\"new_".(string)$z."_answer\"></textarea></td>\n";
        echo "\t</tr><tr style=\"border:1px solid black;\">\n";
        echo "<td>Link</td><td><input type=\"text\" name=\"new_".(string)$z."_link\" value=\"#\" size=\"90\"></td>\n";
        echo "\t</tr><tr style=\"border:1px solid black;\">\n";
        echo "<td colspan=\"2\"><hr></td>";
    }
        echo "<tr>";
        echo "<td colspan=\"2\" align=\"center\">";
        echo "<input type=\"submit\" value=\"editieren\">";
        echo "</td>";
        echo "</tr>";
?>
</table>
</form>

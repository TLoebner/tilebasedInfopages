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
//     echo $key1." : ".$value1."<br/>\n";
    if (is_numeric($key1)){
        if(isset($_FILES['new_'.$key1.'_image'])){
                if(is_uploaded_file($_FILES['new_'.$key1.'_image']['tmp_name']) && getimagesize($_FILES['new_'.$key1.'_image']['tmp_name']) != false){
                    /***  get the image info. ***/
                    $size = getimagesize($_FILES['new_'.$key1.'_image']['tmp_name']);
                    /*** assign our variables ***/
                    $type = $size['mime'];
                    $imgfp = fopen($_FILES['new_'.$key1.'_image']['tmp_name'], 'rb');
                    $size = $size[3];
                    $name = $_FILES['new_'.$key1.'_image']['name'];
                    //$query="UPDATE help_sections SET image='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['new_'.$key1.'_image']['tmp_name']))."' WHERE pk=".(string)$key1.";";
                    //$mysqli->query($query);
                }
            }
        $query = "INSERT INTO faq_sections (name,sequence_no,fg,bg,image) VALUES('".$value1['name']."',".$value1['reihe'].",'".$value1['fg']."','".$value1['bg']."','".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['new_'.$key1.'_image']['tmp_name']))."')";
        $mysqli->query($query);
        $log->InsertItem("new_faq_cath.php -- ".$query);
        $log->WriteLog;
    }
}
?>
<form enctype="multipart/form-data" name="new_faq_cath" method="POST" action="index.php?action=NewFaqCath">
<table>
<tr>
<td>Reihenfolge</td><td>Name</td><td>Vordergrund</td><td>Hintergrund</td><td>Bild</td>
</tr>
<?PHP
for ($x=0;$x<2;$x++) {
    echo "\t<tr>\n";
    echo "<td align=center><input type=\"hidden\" value=\"9999\" size=5 name=\"new_".$x."_reihe\" value=\"".(string)$value1['sequence_no']."\"></td>\n";
    echo "<td align=center><input type=\"text\" size=50 style=\"color:".(string)$value1['fg'].";background-color:".(string)$value1['bg'].";\" name=\"new_".$x."_name\" value=\"".(string)$value1['name']."\"></td>\n";
    echo "<td align=center><input type=\"color\" size=8 name=\"new_".$x."_fg\" value=\"".(string)$value1['fg']."\"></td>\n";
    echo "<td align=center><input type=\"color\" size=8 name=\"new_".$x."_bg\" value=\"".(string)$value1['bg']."\"></td>\n";
    echo "<td><input type=\"file\" name=\"new_".$x."_image\"/></td>\n";
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

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
        $query = "UPDATE help_subsections SET help_section_fk=".$value1['contents'].", name='".$value1['rubrik']."', sequence_no=".$value1['reihe']." WHERE pk=".$key1;
        $mysqli->query($query);

        $log->InsertItem("edit_help_subcath.php -- ".$query);
        $log->WriteLog;
    }
}
?>
<form name="edit_help_subcath" method="POST" action="index.php?action=EditHelpSubCath">
<table>
<tr>
<td>L&ouml;schen</td><td>Teil</td><td>&nbsp;</td><td>Name</td>
</tr>
<?PHP
// Ausgabe der Ergebnisse in HTML
foreach ($dataTblHelpSubsections as $key1 => $value1) {
    if (is_numeric($key1)){
        echo "\t<tr>\n";
        echo "<td><a href=\"delete_help_subcath.php?pk=".$value1['pk']."\">löschen</a></td>\n";
        echo "<td><select name=\"in_".(string)$key1."_contents\">\n";
        foreach ($dataTblHelpSections as $key2 => $value2){
            if (is_numeric($key2)){
                if ($key2 == $value1['help_section_fk']){
                    echo "<option value=\"".(string)$key2."\" selected>".$value2['name']."</option>\n";
                }else{
                    echo "<option value=\"".(string)$key2."\">".$value2['name']."</option>\n";
                }
            }
        }
        echo "</select></td>\n";
        echo "<td><input type=\"hidden\" value=\"9999\" name=\"in_".(string)$key1."_reihe\" value=\"".(string)$value1['sequence_no']."\"></td>\n";
        echo "<td><input type=\"text\" name=\"in_".(string)$key1."_rubrik\" value=\"".(string)$value1['name']."\"></td>\n";
        echo "\t</tr>\n";
    }
}
    echo "<tr>\n";
    echo "<td colspan=\"3\" align=\"center\">\n";
    echo "<input type=\"submit\" value=\"editieren\">\n";
    echo "</td>\n";
    echo "</tr>\n";
?>
</table>
</form>

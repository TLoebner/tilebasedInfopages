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
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'new'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
  if((isset($value1['name'])) && ($value1['name'] !="")){
    if (is_numeric($key1)){
      $query = "INSERT INTO help_subsections (help_section_fk,name,sequence_no) VALUES(".$value1['contents'].",'".$value1['name']."',9999)";
      $mysqli->query($query);
      $log->InsertItem("NEW_new_help_subcath.php -- ".$query);
      $log->WriteLog;
    }
  }
}
?>
<form name="new_help_subcath" method="POST" action="index.php?action=NewHelpSubCath">
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
?>

</table>
</form>

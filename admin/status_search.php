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
if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
    $StatusQuery="SELECT * FROM `all_search_status`";
    $StatusRes = $mysqli->query($StatusQuery);
    $StatusArray = array();
    if ($StatusRes->num_rows > 0){
        while ($line = $StatusRes->fetch_array(MYSQLI_ASSOC)) {
            $StatusArray[$line['uid']]['main']['string'] = str_replace("%"," ",$line['string']);
            if ($line['type'] == "help"){
                $StatusArray[$line['uid']]['help'] = $line;
            }elseif($line['type'] == "faq"){
                $StatusArray[$line['uid']]['faq'] = $line;
            }else{
                $StatusArray[$line['uid']]['error'] = $line;
            }
        }
        echo "<table border=1>\n";
        echo "<tr>\n";
        echo "<td>UUID</td><td>Suchbegriff</td><td>Jahr</td><td>Monat</td><td>Hilfe</td><td>FAQ</td><td>Fehlerhafte</td><td>Klicks</td>";
        echo "</tr>\n";
        foreach($StatusArray as $key1 => $value1){
            echo "<tr><td><font size=\"0.6rem\">".$key1."</font></td><td>".$value1['main']['string']."</td><td align=\"center\"><font size=\"0.8rem\">".$value1['help']['year']."</font></td><td align=\"center\"><font size=\"0.8rem\">".$value1['help']['month']."</font></td><td align=\"center\">".$value1['help']['num_res']."</td><td align=\"center\">".$value1['faq']['num_res']."</td><td align=\"center\"><font color=\"red\">".$value1['error']['num_res']."</font></td><td align=\"center\">".$value1['help']['num_klicks']."</td></tr>";
        }
        echo "</table>\n";
    }
}
?>

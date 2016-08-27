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
require 'admin_header.php';
?>
<table>
<tr valign="top">
<td>
<?PHP
require 'admin_menu.php';
?>
</td>
<td valign="top">
<?PHP
//CONTENT
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
        echo "<td>UUID</td><td>Suchbegriff</td><td>Jahr</td><td>Monat</td><td>Ergebnisse Hilfe</td><td>Ergebnisse FAQ</td><td>Fehlerhafte Einträge</td><td>Anzahk klicks</td>";
        echo "</tr>\n";
        foreach($StatusArray as $key1 => $value1){
            //echo "(1)".$key1." :: ".$value1."<br/>\n";
            echo "<tr><td>".$key1."</td><td>".$value1['main']['string']."</td><td align=\"center\">".$value1['help']['year']."</td><td align=\"center\">".$value1['help']['month']."</td><td align=\"center\">".$value1['help']['num_res']."</td><td align=\"center\">".$value1['faq']['num_res']."</td><td align=\"center\">".$value1['error']['num_res']."</td><td align=\"center\">".$value1['help']['num_klicks']."</td></tr>";
            //foreach($value1 as $key2 => $value2){
                //echo "(2)".$key2." :: ".$value2."<br/>\n";
                //foreach($value2 as $key3 => $value3){
                    //echo "(3)".$key3." :: ".$value3."<br/>\n";
                    //foreach($value3 as $key4 => $value4){
                    //    echo "(4)".$key4." :: ".$value4."<br/>\n";
                    //}
                //}
            //}
        }
        echo "</table>\n";
    }
}
?>
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

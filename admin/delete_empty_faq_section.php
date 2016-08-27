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

if ($_SESSION['rights'] == "admin"){
    if (isset($_GET['pk']) && is_numeric($_GET['pk'])){
        $pk=$_GET['pk'];
        $query="SELECT * FROM `faq_sections` WHERE pk=".$pk;
        $resDeleteable = $mysqli->query($query);
        if ($resDeleteable->num_rows > 0){
            $ThisDeletable = $resDeleteable->fetch_array(MYSQLI_ASSOC);
?>
<table>
<?PHP
            echo "<tr><td align=left>Name:</td><td>".$ThisDeletable['name']."</td></tr>\n";
            echo "<tr><td align=left>Vordergrund:</td><td>".$ThisDeletable['fg']."</td></tr>\n";
            echo "<tr><td align=left>Hintergrund:</td><td>".$ThisDeletable['bg']."</td></tr>\n";
            echo "<tr><td colspan=\"2\" align=center><a href=\"index.php?action=DeleteFaqCath&pk=".$pk."\">Rubrik löschen</a></td></tr>\n";
        }
    }
}
?>
</table>

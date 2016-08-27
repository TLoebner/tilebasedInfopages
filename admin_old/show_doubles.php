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
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
if (isset($_GET['pk']) && is_numeric($_GET['pk'])){
    $query = "SELECT `name`,`link`,`description`,SUM(`name_count`) AS `name_count` ,SUM(`link_count`) AS `link_count` FROM `show_doubbles` WHERE pk=".$_GET['pk'].";";
}else{
    $query = "SELECT `name`,`link`,`description`,SUM(`name_count`) AS `name_count` ,SUM(`link_count`) AS `link_count` FROM `show_doubbles` GROUP BY `name` ORDER BY `name`;";
}
$ResDoubbles = $mysqli->query($query);
$NumRowsDoubbles = 0;
$NumRowsDoubbles = $ResDoubbles->num_rows;
$i=1;
    echo "<table border=\"1\"><tr><td>Ergebnis</td><td>Eintrag</td></tr>";
    while ($ThisResDouble = $ResDoubbles->fetch_array(MYSQLI_ASSOC)){
        $query="SELECT * FROM help_contents WHERE name='".$ThisResDouble['name']."' OR link='".$ThisResDouble['link']."';";
        $ResThisContentDouble = $mysqli->query($query);
        $NumRowsThisDoubbles = 0;
        $NumRowsThisDoubbles = $ResThisContentDouble->num_rows;
        echo "<tr><td>".(string)$i."</td><td><table border=\"1\">";
        while ($ThisResDoubleEntry = $ResThisContentDouble->fetch_array(MYSQLI_ASSOC)){
            echo "<tr><td><a href=\"edit_help.php?pk=".$ThisResDoubleEntry['pk']."\">Ändern</a></td><td>".$ThisResDoubleEntry['name']."</td><td>".$ThisResDoubleEntry['link']."</td><td>".$ThisResDoubleEntry['description']."</td></tr>";
        }
        echo "</table></td></tr>";
        $i++;
    }
    echo "</table>";
?>

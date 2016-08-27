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

 $pk=$_GET['id'];
 
$query = "SELECT * FROM commonIncidents WHERE pk=".$pk.";";
    $res_incidents = $mysqli->query($query);
    if ($res_incidents->num_rows>0) $incident = $res_incidents->fetch_array(MYSQLI_ASSOC);
?>
<table>
    <tr><td><?PHP echo $incident['description'];?></td></tr>
    <tr><td><a class="alert button" href="index.php?action=DeleteFeedback&id=<?PHP echo $incident['pk'];?>">Löschen</a></td></tr>
</table>

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

    $timestamp = time();
    $datestring = date("d.m.Y - H:i", $timestamp);
    $query = "UPDATE commonIncidents set status='done', coments='closed on ".$datestring."' WHERE pk=".$pk.";";
    $res_incidents = $mysqli->query($query);
    $log->InsertItem("delete_common_feedback.php -- ".$query);
    $log->WriteLog;
    echo "Eintrag gelöscht";
?>

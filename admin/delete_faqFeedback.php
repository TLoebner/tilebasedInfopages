<?PHP
/**
 *  Copyright [2017] [Torsten Loebner <loebnert@gmail.com>]
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


  $pk1=$_GET['id1'];
  $pk2=$_GET['id2'];

    $timestamp = time();
    $datestring = date("d.m.Y - H:i", $timestamp);
    $query = "UPDATE faq_incidents set status='done', comments='closed on ".$datestring."' WHERE incident_fk=".$pk1." AND faq_content_fk=".$pk2.";";
    $res_incidents = $mysqli->query($query);
    $log->InsertItem("delete_faqFeedback.php -- ".$query);
    $log->WriteLog;
    echo "Eintrag gelöscht";
?>

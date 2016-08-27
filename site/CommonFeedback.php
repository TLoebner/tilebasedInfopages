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
if (isset($_POST['comment']) && $_POST['comment'] != ""){
    foreach ($_POST as $key => $value){
        echo $key." :: ".$value."\n";
    }
    $mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
    $query = "INSERT INTO commonIncidents (description,status) VALUES('".(string)$_POST['comment']."','new');";
    $mysqli->query($query);
    header("Location: ./index.php");
    exit;
}
?>

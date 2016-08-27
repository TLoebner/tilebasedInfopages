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
$log = new LogFileHandler();
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
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
        $log->InsertItem("edit_config.php -- ".$query);
        $log->WriteLog;
    }
}
$mysqli->close();
require 'admin_header.php';
?>

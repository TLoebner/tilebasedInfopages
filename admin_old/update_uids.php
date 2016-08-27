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

if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
    $HelpMultiQuery="SELECT * FROM `help_multicontents`;";
    $FaqMultiQuery="SELECT * FROM `faq_multicontents`;";
    
    $HelpMultiRes = $mysqli->query($HelpMultiQuery);
    $FaqMultiRes = $mysqli->query($FaqMultiQuery);
    
    if ($HelpMultiRes->num_rows > 0){
        while ($line = $HelpMultiRes->fetch_array(MYSQLI_ASSOC)) {
            $UpdateQuery = "UPDATE `help_multicontents` SET uid='".(string)uniqid('',true)."' WHERE help_subsection_fk=".(string)$line['help_subsection_fk']." AND help_content_fk=".(string)$line['help_content_fk'].";";
            $mysqli->query($UpdateQuery);
        }
    }
    
    if ($FaqMultiRes->num_rows > 0){
        while ($line = $FaqMultiRes->fetch_array(MYSQLI_ASSOC)) {
            $UpdateQuery = "UPDATE `faq_multicontents` SET uid='".(string)uniqid('',true)."' WHERE faq_section_fk=".(string)$line['faq_section_fk']." AND faq_content_fk=".(string)$line['faq_content_fk'].";";
            $mysqli->query($UpdateQuery);
        }
    }
}
header('Location: index.php');
?>




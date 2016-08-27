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
    if(isset($_GET['link']) && !empty($_GET['link'])){
        $link = $_GET['link'];
        $link = str_replace(";","",$link);
        $link = str_replace("'","",$link);
        $link = str_replace("%","",$link);
        $link = str_replace("*","",$link);

        $mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
        $linkQuery = "SELECT subsection_pk,content_pk,link,content_uid FROM all_help_contents WHERE content_uid='".$link."' ;";

        $linkRes = $mysqli->query($linkQuery);
        if ($linkRes->num_rows > 0){
            $linkArr = $linkRes->fetch_array(MYSQLI_ASSOC);

            $statusQuery="SELECT * FROM `status_help` WHERE month=".date('n')." AND year=".date('Y')." AND help_subsection_fk=".$linkArr['subsection_pk']." AND help_content_fk=".$linkArr['content_pk'].";";
            $statusRes = $mysqli->query($statusQuery);
            if ($statusRes->num_rows > 0){
                $satusArr=$statusRes->fetch_array(MYSQLI_ASSOC);
                $cnt = (int) $satusArr['count'];
                $cnt++;
                $statusQuery="UPDATE `status_help` SET count=".(string)$cnt." WHERE month=".date('n')." AND year=".date('Y')." AND help_subsection_fk=".$linkArr['subsection_pk']." AND help_content_fk=".$linkArr['content_pk'].";";
            }else{
                $statusQuery="INSERT INTO `status_help` (month,year,help_subsection_fk, help_content_fk,count) VALUES(".date('n').",".date('Y').",'".$linkArr['subsection_pk']."','".$linkArr['content_pk']."',1);";
            }
            $mysqli->query($statusQuery);
            header('Location: '.$linkArr['link'].'');
            exit();
        }else{
            header('Location: index.php');
            exit();
        }
    }else{
        header('Location: index.php');
        exit();
    }
?>

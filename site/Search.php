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

$uid='AAA';
$i=0;
$searchString="Suchbegriff";
//     $query = "SELECT * FROM `help_sections` ORDER BY sequence_no ASC;";
//     $res_sub_sec_help = $mysqli->query($query);
//     if ($res_sub_sec_help->num_rows > 0){
//         while ($line2 = $res_sub_sec_help->fetch_array(MYSQLI_ASSOC)){
//             $data[$i] = $line2;
//             $i++;
//         }
//     }
    $query = "SELECT * FROM index_pics WHERE sequence_no=0;";
    $tile_result = $mysqli->query($query);

    $images[0] = $tile_result->fetch_array(MYSQLI_ASSOC);
    
    // search
    if(isset($_GET['search']) && !empty($_GET['search'])){
        $search = $_GET['search'];
        $search = str_replace(";","",$search);
        $search = str_replace("'","",$search);
        $search = str_replace("%","",$search);
        $search = str_replace("*","",$search);
        $search = mysqli_real_escape_string($mysqli,$search);
        $search = str_replace(" ","%",$search);
        

        $SearchQuery1 = "SELECT * FROM all_help_contents WHERE help_name LIKE '%".$search."%' OR link LIKE '%".$search."%' OR description LIKE '%".$search."%' OR meta_description LIKE '%".$search."%' OR section_name LIKE '%".$search."%' OR subsection_name LIKE '%".$search."%'";
        
        $SearchQuery2 = "SELECT * FROM all_faq_contents WHERE section_name LIKE '%".$search."%' OR  question LIKE '%".$search."%' OR  answer LIKE '%".$search."%' OR  link LIKE '%".$search."%'";
        
        $OldSearchQuery = "SELECT * FROM searches WHERE string='".strtolower($search)."';";
        
        $HelpSearchRes = $mysqli->query($SearchQuery1);
        $FaqSearchRes = $mysqli->query($SearchQuery2);
        $OldSearchRes = $mysqli->query($OldSearchQuery);
        
        $data=array();
        $data['help']=array();
        $data['faq']=array();
        $timestamp = date('Y-m-d G:i:s');
        
        if ($OldSearchRes->num_rows>0){
            $ThisSearch = $OldSearchRes->fetch_array(MYSQLI_ASSOC);
            $uid = $ThisSearch['uid'];
            $search_pk=$ThisSearch['pk'];
            
            // reset old search search_results
            $ResetQuery="DELETE FROM `search_results` WHERE searches_fk=".$search_pk.";";
            $mysqli->query($ResetQuery);
            
            if ($HelpSearchRes->num_rows > 0){
                while ($line = $HelpSearchRes->fetch_array(MYSQLI_ASSOC)) {
                    $query = "INSERT INTO search_results (searches_fk,help_subsection_fk,help_content_fk) VALUES('".$search_pk."','".$line['subsection_pk']."','".$line['content_pk']."');";
                    $mysqli->query($query);
                }
            }
            
            if ($FaqSearchRes->num_rows > 0){
                while ($line = $FaqSearchRes->fetch_array(MYSQLI_ASSOC)) {
                    $query = "INSERT INTO search_results (searches_fk,faq_section_fk,faq_content_fk) VALUES('".$search_pk."','".$line['section_pk']."','".$line['content_pk']."');";
                    $mysqli->query($query);
                }
            }
            
            $query="UPDATE searches SET creation='".$timestamp."' WHERE pk=".$search_pk.";";
            $mysqli->query($query);
            
        }else{
            
            $uid = uniqid('',true);
            
            // check string here !!! 
            
            $query="INSERT INTO searches (uid,string,creation) VALUES ('".$uid."','".strtolower(mysqli_real_escape_string($mysqli,$search))."','".$timestamp."');";
            $mysqli->query($query);
            
            $query="SELECT * FROM searches WHERE uid='".$uid."';";
            $res=$mysqli->query($query);
            $line = $res->fetch_array(MYSQLI_ASSOC);
            
            $search_pk=$line['pk'];
            
            if ($HelpSearchRes->num_rows > 0){
                while ($line = $HelpSearchRes->fetch_array(MYSQLI_ASSOC)) {
                    $query = "INSERT INTO search_results (searches_fk,help_subsection_fk,help_content_fk) VALUES('".$search_pk."','".$line['subsection_pk']."','".$line['content_pk']."');";
                    $mysqli->query($query);
                }
            }
            
            if ($FaqSearchRes->num_rows > 0){
                while ($line = $FaqSearchRes->fetch_array(MYSQLI_ASSOC)) {
                    $query = "INSERT INTO search_results (searches_fk,faq_section_fk,faq_content_fk) VALUES('".$search_pk."','".$line['section_pk']."','".$line['content_pk']."');";
                    $mysqli->query($query);
                }
            }
        }
    }
    
    // STATUS
    $statusQuery="SELECT * FROM `status_search` WHERE month=".date('n')." AND year=".date('Y')." AND searches_fk=".$search_pk.";";
    $statusRes = $mysqli->query($statusQuery);
    if ($statusRes->num_rows > 0){
        $satusArr=$statusRes->fetch_array(MYSQLI_ASSOC);
        $cnt = (int) $satusArr['count'];
        $cnt++;
        $statusQuery="UPDATE `status_search` SET count=".(string)$cnt." WHERE month=".date('n')." AND year=".date('Y')." AND searches_fk=".$search_pk.";";
    }else{
        $statusQuery="INSERT INTO `status_search` (month,year,searches_fk, count) VALUES(".date('n').",".date('Y').",'".$search_pk."',1);";
    }
    $mysqli->query($statusQuery);
    
     $query = "SELECT section_pk,type,name,bg,fg,image,string FROM `search_sections` WHERE uid='".$uid."'";
     $searchRes = $mysqli->query($query);
     if ($searchRes->num_rows > 0){
        while ($line = $searchRes->fetch_array(MYSQLI_ASSOC)) {
            $SearchArray[$line['type']][$line['section_pk']]['name'] = $line['name'];
            $SearchArray[$line['type']][$line['section_pk']]['bg'] = $line['bg'];
            $SearchArray[$line['type']][$line['section_pk']]['fg'] = $line['fg'];
            $SearchArray[$line['type']][$line['section_pk']]['image'] = $line['image'];
            $searchString=$line['string'];
        }
     }
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.6">
    <title>KirchenPavillon Bonn</title>
    <link rel="stylesheet" href="assets/css/app.css">
  </head>
  <body>
    <div class="row">
        <div class="small-4 medium-8 large-12 columns">
        &nbsp;
        </div>
    </div>
    <div class="row">
      <form name="search" method="GET" action="Search.php">
            <div class="small-12 medium-8 large-8 columns">
                <img src="data:<?PHP echo $images[0]['type']?>;base64,<?PHP echo base64_encode($images[0]['image']) ?>"/>
            </div>
            <div class="small-12 medium-4 large-4 columns">
                <p>
                <div class="row collapse prefix-round postfix-round">
                    <div class="small-9 columns">
                        <input type="text" name="search" class="prefix round" placeholder="<?PHP echo $searchString;?>">
                    </div>
                    <div class="small-3 columns">
                        <input type="submit" class="radius button postfix" value="suchen">
                    </div>
                    </form>
                </div>
                <p>
            </div>
    </div>


    <?PHP
    $query = "SELECT * FROM `configs` WHERE name='feedbackItem';";
    $res = $mysqli->query($query);
    $image = $res->fetch_array(MYSQLI_ASSOC);
    $feedbackItem = "<img style=\"max-height: 10px;\" src=\"data:".base64_encode($image['type_image_mime']).";base64,".base64_encode($image['type_image_data'])."\" />";
    ?>
    <div class="row">
      <div class="small-8 medium-8 large-8 columns">
        <p><a href="index.php">Startseite</a></p>
      </div>
      <div class="small-4 medium-4 large-4 columns">
        <a data-open="CommonFeedbackInsert"><?PHP echo $feedbackItem;?></a>
      </div>
    </div>

    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p>&nbsp;</p>
      </div>
    </div>

    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p>&nbsp;</p>
      </div>
    </div>
    <?PHP if ($pagintion){?>
     <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <div class="pagination-centered"  align="center">
        <ul class="pagination">
            <?PHP if ($start=0) {?><li class="arrow unavailable"><a href="#">&laquo;</a></li><?PHP }else{?><li class="arrow"><a href="HelpSections.php?start=<?PHP echo $start-6;?>">&laquo;</a></li><?PHP }?>
            <li class="current"><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li class="unavailable"><a href="">&hellip;</a></li>
            <li><a href="">12</a></li>
            <li><a href="">13</a></li>
            <?PHP if ($last - $start < 7) {?><li class="arrow unavailable"><a href="#">&raquo;</a></li><?PHP }else{?><li class="arrow"><a href="HelpSections.php?start=<?PHP echo $start+6;?>">&raquo;</a></li><?PHP }?>
        </ul>
        </div>
      </div>
    <?PHP } ?>

    <div class="row">

<?PHP
     foreach ($SearchArray['help'] as $key1 => $value1){
        //foreach ($value1 as $key2 => $value2){
            // HELP TILE
            $j=1;
            //for ($i=$start;$i<=$end;$i++){
        ?>
        <div class="small-3 medium-4 large-4 columns">
            <a href="HelpSubSections.php?id=<?PHP echo $key1;?>&uid=<?PHP echo $uid;?>">
            <div class="panel">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:<?PHP echo $value1['bg'];?>;color:<?PHP echo $value1['fg'];?>;padding:5px;height:5rem;"><div style="width:100%;" align="center"><font size="5 rem" color=<?PHP echo $value1['fg'];?>><?PHP echo $value1['name'];?></td>
                    </tr>
                    <tr>
                        <td align="center"  style="background-color:white;"><?PHP echo "<img style=\"max-width: 100%;height: 15rem;\" src=\"data:image/png;base64,".base64_encode($value1['image'])."\" />";?></td>
                    </tr>
                </table>
            </div>
            </a>
        </div>
        <?PHP
            if ($j%3==0){
        ?>
            </div>
            <div class="row">
        <?PHP
            }
            $j++;
        //}
        //}
    }
    
    foreach ($SearchArray['faq'] as $key1 => $value1){
        //foreach ($value1 as $key2 => $value2){
            // FAQ TILE
                       $j=1;
           // for ($i=$start;$i<=$end;$i++){
        ?>
        <div class="small-3 medium-4 large-4 columns">
            <a href="FaqContent.php?id=<?PHP echo $key1;?>&uid=<?PHP echo $uid;?>">
            <div class="panel">
                <table width="100%" style="background-color:<?PHP echo $value1['bg'];?>;-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:<?PHP echo $value1['bg'];?>;color:<?PHP echo $value1['fg'];?>;padding:3px;height:5rem;"><div style="width:100%;" align="center"><font size="5 rem" color=<?PHP echo $value1['fg'];?>><?PHP echo $value1['name'];?></td>
                    </tr>
                    <tr>
                        <td style="background-color:white;" align="center" ><?PHP echo "<img style=\"max-width: 100%;height: 15rem;\" src=\"data:image/png;base64,".base64_encode($value1['image'])."\" />";?></td>
                    </tr>
                </table>
            </div>
            </a>
        </div>
        <?PHP
            if ($j%3==0){
        ?>
            </div>
            <div class="row">
        <?PHP
            }
            $j++;
        //}
        //}
    }

?>
   <div class="reveal" id="CommonFeedbackInsert" data-reveal>
        <div class="panel">
            <form name="Feedback" method="POST" action="CommonFeedback.php">
            <label>Ihr Feedback
                <textarea name="comment" cols="30" rows="5" placeholder="Bitte tragen Sie Ihr Feedback zum Eintrag hier ein"></textarea>
            </label>
            <input type="hidden" name="id" value="<?PHP echo $data[$i]['content_pk'];?>"><br/>
            <input type="hidden" name="start" value="<?PHP echo $start;?>"><br/>
            <input type="hidden" name="sec" value="<?PHP echo $data[$i]['section_pk'];?>"><br/>
            <input type="hidden" name="subsec" value="<?PHP echo $data[$i]['subsection_pk'];?>"><br/>
            <input type="submit" class="button" value="absenden"><br/>
            </form>
        </div>
        </div>
        <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                <p>&nbsp;</p>
            </div>
            </div>
            <div class="row">
                <div class="small-12 medium-12 large-12 columns" align="center">
                                <a href="https://github.com/TLoebner/tilebasedInfopages"> Created by TLoebner</a> licensed by <a href="https://github.com/TLoebner/tilebasedInfopages/blob/master/LICENSE">  Apache License Version 2.0, January 2004</a><br>
                    <a href="Impressum.php">Impressum</a><br/>
                    Images by <a class="impressum" href="http://www.flaticon.com/">www.flaticon.com/</a> - Grafik-Lizenzen : <a class="impressum" href="http://creativecommons.org/licenses/by/3.0/" >CC BY 3.0</a>
                    <p>&nbsp;</p>
                    <a href="../admin/">Administration</a>
                </div>
        </div>

    <script src="assets/js/app.js"></script>
  </body>
</html>

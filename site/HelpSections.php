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
require 'config.php';
$i=0;
    $query = "SELECT * FROM `help_sections` ORDER BY ".$config_HelpCathOrderBy.";";
    $res_sub_sec_help = $mysqli->query($query);
    if ($res_sub_sec_help->num_rows > 0){
        while ($line2 = $res_sub_sec_help->fetch_array(MYSQLI_ASSOC)){
            $data[$i] = $line2;
            $i++;
        }
    }
    $query = "SELECT * FROM index_pics WHERE sequence_no=0;";
    $tile_result = $mysqli->query($query);

    $images[0] = $tile_result->fetch_array(MYSQLI_ASSOC);
$start=0;
$pagination=false;
$end=count($data)-1;
if ($end > 5) $end=5;
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
            $j=1;
            for ($i=$start;$i<=$end;$i++){
        ?>
        <div class="small-3 medium-4 large-4 columns">
            <a href="HelpSubSections.php?id=<?PHP echo $data[$i]['pk'];?>">
            <div class="panel">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:<?PHP echo $data[$i]['bg'];?>;color:<?PHP echo $data[$i]['fg'];?>;padding:5px;height:5rem"><div style="width:100%;" align="center"><font size="5 rem" color=<?PHP echo $data[$i]['fg'];?>><?PHP echo $data[$i]['name'];?></td>
                    </tr>
                    <tr>
                        <td style="background-color:white;" align="center" ><?PHP echo "<img style=\"max-width: 100%;height:15rem;\"  src=\"data:image/png;base64,".base64_encode($data[$i]['image'])."\" />";?></td>
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
        }
        ?>
    </div>
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

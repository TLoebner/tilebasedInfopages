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

//require header.php;

/**
 *
 *  Get content from mysql database and create html results
 *
**/
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
require 'config.php';
$query = "SELECT * FROM index_pics WHERE sequence_no<7;";
$tile_result = $mysqli->query($query);
while ($line = $tile_result->fetch_array(MYSQLI_ASSOC)) {
    if ($line['name'] != ""){
        $content[$line['sequence_no']]  = "<a href=\"".$line['link']."\"><div style=\"max-width:90%;max-height:90%;overflow:hidden;\">\n";
        $content[$line['sequence_no']] .= "<font size=\"1.1 rem\"><b>".$line['name']."</b></font><br/>\n";
        $content[$line['sequence_no']] .= "<img class=\"tile_image\" src=\"data:".$line['image_type'].";base64,".base64_encode($line['image'])."\" style=\"width:auto;max-width: 20%;height: auto;max-height:20%;\"/><br/>\n";
        $content[$line['sequence_no']] .= "<font size=\"0.5 rem\">".$line['description']."</font>\n";
        $content[$line['sequence_no']] .= "</div></a>\n";
    }else{
        $content[$line['sequence_no']] = "&nbsp;";
    }
    $images[$line['sequence_no']]['data'] = $line['image'];
    $images[$line['sequence_no']]['type'] = $line['image_type'];
    $images[$line['sequence_no']]['link'] = $line['link'];
    $images[$line['sequence_no']]['name'] = $line['name'];
    $images[$line['sequence_no']]['description'] = $line['description'];
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP echo $configArr_PageTitle['content'];?></title>
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
            <div class="small-4 medium-4 large-8 columns">
                <img src="data:<?PHP echo $images[0]['type']?>;base64,<?PHP echo base64_encode($images[0]['data']) ?>"/>
            </div>
            <div class="small-4 medium-4 large-4 columns">
                <p>
                <div class="row collapse prefix-round postfix-round">
                    <div class="small-1 medium-1 large-9 columns">
                        <input type="text" name="search" class="prefix round" placeholder="Suchbegriff">
                    </div>
                    <div class="small-1 medium-1 large-3 columns">
                        <input type="submit" class="radius button postfix" value="suchen">
                    </div>
                    </form>
                </div>
                <p>
            </div>
        </form>
    </div>

    <?PHP
    $query = "SELECT * FROM `configs` WHERE name='feedbackItem';";
    $res = $mysqli->query($query);
    $image = $res->fetch_array(MYSQLI_ASSOC);
    $feedbackItem = "<img style=\"max-height: ".$configArr_FeedbackHeight['content'].";\" src=\"data:".base64_encode($image['type_image_mime']).";base64,".base64_encode($image['type_image_data'])."\" />";
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
        <?PHP if ($images[1]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[1]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[1]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[1]['type'].";base64,".base64_encode($images[1]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[1]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
        <?PHP } if ($images[2]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[2]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[2]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[2]['type'].";base64,".base64_encode($images[2]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[2]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
        <?PHP } if ($images[3]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[3]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[3]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[3]['type'].";base64,".base64_encode($images[3]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[3]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
        <?PHP } if ($images[4]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[4]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[4]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[4]['type'].";base64,".base64_encode($images[4]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[4]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
        <?PHP } if ($images[5]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[5]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[5]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[5]['type'].";base64,".base64_encode($images[5]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[5]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
        <?PHP } if ($images[6]['name'] != ""){?>
        <div class="small-3 medium-4 large-4 columns">
            <div class="panel">
                <a href="<?PHP echo $images[6]['link']?>">
                <table width="100%" style="-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.41);">
                    <tr>
                        <td style="background-color:white;color:blue;padding:5px;"><div style="width:100%;" align="center"><font size="4 rem" color=black><?PHP echo $images[6]['name']?></font></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="center"><?PHP echo "<img style=\"max-width: 100%;\" src=\"data:".$images[6]['type'].";base64,".base64_encode($images[6]['data'])."\"/>";?></div></td>
                    </tr>
                    <tr>
                        <td  style="background-color:white;color:black;padding:5px;"><div align="left"><font size="1 rem" color=black><?PHP echo $images[6]['description']?></font></td>
                    </tr>
                </table>
                </a>
            </div>
        </div>
    </div>
    <?PHP }?>

<div class="reveal" id="CommonFeedbackInsert" data-reveal>
        <div class="panel">
            <form name="Feedback" method="POST" action="CommonFeedback.php">
            <label>Ihr Feedback
                <textarea name="comment" cols="30" rows="5" placeholder="Bitte tragen Sie Ihr Feedback zum Eintrag hier ein"></textarea>
            </label>
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

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

ini_set('display_errors', '1');
//require 'HTML/BBCodeParser2.php';

/**
 *
 *  Get content from mysql database and create html results
 *
**/
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
require './config.php';
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
$Impressum=$config_impressum;

/**
*
*   Use HTML_BBCodeParser2 here
*
**/
/* get options from the ini file */
//$config = parse_ini_file('BBCodeParser2.ini', true);
//$options = $config['HTML_BBCodeParser2'];
/* do yer stuff! */
//$parser = new HTML_BBCodeParser2($options);
//$parser->setText($Impressum);
//$parser->parse();
//$parsed = $parser->getParsed();
//$Impressum=$parsed;
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP echo $configArr_PageTitle['content'];?></title>
    <link rel="stylesheet" href="assets/css/app.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="minified/themes/default.min.css" type="text/css" media="all" charset="UTF-8" />
    <script type="text/javascript" src="minified/jquery.sceditor.bbcode.min.js" charset="UTF-8"></script>
<script language='javascript'>

  function move_up() {
    scroll_clipper.scrollTop = 0;
  }

</script>
  </head>
  <body>



    <div class="row">
      <form name="search" method="GET" action="Search.php">
            <div class="small-12 medium-8 large-8 columns">
                <img src="data:<?PHP echo $images[0]['type']?>;base64,<?PHP echo base64_encode($images[0]['data']) ?>"/>
            </div>
            <div class="small-12 medium-4 large-4 columns">
                <p>
                <div class="row collapse prefix-round postfix-round">
                    <div class="small-9 columns">
                        <input type="text" name="search" class="prefix round" placeholder="Suchbegriff">
                    </div>
                    <div class="small-3 columns">
                        <input type="submit" class="radius button postfix" value="suchen">
                    </div>
                    </form>
                </div>
                <p>
            </div>
    </div>


    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p><a href="index.php">Startseite</a></p>
      </div>
    </div>

    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p>&nbsp;</p>
      </div>
    </div>


    <div class="row">
        <div class="panel">
            <!-- T#60 <textarea rows="80" cols="200" style="border:0px solid black;"  disabled> -->
                <?PHP echo $Impressum;?>
            <!-- T#60 </textarea>-->
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

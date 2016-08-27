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

?>
<html>
<head>
<style>
.wrap {
    width: 960px;
    height: 540px;
    padding: 0;
    overflow: hidden;
    border:1px solid black;
}
.frame {
    width: 1920px;
    height: 1080px;
    border: 0;
    -ms-transform: scale(0.5);
    -moz-transform: scale(0.5);
    -o-transform: scale(0.5);
    -webkit-transform: scale(0.5);
    transform: scale(0.5);

    -ms-transform-origin: 0 0;
    -moz-transform-origin: 0 0;
    -o-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
}
@page {
  size: A4;
}
@page :left {
  margin-left: 1cm;
}

@page :right {
  margin-left: 1cm;
}
h1 {
  page-break-before: always;
}
h1, h2, h3, h4, h5 {
  page-break-after: avoid;
}
</style>
</head>
<body>
<?PHP

$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");


require 'admin_header.php';
require 'config.php';

$query = "SELECT * FROM Readme;";
$ReadmeRes=$mysqli->query($query);
while ($Readme = $ReadmeRes->fetch_array(MYSQLI_ASSOC)){
?>
<a name="<?PHP echo $Readme['part']; ?>_<?PHP echo $Readme['sequence_no']; ?>"><h2><?PHP echo $Readme['name']; ?></h2></a>
<table>
<tr>
<td>
<div class="wrap">
    <iframe class="frame" src="../<?PHP echo $Readme['file_link']; ?>?demo=readme" sandbox="allow-scripts" scrolling="no"></iframe>
</div>
</td>
<td>
<?PHP echo $Readme['text']; ?>
</td>
</tr>
</table>
<p>&nbsp;</p>
<?PHP
}
?>
</body>
</html>

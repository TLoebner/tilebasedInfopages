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
$query = "SELECT * FROM index_pics WHERE sequence_no<7;";
$tile_result = $mysqli->query($query);
while ($line = $tile_result->fetch_array(MYSQLI_ASSOC)) {
    if ($line['name'] != ""){
        $content[$line['sequence_no']]  = "<div class=\"tile_content\">\n";
        $content[$line['sequence_no']] .= "".$line['name']."<br/>\n";
        $content[$line['sequence_no']] .= "<img class=\"tile_image\" src=\"data:".$line['image_type'].";base64,".base64_encode($line['image'])."\" style=\"max-width: 80%;height: auto;\"/><br/>\n";
        $content[$line['sequence_no']] .= "<h9>".$line['description']."</h9>\n";
        $content[$line['sequence_no']] .= "</div>\n";
    }else{
        $content[$line['sequence_no']] = "&nbsp;";
    }
    $images[$line['sequence_no']]['data'] = $line['image'];
    $images[$line['sequence_no']]['type'] = $line['image_type'];
    $images[$line['sequence_no']]['link'] = $line['link'];
}
?>
<table>
<tr valign="top">
<td>
<div align="center">
        <table align="center" style="border-collapse:separate;border-spacing:30px;">
            <tr>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[1];
                    ?>
                    <a href="index.php?action=EditMainItem&filter=1">ANPASSEN</a>
                </td>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[2];
                    ?>
                    <a href="index.php?action=EditMainItem&filter=2">ANPASSEN</a>
                </td>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[3];
                    ?>
                    <a href="index.php?action=EditMainItem&filter=3">ANPASSEN</a>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[4];
                    ?>
                    <a href="index.php?action=EditMainItem&filter=4">ANPASSEN</a>
                </td>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[5];
                    ?>
                    <a href="index.php?action=EditMainItem&filter=5">ANPASSEN</a>
                </td>
                <td align="center" valign="top" style="width:30%;height:auto;">
                    <?PHP
                        echo $content[6];
                    ?><br/>
                    <a href="index.php?action=EditMainItem&filter=6">ANPASSEN</a>
                </td>
            </tr>
        </table><br/>
        <img src="data:image/<?PHP echo $images[0]['type']?>;base64,<?PHP echo base64_encode($images[0]['data']) ?>" style="max-width:80%;height:auto;"/><br/>
        <a href="index.php?action=EditMainItem&filter=0">ANPASSEN</a>
</div>
</td>
</tr>
</table>

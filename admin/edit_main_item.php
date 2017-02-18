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
foreach ($_POST as $key => $value){

}
if(isset($_POST['key']) && isset($_POST['sequence']) && is_numeric($_POST['key']) && is_numeric($_POST['sequence'])){
    if(isset($_FILES['file'])){
        if(is_uploaded_file($_FILES['file']['tmp_name']) && getimagesize($_FILES['file']['tmp_name']) != false){
            /***  get the image info. ***/
            $size = getimagesize($_FILES['file']['tmp_name']);
            /*** assign our variables ***/
            $type = $size['mime'];
            $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
            $size = $size[3];
            $name = $_FILES['file']['name'];

            $query="UPDATE index_pics set image='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['file']['tmp_name']))."' , image_size='".(string)$size."' , image_name='".(string)$name."' , image_type='".(string)$type."' WHERE pk=".(string)$_POST['key'].";";
            $mysqli->query($query);
        }
    }
    $query="UPDATE index_pics set name='".(string)$_POST['title']."' , link='".(string)$_POST['link']."' , description='".(string)$_POST['description']."' WHERE pk=".(string)$_POST['key']." AND sequence_no=".(string)$_POST['sequence'].";";
    $mysqli->query($query);
    $log->InsertItem("edit_main_item.php -- ".$query);
    $log->WriteLog;
    header("Location: ./index.php?action=EditMain");
}



if (is_numeric($_GET['filter'])){
    $query = "SELECT * FROM index_pics WHERE sequence_no=".$_GET['filter'].";";
    $tile_result = $mysqli->query($query);
    while ($line = $tile_result->fetch_array(MYSQLI_ASSOC)) {
        $image['data'] = $line['image'];
        $image['type'] = $line['image_type'];
        $image['link'] = $line['link'];
        $image['name'] = $line['name'];
        $image['description'] = $line['description'];
        $image['link'] = $line['link'];
        $image['key'] = $line['pk'];
        $image['sequence'] = $line['sequence_no'];
    }
}
?>
<form enctype="multipart/form-data" name="edit_main_item" method="POST" action="index.php?action=EditMainItem&filter=<?PHP echo $image['sequence'];?>">
<table>
<tr>
<td>Überschrift:</td>
<td><input type="text" name="title" value="<?PHP echo $image['name'];?>" size="90"></td>
</tr>
<tr>
<td> Bild: </td>
<td><img class="tile_image" src="data:<?PHP echo $image['type'];?>;base64,<?PHP echo base64_encode($image['data']);?>" style="max-width: 30%;height: auto;"/><br/><input name="file" type="file" /></td>
</tr>
<tr>
<td>Beschreibung:</td>
<td><textarea cols="80" rows="10" name="description"><?PHP echo $image['description'];?></textarea></td>
</tr>
<tr>
<td>Link:</td>
<td><input type="text" name="link" value="<?PHP echo $image['link'];?>" size="90"></td>
</tr>
</table>
<input type="hidden" name="key" value="<?PHP echo $image['key'];?>">
<input type="hidden" name="sequence" value="<?PHP echo $image['sequence'];?>">
<input type="submit" value="Ändern">
</form>

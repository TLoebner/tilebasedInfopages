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
$mysqli = new mysqli("localhost", "root", "", "KirchenPavilon");
foreach ($_POST as $key => $value){
//     echo $key." : ".$value."<br/>\n";
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'in'){
        $EditErgarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
    if ($postvarsplit[0] == 'new'){
        $NewErgarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach($EditErgarray as $key1 => $value1){
    if(isset($_FILES['in_'.$key1.'_image'])){
            if(is_uploaded_file($_FILES['in_'.$key1.'_image']['tmp_name']) && getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']) != false){
                /***  get the image info. ***/
                $size = getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']);
                /*** assign our variables ***/
                $type = $size['mime'];
                $imgfp = fopen($_FILES['in_'.$key1.'_image']['tmp_name'], 'rb');
                $size = $size[3];
                $name = $_FILES['in_'.$key1.'_image']['name'];
                
                $query="UPDATE INTO screensaver (sequence_no,due_date,image_type,image,image_size,image_name) image='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['in_'.$key1.'_image']['tmp_name']))."' WHERE pk=".(string)$key1.";";
                $mysqli->query($query);
                $log->InsertItem("edit_screensaver.php -- ".$query);
                $log->WriteLog;
            }
    }else{
        
    }
}
foreach($NewErgarray as $key1 => $value1){
    if(isset($_FILES['in_'.$key1.'_image'])){
            if(is_uploaded_file($_FILES['in_'.$key1.'_image']['tmp_name']) && getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']) != false){
                /***  get the image info. ***/
                $size = getimagesize($_FILES['in_'.$key1.'_image']['tmp_name']);
                /*** assign our variables ***/
                $type = $size['mime'];
                $imgfp = fopen($_FILES['in_'.$key1.'_image']['tmp_name'], 'rb');
                $size = $size[3];
                $name = $_FILES['in_'.$key1.'_image']['name'];
                
                $query="INSERT INTO screensaver (sequence_no,due_date,image_type,image,image_size,image_name) image='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['in_'.$key1.'_image']['tmp_name']))."' WHERE pk=".(string)$key1.";";
                $mysqli->query($query);
                $log->InsertItem("edit_screensaver.php -- ".$query);
                $log->WriteLog;
            }
    }else{
        
    }
}


// FIXME !!!
// foreach ($ergarray as $key1 => $value1){
// //     echo $key1." : ".$value1."<br/>\n"; 
//     if (is_numeric($key1)){
//         $query = "UPDATE faq_inhalte SET fk_rubrik=".$value1['rubrik'].", reihe=".$value1['reihe'].", question='".$value1['question']."', answer='".$value1['answer']."', link='".$value1['link']."' WHERE pk=".$key1;
//         $mysqli->query($query);
//     }
// }


// $mysqli->close();
require 'admin_header.php';
?>
<table>
<tr valign="top">
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_menu.php';
?>
</div>
</td>
<td valign="top">
<div style="width:600 px;height:100%;overflow-y: auto;overflow-x: auto;">
<form name="edit_screensaver" enctype="multipart/form-data" method="POST" action="edit_screensaver.php?pk=<?PHP echo $_GET['pk']?>">
<table>
<tr>
    <td>Name</td>
    <td>Reihenfolge</td>
    <td>Ablaufdatum</td>
    <td>Upload</td>
</tr>
<?PHP
//
//
$sqlQuery = "SELECT * FROM screensaver;";
$resScreensaver = $mysqli->query("SELECT * FROM screensaver;");
if ($resScreensaver->num_rows > 0){
    while ($line = $resScreensaver->fetch_array(MYSQLI_ASSOC)){
        echo "<tr><td>".$line['image_name']."</td><td><input type=\"text\" name=\"in_".(string)$line['pk']."_seqno\" value=\"".$line['sequence_no']."\"></td><td><input  type=\"text\" name=\"in_".(string)$line['pk']."_duedate\" value=\"".$line['due_date']."\"></td><td><input type=\"file\" value=\"Datei hochladen\" name=\"in_".(string)$line['pk']."_image\"/></td></tr>";
    }
}
for($i=1;$i<11;$i++){
    echo "<tr><td>Neuer Eintrag".(string)$i."</td><td><input type=\"text\" name=\"new_".(string)$i."_seqno\" value=\"".$line['sequence_no']."\"></td><td><input  type=\"text\" name=\"new_".(string)$i."_duedate\" value=\"".$line['due_date']."\"></td><td><input type=\"file\" value=\"Datei hochladen\" name=\"new_".(string)$i."_image\"/></td></tr>";
}
//
//
?>
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
<td colspan="4" align="center"><input type="submit" value="absenden"></td>
</tr>
</table>
</form>
</div>
</td>
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_todoList.php';
?>
</div>
</td>
</tr>
</table>
<script>
$(function() {
    // Replace all textarea's
    // with SCEditor
    $("textarea").sceditor({
        plugins: "bbcode",
        toolbar: "bold,italic,underline|source",
	style: "minified/jquery.sceditor.default.min.css"
    });
});
</script>
<?PHP
require 'admin_footer.php'
?>

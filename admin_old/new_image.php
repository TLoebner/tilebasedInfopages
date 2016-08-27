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
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
// foreach ($_POST as $key => $value){
//   //echo $key." : ".$value."<br/>\n";
//   $postvarsplit = preg_split('/_/',$key);
//   if ($postvarsplit[0] == 'new'){
//     $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
//   }
// }
// foreach ($ergarray as $key1 => $value1){
//   if (is_numeric($key1)){
//     if ($value1['inhalt'] != ""){
//         $query = "INSERT INTO rubrikeninhalte (fk_rubrik,reihe,inhalt,link,comment) VALUES(".$value1['rubrik'].",".$value1['reihe'].",'".htmlentities($value1['inhalt'])."','".$value1['link']."','".htmlentities($value1['comment'])."')";
//         $mysqli->query($query);
//     }
//   }
// }
function upload(){
/*** check if a file was uploaded ***/
if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false)
    {
    /***  get the image info. ***/
    $size = getimagesize($_FILES['userfile']['tmp_name']);
    /*** assign our variables ***/
    $type = $size['mime'];
    $imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
    $size = $size[3];
    $name = $_FILES['userfile']['name'];
    $maxsize = 99999999;


    /***  check the file is less than the maximum file size ***/
    if($_FILES['userfile']['size'] < $maxsize )
        {
        /*** connect to db ***/
        $query = "INSERT INTO pictures (sequence_no,due_date,image_type,image,image_size,image_ctgy,image_name) VALUES(".$_POST['seq_no'].",".$_POST['due_date'].",'".$type."',".$imgfp.",'".$size."','".$_POST['cath']."','".$_POST['name']."')";
        $mysqli->query($query);
        }
    else
        {
        /*** throw an exception is image is not of type ***/
        throw new Exception("File Size Error");
        }
    }
else
    {
    // if the file is not less than the maximum allowed, print an error
    throw new Exception("Unsupported Image Format!");
    }
}
/*** check if a file was submitted ***/
if(!isset($_FILES['userfile']))
    {
    echo '<p>Please select a file</p>';
    }
else
    {
    try    {
        upload();
        /*** give praise and thanks to the php gods ***/
        echo '<p>Thank you for submitting</p>';
        }
    catch(Exception $e)
        {
        echo '<h4>'.$e->getMessage().'</h4>';
        }
    }
$mysqli->close();
//require 'admin_header.php';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

  <html>
  <head><title>File Upload To Database</title></head>
  <body>
  <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
  <table>
    <tr>
        <td>
            Reihenfolge:
        </td>
        <td>
            <input type="text" name="seq_no" />
        </td>
    </tr>
    <tr>
        <td>
            gültig bis:
        </td>
        <td>
            <input type="text" name="due_date" />
        </td>
    </tr>
    <tr>
        <td>
            Kategorie:
        </td>
        <td>
            <input type="text" name="cath" />
        </td>
    </tr>
    <tr>
        <td>
            Name:
        </td>
        <td>
            <input type="text" name="name" />
        </td>
    </tr>
    <tr>
        <td>
            Datei:
        </td>
        <td>
            <input name="userfile" type="file" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="OK" />
        </td>
    </tr>
  </form>

</body></html>

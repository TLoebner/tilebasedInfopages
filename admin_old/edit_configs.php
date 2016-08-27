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
    if (isset($_POST['config_impressum_text'])){
        $query = "UPDATE configs SET type_text='".$_POST['config_impressum_text']."' WHERE name='impressum';";
        $mysqli->query($query);
        $log->InsertItem("edit_configs.php -- ".$query);
    }
    if(isset($_FILES['configArr_textItem_file']) && is_uploaded_file($_FILES['configArr_textItem_file']['tmp_name']) && getimagesize($_FILES['configArr_textItem_file']['tmp_name']) != false){
        $size = getimagesize($_FILES['configArr_textItem_file']['tmp_name']);
        $query = "UPDATE configs SET type_image_mime='".(string)$size['mime']."' , type_image_size='".(string)$size[3]."' , type_image_data='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['configArr_textItem_file']['tmp_name']))."' WHERE name='textItem';";
        $mysqli->query($query);
    }
    if(isset($_FILES['configArr_feedbackItem_file']) && is_uploaded_file($_FILES['configArr_feedbackItem_file']['tmp_name']) && getimagesize($_FILES['configArr_feedbackItem_file']['tmp_name']) != false){
        $size = getimagesize($_FILES['configArr_feedbackItem_file']['tmp_name']);
        $query = "UPDATE configs SET type_image_mime='".(string)$size['mime']."' , type_image_size='".(string)$size[3]."' , type_image_data='".mysqli_real_escape_string($mysqli,file_get_contents($_FILES['configArr_feedbackItem_file']['tmp_name']))."' WHERE name='feedbackItem';";
        $mysqli->query($query);
    }
$mysqli->close();
$log->WriteLog;
require 'admin_header.php';
require 'config.php';
?>
<form enctype="multipart/form-data" name="edit_configs" method="POST" action="edit_configs.php">
<h1><u>Icons</u></h1><br>
<table>
<tr>
<td><?PHP echo $configArr_textItem['text'];?></td><td> :: </td><td><?PHP echo "<img style=\"max-height: 30px;\" src=\"data:".base64_encode($configArr_textItem['mime']).";base64,".base64_encode($configArr_textItem['data'])."\" />";?></td><td> :: </td><td><input name="configArr_textItem_file" type="file" /></td>
</tr>
<tr>
<td><?PHP echo $configArr_feedbackItem['text'];?></td><td> :: </td><td><?PHP echo "<img style=\"max-height: 30px;\" src=\"data:".base64_encode($configArr_feedbackItem['mime']).";base64,".base64_encode($configArr_feedbackItem['data'])."\" />";?></td><td> :: </td><td><input name="configArr_feedbackItem_file" type="file" /></td>
</tr>
<tr><td colspan=5>&nbsp;</td></tr>
<tr><td colspan=5><h1><u>Sortierung der Inhalte</u></h1><br></td></tr>
<tr>
<td><?PHP echo $configArr_HelpCathOrderBy['text'];?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
<select name="HelpCathOrderBy">
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "name ASC") echo "selected";?> value="name ASC">alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "name DESC") echo "selected";?> value="name DESC">alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "sequence_no ASC") echo "selected";?> value="sequence_no ASC">Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "sequence_no DESC") echo "selected";?> value="sequence_no DESC">Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count ASC, name ASC") echo "selected";?> value="count ASC, name ASC">meist gesucht aufsteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count ASC, name DESC") echo "selected";?> value="count ASC, name DESC">meist gesucht aufsteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count ASC, sequence_no ASC") echo "selected";?> value="count ASC, sequence_no ASC">meist gesucht aufsteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count ASC, sequence_no DESC") echo "selected";?> value="count ASC, sequence_no DESC">meist gesucht aufsteigend | Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count DESC, name ASC") echo "selected";?> value="count DESC, name ASC">meist gesucht absteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count DESC, name DESC") echo "selected";?> value="count DESC, name DESC">meist gesucht absteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count DESC, sequence_no ASC") echo "selected";?> value="count DESC, sequence_no ASC">meist gesucht absteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpCathOrderBy['content'] == "count DESC, sequence_no DESC") echo "selected";?> value="count DESC, sequence_no DESC">meist gesucht absteigend | Reihenfolge absteigend</option>
</select></td>
</tr>
<tr>
<td><?PHP echo $configArr_HelpSubCathOrderBy['text'];?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
<select name="HelpCathOrderBy">
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "name ASC") echo "selected";?> value="name ASC">alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "name DESC") echo "selected";?> value="name DESC">alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "sequence_no ASC") echo "selected";?> value="sequence_no ASC">Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "sequence_no DESC") echo "selected";?> value="sequence_no DESC">Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count ASC, name ASC") echo "selected";?> value="count ASC, name ASC">meist gesucht aufsteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count ASC, name DESC") echo "selected";?> value="count ASC, name DESC">meist gesucht aufsteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count ASC, sequence_no ASC") echo "selected";?> value="count ASC, sequence_no ASC">meist gesucht aufsteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count ASC, sequence_no DESC") echo "selected";?> value="count ASC, sequence_no DESC">meist gesucht aufsteigend | Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count DESC, name ASC") echo "selected";?> value="count DESC, name ASC">meist gesucht absteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count DESC, name DESC") echo "selected";?> value="count DESC, name DESC">meist gesucht absteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count DESC, sequence_no ASC") echo "selected";?> value="count DESC, sequence_no ASC">meist gesucht absteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpSubCathOrderBy['content'] == "count DESC, sequence_no DESC") echo "selected";?> value="count DESC, sequence_no DESC">meist gesucht absteigend | Reihenfolge absteigend</option>
</select></td>
</tr>
<tr>
<td><?PHP echo $configArr_HelpContentOrderBy['text'];?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
<select name="HelpCathOrderBy">
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "name ASC") echo "selected";?> value="name ASC">alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "name DESC") echo "selected";?> value="name DESC">alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "content_sequence ASC") echo "selected";?> value="content_sequence ASC">Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "content_sequence DESC") echo "selected";?> value="content_sequence DESC">Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count ASC, name ASC") echo "selected";?> value="count ASC, name ASC">meist gesucht aufsteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count ASC, name DESC") echo "selected";?> value="count ASC, name DESC">meist gesucht aufsteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count ASC, content_sequence ASC") echo "selected";?> value="count ASC, content_sequence ASC">meist gesucht aufsteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count ASC, content_sequence DESC") echo "selected";?> value="count ASC, content_sequence DESC">meist gesucht aufsteigend | Reihenfolge absteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count DESC, name ASC") echo "selected";?> value="count DESC, name ASC">meist gesucht absteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count DESC, name DESC") echo "selected";?> value="count DESC, name DESC">meist gesucht absteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count DESC, content_sequence ASC") echo "selected";?> value="count DESC, content_sequence ASC">meist gesucht absteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_HelpContentOrderBy['content'] == "count DESC, content_sequence DESC") echo "selected";?> value="count DESC, content_sequence DESC">meist gesucht absteigend | Reihenfolge absteigend</option>
</select></td>
</tr>
<tr>
<td><?PHP echo $configArr_FaqCathOrderBy['text'];?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
<select name="HelpCathOrderBy">
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "name ASC") echo "selected";?> value="name ASC">alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "name DESC") echo "selected";?> value="name DESC">alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "sequence_no ASC") echo "selected";?> value="sequence_no ASC">Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "sequence_no DESC") echo "selected";?> value="sequence_no DESC">Reihenfolge absteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count ASC, name ASC") echo "selected";?> value="count ASC, name ASC">meist gesucht aufsteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count ASC, name DESC") echo "selected";?> value="count ASC, name DESC">meist gesucht aufsteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count ASC, sequence_no ASC") echo "selected";?> value="count ASC, sequence_no ASC">meist gesucht aufsteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count ASC, sequence_no DESC") echo "selected";?> value="count ASC, sequence_no DESC">meist gesucht aufsteigend | Reihenfolge absteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count DESC, name ASC") echo "selected";?> value="count DESC, name ASC">meist gesucht absteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count DESC, name DESC") echo "selected";?> value="count DESC, name DESC">meist gesucht absteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count DESC, sequence_no ASC") echo "selected";?> value="count DESC, sequence_no ASC">meist gesucht absteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqCathOrderBy['content'] == "count DESC, sequence_no DESC") echo "selected";?> value="count DESC, sequence_no DESC">meist gesucht absteigend | Reihenfolge absteigend</option>
</select></td>
</tr>
<tr>
<td><?PHP echo $configArr_FaqContentOrderBy['text'];?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>
<select name="HelpCathOrderBy">
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "question ASC") echo "selected";?> value="question ASC">alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "question DESC") echo "selected";?> value="question DESC">alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "content_sequence ASC") echo "selected";?> value="content_sequence ASC">Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "content_sequence DESC") echo "selected";?> value="content_sequence DESC">Reihenfolge absteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count ASC, question ASC") echo "selected";?> value="count ASC, question ASC">meist gesucht aufsteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count ASC, question DESC") echo "selected";?> value="count ASC, question DESC">meist gesucht aufsteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count ASC, content_sequence ASC") echo "selected";?> value="count ASC, content_sequence ASC">meist gesucht aufsteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count ASC, content_sequence DESC") echo "selected";?> value="count ASC, content_sequence DESC">meist gesucht aufsteigend | Reihenfolge absteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count DESC, question ASC") echo "selected";?> value="count DESC, question ASC">meist gesucht absteigend | alphabetisch aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count DESC, question DESC") echo "selected";?> value="count DESC, question DESC">meist gesucht absteigend | alphabetisch absteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count DESC, content_sequence ASC") echo "selected";?> value="count DESC, content_sequence ASC">meist gesucht absteigend | Reihenfolge aufsteigend</option>
<option <?PHP if ($configArr_FaqContentOrderBy['content'] == "count DESC, content_sequence DESC") echo "selected";?> value="count DESC, content_sequence DESC">meist gesucht absteigend | Reihenfolge absteigend</option>
</select></td>
</tr>
</table><br/>
<h1><u>Impressum</u></h1><br>
<textarea name="config_impressum_text" cols=160 rows=50><?PHP echo $config_impressum;?></textarea><br/>
<input type="submit" value="absenden">
</form>

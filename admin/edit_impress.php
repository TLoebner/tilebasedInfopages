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
 if (isset($_POST['config_impressum'])){
     $query = "UPDATE configs SET type_text='".$_POST['config_impressum']."' WHERE name='impressum';";
     $mysqli->query($query);
     $log->InsertItem("edit_impress.php -- ".$query);
 }
?>
 <form enctype="multipart/form-data" name="edit_impress" method="POST" action="index.php?action=EditMainItem&filter=<?PHP echo $image['sequence'];?>">
   <table>
    <tr>
      <td>
        <textarea name="config_impressum" rows=30 cols=70>
            <?PHP
              echo $config_impressum;
            ?>
        </textarea>
      </td>
    </tr>
   </table>
   <input type="hidden" name="key" value="<?PHP echo $image['key'];?>">
   <input type="hidden" name="sequence" value="<?PHP echo $image['sequence'];?>">
   <input type="submit" value="Ändern">
 </form>

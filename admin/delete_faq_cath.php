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
//     echo $key." : ".$value."<br/>\n";
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'del'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
//     echo $key1." : ".$value1."<br/>\n";
    if (is_numeric($key1)){
        $query = "DELETE FROM faq_multicontents WHERE faq_section_fk=".$value1['pk'].";";
        $mysqli->query($query);
        $query = $query="DELETE FROM faq_sections WHERE pk=".$value1['pk']." AND name='".$value1['rubrik']."';";
        $mysqli->query($query);
        $log->InsertItem("delete_faq_cath.php -- ".$query);
        $log->WriteLog;
    }
}
if (isset($_GET['pk'])){
?>
<form name="delete_faq_cath" action="index.php?action=DeleteFaqCath" method="POST">
<input type="hidden" name="del_1_rubrik" value="<?PHP echo $dataTblFaqSections[$_GET['pk']]['name']?>" >
<input type="hidden" name="del_1_pk" value="<?PHP echo $dataTblFaqSections[$_GET['pk']]['pk']?>" >
<table align="center" valign="center">
<tr><td> Rubrik "<?PHP echo $dataTblFaqSections[$_GET['pk']]['name']?>" wirklich löschen?</td></tr>
</table>
<input type="submit" value="JA">
</form>
<?PHP
}else{
echo "gelöscht";
}
?>

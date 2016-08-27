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
     $postvarsplit = preg_split('/_/',$key);
    if ($postvarsplit[0] == 'del'){
        $ergarray[$postvarsplit[1]][$postvarsplit[2]] = $value;
    }
}
foreach ($ergarray as $key1 => $value1){
    if (is_numeric($key1)){
        $query = "SELECT * FROM help_subsections WHERE help_section_fk=".$value1['pk'].";";
        $resDel = $mysqli->query($query);
        while ($line = $resDel->fetch_array(MYSQLI_ASSOC)) {
            $query = "DELETE FROM help_multicontents WHERE help_subsection_fk=".$line['pk'].";";
            $mysqli->query($query);
            $query = "DELETE FROM help_subsections WHERE pk=".$line['pk'].";";
            $mysqli->query($query);
            $log->InsertItem("delete_faq.php -- ".$query);
        }
        $query = $query="DELETE FROM help_sections WHERE pk=".$value1['pk'].";";
        $mysqli->query($query);
        $log->InsertItem("delete_faq.php -- ".$query);
        $log->WriteLog;
    }
}
?>
<form name="delete_faq_cath" action="index.php?action=DeleteHelpCath" method="POST">
<input type="hidden" name="del_1_name" value="<?PHP echo $dataTblHelpSections[$_GET['pk']]['name']?>" >
<input type="hidden" name="del_1_pk" value="<?PHP echo $dataTblHelpSections[$_GET['pk']]['pk']?>" >
<table align="center" valign="center">
<tr><td> Rubrik "<?PHP echo $dataTblHelpSections[$_GET['pk']]['name']?>" und alle Unterrubriken wirklich löschen?</td></tr>
</table>
<input type="submit" value="JA">
</form>

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
            $query = "DELETE FROM help_multicontents WHERE help_content_fk=".$value1['pk'].";";
            $mysqli->query($query);
            $rows1 = $mysqli->affected_rows;
            $log->InsertItem("delete_help.php -- ".$query);
            $log->WriteLog;
            $query = "DELETE FROM help_incidents WHERE help_content_fk=".$value1['pk'].";";
            $mysqli->query($query);
            $rows3 = $mysqli->affected_rows;
            $log->InsertItem("delete_faq.php -- ".$query);
            $log->WriteLog;
            $query = "DELETE FROM help_contents WHERE pk=".$value1['pk'].";";
            $mysqli->query($query);
            $rows2 = $mysqli->affected_rows;
            $log->InsertItem("delete_help.php -- ".$query);
            $log->WriteLog;
}
if (isset($_GET['pk'])){
?>
<form name="delete_help" action="index.php?action=DeleteHelp" method="POST">
<input type="hidden" name="del_1_reihe" value="<?PHP echo $dataTblHelpContents[$_GET['pk']]['reihe']?>" >
<input type="hidden" name="del_1_pk" value="<?PHP echo $dataTblHelpContents[$_GET['pk']]['pk']?>" >
<table align="center" valign="center">
<tr><td> Eintrag "<?PHP echo $dataTblHelpContents[$_GET['pk']]['name']?>" wirklich löschen?</td></tr>
</table>
<input type="submit" value="JA">
</form>
<?PHP
}else{
echo "gelöscht [".(string)$rows1." :: ".(string)$rows2."]";
}
?>

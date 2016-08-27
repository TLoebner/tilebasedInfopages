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
if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
?>
<div class="dtree">

	<p><a href="javascript: d.openAll();">alle erweitern</a> | <a href="javascript: d.closeAll();">alle minimieren</a></p>

	<script type="text/javascript" charset="UTF-8">

		d = new dTree('d');

		d.add(0,-1,'Administration');
		d.add(1,0,'<a href="edit_main.php">Titelseite editieren</a>');
		d.add(2,0,'<a href="edit_configs.php">Konfiguration editieren</a>');
		d.add(3,0,'<a href="edit_screensaver.php">Bildschirmschoner editieren</a>');
		d.add(4,0,'Neues Element einfügen');
		d.add(5,4,'<a href="new_help_cath.php">Hilfe - Rubrik</a>');
		d.add(6,4,'<a href="new_help_subcath.php">Hilfe - Subrubrik</a>');
		d.add(7,4,'<a href="new_help.php">Hilfe - Eintrag</a>');
		d.add(8,4,'<a href="new_faq_cath.php">FAQ - Rubrik</a>');
		d.add(9,4,'<a href="new_faq.php">FAQ - Eintrag</a>');
		d.add(10,0,'Utils');
		d.add(11,10,'<a href="update_uids.php">uids erzeugen</a>');
		d.add(12,10,'<a href="status_search.php">Statistiken anzeigen</a>');
		d.add(13,10,'<a href="show_doubles.php">Doppeleinträge anzeigen</a>');
		d.add(14,0,'<a href="logout.php">LOGOUT</a>');

		d.add(50,0,'Hilfe');
		
<?PHP
$i=51;
foreach($data['help'] as $key1 => $value1){    
    echo "d.add(".(string)$i.",50,'".$key1."');\n";$a=$i;
    $a=$i;
    $i++;
    echo "d.add(".(string)$i.",".(string)$a.",'<a href=\"edit_help_cath.php?pk=".$value1['tbl']['pk']."\">Editieren</a>');\n";
    $j=$i-1;
    $i++;
    if (key1!='tbl'){
        foreach($value1 as $key2 => $value2){
            if($key2!='tbl'){
                echo "d.add(".(string)$i.",".(string)$j.",'".$key2."');\n";
                $a=$i;
                $i++;
                echo "d.add(".(string)$i.",".(string)$a.",'<a href=\"edit_help_subcath.php?pk=".$value2['tbl']['pk']."\">Editieren</a>');\n";
                $i++;
                foreach($value2 as $key3 => $value3){
                    if($key3!='tbl'){
                        echo "d.add(".(string)$i.",".(string)$a.",'<a href=\"edit_help.php?pk=".$value3['content_pk']."\">".substr($value3['help_name'],0,20).str_replace("Ä","&Auml;").str_replace("ä","&auml;").str_replace("Ü","&Uuml;").str_replace("ü","&uuml;").str_replace("Ö","&Ouml;").str_replace("ö","&ouml;")."</a>');\n";
                        $i++;
                    }
                }
            }
        }
    }
}
$i++;
$h=$i;
echo "d.add(".(string)$i.",0,'FAQ');\n";
$i++;
foreach($data['faq'] as $key1 => $value1){    
    echo "d.add(".(string)$i.",".(string)$h.",'".$value1['tbl']['sequence_no']." :: ".$key1."');\n";
    $a=$i;
    $i++;
    echo "d.add(".(string)$i.",".(string)$a.",'<a href=\"edit_faq_cath.php?pk=".$value1['tbl']['pk']."\">Editieren</a>','','','','','img/question.gif');\n";
    $j=$i-1;
    $i++;
    foreach($value1 as $key2 => $value2){
        if ($key2!="tbl"){
            echo "d.add(".(string)$i.",".(string)$j.",'<a href=\"edit_faq.php?pk=".$value2['content_pk']."\">".substr($value2['question'],0,20)."</a>');\n";
            $a=$i;
            $i++;
        }
    }
}
?>
		document.write(d);
	</script>
</div>
<?PHP }?>

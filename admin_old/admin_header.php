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

?>
<HTML>
<HEADER>
    <meta charset="UTF-8">
    <link rel="StyleSheet" href="dtree.css" type="text/css" />
    <script type="text/javascript" src="dtree.js" charset="UTF-8"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="minified/themes/default.min.css" type="text/css" media="all" charset="UTF-8" />
    <script type="text/javascript" src="minified/jquery.sceditor.bbcode.min.js" charset="UTF-8"></script>
<script language='javascript'>
  
  function move_up() {
    scroll_clipper.scrollTop = 0;
  }

</script>
    
</HEADER>
<BODY>
<?PHP
    require_once 'log.class.php';
    ini_set ( "session.cookie_lifetime" , "1500" );
    ini_set ( "session.gc_maxlifetime" , "1500" );
    session_start();

  $mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
  echo "<br/>";
}else{
  if (isset($_POST) && (strlen($_POST['user']) > 3)){
    $query = "SELECT * FROM users WHERE name='".$_POST['user']."' AND password='".md5($_POST['password'])."';";
    $result = $mysqli->query($query);// or die("Anfrage fehlgeschlagen: " . mysql_error());
    if ($result->num_rows>0){
        $line = $result->fetch_assoc();
        $_SESSION['user'] = $line["name"];
        $_SESSION['rights'] = "admin";//$line["rights"];
        $log = new LogFileHandler();
        $log->InsertItem("LOGIN");
        $log->WriteLog;
    }
  }else{

    echo "<form method=\"POST\" action=\"".$_SERVER["SCRIPT_NAME"]."\">"
?>
  <input type="text" name="user"><br/>
  <input type="password" name="password"><br/>
  <input type="submit" value="login"><br/>
</form>
<?PHP
  }
}
if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
    $query = "SELECT * FROM help_sections ORDER BY sequence_no ASC";
    $res_tbl_help_sections = $mysqli->query($query);
    $query = "SELECT * FROM help_subsections ORDER BY help_section_fk, sequence_no ASC";
    $res_tbl_help_subsections = $mysqli->query($query);
    $query = "SELECT * FROM help_contents ORDER BY pk ASC";
    $res_tbl_help_contents = $mysqli->query($query);
    $query = "SELECT * FROM faq_sections ORDER BY sequence_no ASC";
    $res_tbl_faq_sections = $mysqli->query($query);
    $query = "SELECT * FROM faq_contents ORDER BY pk ASC";
    $res_tbl_faq_contents = $mysqli->query($query);
    //
    $query = "SELECT * FROM all_help_contents;";
    $res_tbl_help = $mysqli->query($query);
    $query = "SELECT * FROM all_faq_contents;";
    $res_tbl_faq = $mysqli->query($query);
    //
    $data['help'] = array();
//     $data['help']['unzugeordnet'] = array();
//     $data['help']['unzugeordnet']['unzugeordnet'] = array();
//     $data['faq'] = array();
//     $data['faq']['unzugeordnet'] = array();
    //
    while ($line = $res_tbl_help_sections->fetch_array(MYSQLI_ASSOC)) {
        $dataTblHelpSections[$line['pk']] = $line;
        $dataTblHelpSections[$line['name']] = $line;
    }
    while ($line = $res_tbl_help_subsections->fetch_array(MYSQLI_ASSOC)) {
        $dataTblHelpSubsections[$line['pk']] = $line;
        $dataTblHelpSubsections[$line['name']] = $line;
    }
    while ($line = $res_tbl_help_contents->fetch_array(MYSQLI_ASSOC)) {
        $dataTblHelpContents[$line['pk']] = $line;

    }
    while ($line = $res_tbl_faq_sections->fetch_array(MYSQLI_ASSOC)) {
        $dataTblFaqSections[$line['pk']] = $line;
        $dataTblFaqSections[$line['name']] = $line;
    }
    while ($line = $res_tbl_faq_contents->fetch_array(MYSQLI_ASSOC)) {
        $dataTblFaqContents[$line['pk']] = $line;
    }
    while ($line = $res_tbl_help->fetch_array(MYSQLI_ASSOC)) {
//         echo $line['help_name'];
        if (isset($line['section_pk']) && $line['section_pk'] != "NULL"){
            $data['help'][$line['section_name']][$line['subsection_name']][$line['content_sequence']] = $line;
        }
//         else{
//             $data['help']['unzugeordnet']['unzugeordnet'][$line['content_pk']] = $line;
//         }
    }
    foreach($data['help'] as $key1 => $value1){
        $data['help'][$key1]['tbl'] = $dataTblHelpSections[$key1];
        foreach($value1 as $key2 => $value2){
            $data['help'][$key1][$key2]['tbl'] = $dataTblHelpSubsections[$key2];
        }
    }
//     $data['help']['unzugeordnet']['tbl']['pk'] = "0";
//     $data['help']['unzugeordnet']['unzugeordnet']['tbl']['pk'] = "0";
//     $data['help']['unzugeordnet']['tbl']['sequence_no'] = "0";
//     $data['help']['unzugeordnet']['unzugeordnet']['tbl']['sequence_no'] = "0";
    while ($line = $res_tbl_faq->fetch_array(MYSQLI_ASSOC)) {
        if (isset($line['section_pk']) && $line['section_pk'] != "NULL"){
            $data['faq'][$line['section_name']][$line['content_sequence']] = $line;
//             $m=1;
//             $query = "SELECT * FROM faq_multicontents WHERE faq_contents_fk=".$line['pk'];
//             $res_multicontent = $mysqli->query($query);
//             if ($res_multicontent->num_rows > 0){
//                 while ($line2 = $res_multicontent->fetch_array(MYSQLI_ASSOC)){
//                     $data['faq'][$line['section_name']][$line['content_sequence']]['fk_faq_section_'.(string)$m]=$line2['faq_section_fk'];
//                     $data['faq'][$line['section_name']][$line['content_sequence']]['sequence_no_'.(string)$m]=$line2['sequence_no'];
//                     $m++;
//                 }
//             }
        }
//         else{
//             $data['faq']['unzugeordnet'][$line['content_pk']]  = $line;
//             $m=1;
//             $query = "SELECT * FROM faq_multicontents WHERE faq_contents_fk=".$line['pk'];
//             $res_multicontent = $mysqli->query($query);
//             if ($res_multicontent->num_rows > 0){
//                 while ($line2 = $res_multicontent->fetch_array(MYSQLI_ASSOC)){
//                     $data['faq']['unzugeordnet'][$line['content_pk']]['fk_faq_section_'.(string)$m]=$line2['faq_section_fk'];
//                     $data['faq']['unzugeordnet'][$line['content_pk']]['sequence_no_'.(string)$m]=$line2['sequence_no'];
//                     $m++;
//                 }
//             }
//         }
    }
    foreach($data['faq'] as $key1 => $value1){
        $data['faq'][$key1]['tbl'] = $dataTblFaqSections[$key1];
    }
//     $data['faq']['unzugeordnet']['tbl']['pk'] = "0";
//     $data['faq']['unzugeordnet']['tbl']['sequence_no'] = "0";
}
?>

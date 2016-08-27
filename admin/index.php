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
ini_set ( "session.cookie_lifetime" , "1500" );
ini_set ( "session.gc_maxlifetime" , "1500" );
session_start();
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
//mysql_set_charset ( "UTF-8", $mysqli );

if (isset($_SESSION) && $_SESSION['rights'] == "admin" && isset($_GET['action']) && (strlen($_GET['action']) > 3) && (strtolower($_GET['action']) == "logout")){
    session_destroy();
    $log->InsertItem("LOGOUT");
    $log->WriteLog;
    header('Location: index.php');
}

if (isset($_SESSION) && $_SESSION['rights'] == "admin"){
    // get actions
    if (isset($_GET['action']) && (strlen($_GET['action']) > 3)){
        require_once 'config.php';
        $query = "SELECT * FROM admin_menu WHERE action='".$_GET['action']."';";
        $result = $mysqli->query($query);
        $action=$result->fetch_assoc()['module'];

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
            if (isset($line['section_pk']) && $line['section_pk'] != "NULL"){
                $data['help'][$line['section_name']][$line['subsection_name']][$line['content_sequence']] = $line;
            }
        }
        foreach($data['help'] as $key1 => $value1){
            $data['help'][$key1]['tbl'] = $dataTblHelpSections[$key1];
            foreach($value1 as $key2 => $value2){
                $data['help'][$key1][$key2]['tbl'] = $dataTblHelpSubsections[$key2];
            }
        }
        while ($line = $res_tbl_faq->fetch_array(MYSQLI_ASSOC)) {
            if (isset($line['section_pk']) && $line['section_pk'] != "NULL"){
                $data['faq'][$line['section_name']][$line['content_sequence']] = $line;
            }
        }
        foreach($data['faq'] as $key1 => $value1){
            $data['faq'][$key1]['tbl'] = $dataTblFaqSections[$key1];
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiPa-Admin-Seite</title>
    <link rel="stylesheet" href="assets/css/app.css">
  </head>
  <body>

    <div class="row">
      <div class="large-12 medium-6 small=2">
        &nbsp;
      </div>
    </div>
    <div class="row">
        <div class="large-2 column">
            <div class="row">
                <?php
                    require_once 'admin_menu.php';
                ?>
            </div>
        </div>
        <div class="large-8 column">
            <?PHP
                if (isset($action) && $action != '') require_once $action;
            ?>
        </div>
        <div class="large-2 column">
            <div class="row">
                <?php
                    require_once 'admin_todoList.php';
                ?>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
  </body>
</html>
<?PHP
}else{
    if (isset($_POST) && (strlen($_POST['user']) > 3)){
        $query = "SELECT * FROM users WHERE name='".$_POST['user']."' AND password='".md5($_POST['password'])."';";
        $result = $mysqli->query($query);// or die("Anfrage fehlgeschlagen: " . mysql_error());
        if ($result->num_rows>0){
            $line = $result->fetch_assoc();
            $_SESSION['user'] = $line["name"];
            $_SESSION['rights'] = "admin";//$line["rights"];
            $log->InsertItem("LOGIN");
            $log->WriteLog;
            ?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiPa-Admin-Seite</title>
    <link rel="stylesheet" href="assets/css/app.css">
  </head>
  <body>

    <div class="row">
      <div class="large-12 medium-6 small=2">
        &nbsp;
      </div>
    </div>
    <div class="row">
        <div class="large-3 column">
            <div class="row">
                <?php
                    require_once 'admin_menu.php';
                ?>
            </div>
        </div>
        <div class="large-6 column">
            <?PHP
                if (isset($action) && $action != '') require_once $action;
                //echo $_GET['action'];
                //echo $action;
            ?>
        </div>
        <div class="large-3 column">
            <div class="row">
                <?php
                    require_once 'admin_todoList.php';
                ?>
            </div>
        </div>
    </div>

<div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p>&nbsp;</p>
      </div>
    </div>
    <div class="row">
        <div class="small-12 medium-12 large-12 columns" align="center">
			<a href="https://github.com/TLoebner/tilebasedInfopages"> Created by TLoebner</a> licensed by <a href="https://github.com/TLoebner/tilebasedInfopages/blob/master/LICENSE">  Apache License Version 2.0, January 2004</a><br>
            <a href="Impressum.php">Impressum</a><br/>
            Images by <a class="impressum" href="http://www.flaticon.com/">www.flaticon.com/</a> - Grafik-Lizenzen : <a class="impressum" href="http://creativecommons.org/licenses/by/3.0/" >CC BY 3.0</a>
            <p>&nbsp;</p>
            <a href="../adminNew/">Administration</a>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
  </body>
  <?PHP
        }else{
            header('Location: login.php');
        }
    }else{
        header('Location: login.php');
    }
    header('Location: login.php');
}
$mysqli->close();
?>

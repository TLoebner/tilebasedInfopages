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
    $query = "SELECT * FROM `all_contents`;";
    $resContents = $mysqli->query($query);
    if ($resContents->num_rows > 0){
    while ($Contents = $resContents->fetch_array(MYSQLI_ASSOC)){
        if ($Contents['type'] == 'help'){
            $Menu[$Contents['type']][$Contents['section_name']][$Contents['subsection_name']][$Contents['help_name']] = $Contents;
            $Menu[$Contents['type']][$Contents['section_name']]['section_pk'] = $Contents['section_pk'];
            $Menu[$Contents['type']][$Contents['section_name']][$Contents['subsection_name']]['subsection_pk'] = $Contents['subsection_pk'];
        }
        if ($Contents['type'] == 'faq'){
            $Menu[$Contents['type']][$Contents['section_name']][$Contents['question']] = $Contents;
            $Menu[$Contents['type']][$Contents['section_name']]['section_pk'] = $Contents['section_pk'];
        }
    }}

    if (isset($_GET)){
        foreach($_GET as $key => $value){
            $GetString .= $key."=".$value."&";
        }
    }else{
        $GetString = "";
    }
?>
    <ul class="vertical menu" data-accordion-menu>
          <li><a href="index.php?action=logout">LOGOUT</a></li>
          <li><a href="index.php?<?PHP echo $GetString;?>">Menü neu laden</a></li>
          <li><a href="#">Einstellungen</a>
            <ul class="menu vertical nested">
                <li><a href="index.php?action=EditMain">Titelseite editieren</a></li>
		            <li><a href="index.php?action=EditConfigs">Konfiguration editieren</a></li>
            		<li><a href="index.php?action=EditImpress">Impressum editieren</a></li>
            		<!--<li><a href="index.php?action=EditHeadMenu">Oberes Menü editieren</a></li>-->
            		<!--<li><a href="index.php?action=EditScreensaver">Bildschirmschoner editieren</a></li>-->
            		<!--<li><a href="index.php?action=UpdateUids">uids erzeugen</a></li>-->
            		<li><a href="index.php?action=StatusSearch">Statistiken anzeigen</a></li>
            		<li><a href="index.php?action=ShowDoubles">Doppeleinträge anzeigen</a></li>
            </ul>
          </li>
          <li><a href="#">Neue Elemente</a>
            <ul class="menu vertical nested">
                <li><a href="index.php?action=NewHelpCath">Hilfe - Rubrik</a></li>
		<li><a href="index.php?action=NewHelpSubcath">Hilfe - Subrubrik</a></li>
		<li><a href="index.php?action=NewHelp">Hilfe - Eintrag</a></li>
		<li><a href="index.php?action=NewFaqCath">FAQ - Rubrik</a></li>
		<li><a href="index.php?action=NewFaq">FAQ - Eintrag</a></li>
            </ul>
          </li>
          <li><a>Hilfe-Einträge</a>
            <ul class="menu vertical nested">
            <?PHP
                foreach($Menu['help'] as $SecKey => $SecValue){
                    echo "<li><a href=\"index.php?action=EditHelpCath&pk=".$SecValue['section_pk']."\">".$SecKey."</a>\n";
                    echo "<ul class=\"menu vertical nested\">\n";
                    echo "<li><a href=\"index.php?action=EditHelpCath&pk=".$SecValue['section_pk']."\">Hilfe-Kategorie anpassen</a></li>";
                    foreach($SecValue as $SubSecKey => $SubSecValue){
                        if ($SubSecKey != 'section_pk'){
                            echo "<li><a href=\"index.php?action=EditHelpSubCath&pk=".$SubSecValue['subsection_pk']."\">".$SubSecKey."</a>\n";
                            echo "<ul class=\"menu vertical nested\">\n";
                            echo "<li><a href=\"index.php?action=EditHelpSubCath&pk=".$SubSecValue['subsection_pk']."\">Hilfe-UnterKategorie anpassen</a></li>";
                                foreach($SubSecValue as $ContentKey => $ContentValue){
                                    if ($ContentKey != 'subsection_pk'){
                                        echo "<li><a href=\"index.php?action=EditHelp&pk=".$ContentValue['content_pk']."\">".$ContentKey."</a></li>\n";
                                    }
                                }
                            echo "</ul></li>\n";
                        }
                    }
                    echo "</ul></li>\n";
                }
            ?>
            </ul>
          </li>
          <li><a>FAQ-Einträge</a>
            <ul class="menu vertical nested">
            <?PHP
                foreach($Menu['faq'] as $SecKey => $SecValue){
                    echo "<li><a href=\"index.php?action=EditFaqCath&pk=".$SecValue['section_pk']."\">".$SecKey."</a>\n";
                    echo "<ul class=\"menu vertical nested\">";
                    echo "<li><a href=\"index.php?action=EditFaqCath&pk=".$SecValue['section_pk']."\">FAQ-Kategorie anpassen</a></li>";
                    foreach($SecValue as $ContentKey => $ContentValue){
                        if ($ContentKey != 'section_pk'){
                            echo "<li><a href=\"index.php?action=EditFaq&pk=".$ContentValue['content_pk']."\">".$ContentKey."</a></li>\n";
                        }
                    }
                    echo "</ul></li>";
                }
            ?>
            </ul>
          </li>
        </ul>

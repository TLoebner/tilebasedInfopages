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
require 'admin_header.php';
require 'admin_menu.php';

// echo "<p><h1>JSON Einrichtugen</h1></p>";
// $json_res = "[";
//   $query0 = "SELECT * FROM contents ORDER BY reihe ASC";
//   $contents_result = $mysqli->query($query0);
//   while ($contents_line = $contents_result->fetch_assoc()) {
//     // JSON output
//     $json_res .= "{ rubrik : '".$contents_line['name']."', values : ";
//     //
//     $query1 = "SELECT * FROM rubriken WHERE contents_fk=".$contents_line['pk']."  ORDER BY reihe ASC";
//     $rubriken_result = $mysqli->query($query1);
//     while ($rubriken_line = $rubriken_result->fetch_assoc()) {
//       // JSON output
//       $json_res .=  "{unterrubrik : '".$rubriken_line['rubrik']."', values : ";
//       //
//       $query2 = "SELECT * FROM rubrikeninhalte WHERE fk_rubrik=".$rubriken_line['pk']." ORDER BY fk_rubrik,reihe ASC";
//       $inhalte_result = $mysqli->query($query2);
//       while ($inhalte_line = $inhalte_result->fetch_assoc()) {
// 	$strcomment = str_replace('[b]','<b>',$inhalte_line['comment']);
// 	$strcomment = str_replace("[/b]","</b>",$strcomment);
// 	$strcomment = str_replace("[i]","<i>",$strcomment);
// 	$strcomment = str_replace("[/i]","</i>",$strcomment);
// 	$strcomment = str_replace("[u]","<u>",$strcomment);
// 	$strcomment = str_replace("[/u]","</u>",$strcomment);
// 	$strcomment = str_replace(array("\r\n", "\n", "\r"),"<br />",$strcomment);
// 	// JSON output
// 	$json_res .=  "{name : '".$inhalte_line['inhalt']."', link : '".$inhalte_line['link']."', text : '".$strcomment."'}";
// 	//
// //       echo "}\n";
//       }
//       $json_res .=  "}";
//     }
//     $json_res .=  "}";
//   }
// $json_res .=  "]";
// 
// echo $json_res;
// echo "<p><h1>JSON Einrichtugen</h1></p>";
// $json_res = "[";
//   $query0 = "SELECT * FROM faq_rubrik ORDER BY reihe ASC";
//   $contents_result = $mysqli->query($query0);
//   while ($contents_line = $contents_result->fetch_assoc()) {
//     // JSON output
//     $json_res .= "{ rubrik : '".$contents_line['name']."', values : ";
//     //
//     $query2 = "SELECT * FROM faq_inhalte WHERE fk_rubrik=".$contents_line['pk']." ORDER BY fk_rubrik,reihe ASC";
//     $inhalte_result = $mysqli->query($query2);
//     while ($inhalte_line = $inhalte_result->fetch_assoc()) {
//       $question = str_replace('[b]','<b>',$inhalte_line['question']);
//       $question = str_replace("[/b]","</b>",$question);
//       $question = str_replace("[i]","<i>",$question);
//       $question = str_replace("[/i]","</i>",$question);
//       $question = str_replace("[u]","<u>",$question);
//       $question = str_replace("[/u]","</u>",$question);
//       $question = str_replace(array("\r\n", "\n", "\r"),"<br />",$question);
//       $answer = str_replace('[b]','<b>',$inhalte_line['answer']);
//       $answer = str_replace("[/b]","</b>",$answer);
//       $answer = str_replace("[i]","<i>",$answer);
//       $answer = str_replace("[/i]","</i>",$answer);
//       $answer = str_replace("[u]","<u>",$answer);
//       $answer = str_replace("[/u]","</u>",$answer);
//       $answer = str_replace(array("\r\n", "\n", "\r"),"<br />",$answer);
//       // JSON output
//       $json_res .=  "{question : '".$question."', link : '".$inhalte_line['link']."', answer : '".$answer."'}";
//       //
// //       echo "}\n";
//     }
//     $json_res .=  "}";
//   }
// $json_res .=  "]";
// echo $json_res;
echo "<p><h1>Array - Komplett</h1></p>";
foreach($data as $key1 => $value1){
    echo $key1." => ".$value1."<br/>";
    foreach($value1 as $key2 => $value2){    
        echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
        foreach($value2 as $key3 => $value3){
            echo "&nbsp;&nbsp;&nbsp;|  |--> ".$key3." => ".$value3."<br/>";
            foreach($value3 as $key4 => $value4){
                echo "&nbsp;&nbsp;&nbsp;|  |  |--> ".$key4." => ".$value4."<br/>";
                foreach($value4 as $key5 => $value5){
                    echo "&nbsp;&nbsp;&nbsp;|  |  |  |--> ".$key5." => ".$value5."<br/>";
                }
            }
        }
    }
}
/*
echo "<p><h1>Array - einzeln</h1></p>";
foreach($dataTblContents as $key1 => $value1){
    echo $key1." => ".$value1."<br/>";
    foreach($value1 as $key2 => $value2){    
        echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
    }
}*/
echo "<hr/>";
foreach($dataTblHelpSubsections as $key1 => $value1){
    echo $key1." => ".$value1."<br/>";
    foreach($value1 as $key2 => $value2){    
        echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
    }
}
// echo "<hr/>";
// foreach($dataTblRubrikeninhalte as $key1 => $value1){
//     echo $key1." => ".$value1."<br/>";
//     foreach($value1 as $key2 => $value2){    
//         echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
//     }
// }
// echo "<hr/>";
// foreach($dataTblFaqrubrik as $key1 => $value1){
//     echo $key1." => ".$value1."<br/>";
//     foreach($value1 as $key2 => $value2){    
//         echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
//     }
// }
// echo "<hr/>";
// foreach($dataTblFaqinhalte as $key1 => $value1){
//     echo $key1." => ".$value1."<br/>";
//     foreach($value1 as $key2 => $value2){    
//         echo "&nbsp;&nbsp;&nbsp;|--> ".$key2." => ".$value2."<br/>";
//     }
// }
// echo "<hr/>";
// echo "<p><h1>PHPINFO</h1></p>";
// //phpinfo();
?>

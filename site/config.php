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
$mysqli = new mysqli("localhost", "root", "", "TileInfoPage");
$query = "SELECT * FROM `configs`;";
    $res_config = $mysqli->query($query);
    if ($res_config->num_rows > 0){
        while ($config = $res_config->fetch_array(MYSQLI_ASSOC)){
            switch ($config['type']) {
                case "int":
                     ${"config_".$config['name']} = $config["type_".$config['type']];
                     ${'configArr_'.$config['name']} = array('name'=>$config['name'],'type'=>$config['type'],'content'=>$config['type_'.$config['type']],'text'=>$config['text']);
                break;
                case "color":
                     ${'config_'.$config['name']} = $config['type_'.$config['type']];
                     ${'configArr_'.$config['name']} = array('name'=>$config['name'],'type'=>$config['type'],'content'=>$config['type_'.$config['type']],'text'=>$config['text']);
                break;
                case "string":
                     ${'config_'.$config['name']} = $config['type_'.$config['type']];
                     ${'configArr_'.$config['name']} = array('name'=>$config['name'],'type'=>$config['type'],'content'=>$config['type_'.$config['type']],'text'=>$config['text']);
                break;
                case "text":
                     ${'config_'.$config['name']} = $config['type_'.$config['type']];
                     ${'configArr_'.$config['name']} = array('name'=>$config['name'],'type'=>$config['type'],'content'=>$config['type_'.$config['type']],'text'=>$config['text']);
                break;
                case "image":
                     ${'config_'.$config['name']} = $config['type_'.$config['type'].'_data'];
                     ${'configArr_'.$config['name']} = array('name'=>$config['name'],'type'=>$config['type'],'mime'=>$config['type_image_mime'],'size'=>$config['type_image_size'],'data'=>$config['type_image_data'],'text'=>$config['text']);
                break;
            }
        }
        $menu[$config_Item1Sort]['type'] = $config_Item1Type;
        $menu[$config_Item1Sort]['text'] = $config_Item1Text;
        $menu[$config_Item1Sort]['image_mime'] = $configArr_Item1Image['mime'];
        $menu[$config_Item1Sort]['image_size'] = $configArr_Item1Image['size'];
        $menu[$config_Item1Sort]['image_data'] = $configArr_Item1Image['data'];
        $menu[$config_Item1Sort]['HelpSecLink'] = $config_Item1HelpSecLink;
        $menu[$config_Item1Sort]['HelpSubSecLink'] = $config_Item1HelpSubSecLink;
        $menu[$config_Item1Sort]['HelpContLink'] = $config_Item1HelpContLink;
        $menu[$config_Item1Sort]['FaqSecLink'] = $config_Item1FaqSecLink;
        $menu[$config_Item1Sort]['FaqContLink'] = $config_Item1FaqContLink;
        //
        $menu[$config_Item2Sort]['type'] = $config_Item2Type;
        $menu[$config_Item2Sort]['text'] = $config_Item2Text;
        $menu[$config_Item2Sort]['image_mime'] = $configArr_Item2Image['mime'];
        $menu[$config_Item2Sort]['image_size'] = $configArr_Item2Image['size'];
        $menu[$config_Item2Sort]['image_data'] = $configArr_Item2Image['data'];
        $menu[$config_Item2Sort]['HelpSecLink'] = $config_Item2HelpSecLink;
        $menu[$config_Item2Sort]['HelpSubSecLink'] = $config_Item2HelpSubSecLink;
        $menu[$config_Item2Sort]['HelpContLink'] = $config_Item2HelpContLink;
        $menu[$config_Item2Sort]['FaqSecLink'] = $config_Item2FaqSecLink;
        $menu[$config_Item2Sort]['FaqContLink'] = $config_Item2FaqContLink;
        //
        $menu[$config_Item3Sort]['type'] = $config_Item3Type;
        $menu[$config_Item3Sort]['text'] = $config_Item3Text;
        $menu[$config_Item3Sort]['image_mime'] = $configArr_Item3Image['mime'];
        $menu[$config_Item3Sort]['image_size'] = $configArr_Item3Image['size'];
        $menu[$config_Item3Sort]['image_data'] = $configArr_Item3Image['data'];
        $menu[$config_Item3Sort]['HelpSecLink'] = $config_Item3HelpSecLink;
        $menu[$config_Item3Sort]['HelpSubSecLink'] = $config_Item3HelpSubSecLink;
        $menu[$config_Item3Sort]['HelpContLink'] = $config_Item3HelpContLink;
        $menu[$config_Item3Sort]['FaqSecLink'] = $config_Item3FaqSecLink;
        $menu[$config_Item3Sort]['FaqContLink'] = $config_Item3FaqContLink;
    }

?>

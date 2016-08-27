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
    class LogFileHandler{
        private $logstrings;
        private $index;

        public function __construct(){
            $index=0;
        }

        public function __destruct(){
            if (index>0){
                WriteLog();
            }
        }

        public function InsertItem($message){
            $logstrings[$index] = "::LOG::;".date('h-i-s, j-m-y').";".$message."\n";
            file_put_contents('./log/'.date("Y_m_d").'_logfile.csv', $logstrings[$index]. PHP_EOL, FILE_APPEND);
            $index++;
        }

        public function InsertError($message){
            $logstrings[$index] = "::ERROR::;".date('h-i-s, j-m-y').";".$message."\n";
            file_put_contents('./log/'.date("Y_m_d").'_logfile.csv', $logstrings[$index]. PHP_EOL, FILE_APPEND);
            $index++;
        }

        public function WriteLog(){
            //foreach($logstrings as $key => $logentry){
            //    file_put_contents('./log/'.date("Y_m_d").'_logfile.csv', $logentry, FILE_APPEND);
            //}
            $logstrings=array();
            $index=0;
        }
    }

?>

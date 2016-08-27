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


$HelpSectionQuery = "SELECT `all_status`.`type`, `all_status`.`pk`, `all_status`.`month`, `all_status`.`year`, `all_status`.`section_pk`,`help_sections`.`name`,SUM(`all_status`.`count`) AS sum_count FROM `all_status` LEFT JOIN `help_sections` ON (`all_status`.`section_pk` = `help_sections`.`pk` AND `all_status`.`type`='help') GROUP BY `section_pk`;";
$HelpSubSectionQuery = "SELECT `all_status`.`type`, `all_status`.`pk`, `all_status`.`month`, `all_status`.`year`, `all_status`.`subsection_pk`,`help_subsections`.`name`,SUM(`all_status`.`count`) AS sum_count FROM `all_status` LEFT JOIN `help_subsections` ON (`all_status`.`subsection_pk` = `help_subsections`.`pk` AND `all_status`.`type`='help') GROUP BY `subsection_pk`;";
$HelpContentQuery = "SELECT `all_status`.`type`, `all_status`.`pk`, `all_status`.`month`, `all_status`.`year`, `all_status`.`content_pk`,`help_contents`.`name`,SUM(`all_status`.`count`) AS sum_count FROM `all_status` LEFT JOIN `help_contents` ON (`all_status`.`content_pk` = `help_contents`.`pk` AND `all_status`.`type`='help') GROUP BY `content_pk`;";

$FaqSectionQuery = "SELECT `all_status`.`type`, `all_status`.`pk`, `all_status`.`month`, `all_status`.`year`, `all_status`.`section_pk`,`faq_sections`.`name`,SUM(`all_status`.`count`) AS sum_count FROM `all_status` LEFT JOIN `faq_sections` ON (`all_status`.`section_pk` = `faq_sections`.`pk` AND `all_status`.`type`='faq') GROUP BY `faq_sections`.`pk`;";
$FaqContentQuery = "SELECT `all_status`.`type`, `all_status`.`pk`, `all_status`.`month`, `all_status`.`year`, `all_status`.`content_pk`,`faq_contents`.`question`,SUM(`all_status`.`count`) AS sum_count FROM `all_status` LEFT JOIN `faq_contents` ON (`all_status`.`content_pk` = `faq_contents`.`pk` AND `all_status`.`type`='faq') GROUP BY `faq_contents`.`pk`;";


?>

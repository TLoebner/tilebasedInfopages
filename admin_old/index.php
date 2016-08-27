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
?>
<table>
<tr valign="top">
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_menu.php';
?>
</div>
</td>
<td valign="top">
<div style="width:600 px;height:100%;overflow-y: auto;overflow-x: auto;">
<table>
<tr>
<?PHP
//
//
    echo ("<h1>Administrationsbereich</h1>");
//
//
?>
</table>
</div>
</td>
<td>
<div style="width:250 px;height:100%;overflow-y: auto;overflow-x: auto;">
<?PHP
require 'admin_todoList.php';
?>
</div>
</td>
</tr>
</table>
<script>
$(function() {
    // Replace all textarea's
    // with SCEditor
    $("textarea").sceditor({
        plugins: "bbcode",
        toolbar: "bold,italic,underline|source",
	style: "minified/jquery.sceditor.default.min.css"
    });
});
</script>
<?PHP
require 'admin_footer.php'
?>

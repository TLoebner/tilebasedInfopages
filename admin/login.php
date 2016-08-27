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
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foundation for Sites</title>
    <link rel="stylesheet" href="assets/css/app.css">
  </head>
  <body>

    <div class="row">
	<div class="large-12 medium-6 small=2">
		&nbsp;
	</div>
    </div>
    <div class="large-5 large-centered columns" style="border:1px solid black;">
    <form action="index.php" method="POST">
	<div class="row">
		<div class="large-10 large-centered columns">
			&nbsp;
		</div>
	</div>
	<div class="row">
		<div class="large-10 large-centered columns">
			<label>Nutzername
			<input name="user" type="text" placeholder="Nutzername">
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-10 large-centered columns">
			<label>Passwort
			<input name="password" type="password" placeholder="Passwort">
		</div>
	</div>
	<div class="row">
		<div class="large-10 large-centered columns">
			<input type="submit" class="success button" value="Login">
			<a class="alert button" href="../site/index.php">Schließen</a>
		</div>
	</div>
	<div class="row">
		<div class="large-10 large-centered columns">
			&nbsp;
		</div>
	</div>
    </form>
    </div>

    <script src="assets/js/app.js"></script>
  </body>
</html>

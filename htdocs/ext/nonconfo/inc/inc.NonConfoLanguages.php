<?php
//    Copyright (C) 2017 Multisistemas e Inversiones S.A. de C.V.
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

$__languages = getLanguagesTwo();

foreach($__languages as $_lang) {
	if(file_exists($settings->_rootDir . "ext/nonconfo/languages/" . $_lang . "/lang.inc")) {
		include $settings->_rootDir . "ext/nonconfo/languages/" . $_lang . "/lang.inc";

		$LANG[$_lang] = $LANG[$_lang] + $text;

	}
}
unset($text);

function getAvailableLanguagesTwo() { /* {{{ */
	global $settings;

	$languages = array();

	$path = $settings->_rootDir . "ext/nonconfo/languages/";
	$handle = opendir($path);

	while ($entry = readdir($handle) )
	{
		if ($entry == ".." || $entry == ".")
			continue;
		else if (is_dir($path . $entry))
			array_push($languages, $entry);
	}
	closedir($handle);

	asort($languages);
	return $languages;
} /* }}} */

function getLanguagesTwo() { /* {{{ */
	global $settings;

	if($settings->_availablelanguages) {
		return $settings->_availablelanguages;
	}

	return getAvailableLanguagesTwo();
} /* }}} */


<?php
/*
Copyright (C) 2008 Halmat Ferello

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once('../../../wp-config.php');
require_once('../../../wp-admin/includes/admin.php');
include_once('wp-js-files-list.php');

if ($_GET['action'] == "add" && $_GET['file']) {
	add_post_meta($_GET['id'], 'wp_js_file', $_GET['file']);
	wp_js_files($_GET['id']);
}
else if ($_GET['action'] == "delete" && $_GET['string']) {
	delete_post_meta($_GET['id'], 'wp_js_file', $_GET['string']);
	if ($_GET['ajax']) wp_js_files($_GET['id'], FALSE);
}
else if ($_GET['ajax'] && $_GET['action'] == "view") {
	wp_js_files($_GET['id']);
}
else if ($_GET['action'] == "apply_children_pages") {
	echo '<a href="javascript:void(0)" onclick="wp_js.applyChildren(this);return false;">Unapply from children pages</a>';
}

if (!$_GET['ajax']) {
	wp_redirect($_SERVER['HTTP_REFERER']);
}

?>

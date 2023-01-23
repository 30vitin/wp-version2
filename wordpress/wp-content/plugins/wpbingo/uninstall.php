<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
define('WPBINGO_CONTENT_TYPES_LIB', dirname(__FILE__) . '/lib/');
require_once WPBINGO_CONTENT_TYPES_LIB . 'lookbook/includes/bwp_lookbook_class.php';

global $wpdb;

$wpdb->query("DROP TABLE `" . $wpdb->prefix . SLIDES_TABLE . "`");
$file = new bwp_lookbook_class();
$file->delete_directory(FULL_UPLOAD_PATH);
$file->delete_directory(FULL_UPLOAD_PATH_THUMB);

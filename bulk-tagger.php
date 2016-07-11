<?php
/**
 * Bulk Tagger
 *
 * Helper page for Zenphoto, enabling the bulk tagging of images and albums based on search criteria.
 *
 * @author Marcus Wong (wongm)
 * @package plugins
 */

$plugin_description = gettext("Helper page for Zenphoto, enabling the bulk tagging of images and albums based on search criteria.");
$plugin_author = "Marcus Wong (wongm)";
$plugin_version = '1.0.0'; 
$plugin_URL = "https://github.com/wongm/zenphoto-tagger/";
$plugin_is_filter = 500 | ADMIN_PLUGIN;

zp_register_filter('admin_utilities_buttons', 'bulkTagger::button');

class bulkTagger {
	
	static function button($buttons) {
		$buttons[] = array(
						'category'		 => gettext('Admin'),
						'enable'			 => true,
						'button_text'	 => gettext('Bulk tagger'),
						'formname'		 => 'zenphotoTagger_button',
						'action'			 => WEBPATH.'/plugins/bulk-tagger',
						'icon'				 => 'images/pencil.png',
						'title'				 => gettext('Bulk tag images and albums in your gallery.'),
						'alt'					 => '',
						'hidden'			 => '',
						'rights'			 => ALBUM_RIGHTS
		);
		return $buttons;
	}
}
?>
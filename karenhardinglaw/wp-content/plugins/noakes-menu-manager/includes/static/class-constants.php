<?php
/*!
 * Plugin constants.
 *
 * @since 3.0.0
 *
 * @package    Nav Menu Manager
 * @subpackage Constants
 */

if (!defined('ABSPATH'))
{
	exit;
}

/**
 * Class used to implement plugin constants.
 *
 * @since 3.0.0
 */
final class Noakes_Menu_Manager_Constants
{
	/**
	 * Plugin prefixes.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const PREFIX = 'nmm_';

	/**
	 * Plugin token.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const TOKEN = 'noakes_menu_manager';

	/**
	 * Plugin version.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const VERSION = '3.0.1';
	
	/**
	 * Constants for code generation.
	 * 
	 * @since 3.0.0
	 * 
	 * @var string
	 */
	const CODE_FALSE = 'false';
	const CODE_MENU = 'menu';
	const CODE_NAV = 'nav';
	const CODE_QUOTE = '__Q__';
	const CODE_TRUE = 'true';
	
	/**
	 * ID used for widgets and shortcodes.
	 * 
	 * @since 3.0.0
	 * 
	 * @var string
	 */
	const COMPONENT_ID = self::PREFIX . 'menu';
	
	/**
	 * Plugin hook names.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const HOOK_RESET_GENERATOR = self::PREFIX . 'reset_generator';
	const HOOK_SAVE_SETTINGS = self::PREFIX . 'save_settings';

	/**
	 * Plugin option names.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const OPTION_GENERATOR = self::TOKEN . '_generator';
	const OPTION_SETTINGS = self::TOKEN . '_settings';
	const OPTION_VERSION = self::TOKEN . '_version';

	/**
	 * Plugin post meta names.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const POST_META_HASH = self::PREFIX . 'hash';
	const POST_META_ID = self::PREFIX . 'id';
	const POST_META_PREFIX = '_menu_item_';
	const POST_META_QUERY_STRING = self::PREFIX . 'query_string';

	/**
	 * Plugin setting names.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const SETTING_DELETE_SETTINGS = 'delete_settings';
	const SETTING_DELETE_POST_META = 'delete_post_meta';
	const SETTING_DELETE_USER_META = 'delete_user_meta';
	const SETTING_UNCONFIRMED = '_unconfirmed';

	/**
	 * Plugin URLs.
	 *
	 * @since 3.0.0
	 *
	 * @var string
	 */
	const URL_BASE = 'https://noakesplugins.com/';
	const URL_DONATE = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XNE7BREHR7BZQ&source=url';
	const URL_KB = self::URL_BASE . 'kb/noakes-menu-manager/';
	const URL_SUPPORT = 'https://wordpress.org/support/plugin/noakes-menu-manager/';
	const URL_REVIEW = self::URL_SUPPORT . 'reviews/?rate=5#new-post';
	const URL_TRANSLATE = 'https://translate.wordpress.org/projects/wp-plugins/noakes-menu-manager';
}

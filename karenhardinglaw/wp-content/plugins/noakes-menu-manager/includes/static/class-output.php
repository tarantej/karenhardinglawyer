<?php
/*!
 * Plugin output functionality.
 *
 * @since 3.0.0
 *
 * @package    Nav Menu Manager
 * @subpackage Output
 */

if (!defined('ABSPATH'))
{
	exit;
}

/**
 * Class used to implement the output functionality.
 *
 * @since 3.0.0
 */
final class Noakes_Menu_Manager_Output
{
	/**
	 * URL attribute for the default tab.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const TAB_DEFAULT = 'default';
	
	/**
	 * Admin page secondary tabs.
	 *
	 * @since 3.0.0
	 *
	 * @access private static
	 * @var    array
	 */
	private static $_secondary_tabs = array();

	/**
	 * Admin page tabs.
	 *
	 * @since 3.0.0
	 *
	 * @access private static
	 * @var    array
	 */
	private static $_tabs = array();

	/**
	 * Add an admin page secondary tab.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string $menu_parent Parent page for the admin page.
	 * @param  string $menu_slug   Menu slug for the admin page.
	 * @param  string $tab_slug    Slug for the secondary tab.
	 * @param  string $page_title  Title for the admin page tab.
	 * @return void
	 */
	public static function add_secondary_tab($menu_parent, $menu_slug, $tab_slug, $title)
	{
		if (!empty($menu_parent))
		{
			$nmm = Noakes_Menu_Manager();
			$url = admin_url($menu_parent);

			if (!empty($menu_slug))
			{
				$url = add_query_arg('page', $menu_slug, $url);
			}

			if (empty($tab_slug))
			{
				$tab_slug = self::TAB_DEFAULT;
			}
			else
			{
				$url = add_query_arg('tab', $tab_slug, $url);
			}
			
			$active_class =
			(
				$nmm->cache->current_page != $menu_slug
				||
				$nmm->cache->current_tab != $tab_slug
			)
			? ''
			: ' nmm-tab-active';
			
			self::$_secondary_tabs[] = '<a href="' . esc_url($url) . '" class="nmm-secondary-tab' . $active_class . '">' . $title . '</a>';
		}
	}

	/**
	 * Add an admin page tab.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string $menu_parent Parent page for the admin page.
	 * @param  string $menu_slug   Menu slug for the admin page.
	 * @param  string $page_title  Title for the admin page tab.
	 * @return void
	 */
	public static function add_tab($menu_parent, $menu_slug, $title)
	{
		if (!empty($menu_parent))
		{
			$url = admin_url($menu_parent);

			if (!empty($menu_slug))
			{
				$url = add_query_arg('page', $menu_slug, $url);
			}

			self::$_tabs[] = array
			(
				'title' => $title,
				'url' => esc_url($url),

				'active_class' => ($menu_slug == Noakes_Menu_Manager()->cache->current_page)
				? ' nmm-tab-active'
				: ''
			);
		}
	}

	/**
	 * Output an admin form page.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string $heading     Heading displayed at the top of the admin form page.
	 * @param  string $action      AJAX action to request on form submission.
	 * @param  string $option_name Option name to generate the admin form page for.
	 * @return void
	 */
	public static function admin_form_page($heading, $action = '', $option_name = '')
	{
		$nmm = Noakes_Menu_Manager();
		
		echo '<div class="wrap">';

		self::admin_nav_bar($heading);

		$screen = $nmm->cache->screen;
		$columns = $screen->get_columns();
		
		if (empty($columns))
		{
			$columns = 2;
		}

		echo '<form method="post" id="nmm-form">'
		. '<input name="admin-page" type="hidden" value="' . esc_attr(basename($_SERVER['SCRIPT_NAME'])) . '" />';
		
		if (!empty($action))
		{
			$action = sanitize_key($action);
			
			echo '<input name="action" type="hidden" value="' . $action . '" />';
			
			wp_nonce_field($action);
		}

		if (!empty($option_name))
		{
			echo '<input name="option-name" type="hidden" value="' . sanitize_key($option_name) . '" />';
		}

		wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
		wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

		echo '<div id="poststuff">'
		. '<div id="post-body" class="metabox-holder columns-' . $columns . '">'
		. '<div id="postbox-container-1" class="postbox-container">';

		do_meta_boxes($screen->id, 'side', '');

		echo '</div>'
		. '<div id="nmm-primary-wrapper">'
		. '<div id="postbox-container-2" class="postbox-container">';

		do_meta_boxes($screen->id, 'advanced', '');
		do_meta_boxes($screen->id, 'normal', '');

		echo '</div>'
		. '</div>'
		. '<div class="nmm-clear"></div>'
		. '</div>'
		. '</div>'
		. '</form>'
		. '</div>';
	}

	/**
	 * Output the admin page nav bar.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string $heading Heading displayed in the nav bar.
	 * @return void
	 */
	public static function admin_nav_bar($heading)
	{
		$nmm = Noakes_Menu_Manager();
		$buttons = '';
		
		echo '<div class="nmm-nav">'
		. '<div class="nmm-nav-title">'
		. '<h1>'
		. '<strong>' . $nmm->cache->plugin_data['Name'] . '</strong> | ' . $heading
		. '</h1>'
		. '<div class="nmm-clear"></div>'
		. '</div>';
		
		$has_secondary_tabs = (count(self::$_secondary_tabs) > 1);

		if (count(self::$_tabs) > 1)
		{
			echo '<div class="nmm-tab-wrapper">';

			foreach (self::$_tabs as $tab)
			{
				$tab['active_class'] .=
				(
					empty($tab['active_class'])
					||
					!$has_secondary_tabs
				)
				? ''
				: '-no-arrow';

				echo '<a href="' . $tab['url'] . '" class="nmm-tab' . $tab['active_class'] . '">' . $tab['title'] . '</a>';
			}

			echo '</div>';
		}

		if ($has_secondary_tabs)
		{
			echo '<div class="nmm-secondary-tab-wrapper">'
			. implode('', self::$_secondary_tabs)
			. '</div>';
		}
		
		echo '</div>'
		. '<hr class="wp-header-end" />';
	}
	
	/**
	 * Add the plugin name to a page title.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string $page_title Current page title.
	 * @return string             Modified page title.
	 */
	public static function page_title($page_title)
	{
		return $page_title . ' &#0139; ' . Noakes_Menu_Manager()->cache->plugin_data['Name'];
	}

	/**
	 * Add a required asterisk to a label if necessary.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  string  $label      Label to update with an asterisk.
	 * @param  array   $validation Array of validation rules for the object.
	 * @param  boolean $add_class  True if the asterisk should have the required class added.
	 * @return string              Modified label.
	 */
	public static function required_asterisk($label, $validation, $add_class = true)
	{
		if
		(
			is_array($validation)
			&&
			isset($validation['required'])
			&&
			$validation['required']
		)
		{
			$label = sprintf
			(
				_x('%1$s [*]', 'Required Field Label', 'noakes-menu-manager'),
				$label
			);
		}

		return ($add_class)
		? str_replace('[*]', '<span class="nmm-required">*</span>', $label)
		: $label;
	}
}

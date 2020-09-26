<?php
/*!
 * AJAX functionality.
 *
 * @since 3.0.0
 *
 * @package    Nav Menu Manager
 * @subpackage AJAX
 */

if (!defined('ABSPATH'))
{
	exit;
}

/**
 * Class used to implement the AJAX functionality.
 *
 * @since 3.0.0
 *
 * @uses Noakes_Menu_Manager_Wrapper
 */
final class Noakes_Menu_Manager_AJAX extends Noakes_Menu_Manager_Wrapper
{
	/**
	 * Constructor function.
	 *
	 * @since 3.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		if
		(
			defined('DOING_AJAX')
			&&
			DOING_AJAX
		)
		{
			add_action('wp_ajax_' . Noakes_Menu_Manager_Constants::HOOK_RESET_GENERATOR, array($this, 'reset_generator'));
			add_action('wp_ajax_' . Noakes_Menu_Manager_Constants::HOOK_SAVE_SETTINGS, array($this, 'save_settings'));
		}
		else
		{
			$query_arg = '';
			
			if (isset($_GET[Noakes_Menu_Manager_Constants::HOOK_RESET_GENERATOR]))
			{
				$query_arg = Noakes_Menu_Manager_Constants::HOOK_RESET_GENERATOR;
				
				Noakes_Menu_Manager_Noatice::add_success(__('Generator reset successfully.', 'noakes-menu-manager'));
			}
			else if (isset($_GET[Noakes_Menu_Manager_Constants::HOOK_SAVE_SETTINGS]))
			{
				$query_arg = Noakes_Menu_Manager_Constants::HOOK_SAVE_SETTINGS;
				
				Noakes_Menu_Manager_Noatice::add_success(__('Settings saved successfully.', 'noakes-menu-manager'));
			}
			
			if (!empty($query_arg))
			{
				$this->base->cache->push('remove_query_args', $query_arg);
			}
		}
	}
	
	/**
	 * Reset the generator settings.
	 *
	 * @since 3.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function reset_generator()
	{
		check_ajax_referer(Noakes_Menu_Manager_Constants::HOOK_RESET_GENERATOR, 'nonce');
		
		update_option(Noakes_Menu_Manager_Constants::OPTION_GENERATOR, array());
		
		wp_send_json_success(array
		(
			'url' => add_query_arg(Noakes_Menu_Manager_Constants::HOOK_RESET_GENERATOR, true, esc_url($_POST['url']))
		));
	}
	
	/**
	 * Save the plugin settings.
	 *
	 * @since 3.0.0
	 *
	 * @access public
	 * @return void
	 */
	public function save_settings()
	{
		check_ajax_referer(Noakes_Menu_Manager_Constants::HOOK_SAVE_SETTINGS);
		
		if (!isset($_POST['option-name']))
		{
			$this->_send_error(__('Settings could not be saved.', 'noakes-menu-manager'));
		}
		
		$option_name = sanitize_key($_POST['option-name']);
		
		update_option
		(
			$option_name,
			
			(isset($_POST[$option_name]))
			? Noakes_Menu_Manager_Sanitization::sanitize($_POST[$option_name])
			: array()
		);
		
		wp_send_json_success(array
		(
			'url' => add_query_arg
			(
				array
				(
					'page' => $option_name,
					Noakes_Menu_Manager_Constants::HOOK_SAVE_SETTINGS => true
				),
				
				esc_url(admin_url($_POST['admin-page']))
			)
		));
	}
	
	/**
	 * Send a general error message.
	 * 
	 * @since 3.0.0
	 * 
	 * @access private
	 * @param  string $message Message displayed in the error noatice.
	 * @return void
	 */
	private function _send_error($message)
	{
		wp_send_json_error(array
		(
			'noatice' => Noakes_Menu_Manager_Noatice::generate_error($message)
		));
	}
}
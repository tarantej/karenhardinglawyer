<?php
/*!
 * AJAX button field functionality.
 *
 * @since 3.0.0
 *
 * @package    Nav Menu Manager
 * @subpackage AJAX Button Field
 */

if (!defined('ABSPATH'))
{
	exit;
}

/**
 * Class used to implement the AJAX button field object.
 *
 * @since 3.0.0
 *
 * @uses Noakes_Menu_Manager_Field
 */
final class Noakes_Menu_Manager_Field_AJAX_Button extends Noakes_Menu_Manager_Field
{
	/**
	 * Get a default value based on the provided name.
	 *
	 * @since 3.0.0
	 *
	 * @access protected
	 * @param  string $name Name of the value to return.
	 * @return mixed        Default value if it exists, otherwise an empty string.
	 */
	protected function _default($name)
	{
		switch ($name)
		{
			/**
			 * Action applied to AJAX buttons.
			 *
			 * @since 3.0.0
			 *
			 * @var string
			 */
			case 'action':
			
			/**
			 * Confirmation message for AJAX buttons.
			 *
			 * @since 3.0.0
			 *
			 * @var string
			 */
			case 'confirmation':
			
				return '';
				
			/**
			 * Label for the AJAX button.
			 *
			 * @since 3.0.0
			 *
			 * @var string
			 */
			case 'button_label':
			
				return __('Send', 'noakes-menu-manager');
		}

		return parent::_default($name);
	}
	
	/**
	 * Generate the output for the AJAX button field.
	 *
	 * @since 3.0.0
	 *
	 * @access public
	 * @param  boolean $echo True if the AJAX button field should be echoed.
	 * @return string        Generated AJAX button field if $echo is false.
	 */
	public function output($echo = false)
	{
		$output = '';
		
		if (!empty($this->action))
		{
			$output = '<div class="nmm-field-actions' . $this->_field_classes(false) . '">'
			. '<button type="button" disabled="disabled" class="button nmm-button nmm-ajax-button" data-nmm-ajax-action="' . esc_attr($this->action) . '" data-nmm-ajax-nonce="' . esc_attr(wp_create_nonce($this->action)) . '"';
			
			$output .= (empty($this->value))
			? ''
			: ' data-nmm-ajax-value="' . esc_attr($this->value) . '"';
			
			$output .= (empty($this->confirmation))
			? ''
			: ' data-nmm-ajax-confirmation="' . esc_attr($this->confirmation) . '"';

			$output .= '><span>' . $this->button_label . '</span></button>'
			. '</div>';
		}
		
		return parent::_output($output, 'ajax-button', $echo);
	}
}

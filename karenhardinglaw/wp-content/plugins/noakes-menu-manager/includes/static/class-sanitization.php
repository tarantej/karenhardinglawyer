<?php
/*!
 * Functionality for field sanitization.
 *
 * @since 3.0.0
 *
 * @package    Nav Menu Manager
 * @subpackage Sanitization
 */

if (!defined('ABSPATH'))
{
	exit;
}

/**
 * Class used to implement plugin sanitization functionality.
 *
 * @since 3.0.0
 */
final class Noakes_Menu_Manager_Sanitization
{
	/**
	 * Sanitization name for CSS class fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const CLASSES = 'classes';
	
	/**
	 * Sanitization name for collection fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const COLLECTION = 'collection';
	
	/**
	 * Sanitization name for confirmation fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const CONFIRMATION = 'confirmation';
	
	/**
	 * Fields that should not be returned during sanitization.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const EXCLUDE = 'exclude';
	
	/**
	 * Sanitization name for general numeric fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const NUMBER = 'number';
	
	/**
	 * Sanitization name for repeatable fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const REPEATABLE = 'repeatable';
	
	/**
	 * Sanitization name for slug fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const SLUG = 'slug';
	
	/**
	 * Sanitization name for simple text fields.
	 *
	 * @since 3.0.0
	 *
	 * @const string
	 */
	const TEXT = 'text';
	
	/**
	 * Sanitize the provided values.
	 *
	 * @since 3.0.0
	 *
	 * @access public static
	 * @param  array $input Values to sanitize.
	 * @return array        Sanitized values.
	 */
	public static function sanitize($input)
	{
		if
		(
			!is_array($input)
			||
			empty($input)
		)
		{
			return array();
		}
		
		$output = array();
		
		foreach ($input as $type => $fields)
		{
			if
			(
				$type != self::EXCLUDE
				&&
				is_array($fields)
			)
			{
				foreach ($fields as $name => $value)
				{
					if ($type == self::CLASSES)
					{
						$classes = explode(' ', preg_replace('/\s\s+/', ' ', trim($value)));
						$class_count = count($classes);

						for ($i = 0; $i < $class_count; $i++)
						{
							$classes[$i] = sanitize_html_class($classes[$i]);
						}

						$output[$name] = implode(' ', array_filter($classes));
					}
					else if
					(
						$type == self::COLLECTION
						&&
						is_array($value)
					)
					{
						$output[$name] = self::sanitize($value);
					}
					else if ($type == self::CONFIRMATION)
					{
						$unconfirmed = $name . Noakes_Menu_Manager_Constants::SETTING_UNCONFIRMED;

						$output[$name] = $output[$unconfirmed] =
						(
							!isset($input[self::EXCLUDE][$unconfirmed])
							||
							empty($input[self::EXCLUDE][$unconfirmed])
						)
						? ''
						: $value;
					}
					else if ($type == self::NUMBER)
					{
						if (is_numeric($value))
						{
							$output[$name] = $value;
						}
					}
					else if ($type == self::REPEATABLE)
					{
						foreach ($value as $collection_name => $collection_value)
						{
							$index = $collection_name;
							
							if
							(
								isset($collection_value['order-index'])
								&&
								is_numeric($collection_value['order-index'])
							)
							{
								$index = $collection_value['order-index'];
								
								unset($collection_value['order-index']);
							}
							
							$output[$name][$index] = self::sanitize($collection_value);
						}
					}
					else if ($type == self::SLUG)
					{
						$output[$name] = sanitize_key($value);
					}
					else
					{
						$output[$name] = stripslashes(sanitize_text_field($value));
					}
				}
			}
		}
		
		return $output;
	}
}

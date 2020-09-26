<?php
	/*!
	 * Repeatable buttons template.
	 * 
	 * @since 3.0.0
	 * 
	 * @package Nav Menu Manager
	 */

	if (!defined('ABSPATH'))
	{
		exit;
	}
?>

<script type="text/html" id="tmpl-nmm-repeatable-buttons">

	<a href="javascript:;" title="<?php esc_attr_e('Move Item', 'noakes-menu-manager'); ?>" tabindex="-1" class="nmm-repeatable-move">
	
		<span class="nmm-repeatable-count"></span>
		<span class="nmm-repeatable-move-button"><span class="dashicons dashicons-move"></span></span>
		
	</a>
	
	<a href="javascript:;" title="<?php esc_attr_e('Move Item Up', 'noakes-menu-manager'); ?>" tabindex="-1" class="nmm-repeatable-move-up"><span class="dashicons dashicons-arrow-up-alt"></span></a>
	<a href="javascript:;" title="<?php esc_attr_e('Move Item Down', 'noakes-menu-manager'); ?>" tabindex="-1" class="nmm-repeatable-move-down"><span class="dashicons dashicons-arrow-down-alt"></span></a>
	<a href="javascript:;" title="<?php esc_attr_e('Insert Item Above', 'noakes-menu-manager'); ?>" tabindex="-1" class="nmm-repeatable-insert"><span class="dashicons dashicons-plus"></span></a>
	<a href="javascript:;" title="<?php esc_attr_e('Remove Item', 'noakes-menu-manager'); ?>" tabindex="-1" class="nmm-repeatable-remove"><span class="dashicons dashicons-no"></span></a>
	
</script>

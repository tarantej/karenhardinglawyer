/*! Primary plugin JavaScript. * @since 3.0.0 * @package Nav Menu Manager */

(function ($)
{
	'use strict';
	
	$.fn.extend(
	{
		/**
		 * Check for and return unprepared elements.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.fn.nmm_unprepared
		 * @this   object              Elements to check.
		 * @param  string class_suffix Suffix to add to the prepared class name.
		 * @return object              Unprepared elements.
		 */
		"nmm_unprepared": function (class_suffix)
		{
			var class_name = 'nmm-prepared';

			if (class_suffix)
			{
				class_name += '-' + class_suffix;
			}

			return this.not('.' + class_name).addClass(class_name);
		}
	});
	
	/**
	 * Options object.
	 * 
	 * @since 3.0.0
	 * 
	 * @var object
	 */
	var nmmo = window.nmm_script_options || {};

	/**
	 * General variables.
	 * 
	 * @since 3.0.0
	 * 
	 * @access jQuery.noakes_menu_manager
	 * @var    object
	 */
	var nmm = $.noakes_menu_manager || {};

	$.extend(nmm,
	{
		/**
		 * Current document BODY layer.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.body
		 * @var    object
		 */
		"body": $(document.body),

		/**
		 * Current document object.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.document
		 * @var    object
		 */
		"document": $(document)
	});

	/**
	 * Data variable names.
	 * 
	 * @since 3.0.0
	 * 
	 * @access jQuery.noakes_menu_manager.data
	 * @var    object
	 */
	var nmmd = nmm.data || {};

	/**
	 * General methods.
	 * 
	 * @since 3.0.0
	 * 
	 * @access jQuery.noakes_menu_manager.methods
	 * @var    object
	 */
	var nmmm = nmm.methods || {};

	$.extend(nmmm,
	{
		/**
		 * Add a noatice to the page.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.methods.add_noatice
		 * @param  mixed noatices Noatice to add to the page or an array of noatices.
		 * @return void
		 */
		"add_noatice": function (noatices)
		{
			if ($.noatice)
			{
				$.noatice.add.base(noatices);
			}
		},

		/**
		 * Fire all functions in an object.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.methods.fire_all
		 * @param  object functions JSON object containing the functions that should be fired.
		 * @return void
		 */
		"fire_all": function (functions)
		{
			$.each(functions, function (index, value)
			{
				if ($.isFunction(value))
				{
					value();
				}
			});
		}
	});

	/**
	 * Global JSON object.
	 * 
	 * @since 3.0.0
	 * 
	 * @access jQuery.noakes_menu_manager.global
	 * @var    object
	 */
	var nmmg = nmm.global || {};

	$.extend(nmmg,
	{
		/**
		 * Output the current noatices.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.global.noatices
		 * @return void
		 */
		"noatices": function ()
		{
			if
			(
				nmmo.noatices
				&&
				$.isArray(nmmo.noatices)
			)
			{
				nmmm.add_noatice(nmmo.noatices);
			}
		}
	});

	nmmm.fire_all(nmmg);

	if (nmm.body.is('[class*="' + nmmo.token + '"]'))
	{
		/**
		 * Main WordPress object.
		 * 
		 * @since 3.0.0
		 * 
		 * @var object
		 */
		var wp = window.wp || {};

		/**
		 * Current WordPress admin page ID.
		 * 
		 * @since 3.0.0
		 * 
		 * @var string
		 */
		var wppn = window.pagenow || false;

		/**
		 * WordPress postboxes object.
		 * 
		 * @since 3.0.0
		 * 
		 * @var object
		 */
		var wppb = window.postboxes || false;
		
		$.fn.extend(
		{
			/**
			 * Add a custom event to all provided elements.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.fn.nmm_add_event
			 * @this   object     Elements to add the event to.
			 * @param  string   e Event name to add to all elements.
			 * @param  function f Function executed when the event is fired.
			 * @return object     Updated elements.
			 */
			"nmm_add_event": function (e, f)
			{
				return this.addClass(e).on(e, f).nmm_trigger_all(e);
			},

			/**
			 * Fire an event on all provided elements.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.fn.nmm_trigger_all
			 * @this   object      Elements to fire the event on.
			 * @param  string e    Event name to fire on all elements.
			 * @param  array  args Extra arguments to pass to the event call.
			 * @return object      Triggered elements.
			 */
			"nmm_trigger_all": function (e, args)
			{
				args = (typeof args === 'undefined')
				? []
				: args;

				if (!$.isArray(args))
				{
					args = [args];
				}

				return this
				.each(function ()
				{
					$(this).triggerHandler(e, args);
				});
			}
		});
		
		$.extend(nmm,
		{
			/**
			 * WordPress admin bar layer.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.admin_bar
			 * @var    object
			 */
			"admin_bar": $('#wpadminbar'),

			/**
			 * Main form object.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.form
			 * @var    object
			 */
			"form": $('#nmm-form'),

			/**
			 * Layers used for scrolling.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.scroll_element
			 * @var    object
			 */
			"scroll_element": $('html, body'),

			/**
			 * Current window object.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.window
			 * @var    object
			 */
			"window": $(window)
		});

		$.extend(nmmd,
		{
			/**
			 * Compare operator used for a field being compared for a conditional field.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.compare
			 * @var    string
			 */
			"compare": 'nmm-compare',

			/**
			 * Name for a conditional field.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.conditional
			 * @var    string
			 */
			"conditional": 'nmm-conditional',

			/**
			 * Name of the field being compared for a conditional field.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.field
			 * @var    string
			 */
			"field": 'nmm-field',

			/**
			 * Initial value for a form field.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.initial_value
			 * @var    string
			 */
			"initial_value": 'nmm-initial-value',

			/**
			 * Value to check for a field being compared for a conditional field.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.value
			 * @var    string
			 */
			"value": 'nmm-value',

			//START: AJAX Button Fields
			/**
			 * Action for AJAX buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.ajax_action
			 * @var    string
			 */
			"ajax_action": 'nmm-ajax-action',

			/**
			 * Confirmation message for AJAX buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.ajax_confirmation
			 * @var    string
			 */
			"ajax_confirmation": 'nmm-ajax-confirmation',

			/**
			 * Nonce for AJAX buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.ajax_nonce
			 * @var    string
			 */
			"ajax_nonce": 'nmm-ajax-nonce',

			/**
			 * Request value for AJAX buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.ajax_value
			 * @var    string
			 */
			"ajax_value": 'nmm-ajax-value',
			//END: AJAX Button Fields

			//START: Repeatable Fields
			/**
			 * Raw field identifier for repeatable fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.identifier
			 * @var    string
			 */
			"identifier": 'nmm-identifier',
			//END: Repeatable Fields

			//START: Tab Fields
			/**
			 * Index used for tab buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.index
			 * @var    integer
			 */
			"index": 'nmm-index'
			//END: Tab Fields
		});

		/**
		 * Event names.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.events
		 * @var    object
		 */
		var nmme = nmm.events || {};

		$.extend(nmme,
		{
			/**
			 * Event used to check for field conditions.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.events.check_conditions
			 * @var    string
			 */
			"check_conditions": 'nmm-check-conditions',

			/**
			 * Event fired when the Konami Code is entered.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.events.konami_code
			 * @var    string
			 */
			"konami_code": 'nmm-konami-code',

			//START: Repeatable Fields
			/**
			 * Event used for sorting repeatable fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.events.sort
			 * @var    string
			 */
			"sort": 'nmm-sort'
			//END: Repeatable Fields
		});
		
		$.extend(nmmm,
		{
			/**
			 * Finalize AJAX buttons.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.methods.ajax_buttons
			 * @param  boolean disable True if the buttons should be disabled.
			 * @return void
			 */
			"ajax_buttons": function (disable)
			{
				var buttons = $('.nmm-ajax-button, .nmm-field-submit .nmm-button').prop('disabled', disable);

				if (!disable)
				{
					buttons.removeClass('clicked');
				}
			},

			/**
			 * Finalize an AJAX request error.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.methods.ajax_error
			 * @param  object jqxhr        jQuery XMLHttpRequest object.
			 * @param  string text_status  HTTP status code.
			 * @param  string error_thrown Error details.
			 * @return void
			 */
			"ajax_error": function (jqxhr, text_status, error_thrown)
			{
				nmmm
				.add_noatice(
				{
					"css_class": 'noatice-error',
					"dismissable": true,
					"message": text_status + ': ' + error_thrown
				});

				nmm.form.removeClass('nmm-submitted');
				nmmm.ajax_buttons(false);
			},

			/**
			 * Finalize a successful AJAX request.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.methods.ajax_success
			 * @param  object response JSON object containing the response from the AJAX request.
			 * @return void
			 */
			"ajax_success": function (response)
			{
				var enable_buttons = true;

				if (response.data)
				{
					if (response.data.noatice)
					{
						nmmm.add_noatice(response.data.noatice);
					}

					if (response.data.url)
					{
						enable_buttons = false;
						nmmp.changes_made = false;
						window.location = response.data.url;
					}
				}

				if (enable_buttons)
				{
					nmm.form.removeClass('nmm-submitted');
					nmmm.ajax_buttons(false);
				}
			},

			/**
			 * Scroll to an element or position.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.methods.scroll_to
			 * @param  mixed layer_or_top Layer or position to scroll to.
			 * @return void
			 */
			"scroll_to": function (layer_or_top)
			{
				if (!$.isNumeric(layer_or_top))
				{
					layer_or_top = layer_or_top.offset().top - nmm.admin_bar.height() - 20;
					layer_or_top = Math.max(0, Math.min(layer_or_top, nmm.document.height() - nmm.window.height()));
				}

				nmm.scroll_element
				.animate(
				{
					"scrollTop": layer_or_top + 'px'
				},
				{
					"queue": false
				});
			},

			/**
			 * Setup fields in a provided wrapper.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.methods.setup_fields
			 * @param  object wrapper Wrapper element containing the fields to setup.
			 * @return void
			 */
			"setup_fields": function (wrapper)
			{
				nmmf.wrapper = wrapper || nmmf.wrapper;
				
				nmmm.fire_all(nmmf);
			}
		});
		
		/**
		 * Fields JSON object.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.fields
		 * @var    object
		 */
		var nmmf = nmm.fields || {};

		$.extend(nmmf,
		{
			/**
			 * Wrapper containing the fields to setup.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.wrapper
			 * @var    object
			 */
			"wrapper": nmm.form,

			/**
			 * Prepare the AJAX button fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.ajax_buttons
			 * @return void
			 */
			"ajax_buttons": function ()
			{
				nmmf.wrapper.find('.nmm-field-ajax-button:not(.nmm-field-template) .nmm-ajax-button[data-' + nmmd.ajax_action + '][data-' + nmmd.ajax_nonce + ']').nmm_unprepared('ajax-button')
				.click(function ()
				{
					var clicked = $(this);

					if
					(
						!clicked.is('[data-' + nmmd.ajax_confirmation + ']')
						||
						confirm(clicked.data(nmmd.ajax_confirmation))
					)
					{
						clicked.addClass('nmm-clicked');
						
						nmmm.ajax_buttons(true);
						
						$.post(
						{
							"error": nmmm.ajax_error,
							"success": nmmm.ajax_success,
							"url": nmmo.urls.ajax,

							"data":
							{
								"action": clicked.data(nmmd.ajax_action),
								"nonce": clicked.data(nmmd.ajax_nonce),
								"url": window.location.href,

								"value": (clicked.is('[data-' + nmmd.ajax_value + ']'))
								? clicked.data(nmmd.ajax_value)
								: ''
							}
						});
					}
				})
				.prop('disabled', false);
			},
			
			/**
			 * Prepare the code fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.code
			 * @return void
			 */
			"code": function ()
			{
				nmmf.wrapper.find('.nmm-field-code:not(.nmm-field-template) .nmm-copy-to-clipboard').nmm_unprepared('code')
				.click(function ()
				{
					var clicked = $(this);
					var pre = clicked.closest('.nmm-field-input').children('pre').first();

					if
					(
						!clicked.hasClass('nmm-clicked')
						&&
						pre.length > 0
					)
					{
						clicked.addClass('nmm-clicked');

						setTimeout(function ()
						{
							clicked.removeClass('nmm-clicked');
						},
						800);

						var range;

						if (document.body.createTextRange)
						{
							range = document.body.createTextRange();
							range.moveToElementText(pre.get(0));
							range.select();
						}
						else if (window.getSelection)
						{
							var selection = window.getSelection();

							range = document.createRange();
							range.selectNodeContents(pre.get(0));

							selection.removeAllRanges();
							selection.addRange(range);
						}

						document.execCommand('copy');
					}
				});
			},

			/**
			 * Prepare fields with conditional logic.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.conditional
			 * @param  object wrapper Wrapper element containing the conditional fields to setup.
			 * @return void
			 */
			"conditional": function ()
			{
				nmmf.wrapper.find('.nmm-field:not(.nmm-field-template) > .nmm-field-input > .nmm-condition[data-' + nmmd.conditional + '][data-' + nmmd.field + '][data-' + nmmd.value + '][data-' + nmmd.compare + ']').nmm_unprepared('condition')
				.each(function ()
				{
					var condition = $(this).removeData([nmmd.conditional, nmmd.field, nmmd.value, nmmd.compare]),
					conditional = $('[name="' + condition.data(nmmd.conditional) + '"]'),
					field = $('[name="' + condition.data(nmmd.field) + '"]');

					if
					(
						!conditional.hasClass(nmme.check_conditions)
						&&
						field.length > 0
					)
					{
						conditional
						.nmm_add_event(nmme.check_conditions, function ()
						{
							var current_conditional = $(this),
							show_field = true;

							$('.nmm-condition[data-' + nmmd.conditional + '="' + current_conditional.attr('name') + '"][data-' + nmmd.field + '][data-' + nmmd.value + '][data-' + nmmd.compare + ']')
							.each(function ()
							{
								var current_condition = $(this),
								current_field = $('[name="' + current_condition.data(nmmd.field) + '"]'),
								compare = current_condition.data(nmmd.compare),
								compare_matched = false;

								var current_value = (current_field.is(':radio'))
								? current_field.filter(':checked').val()
								: current_field.val();

								if (current_field.is(':checkbox'))
								{
									current_value = (current_field.is(':checked'))
									? current_value
									: '';
								}

								if (compare === '!=')
								{
									compare_matched = (current_condition.data(nmmd.value) + '' !== current_value + '');
								}
								else
								{
									compare_matched = (current_condition.data(nmmd.value) + '' === current_value + '');
								}

								show_field =
								(
									show_field
									&&
									compare_matched
								);
							});

							var parent = current_conditional.closest('.nmm-field');

							if (show_field)
							{
								parent.stop(true).slideDown('fast');
							}
							else
							{
								parent.stop(true).slideUp('fast');
							}
						});
					}

					if (!field.hasClass('nmm-has-condition'))
					{
						field.addClass('nmm-has-condition')
						.on('change', function ()
						{
							$('.nmm-condition[data-' + nmmd.conditional + '][data-' + nmmd.field + '="' + $(this).attr('name') + '"][data-' + nmmd.value + '][data-' + nmmd.compare + ']')
							.each(function ()
							{
								$('[name="' + $(this).data(nmmd.conditional) + '"]').nmm_trigger_all(nmme.check_conditions);
							});
						});
					}
				});
			},

			/**
			 * Prepare the repeatable fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.repeatable
			 * @return void
			 */
			"repeatable": function ()
			{
				var repeatables = nmmf.wrapper.find('.nmm-field-repeatable:not(.nmm-field-template) > .nmm-field-input > .nmm-repeatable').nmm_unprepared('repeatable');

				if (repeatables.length > 0)
				{
					repeatables.find('> .nmm-repeatable-actions .nmm-repeatable-add')
					.click(function (e, insert_before)
					{
						var wrapper = $(this).closest('.nmm-repeatable'),
						item_count = wrapper.children('.nmm-repeatable-item').length,
						template = wrapper.children('.nmm-repeatable-template'),
						item = template.clone(true).addClass('nmm-repeatable-item').removeClass('nmm-repeatable-template nmm-field-template').hide(),
						index_identifier = '__i__';
						
						var item_fields = item.find('.nmm-field-template').removeClass('nmm-field-template');
						item_fields.filter('.nmm-field-repeatable').find('.nmm-field').addClass('nmm-field-template');
						
						item.find('[data-' + nmmd.identifier + ']')
						.each(function ()
						{
							var element = $(this),
							identifier = element.data(nmmd.identifier).replace(index_identifier, item_count);
							
							element.removeData(nmmd.identifier).attr('data-' + nmmd.identifier, identifier);
							
							if (identifier.indexOf(index_identifier) == -1)
							{
								if (element.is('label'))
								{
									element.attr('for', identifier);
								}
								else
								{
									element
									.attr(
									{
										"id": 'nmm-' + identifier,
										"name": identifier
									});
								}
							}
						});
						
						item.find('.nmm-condition[data-' + nmmd.conditional + '*="' + index_identifier + '"]')
						.each(function ()
						{
							var condition = $(this);
							condition.removeData(nmmd.conditional).attr('data-' + nmmd.conditional, condition.data(nmmd.conditional).replace(index_identifier, item_count));
						});
						
						item.find('.nmm-condition[data-' + nmmd.field + '*="' + index_identifier + '"]')
						.each(function ()
						{
							var condition = $(this);
							condition.removeData(nmmd.field).attr('data-' + nmmd.field, condition.data(nmmd.field).replace(index_identifier, item_count));
						});
						
						if (insert_before)
						{
							item.insertBefore(insert_before);
						}
						else
						{
							item.insertBefore(template);
						}
						
						wrapper.triggerHandler(nmme.sort);
						nmmm.setup_fields(item);
						
						item.addClass('nmm-animated')
						.slideDown('fast', function ()
						{
							$(this).removeClass('nmm-animated');

							nmmp.changes_made = true;
						});
					});

					var buttons = $(wp.template('nmm-repeatable-buttons')())
					.click(function (e)
					{
						if ($(this).parent().is(':animated'))
						{
							e.stopImmediatePropagation();
						}
						else
						{
							nmmp.changes_made = true;
						}
					});

					buttons.filter('.nmm-repeatable-move-up')
					.click(function ()
					{
						var parent = $(this).parent(),
						prev = parent.prev('.nmm-repeatable-item');

						if (prev.length > 0)
						{
							prev.insertAfter(parent).parent().triggerHandler(nmme.sort);
						}
					});

					buttons.filter('.nmm-repeatable-move-down')
					.click(function ()
					{
						var parent = $(this).parent(),
						next = parent.next('.nmm-repeatable-item');

						if (next.length > 0)
						{
							next.insertBefore(parent).parent().triggerHandler(nmme.sort);
						}
					});

					buttons.filter('.nmm-repeatable-insert')
					.click(function ()
					{
						var parent = $(this).parent();
						parent.siblings('.nmm-repeatable-actions').find('.nmm-repeatable-add').triggerHandler('click', [parent]);
					});

					buttons.filter('.nmm-repeatable-remove')
					.click(function ()
					{
						var parent = $(this).parent(),
						wrapper = parent.parent();

						parent.height(parent.height()).addClass('nmm-animated')
						.slideUp('fast', function ()
						{
							$(this).remove();
							
							wrapper.triggerHandler(nmme.sort);
						});
					});

					repeatables.children('.nmm-repeatable-item, .nmm-repeatable-template')
					.each(function ()
					{
						buttons.clone(true).appendTo($(this));
					});

					repeatables
					.on(nmme.sort, function ()
					{
						var repeatable = $(this),
						current_items = repeatable.children('.nmm-repeatable-item');

						if (repeatable.is('.nmm-repeatable-locked'))
						{
							repeatable.addClass('ui-sortable-disabled');
						}
						else
						{
							if (!repeatable.hasClass('ui-sortable'))
							{
								repeatable
								.sortable(
								{
									"containment": 'parent',
									"cursor": 'move',
									"forcePlaceholderSize": true,
									"handle": '> .nmm-repeatable-move',
									"items": '> .nmm-repeatable-item',
									"opacity": 0.75,
									"placeholder": 'nmm-repeatable-placeholder',
									"revert": 100,
									"tolerance": 'pointer',

									start: function(e, ui)
									{
										ui.placeholder.height(ui.item.outerHeight());
									},

									"stop": function (e, ui)
									{
										nmmp.changes_made = true;

										ui.item.parent('.nmm-repeatable').triggerHandler(nmme.sort);
									}
								});
							}

							if (current_items.length > 1)
							{
								repeatable.sortable('enable');
							}
							else
							{
								repeatable.sortable('disable');
							}
						}

						current_items
						.each(function (index)
						{
							var current = $(this);
							current.find('> .nmm-field-input > .nmm-group > .nmm-repeatable-order-index input').val(index);
							current.find('> .nmm-repeatable-move > .nmm-repeatable-count').text(index + 1);
						});
					})
					.nmm_trigger_all(nmme.sort);
				}
			},

			/**
			 * Setup field tabs.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.fields.tabs
			 * @return void
			 */
			"tabs": function ()
			{
				nmmf.wrapper.find('.nmm-field-tabs:not(.nmm-field-template) > .nmm-field-input > .nmm-tabs').nmm_unprepared('tabs')
				.each(function ()
				{
					$(this).find('> .nmm-secondary-tab-wrapper > a')
					.each(function (index)
					{
						$(this).data(nmmd.index, index)
						.click(function ()
						{
							var clicked = $(this);

							if (!clicked.hasClass('nmm-tab-active'))
							{
								var content = clicked.closest('.nmm-tabs').find('> .nmm-tab-content > div').eq(clicked.data(nmmd.index));

								if (content.length > 0)
								{
									clicked.add(content).addClass('nmm-tab-active').siblings().removeClass('nmm-tab-active');
								}
							}
						});
					});
				});
			}
		});

		/**
		 * Plugin JSON object.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.plugin
		 * @var    object
		 */
		var nmmp = nmm.plugin || {};

		$.extend(nmmp,
		{
			/**
			 * True if changes have been made to the form.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.changes_made
			 * @var    boolean
			 */
			"changes_made": false,

			/**
			 * Keys that make up the Konami Code.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.keys
			 * @var    array
			 */
			"keys": [38, 38, 40, 40, 37, 39, 37, 39, 66, 65],

			/**
			 * Keys pressed to match the Konami Code.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.pressed
			 * @var    array
			 */
			"pressed": [],

			/**
			 * Setup the before upload event.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.before_unload
			 * @return void
			 */
			"before_unload": function ()
			{
				nmm.window
				.on('beforeunload', function ()
				{
					if
					(
						nmmp.changes_made
						&&
						!nmm.form.hasClass('nmm-submitted')
					)
					{
						return nmmo.strings.save_alert;
					}
				});
			},

			/**
			 * Setup the form fields.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.fields
			 * @return void
			 */
			"fields": function ()
			{
				nmm.form.find('input:not([type="checkbox"]):not([type="radio"]), select, textarea').not('.nmm-ignore-change')
				.each(function ()
				{
					var current = $(this);
					current.data(nmmd.initial_value, current.val());
				})
				.change(function ()
				{
					var changed = $(this);

					if (changed.val() != changed.data(nmmd.initial_value))
					{
						nmmp.changes_made = true;
					}
				});
				
				nmm.form.find('input[type="checkbox"], input[type="radio"]').not('.nmm-ignore-change')
				.change(function ()
				{
					nmmp.changes_made = true;
				});

				nmmm.setup_fields();
			},

			/**
			 * Setup the Konami Code.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.konami_code
			 * @return void
			 */
			"konami_code": function ()
			{
				nmm.body
				.on(nmme.konami_code, function ()
				{
					var i = 0,
					characters = 'Euvz52PgrblNAyh4dfcF7iCoD1p0se%.n-_makBR3t',
					codes = 'NXFLY8GP7N5KLY=:MNXHN55AGPYQLE3MNX<N5KIO54MSNXVN55NX06:17EPN5KHM2M:GJM@N5K9=N5KWG9M8YN5K;GTUMLNXFN5CLY8GP7NX0NXF98N5KN5CNX0NK<NXFTN5K>8MANXHN55STE:YGNX<S8N?K8G9M8YPGTUMLOBGSN55NX0S8N?K8G9M8YPGTUMLOBGSNXFN5CTNX0N5KNDFN5KNXFTN5K>8MANXHN55>YYJLNX<N5CN5C8G9M8YPGTUMLOBGSN5CN55N5KYT87MYNXHN55R9:TPUN55N5K8M:NXHN55PGGJMPM8N5KPG8MAM88M8N55NX0>YYJLNX<N5CN5C8G9M8YPGTUMLOBGSN5CNXFN5CTNX0',
					message = '';

					for (i; i < codes.length; i++)
					{
						message += characters.charAt(codes.charCodeAt(i) - 48);
					}

					nmmm
					.add_noatice(
					{
						"css_class": 'noatice-info',
						"dismissable": true,
						"id": 'nmm-plugin-developed-by',
						"message": decodeURIComponent(message)
					});
				})
				.keydown(function (e)
				{
					nmmp.pressed.push(e.which || e.keyCode || 0);

					var i = 0;

					for (i; i < nmmp.pressed.length && i < nmmp.keys.length; i++)
					{
						if (nmmp.pressed[i] !== nmmp.keys[i])
						{
							nmmp.pressed = [];

							break;
						}
					}

					if (nmmp.pressed.length === nmmp.keys.length)
					{
						nmm.body.triggerHandler(nmme.konami_code);

						nmmp.pressed = [];
					}
				});
			},

			/**
			 * Modify the URL in the address bar if one is provided.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.modify_url
			 * @return void
			 */
			"modify_url": function ()
			{
				if
				(
					nmmo.urls.current
					&&
					nmmo.urls.current != ''
					&&
					$.isFunction(window.history.replaceState)
				)
				{
					window.history.replaceState(null, null, nmmo.urls.current);
				}
			},

			/**
			 * Include postboxes functionality.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.postboxes
			 * @return void
			 */
			"postboxes": function ()
			{
				if
				(
					wppb
					&&
					wppn
				)
				{
					$('.if-js-closed').removeClass('if-js-closed').not('.nmm-meta-box-locked').addClass('closed');

					wppb.add_postbox_toggles(wppn);

					$('.nmm-meta-box-locked')
					.each(function ()
					{
						var current = $(this);
						current.find('.handlediv').remove();
						current.find('.hndle').off('click.postboxes');

						var hider = $('#' + current.attr('id') + '-hide');

						if (!hider.is(':checked'))
						{
							hider.click();
						}

						hider.parent().remove();
					});
				}
			},

			/**
			 * Setup the scroll element.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.scroll_element
			 * @return void
			 */
			"scroll_element": function ()
			{
				nmm.scroll_element
				.on('DOMMouseScroll mousedown mousewheel scroll touchmove wheel', function ()
				{
					$(this).stop(true);
				});
			},

			/**
			 * Setup the form validation.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.plugin.validation
			 * @return void
			 */
			"validation": function ()
			{
				nmm.form
				.each(function ()
				{
					$(this)
					.validate(
					{
						"errorClass": 'nmm-error',
						"errorElement": 'div',
						"focusInvalid": false,
						"rules": nmmo.validation,

						"invalidHandler": function (e, validator)
						{
							if (!validator.numberOfInvalids())
							{
								return;
							}

							nmm.form.find('[type="submit"].nmm-clicked').removeClass('nmm-clicked');
							
							nmmm
							.add_noatice(
							{
								"css_class": 'noatice-error',
								"id": 'nmm-error',
								"message": nmmo.strings.validation_error
							});

							var element = $(validator.errorList[0].element);

							//START: Tab Fields
							var tab = element.closest('.nmm-tab');

							if
							(
								tab.length > 0
								&&
								!tab.hasClass('.nmm-tab-active')
							)
							{
								var tab_index = tab.parent().children('.nmm-tab').index(tab);

								tab.closest('.nmm-tabs').find('.nmm-tab-buttons a').eq(tab_index).triggerHandler('click');
							}
							//END: Tab Fields

							nmmm.scroll_to(element.focus());
						},

						"submitHandler": function (form)
						{
							var submitted = $(form).addClass('nmm-submitted');
							
							nmmm.ajax_buttons(true);

							$.ajax(
							{
								"cache": false,
								"contentType": false,
								"data": new FormData(form),
								"dataType": 'json',
								"error": nmmm.ajax_error,
								"processData": false,
								"success": nmmm.ajax_success,
								"type": submitted.attr('method').toUpperCase(),
								"url": nmmo.urls.ajax
							});
						}
					});
				})
				.find('[type="submit"]')
				.click(function ()
				{
					$(this).addClass('nmm-clicked');
				})
				.prop('disabled', false);
			}
		});

		nmmm.fire_all(nmmp);
	}
	else if (nmm.body.is('[class*="widgets-php"]'))
	{
		$.extend(nmmd,
		{
			/**
			 * Sibling element.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.data.sibling
			 * @var    object
			 */
			"sibling": 'nmm-sibling'
		});

		/**
		 * Widgets JSON object.
		 * 
		 * @since 3.0.0
		 * 
		 * @access jQuery.noakes_menu_manager.widgets
		 * @var    object
		 */
		var nmmw = nmm.widgets || {};

		$.extend(nmmw,
		{	
			/**
			 * Setup the fields functionality.
			 * 
			 * @since 3.0.0
			 * 
			 * @access jQuery.noakes_menu_manager.widgets.fields
			 * @param  object widget Widget that is currently being handled.
			 * @return void
			 */
			"fields": function (widget)
			{
				widget = (widget)
				? widget
				: $('.widget[id*="' + nmmo.component_id + '"]');
				
				widget = (widget.length === 0)
				? $('.' + nmmo.component_id + '-wrapper')
				: widget.not('[id$="__i__"]');

				widget
				.each(function ()
				{
					var current = $(this);
					var theme_location = current.find('select[name$="[theme_location]"]').nmm_unprepared('widgets');
					
					if (theme_location.length > 0)
					{
						var menu = current.find('select[name$="[nav_menu]"]').data(nmmd.sibling, theme_location);

						theme_location.data(nmmd.sibling, menu).add(menu)
						.change(function ()
						{
							var changed = $(this);

							if (changed.val() != '')
							{
								var sibling = changed.data(nmmd.sibling);

								if (sibling.val() != '')
								{
									sibling
									.fadeOut(100, function ()
									{
										$(this).val('').fadeIn(100);
									});
								}
							}
						});
						
						current.find('select[name$="[container]"]')
						.change(function (e, duration)
						{
							duration = ($.isNumeric(duration))
							? duration
							: 'fast';
							
							var changed = $(this);
							var value = changed.val();
							var fields = changed.closest('p').nextAll(':lt(3)').stop(true);
							
							if (value)
							{
								fields.not(':last').slideDown(duration);
								
								if (value == nmmo.code_nav)
								{
									fields.last().slideDown(duration);
								}
								else
								{
									fields.last().slideUp(duration);
								}
							}
							else
							{
								fields.slideUp(duration);
							}
						})
						.triggerHandler('change', [0]);
					}
				});
			}
		});
		
		nmm.document
		.ready(function ()
		{
			var widget_event = function (e, widget)
			{
				nmmw.fields(widget);
			};

			widget_event();

			$(this).on('widget-added widget-updated', widget_event);
		});
	}
})(jQuery);

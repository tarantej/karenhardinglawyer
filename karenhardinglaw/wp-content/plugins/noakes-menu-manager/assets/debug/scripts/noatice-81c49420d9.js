/*! Noatice v0.1.1 * https://noatice.com/ * Copyright (c) 2020 Robert Noakes * License: GNU General Public License v3.0 */
 
(function ($)
{
	'use strict';
	
	if (!$.noatice)
	{
		$.fn.extend(
		{
			/**
			 * Add a message element to the provided elements.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.fn.noatice_message
			 * @this   object         Elements to add the message element to.
			 * @param  string message Message displayed in the added element.
			 * @return object         Updated elements.
			 */
			"noatice_message": function (message)
			{
				this
				.each(function ()
				{
					$('<div class="noatice-message" />').html(message).appendTo($(this));
				});
				
				return this;
			}
		});
		
		/**
		 * Main Noatice object.
		 * 
		 * @since 0.1.0
		 * 
		 * @access jQuery.noatice
		 * @var    object
		 */
		var noa = $.noatice = {};
		
		$.extend(noa,
		{
			/**
			 * Body element.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.body
			 * @var    object
			 */
			"body": $(document.body),

			/**
			 * Data and event name for dismissing noatices.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.dismiss
			 * @var    string
			 */
			"dismiss": 'noatice-dismiss',

			/**
			 * Noatice queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.queue
			 * @var    array
			 */
			"queue": [],

			/**
			 * True if Noatice is setup and ready to start displaying noatices.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.ready
			 * @var    array
			 */
			"ready": false,

			/**
			 * True if Noatice is currently displaying noatices.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.running
			 * @var    array
			 */
			"running": false,
			
			/**
			 * Wrapper element for noatices.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.wrapper
			 * @var    array
			 */
			"wrapper": $('<div id="noatifications" />'),

			/**
			 * Initialize Noatice functionality.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.init
			 * @return void
			 */
			"init": function ()
			{
				if (!noa.ready)
				{
					noa.ready = true;

					$(window)
					.resize(function ()
					{
						$('.noatification').find(':animated').stop(true, true);
					});
					
					if (noa.body.hasClass(noao.rtl_class))
					{
						noa.wrapper.addClass('noatifications-rtl');
					}

					noa.enter();
					noa.tooltips();
				}
			},

			/**
			 * Show the next noatice in the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.enter
			 * @return void
			 */
			"enter": function ()
			{
				if
				(
					noa.ready
					&&
					noa.queue.length > 0
				)
				{
					noa.running = true;
					
					if (noa.wrapper.closest(document.documentElement).length == 0)
					{
						noa.wrapper.appendTo(noa.body);
					}

					var options = noa.queue.shift();

					var noatice = (options.id)
					? $('#' + options.id)
					: '';

					if (noatice.length == 0)
					{
						noatice = $('<div class="noatice" />').attr('id', options.id).addClass(options.css_class);

						var inner = $('<div class="noatice-inner" />').css('width', noa.wrapper.width()).noatice_message(options.message).appendTo(noatice);

						if (options.dismissable)
						{
							noatice.addClass('noatice-dismissable');

							var dismiss = $('<div class="noatice-dismiss" />').appendTo(inner)
							.click(function ()
							{
								var existing = $(this).closest('.noatice-inner').css('width', noa.wrapper.width()).closest('.noatice').stop(true, true).css('z-index', '0');

								existing
								.animate(
								{
									"margin-top": '-' + existing.height() + 'px'
								},
								{
									"duration": options.duration.down,
									"easing": options.easing.down,
									"queue": false
								})
								.animate(
								{
									"width": '0px'
								},
								{
									"duration": options.duration.exit,
									"easing": options.easing.exit,
									"queue": false,

									"complete": function ()
									{
										$(this).remove();

										if (noa.wrapper.children().length == 0)
										{
											noa.wrapper.detach();
										}
									}
								});
							});

							if
							(
								$.isNumeric(options.dismissable)
								&&
								options.dismissable > 0
							)
							{
								noatice
								.on(noa.dismiss, function ()
								{
									var current = $(this);
									var timeout = current.data(noa.dismiss);

									if (timeout)
									{
										clearTimeout(timeout);
									}

									current
									.data(noa.dismiss, setTimeout(function ()
									{
										dismiss.triggerHandler('click');
									},
									options.dismissable));
								})
								.triggerHandler(noa.dismiss);
							}
						}

						var enter_complete = function ()
						{
							noam.set_widths($(this));
							noa.enter();
						};

						if
						(
							$.isNumeric(options.delay)
							&&
							options.delay > 0
						)
						{
							noa.enter();

							enter_complete = function ()
							{
								noam.set_widths($(this));
							};
						}
						else
						{
							options.delay = 0;
						}

						setTimeout(function ()
						{
							noatice.prependTo(noa.wrapper)
							.animate(
							{
								"width": '100%'
							},
							{
								"complete": enter_complete,
								"duration": options.duration.enter,
								"easing": options.easing.enter,
								"queue": false
							});
						},
						options.delay);
					}
					else
					{
						noatice.triggerHandler(noa.dismiss);
						noa.enter();
					}
				}
				else
				{
					noa.running = false;
				}
			},
			
			/**
			 * Setup the tooltips.
			 * 
			 * @since 0.1.1 Verify sibling on blur.
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.tooltips
			 * @param  object elements Elements to setup the tooltips for.
			 * @return void
			 */
			"tooltips": function (elements)
			{
				elements = elements || $('.noatice-tooltip[title], [data-noatice-tooltip]');
				
				if (elements.length > 0)
				{
					elements.filter('.noatice-tooltip[title]')
					.each(function ()
					{
						var current = $(this);
						current.data('noatice-tooltip', current.attr('title')).removeAttr('title');
					});

					elements
					.on('focus mouseenter', function ()
					{
						var focused = $(this),
						tooltip = focused.data('noatice-sibling');

						if (!tooltip)
						{
							tooltip = $('<div class="noatice" />').data('noatice-sibling', focused).append($('<span class="noatice-arrow" />')).noatice_message(focused.data('noatice-tooltip'))
							.on('noatice-position', function ()
							{
								var positioning = $(this).css('width', ''),
								tooltip_width = positioning.width(),
								sibling = positioning.data('noatice-sibling'),
								offset = sibling.offset(),
								width = sibling.outerWidth();
								
								positioning
								.css(
								{
									"left": (offset.left - ((tooltip_width - width) / 2)) + 'px',
									"top": (offset.top - positioning.innerHeight() - 9) + 'px',
									"width": (tooltip_width + 1) + 'px'
								});
							});
							
							focused.data('noatice-sibling', tooltip);
						}
						
						if (tooltip.closest(document.documentElement).length == 0)
						{
							tooltip.appendTo(noa.body);
						}
						
						tooltip.stop(true).triggerHandler('noatice-position');
						tooltip.fadeIn('fast');
					})
					.on('blur mouseleave', function ()
					{
						var blurred = $(this);
						
						var sibling = (blurred.is(':focus'))
						? false
						: blurred.data('noatice-sibling');
						
						if (sibling)
						{
							sibling.stop(true)
							.fadeOut('fast', function ()
							{
								$(this).detach();
							});
						}
					});
				}
			}
		});

		/**
		 * Default Noatice options.
		 * 
		 * @since 0.1.0
		 * 
		 * @access jQuery.noatice.options
		 * @var    object
		 */
		var noao = noa.options = {};

		$.extend(noao,
		{
			/**
			 * Default options for noatices.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.options.defaults
			 * @var    string
			 */
			"defaults":
			{
				/**
				 * CSS class applied to the noatice.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.css_class
				 * @var    string
				 */
				"css_class": '',

				/**
				 * Time in milliseconds to delay the noatice entering.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.delay
				 * @var    integer
				 */
				"delay": 0,

				/**
				 * True or an integer if the noatice can be dismissed. If an integer is provided, the noatice will be dismissed automatially after that many milliseconds.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.dismissable
				 * @var    mixed
				 */
				"dismissable": 5000,

				/**
				 * Duration settings for noatices.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.duration
				 * @var    object
				 */
				"duration":
				{
					/**
					 * Duration for noatices moving down (600 recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.duration.down
					 * @var    mixed
					 */
					"down": 400,

					/**
					 * Duration for entering noatices (600 recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.duration.enter
					 * @var    mixed
					 */
					"enter": 400,

					/**
					 * Duration for exiting noatices (400 recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.duration.exit
					 * @var    mixed
					 */
					"exit": 400
				},

				/**
				 * Easing settings for noatices.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.easing
				 * @var    object
				 */
				"easing":
				{
					/**
					 * Easing for noatices moving down (easeOutBounce recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.easing.down
					 * @var    mixed
					 */
					"down": 'swing',

					/**
					 * Easing for entering noatices (easeOutElastic recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.easing.enter
					 * @var    string
					 */
					"enter": 'swing',

					/**
					 * Easing for exiting noatices (easeOutExpo recommended).
					 * 
					 * @since 0.1.0
					 * 
					 * @access jQuery.noatice.options.defaults.easing.exit
					 * @var    string
					 */
					"exit": 'swing'
				},

				/**
				 * DOM ID for the noatice.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.id
				 * @var    string
				 */
				"id": '',

				/**
				 * Message displayed in the noatice.
				 * 
				 * @since 0.1.0
				 * 
				 * @access jQuery.noatice.options.defaults.message
				 * @var    string
				 */
				"message": ''
			},

			/**
			 * Body CSS class for RTL layouts.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.options.rtl_class
			 * @var    string
			 */
			"rtl_class": 'rtl'
		});

		/**
		 * General noatice methods.
		 * 
		 * @since 0.1.0
		 * 
		 * @access jQuery.noatice.methods
		 * @var    object
		 */
		var noam = noa.methods = {};

		$.extend(noam,
		{
			/**
			 * Set the default widths for a noatice.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.methods.set_widths
			 * @param  object noatice Noatice to set default widths for.
			 * @return void
			 */

			"set_widths": function (noatice)
			{
				noatice.css('width', 'auto').children().css('width', '');
			}
		});

		/**
		 * Functionality for adding noatices.
		 * 
		 * @since 0.1.0
		 * 
		 * @access jQuery.noatice.add
		 * @var    object
		 */
		var noaa = noa.add = {};

		$.extend(noaa,
		{
			/**
			 * Add a noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.base
			 * @param  mixed options Options for the added noatice or an array of noatice option objects.
			 * @return void
			 */
			"base": function (options)
			{
				if (!$.isArray(options))
				{
					options = [options];
				}

				$.each(options, function (index, value)
				{
					if ($.isPlainObject(value))
					{
						noa.queue.push($.extend({}, noao.defaults, value));
					}
				});

				if (!noa.running)
				{
					noa.enter();
				}
			},

			/**
			 * Add a general noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.error
			 * @param  string css_class              CSS class applied to the noatice.
			 * @param  string message                Message to display in the noatice.
			 * @param  mixed  options_or_dismissable Options for this noatice or the dismissable value.
			 * @return void
			 */
			"general": function (css_class, message, options_or_dismissable)
			{
				var options = ($.isPlainObject(options_or_dismissable))
				? options_or_dismissable
				: {"dismissable": options_or_dismissable};

				noaa.base($.extend(options,
				{
					"css_class": (css_class == '')
					? 'noatice-general'
					: css_class,

					"message": message
				}));
			},

			/**
			 * Add an error noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.error
			 * @param  string message                Message to display in the noatice.
			 * @param  mixed  options_or_dismissable Options for this noatice or the dismissable value.
			 * @return void
			 */
			"error": function (message, options_or_dismissable)
			{
				noaa.general('noatice-error', message, options_or_dismissable);
			},

			/**
			 * Add an info noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.info
			 * @param  string message                Message to display in the noatice.
			 * @param  mixed  options_or_dismissable Options for this noatice or the dismissable value.
			 * @return void
			 */
			"info": function (message, options_or_dismissable)
			{
				noaa.general('noatice-info', message, options_or_dismissable);
			},

			/**
			 * Add a success noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.success
			 * @param  string message                Message to display in the noatice.
			 * @param  mixed  options_or_dismissable Options for this noatice or the dismissable value.
			 * @return void
			 */
			"success": function (message, options_or_dismissable)
			{
				noaa.general('noatice-success', message, options_or_dismissable);
			},

			/**
			 * Add a warning noatice to the queue.
			 * 
			 * @since 0.1.0
			 * 
			 * @access jQuery.noatice.add.warning
			 * @param  string message                Message to display in the noatice.
			 * @param  mixed  options_or_dismissable Options for this noatice or the dismissable value.
			 * @return void
			 */
			"warning": function (message, options_or_dismissable)
			{
				noaa.general('noatice-warning', message, options_or_dismissable);
			}
		});
		
		$(document).ready(noa.init);
	}
})(jQuery);

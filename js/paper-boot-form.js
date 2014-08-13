/**
* Manages ajax form submission.
* Handles error process messasges.
*
* @return void
*/
var Paperboot =
{
	/**
    * Store default class parameters
    *
    * @param params json object
	*
    */
	params : {
		/**
		* Time after which success message retracts upon successful form submission
		*
		* @param int milliseconds
		*/
		messasgeHideDelayTime: 5000
	},

	/**
    * Override and merge parsed default parameters.
    *
    * @param params json object.
	*
    * @return void
    */
    overideParams: function(params) {
        this.params = jQuery.extend.apply(jQuery, [this.params].concat(params));
    },
	
    /**
    * Parse default parameters
	* Enable chaining.
	* Define onload events
    *
    * @param json object params
	*
    * @return object Base
    */
    construct: function (params) {
		this.overideParams(params);
		
		
		
		/*
		* Component: admin post edit form
		* Event: Cycle through each post form field and trigger its event
		
		jQuery('.paperboot_fields .menu-settings .edit').each(function() {
			if(jQuery(this).find('input.range').prop('checked')) {
				jQuery(this).find('.range input').removeAttr('disabled');
			}
			
			if(jQuery(this).find('input.depth').prop('checked')) {
				jQuery(this).find('.depth input').removeAttr('disabled');
			}
		});
		*/
		/*
		* Component: wordpress admin menu
		* Event: Replace paperboot menu icon with settings page icon 
		*/
		jQuery('#menu-posts-paperboot').removeClass('menu-icon-post').addClass('menu-icon-settings').find('.wp-menu-image').removeClass('dashicons-admin-post').addClass('dashicons-admin-settings');
		
        return this;
    },

    /**
    * Define all user triggered events.
	*
    * @return void
    */
    event: function() {
		/***** FRONTEND PAPERBOOT WIDGET *****/
		
		/*
		* Component: widget front-end form
		* Event: reload captcha image 
		* 	clear captcha input
		* 	place text cursor onto captcha input
		*/
		jQuery('form.paper-boot-form .captcha-reload').click(function(e) {
			Paperboot.params['formId'] = 'form#' + jQuery(this).parents('form').attr('id');
			jQuery(Paperboot.params.formId + ' #captcha-img').attr('src', jQuery('#captcha-img').attr('src') + '?' + Math.random());
			jQuery(Paperboot.params.formId + ' #captcha').val('').focus();
		})

		/*
		* Component: widget front-end form
		* Event: submit form
		* 	prevent default url submission
		* 	Clear validation error messages
		* 	Initiate ajax request which validates and processes form
		* 	Validate ajax request, show error message upon bad or 404 request	
		* 	Capture ajax response, display individual field validation error messages
		* 	Display and retract success message upon successful submission
		*/
		jQuery('form.paper-boot-form').submit(function(e) {
			e.preventDefault();
			
			Paperboot.params['formId'] = 'form#' + this.id;
			Paperboot.params['form']   = jQuery('form#' + this.id);
			Paperboot.params['prefix'] = this.id
			
			Paperboot.params.form.find('.form-group').removeClass('has-error')
				.find('.alert-danger').hide();

			var request = Ajax.construct({
				data: jQuery(this).serialize() + '&prefix=' + Paperboot.params.prefix,
				url: Paperboot.params['form'].attr('action'),
				type: 'POST',
				dataType: 'json'
			});
			
			request.success(function(response) {
				var errors = response[Paperboot.params.prefix].errors;

				var submit_event = response[Paperboot.params.prefix].submit_event;
				jQuery('form.paper-boot-form').append(submit_event);
				
				if(response[Paperboot.params.prefix].status == false) {
					jQuery(Paperboot.params.formId + ' .alert-danger').each(function() {
						if (errors[jQuery(this).attr('for')]) {
							jQuery(Paperboot.params.formId + ' .alert-danger[for=' + jQuery(this).attr('for') + ']')
								.text(errors[jQuery(this).attr('for')])
								.show()
								.parents('.form-group')
								.addClass('has-error');
						}
					});
				} else {
					jQuery(Paperboot.params.formId + ' #submit').attr('disabled', 'disabled');
					jQuery(Paperboot.params.formId + ' .alert-success').show();
					jQuery(Paperboot.params.formId + ' .captcha-reload').trigger('click');
					jQuery(Paperboot.params.formId)[0].reset();
					
					setTimeout(function() {
						jQuery(Paperboot.params.formId + ' .alert-success').hide();
						jQuery(Paperboot.params.formId + ' #submit').removeAttr('disabled', 'disabled');
					}, Paperboot.params.messasgeHideDelayTime);
				}
			}).fail(function() {
				jQuery(Paperboot.params.formId + ' .alert-danger').show(0).delay(Paperboot.params.messasgeHideDelayTime).hide(0);
			});
		});
		
		/***** ADMIN/BACKEND PAPERBOOT WIDGET *****/
		
		/*
		* Component: widget admin/back-end form
		* Event: toggle visibility of form components depended on "show form" trigger
		*/
		jQuery(document).on('change', '.pb-widget-form .show_form', function() {
			if(this.checked) {
				jQuery(this).parents('.pb-widget-form').find('.show_captcha').show()
					.parents('.pb-widget-form').find('.post_title_field').show()
					.parents('.pb-widget-form').find('.submit_label').show()
					.parents('.pb-widget-form').find('.submit_event').show();
			} else {
				jQuery(this).parents('.pb-widget-form').find('.show_captcha').hide()
					.parents('.pb-widget-form').find('.post_title_field').hide()
					.parents('.pb-widget-form').find('.submit_label').hide()
					.parents('.pb-widget-form').find('.submit_event').hide();
			}
		});
		
		/*
		* Component: widget admin/back-end form
		* Event: toggle visibility of form components depended on "show listing" trigger
		*/
		jQuery(document).on('change', '.pb-widget-form .show_listing', function() {
			if(this.checked) {
				jQuery(this).parents('.pb-widget-form').find('.is_authorized').show();
			} else {
				jQuery(this).parents('.pb-widget-form').find('.is_authorized').hide();
			}
		});
		
		jQuery('.pb-widget-form .show_listing').trigger('change');

		/***** ADMIN/BACKEND PAPERBOOT POST *****/

		/*
		* Component: admin post edit form
		* Event: filter value
		*   Replace illegal and special characters with underscore	
		* 	Convert characters to small case
		*/
		jQuery(document).on('keyup', 'input#paperboot_post_type', function(e) {
			if(this.value) {
				this.value = this.value.replace(/[_\W0-9]+/g, "_");
				this.value = this.value.toLowerCase();
			}
		});
	
		/*
		* Component: admin post edit form
		* Event: filter value
		*   Filter out illegal and special characters	
		*/
		jQuery(document).on('keyup', 'input#paperboot_admin_menu_label', function(e) {
			if(this.value) {
				this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
			}
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: initiate fields accordion
		* 	Enable sliding animation
		*/ 
		jQuery('.paperboot_fields .accordion .accord-content').hide();
		jQuery(document).on('click', '.paperboot_fields .accordion .accord-header', function() {
			if(jQuery(this).next('div').is(':visible')) {
				jQuery(this).next('div').slideUp('fast');
			} else {
				jQuery('.accordion .accord-content').slideUp('fast');
				jQuery(this).next('div').slideToggle('fast');
			}
		});
		
		/***** ADMIN FILTER FIELD *****/
		
		/*
		* Component: admin post edit form, fields section
		* Event: filter value
		*	Filter out illegal and special characters
		* 	Replace illegal and special characters with specified character
		*	Copy value and paste into "name, id, class" fields.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.label', function(e) {
			this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
			var value  = this.value;
			value = value.toLowerCase();
			
			jQuery(this).parents('.menu-settings').find('input.name').val(value.replace(/[^a-zA-Z0-9-]/g, '_'))
				.parents('.menu-settings').find('input.id').val(value.replace(/[^a-zA-Z0-9-]/g, '-'))
				.parents('.menu-settings').find('input.class').val(value.replace(/[^a-zA-Z0-9-]/g, '-'));
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: filter value
		*	Filter out illegal and special characters
		* 	Replace illegal and special characters with underscore
		*	Copy value and paste into "id, class" fields
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.name', function(e) {
			this.value = this.value.replace(/[^a-zA-Z0-9_-]/g, '_');
			var value = this.value;
			value = value.toLowerCase();
			
			jQuery(this).parents('.menu-settings').find('input.id').val(value.replace(/[^a-zA-Z0-9-]/g, '-'))
				.parents('.menu-settings').find('input.class').val(value.replace(/[^a-zA-Z0-9-]/g, '-'));	
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: filter value
		*	Filter out illegal and special characters
		* 	Replace illegal and special characters with underscore
		*	Lower case all characters
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.name', function(e) {
			jQuery(this).val(this.value.replace(/[^a-zA-Z0-9_-]/g, '_').toLowerCase());
		});

		/*
		* Component: admin post edit form, fields section
		* Event: filter value
		*	Filter out illegal and special characters
		* 	Replace illegal and special characters with dash
		*	Lower case all characters
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.id, .paperboot-fields input.class', function(e) {
			jQuery(this).val(this.value.replace(/[^a-zA-Z0-9_-]/g, '-').toLowerCase());
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: filter value
		*	Filter out illegal and special characters
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.maxlength, .paperboot-fields input.size, .paperboot-fields input.max, .paperboot-fields input.min', function(e) {
			jQuery(this).val(this.value.replace(/[^0-9]/g, ''));
		});
		
		
		/***** ADMIN VALIDATION FIELD SWITCHES *****/
		
		/*
		* Component: admin post edit form, fields section
		* Event: toggle label text
		*	Display default label when label is empty
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.label', function(e) {
			if(this.value) {
				jQuery(this).parents('.menu-settings').find('.with-label').text(this.value).show()
					.parents('.menu-settings').find('.no-label').hide();
			} else {
				jQuery(this).parents('.menu-settings').find('.with-label').hide()
					.parents('.menu-settings').find('.no-label').show();
			}
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: toggle visibility of form components depended on "mode" trigger
		*/
		jQuery(document).on('change', '.paperboot_fields select.mode', function(e) {
			jQuery(this).parents('.menu-settings').find('dl').hide()
				.parents('.menu-settings').find('.settings dl').show()
				.parents('.menu-settings').find('dl.pb-' + this.value).show()
		});
		jQuery('.paperboot_fields select.mode').trigger('change');

		/*
		* Component: admin post edit form, fields section
		* Event: toggle visibility of form components depended on "range" and "depth" trigger
		*/
		jQuery(document).on('click', '.paperboot_fields input.range', function(e) {
			if(jQuery(this).prop('checked')) {
				jQuery(this).parents('.range').find('input.min').removeAttr('disabled')
					.parents('.range').find('input.max').removeAttr('disabled');
			} else {
				jQuery(this).parents('.range').find('input.min').prop('disabled', 'disabled')
					.parents('.range').find('input.max').prop('disabled', 'disabled');
			}
		});

		jQuery('.paperboot_fields input.range').trigger('click');
		
		/*
		* Component: admin post edit form, fields section
		* Event: toggle visibility of form components depended on "range" and "depth" trigger
		*/
		jQuery(document).on('click', '.paperboot_fields input.depth', function(e) {
			if(jQuery(this).prop('checked')) {
				jQuery(this).parents('.depth').find('input.min').removeAttr('disabled')
					.parents('.depth').find('input.max').removeAttr('disabled');
			} else {
				jQuery(this).parents('.depth').find('input.min').prop('disabled', 'disabled')
					.parents('.depth').find('input.max').prop('disabled', 'disabled');
			}
		});

		jQuery('.paperboot_fields input.depth').trigger('click');

		/*
		* Component: admin post edit form, fields section
		* Event: disable depth validation rule when multiple is unchecked
		*/
		jQuery(document).on('click', '.menu-settings .multiple input.multiple ', function(e) {
			if(jQuery(this).prop('checked')) {
				jQuery(this).parents('.menu-settings').find('input.depth').removeAttr('disabled').prop('checked', 'checked')
					.parents('.menu-settings').find('.depth input.min, .depth input.max').removeAttr('disabled');
			} else {
				jQuery(this).parents('.menu-settings').find('input.depth').prop('disabled', 'disabled').removeAttr('checked')
					.parents('.menu-settings').find('.depth input.min, .depth input.max').prop('disabled', 'disabled');
			}
		});
		
		
		/***** ADMIN FIELD PARAMETERS MANAGE SELECT, RADIO, CHECKBOX OPTIONS *****/
		
		/*
		* Component: admin post edit form, fields section
		* Event: add option to select
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.add', function(e) {
			e.preventDefault();
			
			var id = jQuery(this).parents('.options').find('input.add').prop('id');
			var name = jQuery(this).parents('.options').find('input.value').val();
			var value = jQuery(this).parents('.options').find('input.add').val();
			
			jQuery(this).parents('.options').find('input.add').val('');
			jQuery(this).parents('.options').find('input.add').prop('id', parseInt(id) + 1);

			jQuery(this).parents('.options').find('.order-container')
				.append('<li class="order-item" data-sort="'+id+'"><input type="text" id="'+id+'" value="'+value+'" name="'+name+'['+value+
				']"><ul style="list-style-type: none; display: inline"><li style="display: inline; margin-left: 10px"> <button class="order button-secondary" id="'+id+
				'">&#8597;</button></li><li style="display: inline; margin-left: 10px"> <button class="delete button-secondary" id="'+id+
				'">&times;</button></li></ul></li>');
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: delete option to select
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.delete', function(e) {
			e.preventDefault();

			jQuery(this).parents('.options').find('input#' + this.id).parents('li').remove();
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: reorder field
		*/
		jQuery(document).on('click', '.paperboot-fields .toolbar-field button.order', function(e) {
			e.preventDefault();
			
			var sort = jQuery(this).parents('.sort-element').attr('data-sort');
			var result = sort;
			if(sort > 1) {
				result = sort - 1;
			} else {
				result = 2;
			}
			
			jQuery('.sort-element').each(function(index) {
				if(jQuery(this).attr('data-sort') == result) {
					jQuery(this).attr('data-sort', sort);
				}
			});

			jQuery(this).parents('.sort-element').attr('data-sort', result);

			jQuery('.sort-element').sort(function(a,b) {
				 return a.dataset.sort > b.dataset.sort;
			}).appendTo('.sort-container');
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: reorder select option
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.order', function(e) {
			e.preventDefault();
			
			var sectionId = jQuery(this).parents('.menu-settings').attr('id');
			
			var sort = jQuery(this).parents('.order-item').attr('data-sort');
			var result = sort;
			
			if(sort > 1) {
				var result = sort - 1;
			}
			
			if(sort == 1) {
				var result = 2;
			}
			
			jQuery('#' + sectionId + ' .options .order-item').each(function(index) {
				if(jQuery(this).attr('data-sort') == result) {
					jQuery(this).attr('data-sort', sort);
				}
			});

			jQuery(this).parents('.order-item').attr('data-sort', result);

			jQuery('#' + sectionId + ' .options .order-item').sort(function(a, b) {
				return a.dataset.sort > b.dataset.sort;
			}).appendTo('.options .order-container');
		});
		
		/*
		* Component: admin post edit form, fields section
		* Event: Remove Field section.
		*/ 
		jQuery(document).on('click', '.paperboot-fields button.delete', function(e) {
			e.preventDefault();
			
			jQuery(this).parents('.menu-settings').fadeOut(300, function() { 
				jQuery(this).remove();
			});
		});
		
		/*
		* Component: admin post edit form, fields section, add Field Button.
		* Event: disable default behaviour, to revent url refresh
		*/ 
		jQuery(document).on('click', 'button.accord-header', function(e) {
			e.preventDefault();
		});
		
		/*
		* Validation Name, Id.
		* Validate value if empty
		* Set error message
		* Toggle message visibility
		* Disable form submission when errors given.
		*/
		jQuery('#post').on('submit', function(e) {
			if(!jQuery('#paperboot_post_type').val()) {
				e.preventDefault();
				jQuery('#paperboot_post_type').prev('label.alert-danger').addClass('active');
			} else {
				jQuery('#paperboot_post_type').prev('label.alert-danger').removeClass('active');
			}
			
			if(!jQuery('#paperboot_admin_menu_label').val()) {
				e.preventDefault();
				jQuery('#paperboot_admin_menu_label').prev('label.alert-danger').addClass('active');
			} else {
				jQuery('#paperboot_admin_menu_label').prev('label.alert-danger').removeClass('active');
			}
	
			jQuery('.accord-content').slideUp('fast');
			
			jQuery('.edit .menu-settings').each(function() {
				if(!jQuery(this).find('input.name').val()) {
					jQuery(this).find('.name label.alert-danger').text('Cannot be blank').addClass('active');
					jQuery(this).find('.accord-content').slideDown('fast');
					
					e.preventDefault();
					
					jQuery('html,body').animate({
						scrollTop: jQuery('#' + this.id).offset().top
					},
					'slow');

					return false;
				} else {
					jQuery(this).find('.name label.alert-danger').removeClass('active');
				}
				
				if(!jQuery(this).find('input.id').val()) {
					jQuery(this).find('.id label.alert-danger').text('Cannot be blank').addClass('active');
					jQuery(this).find('.accord-content').slideDown('fast');
					
					e.preventDefault();
					return false;
				} else {
					jQuery(this).find('.id label.alert-danger').removeClass('active');
				}
			});
		});
	}
}

jQuery(function() {
	/**
	* Load base/parent class.
	*/
	Paperboot.construct().event();
});
/**
* Manages ajax form submission.
* Handles error process messasges.
*
* @return void
*/
var Paperboot =
{
	/**
    * Store default class options.
    *
    * @param params json object.
	*
    */
	params : {
		messasgeHideDelayTime: 5000
	},

	/**
    * Override parsed default parameters.
    *
    * @param params json object.
	*
    * @return void
    */
    overideParams: function(params) {
        this.params = jQuery.extend.apply(jQuery, [this.params].concat(params));
    },
	
    /**
    * Parse default parameters.
	* Enable chaining.
	* Define all onload functionalities required by all pages.
    *
    * @param json object params
	*
    * @return object Base
    */
    construct: function (params) {
		this.overideParams(params);
		
		/*
		* Change paperboot admin menu post icon to settings icon.
		*/
		jQuery('#menu-posts-paperboot').removeClass('menu-icon-post').addClass('menu-icon-settings').find('.wp-menu-image').removeClass('dashicons-admin-post').addClass('dashicons-admin-settings');
		
		/***** WIDGET JS *****/
		/*
		* Admin widget "Show Listing" toggle front-end form visibility.
		*/ 
		jQuery(document).on('change', '.pb-widget-form .show_listing', function() {
			if(this.checked) {
				jQuery(this).parents('.pb-widget-form').find('.is_authorized').show();
			} else {
				jQuery(this).parents('.pb-widget-form').find('.is_authorized').hide();
			}
		});
		
		jQuery('.pb-widget-form .show_listing').trigger('change');

		/*
		* Admin widget "Show Form" toggle front-end form visibility.
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
		
		
		/***** ADMIN PAPERBOOT FIELDS *****/
		/*
		* Initiate fields accordion.
		*/ 
		jQuery('.accordion .accord-content').hide();
		
		jQuery(document).on('click', '.accordion .accord-header', function() {
			if(jQuery(this).next('div').is(':visible')) {
				jQuery(this).next('div').slideUp('fast');
			} else {
				jQuery('.accordion .accord-content').slideUp('fast');
				jQuery(this).next('div').slideToggle('fast');
			}
		});

		/*
		* Copy post title to post type field.
		* Remove illegal characters.
		* Convert caps to small case.
		*/
		jQuery(document).on('keyup', '#paperboot_post_type', function(e) {
			if(this.value) {
				this.value = this.value.replace(/[_\W0-9]+/g, "_");
				this.value = this.value.toLowerCase();

				jQuery(this).parent('.paperboot_post_type').find('label.alert-danger').removeClass('active');
			} else {
				jQuery(this).parent('.paperboot_post_type').find('label.alert-danger').text('Cannot be blank').addClass('active');
			}
		});
	
		/*
		* Admin Menu Label validation
		* Filter out illegal characters.
		*/
		jQuery(document).on('keyup', '#paperboot_admin_menu_label', function(e) {
			if(this.value) {
				this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
				
				jQuery(this).parent('.paperboot_admin_menu_label').find('label.alert-danger').removeClass('active');
			} else {
				jQuery(this).parent('.paperboot_admin_menu_label').find('label.alert-danger').text('Cannot be blank').addClass('active');
			}
		});
		
		/***** ADMIN FILTER FIELD *****/
		
		/*
		* Field: Label
		* Filter out illegal characters.
		* Copy and filter label value and paste into "name, id, class" fields.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.label', function(e) {
			this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
			var value  = this.value;
			value = value.toLowerCase();
			
			jQuery(this).parents('.field').find('input.name').val(value.replace(/[^a-zA-Z0-9-]/g, '_'))
				.parents('.field').find('input.id').val(value.replace(/[^a-zA-Z0-9-]/g, '-'))
				.parents('.field').find('input.class').val(value.replace(/[^a-zA-Z0-9-]/g, '-'));
		});
		
		/*
		* Field: Label
		* Filter out illegal characters.
		* Copy and filter label value and paste into "name, id, class" fields.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.name', function(e) {
			this.value = this.value.replace(/[^a-zA-Z0-9_-]/g, '_');
			var value = this.value;
			value = value.toLowerCase();
			
			jQuery(this).parents('.field').find('input.id').val(value.replace(/[^a-zA-Z0-9-]/g, '-'))
				.parents('.field').find('input.class').val(value.replace(/[^a-zA-Z0-9-]/g, '-'));	
		});
		
		/*
		* Admin update Name field
		* Filter out illegal characters.
		* Display error when empty.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.name', function(e) {
			jQuery(this).val(this.value.replace(/[^a-zA-Z0-9_-]/g, '_').toLowerCase());
		});

		/*
		* Admin update Id field
		* Filter out illegal characters.
		* Display error when empty.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.id, .paperboot-fields input.class', function(e) {
			jQuery(this).val(this.value.replace(/[^a-zA-Z0-9_-]/g, '-').toLowerCase());
		});
		
		/*
		* Admin update Size field
		* Display error when non numeric.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.maxlength, .paperboot-fields input.size, .paperboot-fields input.max, .paperboot-fields input.min', function(e) {
			jQuery(this).val(this.value.replace(/[^0-9]/g, ''));
		});
		
		
		/***** ADMIN VALIDATION FIELD SWITCHES *****/
		
		/*
		* Update field section heading from label.
		*/
		jQuery(document).on('keyup', '.paperboot-fields input.label', function(e) {
			if(this.value) {
				jQuery(this).parents('.field').find('.with-label').text(this.value).show()
					.parents('.field').find('.no-label').hide();
			} else {
				jQuery(this).parents('.field').find('.with-label').hide()
					.parents('.field').find('.no-label').show();
			}
		});
		
		/*
		* Field Input Type switch.
		*/
		jQuery(document).on('change', '.paperboot-fields select.mode', function() {
			jQuery(this).parents('.field').find('.parameters dl').hide()
				.parents('.field').find('.validation-rules dl').hide()
				.parents('.field').find('.parameters dl.pb-' + this.value).show()
				.parents('.field').find('.validation-rules dl.pb-' + this.value).show();
		});
		
		/*
		* Admin update field validation Range rule
		* Toggle range validation rule parameters.
		*/
		jQuery(document).on('click', '.paperboot-fields input.range, .paperboot-fields input.depth', function(e) {
			var selector = jQuery(this).attr('class');
			
			if(jQuery(this).prop('checked')) {
				jQuery(this).parents('.' + selector).find('input.min').removeAttr('disabled')
					.parents('.' + selector).find('input.max').removeAttr('disabled');
			} else {
				jQuery(this).parents('.' + selector).find('input.min').prop('disabled', 'disabled')
					.parents('.' + selector).find('input.max').prop('disabled', 'disabled');
			}
		});
		
		/*
		* Field Multiple
		* Disable depth validation rule when mltiple is unchecked.
		*/
		jQuery(document).on('click', '.field .multiple input.multiple ', function(e) {
			if(jQuery(this).prop('checked')) {
				jQuery(this).parents('.field').find('input.depth').removeAttr('disabled')
					.parents('.field').find('.depth input.min, .depth input.max').removeAttr('disabled');
			} else {
				jQuery(this).parents('.field').find('input.depth').prop('disabled', 'disabled')
					.parents('.field').find('.depth input.min, .depth input.max').prop('disabled', 'disabled');
			}
		});
		
		/*
		* Execute on load triggers.
		*/
		jQuery('.field').each(function() {
			if(this.id) {
				jQuery(this).find('select.mode').trigger('change');

				if(jQuery(this).find('input.range').prop('checked')) {
					jQuery(this).find('.range input').removeAttr('disabled');
				}
				
				if(jQuery(this).find('input.depth').prop('checked')) {
					jQuery(this).find('.depth input').removeAttr('disabled');
				}
			}
		});
		
		
		/***** ADMIN FIELD PARAMETERS MANAGE SELECT, RADIO, CHECKBOX OPTIONS *****/
		
		/*
		* Add option
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.add', function(e) {
			e.preventDefault();
			
			var id = jQuery(this).parents('.options').find('input.add').prop('id');
			var name = jQuery(this).parents('.options').find('input.value').val();
			var value = jQuery(this).parents('.options').find('input.add').val();
			
			jQuery(this).parents('.options').find('input.add').val('');
			jQuery(this).parents('.options').find('input.add').prop('id', parseInt(id) + 1);
			/*
			var input = jQuery('input');
			input.prop('type', 'text')
				.prop('id', id)
				.prop('value', value)
				.prop('name', name + '[' + value + ']')
				.prop('id', id);
			*/	
			
			jQuery(this).parents('.options').find('.order-container')
				.append('<li class="order-item" data-sort="'+id+'"><input type="text" id="'+id+'" value="'+value+'" name="'+name+'['+value+
				']"><ul style="list-style-type: none; display: inline"><li style="display: inline; margin-left: 10px"> <button class="order button-secondary" id="'+id+
				'">&#8597; Order</button></li><li style="display: inline; margin-left: 10px"> <button class="delete button-secondary" id="'+id+
				'">&times; Delete</button></li></ul></li>');
		});
		
		/*
		* Delete option.
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.delete', function(e) {
			e.preventDefault();

			jQuery(this).parents('.options').find('input#' + this.id).parents('li').remove();
		});
		 		
		/*
		* Order field containers.
		*/
		jQuery(document).on('click', '.paperboot-fields .options button.order', function(e) {
			e.preventDefault();
			
			var sectionId = jQuery(this).parents('.field').attr('id');
			
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
		* Sort field containers.
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
		* Remove Field section.
		*/ 
		jQuery(document).on('click', '.paperboot-fields button.delete', function(e) {
			e.preventDefault();
			
			jQuery(this).parents('.field').remove();
		});
		
		/*
		* Add Field Button.
		* Disable default behaviour, to revent url refresh
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
			jQuery('.field').each(function() {
				if(!jQuery(this).find('input.name').val()) {
					jQuery(this).find('.name label.alert-danger').text('Cannot be blank').addClass('active');
					jQuery(this).find('.accord-content').slideDown('fast');
					
					e.preventDefault();
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
		
		/*
		* Disable form submission on enter click.
		*/
		jQuery('#post').bind('keyup keypress change', function(e) {
			var code = e.keyCode || e.which;
			
			if (code == 13) {
				e.preventDefault();
			}
		});
		
        return this;
    },

    /**
    * Define all user triggered events.
	*
    * @return void
    */
    event: function() {
		jQuery('.reload-captcha').click(function(e) {
			Paperboot.params['formId'] = 'form#' + jQuery(this).parents('form').attr('id');
			jQuery(Paperboot.params.formId + ' #captcha-img').attr('src', jQuery('#captcha-img').attr('src') + '?' + Math.random());
			jQuery(Paperboot.params.formId + ' #captcha').val('').focus();
		})

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
					jQuery(Paperboot.params.formId + ' #reload-captcha').trigger('click');
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
	}
}

jQuery(function() {
	/**
	* Load base/parent class.
	*/
	Paperboot.construct().event();
});
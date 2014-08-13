<div class="settings inlinexX">
	<h4><?php _e('Field Options', 'text_domain') ?></h4>
	
	<dl class="label">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Label', 'text_domain'),
				'for'   => 'pb_settings_label_' . $i,
				'title' => __('Label', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'        => 'paperboot_fields['.$i.'][label]', 
				'id'          => 'pb_settings_label_' . $i,
				'class'       => 'label',
				'placeholder' => __('LABEL', 'text_domain'),
				'maxlength'   => 30,
				'value'       => isset($field) ? $field['label'] : null)
			) ?>
		</dd>
	</dl>
	<dl class="description">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Description', 'text_domain'),
				'for'   => 'pb_settings_description_' . $i,
				'title' => __('Description', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'    => 'paperboot_fields['.$i.'][description]', 
				'id'      => 'pb_settings_description_' . $i,
				'class'   => 'description',
				'placeholder' => __('DESCRIPTION', 'text_domain'),
				'maxlength'   => 30,
				'value'       => isset($field) ? $field['description'] : null)
			) ?>
		</dd>
	</dl>
	<dl class="admin_grid">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Display on post listing screen', 'text_domain'),
				'for'   => 'pb_settings_admin_grid_' . $i,
				'title' => __('Display on post listing screen', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][admin_grid]', 
				'id'      => 'pb_settings_admin_grid_' . $i,
				'class'   => 'admin_grid',
				'value'   => 'on',
				'checked' => isset($field) ? array_key_exists('admin_grid', $field) : null)
			) ?>
		</dd>
	</dl>
	<dl class="admin_edit">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Display on edit post screen', 'text_domain'),
				'for'   => 'pb_settings_admin_edit_' . $i,
				'title' => __('Display on edit screen', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][admin_edit]', 
				'id'      => 'pb_settings_admin_edit_' . $i,
				'class'   => 'admin_edit',
				'value'   => 'on',
				'checked' => isset($field) ? array_key_exists('admin_edit', $field) : null)
			) ?>
		</dd>
	</dl>
	<dl class="mode">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Input Type', 'text_domain'),
				'for'   => 'pb_settings_type_' . $i,
				'title' => __('Input Type', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::select(array(
				'name'    => 'paperboot_fields['.$i.'][mode]', 
				'id'      => 'pb_settings_type_' . $i,
				'class'   => 'mode',
				'value'   => $field['mode'],
				'options' => array(
					'text'     => 'Text', 
					'email'    => 'Email',
					'url'      => 'Url',
					'select'   => 'Select', 
					'textarea' => 'Textarea',
					'checkbox' => 'Checkbox',
					'radio'    => 'Radio'
				))
			) ?>
		</dd>
	</dl>
</div>
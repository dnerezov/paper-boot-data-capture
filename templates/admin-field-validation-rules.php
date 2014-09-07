<div class="validation-rules inlinexX">
	<h4><?php _e('Input Validation Rules', 'text_domain') ?></h4>
	
	<dl class="pb-email pb-text pb-select pb-textarea pb-checkbox pb-radio pb-hidden blank">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Required', 'text_domain'),
				'for'   => 'pb_validation_rule_blank_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][blank]', 
				'id'      => 'pb_validation_rule_blank_' . $i,
				'value'   => 'on',
				'class'   => 'blank',
				'checked' => isset($field) ? array_key_exists('blank', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-email pb-text pb-select pb-textarea required-html5">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Required HTML5', 'text_domain'),
				'for'   => 'pb_validation_rule_required_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][input][params][required]',  
				'id'      => 'pb_validation_rule_required_' . $i,
				'value'   => 'on',
				'class'   => 'blank',
				'checked' => isset($field) ? array_key_exists('required', $field['input']['params']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-text alpha">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Alpha', 'text_domain'),
				'for'   => 'pb_validation_rule_alpha_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][alpha]', 
				'id'      => 'pb_validation_rule_alpha_' . $i,
				'value'   => 'on',
				'class'   => 'alpha',
				'checked' => isset($field) ? array_key_exists('alpha', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-email pb-text pb-textarea censorWords">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Censor Words', 'text_domain'),
				'for'   => 'pb_validation_rule_censorWords_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][censorWords]', 
				'id'      => 'pb_validation_rule_censorWords_' . $i,
				'value'   => 'on',
				'class'   => 'censorWords',
				'checked' => isset($field) ? array_key_exists('censorWords', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-text numeric">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Numeric', 'text_domain'),
				'for'   => 'pb_validation_rule_numeric_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][numeric]', 
				'id'      => 'pb_validation_rule_numeric_' . $i,
				'value'   => 'on',
				'class'   => 'numeric',
				'checked' => isset($field) ? array_key_exists('numeric', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-text pb-textarea alphanumeric">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Alphanumeric', 'text_domain'),
				'for'   => 'pb_validation_rule_alphanumeric_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][alphanumeric]', 
				'id'      => 'pb_validation_rule_alphanumeric_' . $i,
				'value'   => 'on',
				'class'   => 'alphanumeric',
				'checked' => isset($field) ? array_key_exists('alphanumeric', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-url url">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Url', 'text_domain'),
				'for'   => 'pb_validation_rule_url_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][url]', 
				'id'      => 'pb_validation_rule_url_' . $i,
				'value'   => 'on',
				'class'   => 'url',
				'checked' => isset($field) ? array_key_exists('url', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-email pb-text email">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Email Address', 'text_domain'),
				'for'   => 'pb_validation_rule_email_' . $i)
			) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][validation_rules][email]', 
				'id'      => 'pb_validation_rule_email_' . $i,
				'value'   => 'on',
				'class'   => 'email',
				'checked' => isset($field) ? array_key_exists('email', $field['validation_rules']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-email pb-text pb-textarea pb-url range">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Range', 'text_domain'),
				'for'   => 'pb_validation_rule_range_' . $i)
			) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::label(array(
					'for'   => 'pb_validation_rule_range_' . $i, 
					'class' => 'pb-validation-error edit-meta-fields'
			)) ?>
			<?php echo PB_Tag::checkbox(array(
				'name'  => 'paperboot_fields['.$i.'][validation_rules][range]', 
				'id'    => 'pb_validation_rule_range_' . $i, 
				'value' => 'on',
				'class' => 'range',
				'checked' => isset($field) ?  array_key_exists('range', $field['validation_rules']) : null)
			) ?>
			<div style="display: inline">
				<?php _e('Min', 'text_domain') ?>
				<?php echo PB_Tag::input(array(
					'id'        => 'pb_validation_rule_range_' . $i, 
					'size'      => 3, 
					'maxlength' => 4, 
					'type'      => 'text', 
					'name'      => 'paperboot_fields['.$i.'][validation_rules][range][min]', 
					'value'     => !empty($field['validation_rules']['range']['min']) ? $field['validation_rules']['range']['min'] : 2,
					'disabled'  => isset($field['validation_rules']) ? array_key_exists('range', $field['validation_rules']) : null,
					'class'     => 'min',
					'placeholder' => 2)
				) ?>
				
				<?php _e('Max', 'text_domain') ?>
				<?php echo PB_Tag::input(array(
					'id'        => 'pb_validation_rule_range_' . $i, 
					'size'      => 3, 
					'maxlength' => 4, 
					'type'      => 'text', 
					'name'      => 'paperboot_fields['.$i.'][validation_rules][range][max]', 
					'value'     => !empty($field['validation_rules']['range']['max']) ? $field['validation_rules']['range']['max'] : 50,
					'disabled'  => isset($field['validation_rules']) ? array_key_exists('range', $field['validation_rules']) : null,
					'class'     => 'max',
					'placeholder' => 30)
				) ?>
			</div>
		</dd>
	</dl>
	<dl class="pb-checkbox pb-select depth">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Min Max Number Of Checked Items', 'text_domain'),
				'for'   => 'pb_validation_rule_depth_' . $i)
			) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::label(array(
					'for'   => 'pb_validation_rule_depth_' . $i, 
					'class' => 'pb-validation-error edit-meta-fields'
			)) ?>
			<?php echo PB_Tag::checkbox(array(
				'name'  => 'paperboot_fields['.$i.'][validation_rules][depth]', 
				'id'    => 'pb_validation_rule_depth_' . $i, 
				'value' => 'on',
				'class' => 'depth',
				'checked' => isset($field) ?  array_key_exists('depth', $field['validation_rules']) : null)
			) ?>
			<div style="display: inline">
				<?php _e('Min', 'text_domain') ?>
				<?php echo PB_Tag::input(array(
					'id'        => 'pb_validation_rule_depth_' . $i, 
					'size'      => 3, 
					'maxlength' => 4, 
					'type'      => 'text', 
					'name'      => 'paperboot_fields['.$i.'][validation_rules][depth][min]', 
					'value'     => !empty($field['validation_rules']['depth']['min']) ? $field['validation_rules']['depth']['min'] : 2,
					'class'     => 'min',
					'placeholder' => 2)
				) ?>
				
				<?php _e('Max', 'text_domain') ?>
				<?php echo PB_Tag::input(array(
					'id'        => 'pb_validation_rule_depth_' . $i, 
					'size'      => 3, 
					'maxlength' => 4, 
					'type'      => 'text', 
					'name'      => 'paperboot_fields['.$i.'][validation_rules][depth][max]', 
					'value'     => !empty($field['validation_rules']['depth']['max']) ? $field['validation_rules']['depth']['max'] : 5,
					'class'     => 'max',
					'placeholder' => 5)
				) ?>
			</div>
		</dd>
	</dl>
</div>
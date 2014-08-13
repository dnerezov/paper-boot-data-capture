<div class="parameters inlinexX">
	<h4><?php _e('Input Parameters', 'text_domain') ?></h4>
	
	<dl class="pb-text pb-url pb-email pb-select pb-textarea pb-button pb-checkbox pb-radio name">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Name', 'text_domain'),
				'for'   => 'pb_parameter_name_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::label(array(
				'for'   => 'pb_parameter_name_' . $i,
				'class' => 'alert-danger'
			)) ?>
			<?php echo PB_Tag::text(array(
				'name'    => 'paperboot_fields['.$i.'][input][params][name]', 
				'id'      => 'pb_parameter_name_' . $i,
				'class'   => 'name',
				'value'   => isset($field) ? $field['input']['params']['name'] : null,
				'placeholder' => 'NAME')
			) ?>
		</dd>
	</dl>
	<dl class="pb-text pb-email pb-url pb-checkbox pb-radio pb-select pb-button pb-textarea pb-submit id">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Id', 'text_domain'),
				'for'   => 'pb_parameter_id_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::label(array(
				'for'   => 'pb_parameter_id_' . $i,
				'class' => 'alert-danger'
			)) ?>
			<?php echo PB_Tag::text(array(
				'name'    => 'paperboot_fields['.$i.'][input][params][id]', 
				'id'      => 'pb_parameter_id_' . $i,
				'class'   => 'id',
				'value'   => isset($field) ? $field['input']['params']['id'] : null,
				'placeholder' => 'ID')
			) ?>
		</dd>
	</dl>
	<dl class="pb-text pb-email pb-url pb-checkbox pb-radio pb-select pb-button pb-textarea pb-submit class">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Class', 'text_domain'),
				'for'   => 'pb_parameter_class_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'    => 'paperboot_fields['.$i.'][input][params][class]', 
				'id'      => 'pb_parameter_class_' . $i,
				'class'   => 'class',
				'value'   => isset($field) ? $field['input']['params']['class'] : null,
				'placeholder' => 'CSS CLASS')
			) ?>
		</dd>
	</dl>
	<dl class="pb-text pb-email pb-url pb-textarea maxlength">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Maxlength', 'text_domain'),
				'for'   => 'pb_parameter_maxlength_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'        => 'paperboot_fields['.$i.'][input][params][maxlength]', 
				'id'          => 'pb_parameter_maxlength_' . $i,
				'class'       => 'maxlength',
				'placeholder' => 30,
				'maxlength'   => 5,
				'size'        => 4,
				'value'       => isset($field) ? $field['input']['params']['maxlength'] : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-text pb-email pb-url pb-select size">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Size', 'text_domain'),
				'for'   => 'pb_parameter_size_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'        => 'paperboot_fields['.$i.'][input][params][size]', 
				'id'          => 'pb_parameter_size_' . $i,
				'class'       => 'size',
				'placeholder' => 30,
				'maxlength'   => 5,
				'size'        => 4,
				'value'       => isset($field) ? $field['input']['params']['size'] : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-select multiple">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Multiple', 'text_domain'),
				'for'   => 'pb_parameter_multiple_' . $i
			)) ?>
		</dt>
		<dd><?php echo PB_Tag::checkbox(array(
				'name'    => 'paperboot_fields['.$i.'][input][params][multiple]', 
				'id'      => 'pb_parameter_multiple_' . $i,
				'class'   => 'multiple',
				'checked' => isset($field) ? array_key_exists('multiple', $field['input']['params']) : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-select pb-checkbox pb-radio options">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Options', 'text_domain')
			)) ?>
		</dt>
		<dd>
			<ul class="order-container">
			<?php 
			$cnt = 1;
			if(!empty($field['input']['params']['options'])) {
				foreach ($field['input']['params']['options'] as $option) { ?>
					<li class="order-item" data-sort="<?php echo $cnt ?>">
						<?php echo PB_Tag::text(array(
							'name'  => 'paperboot_fields['.$i.'][input][params][options]['.$option.']', 
							'id'    => $cnt,
							'value' => $option
						))?>
						<ul style="list-style-type: none; display: inline">
							<li style="display: inline; margin-left: 10px">
								<button id="<?php echo $cnt ?>" class="order button-secondary">&#8597;</button>
							</li>
							<li style="display: inline; margin-left: 10px">
								<button id="<?php echo $cnt ?>" class="delete button-secondary">&times;</button>
							</li>
						</ul>
					</li>
				<?php $cnt ++;
				}
			} ?>
			</ul>
			<?php echo PB_Tag::text(array(
				'id'    => $cnt,
				'class' => 'add'
			))?>
			<ul style="list-style-type: none; display: inline">
				<li style="display: inline; margin-left: 10px">
					<button id="pb_parameter_options_<?php echo $cnt ?>" class="button button-primary button-large add button-secondary">&#43; Add</button>
				</li>
			</ul>
			<input type="hidden" class="value" value="paperboot_fields[<?php echo $i ?>][input][params][options]">
		</dd>
	</dl>
	<dl class="pb-textarea cols">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Cols', 'text_domain'),
				'for'   => 'pb_parameter_cols_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'        => 'paperboot_fields['.$i.'][input][params][cols]', 
				'id'          => 'pb_parameter_cols_' . $i,
				'class'       => 'cols',
				'placeholder' => 5,
				'maxlength'   => 5,
				'size'        => 4,
				'value'       => isset($field) ? $field['input']['params']['cols'] : null)
			) ?>
		</dd>
	</dl>
	<dl class="pb-textarea rows">
		<dt class="howto">
			<?php echo PB_Tag::label(array(
				'value' => __('Rows', 'text_domain'),
				'for'   => 'pb_parameter_rows_' . $i
			)) ?>
		</dt>
		<dd>
			<?php echo PB_Tag::text(array(
				'name'        => 'paperboot_fields['.$i.'][input][params][rows]', 
				'id'          => 'pb_parameter_rows_' . $i,
				'class'       => 'rows',
				'placeholder' => 10,
				'maxlength'   => 5,
				'size'        => 4,
				'value'       => isset($field) ? $field['input']['params']['rows'] : null)
			) ?>
		</dd>
	</dl>
</div>
	<?php echo PB_Tag::hidden(array(
		'name'  => 'paperboot_fields['.$i.'][input][params][type]',
		'value' => $field['input']['params']['type'],
		'class' => 'pb-type')
	) ?>
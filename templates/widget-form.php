<?php 
//echo '<pre>';
//print_r($settings);
//echo '</pre>';

if(!empty($settings['fields']) && isset($show_form)) : ?>
<form class="paper-boot-form" action="<?php echo plugins_url('pb-widget-ajax.php', dirname(__FILE__)) ?>" method="post" id="<?php echo $settings['post_type'] ?>" role="form">
	<?php foreach ($settings['fields'] as $field) : ?>
		<div class="form-group">
			<?php if(array_key_exists('label', $field) && is_string($field['label'])) :?>
				<?php echo PB_Tag::label(array(
					'for'   => $field['input']['params']['id'], 
					'title' => !empty($field['description']) ? $field['description'] : $field['label'],
					'class' => 'control-label ellipsis', 
					'style' => 'display: block', 
					'value' => $field['label'])
				) ?>
			<?php endif?>
			
			<?php echo PB_Tag::label(array(
				'for'   => $field['input']['params']['id'], 
				'class' => 'control-label alert alert-danger', 
				'style' => 'display: none')
			) ?>
			
			<?php if(array_key_exists('mode', $field) 
					&& array_key_exists('input', $field) 
						&& array_key_exists('params', $field['input'])) {
					$mode = $field['mode']; 
					echo PB_Tag::$mode($field['input']['params']) ?>
				<?php } ?>
		</div>
	<?php endforeach ?>
	
	<?php if ($show_captcha) : ?>
	<div class="form-group">
		<?php echo PB_Tag::label(array(
				'for'   => 'captcha', 
				'class' => 'control-label ellipsis', 
				'style' => 'display: block', 
				'value' => __('Captcha Term', 'text_doamin'))
			) ?>
		<?php echo PB_Tag::label(array(
			'for'   => 'captcha', 
			'class' => 'control-label alert alert-danger', 
			'style' => 'display: none')
		) ?>
		<?php echo PB_Tag::img(array(
			'src' => plugins_url('../inc/cool_php_captcha/captcha.php?=' . rand(2, 9) . '', __FILE__ ),
			'id'  => 'captcha-img')
		) ?>
		<div class="input-group">
			<span class="input-group-btn">
				<button class="btn btn-default captcha-reload" type="button" title="Reload Word">
					<span class="glyphicon glyphicon-repeat"></span> <?php _e('Reload', 'text_domain') ?>
				</button>
			</span>
			<?php echo PB_Tag::text(array(
				'name'         => 'captcha', 
				'id'           => 'captcha',													
				'class'        => 'form-control', 
				'placeholder'  => __('TYPE WORD*', 'text_doamin'), 
				'required'     => 'required', 
				'autocomplete' => 'off', 
				'maxlength'    => 8)
			) ?>
		</div>
	</div>
	<?php endif ?>

	<br><br>
	
	<button class="btn btn-primary btn-lg" id="submit" name="submit" type="submit"><span class="glyphicon glyphicon-send"></span> <?php echo $submit_label ?></button>
	
	<?php if (!empty($messages['fail'])) : ?>
	<div class="alert alert-danger" style="display: none">
		<strong><?php echo $messages['fail']?></strong>
	</div>
	<?php endif ?>
	
	<?php if (!empty($messages['success'])) : ?>
	<div class="alert alert-success" style="display: none">
		<?php echo $messages['success']?>
	</div>
	<?php endif ?>
</form>
<?php endif?>
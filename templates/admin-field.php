<?php 
$i = 1 ?>
<div class="accordion paperboot-fields">
	<?php if(is_array($attributes) && count($attributes) > 0) : ?>
	<div class="sort-container edit">
		<?php foreach($attributes as $field) : ?>
		<div class="menu-settings sort-element" id="pb_field_<?php echo $i ?>" data-sort="<?php echo $i ?>">				
			<ul class="toolbar-field">
				<li>
					<button class="button-secondary delete">&times;</button>
				</li>
				<li>
					<button class="button-secondary order">&#8597;</button>
				</li>
			</ul>
			<div class="accord-header">
				<h2 class="with-label" <?php echo empty($field['label']) ? 'style="display: none"' : null ?>><?php _e($field['label'], 'text_domain') ?></h2>
				<h2 class="no-label" <?php echo !empty($field['label']) ? 'style="display: none"' : null ?>><?php _e('Field ' . $i, 'text_domain') ?></h2>
			</div>
			
			<div class="accord-content">
				<br>
				

				
				<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-settings.php') ?>
				<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-parameters.php') ?>
				<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-validation-rules.php') ?>
			</div>
			
		</div>
		<?php $i ++; endforeach ?>
	</div>
	<br>
	<?php endif ?>
	
	<button class="button-secondary accord-header">&#43; <?php echo __('New Field', 'text_domain') ?></button>
	
	<div class="accord-content menu-settings add" style="border-top: none" id="pb_field_<?php echo $i ?>">
		<br>
		<?php unset($field)?>
		<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-settings.php') ?>
		<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-parameters.php') ?>
		<?php include(plugin_dir_path(__FILE__) . '../templates/admin-field-validation-rules.php') ?>
	</div>
</div>
<?php if($show_listing) : ?>
	<?php if($is_authorized == true && !is_super_admin()) {
		return;
	}
	?>
	<?php if ($posts) : ?>
	<br>
	<?php foreach($posts as $post) : ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $post->post_title ?></h3>
			</div>
			<div class="panel-body" style="height: auto">
				<?php if(!empty($settings['fields'])) : ?>
				<dl>
					<?php foreach ($settings['fields'] as $field) : 
					$name = Paper_Boot_Form::get_pb_field_name($field) ?>
					<dt><?php echo $field['label'] ?></dt>
					<dd><?php echo get_post_meta($post->ID, '_' . $name, true); ?></dd>
					<?php endforeach ?>
				</dl>
				<?php endif ?>
			</div>
			<div class="panel-footer">
				<time><small><?php echo mysql2date(get_option('date_format', 'j M Y'), $post->post_modified) ?></small></time>
			</div>
		</div>
	<?php endforeach ?>
	<?php endif?>
<?php endif?>
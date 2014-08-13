<?php echo $before_widget ?>
<?php echo $title ? $before_title . $title . $after_title : null ?>
<?php echo $before_body ?>

<?php include('widget-form.php') ?>
<?php include('widget-posts.php') ?>

<?php echo $after_body ?>
<?php echo $after_widget ?>
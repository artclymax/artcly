<?php
function mx_logo($text = '')
{
	if (has_custom_logo()) {
		the_custom_logo();
	} else {
		?>
		<a href="<?php echo esc_url(home_url('/')); ?>" class="logo__link">
			<?php echo $text ?: get_bloginfo('name'); ?>
		</a>
		<?php
	}
}


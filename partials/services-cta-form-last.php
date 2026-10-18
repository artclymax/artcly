<?php
$page = 'options';
$bg = get_template_directory_uri() . '/assets/images/decor/decor-form.png';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
?>
<section class="section section-form section-cta-form-last" id="section-cta-form-last"
	style="--decor-bg: url('<?php echo esc_url($bg) ?>'); --vb: url('<?php echo esc_url($vb) ?>');">
	<div class="container section-cta-form-last__container">
		<div class="section-cta-form-last__body">
			<h3 class="section-cta-form-last__subtitle title-3">Остались вопросы? Задайте их и мы ответим</h3>
			<?php echo do_shortcode('[contact-form-7 id="bc15856" title="Остались вопросы - SEO"]'); ?>
		</div>
	</div>
</section>
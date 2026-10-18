<?php
$page = 'options';

$title = get_field('quiz_title', $page) ?? '';

?>
<section class="section section-quiz" id="section-quiz">
	<h2 class="section-reviews__title title-1 title-mix mb-title descr">
		<?php echo wp_kses_post($title) ?>
	</h2>
	<div class="container section-quiz__container">
		<?php echo do_shortcode('[contact-form-7 id="661b491" title="Узнайте стоимость продвижения вашего бизнеса за 1 минуту"]') ?>
	</div>
</section>
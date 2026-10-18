<?php
$title = get_field('single_services_faq_title') ?? '';
$descr = get_field('single_services_faq_descr') ?? '';
$list = get_field('single_services_faq_list') ?? '';
$image = get_field('single_services_faq_image') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-faq" id="services-faq">
		<div class="container services-faq__container">
			<h2 class="services-faq__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="services-faq__list">
				<?php foreach ($list as $index => $item): ?>
				<li class="services-faq-item <?= $index ?: 'spoiler-active'?>" data-spoiler>
					<button class="services-faq-item__btn" data-spoiler-title>
						<h3 class="services-faq-item__title title-3">
							<?php echo esc_html($item['single_services_faq_list_title'])?>
						</h3>
						<span class="services-faq-item__icon"></span>
					</button>
					<div class="services-faq-item__content" data-spoiler-content>
						<div class="services-faq-item__descr descr">
							<?php echo wp_kses_post($item['single_services_faq_list_descr'])?>
						</div>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
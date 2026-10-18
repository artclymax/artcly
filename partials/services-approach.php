<?php
$title = get_field('single_services_approach_title') ?? '';
$descr = get_field('single_services_approach_descr') ?? '';
$list = get_field('single_services_approach_list') ?? '';
$image = get_field('single_services_approach_image') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-approach" id="services-approach">
		<div class="container services-approach__container">
			<h2 class="services-approach__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="services-approach__wrapper">
				<div class="services-approach__tab-btns-wrapper">
					<ul class="services-approach__tab-btns approach-tab-btns">
						<?php foreach ($list as $index => $item): ?>
							<li class="approach-tab-btns__item">
								<a class="approach-tab-btns__btn" href="#approach-tab-<?= $index ?>" data-tabs-btn>
									<?php echo esc_html($item['single_services_approach_list_title']) ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<ul class="services-approach__list approach-tab-tabs">
					<?php foreach ($list as $index => $item): ?>
						<li class="approach-tab-tabs__item" id="approach-tab-<?= $index ?>" data-tabs-tab>
							<div class="approach-tab-tabs__content">
								<h3 class="approach-tab-tabs__title title-3">
									<?php echo esc_html($item['single_services_approach_list_title']) ?>
								</h3>
								<div class="approach-tab-tabs__descr descr">
									<?php echo wp_kses_post($item['single_services_approach_list_descr']) ?>
								</div>
							</div>
							<div class="approach-tab-tabs__image">
								<?php echo wp_get_attachment_image(
									$item['single_services_approach_list_image']['ID'],
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $item['single_services_approach_list_image']['alt'] ?: $item['single_services_approach_list_title']
									)
								); ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="services-approach__form">
				<?php echo do_shortcode('[contact-form-7 id="abd4879" title="Получить консультацию мини-секция"]') ?>
			</div>
		</div>
	</section>
<?php endif; ?>
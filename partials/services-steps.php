<?php
$title = get_field('single_services_steps_title') ?? '';
$descr = get_field('single_services_steps_descr') ?? '';
$list = get_field('single_services_steps_list') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-steps process" id="process">
		<div class="container process__container">
			<div class="process__content mb-title">
				<h2 class="process__title title-1 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<div class="process__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			</div>

			<ul class="process__list grid">
				<?php foreach ($list as $item): ?>
					<li class="process__item process-item dark-glass-card">
						<h3 class="process-item__title title-3">
							<?php echo esc_html($item['single_services_steps_list_title']) ?>
						</h3>
						<div class="descr process-item__descr">
							<?php echo wp_kses_post($item['opisanie']) ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<a class="services-steps__btn btn" href="#section-form">Получить консультацию</a>
		</div>
	</section>
<?php endif; ?>
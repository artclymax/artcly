<?php
$title = get_field('services_crm_steps_title') ?? '';
$list = get_field('services_crm_steps_list') ?? '';
?>
<?php if ($list): ?>
	<section class="section services-crm-steps" id="services-crm-steps">
		<div class="container services-crm-steps__container">
			<h2 class="services-crm-steps__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="services-crm-steps__list grid">
				<?php foreach ($list as $item): ?>
					<li class="dark-glass-card services-crm-steps__item services-crm-steps-card">
						<h3 class="services-crm-steps-card__title title-3">
							<?php echo esc_html($item['services_crm_steps_list_title']) ?>
						</h3>
						<div class="services-crm-steps-card__descr descr">
							<?php echo wp_kses_post($item['services_crm_steps_list_descr']) ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
<?php
$title = get_field('single_services_benefits_title') ?? '';
$descr = get_field('single_services_benefits_descr') ?? '';
$list = get_field('single_services_benefits_list') ?? '';
$column = get_field('single_services_benefits_column') ?: 3;

?>
<?php if ($list): ?>
	<section class="section services-benefits" id="services-benefits">
		<div class="container services-benefits__container">
			<h2 class="services-benefits__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<?php if ($descr): ?>
				<div class="services-benefits__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			<?php endif; ?>
			<ul class="services-benefits__list grid" style="--cols: <?= esc_attr($column) ?>;">
				<?php foreach ($list as $item): ?>
					<li class="services-benefits__item light-glass-card services-benefits-item icon icon--benefits-check">
						<?php echo esc_html($item['single_services_benefits_list_text']) ?>
					</li>
				<?php endforeach; ?>
			</ul>
			
		</div>
	</section>
<?php endif; ?>
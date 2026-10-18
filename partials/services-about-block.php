<?php
$title = get_field('services_about_block_title') ?? '';
$list = get_field('services_about_block_list') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-about-block" id="services-about-block">
		<div class="container services-about-block__container">
			<h2 class="services-about-block__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="services-about-block__list">
				<?php foreach ($list as $item): ?>
					<div class="services-about-block__item descr">
						<?php echo wp_kses_post($item['services_about_block_list_descr']) ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
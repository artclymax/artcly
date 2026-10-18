<?php
$page = 'options';

$title = get_field('process_title', $page) ?? '';
$descr = get_field('process_descr', $page) ?? '';
$list = get_field('process_list', $page) ?? '';

?>
<?php if ($list): ?>
	<section class="section process" id="process"
		style="background-image: url('<?php echo esc_attr(get_template_directory_uri() . '/assets/images/decor/decor-3.png') ?>');">
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
							<?php echo esc_html($item['title']) ?>
						</h3>
						<div class="descr process-item__descr">
							<?php echo wp_kses_post($item['descr']) ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
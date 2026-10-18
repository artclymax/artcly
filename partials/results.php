<?php
$page = 'options';

$title = get_field('results_title', $page) ?? '';
$list = get_field('results_list', $page) ?? '';

?>
<?php if ($list): ?>
	<section class="section results" id="results">
		<div class="container results__container">
			<h2 class="results__title title-1 title-mix descr mb-title">
				<?php echo wp_kses_post($title) ?>
			</h2>

			<ul class="results__list grid">
				<?php foreach ($list as $item): ?>
					<li class="results__item results-item">
						<div class="results-item__icon">
							<?php echo wp_get_attachment_image(
								$item['image']['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $item['image']['alt'] ?: $item['title']
								)
							); ?>
						</div>
						<h3 class="results-item__title text-2">
							<?php echo esc_html($item['title']) ?>
						</h3>
						<div class="results-item__hint dark-glass-card">
							<h3 class="results-item__hint-title text-2">
								<?php echo esc_html($item['title']) ?>
							</h3>
							<div class="descr results-item__descr">
								<?php echo wp_kses_post($item['descr']) ?>
							</div>
						</div>

					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
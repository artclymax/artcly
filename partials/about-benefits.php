<?php
$page = 'options';

$title = get_field('about_benefits_title', $page) ?? '';
$list = get_field('about_benefits_list', $page) ?? '';
$image = get_field('about_benefits_image', $page) ?? '';

$bg = $args['bg']
?>
<?php if ($list): ?>
	<section class="section about-benefits" id="about-benefits" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
		<div class="container about-benefits__container">
			<h2 class="about-benefits__title title-1 descr mb-title title-mix">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="about-benefits__list grid">
				<?php foreach ($list as $item): ?>
					<!-- ITEM -->
					<li class="about-benefits__item about-benefits-item dark-glass-card">
						<div class="about-benefits-item__images">
							<?php echo wp_get_attachment_image(
								$item['about_benefits_list_image']['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $item['about_benefits_list_image']['alt'] ?: $item['about_benefits_list_title']
								)
							); ?>
						</div>
						<h3 class="about-benefits-item__title title-2">
							<?php echo esc_html($item['about_benefits_list_title']) ?>
						</h3>
						<div class="descr about-benefits-item__descr">
							<?php echo wp_kses_post($item['about_benefits_list_descr']) ?>
						</div>
					</li>
				<?php endforeach; ?>
				<?php if ($image): ?>
					<li class="about-benefits__item about-benefits-item about-benefits-item--decor-image dark-glass-card">
						<div class="about-benefits-item__decor-image image-box">
							<?php echo wp_get_attachment_image(
								$image['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $image['alt'] ?: ''
								)
							); ?>
						</div>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
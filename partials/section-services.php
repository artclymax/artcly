<?php
$page = 'options';

$title = get_field('section_services_title', $page) ?? '';
$list = get_field('section_services_list', $page) ?? '';

?>
<?php if ($list): ?>
	<section class="section section-services" id="section-services" style="--decor-1: url('<?php echo esc_attr(get_template_directory_uri() . '/assets/images/decor/decor-1.png') ?>');">
		<div class="container section-services__container">
			<h2 class="section-services__title title-1 title-mix mb-title descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="section-services__list grid">
				<?php foreach ($list as $item): ?>
					<li class="section-services__item section-services-item light-glass-card">
						<div class="section-services-item__icon">
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
						<h3 class="section-services-item__title title-2">
							<?php echo esc_html($item['title']) ?>
						</h3>
						<div class="descr section-services-item__descr">
							<?php echo wp_kses_post($item['descr']) ?>
						</div>
						<a class="section-services-item__link text-btn link" href="<?php echo esc_attr($item['link']['url']) ?>">
							<span>
								<?php echo esc_html($item['link']['title']) ?>
							</span>
							<svg width="26" height="8" viewBox="0 0 26 8" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M25.3536 4.35355C25.5488 4.15829 25.5488 3.84171 25.3536 3.64645L22.1716 0.464466C21.9763 0.269204 21.6597 0.269204 21.4645 0.464466C21.2692 0.659728 21.2692 0.976311 21.4645 1.17157L24.2929 4L21.4645 6.82843C21.2692 7.02369 21.2692 7.34027 21.4645 7.53553C21.6597 7.7308 21.9763 7.7308 22.1716 7.53553L25.3536 4.35355ZM0 4V4.5H25V4V3.5H0V4Z"
									fill="currentColor" />
							</svg>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
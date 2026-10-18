<?php
$page = 'options';

$title = get_field('about_section_title', $page) ?? '';
$descr = get_field('about_section_descr', $page) ?? '';
$btn = get_field('about_section_btn', $page) ?? '';
$list = get_field('about_section_list', $page) ?? '';
$has_btn = $args['has_btn'] ?? false;
$bg = $args['bg'] ?? '';
$class = $args['class'] ?? '';

?>
<section class="section section-about <?php echo esc_attr($class); ?>" id="section-about" style="background-image: url('<?php echo esc_attr($bg); ?>')">
	<div class="container section-about__container">
		<div class="section-about__content">
			<h2 class="section-about__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="section-about__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
		</div>
		<ul class="section-about__list grid">
			<?php foreach ($list as $item): ?>
				<li class="section-about__item section-about-item light-glass-card">
					<h3 class="section-about-item__title">
						<?php echo esc_html($item['title']) ?>
					</h3>
					<div class="section-about-item__descr descr">
						<?php echo wp_kses_post($item['descr']) ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if ($has_btn): ?>
			<a class="section-about__btn btn" href="<?php echo esc_attr($btn['url']) ?>">
				<?php echo esc_html($btn['title']) ?>
			</a>
		<?php endif; ?>
	</div>
</section>
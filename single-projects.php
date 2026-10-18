<?php get_header(); ?>
<?php get_template_part('partials/hero-single-projects', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/reviews-page-decor.png']); ?>

<?php
$current_id = get_the_ID();

$args = array(
	'post_type' => 'projects',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);

$projects = get_posts($args);

?>
<div class="section container single-projects-content descr">
	<?php if (get_field('case_content_blocks')): ?>
		<div class="single-projects-content__box projects-box">
			<h2 class="projects-box__title title-1"><?php the_field('case_content_title') ?></h2>
			<div class="projects-box__blocks">
				<?php foreach (get_field('case_content_blocks') as $item): ?>
					<div class="projects-box__box project-about">
						<h2 class="project-about__title">
							<?php echo esc_html($item['title']) ?>
						</h2>
						<div class="project-about__descr descr">
							<?php echo wp_kses_post($item['descr']) ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="single-projects-content__content">
		<?php the_content() ?>
	</div>
	<div class="single-projects-gallery">
		<?php if (get_field('case_main_gallery')['image'] ?? ''): ?>
			<div class="single-projects-gallery__main main-gallery">
				<h3 class="main-gallery__title title-2">
					<?php echo esc_html(get_field('case_main_gallery')['title']); ?>
				</h3>
				<div class="main-gallery__image">
					<img src="<?php echo esc_attr(get_field('case_main_gallery')['image']['url']) ?>" alt="">
				</div>
			</div>
		<?php endif; ?>
		<?php if (get_field('case_second_gallery') ?? ''): ?>
			<div class="single-projects-gallery__grid">
				<?php foreach (get_field('case_second_gallery') as $item): ?>
					<div class="single-projects-gallery__box">
						<?php if ($item['title']): ?>
							<h3 class="single-projects-gallery__title title-2">
								<?php echo esc_html($item['title']) ?>
							</h3>
						<?php endif; ?>
						<div class="single-projects-gallery__image">
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
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if (get_field('case_mockup') ?? ''): ?>
			<div class="single-projects-gallery__mockup image-box">
				<?php echo wp_get_attachment_image(
					get_field('case_mockup')['ID'],
					'large',
					false,
					array(
						'class' => 'img',
						'alt' => get_field('case_mockup')['alt'] ?: ''
					)
				); ?>
			</div>
		<?php endif; ?>
		<?php if (get_field('case_mobile_gallery') ?? ''): ?>
			<div class="single-projects-gallery__mobile gallery-mobile">
				<h2 class="gallery-mobile__title title-1">
					<?php echo esc_html(get_field('case_mobile_gallery')['title']); ?>
				</h2>
				<div class="swiper gallery-mobile-swiper" data-swiper="{'slidesPerView': 'auto', 'spaceBetween': 24 }">
					<div class="swiper-wrapper gallery-mobile-swiper__wrapper">
						<?php foreach (get_field('case_mobile_gallery')['gallery'] as $item): ?>
							<div class="swiper-slide gallery-mobile-slide">
								<div class="gallery-mobile-slide__wrapper">
									<img src="<?php echo esc_attr($item['url']) ?>"
										alt="<?php echo esc_html(get_field('case_mobile_gallery')['title']); ?>">
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination gallery-mobile-swiper__pagination visible-mobile"
						data-swiper-pagination=".gallery-mobile-swiper"></div>
				</div>
			</div>
		<?php endif; ?>
		<?php
		if ($projects) {
			$ids = wp_list_pluck($projects, 'ID');
			$current_index = array_search($current_id, $ids);

			if ($current_index !== false) {
				$next_index = ($current_index + 1) % count($ids);
				$next_id = $ids[$next_index];
				?>
				<a href="<?php echo get_permalink($next_id); ?>" class="single-projects-content__next-project-link">
					<span>Следующий кейс</span><svg width="26" height="9" viewBox="0 0 26 9" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M25.8536 4.85355C26.0488 4.65829 26.0488 4.34171 25.8536 4.14645L22.6716 0.964466C22.4763 0.769204 22.1597 0.769204 21.9645 0.964466C21.7692 1.15973 21.7692 1.47631 21.9645 1.67157L24.7929 4.5L21.9645 7.32843C21.7692 7.52369 21.7692 7.84027 21.9645 8.03553C22.1597 8.2308 22.4763 8.2308 22.6716 8.03553L25.8536 4.85355ZM0.5 4.5V5H25.5V4.5V4H0.5V4.5Z"
							fill="currentColor" />
					</svg>
				</a>
				<?php
			}
		}
		?>
	</div>
</div>

<?php get_template_part('partials/section-form'); ?>
<?php get_footer(); ?>
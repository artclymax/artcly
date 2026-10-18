<?php
$page = 'options';

$title = get_field('section_projects_title', $page) ?? '';
$btn = get_field('section_projects_btn', $page) ?? '';

$args = [
	'post_type' => 'projects',
	'posts_per_page' => 6,
	'orderby' => 'menu_order',
	'order' => 'ASC',
];

$query = new WP_Query($args);

$params = [
	'slidesPerView' => 1,
	'spaceBetween' => 24,
	'loop' => true,
];

$json = json_encode($params);
?>
<section class="section section-projects" id="section-projects">
	<div class="container section-projects__container">
		<h2 class="section-projects__title title-1 title-mix mb-title descr">
			<?php echo wp_kses_post($title) ?>
		</h2>
		<ul class="section-projects__list grid hidden-mobile">
			<?php
			if ($query->have_posts()):
				while ($query->have_posts()):
					$query->the_post();
					?>
					<li class="section-projects__item section-projects-item">
						<a class="section-projects-item__link" href="<?php the_permalink() ?>">

							<div class="section-projects-item__image image-box">
								<?php the_post_thumbnail('') ?>
							</div>
							<div class="section-projects-item__content">
								<h3 class="section-projects-item__title title-3">
									<?php the_title(); ?>
								</h3>
								<ul class="section-projects-item__category">
									<?php
									$categories = get_the_category();

									if (!empty($categories)):
										foreach ($categories as $category):

											// пропускаем категорию со slug `all`
											if ($category->slug === 'all') {
												continue;
											}
											?>
											<li class="section-projects-item__category-item">
												<?php echo esc_html($category->name); ?>
											</li>
											<?php
										endforeach;
									endif;
									?>
								</ul>
							</div>
						</a>
					</li>
					<?php
				endwhile;
			endif;
			?>
		</ul>
		<div class="swiper section-projects-swiper visible-mobile" data-swiper="<?php echo esc_attr($json) ?>">
			<div class="swiper-wrapper section-projects-swiper__wrapper">
				<?php
				if ($query->have_posts()):
					while ($query->have_posts()):
						$query->the_post();
						?>
						<div class="swiper-slide section-projects-slide">
							<div class="section-projects-slide__wrapper section-projects-item">
								<a class="section-projects-item__link" href="<?php the_permalink() ?>">

									<div class="section-projects-item__image image-box">
										<?php the_post_thumbnail('medium') ?>
									</div>
									<div class="section-projects-item__content">
										<h3 class="section-projects-item__title title-3">
											<?php the_title(); ?>
										</h3>
										<ul class="section-projects-item__category">
											<?php
											$categories = get_the_category();

											if (!empty($categories)):
												foreach ($categories as $category):

													// пропускаем категорию со slug `all`
													if ($category->slug === 'all') {
														continue;
													}
													?>
													<li class="section-projects-item__category-item">
														<?php echo esc_html($category->name); ?>
													</li>
													<?php
												endforeach;
											endif;
											?>
										</ul>
									</div>
								</a>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			<div class="swiper-pagination section-projects-swiper__pagination" data-swiper-pagination=".section-projects-swiper"></div>
		</div>
		<a class="section-projects__btn btn" href="<?php echo esc_attr($btn['url']) ?>">
			<?php echo esc_html($btn['title']) ?>
		</a>
	</div>
</section>
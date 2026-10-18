<?php
$bg = $args['bg'] ?? '';
$about = get_field('case_about') ?? '';
$tasks = get_field('case_tasks') ?? '';
$staff = get_field('case_staff') ?? '';
$tech = get_field('case_tech') ?? '';

$params = [
	'slidesPerView' => 'auto',
	'spaceBetween' => 8,
	'breakpoints' => [
		'768' => [
			'spaceBetween' => 24,
		]
	]
];

$json = json_encode($params);
?>

<section class="hero-single-projects" id="hero-single-projects" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
	<div class="container hero-single-projects__container">
		<div class="hero-single-projects__breadcrumbs breadcrumbs">
			<?php if (function_exists('bcn_display')) {
				bcn_display();
			} ?>
		</div>
		<h1 class="hero-single-projects__title title-first">
			<?php the_title() ?>
		</h1>
		<?php if ($about): ?>
			<div class="hero-single-projects__about project-about">
				<h2 class="project-about__title title-1">
					О проекте
				</h2>
				<div class="project-about__descr descr">
					<?php echo wp_kses_post($about) ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (get_field('case_main_image')): ?>
			<div class="hero-single-projects__image image-box">
				<?php echo wp_get_attachment_image(
					get_field('case_main_image')['ID'],
					'large',
					false,
					array(
						'class' => 'img',
						'alt' => get_field('case_main_image')['alt'] ?: ''
					)
				); ?>
			</div>
		<?php endif; ?>
		<?php if ($tasks): ?>
			<div class="hero-single-projects__about project-about">
				<h2 class="project-about__title title-1">
					Задача
				</h2>
				<div class="project-about__descr descr">
					<?php echo wp_kses_post($tasks) ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($staff): ?>
			<div class="hero-single-projects__staff project-staff">
				<h2 class="project-staff__title title-2">
					Специалисты проекта
				</h2>
				<ul class="project-staff__list">
					<?php foreach ($staff as $item): ?>
						<li class="title-3 project-staff__item light-glass-card ">
							<?php echo esc_html($item['title']) ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if ($tech): ?>
			<div class="hero-single-projects__tech project-tech">
				<h2 class="project-tech__title title-2">
					Использованные технологии и инструменты
				</h2>
				<div class="swiper projects-tech-swiper" data-swiper="<?php echo esc_attr($json) ?>">
					<div class="swiper-wrapper projects-tech-swiper__wrapper">
						<?php foreach ($tech as $item): ?>
							<div class="swiper-slide projects-tech-slide">
								<div class="projects-tech-slide__wrapper dark-glass-card">
									<div class="projects-tech-slide__image">
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
									<p class="projects-tech-slide__text title-3">
										<?php echo esc_html($item['title']) ?>
									</p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
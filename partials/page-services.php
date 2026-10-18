<?php
$bg = $args['bg'] ?? '';
?>

<section class="section page-projects page-services pt-0" id="page-services"
	style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container page-services__container">
		<?php
		$terms = get_terms([
			'taxonomy' => 'services_category',
			'hide_empty' => true,
		]);

		$current_term = get_queried_object();
		$is_tax = is_tax('services_category');

		$current_label = 'Все';

		if ($is_tax && !empty($current_term->name)) {
			$current_label = $current_term->name;
		}
		?>

		<?php if (!empty($terms) && !is_wp_error($terms)): ?>
			<div class="page-projects__category-select category-select visible-mobile" data-category-select>

				<button class="category-select__current icon icon--after icon--select" type="button">
					<span>
						<?php echo esc_html($current_label); ?>
					</span>
				</button>

				<ul class="dark-glass-card category-select__list">

					<!-- Все -->
					<li class="category-select__item">
						<a class="category-select__link <?php echo !$is_tax ? 'active' : ''; ?>"
							href="<?php echo esc_url(get_post_type_archive_link('services')); ?>">
							Все
						</a>
					</li>

					<?php foreach ($terms as $term):

						if ($term->slug === 'all')
							continue;

						$is_active = ($is_tax && $current_term->term_id === $term->term_id);
						?>

						<li class="category-select__item">
							<a class="category-select__link <?php echo $is_active ? 'active' : ''; ?>"
								href="<?php echo esc_url(get_term_link($term)); ?>">
								<?php echo esc_html($term->name); ?>
							</a>
						</li>

					<?php endforeach; ?>

				</ul>
			</div>
		<?php endif; ?>

		<?php
		$terms = get_terms([
			'taxonomy' => 'services_category',
			'hide_empty' => false,
		]);

		$current_term = get_queried_object();
		$is_tax = is_tax('services_category');
		?>

		<?php if (!empty($terms) && !is_wp_error($terms)): ?>
			<ul class="page-projects__category projects-category hidden-mobile">
				<!-- Кнопка "Все" -->
				<li class="projects-category__item">
					<a class="projects-category__link <?php echo !$is_tax ? 'active' : ''; ?>"
						href="<?php echo esc_url(get_post_type_archive_link('services')); ?>">
						Все
					</a>
				</li>

				<?php foreach ($terms as $term):

					// Пропускаем термин all
					if ($term->slug === 'all')
						continue;

					$is_active = ($is_tax && $current_term->term_id === $term->term_id);
					?>

					<li class="projects-category__item">
						<a class="projects-category__link <?php echo $is_active ? 'active' : ''; ?>"
							href="<?php echo esc_url(get_term_link($term)); ?>">
							<?php echo esc_html($term->name); ?>
						</a>
					</li>

				<?php endforeach; ?>

			</ul>
		<?php endif; ?>
		<ul class="page-services__list grid">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>
					<?php
					$service_terms = get_the_terms(get_the_ID(), 'services_category');
					?>
					<li class="light-glass-card page-services__item section-projects-card">
						<?php if ($service_terms && !is_wp_error($service_terms)): ?>
							<?php $term = array_shift($service_terms); ?>
							<div class="section-projects-card__category">
								<a href="<?php echo esc_url(get_term_link($term)); ?>">
									<?php echo esc_html($term->name); ?>
								</a>
							</div>
						<?php endif; ?>
						<a class="section-projects-card__link" href="<?php the_permalink() ?>">
							<h3 class="section-projects-card__title title-2">
								<?php the_title() ?>
							</h3>
							<div class="section-projects-card__descr descr">
								<?php echo wp_kses_post(get_field('services_hero_descr') ?? get_the_content()) ?>
							</div>
							<span class="section-projects-card__btn btn">
								Подробнее
							</span>
						</a>
					</li>

				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
		<div class="pagination-page page-services__pagination">
			<?php
			echo paginate_links([
				'total' => $wp_query->max_num_pages,
				'mid_size' => 1,
				'current' => max(1, get_query_var('paged')),
				'prev_next' => false
			]);
			?>
		</div>
	</div>
</section>
<?php
$bg = $args['bg'] ?? '';
?>


<section class="section page-projects pt-0" id="page-projects" style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container page-projects__container">
		<?php
		$terms = get_terms([
			'taxonomy' => 'projects_category',
			'hide_empty' => true,
		]);

		$current_term = get_queried_object();
		$is_tax = is_tax('projects_category');

		$current_label = 'Все';

		if ($is_tax && !empty($current_term->name)) {
			$current_label = $current_term->name;
		}
		?>

		<?php if (!empty($terms) && !is_wp_error($terms)): ?>
			<div class="page-projects__category-select category-select visible-mobile" data-category-select>

				<button class="category-select__current icon icon--after icon--select" type="button">
					<span><?php echo esc_html($current_label); ?></span>
				</button>

				<ul class="dark-glass-card category-select__list">

					<!-- Все -->
					<li class="category-select__item">
						<a class="category-select__link <?php echo !$is_tax ? 'active' : ''; ?>"
							href="<?php echo esc_url(get_post_type_archive_link('projects')); ?>">
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
			'taxonomy' => 'projects_category',
			'hide_empty' => true,
		]);

		$current_term = get_queried_object();
		$is_tax = is_tax('projects_category');
		?>

		<?php if (!empty($terms) && !is_wp_error($terms)): ?>
			<ul class="page-projects__category projects-category hidden-mobile">
				<!-- Кнопка "Все" -->
				<li class="projects-category__item">
					<a class="projects-category__link <?php echo !$is_tax ? 'active' : ''; ?>"
						href="<?php echo esc_url(get_post_type_archive_link('projects')); ?>">
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
		<ul class="page-projects__list grid">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>
					<li class="page-projects__item section-projects-item">
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

				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
		<div class="pagination-page page-projects__pagination">
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
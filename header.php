<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="wrapper">
		<?php
		$descr = get_field('header_descr', 'options') ?? get_bloginfo('description');
		$time = get_field('header_time', 'options') ?? [];
		$phones = get_field('header_phones', 'options') ?? [];
		$btn = get_field('header_btn', 'options') ?? '';
		?>
		<header class="header" data-auto-calc="header, height">
			<div class="header__container container">
				<div class="header__top">
					<div class="header__logo logo">
						<?php mx_logo(); ?>
						<p class="logo__descr">
							<?php echo esc_html($descr) ?>
						</p>
					</div>
					<?php if (!empty($time)): ?>
						<div class="header__time hidden-tablet">
							<p class="header__time-title">
								<?php echo esc_html($time['title']) ?>
							</p>
							<div class="header__time-descr descr">
								<?php echo wp_kses_post($time['descr']) ?>
							</div>
						</div>
					<?php endif; ?>
					<div class="header__theme-switcher theme-switcher hidden-tablet">
						<button class="theme-switcher__btn">
							<div class="theme-switcher__icon-box">
								<div class="theme-switcher__icons">
									<span class="theme-switcher__icon theme-switcher__icon--dark"></span>
									<span class="theme-switcher__icon theme-switcher__icon--light"></span>
								</div>
							</div>
							<div class="theme-switcher__area">
								<span class="theme-switcher__circle"></span>
							</div>
						</button>
					</div>
					<?php if (!empty($phones)): ?>
						<ul class="header__contacts hidden-tablet">
							<?php foreach ($phones as $item): ?>
								<li class="header__contacts-item header-contacts-item">
									<a class="header-contacts-item__link"
										href="tel:+<?php echo esc_attr(correct_phone($item['phone'])); ?>">
										<?php echo esc_html($item['phone']) ?>
									</a>
									<?php if ($item['messengers']): ?>
										<div class="header-contacts-item__messengers">
											<?php foreach ($item['messengers'] as $msg): ?>
												<?php if ($msg == 'Вайбер'): ?>
													<a class="header-contacts-item__link-icon"
														href="viber://chat?number=<?php echo esc_attr(correct_phone($item['phone'])); ?>"
														aria-label="Вайбер">
														<img
															src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/vb.svg') ?>"
															alt="Вайбер">
													</a>
												<?php endif; ?>
												<?php if ($msg == 'Телеграм'): ?>
													<a class="header-contacts-item__link-icon"
														href="https://t.me/+<?php echo esc_attr(correct_phone($item['phone'])); ?>"
														aria-label="Телеграм">
														<img
															src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/tg.svg') ?>"
															alt="Телеграм">
													</a>
												<?php endif; ?>
												<?php if ($msg == 'Ватсап'): ?>
													<a class="header-contacts-item__link-icon"
														href="https://wa.me/<?php echo esc_attr(correct_phone($item['phone'])); ?>"
														aria-label="Ватсап">
														<img
															src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/wh.svg') ?>"
															alt="Ватсап">
													</a>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<a class="header__btn btn hidden-tablet" href="<?php echo esc_attr($btn['url']) ?>">
						<?php echo esc_html($btn['title']) ?>
					</a>
					<button class="header__phone-btn phone-btn visible-tablet" aria-label="Открыть телефоны для связи">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M8.92416 4.52866C8.64536 3.59858 8.45364 2.64458 8.3515 1.67899C8.24945 0.716318 7.40897 0 6.4411 0H1.95078C0.795705 0 -0.0935178 0.997774 0.00788485 2.14765C1.03166 13.7368 10.2632 22.9677 21.8523 23.9921C23.0029 24.0935 24 23.2075 24 22.0524V18.0483C24 16.5871 23.2837 15.7499 22.321 15.6478C21.3554 15.5459 20.4014 15.3544 19.4713 15.0758C18.9199 14.9123 18.3345 14.9011 17.7771 15.0433C17.2198 15.1856 16.7114 15.476 16.3058 15.8838L14.3837 17.8059C10.9174 15.928 8.07199 13.0826 6.19409 9.61634L8.11619 7.69424C8.5241 7.28867 8.81465 6.78027 8.95701 6.22295C9.09937 5.66563 9.0876 5.08017 8.92416 4.52866Z"
								fill="url(#paint0_linear_3603_14390)" />
							<defs>
								<linearGradient id="paint0_linear_3603_14390" x1="5.48148" y1="-0.327442" x2="19.4815"
									y2="23.9213" gradientUnits="userSpaceOnUse">
									<stop stop-color="#4C6FFF" />
									<stop offset="1" stop-color="#8254FF" />
								</linearGradient>
							</defs>
						</svg>
					</button>
					<button class="header__burger-btn burger-btn visible-tablet" type="button"
						aria-label="Открыть/закрыть меню">
						<span></span>
					</button>
				</div>
				<nav class="header__menu header-menu">
					<?php
					$menu = wp_nav_menu(
						array(
							'theme_location' => 'header-menu',
							'container' => false,
							'menu_class' => 'header-menu__list mega-menu',
							'depth' => 3
						)
					);
					echo htmlspecialchars($menu); ?>
					<div class="header-menu__box visible-tablet">
						<div class="header__time">
							<p class="header__time-title">
								<?php echo esc_html($time['title']) ?>
							</p>
							<div class="header__time-descr descr">
								<?php echo wp_kses_post($time['descr']) ?>
							</div>
						</div>
						<div class="header__theme-switcher theme-switcher">
							<button class="theme-switcher__btn">
								<div class="theme-switcher__icon-box">
									<div class="theme-switcher__icons">
										<span class="theme-switcher__icon theme-switcher__icon--dark"></span>
										<span class="theme-switcher__icon theme-switcher__icon--light"></span>
									</div>
								</div>
								<div class="theme-switcher__area">
									<span class="theme-switcher__circle"></span>
								</div>
							</button>
						</div>
					</div>
				</nav>
				<div class="header__phones-menu phones-menu visible-tablet">
					<?php get_template_part('partials/phones-box', null, ['class' => 'phones-menu__phones-box']); ?>
					<a class="phones-menu__btn btn" href="<?php echo esc_attr($btn['url']) ?>">
						<?php echo esc_html($btn['title']) ?>
					</a>
				</div>
			</div>
		</header>
		<main class="main">
			<?php if (!is_front_page() && !is_404() && !is_page('thank-you')): ?>
			<?php endif; ?>
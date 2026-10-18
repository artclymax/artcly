import 'jarallax/dist/jarallax.min.css';
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import './scss/style.scss';
import './scss/site-single-page.scss';
//!
import Swiper from "swiper/bundle";

import { jarallax } from "jarallax";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";

import { AutoCalc } from "./js/AutoCalc.js";
import { Menu } from './js/Menu.js';
import { RunningLine } from './js/RunningLine.js';
//import { BackdropList } from './js/BackdropList.js';
import { Modal } from './js/Modal.js';
import { cookies } from "./js/Cookies.js";
import { imask } from "./js/imask.js";
//import { fileBtn } from "./js/FileBtn.js";
//import { CustomFieldSelect } from "./js/CustomFieldSelect.js";
import { Spoiler } from './js/Spoiler.js';
//import { ScrollToTop } from './js/ScrollToTop.js';
import { MXSwiper } from './js/MXSwiper.js';
//import { CustomSelect } from './js/CustomSelect.js';
import { Tabs } from './js/Tabs.js';
import { FormValidator } from './js/FormValidator.js';

// FOR CONTACTS FORM 7
//import "./js/redirect-to-thanks-page.js";

new AutoCalc();
//new CustomFieldSelect({
//	input: '.form-wrapper .cf-select',
//	hasPlaceholder: false
//});
new Menu({
	btn: '.burger-btn',
	menu: '.header-menu',
	activeClass: 'open-header-menu',
	closeBtns: false
})

new Menu({
	btn: '.phone-btn',
	menu: '.phones-menu',
	activeClass: 'open-phone-menu',
})


//new BackdropList();

new Modal();

jarallax(document.querySelectorAll('.jarallax'), {
	speed: 0.2,
});

//cookies();
imask();

Fancybox.bind("[data-fancybox]");

new RunningLine();
//new ScrollToTop();

new Spoiler();

new MXSwiper();
//new CustomSelect({
//	selector: 'select'
//});
/*
window.addEventListener('scroll', function () {
	const header = document.querySelector('.header');

	if (window.scrollY > 50) {
		header.classList.add('scrolled');
	} else {
		header.classList.remove('scrolled');
		const valueUnits = header.offsetHeight;
		document.querySelector(':root').style.setProperty(`--header-height`, valueUnits + 'px');
	}
});
*/

//fileBtn();

new Tabs();
//document.querySelectorAll('video.wp-video-shortcode').forEach(video => {
//	if (!video.src) {
//		const link = video.querySelector('a');
//		if (link) video.src = link.href;
//	}
//});

const root = document.documentElement;
const toggles = document.querySelectorAll('.theme-switcher__btn');

/* init theme */
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
	root.setAttribute('data-theme', savedTheme);
} else {
	const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
	root.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
}

/* sync checkboxes (если есть) */
toggles.forEach(toggle => {
	if (toggle.type === 'checkbox') {
		toggle.checked = root.getAttribute('data-theme') === 'dark';
	}
});

/* toggle theme */
toggles.forEach(toggle => {
	toggle.addEventListener('click', () => {
		const current = root.getAttribute('data-theme');
		const next = current === 'dark' ? 'light' : 'dark';

		root.setAttribute('data-theme', next);
		localStorage.setItem('theme', next);

		// синхронизируем все кнопки
		toggles.forEach(t => {
			if (t.type === 'checkbox') {
				t.checked = next === 'dark';
			}
		});
	});
});


/**
 * Мегаменю - простое открытие/закрытие по клику
 */
/*
document.addEventListener('DOMContentLoaded', function () {
	const menuItems = document.querySelectorAll('.mega-menu > .menu-item-has-children');

	menuItems.forEach(function (item) {
		const link = item.querySelector(':scope > a');
		const submenu = item.querySelector(':scope > .sub-menu');

		if (link && submenu) {
			// Клик на ссылку
			link.addEventListener('click', function (e) {
				e.preventDefault(); // Предотвращаем переход по ссылке

				const isOpen = item.classList.contains('is-open');

				// Закрываем все остальные подменю
				menuItems.forEach(function (otherItem) {
					if (otherItem !== item) {
						otherItem.classList.remove('is-open');
					}
				});

				// Переключаем текущее подменю
				if (isOpen) {
					item.classList.remove('is-open');
				} else {
					item.classList.add('is-open');
				}
			});
		}
	});

	// Закрытие при клике вне меню
	document.addEventListener('click', function (e) {
		const isClickInsideMenu = e.target.closest('.mega-menu');

		if (!isClickInsideMenu) {
			menuItems.forEach(function (item) {
				item.classList.remove('is-open');
			});
		}
	});

	// Закрытие по клавише Escape
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			menuItems.forEach(function (item) {
				item.classList.remove('is-open');
			});
		}
	});
});
*/
document.addEventListener('DOMContentLoaded', function () {
	const menuItems = document.querySelectorAll('.mega-menu > .menu-item-has-children');
	const BREAKPOINT = 1024;

	function isTabletOrLess() {
		return window.innerWidth <= BREAKPOINT;
	}

	menuItems.forEach(function (item) {
		const link = item.querySelector(':scope > a');
		const submenu = item.querySelector(':scope > .sub-menu');

		if (link && submenu) {
			link.addEventListener('click', function (e) {

				if (!isTabletOrLess()) return;

				e.preventDefault();

				const isOpen = item.classList.contains('is-open');

				item.classList.toggle('is-open', !isOpen);
			});
		}
	});

	// Клик вне меню — тоже только до 1024px
	document.addEventListener('click', function (e) {
		if (!isTabletOrLess()) return;

		const isClickInsideMenu = e.target.closest('.mega-menu');
		if (!isClickInsideMenu) {
			menuItems.forEach(item => item.classList.remove('is-open'));
		}
	});

	// Escape — без ограничений (удобно и на десктопе)
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			menuItems.forEach(item => item.classList.remove('is-open'));
		}
	});
});

const megaMenu = document.querySelector('.mega-menu');

const parentsWithSub = megaMenu.querySelectorAll(
	':scope > .menu-item-has-children'
);

parentsWithSub.forEach(item => {
	item.addEventListener('mouseenter', () => {
		megaMenu.classList.add('has-sub-hover');
	});

	item.addEventListener('mouseleave', () => {
		megaMenu.classList.remove('has-sub-hover');
	});
});

//!==== Hero-swiper
const heroSwiperThumb = new Swiper('.hero-swiper-thumb', {
	loop: true,
	slidesPerView: 'auto',
	spaceBetween: 56,
	direction: "horizontal",
	watchSlidesProgress: true,
	autoplay: {
		delay: 3000,
		disableOnInteraction: false,
	},
	breakpoints: {
		769: {
			direction: "vertical",
		}
	}
})
document.addEventListener('DOMContentLoaded', function () {
	// change-checkbox-buttons
	const checkBoxElems = document.querySelectorAll('.form-radio input');

	checkBoxElems.forEach(el => {
		el.parentElement.classList.add(el.value)
		el.parentElement.title = el.value;
	})
})
document.addEventListener('DOMContentLoaded', () => {
	const selects = document.querySelectorAll('[data-category-select]');

	selects.forEach(select => {
		const button = select.querySelector('.category-select__current');

		button.addEventListener('click', () => {
			select.classList.toggle('is-open');
		});

		document.addEventListener('click', (e) => {
			if (!select.contains(e.target)) {
				select.classList.remove('is-open');
			}
		});
	});
});

//document?.querySelectorAll('.form-checkbox')?.forEach(el => {
//	el.checked = true;
//})

const servicesPriceBtns = document.querySelectorAll('.services-prices-card');

if (servicesPriceBtns.length) {
	servicesPriceBtns.forEach(btn => {
		btn.addEventListener('click', (e) => {
			const title = btn.querySelector('.services-prices-card__title');
			const input = document.querySelector('input[name="user_tariff"]');
			const modalTitle = document.querySelector('.modal-crm-title');
			const titleText = title.textContent.trim();
			modalTitle.textContent = titleText;
			if (input) {
				input.value = titleText;
			}
		})
	})
}

// Инициализация
//document.addEventListener('DOMContentLoaded', () => {
//	FormValidator.initAll('[data-form-validate]', {
//		disableSubmitUntilValid: true
//	});
//});

//document.querySelectorAll('form').forEach(form => {
//	console.log(form);
//	form.addEventListener('submit', (e) => {
//		e.preventDefault();
//	})
//})
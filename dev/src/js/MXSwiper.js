import Swiper from "swiper/bundle"; // ← Исправлено
import "swiper/swiper-bundle.css";

export class MXSwiper {
	constructor(selector = "[data-swiper]", paramsAttr = "data-swiper") {
		this.selector = selector;
		this.paramsAttr = paramsAttr;
		this.instances = []; // ← Сохраняем все инстансы

		// Безопасный запуск после загрузки DOM
		if (document.readyState === "loading") {
			document.addEventListener("DOMContentLoaded", () => this.init());
		} else {
			this.init();
		}
	}

	init() {
		const containers = document.querySelectorAll(this.selector);
		if (!containers.length) return;

		containers.forEach((container) => {
			try {
				// Безопасный парсинг параметров
				const rawParams = container.getAttribute(this.paramsAttr);
				if (!rawParams) {
					console.warn(`[MXSwiper] Отсутствует атрибут ${this.paramsAttr}`, container);
					return;
				}

				let params;
				try {
					params = JSON.parse(rawParams);
				} catch (e) {
					// Фолбэк для legacy-кода с одинарными кавычками
					params = JSON.parse(rawParams.replace(/'/g, '"'));
				}

				// Поиск элементов управления
				const findEl = (attr) =>
					[...document.querySelectorAll(`[${attr}]`)].find(
						(el) => el.dataset[attr.replace("data-swiper-", "")] && container.matches(el.dataset[attr.replace("data-swiper-", "")])
					);

				const btnPrev = findEl("data-swiper-btn-prev");
				const btnNext = findEl("data-swiper-btn-next");
				const pagination = findEl("data-swiper-pagination");
				const scrollbar = findEl("data-swiper-scrollbar");

				// Сборка конфига
				if (btnPrev || btnNext) {
					params.navigation = { prevEl: btnPrev, nextEl: btnNext };
				}
				if (pagination) {
					params.pagination = { el: pagination, clickable: true };
				}
				if (scrollbar) {
					params.scrollbar = { el: scrollbar, draggable: true };
				}

				// Инициализация
				const swiper = new Swiper(container, params);
				this.instances.push(swiper);

				// Swiper автоматически вешает инстанс на контейнер: container.swiper
				// Но явно пробросим для старых трекеров
				container.swiperInstance = swiper;
			} catch (error) {
				console.error("[MXSwiper] Ошибка инициализации:", error);
			}
		});
	}
}
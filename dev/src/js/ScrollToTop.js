export class ScrollToTop {
	constructor(selector, options) {
		const defaultOptions = {
			section: 'main > *:first-child',
			activeClass: 'active',
		}

		this.options = Object.assign(defaultOptions, options);
		this.selector = selector || '.scroll-to-top';
		this.btn = document.querySelector(this.selector);
		this.init();
	}

	toggleButton(btn, firstSection) {
		const firstSectionBottom = firstSection.offsetTop + firstSection.offsetHeight;
		if (window.scrollY > firstSectionBottom) {
			btn.classList.add(this.options.activeClass);
		} else {
			btn.classList.remove(this.options.activeClass);
		}
	}

	init() {
		const firstSection = document.querySelector(this.options.section);
		if (!firstSection) return;
		window.addEventListener('scroll', () => this.toggleButton(this.btn, firstSection));
	}
}

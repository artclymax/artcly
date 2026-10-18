export class Tabs {
	constructor(params = {}) {
		const defaultParams = {
			tab: '[data-tabs-tab]',
			link: '[data-tabs-btn]',
			activeClass: 'is-active',
		};

		this.params = { ...defaultParams, ...params };
		this.links = document.querySelectorAll(this.params.link);
		this.tabs = document.querySelectorAll(this.params.tab);

		this.init();
	}

	init() {
		if (!this.links.length || !this.tabs.length) return;

		this.openFromHash();

		this.links.forEach(link => {
			link.addEventListener('click', (e) => {
				e.preventDefault();
				const id = link.getAttribute('href');
				this.open(id, true);
			});
		});

		window.addEventListener('hashchange', () => this.openFromHash());
	}

	open(id, updateHash = false) {
		if (!id) return;

		const tab = document.querySelector(id);
		if (!tab) return;

		this.tabs.forEach(t => t.classList.remove(this.params.activeClass));
		this.links.forEach(l => l.classList.remove(this.params.activeClass));

		tab.classList.add(this.params.activeClass);

		const activeLink = [...this.links].find(l => l.getAttribute('href') === id);
		if (activeLink) activeLink.classList.add(this.params.activeClass);

		if (updateHash) history.replaceState(null, '', id);
	}

	openFromHash() {
		const hash = window.location.hash;
		
		const validLink = [...this.links].find(l => l.getAttribute('href') === hash);

		if (hash && validLink) {
			this.open(hash);
			return;
		}

		const firstLink = this.links[0];
		if (firstLink) this.open(firstLink.getAttribute('href'));
	}
}
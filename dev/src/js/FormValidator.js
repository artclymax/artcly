export class FormValidator {
	static defaults = {
		errorClass: 'form-no-validate',
		defaultLabel: 'Введите корректное значение',
		errorMsgClass: 'form-error-msg',
		triggerEvents: ['input', 'change', 'blur'],
		disableSubmitUntilValid: true,
		submitBtnSelector: 'button[type="submit"], input[type="submit"]'
	};

	constructor(form, options = {}) {
		this.form = form;
		this.options = { ...FormValidator.defaults, ...options };
		this.fields = [];
		this.submitBtn = null;
		this.rules = this._buildDefaultRules();
		this._init();
	}

	_init() {
		// 1. Жёсткое отключение нативной валидации (атрибут + свойство DOM)
		this.form.setAttribute('novalidate', 'novalidate');
		this.form.noValidate = true;

		// 2. Блокировка нативных тултипов required/type/pattern
		//    (true = фаза захвата, срабатывает ДО показа UI браузером)
		this.form.addEventListener('invalid', (e) => e.preventDefault(), true);

		// 3. Дальнейшая инициализация без изменений
		this.submitBtn = this.form.querySelector(this.options.submitBtnSelector);
		this._collectFields();
		this._bindEvents();
		this._updateSubmitButton();
	}
	_buildDefaultRules() {
		return {
			required: (val) => val.trim() !== '',
			email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
			url: (val) => /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/.test(val),
			number: (val) => /^-?\d*\.?\d+$/.test(val),
			pattern: (val, p) => new RegExp(p).test(val),
			minlength: (val, len) => val.length >= len,
			maxlength: (val, len) => val.length <= len,
			min: (val, m) => parseFloat(val) >= m,
			max: (val, m) => parseFloat(val) <= m
		};
	}

	_collectFields() {
		const fieldEls = this.form.querySelectorAll('input, select, textarea');
		this.fields = Array.from(fieldEls)
			.filter(el => el.type !== 'hidden' && el.type !== 'submit' && !el.disabled)
			.map(el => ({
				el,
				// Режим 1: обёртка с атрибутом | Режим 2: сам инпут
				target: el.closest('[data-form-validate-label]') || el,
				touched: false,
				isValid: false,
				errorMsgEl: null
			}));
	}

	_bindEvents() {
		this.fields.forEach(field => {
			this.options.triggerEvents.forEach(event => {
				field.el.addEventListener(event, () => this._handleFieldEvent(field));
			});
		});

		this.form.addEventListener('submit', (e) => this._handleSubmit(e));
		this.form.addEventListener('reset', () => this.reset());
	}

	_handleFieldEvent(field) {
		field.touched = true;
		this._validateField(field);
		this._updateSubmitButton();
	}

	_validateField(field) {
		const value = field.el.value;
		const el = field.el;

		// Если поле необязательное и пустое — считаем валидным
		if (!el.required && !value) {
			field.isValid = true;
			this._clearError(field.target, field);
			return true;
		}

		const rules = this._getFieldRules(el);
		let error = null;

		for (const [ruleName, config] of Object.entries(rules)) {
			const validator = this.rules[ruleName];
			if (!validator) continue;

			if (!validator(value, config)) {
				error = this._getErrorMessage(field.target);
				break;
			}
		}

		if (error) {
			field.isValid = false;
			this._showError(field.target, error, field);
		} else {
			field.isValid = true;
			this._clearError(field.target, field);
		}

		return field.isValid;
	}

	_getFieldRules(el) {
		const rules = {};
		if (el.required) rules.required = true;
		if (['email', 'url', 'number'].includes(el.type)) rules[el.type] = true;
		if (el.pattern) rules.pattern = el.pattern;
		if (el.minLength > 0) rules.minlength = el.minLength;
		if (el.maxLength > 0) rules.maxlength = el.maxLength;
		if (el.min !== '') rules.min = el.min;
		if (el.max !== '') rules.max = el.max;
		return rules;
	}

	_getErrorMessage(target) {
		return target.dataset.formValidateLabel || this.options.defaultLabel;
	}

	_showError(target, message, field) {
		target.classList.add(this.options.errorClass);

		if (!field.errorMsgEl) {
			field.errorMsgEl = document.createElement('span');
			field.errorMsgEl.className = this.options.errorMsgClass;
			field.errorMsgEl.setAttribute('role', 'alert');
			target.appendChild(field.errorMsgEl);
		}
		field.errorMsgEl.textContent = message;
	}

	_clearError(target, field) {
		target.classList.remove(this.options.errorClass);
		if (field.errorMsgEl) field.errorMsgEl.textContent = '';
	}

	_updateSubmitButton() {
		if (!this.submitBtn || !this.options.disableSubmitUntilValid) return;
		// Кнопка заблокирована, пока не все поля валидны
		this.submitBtn.disabled = !this.fields.every(f => f.isValid);
	}

	_handleSubmit(e) {
		let hasErrors = false;
		this.fields.forEach(field => {
			field.touched = true;
			if (!this._validateField(field)) hasErrors = true;
		});

		this._updateSubmitButton();

		if (hasErrors) {
			e.preventDefault();
			const firstInvalid = this.fields.find(f => !f.isValid);
			if (firstInvalid) firstInvalid.el.focus();
		}
	}

	// 🟢 Публичное API
	validate() {
		let isValid = true;
		this.fields.forEach(field => {
			field.touched = true;
			if (!this._validateField(field)) isValid = false;
		});
		this._updateSubmitButton();
		return isValid;
	}

	reset() {
		this.fields.forEach(field => {
			field.touched = false;
			field.isValid = false;
			this._clearError(field.target, field);
			if (field.errorMsgEl && field.errorMsgEl.parentNode) {
				field.errorMsgEl.parentNode.removeChild(field.errorMsgEl);
				field.errorMsgEl = null;
			}
		});
		this._updateSubmitButton();
	}

	destroy() {
		this.reset();
		this.form.noValidate = false;
		this.fields = [];
		this.submitBtn = null;
	}

	addRule(name, validatorFn) {
		this.rules[name] = validatorFn;
	}

	// Хелпер для автоинициализации
	static initAll(selector = '[data-validate-form]', options = {}) {
		document.querySelectorAll(selector).forEach(form => new FormValidator(form, options));
	}
}
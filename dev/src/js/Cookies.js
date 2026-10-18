export function cookies() {
	const banner = document.getElementById('cookie-banner');

	if (!banner) return;
	
	const acceptBtn = document.getElementById('cookie-accept');
	const declineBtn = document.getElementById('cookie-decline');
	const cookieName = 'cookie_consent';
	const cookieExpireDays = 365;

	// Функции работы с cookie
	function setCookie(name, value, days) {
		const d = new Date();
		d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
		document.cookie = name + "=" + value + "; path=/; max-age=" + (days * 24 * 60 * 60) + "; SameSite=Lax";
	}

	function getCookie(name) {
		const value = "; " + document.cookie;
		const parts = value.split("; " + name + "=");
		if (parts.length === 2) return parts.pop().split(";").shift();
		return null;
	}

	// Скрыть баннер, если cookie уже установлено
	if (getCookie(cookieName)) {
		banner.classList.add('hide');
	}

	// Обработчики кнопок
	acceptBtn.addEventListener('click', function () {
		setCookie(cookieName, 'accepted', cookieExpireDays);
		banner.classList.add('hide');
		// Здесь можно запускать скрипты аналитики
	});

	declineBtn.addEventListener('click', function () {
		setCookie(cookieName, 'declined', cookieExpireDays);
		banner.classList.add('hide');
		// Скрипты аналитики не запускаем
	});
}
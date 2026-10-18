<div class="modal" id="modal-crm" data-modal>
	<div class="modal__box modal-call__box" data-modal-box>
		<button class="modal-call__close-btn modal__close-btn modal-close-btn" data-modal-close aria-label="Закрыть">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 10L19 19M10 10L1 1M10 10L1 19M10 10L19 1" stroke="currentColor" stroke-width="2"
					stroke-linecap="round" />
			</svg>
		</button>
		<div class="modal__body">
			<h3 class="modal__title title-3">
				Тариф “<span class="modal-crm-title">название тарифа</span>”
			</h3>
			<div class="modal__form">
				<?php echo do_shortcode('[contact-form-7 id="c7a5550" title="Тариф"]') ?>
			</div>
		</div>
	</div>
</div>
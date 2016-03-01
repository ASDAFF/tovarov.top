<?
global $USER;
if (!$USER->IsAuthorized()){
	?>
	<div class="popup enter-popup" id="login">
		<div class="holder">
			<a href="#" class="btn-close">close</a> 
			<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", Array(
						"REGISTER_URL" => "#register",
						"PROFILE_URL" => SITE_DIR."personal/",
						"SHOW_ERRORS" => "Y"
					),
					false
				);?>
		</div>
	</div>
	<div class="popup forgot-popup" id="forgot">
		<div class="holder">
			<a href="#" class="btn-close">close</a> 
			<?$APPLICATION->IncludeComponent(
					"bitrix:system.auth.forgotpasswd",
					".default",
					Array()
				);?>
		</div>
	</div>
	<?
}
?>
<div class="popup" id="promo-popup">
	<div class="holder">
		<a href="#" class="btn-close">close</a>
		<div class="title">
			<h2>Как получить скидку</h2>
		</div>
		<p>Для того чтобы получить скидку участвуйте в наших программах лояльности и получайте промокоды на следующие покупки.</p>
	</div>
</div>
<div class="popup success-popup" id="order-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h2>СПАСИБО ЗА ПОКУПКУ</h2>
    <h3>Ваш заказ успешно оформлен</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="subscribe-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h2>СПАСИБО ЗА ПОДПИСКУ</h2>
    <h3>Ваш e-mail успешно добавлен</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="subscribe-unsuccess">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/sad-face.png" />
    <h2>ВОЗНИКЛА ОШИБКА </h2>
    <h3>Поле e-mail заполнено не верно</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="basket-success">
    <h2>Товар успешно добавлен в корзину.</h2>
    <a href="/personal/basket/" rel="nofollow">Перейти в корзину</a>
    <a href="#" class='btn-continue' rel="nofollow">Продолжить покупки</a>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="basket-fail">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h2>Произошла ошибка</h2>
    <h3>Извините вы не смогли заказать товар, возможно товар отсутствует на складе.</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="wishlist-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h3>Товар успешно добавлен в wishlist.</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="compare-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h3>Товар успешно добавлен к сравнению.</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<div class="popup success-popup" id="remove-basket-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h3>Товар успешно удален из корзины.</h3>
    <p>Если у вас есть вопросы закажите <a href="/ajax/callback.php" class='callback-popup-link' rel="nofollow">обратный звонок</a></p>
    <a href="#" class="btn-close">close</a>
</div>
<?
global $USER;
if($_GET['reg']=='Y' && $USER->IsAuthorized()){?>
    <script type="text/javascript">
        $(document).ready(function(){
			jQuery('#registration-success').bPopup({
					closeClass: 'btn-close',
					modalColor: '#fff'
			});
        })
    </script>
	<div class="popup success-popup" id="registration-success">
		<img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
		<h2>СПАСИБО ЗА РЕГИСТРАЦИЮ</h2>
		<p>Вы зарегистрированы на сервере и успешно авторизованы.</p>
		<a href="#" class="btn-close">close</a>
	</div>
<?}?>

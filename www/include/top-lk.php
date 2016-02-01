<?
	$isAuth = $USER->IsAuthorized();
	$lkUrl = ($isAuth?SITE_DIR."personal/":"javascript:void(0)");
?>
<div class="account-menu">
	<a href="<?=$lkUrl?>" class="account-link">Личный кабинет</a>
	<?if(!$isAuth):?>
		<ul class="account-drop">
			<li><a href="#login" class="link-enter popup-open" rel="nofollow">Войти</a></li>
			<li><a href="<?=SITE_DIR;?>ajax/registration.php" class="link-reg registry-popup-link" rel="nofollow">Зарегистрироваться</a></li>
		</ul>
	<?else:?>
		<ul class="account-drop">
			<li><a href="?logout=yes" class="link-enter">Выйти</a></li>
		</ul>
	<?endif?>
</div>
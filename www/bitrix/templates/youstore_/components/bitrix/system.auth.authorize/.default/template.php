<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>
	<div class="title">
		<h2><?=GetMessage("AUTH_AUTHORIZE")?></h2>
	</div>
	<?
	global $USER;
	if(!$USER->IsAuthorized() && $_POST['AUTH_FORM']=='Y' && $_POST['TYPE']=='AUTH'){?>
		<p class="error"><?=GetMessage("AUTH_ERR_WRANG")?></p>
		<script type="text/javascript">
			$(document).ready(function(e) {
				$('.btn-close').click();
				jQuery('#login').bPopup({
					closeClass: 'btn-close',
					modalColor: '#fff'
				});
			});
		</script>
	<?}?>
	<form name="form_auth" method="post" class="popup-form" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<fieldset>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
			<?if (strlen($arResult["BACKURL"]) > 0):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<div class="row">
				<input class="text" type="text" placeholder="<?=GetMessage("AUTH_LOGIN")?>" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
			</div>
			<div class="row">
				<input class="text" type="password" placeholder="<?=GetMessage("AUTH_PASSWORD")?>" name="USER_PASSWORD" maxlength="255" />
			</div>
			<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
				<div class="row">
					<div class="check-cell">
						<input type="checkbox" id="USER_REMEMBER" class="check" name="USER_REMEMBER" value="Y" />
						<label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER")?></label>
					</div>
				</div>
			<?endif?>
			<div class="row">
				<input type="submit" class='submit button' name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
				<div class="links">
					<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
						<noindex>
							<a class="popup-open" href="#forgot" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
						</noindex>
					<?endif?>
					<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
						<noindex>
							<a <?/*class="popup-open" href="#register"*/?> href="<?=SITE_DIR?>ajax/registration.php" class="registry-popup-link" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
						</noindex>
					<?endif?>
				</div>
			</div>
		</fieldset>
	</form>
	<script type="text/javascript">
		<?if (strlen($arResult["LAST_LOGIN"])>0):?>
			try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
		<?else:?>
			try{document.form_auth.USER_LOGIN.focus();}catch(e){}
		<?endif?>
	</script>

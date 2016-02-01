<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

$this->setFrameMode(true);?>

	<div class="title">
		<h2><?=GetMessage("AUTH_REGISTER")?></h2>
	</div>
	<?if($USER->IsAuthorized()):?>
		<?/*<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>*/?>
		<script>
			setAttr('reg','Y');
		</script>
	<?else:?>
		<?
		if (count($arResult["ERRORS"]) > 0):
			$numErrors = array();
			
			foreach ($arResult["ERRORS"] as $key => $error){
				if (is_numeric($key)){
					$numErrors[] = $error;
				}else{
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
				}
			}
			ShowError(implode("<br />", $numErrors));
		elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
		?>
			<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		<?endif?>
	<?/*------------------------*/?>
	
	<form method="post" action="<?=POST_FORM_ACTION_URI?>" class="popup-form" name="regform" enctype="multipart/form-data">
		<fieldset>
			<?
				if($arResult["BACKURL"] <> ''):
				?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?
				endif;
			?>
			<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
				<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
				<?else:?>
					<div class="row">
						<?
						switch ($FIELD)
						{
							case "PASSWORD":
								?><input class="text default" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off">
								<?
								break;
							case "CONFIRM_PASSWORD":
								?>
								<input class="text default" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off" /><?
								break;
							case "EMAIL":
								?>
								<input class="text default" type="email" required name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off" />
								<?
								break;
							default:
								?>
								<input class="text default" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off" />
								<?
							break;
						}?>
						<?if(!empty($arResult["ERRORS"][$FIELD])):?>
							<span class="error"><?=$arResult["ERRORS"][$FIELD]?></span>
						<?endif?>
					</div>
				<?endif?>
			<?endforeach?>
			<?// ******************** /User properties ***************************************************?>
			<?
			/* CAPTCHA */
			if ($arResult["USE_CAPTCHA"] == "Y")
			{
				?>
				<div class='row'>
					<div class="captcha-box">
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="162" alt="CAPTCHA" />
					</div>
					<input class="text short" type="text" name="captcha_word" maxlength="50" value="" />
				</div>
				<?
			}
			/* !CAPTCHA */
			?>
			<div class="row">
				<input type="submit" class="submit button" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
			</div>
		</fieldset>
	</form>
	
	<?/*if (count($arResult["ERRORS"]) > 0):?>
		<script>
			jQuery(function(){
				$id = "#register";
				jQuery($id).bPopup({
					closeClass: 'btn-close',
					modalColor: '#fff'
				});
			});
		</script>
	<?endif*/?>
<?endif?>
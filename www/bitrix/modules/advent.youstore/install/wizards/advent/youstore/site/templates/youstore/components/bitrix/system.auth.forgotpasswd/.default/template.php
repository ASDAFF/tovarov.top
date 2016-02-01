<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?

    ShowMessage($arParams["~AUTH_RESULT"]);

?>
<div class="title">
    <h2><?=GetMessage("AUTH_TITLE_FGP")?></h2>
</div>
<form name="bform" method="post" class="popup-form" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <fieldset>
        <?
            if (strlen($arResult["BACKURL"]) > 0)
            {
            ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">
        <p>
            <?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
        </p>

        <div class="row">
			<?if($arResult['EMAIL_WRANG'] == 'Y'){?>
				<p class="error"><?=GetMessage("AUTH_EMAIL_WRANG")?></p>
				<script type="text/javascript">
					$(document).ready(function(e) {
						$('.popup .btn-close').click();
						jQuery('#forgot').bPopup({
								closeClass: 'btn-close',
								modalColor: '#fff'
						});
					});
				</script>
			<?}?>
            <input type="email" required name="USER_EMAIL" class="text" placeholder="<?=GetMessage("AUTH_EMAIL")?>" maxlength="255" />
        </div>
        <div class="row">
            <input type="submit" class='submit button' name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
        </div>
        <p> 
            <a href="#login" class="popup-open"><b><?=GetMessage("AUTH_AUTH")?></b></a>
        </p> 
    </fieldset>
</form>
<script type="text/javascript">
    document.bform.USER_EMAIL.focus();
</script>

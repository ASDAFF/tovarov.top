<?
    if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
    /**
    * Bitrix vars
    *
    * @var array $arParams
    * @var array $arResult
    * @var CBitrixComponentTemplate $this
    * @global CMain $APPLICATION
    * @global CUser $USER
    */
?>
<div id="feedback">
    <?if(!empty($arResult["ERROR_MESSAGE"]))
        { ?>
        <div class="alert alert2">
            <a class="close" href="#">close</a>
            <div class="image-box">
                <img src="<?=$templateFolder?>/images/ico02.png" alt="#" width="53" height="46" />
            </div>
            <div class="text-box">
                <p><? foreach($arResult["ERROR_MESSAGE"] as $v)
                        echo $v.'<br/>';   ?></p>
            </div>
        </div>
        <?}?>

    <?
        if(strlen($arResult["OK_MESSAGE"]) > 0)
        {
        ?><script type="text/javascript">
            $(document).ready(function(){
                    jQuery('#feedback-success').bPopup({
                            closeClass: 'btn-close',
                            modalColor: '#fff'
                    });
            })
        </script>
        <?}  
    ?>

    <form class="contact-form" action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <input type="hidden" name="PARAMS" value='<?=json_encode($arParams)?>'>
        <?=bitrix_sessid_post()?>
        <fieldset>
            <div class="row">
                <input type="text" name="user_name" class="text" value="<?=$arResult["AUTHOR_NAME"]?>" placeholder="<?=GetMessage("MFT_NAME")?>" />
            </div>
            <div class="row">
                <div class="cell">
                    <input type="email" required name="user_email" class="text" value="<?=$arResult["AUTHOR_EMAIL"]?>" placeholder="<?=GetMessage("MFT_EMAIL")?>" />
                </div>
                <div class="cell">
                    <input type="text" name="user_phone" class="text" value="<?=$arResult["AUTHOR_PHONE"]?>" placeholder="<?=GetMessage('MFT_PHONE')?>" />
                </div>
            </div>
            <?if($arParams["USE_CAPTCHA"] == "Y"):?>
                <div class="row">
                    <div class="captcha-cell">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" alt="captcha" />
                        <input type="text" name="captcha_word" placeholder="<?=GetMessage('MFT_CAPTCHA_CODE')?>" class="text" />
                    </div>
                </div>
                <?endif;?>
            <div class="row">
                <input type="text" name="subject" class="text" value="<?=$arResult["SUBJECT"]?>" placeholder="<?=GetMessage("MFT_SUBJECT")?>" />
            </div>
            <div class="row">
                <textarea name="MESSAGE" placeholder="<?=GetMessage("MFT_MESSAGE")?>"><?=$arResult["MESSAGE"]?></textarea>
            </div>
            <div class="row">
                <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
                <input type="submit" name="submit" class="button" value="<?=GetMessage("MFT_SUBMIT")?>">
            </div>
        </fieldset>
    </form>

    <div class="popup success-popup" id="feedback-success">
        <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png">
        <h2><?=GetMessage('THANK')?></h2>
        <h3><?=GetMessage('OK_TEXT')?></h3>
        <a href="#" class="btn-close">close</a>
    </div>
</div>
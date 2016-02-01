<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $APPLICATION->SetPageProperty("prop-h1", GetMessage("AUTH_CHANGE_PASSWORD"));?>
<div class="contents">
    <div class="changepwd">

        <?
            ShowMessage($arParams["~AUTH_RESULT"]);
        ?>
        <h2><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h2>
        <form class="contact-form" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
            <fieldset>
                <?if (strlen($arResult["BACKURL"]) > 0): ?>
                    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                    <? endif ?>
                <input type="hidden" name="AUTH_FORM" value="Y">
                <input type="hidden" name="TYPE" value="CHANGE_PWD">
                <input type="hidden" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" />
                <div class="row ">

                    <input type="text" class="text" name="USER_LOGIN" maxlength="50" placeholder="<?=GetMessage("AUTH_LOGIN")?>" value="<?=$arResult["LAST_LOGIN"]?>"  />

                </div>		
                <span><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></span>
                <div class="row ">
                    <input type="password" class="text" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" />
                </div>
                <?if($arResult["SECURE_AUTH"]):?>
                    <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                        <div class="bx-auth-secure-icon"></div>
                    </span>
                    <noscript>
                        <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                            <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                        </span>
                    </noscript>
                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure').style.display = 'inline-block';
                    </script>
                    <?endif?>
                <span><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?> </span>
                <div class="row">
                    <input type="password" class="text" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" />
                </div>
                <input type="submit" class="button" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />


                <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>

                <p>
                    <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
                </p>
            </fieldset>
        </form>

        <script type="text/javascript">
            document.bform.USER_LOGIN.focus();
        </script>
    </div>
</div>
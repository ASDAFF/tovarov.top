<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$this->setFrameMode(true);?>
<div class="tab general">
    <div class="left">
        <div class="title">
            <h2><?=GetMessage('PROFILE_INFO')?></h2>
        </div>
        <div class="message">
            <?ShowError($arResult["strProfileError"]);?>
            <?
            if ($arResult['DATA_SAVED'] == 'Y')
                ShowNote(GetMessage('PROFILE_DATA_SAVED'));
            ?>
        </div>
        <div class="holder">
            <form class="account-form" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
                <fieldset>
                    <?=$arResult["BX_SESSION_CHECK"]?>
                    <input type="hidden" name="lang" value="<?=LANG?>" />
                    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
                    <div class="row">
                        <label><?=GetMessage('NAME')?></label>
                        <div class="text-holder">
                            <div class="cell">
                                <input class="text" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label><?=GetMessage('LOGIN')?></label>
                        <div class="text-holder">
                            <div class="cell">
                                <input class="text" type="text" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?for($i=1; $i<13; $i++){
                            $monthArr[$i]=GetMEssage('PROFILE_MONTH_'.$i);
                        }
                       
                        $bday = $arResult["arUser"]["PERSONAL_BIRTHDAY"];
                        list($day, $month, $year) = explode(".", $bday);
                        $day = intval($day);
                        $month = intval($month);
                        $year = intval($year);
                        ?>
                        <label><?=GetMessage('PROFILE_BIRTH')?></label>
                        <div class="text-holder">
                            <div class="cell day">
                                <select name="PERSONAL_BIRTHDAY_DAY">
                                    <option><?=GetMessage('PROFILE_DAY')?></option>
                                    <?for($i = 1; $i <= 31; $i++):?>
                                        <option <?if($i == $day) echo "selected='selected'";?> value="<?=$i?>"><?=$i?></option>
                                    <?endfor?>
                                </select>
                            </div>
                            <div class="cell month">
                                <select name="PERSONAL_BIRTHDAY_MONTH">
                                    <option><?=GetMessage('PROFILE_MONTH')?></option>
                                    <?foreach($monthArr as $i => $name):?>
                                        <option <?if($i == $month) echo "selected='selected'";?> value="<?=$i?>"><?=$name?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                            <div class="cell year">
                                <select name="PERSONAL_BIRTHDAY_YEAR">
                                    <option><?=GetMessage('PROFILE_YEAR')?></option>
                                    <?for($i = date('Y'); $i > 1930; $i--):?>
                                        <option <?if($i == $year) echo "selected='selected'";?> value="<?=$i?>"><?=$i?></option>
                                    <?endfor?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label><?=GetMessage('EMAIL')?></label>
                        <div class="text-holder">
                            <div class="cell">
                                <input class="text" type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="phone"><?=GetMessage('PROFILE_MOBILE')?></label>
                        <div class="text-holder">
                            <div class="cell">
                                <input type="text" id="phone" name="PERSONAL_PHONE" class="text" value="<? echo $arResult["arUser"]["PERSONAL_PHONE"]?>" placeholder="+7(___) ___-__-__">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label><?=GetMessage('PROFILE_ADRESS')?></label>
                        <div class="text-holder">
                            <div class="cell">
                                <input class="text" type="text" name="PERSONAL_STREET" maxlength="50" value="<? echo $arResult["arUser"]["PERSONAL_STREET"]?:" "?>" />
                            </div>
                        </div>
                    </div>
                    <?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
                        <div class="row">
                            <label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
                            <div class="text-holder">
                                <div class="cell">
                                    <input class="text" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
                            <div class="text-holder">
                                <div class="cell">
                                    <input class="text" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    <?endif?>

                    <?/*
                    <div class="row">
                        <div class="text-holder">
                            <div class="cell">
                                <?
                                    if($arResult["SOCSERV_ENABLED"])
                                    {
                                        $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "empty", array(
                                                "SHOW_PROFILES" => "Y",
                                                "ALLOW_DELETE" => "Y"
                                            ),
                                            $component
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    */?>

                    <div class="row">
                        <label>&nbsp;</label>
                        <div class="text-holder">
                            <div class="cell">
                                <a class="button" href="#" onclick="$('input[name=save]').click(); return false;"><?=GetMessage('SAVE')?></a>
                                <div class="hidden">
                                    <input type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="right">
        <div class="title">
            <h2><?=GetMessage('PROFILE_DELIVERY')?></h2>
            <a href="#"><?=GetMessage('PROFILE_ADDDELIVERY')?></a>
        </div>
        <div class="holder">
            <?
            $itemSize = count($arResult["DELIVERY_ADDR"]); 
            if($itemSize <= 0) echo GetMessage('PROFILE_NODELIVERY');
            foreach($arResult["DELIVERY_ADDR"] as $index => $delivery){?>
                <div class="account-pop">
                    <a href="#" class="btn-close">close</a>
                    <h2><?=$delivery["NAME"]?></h2>
                    <?foreach($delivery["PROPS"] as $prop):?>
                        <span class="name"><strong><?=$prop["NAME"]?>:</strong> <?=$prop["VALUE"]?></span><br/>
                    <?endforeach;?>
                    <div class="link-holder">
                        <a href="#" class="link-edit"><?=GetMessage('PROFILE_EDDELIVERY')?></a>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</div>

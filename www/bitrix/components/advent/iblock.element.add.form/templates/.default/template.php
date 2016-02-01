<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
    //echo "<pre>Template arParams: "; print_r($arParams); echo "</pre>";
    //echo "<pre>Template arResult: "; print_r($arResult); echo "</pre>";
    //exit();
?>
<?if (count($arResult["ERRORS"])):?>
    <?//=ShowError(implode("<br />", $arResult["ERRORS"]))?>
    <script type="text/javascript">
        $(document).ready(function(){
                $("input.req").each(function(index, elem){
                        if ($(elem).val().trim() == ''){
                            $(elem).css({'border-color':'red'});
                            bOk = false;
                        }else{
                            $(elem).css({'border-color':''});
                        }
                });
        })
    </script>
    <?endif?>     
<script type="text/javascript">
$(document).ready(function(){
$('input.phone').on('keyup keypress', function(e) {
   if (e.keyCode == 8 || e.keyCode == 46) {}
   else
     {
       var letters=' 1234567890()-';
                    return (letters.indexOf(String.fromCharCode(e.which))!=-1);
                }
}); });
  
</script>      
<?if (strlen($arResult["MESSAGE"]) > 0):?>
    <script type="text/javascript">
        $(document).ready(function(){
				$('.popup .btn-close').click();
                $('.call-popup').bPopup().close();
                jQuery('#callback-success').bPopup({
                        closeClass: 'btn-close',
                        modalColor: '#fff'
                });
        })
    </script>
    <?endif?>
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" class="popup-form" enctype="multipart/form-data">
    <fieldset>
        <?=bitrix_sessid_post()?>

        <?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
        <?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>

            <?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
                <?
                    //echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"]); echo "</pre>";
                    if (intval($propertyID) > 0)
                    {
                        if (
                            $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
                            &&
                            $arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
                        )
                            $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
                        elseif (
                            (
                                $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
                                ||
                                $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
                            )
                            &&
                            $arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
                        )
                            $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
                    }
                    elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
                        $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

                    if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
                    {
                        $inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
                        $inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
                    }
                    else
                    {
                        $inputNum = 1;
                    }

                    if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
                        $INPUT_TYPE = "USER_TYPE";
                    else
                        $INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

                    switch ($INPUT_TYPE):
                    case "USER_TYPE":
                        for ($i = 0; $i<$inputNum; $i++)
                        {
                            if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
                            {
                                $value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
                                $description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
                            }
                            elseif ($i == 0)
                            {
                                $value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
                                $description = "";
                            }
                            else
                            {
                                $value = "";
                                $description = "";
                            }
                            echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
                                array(
                                    $arResult["PROPERTY_LIST_FULL"][$propertyID],
                                    array(
                                        "VALUE" => $value,
                                        "DESCRIPTION" => $description,
                                    ),
                                    array(
                                        "VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
                                        "DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
                                        "FORM_NAME"=>"iblock_add",
                                    ),
                                ));
                        ?><?
                        }
                        break;
                    case "TAGS":
                        $APPLICATION->IncludeComponent(
                            "bitrix:search.tags.input",
                            "",
                            array(
                                "VALUE" => $arResult["ELEMENT"][$propertyID],
                                "NAME" => "PROPERTY[".$propertyID."][0]",
                                "TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
                            ), null, array("HIDE_ICONS"=>"Y")
                        );
                        break;
                    case "HTML":
                        $LHE = new CLightHTMLEditor;
                        $LHE->Show(array(
                                'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
                                'width' => '100%',
                                'height' => '200px',
                                'inputName' => "PROPERTY[".$propertyID."][0]",
                                'content' => $arResult["ELEMENT"][$propertyID],
                                'bUseFileDialogs' => false,
                                'bFloatingToolbar' => false,
                                'bArisingToolbar' => false,
                                'toolbarConfig' => array(
                                    'Bold', 'Italic', 'Underline', 'RemoveFormat',
                                    'CreateLink', 'DeleteLink', 'Image', 'Video',
                                    'BackColor', 'ForeColor',
                                    'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
                                    'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
                                    'StyleList', 'HeaderList',
                                    'FontList', 'FontSizeList',
                                ),
                            ));
                        break;
                    case "T":
                        for ($i = 0; $i<$inputNum; $i++)
                        {

                            if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
                            {
                                $value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
                            }
                            elseif ($i == 0)
                            {
                                $value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
                            }
                            else
                            {
                                $value = "";
                            }
                        ?>

                        <div class="row">
                            <textarea <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>class="required"<?endif?> cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" placeholder="<?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?>"><?=$value?></textarea>
                            <i class="fa fa-align-left"></i>
                        </div>
                        <?
                        }
                        break;

                    case "S":
                    case "N":
                        for ($i = 0; $i<$inputNum; $i++)
                        {
                            if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
                            {
                                $value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
                            }
                            elseif ($i == 0)
                            {
                                $value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

                            }
                            else
                            {
                                $value = "";
                            }
                        ?>
                        <?if($arResult['TOVAR_ID']!=$propertyID):?>
                            <div class="row">
                                <input name="PROPERTY[<?=$propertyID?>][<?=$i?>]" type="text" class="text <?=($arResult['PHONE_ID']==$propertyID)?'phone':''?> <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>req<?endif?>" value="<?=$value?>" placeholder="<?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?>" />
                            </div>
						<?else:?>
							<?if($arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"]=='TOVAR_CALLBACK' && strlen($arResult['DETAIL_ITEM']['NAME'])){?>
								<input name="PROPERTY[<?=$propertyID?>][<?=$i?>]" type="hidden" class="callback-tovar" value="<?=$arResult['DETAIL_ITEM']['NAME']?>" />
							<?}else{?>
								<input name="PROPERTY[<?=$propertyID?>][<?=$i?>]" type="hidden" class="callback-tovar" value="<?=$value?>" />
							<?}?>
						<?endif;?>

                        <?
                            if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
                                $APPLICATION->IncludeComponent(
                                    'bitrix:main.calendar',
                                    '',
                                    array(
                                        'FORM_NAME' => 'iblock_add',
                                        'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
                                        'INPUT_VALUE' => $value,
                                    ),
                                    null,
                                    array('HIDE_ICONS' => 'Y')
                                );
                            ?><small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small><?
                                endif
                        ?><?
                        }
                        break;
                    case "F":
                        for ($i = 0; $i<$inputNum; $i++)
                        {
                            $value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
                        ?>
                        <input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
                        <input type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" />
                        <?

                            if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
                            {
                            ?>
                            <input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label>
                            <?

                                if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
                                {
                                ?>
                                <img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" />
                                <?
                                }
                                else
                                {
                                ?>
                                <?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?>
                                <?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> 

                                [<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]
                                <?
                                }
                            }
                        }

                        break;
                    case "L":

                        if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
                            $type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
                        else
                            $type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

                        switch ($type):
                        case "checkbox":
                        case "radio":

                            //echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"][$propertyID]); echo "</pre>";

                            foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
                            {
                                $checked = false;
                                if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
                                {
                                    if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
                                    {
                                        foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
                                        {
                                            if ($arElEnum["VALUE"] == $key) {$checked = true; break;}
                                        }
                                    }
                                }
                                else
                                {
                                    if ($arEnum["DEF"] == "Y") $checked = true;
                                }

                            ?>
                            <input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label>
                            <?
                            }
                            break;

                        case "dropdown":
                        case "multiselect":
                        ?>
                        <select name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
                            <option value=""><?echo GetMessage("CT_BIEAF_PROPERTY_VALUE_NA")?></option>
                            <?
                                if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
                                else $sKey = "ELEMENT";

                                foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
                                {
                                    $checked = false;
                                    if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
                                    {
                                        foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
                                        {
                                            if ($key == $arElEnum["VALUE"]) {$checked = true; break;}
                                        }
                                    }
                                    else
                                    {
                                        if ($arEnum["DEF"] == "Y") $checked = true;
                                    }
                                ?>
                                <option value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
                                <?
                                }
                            ?>
                        </select>
                        <?
                            break;

                            endswitch;
                        break;
                        endswitch;?>

                <?endforeach;?>
            <?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
                <?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                <?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:
                <input type="text" name="captcha_word" maxlength="50" value="">
                <?endif?>

            <?endif?>
        <div class="row">
            <input type="submit" name="iblock_submit_c" class="submit button" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
        </div>
        <?if (strlen($arParams["LIST_URL"]) > 0 && $arParams["ID"] > 0):?><input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" /><?endif?>
        <?/*<input type="reset" value="<?=GetMessage("IBLOCK_FORM_RESET")?>" />*/?>
    </fieldset>
    <?if (strlen($arParams["LIST_URL"]) > 0):?><a href="<?=$arParams["LIST_URL"]?>"><?=GetMessage("IBLOCK_FORM_BACK")?></a><?endif?>
</form>

<div class="popup success-popup" id="callback-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h2><?=GetMessage('SUCCESS_H3')?></h2>
    <p><?=GetMessage('SUCCESS_P')?></p>
    <a href="#" class="btn-close">close</a>
</div>

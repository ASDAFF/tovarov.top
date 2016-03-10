<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID.'_pict',
    'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
    'STICKER_ID' => $strMainID.'_stricker',
    'BIG_SLIDER_ID' => $strMainID.'_big_slider',
    'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
    'SLIDER_LIST' => $strMainID.'_slider_list',
    'SLIDER_LEFT' => $strMainID.'_slider_left',
    'SLIDER_RIGHT' => $strMainID.'_slider_right',
    'OLD_PRICE' => $strMainID.'_old_price',
    'PRICE' => $strMainID.'_price',
    'DISCOUNT_PRICE' => $strMainID.'_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
    'QUANTITY' => $strMainID.'_quantity',
    'QUANTITY_DOWN' => $strMainID.'_quant_down',
    'QUANTITY_UP' => $strMainID.'_quant_up',
    'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
    'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
    'BUY_LINK' => $strMainID.'_buy_link',
    'QUICK_BUY_LINK' => $strMainID.'_quick_buy_link',
    'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
    'COMPARE_LINK' => $strMainID.'_compare_link',
    'PROP' => $strMainID.'_prop_',
    'PROP_DIV' => $strMainID.'_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
    'OFFER_GROUP' => $strMainID.'_set_group_',
    'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
    'ZOOM_DIV' => $strMainID.'_zoom_cont',
    'ZOOM_PICT' => $strMainID.'_zoom_pict',

    'AVAILABILITY_STATUS' => $strMainID."_avail_status"
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

$strTitle = (
    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
    : $arResult['NAME']
);
$strAlt = (
    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
    : $arResult['NAME']
);

if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])){
    foreach($arResult["OFFERS"] as &$offer){
        if($arResult["OFFERS"][$arResult['OFFERS_SELECTED']]["CATALOG_QUANTITY"] <= 0)
            $offer["CAN_BUY"] = false;
    }
}else{
    /*if($arResult["CATALOG_QUANTITY"] <= 0)
        $arResult["CAN_BUY"] = false;*/
}

if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
    $canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
}
else
{
    $canBuy = $arResult['CAN_BUY'] && !empty($arResult["MIN_PRICE"]);
}
if ($canBuy)
{
    $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
    $buyBtnClass = 'bx_big bx_bt_button bx_cart';
}
else
{
    $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
    $buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
}

?>
<link rel="stylesheet" href="<?=$templateFolder."/style.css?".time()?>" />

<div class="<?if(!$canBuy):?>unavailable<?endif?>" id="<? echo $arItemIDs['ID']; ?>">
    <div class="left">
        <div class="images-box">
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/photos.php")?>
        </div>
    </div>
    <div class="right">
        <div class="title-holder">
            <div class="include">
                <h2>
                    <? echo (
                    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                        ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                        : $arResult["NAME"]
                    ); ?>
                </h2>
            </div>
            <div class="marks">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:iblock.vote",
                    "5-stars-cnt",
                    array(
                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "ELEMENT_ID" => $arResult['ID'],
                        "ELEMENT_CODE" => "",
                        "MAX_VOTE" => "5",
                        "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                        "SET_STATUS_404" => "N",
                        "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                        "SHOW_VOTE_COUNT" => "Y",
                    ),
                    $component
                );?>
                <span class="id">Артикул: <?=$arResult["PROPERTIES"]["ARTICLE"]["VALUE"]?></span>
            </div>
        </div>
        <div class="info-box">
            <div class="price-box">
                <?
                    $boolDiscountShow = false;//(0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                ?>
                <div class="item_old_price hidden" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?></div>
                <div class="item_economy_price hidden" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
                <strong class="price-item" id="<? echo $arItemIDs['PRICE']; ?>"><? echo floatval($arResult['MIN_PRICE']['DISCOUNT_VALUE']); ?> <sub><?=GetMessage('CATALOG_CURR')?></sub></strong>
                <a href="#" class="link-delete">&nbsp;</a>
                <input class="number" id="<?=$arItemIDs['QUANTITY']?>" type="text" placeholder="1" value="1">
                <?if($canBuy):?>
                    <span class='status available' id="<?=$arItemIDs['AVAILABILITY_STATUS']?>"><?=GetMessage("CT_BCE_CATALOG_AVAILABLE")?></span>
                <?else:?>
                    <span class='status unavailable' id="<?=$arItemIDs['AVAILABILITY_STATUS']?>"><?=GetMessage("CT_BCE_CATALOG_NOT_AVAILABLE")?></span>
                <?endif?>
            </div>
            <?if(empty($arResult['DETAIL_TEXT'])){$arResult["DETAIL_TEXT"] = $arResult["PREVIEW_TEXT"];}?>
            <?if(!empty($arResult["DETAIL_TEXT"])):?>
                <div class="text">
                    <p>
                        <?=$arResult["DETAIL_TEXT"]?>
                    </p>
                </div>
            <?endif?>
            
            <?/*Обработка SKU*/?>
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/skuSelect.php");?>
            <noindex>
            <?/*Кнопки (в корзину, Избранное, купить в 1 клик)*/?>
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/cardActions.php");?>
            </noindex>
			<div class="prod-link">
				<a href="<?=$arResult['DETAIL_PAGE_URL']?>"><?=GetMessage('MORE_LINK')?></a>
			</div>
            <div class="wish">
                <p><?=GetMessage("CATALOG_LIKES_MESSAGE")?></p>
            </div>
            <noindex>
                <script type="text/javascript">(function() {
                        if (window.pluso)if (typeof window.pluso.start == "function") return;
                        if (window.ifpluso==undefined) { window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                            var h=d[g]('body')[0];
                            h.appendChild(s);
                        }})();
                </script>
                <div class="pluso" data-background="transparent" data-options="medium,round,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,livejournal,pinterest,moimir"></div>
            </noindex>
        </div>
    </div>
</div>
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
    foreach ($arResult['JS_OFFERS'] as &$arOneJS)
    {
        if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
        {
            $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
            $arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
        }
        $strProps = '';
        if ($arResult['SHOW_OFFERS_PROPS'])
        {
            if (!empty($arOneJS['DISPLAY_PROPERTIES']))
            {
                foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
                {
                    $strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
                        is_array($arOneProp['VALUE'])
                        ? implode(' / ', $arOneProp['VALUE'])
                        : $arOneProp['VALUE']
                    ).'</dd>';
                }
            }
        }
        $arOneJS['DISPLAY_PROPERTIES'] = $strProps;
    }
    if (isset($arOneJS))
        unset($arOneJS);
    $arJSParams = array(
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_ADD_BASKET_BTN' => true,
        'SHOW_BUY_BTN' => false,
        'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
        'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
        'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
        'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
        'OFFER_GROUP' => $arResult['OFFER_GROUP'],
        'VISUAL' => array(
            'ID' => $arItemIDs['ID'],
            'PICT_ID' => $arItemIDs['PICT'],
            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
            'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
            'QUANTITY_LIMIT' => $arItemIDs['QUANTITY_LIMIT'],
            'PRICE_ID' => $arItemIDs['PRICE'],
            'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
            'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
            'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
            'NAME_ID' => $arItemIDs['NAME'],
            'TREE_ID' => $arItemIDs['PROP_DIV'],
            'TREE_ITEM_ID' => $arItemIDs['PROP'],
            'SLIDER_CONT_OF_ID' => $arItemIDs['SLIDER_CONT_OF_ID'],
            'SLIDER_LIST_OF_ID' => $arItemIDs['SLIDER_LIST_OF_ID'],
            'SLIDER_LEFT_OF_ID' => $arItemIDs['SLIDER_LEFT_OF_ID'],
            'SLIDER_RIGHT_OF_ID' => $arItemIDs['SLIDER_RIGHT_OF_ID'],
            'BUY_ID' => $arItemIDs['BUY_LINK'],
            'QUICK_BUY_ID' => $arItemIDs['QUICK_BUY_LINK'],
            'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
            'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
            'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
            'OFFER_GROUP' => $arItemIDs['OFFER_GROUP'],
            'ZOOM_DIV' => $arItemIDs['ZOOM_DIV'],
            'ZOOM_PICT' => $arItemIDs['ZOOM_PICT'],
            'AVAILABILITY_STATUS' => $arItemIDs['AVAILABILITY_STATUS']
        ),
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'NAME' => $arResult['~NAME']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $arSkuProps,
        'MESS' => array(
            'ECONOMY_INFO' => GetMessage('ECONOMY_INFO')
        )
    );
}
else
{
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
    {
        ?>
        <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
            <?
                if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
                {
                    foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
                    {
                        ?>
                            <input
                                type="hidden"
                                name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
                            >
                        <?
                        if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
                            unset($arResult['PRODUCT_PROPERTIES'][$propID]);
                    }
                }
                $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
                if (!$emptyProductProperties)
                {
                    ?>
                        <table>
                    <?
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
                    {
                        ?>
                            <tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
                            <td>
                        <?
                        if(
                            'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
                            && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
                        )
                        {
                            foreach($propInfo['VALUES'] as $valueID => $value)
                            {
                                ?><label><input
                                    type="radio"
                                    name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                    value="<? echo $valueID; ?>"
                                    <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
                                ><? echo $value; ?></label><br><?
                            }
                        }
                        else
                        {
                            ?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                            foreach($propInfo['VALUES'] as $valueID => $value)
                            {
                                ?><option
                                    value="<? echo $valueID; ?>"
                                    <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
                                ><? echo $value; ?></option><?
                            }
                            ?></select><?
                        }
                        ?>
                            </td></tr>
                        <?
                    }
                    ?>
                        </table>
                    <?
                }
            ?>
        </div>
        <?
    }
    unset($emptyProductProperties);
}
?>

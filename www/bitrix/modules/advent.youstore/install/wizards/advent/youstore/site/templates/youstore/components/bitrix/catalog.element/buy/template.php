<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$strMainID = $this->GetEditAreaId($arResult['ID']);
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
    'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
    'COMPARE_LINK' => $strMainID.'_compare_link',
    'PROP' => $strMainID.'_prop_',
    'PROP_DIV' => $strMainID.'_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
    'OFFER_GROUP' => $strMainID.'_set_group_',
    'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
    'ZOOM_DIV' => $strMainID.'_zoom_cont',
    'ZOOM_PICT' => $strMainID.'_zoom_pict'
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
?>
<link rel="stylesheet" href="<?=$templateFolder."/style.css"?>" />
<div class="popup add-popup" style="display:block; overflow: visible">
    <div class="holder" id="<? echo $arItemIDs['ID']; ?>" style="overflow: visible">
        <a href="#" class="btn-close">close</a>
        <div class="title-holder">
            <div class="include">
                <h2><?=GetMessage("OFFER_BUY_TEXT")?></h2>
            </div>
        </div>

            <div class="photo-box" style="display:none">
                <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/photos.php")?>
            </div>


        <form class="info-box">
            <fieldset>
                <?/*show product price*/?>
                <div class="price-box">
                    <?
                        $boolDiscountShow = false;//(0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                    ?>
                    <strong class="old-price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?></strong>

                    <strong class="price-item" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $arResult['MIN_PRICE']['DISCOUNT_VALUE']; ?> <sub><?=GetMessage("CURRENCY_".$arResult["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sub></strong>
                    <div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
                    <a href="#" class="link-delete">delete</a>
                    <input class="number" id="<?=$arItemIDs['QUANTITY']?>" type="text" placeholder="1">
                </div>
                <?/*show product buttons (buy, etc..)*/?>
                <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/skuSelect.php");?>
                <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/cardActions.php");?>
            </fieldset>
        </form>
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
                'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
                'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                'OFFER_GROUP' => $arItemIDs['OFFER_GROUP'],
                'ZOOM_DIV' => $arItemIDs['ZOOM_DIV'],
                'ZOOM_PICT' => $arItemIDs['ZOOM_PICT']
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
        $arJSParams = array(
            'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_ADD_BASKET_BTN' => false,
            'SHOW_BUY_BTN' => true,
            'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
            'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
            'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
            'VISUAL' => array(
                'ID' => $arItemIDs['ID'],
                'PICT_ID' => $arItemIDs['PICT'],
                'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                'PRICE_ID' => $arItemIDs['PRICE'],
                'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
                'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
                'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
                'NAME_ID' => $arItemIDs['NAME'],
                'TREE_ID' => $arItemIDs['PROP_DIV'],
                'TREE_ITEM_ID' => $arItemIDs['PROP'],
                'SLIDER_CONT' => $arItemIDs['SLIDER_CONT_ID'],
                'SLIDER_LIST' => $arItemIDs['SLIDER_LIST'],
                'SLIDER_LEFT' => $arItemIDs['SLIDER_LEFT'],
                'SLIDER_RIGHT' => $arItemIDs['SLIDER_RIGHT'],
                'BUY_ID' => $arItemIDs['BUY_LINK'],
                'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
                'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
            ),
            'PRODUCT' => array(
                'ID' => $arResult['ID'],
                'PICT' => $arFirstPhoto,
                'NAME' => $arResult['~NAME'],
                'SUBSCRIPTION' => true,
                'PRICE' => $arResult['MIN_PRICE'],
                'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
                'SLIDER' => $arResult['MORE_PHOTO'],
                'CAN_BUY' => $arResult['CAN_BUY'],
                'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
                'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
                'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
                'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
                'BUY_URL' => $arResult['~BUY_URL'],
            ),
            'BASKET' => array(
                'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                'EMPTY_PROPS' => $emptyProductProperties,
                'BASKET_URL' => $arParams['BASKET_URL']
            ),
            'MESS' => array()
        );
        unset($emptyProductProperties);
    }
    ?>
    <script type="text/javascript">
        var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
        BX.message({
            MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
            MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
            MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
            TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
            TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
            BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
            BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
            BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>'
        });
    </script>
</div>
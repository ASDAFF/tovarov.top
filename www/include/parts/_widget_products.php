<?
    CModule::IncludeModule("sale");
    CModule::IncludeModule("iblock");
    $arID = array();
    $arBasketItems = array();

    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
        {
            CSaleBasket::UpdatePrice($arItems["ID"],
                $arItems["CALLBACK_FUNC"],
                $arItems["MODULE"],
                $arItems["PRODUCT_ID"],
                $arItems["QUANTITY"],
                "N",
                $arItems["PRODUCT_PROVIDER_CLASS"]
            );
            $arID[] = $arItems["ID"];
        }
    }
    if (!empty($arID))
    {
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "ID" => $arID,
                "ORDER_ID" => "NULL"
            ),
            false,
            false,
            array("ID", "PRODUCT_ID",)
        );
        while ($arItems = $dbBasketItems->Fetch())
        {
            $arProducts[] = $arItems['PRODUCT_ID'];
        }
    }

    foreach ($arProducts as $key => $prod){
        $mxResult = CCatalogSku::GetProductInfo(
            $prod
        );
        if (is_array($mxResult))
        {
            $arProducts[$key]=$mxResult['ID'];
        }
    }

    $arFilter = Array("ID"=>$arProducts, );
    $arAccessories = array();
    $res = CIBlockElement::GetList(Array(), $arFilter,false,false, Array("ID",'IBLOCK_ID','NAME','SECTION_ID','PROPERTY_ACCESSORIES'));
    while($ar_fields = $res->GetNext())
    {
        $arAccessories[] = $ar_fields['PROPERTY_ACCESSORIES_VALUE'];
        if(!array_key_exists($ar_fields['SECTION_ID'],$section_id)){
            $section_id[$ar_fields['SECTION_ID']] = $ar_fields['SECTION_ID'];
        }
    }
print_r($section_id);

   
        $arFilter = array('SECTION_ID'=>$section_id);
        $arSecProducts = array();
        $obj = CIBlockElement::GetList(Array(),$arFilter,false,false,array('ID'));
        while($res = $obj->GetNext()){
            $arSecProducts[] = $res['ID']; 
        }
   
    $arIds =  array_merge($arAccessories,$arSecProducts);
    global $accFilter;
    $accFilter = array();
    
        $accFilter['ID'] = $arIds;
    

?>

<div class="widget">
    <h3>Возможно, это вас<br/>заинтересует:</h3>
    <?$APPLICATION->IncludeComponent("bitrix:catalog.section", "advice-product", Array(

                "SHOW_EXPAND_OPTIONS" => "N",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "1",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",
                "ELEMENT_SORT_ORDER" => "DESC",
                "ELEMENT_SORT_FIELD2" => "RAND",
                "ELEMENT_SORT_ORDER2" => "asc",
                "FILTER_NAME" => "accFilter",
                "INCLUDE_SUBSECTIONS" => "Y",
                "SHOW_ALL_WO_SECTION" => "Y",
                "HIDE_NOT_AVAILABLE" => "N",
                "PAGE_ELEMENT_COUNT" => "7",
                "LINE_ELEMENT_COUNT" => "7",
                "PROPERTY_CODE" => array(
                    0 => "MORE_PHOTO"
                ),
                "OFFERS_FIELD_CODE" => array(
                    0 => "ID",
                    1 => "NAME",
                    2 => "PREVIEW_PICTURE",
                    3 => "DETAIL_PICTURE",
                ),
                "OFFERS_PROPERTY_CODE" => array(
                    0 => "CML2_ARTICLE",
                    1 => "MORE_PHOTO",
                    2 => "FILES",
                    3 => "COLOR",
                    4 => "CML2_LINK",
                    5 => "",
                ),
                "OFFERS_SORT_FIELD" => "sort",
                "OFFERS_SORT_ORDER" => "asc",
                "OFFERS_SORT_FIELD2" => "active_from",
                "OFFERS_SORT_ORDER2" => "desc",
                "OFFERS_LIMIT" => "0",
                "TEMPLATE_THEME" => "blue",
                "PRODUCT_DISPLAY_MODE" => "Y",
                "ADD_PICT_PROP" => "MORE_PHOTO",
                "LABEL_PROP" => "-",
                "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                "OFFER_TREE_PROPS" => array(
                    0 => "COLOR",
                    1 => "SIZE"
                ),
                "PRODUCT_SUBSCRIPTION" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_OLD_PRICE" => "Y",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "SECTION_URL" => "",
                "DETAIL_URL" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "Y",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "SET_META_KEYWORDS" => "Y",
                "META_KEYWORDS" => "-",
                "SET_META_DESCRIPTION" => "Y",
                "META_DESCRIPTION" => "-",
                "BROWSER_TITLE" => "-",
                "ADD_SECTIONS_CHAIN" => "N",
                "DISPLAY_COMPARE" => "Y",
                "SET_TITLE" => "N",
                "SET_STATUS_404" => "N",
                "CACHE_FILTER" => "Y",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "CONVERT_CURRENCY" => "Y",
                "CURRENCY_ID" => "RUB",
                "BASKET_URL" => "/personal/basket/",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "USE_PRODUCT_QUANTITY" => "N",
                "ADD_PROPERTIES_TO_BASKET" => "N",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "Y",
                "PRODUCT_PROPERTIES" => array(
                    "MANUFACTURER"
                ),
                "OFFERS_CART_PROPERTIES" => array(
                    0 => "COLOR",
                    1 => "SIZE"
                ),
                "PAGER_TEMPLATE" => "",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Товары",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_DISPLAY_MODE" => "Y",
                "OFFER_TREE_PROPS" => array(
                    0 => "COLOR",
                    1 => "SIZE",
                )
            ),
            false
        );?>
</div>
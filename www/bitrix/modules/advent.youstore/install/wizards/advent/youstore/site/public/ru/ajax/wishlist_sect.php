<?
define('SITE_ID', '#SITE_ID#');
define('SITE_DIR', '#SITE_DIR#');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
   CModule::includeModule('catalog');
    CModule::includeModule('iblock');
    CModule::includeModule('sale');
    $dbBasketItems = CSaleBasket::GetList(array(),array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => SITE_ID,"ORDER_ID" => "NULL"),false,false,array("ID", "PRODUCT_ID"));
    while($arItems = $dbBasketItems->Fetch()){          
        $mxResult = CCatalogSku::GetProductInfo($arItems['PRODUCT_ID']);
        if (is_array($mxResult))$id=$mxResult['ID'];
        else $id=$arItems['PRODUCT_ID'];
        $GLOBALS['wished']['ID'][]=$id;
    } 
   if(!empty($GLOBALS['wished']['ID']))
                $result = $APPLICATION->IncludeComponent("bitrix:catalog.section", "wishlist", array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "#CATALOG_IBLOCK_ID#",
                        "SECTION_ID" => "",
                        "SECTION_CODE" => "",
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "ELEMENT_SORT_FIELD" => "ID",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "ELEMENT_SORT_FIELD2" => "name",
                        "ELEMENT_SORT_ORDER2" => "asc",
                        "FILTER_NAME" => "wished",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "PAGE_ELEMENT_COUNT" => "12",
                        "LINE_ELEMENT_COUNT" => "5",
                        "PROPERTY_CODE" => array(
                            0 => "MORE_PHOTO"
                        ),
                        "OFFERS_FIELD_CODE" => array(
                            0 => "ID",
                            1 => "NAME",
                            2 => "PREVIEW_PICTURE",
                            3 => "",
                        ),
                        "OFFERS_PROPERTY_CODE" => array(
                            0 => "CML2_ARTICLE",
                            1 => "MORE_PHOTO",
                            2 => "FILES",
                            3 => "COLOR",
                            4 => "SIZE",
                            5 => "CML2_LINK",
                            6 => "",
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
                        "BASKET_URL" => SITE_DIR."personal/basket/",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "USE_PRODUCT_QUANTITY" => "N",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRODUCT_PROPERTIES" => array(
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
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity"
                    ),
                    false
                );
            ?>

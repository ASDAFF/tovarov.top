<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
$APPLICATION->SetPageProperty("prop-h1", $arResult["NAME"]);
?>
<div id="reviews" class="tab" style="display:none">
            <div class="comments-board">
                <?global $commentsFilter;
                    $commentsFilter = array("PROPERTY_ELEMENT_ID" => $arResult["ID"], "PROPERTY_REPLY_ID" => false);
                    $APPLICATION->IncludeComponent("bitrix:news.list","comments",Array(
                        "AJAX_MODE" => "N",
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => $arParams['COMMENTS_IB'],
                        "NEWS_COUNT" => "5",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "commentsFilter",
                        "FIELD_CODE" => Array("ID", "NAME", "DATE_CREATE"),
                        "PROPERTY_CODE" => Array("AVATAR"),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "Y",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        //"CACHE_TYPE" => "A",
                        "CACHE_TYPE" => "N",
                        "CACHE_TIME" => "3600",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_TOP_PAGER" => "Y",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "PAGER_TITLE" => "отзывы",
                        "PAGER_SHOW_ALWAYS" => "Y",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "Y",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_ADDITIONAL" => ""
                        ),
                        $component
                    );?>
                <?$APPLICATION->IncludeComponent(
                        "advent:iblock.comments",
                        "",
                        array(
                            "ELEMENT_ID" => $arResult["ID"],
                            "USE_CAPTCHA" => "Y",
                            "SUCCESS_TEXT" => GetMessage('CATALOG_THANKS'),
                            "EMAIL_TO" => "sale@tovarov.top",
                            "IBLOCK_ID" => $arParams['COMMENTS_IB'],
                            "SHOW_BASE_FIELDS" => array(
                                0 => "NAME",
                                1 => "MESSAGE",
                            ),
                            "REQUIRED_BASE_FIELDS" => array(
                                0 => "NAME"
                            ),
                            "SHOW_FIELDS" => array(
                                1 => "AUTHOR_EMAIL",
                                2 => "POSITIVE_MESSAGE",
                                3 => "NEGATIVE_MESSAGE",
                                4 => "RATING",
                                5 => "AVATAR",
                                6 => "ELEMENT_ID",
                                7 => "REPLY_ID"
                            ),
                            "REQUIRED_FIELDS" => array(
                                1 => "AUTHOR_EMAIL",
                            ),
                            "EVENT_MESSAGE_ID" => array(
                                0 => "13",
                            ),
                        ),
                        $component
                    );?>


            </div>
        </div>
    </div>
</div>
<? $APPLICATION->IncludeComponent(
    "bitrix:catalog.bigdata.products",
    "product_detail",
    array(
        "RCM_TYPE" => "any_personal",
        "ID" => $arResult["ID"],
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => $iblock_id,
        "SHOW_FROM_SECTION" => "N",
        "HIDE_NOT_AVAILABLE" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_NAME" => "Y",
        "SHOW_IMAGE" => "Y",
        "MESS_BTN_BUY" => GetMessage("BIGDATA_MESS_BTN_BUY"),
        "MESS_BTN_DETAIL" => GetMessage("BIGDATA_MESS_BTN_DETAIL"),
        "MESS_BTN_SUBSCRIBE" => GetMessage("BIGDATA_MESS_BTN_SUBSCRIBE"),
        "PAGE_ELEMENT_COUNT" => "6",
        "LINE_ELEMENT_COUNT" => "3",
        "TEMPLATE_THEME" => "blue",
        "DETAIL_URL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "N",
        "SHOW_OLD_PRICE" => "Y",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "CONVERT_CURRENCY" => "Y",
        "BASKET_URL" => SITE_DIR . "personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "Y",
        "USE_PRODUCT_QUANTITY" => "N",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_ELEMENT_ID" => "",
        "SECTION_ELEMENT_CODE" => "",
        "DEPTH" => "2",
        "CURRENCY_ID" => "RUB",
        "COMPONENT_TEMPLATE" => "product_detail",
        "SHOW_PRODUCTS_20" => "Y",
        "PROPERTY_CODE_20" => array(

        ),
        "CART_PROPERTIES_20" => array(

        ),
        "ADDITIONAL_PICT_PrightROP_20" => "MORE_PHOTO",
        "LABEL_PROP_20" => ""
    ),
    $component
); ?>
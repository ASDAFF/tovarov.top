<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("prop-h1", "Спецпредложения");
?>
    <div class="three-columns">
        <div class="two-columns">
            <div id="sidebar">
                <form class="subscription-form">
                    <fieldset>
                        <div class="subscription-holder">
                            <span class="title">Подписка на акции</span>
                            <input class="text" type="text" placeholder="Ваше имя">
                            <input class="text" type="text" placeholder="Ваш Email">
                            <input class="submit" type="submit" value="Подписаться">
                        </div>
                    </fieldset>
                </form>
                <?
                    // включаемая область для раздела
                    $APPLICATION->IncludeFile(SITE_DIR."include/right_anounce.php", Array(), Array(
                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                        "NAME"      => "Редактирование включаемой области раздела",      // текст всплывающей подсказки на иконке
                        "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
                    ));
                ?>
                <?
                    // включаемая область для раздела
                    $APPLICATION->IncludeFile(SITE_DIR."include/right_social.php", Array(), Array(
                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                        "NAME"      => "Редактирование включаемой области раздела",      // текст всплывающей подсказки на иконке
                        "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
                    ));
                ?>
            </div>
            <div id="content">
                <?
                    $offersFilter = array(
                        "!PROPERTY_LABEL_PROP" => false
                    );
                    
                    $APPLICATION->IncludeComponent("bitrix:catalog.section", "search", array(
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
                        "FILTER_NAME" => "offersFilter",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "PAGE_ELEMENT_COUNT" => "12",
                        "LINE_ELEMENT_COUNT" => "4",
                        "PROPERTY_CODE" => array(
                            0 => "MORE_PHOTO",
                            /*1 => "MANUFACTURER",
                            2 => "CML2_ARTICLE",
                            5 => "MATERIAL",
                            6 => "COVERS_ASSIGNMENT",
                            7 => "NOVINKA_SPRAVOCHNIK_NOMENKLATURA_OBSHCHIE_",
                            8 => "COVERS_WATERSPROOF",
                            9 => "COVERS_TYPE",
                            10 => "CHARGER_VIEW",
                            11 => "CHARGER_TYPE",
                            12 => "SCR_PROT_DIAGONAL",
                            13 => "SCR_PROT_TYPE",
                            14 => "CARHOLDERS_TYPE",
                            15 => "CARHOLDERS_MOUNT_TYPE",
                            18 => "SPECIALS",
                            19 => "CML2_MANUFACTURER"*/
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
                        "CACHE_TIME" => "3600",
                        "CACHE_GROUPS" => "N",
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
                            0 => "Типовые правила продаж (интернет-магазин)",
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
            </div>
        </div>
    </div>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
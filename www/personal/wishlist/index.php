<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    $APPLICATION->SetPageProperty("prop-h1", "Личный кабинет");
    $APPLICATION->SetPageProperty("prop-container-class", "account-page");

    $APPLICATION->SetTitle("Личный кабинет"); 
    include 'filter.php';
?>
<?
    //change data to save
    if(!empty($_POST["PERSONAL_BIRTHDAY_DAY"]) && !empty($_POST["PERSONAL_BIRTHDAY_MONTH"]) && !empty($_POST["PERSONAL_BIRTHDAY_YEAR"])){
        foreach(array("DAY", "MONTH", "YEAR") as $v){
            $_POST["PERSONAL_BIRTHDAY_".$v] = str_pad($_POST["PERSONAL_BIRTHDAY_".$v], 2, '0', STR_PAD_LEFT);
        }

        $_REQUEST["PERSONAL_BIRTHDAY"] = $_GET["PERSONAL_BIRTHDAY"] = $_POST["PERSONAL_BIRTHDAY"] = $_POST["PERSONAL_BIRTHDAY_DAY"].".".$_POST["PERSONAL_BIRTHDAY_MONTH"].".".$_POST["PERSONAL_BIRTHDAY_YEAR"];
    }

?>
<div class="account-holder">
    <?
        $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"account-menu", 
	array(
		"ROOT_MENU_TYPE" => "left",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		)
	),
	false
);
    ?>
    <div class="account-frames wishlist">
        <?
            /*  if($USER->IsAuthorized()){
            ?>
            <div class="title">
            <h2>ТОВАРЫ В ВАШЕМ ЛИСТЕ ЖЕЛАНИЙ</h2>
            <a href="#">Очистить список</a>
            </div>
            <div class="products-content">
            <?
            $APPLICATION->IncludeComponent(
            "brsoft:wishlist",
            "",
            Array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "1",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_USER_FIELDS" => array("",""),
            "ELEMENT_SORT_FIELD" => "",
            "ELEMENT_SORT_ORDER" => "",
            "ELEMENT_SORT_FIELD2" => "",
            "ELEMENT_SORT_ORDER2" => "",
            "FILTER_NAME" => "arrFilter",
            "INCLUDE_SUBSECTIONS" => "Y",
            "SHOW_ALL_WO_SECTION" => "Y",
            "HIDE_NOT_AVAILABLE" => "N",
            "PAGE_ELEMENT_COUNT" => "8",
            "LINE_ELEMENT_COUNT" => "3",
            "PROPERTY_CODE" => array("",""),
            "OFFERS_LIMIT" => "0",
            "TEMPLATE_THEME" => "",
            "PRODUCT_SUBSCRIPTION" => "N",
            "SHOW_DISCOUNT_PERCENT" => "Y",
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
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "N",
            "SET_META_KEYWORDS" => "Y",
            "META_KEYWORDS" => "",
            "SET_META_DESCRIPTION" => "Y",
            "META_DESCRIPTION" => "",
            "BROWSER_TITLE" => "-",
            "ADD_SECTIONS_CHAIN" => "N",
            "DISPLAY_COMPARE" => "N",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "CACHE_FILTER" => "N",
            "PRICE_CODE" => array("BASE"),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "CONVERT_CURRENCY" => "Y",
            "BASKET_URL" => "/personal/basket/",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "USE_PRODUCT_QUANTITY" => "N",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PARTIAL_PRODUCT_PROPERTIES" => "Y",
            "PRODUCT_PROPERTIES" => array(),
            "PAGER_TEMPLATE" => "",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Товары",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "OFFERS_FIELD_CODE" => array("",""),
            "OFFERS_PROPERTY_CODE" => array("MORE_PHOTO","SIZE","COLOR",""),
            "OFFERS_SORT_FIELD" => "",
            "OFFERS_SORT_ORDER" => "",
            "OFFERS_SORT_FIELD2" => "",
            "OFFERS_SORT_ORDER2" => "",
            "PRODUCT_DISPLAY_MODE" => "Y",
            "ADD_PICT_PROP" => "MORE_PHOTO",
            "LABEL_PROP" => "-",
            "OFFERS_CART_PROPERTIES" => array("SIZE","COLOR"),
            "CURRENCY_ID" => "",
            "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
            "OFFER_TREE_PROPS" => array("COLOR","SIZE")
            )
            );?>
            </div>
            <?
            }else{
            $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", Array(
            "REGISTER_URL" => "#fancybox01",
            "PROFILE_URL" => "/personal/",
            "SHOW_ERRORS" => "Y"
            ),
            false
            );
            } */
        ?>    
        <div class="title">
            <h2>ТОВАРЫ В ВАШЕМ ЛИСТЕ ЖЕЛАНИЙ</h2>
            <a class="all-wish-delete" href="<?=SITE_DIR?>ajax/wishlist.php?action=DELETEALL_FROM_DELAY" rel="nofollow">Очистить список</a>
        </div>
        <div class="products-content">

            <?  if(!empty($GLOBALS['wished']['ID']))
                $result = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"wishlist", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "20",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "CATALOG_QUANTITY",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "ID",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "wished",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "12",
		"LINE_ELEMENT_COUNT" => "5",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "MORE_PHOTO",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_PICTURE",
			3 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "MORE_PHOTO",
			1 => "SIZE",
			2 => "COLOR",
			3 => "CML2_ARTICLE",
			4 => "FILES",
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
			1 => "SIZE",
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
			0 => "SIZE",
			1 => "COLOR",
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
		"SET_BROWSER_TITLE" => "Y"
	),
	false
);
            ?>

        </div>


    </div>
</div>
<?
    // включаема¤ область дл¤ раздела
    $APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
            "NAME"      => "Баннеры",      // текст всплывающей подсказки на иконке
            "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
        ));
?>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
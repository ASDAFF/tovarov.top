<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Поиск");
	$APPLICATION->SetPageProperty("prop-h1", "Поиск");
    $APPLICATION->SetPageProperty("prop-container-class", "page-main");
?>


<?$APPLICATION->IncludeComponent("bitrix:catalog.search", ".default", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "20",
	"ELEMENT_SORT_FIELD" => "sort",
	"ELEMENT_SORT_ORDER" => "asc",
	"ELEMENT_SORT_FIELD2" => "id",
	"ELEMENT_SORT_ORDER2" => "desc",
	"HIDE_NOT_AVAILABLE" => "N",
	"PAGE_ELEMENT_COUNT" => "20",
	"LINE_ELEMENT_COUNT" => "4",
	"PROPERTY_CODE" => array(
		0 => "MORE_PHOTO",
	),
	"OFFERS_FIELD_CODE" => array(
		0 => "ID",
		1 => "NAME",
		2 => "PREVIEW_PICTURE",
	),
	"OFFERS_PROPERTY_CODE" => array(
		0 => "SIZE",
		1 => "COLOR",
		2 => "MORE_PHOTO",
		3 => "",
	),
	"OFFERS_SORT_FIELD" => "sort",
	"OFFERS_SORT_ORDER" => "asc",
	"OFFERS_SORT_FIELD2" => "id",
	"OFFERS_SORT_ORDER2" => "desc",
	"OFFERS_LIMIT" => "0",
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => SITE_DIR."personal/basket/",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"DISPLAY_COMPARE" => "N",
	"PRICE_CODE" => array(
		0 => "BASE",
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"USE_PRODUCT_QUANTITY" => "N",
	"CONVERT_CURRENCY" => "Y",
	"CURRENCY_ID" => "RUB",
	"OFFERS_CART_PROPERTIES" => array(
		0 => "COLOR",
        1 => "SIZE"
	),

    'ADD_PICT_PROP' => "MORE_PHOTO",
    'PRODUCT_DISPLAY_MODE' => "Y",
    'OFFER_ADD_PICT_PROP' => "MORE_PHOTO",

	"RESTART" => "Y",
	"NO_WORD_LOGIC" => "N",
	"USE_LANGUAGE_GUESS" => "N",
	"CHECK_DATES" => "N",
	"PAGER_TEMPLATE" => ".default",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> <?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>

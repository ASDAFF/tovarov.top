<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Приобрести качественные феерверки по самым выгодным ценам в интернет-магазине с доставкой по России");
$APPLICATION->SetPageProperty("keywords", "пиротехника на корпоратив, новогодние фейерверки купить русская пиротехника, купить пиротехнику в интернет магазине недорого, заказ пиротехники по россии");
$APPLICATION->SetPageProperty("title", "Фейерверки и пиротехника по выгодным ценам");
$APPLICATION->SetPageProperty("prop-show-bottom", "Y");
$APPLICATION->SetTitle("Фейерверки и пиротехника по выгодным ценам");
?>

<? $APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	".default", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "20",
		"HIDE_NOT_AVAILABLE" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_ELEMENT_COUNTER" => "N",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "MANUFACTURER",
			1 => "TIPE_SALUTE",
			2 => "TIME_WORK",
			3 => "HEIGHT_GAP",
			4 => "CALIBER",
			5 => "VOLLEYS",
			6 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "BASE",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"FILTER_VIEW_MODE" => "VERTICAL",
		"USE_COMPARE" => "Y",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"COMPARE_PROPERTY_CODE" => array(
			0 => "",
			1 => "MANUFACTIRER",
			2 => "MORE_PHOTO",
			3 => "",
		),
		"COMPARE_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"COMPARE_OFFERS_PROPERTY_CODE" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"COMPARE_ELEMENT_SORT_FIELD" => "sort",
		"COMPARE_ELEMENT_SORT_ORDER" => "asc",
		"DISPLAY_ELEMENT_SELECT_BOX" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"BASKET_URL" => SITE_DIR."personal/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "Y",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"OFFERS_CART_PROPERTIES" => array(
			0 => "SIZE",
			1 => "COLOR",
		),
		"SHOW_TOP_ELEMENTS" => "N",
		"SECTION_COUNT_ELEMENTS" => "Y",
		"SECTION_TOP_DEPTH" => "1",
		"SECTIONS_VIEW_MODE" => "LINE",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"PAGE_ELEMENT_COUNT" => "16",
		"LINE_ELEMENT_COUNT" => "4",
		"ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "CATALOG_AVAILABLE",
		"ELEMENT_SORT_ORDER2" => "asc",
		"LIST_PROPERTY_CODE" => array(
			0 => "ARTICLE",
			1 => "MORE_PHOTO",
			2 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "UF_METAKEYWORDS",
		"LIST_META_DESCRIPTION" => "UF_METADESCRIPTION",
		"LIST_BROWSER_TITLE" => "UF_METATITLE",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"LIST_OFFERS_LIMIT" => "0",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "MANUFACTURER",
			1 => "NEWPRODUCT",
			2 => "DAY_ITEM",
			3 => "SPECIALOFFER",
			4 => "TIPE_SALUTE",
			5 => "ARTICLE",
			6 => "WEIGHT",
			7 => "YOUTUBE_VIDEO",
			8 => "TIME_WORK",
			9 => "HEIGHT_GAP",
			10 => "CALIBER",
			11 => "VOLLEYS",
			12 => "vote_count",
			13 => "MATERIAL",
			14 => "PRODUCT_LABEL_TEXT",
			15 => "LABEL",
			16 => "SIZE",
			17 => "rating",
			18 => "vote_sum",
			19 => "TABS_MAIN_PAGE",
			20 => "SHOW_ON_MANUFACTURER_TAB",
			21 => "PACKING",
			22 => "COLOR",
			23 => "THREEG",
			24 => "BLUETOOTH",
			25 => "WI_FI",
			26 => "ACCESSORIES",
			27 => "WIRELESS_INTERFACES",
			28 => "DIAGONAL",
			29 => "MEMORY_CAPACITY",
			30 => "OS",
			31 => "PIXEL_DENSITY",
			32 => "SEX",
			33 => "DIMENSIONS",
			34 => "DEVICE_COMPABILITY",
			35 => "TYPE_MATRIX",
			36 => "SALELEADER",
			37 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"LINK_IBLOCK_TYPE" => "catalog",
		"LINK_IBLOCK_ID" => "17",
		"LINK_PROPERTY_SID" => "CML2_LINK",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "N",
		"USE_STORE" => "N",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"TEMPLATE_THEME" => "blue",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"LABEL_PROP" => "LABEL",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "COLOR",
			1 => "SIZE",
		),
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"DETAIL_USE_VOTE_RATING" => "Y",
		"DETAIL_VOTE_DISPLAY_AS_RATING" => "vote_avg",
		"DETAIL_BRAND_USE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"COMMENTS_IB" => "4",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_USE_COMMENTS" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"USE_REVIEW" => "N",
		"ES_IBLOCK_GROUP" => "",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"SHOW_DEACTIVATED" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"FILE_404" => "",
		"DETAIL_BRAND_PROP_CODE" => "-",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "product/#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
); ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
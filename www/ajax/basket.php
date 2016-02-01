<?
	define("NO_KEEP_STATISTIC", true);
    define('SITE_ID', 's1');
    define('SITE_DIR', '/');
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
	global $APPLICATION;
	$APPLICATION->IncludeComponent("bitrix:sale.basket.basket",
		"popup",
		Array(
			"OFFERS_PROPS" => array("COLOR", "CML2_LINK"),
			"PATH_TO_ORDER" => SITE_DIR."personal/order/",
			"PATH_TO_BASKET" => SITE_DIR."personal/basket/",
			"HIDE_COUPON" => "Y",
			"COLUMNS_LIST" => Array("NAME", "PRICE", "QUANTITY", "DELETE", "PICTURE", "PROPERTY_MORE_PHOTO"),
			"PRICE_VAT_SHOW_VALUE" => "Y",
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"USE_PREPAYMENT" => "N",
			"SET_TITLE" => "N"
		)
	);
?>
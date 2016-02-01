<?
define('SITE_ID', 's1');
define('SITE_DIR', '/');
define("NO_KEEP_STATISTIC", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?
global $APPLICATION;

$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	".default",
	array(
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "QUANTITY",
			3 => "PROPS",
			4 => "DELETE",
			5 => "PRICE",
			6 => "SUM",
			8 => "PROPERTY_MORE_PHOTO",
		),
		"OFFERS_PROPS" => array(
			0 => "SIZE",
			1 => "COLOR",
		),
		"PATH_TO_ORDER" => SITE_DIR."personal/order/",
		"HIDE_COUPON" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "Y",
		"USE_PREPAYMENT" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y"
	),
	false
);?> 
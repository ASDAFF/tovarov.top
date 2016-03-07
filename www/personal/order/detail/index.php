<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Детали заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.detail",
	"",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"CUSTOM_SELECT_PROPS" => array("",""),
		"ID" => $ID,
		"PATH_TO_CANCEL" => "https://tovarov.top/order/cancel/",
		"PATH_TO_LIST" => "https://tovarov.top/personal/history/",
		"PATH_TO_PAYMENT" => "payment.php",
		"PICTURE_HEIGHT" => "110",
		"PICTURE_RESAMPLE_TYPE" => "1",
		"PICTURE_WIDTH" => "110",
		"PROP_1" => array(""),
		"SET_TITLE" => "Y"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
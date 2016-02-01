<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("prop-h1", "Карта сайта");
$APPLICATION->SetPageProperty("TITLE", "Карта сайта");
$APPLICATION->SetTitle("Карта сайта");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.map",
	"",
	Array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SET_TITLE" => "Y",
		"LEVEL" => "3",
		"COL_NUM" => "1",
		"SHOW_DESCRIPTION" => "Y"
	)
);?><br><?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
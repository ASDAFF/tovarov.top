<?
	define("NO_KEEP_STATISTIC", true);
    define('SITE_ID', 's1');
    define('SITE_DIR', '/');
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"",
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "20",
		"NAME" => "CATALOG_COMPARE_LIST",
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"COMPARE_URL" => "/catalog/compare.php",
	),
	false
);

	if($_REQUEST["action"] == "ADD_TO_COMPARE_LIST"){
		$remove = count($_SESSION["CATALOG_COMPARE_LIST"][1]["ITEMS"]) - 3;
		if($remove > 0){
			$_SESSION["CATALOG_COMPARE_LIST"][1]["ITEMS"] = array_slice($_SESSION["CATALOG_COMPARE_LIST"][1]["ITEMS"], 1, NULL, true);
		}
	}

?>
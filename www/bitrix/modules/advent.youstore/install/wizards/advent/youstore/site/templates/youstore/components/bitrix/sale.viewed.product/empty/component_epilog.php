<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$IDs = array();
	foreach($arResult as $arItem){
		$IDs[] = $arItem["PRODUCT_ID"];
	}
	$APPLICATION->SetPageProperty("prop-viewed", serialize($IDs));
?>
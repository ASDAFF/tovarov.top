<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$APPLICATION->SetPageProperty("SECTIONS_COUNT", $arResult["SECTIONS_COUNT"]);
	$APPLICATION->SetPageProperty("prop-h1", $arResult["SECTION"]["NAME"]);
	$APPLICATION->SetPageproperty("body-class", "root-catalog");
?>
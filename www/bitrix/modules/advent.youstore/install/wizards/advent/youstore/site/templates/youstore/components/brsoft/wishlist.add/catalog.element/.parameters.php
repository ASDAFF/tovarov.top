<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"DELAYED" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => GetMessage("BRSOFT_WL_DELAYED"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),
	"ABOUT_TEXT" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => GetMessage("BRSOFT_WL_ABOUT_TEXT"),
		"TYPE" => "STRING",
		"DEFAULT" => "Y"
	),
);
?>
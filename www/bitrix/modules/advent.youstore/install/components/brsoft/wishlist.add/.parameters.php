<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arIBlocks = array();
$arIBlockElements = array();

if(CModule::IncludeModule("iblock")){
	$dbIBlocks = CIBlock::GetList(array("ID" => "ASC"), array("ACTIVE" => "Y"));
	while($rsIBlocks = $dbIBlocks->GetNext()){
		$arIBlocks[$rsIBlocks["ID"]] = $rsIBlocks["NAME"];
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
		"DATA_SOURSE" => array(
			"NAME" => GetMessage("BRSOFT_WL_DATASOURCE"),
		),
	),
	"PARAMETERS" => array(
		"PARAM2" => array(
			"PARENT" => "DATA_SOURCE", 
			"NAME" => GetMessage("BRSOFT_WL_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"REFRESH" => "Y"
		),
		"PARAM3" => array(
			"PARENT" => "DATA_SOURCE", 
			"NAME" => GetMessage("BRSOFT_WL_ELEMENT_ID"),
			"TYPE" => "STRING"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
?>

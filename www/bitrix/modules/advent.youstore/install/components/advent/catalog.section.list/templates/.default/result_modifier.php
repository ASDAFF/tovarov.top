<?
CModule::IncludeModule("iblock");
$man_id = $_REQUEST["ID"];//reset($GLOBALS[$arParams["FILTER_NAME"]]);

$newSections = array();
foreach($arResult["SECTIONS"] as $arSection){
	$newSections[$arSection["ID"]] = $arSection;
}

$arResult["SECTIONS"] = $newSections;

foreach($arResult["SECTIONS"] as $key => $arSection)
{
	if($arSection["ELEMENT_CNT"] > 0)
	{
		$dbEl = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>17,"PROPERTY_MANUFACTURER"=>$man_id,"PROPERTY_SECTIONS"=>$arSection["ID"]));
		if($rsEl = $dbEl->GetNextElement())
		{
			$rsElFields = $rsEl->GetFields();
			$pic = CFile::ResizeImageGet($rsElFields["PREVIEW_PICTURE"],array("width"=>170,"height"=>170));
			$arResult["SECTIONS"][$key]["PICTURE"]["SRC"] = $pic['src'];
		}
	}
}
?>
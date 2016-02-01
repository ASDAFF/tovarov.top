<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult["TAGS_CHAIN"] = array();
if($arResult["REQUEST"]["~TAGS"])
{
	$res = array_unique(explode(",", $arResult["REQUEST"]["~TAGS"]));
	$url = array();
	foreach ($res as $key => $tags)
	{
		$tags = trim($tags);
		if(!empty($tags))
		{
			$url_without = $res;
			unset($url_without[$key]);
			$url[$tags] = $tags;
			$result = array(
				"TAG_NAME" => htmlspecialcharsex($tags),
				"TAG_PATH" => $APPLICATION->GetCurPageParam("tags=".urlencode(implode(",", $url)), array("tags")),
				"TAG_WITHOUT" => $APPLICATION->GetCurPageParam((count($url_without) > 0 ? "tags=".urlencode(implode(",", $url_without)) : ""), array("tags")),
			);
			$arResult["TAGS_CHAIN"][] = $result;
		}
	}
}
CModule::IncludeModule("iblock");
$arResult["ITEMS"] = array();
$arResult["SECTIONS"] = array();
$arResult["TEMP"] = array();
foreach($arResult["SEARCH"] as $arItem)
{
	if($arItem["PARAM1"] == "catalog")
	{
		$arResult["ITEMS"][] = $arItem["ITEM_ID"];
		$dbEl = CIBlockElement::GetByID($arItem["ITEM_ID"]);
		$rsEl = $dbEl->GetNext();
		$arResult["TEMP"][] = $rsEl;
		if(isset($arResult["SECTIONS"][$rsEl["IBLOCK_SECTION_ID"]]))
			$arResult["SECTIONS"][$rsEl["IBLOCK_SECTION_ID"]]++;
		else $arResult["SECTIONS"][$rsEl["IBLOCK_SECTION_ID"]] = 1;
	}
}
?>
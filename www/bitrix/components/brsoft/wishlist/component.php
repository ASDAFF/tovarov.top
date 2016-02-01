<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($arParams["COMPONENT_ENABLE"]) && $arParams["COMPONENT_ENABLE"] === false)
	return;

if(!CModule::IncludeModule("brsoft.wishlist")) return false;

$arNavParams = array(
	"nPageSize" => $arParams["PAGE_ELEMENT_COUNT"],
	"bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"],
	"bShowAll" => $arParams["PAGER_SHOW_ALL"],
);

$arNavigation = CDBResult::GetNavParams($arNavParams);
if($arNavigation["PAGEN"]==0 && $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"]>0)
	$arParams["CACHE_TIME"] = $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"];

$arResult = array();
$arResult["WL_USER_ID"] = CBrWishlist::GetWLUserID();

if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $arNavigation))) 
{	
	$arSort = array("ID" => "ASC");
	$arFilter = array("WL_USER_ID" => intval($arResult["WL_USER_ID"]));
		if(intval($arParams["IBLOCK_ID"]) > 0)
			$arFilter["PARAM2"] = $arParams["IBLOCK_ID"];
	$arSelect = array("PARAM3");
	$dbResult = CBrWishlist::GetList($arSort, $arFilter, $arSelect, $arNavParams);
	while($rsResult = $dbResult->GetNext()){
		$arResult["__RETURN_VALUE"][] = $arResult["ITEMS"][] = $rsResult["PARAM3"];
	}
	
	$arResult["NAV_STRING"] = $dbResult->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);
	$arResult["NAV_CACHED_DATA"] = $navComponentObject->GetTemplateCachedData();
}

$this->IncludeComponentTemplate();

return $arResult["__RETURN_VALUE"];
?>

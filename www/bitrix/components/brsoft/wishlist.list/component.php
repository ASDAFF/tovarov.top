<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($arParams["COMPONENT_ENABLE"]) && $arParams["COMPONENT_ENABLE"] === false)
	return;

if(!CModule::IncludeModule("brsoft.wishlist")) return false;
	
$arResult = array();
$arResult["WL_USER_ID"] = CBrWishlist::GetWLUserID();

if($this->StartResultCache($arParams["CACHE_TIME"])) 
{
	$dbResult = CBrWishlist::GetList(array("ID" => "ASC"), array("WL_USER_ID" => intval($arResult["WL_USER_ID"])), array("PARAM3"));
	while($rsResult = $dbResult->GetNext()){
		$arResult["__RETURN_VALUE"][] = $rsResult["PARAM3"];
	}
}

return $arResult["__RETURN_VALUE"];
?>

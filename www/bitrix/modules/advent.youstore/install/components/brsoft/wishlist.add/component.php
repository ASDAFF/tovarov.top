<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($arParams["COMPONENT_ENABLE"]) && $arParams["COMPONENT_ENABLE"] === false)
	return;

if(!CModule::IncludeModule("brsoft.wishlist")) return;

//Обработка $arParams
$arParams["PARAM1"] = "iblock"; ///TODO: for all modules
$arParams["PARAM2"] = intval($arParams["PARAM2"])?:false;
$arParams["PARAM3"] = intval($arParams["PARAM3"]);

if(!$arParams["PARAM2"]){
	$arParams["PARAM2"] = CIBlockElement::GetIBlockByID($arParams["PARAM3"]);
	if(!$arParams["PARAM2"]){return;}
}

if(empty($arParams["PARAM3"])) return; //не показывать компонент если не указаны к чему он подкреплен (ИД ИБ, ИД елемента ИБ)


//Выбор данных для $arResult
$arResult = array();

$arResult["WL_USER_ID"] = intval(CBrWishlist::GetWLUserID());
$arResult["USER_ID"] = CBrWishlistUser::GetBXUserID($arResult["WL_USER_ID"]);

if($arResult["WL_USER_ID"] <= 0) return; //не удалось найти/создать текущего пользователя (ощибка самого модуля)

$arExistsFilter = array(
	"WL_USER_ID" => $arResult["WL_USER_ID"],
	"PARAM1" => $arParams["PARAM1"],
	"PARAM2" => $arParams["PARAM2"], 
	"PARAM3" => $arParams["PARAM3"]
);

$wlElementCount = CBrWishlist::GetCount($arExistsFilter);

$arResult["ELEMENT_EXISTS"] = (($wlElementCount > 0)?"Y":"N");
$arResult["WISHLIST_ELEMENT_ID"] = false;

$dbWishlistElement = CBrWishlist::GetList(array(), $arExistsFilter);

if($arWishlistElement = $dbWishlistElement->GetNext()){
	$arResult["WISHLIST_ELEMENT_ID"] = $arWishlistElement["ID"];
}

$this->IncludeComponentTemplate();
?>

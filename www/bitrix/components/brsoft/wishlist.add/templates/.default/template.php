<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$arJSParams = array(
		"ID" => "wl_".implode("_", array($arParams["PARAM1"], $arParams["PARAM2"], $arParams["PARAM3"]))."_".$this->randString(),
		"EXISTS" => $arResult["ELEMENT_EXISTS"] == "Y"?true:false,
		"PARENT_TYPE" => $arParams["PARAM1"], //iblock
		"PARENT_ID" => $arParams["PARAM2"],   //iblock id
		"ELEMENT_ID" => $arParams["PARAM3"],   // element id
		"AJAX_URL" => $templateFolder."/ajax.php",
		"WISHLIST_ELEMENT_ID" => $arResult["WISHLIST_ELEMENT_ID"],
		"DELAY_LOAD" => $arParams["DELAYED"] == "Y"?true:false
	);
	
	$templateData = array(
		"JS_OBJ_ID" => $arJSParams["ID"]
	);
?>
<div class="wishlist_container">
	<a id="<?echo $arJSParams["ID"]?>" class="<?if($arResult["ELEMENT_EXISTS"] == "Y"):?>exists<?endif?>" href="javascript:void(0)">&nbsp;</a>
</div>

<script>
	BX.ready(function(){
		window.<?=$arJSParams["ID"];?> = new brWishlist(<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
	});
</script>
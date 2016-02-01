<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	foreach($arResult["ITEMS"] as &$arItem){
		$photo = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array("width" => 146, "height" => 147), BX_RESIZE_IMAGE_EXACT);
		$arItem["PREVIEW_PICTURE"]["SRC"] = $photo['src'];
	}
?>
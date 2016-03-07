<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$arResult['FORM_ACTION']=str_replace('index.php','',$arResult['FORM_ACTION']);
	$APPLICATION->RestartBuffer();
	unset($arResult["COMBO"]);
	echo CUtil::PHPToJSObject($arResult, true);	
?>
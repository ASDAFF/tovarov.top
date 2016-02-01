<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["FIELDS"] as $k => $v){
	switch($v["CODE"]){
		case 'NAME': 
			$arResult["FIELDS"][$k]["HINT"] = GetMessage("BRSOFT_FC_RM_HINT_NAME");//"Иванов Иван Иванович";
			$arResult["FIELDS"][$k]["NAME"] = GetMessage("BRSOFT_FC_RM_NAME_NAME");
			if($v["REQUIRED"] && !empty($arResult["ERROR_MESSAGE"]["NAME"])){
				$arResult["ERROR_MESSAGE"]["NAME"] = GetMessage("BRSOFT_FC_RM_ERR_NAME");
			}
		break;
		case 'MESSAGE':
			$arResult["FIELDS"][$k]["NAME"] = GetMessage("BRSOFT_FC_RM_HINT_MESSAGE");
			$arResult["FIELDS"][$k]["HINT"] = GetMessage("BRSOFT_FC_RM_NAME_MESSAGE");
			if($v["REQUIRED"]){
				$arResult["ERROR_MESSAGE"]["MESSAGE"] = GetMessage("BRSOFT_FC_RM_ERR_MESSAGE");
			}
		break;
		default:break;
	}
}?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$letters = range('A', 'Z');
	$letters[] = GetMessage('AJA');
	/*foreach($arResult["ITEMS"] as $arItem){
		$letter = strtoupper($arItem["NAME"][0]);
	
		if(preg_match("/[�-��-�]/ui", $letter)){
			$letter = "�-�";
		}
		$letters[] = $letter;
	}*/
	
	$arResult["LETTERS"] = $letters;

?>
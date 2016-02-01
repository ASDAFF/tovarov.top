<?
$arResult['TOVAR_ID'] = findId('TOVAR_CALLBACK');
$arResult['PHONE_ID'] = findId('PHONE_CALLBACK');

if(intval($_REQUEST['itemid'])>0){
	CModule::IncludeModule("iblock");
	$arSelect = Array("ID", "NAME");
	$arFilter = Array("ID"=>intval($_REQUEST['itemid']));
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arResult['DETAIL_ITEM'] = $arFields;
	}
}
?>
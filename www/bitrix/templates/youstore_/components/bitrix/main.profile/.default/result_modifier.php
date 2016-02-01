<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	CModule::IncludeModule("sale");
// ¬ыберем все профили покупател€ дл€ текущего пользовател€, 
// упор€дочив результат по дате последнего изменени€
	$db_sales = CSaleOrderUserProps::GetList(
        array("DATE_UPDATE" => "DESC"),
        array("USER_ID" => $USER->GetID())
    );

	while ($ar_sales = $db_sales->Fetch())
	{
		$props = array();
		$db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$ar_sales["ID"]));
		while ($arPropVals = $db_propVals->Fetch())
		{
			if($arPropVals["PROP_TYPE"] == "LOCATION"){
				$arPropVals["~VALUE"] = $arPropVals["VALUE"];
				$loc = CSaleLocation::GetByID($arPropVals["VALUE"]);
				$arPropVals["VALUE"] = ($loc["CITY_NAME"]?:$loc["REGION_NAME"])?:$loc["COUNTRY_NAME"];
			}
			$props[] = $arPropVals;
		}
		
		$ar_sales["PROPS"] = $props;
		
		$arResult["DELIVERY_ADDR"][] = $ar_sales;
	}
?>
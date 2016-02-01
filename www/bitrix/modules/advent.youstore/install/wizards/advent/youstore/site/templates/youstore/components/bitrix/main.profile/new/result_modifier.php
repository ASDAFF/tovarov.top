<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	CModule::IncludeModule("sale");
	
	if( $_REQUEST["action"]=="delete" && intval($_REQUEST["id"])>0 )
	{
		CSaleOrderUserProps::Delete(intval($_REQUEST["id"]));
	}
	
	if( $_REQUEST["action"]=="update" && intval($_REQUEST["id"])>0 )
	{
		$profileName=trim($_REQUEST["f_name"]." ".$_REQUEST["name"]." ".$_REQUEST["last_name"]);
		$arFields = array("NAME" => $profileName);
		CSaleOrderUserProps::Update($_REQUEST["id"], $arFields);

		if (!empty($_REQUEST["name"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["name_id"], array("VALUE" => $_REQUEST["name"]) );
		}

		if (!empty($_REQUEST["f_name"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["f_name_id"], array("VALUE" => $_REQUEST["f_name"]) );
		}
		if (!empty($_REQUEST["last_name"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["last_name_id"], array("VALUE" => $_REQUEST["last_name"]) );
		}
		if (!empty($_REQUEST["email"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["email_id"], array("VALUE" => $_REQUEST["email"]) );
		}
		if (!empty($_REQUEST["phone"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["phone_id"], array("VALUE" => $_REQUEST["phone"]) );
		}
		if (!empty($_REQUEST["phone"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["phone_id"], array("VALUE" => $_REQUEST["phone"]) );
		}		
		if (!empty($_REQUEST["adres"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["adres_id"], array("VALUE" => $_REQUEST["adres"]) );
		}		
		if (!empty($_REQUEST["city"])) {
			CSaleOrderUserPropsValue::Update($_REQUEST["city_id"], array("VALUE" => $_REQUEST["city"]) );
		}

	}
	if( $_REQUEST["action"]=="add"  )
	{
		$profileName=trim($_REQUEST["f_name"]." ".$_REQUEST["name"]." ".$_REQUEST["last_name"]);
		$arFields = array(
		   "NAME" => $profileName,
		   "USER_ID" => $USER->GetID(),
		   "PERSON_TYPE_ID" => 1
		);
		$USER_PROPS_ID = CSaleOrderUserProps::Add($arFields);
		if($USER_PROPS_ID)
		{
            $db_props = CSaleOrderProps::GetList(array(), array("CODE" => 'FIO'),false,false,array());
            if ($props = $db_props->Fetch())$prop_id=$props['ID'];
            $arFields = array(
			   "USER_PROPS_ID" => $USER_PROPS_ID,
			   "ORDER_PROPS_ID" => $prop_id,
			   "NAME" => GetMessage('NAME1'),
			   "VALUE" => $_REQUEST["name"].' '.$_REQUEST["last_name"].' '.$_REQUEST["f_name"]
			);
			CSaleOrderUserPropsValue::Add($arFields);

             $db_props = CSaleOrderProps::GetList(array(), array("CODE" => 'EMAIL'),false,false,array());
            if ($props = $db_props->Fetch())$prop_id=$props['ID'];
          
			$arFields = array(
			   "USER_PROPS_ID" => $USER_PROPS_ID,
			   "ORDER_PROPS_ID" => $prop_id,
			   "NAME" => GetMessage('EMAIL1'),
			   "VALUE" => $_REQUEST["email"]
			);                                                
			CSaleOrderUserPropsValue::Add($arFields);
              $db_props = CSaleOrderProps::GetList(array(), array("CODE" => 'PHONE'),false,false,array());
            if ($props = $db_props->Fetch())$prop_id=$props['ID'];
          
			$arFields = array(
			   "USER_PROPS_ID" => $USER_PROPS_ID,
			   "ORDER_PROPS_ID" => $prop_id,
			   "NAME" => GetMessage('PHONE1'),
			   "VALUE" => $_REQUEST["phone"]
			);
			CSaleOrderUserPropsValue::Add($arFields);      
            $db_props = CSaleOrderProps::GetList(array(), array("CODE" => 'LOCATION'),false,false,array());
            if ($props = $db_props->Fetch())$prop_id=$props['ID'];
          
			$arFields = array(
			   "USER_PROPS_ID" => $USER_PROPS_ID,
			   "ORDER_PROPS_ID" => $prop_id,
			   "NAME" =>  GetMessage('PROFILE_MESTO'),
			   "VALUE" => $_REQUEST["city"]
			);
			CSaleOrderUserPropsValue::Add($arFields);
             $db_props = CSaleOrderProps::GetList(array(), array("CODE" => 'ADDRESS'),false,false,array());
            if ($props = $db_props->Fetch())$prop_id=$props['ID'];
          
			$arFields = array(
			   "USER_PROPS_ID" => $USER_PROPS_ID,
			   "ORDER_PROPS_ID" => $prop_id,
			   "NAME" => GetMessage('PROFILE_ADDR'),
			   "VALUE" => $_REQUEST["adres"]
			);
			CSaleOrderUserPropsValue::Add($arFields);
			//$arFields = array(
//			   "USER_PROPS_ID" => $USER_PROPS_ID,
//			   "ORDER_PROPS_ID" => 1,
//			   "NAME" => GetMessage('LAST_NAME'),
//			   "VALUE" => $_REQUEST["f_name"]
//			);
//			CSaleOrderUserPropsValue::Add($arFields);
		}

	}

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
				$arPropVals["VALUE_"] =$loc;
			}
			$props[] = $arPropVals;
		}
		
		$ar_sales["PROPS"] = $props;
		
		$arResult["DELIVERY_ADDR"][] = $ar_sales;
	}
    
?>
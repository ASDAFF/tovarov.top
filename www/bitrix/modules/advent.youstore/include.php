<?
IncludeModuleLangFile(__FILE__);
class Cyoustore
{
	public static function OnBasketChange($ID, $arFields = false)
	{
		if(isset($_SESSION["SALE_BASKET_NUM_PRODUCTS"][SITE_ID]))
		{
			$num_products = $_SESSION["SALE_BASKET_NUM_PRODUCTS"][SITE_ID];
		}
		else
		{
			if(!CModule::IncludeModule("sale"))
			{
				return;
			}
			$fUserID = CSaleBasket::GetBasketUserID(True);
			$fUserID = IntVal($fUserID);
			$num_products = 0;
			if ($fUserID > 0)
			{
				$dbRes = CSaleBasket::GetList(
					array(),
					array(
						"FUSER_ID" => $fUserID,
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL",
						"CAN_BUY" => "Y",
						"DELAY" => "N",
						"SUBSCRIBE" => "N"
					)
				);
				while ($arItem = $dbRes->GetNext())
				{
					if (!CSaleBasketHelper::isSetItem($arItem))
						$num_products++;
				}
			}
			$_SESSION["SALE_BASKET_NUM_PRODUCTS"][SITE_ID] = intval($num_products);
		}

		echo "<script>
			if (document.getElementById('bx_cart_num'))
				document.getElementById('bx_cart_num').innerHTML = '".(($num_products > 0) ? " (".$num_products.")" : "")."';
			</script>";
	}

	function ShowPanel()
	{
		if ($GLOBALS["USER"]->IsAdmin() && COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "youstore")
		{
			$GLOBALS["APPLICATION"]->SetAdditionalCSS("/bitrix/wizards/bitrix/youstore/css/panel.css"); 

			$arMenu = Array(
				Array(		
					"ACTION" => "jsUtils.Redirect([], '".CUtil::JSEscape("/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardSiteID=".SITE_ID."&wizardName=advent:youstore&".bitrix_sessid_get())."')",
					"ICON" => "bx-popup-item-wizard-icon",
					"TITLE" => GetMessage("STOM_BUTTON_TITLE_W1"),
					"TEXT" => GetMessage("STOM_BUTTON_NAME_W1"),
				)
			);

			$GLOBALS["APPLICATION"]->AddPanelButton(array(
				"HREF" => "/bitrix/admin/wizard_install.php?lang=".LANGUAGE_ID."&wizardName=advent:youstore&wizardSiteID=".SITE_ID."&".bitrix_sessid_get(),
				"ID" => "youstore_wizard",
				"ICON" => "bx-panel-site-wizard-icon",
				"MAIN_SORT" => 2500,
				"TYPE" => "BIG",
				"SORT" => 10,	
				"ALT" => GetMessage("SCOM_BUTTON_DESCRIPTION"),
				"TEXT" => GetMessage("SCOM_BUTTON_NAME"),
				"MENU" => $arMenu,
			));
		}
	}
    function BeforeIndexHandler($arFields)
    {
        if(!CModule::IncludeModule("iblock")) // подключаем модуль
            return $arFields;
        if($arFields["MODULE_ID"] == "iblock" && $arFields["PARAM2"] == 1)
        {
            $arFields["TITLE"] .= ", ID: ".$arFields["ITEM_ID"];
        }
        return $arFields; // search.title add ID
    }
}
class ESGroupProperty
{
    public static function SetDefault(&$arParams, $name, $value)
    {
        if(is_int($value))
        {
            if(isset($arParams[$name])) $arParams[$name] = intval($arParams[$name]);
            else $arParams[$name] = intval($value);
        }
        if(is_float($value))
        {
            if(isset($arParams[$name])) $arParams[$name] = floatval($arParams[$name]);
            else $arParams[$name] = floatval($value);
        }
        if(is_string($value))
        {
            if(isset($arParams[$name])) $arParams[$name] = strval($arParams[$name]);
            else $arParams[$name] = strval($value);
        }
        if(is_bool($value))
        {
            if(isset($arParams[$name]))
            {
                if($arParams[$name] == "Y") $arParams[$name] = "true";
                if($arParams[$name] == "N") $arParams[$name] = "false";
                if($arParams[$name] == "") $arParams[$name] = "false";
            }
            else
            {
                if($value) $arParams[$name] = "true";
                else $arParams[$name] = "false";
            }
        }
    }

    public static function CheckIBlockID(&$arParams, $name)
    {
        if(is_array($arParams[$name]))
        {
            foreach($arParams[$name] as $k=>$v)
            {
                $v = intval($v);
                if($v <= 0) unset($arParams[$name][$k]);
                else $arParams[$name][$k] = $v;
            }
            if(!count($arParams[$name])) $arParams[$name] = 0;
        }
        else $arParams[$name] = intval($arParams[$name]);
    }
}
function br($str, $cnt = 20){
        $arStr = array_filter(explode(" ", $str));
        $resStr = "";
        $len = 0;
        foreach($arStr as $mstr){
            if($len + strlen($mstr) > $cnt && strlen($mstr) < $cnt){
                $resStr .= "<br/>";
                $len = 0;
            }

            if($len > 0) $resStr .= " ";
            $resStr .= $mstr;
            $len += strlen($mstr);
        }

        return $resStr;
    }
     
    
?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if($arResult["AUTH_SERVICES"]):?>
	<? 
		/*$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
			array( 
				"AUTH_SERVICES" => $arResult["AUTH_SERVICES"], 
				"AUTH_URL" => $arResult["AUTH_URL"], 
				"POST" => $arResult["POST"], 
				"POPUP" => "Y", 
				"SUFFIX" => "form"
			), 
			$component, 
			array("HIDE_ICONS"=>"Y") 
		);   */
	?>
<?endif?>
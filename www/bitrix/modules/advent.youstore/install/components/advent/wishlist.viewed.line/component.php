<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    if (!CModule::IncludeModule("sale") && !CModule::IncludeModule("currency"))
    {
        ShowError(GetMessage("SALE_MODULE_NOT_INSTALL"));
        return;
    }
	$arParams["VIEWED_COUNT"] = IntVal($arParams["VIEWED_COUNT"]);
	if ($arParams["VIEWED_COUNT"] <= 0)
		$arParams["VIEWED_COUNT"] = 5;
	
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");

    if($_REQUEST['site'])$site=$_REQUEST['site']; else $site=SITE_ID;

    $arBasketItems = array();
    $rsBaskets = CSaleBasket::GetList(
        array("ID" => "ASC"),
        array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => $site, "ORDER_ID" => "NULL"),
        false,
        false,
        array(
            "ID", "NAME", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY",
            "PRICE", "WEIGHT", "DETAIL_PAGE_URL", "NOTES", "CURRENCY", "VAT_RATE", "CATALOG_XML_ID",
            "PRODUCT_XML_ID", "SUBSCRIBE", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "TYPE", "SET_PARENT_ID"
        )
    );
    while ($arItem = $rsBaskets->GetNext())
    {
        $arBasketItems[] = $arItem;
    }
	$arResult['BASKET_ITEMS'] = $arBasketItems;
	
	//viewed
	$arFilter = array(
		"LID" =>SITE_ID,
		"FUSER_ID" => CSaleBasket::GetBasketUserID()
	);
	$db_res = CSaleViewedProduct::GetList(
		array("DATE_VISIT" => "DESC"),
		$arFilter,
		false,
		array("nTopCount" => $arParams["VIEWED_COUNT"]),
		array('ID', 'IBLOCK_ID', 'PRICE', 'CURRENCY', 'CAN_BUY', 'PRODUCT_ID', 'DATE_VISIT', 'DETAIL_PAGE_URL', 'DETAIL_PICTURE', 'PREVIEW_PICTURE', 'NAME', 'NOTES')
	);
	while ($arItems = $db_res->Fetch())
	{
		$arResult['VIEWED'][] = $arItems;
	}

    $this->IncludeComponentTemplate();
?>
<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    if (!CModule::IncludeModule("sale") && !CModule::IncludeModule("currency"))
    {
        ShowError(GetMessage("SALE_MODULE_NOT_INSTALL"));
        return;
    }             
    $arParams["PATH_TO_BASKET"] = trim($arParams["PATH_TO_BASKET"]);
    $arParams["PATH_TO_ORDER"] = trim($arParams["PATH_TO_ORDER"]);
    if(!$arParams['DISPLAY_IMG_WIDTH'])$arParams['DISPLAY_IMG_WIDTH']=70;
    if(!$arParams['DISPLAY_IMG_HEIGHT'])$arParams['DISPLAY_IMG_HEIGHT']=89;
    if(!$arParams['DISPLAY_IMG_PROP'])$arParams['DISPLAY_IMG_PROP']="Y";
    if (array_key_exists('SHOW_DELAY', $arParams) && 'N' == $arParams['SHOW_DELAY'])
        $arParams['SHOW_DELAY'] = 'N';
    else
        $arParams['SHOW_DELAY'] = 'Y';
    if (array_key_exists('SHOW_NOTAVAIL', $arParams) && 'N' == $arParams['SHOW_NOTAVAIL'])
        $arParams['SHOW_NOTAVAIL'] = 'N';
    else
        $arParams['SHOW_NOTAVAIL'] = 'Y';
    if (array_key_exists('SHOW_SUBSCRIBE', $arParams) && 'N' == $arParams['SHOW_SUBSCRIBE'])
        $arParams['SHOW_SUBSCRIBE'] = 'N';
    else
        $arParams['SHOW_SUBSCRIBE'] = 'Y';
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");
     $arParams["NAME"]=trim($arParams["NAME"]);
        if(strlen($arParams["NAME"])<=0)
            $arParams["NAME"] = "CATALOG_COMPARE_LIST";

    $arrayActions=Array('ADD_DELAY2BASKET', 'DELETEALL_FROM_DELAY', 'DELETE_FROM_DELAY', 'ADDALLDELAYED2BASKET', 'DELETEFROMCART', 'ADD2DELAY', 'ADD_TO_COMPARE_LIST', 'DELETE_FROM_COMPARE_LIST');
    if($_REQUEST['site'])$site=$_REQUEST['site']; else $site=SITE_ID;
    if($_REQUEST['action'] && in_array($_REQUEST['action'], $arrayActions)){
        
        if(intval($_REQUEST['id'])>0)$id=$_REQUEST['id'];
        if(strlen($arParams["COMPARE_URL"])<=0)
            $arParams["COMPARE_URL"] = "compare.php";
        if(!$arParams["IBLOCK_ID"]){
           $mxResult = CCatalogSku::GetProductInfo($_REQUEST['id']);
           if (is_array($mxResult))$parentid=$mxResult['ID'];
           else $parentid=$_REQUEST['id'];
           $arParams["IBLOCK_ID"]=CIBlockElement::GetIBlockByID($parentid); 
        }
       
        if(!isset($_SESSION[$arParams["NAME"]]) || !is_array($_SESSION[$arParams["NAME"]]))
            $_SESSION[$arParams["NAME"]] = array();

        if(!isset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]) || !is_array($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]))
            $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]] = array();

        if(!isset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"]) || !is_array($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"]))
            $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"] = array();

        $action=$_REQUEST['action'];
        if($_REQUEST["action"] == "ADD_TO_COMPARE_LIST" && $id > 0)
        {   
            if(!array_key_exists($id, $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"]))
            {
               // die();
                //SELECT
                $arSelect = array(
                    "ID",
                    "IBLOCK_ID",
                    "IBLOCK_SECTION_ID",
                    "NAME",
                    "DETAIL_PAGE_URL",
                );
                //WHERE
                $arFilter = array(
                    "ID" => $id,
                    "IBLOCK_LID" => SITE_ID,
                    "IBLOCK_ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y",
                    "CHECK_PERMISSIONS" => "Y",
                );

                $arOffers = CIBlockPriceTools::GetOffersIBlock($arParams["IBLOCK_ID"]);
                $OFFERS_IBLOCK_ID = $arOffers? $arOffers["OFFERS_IBLOCK_ID"]: 0;

                if($arOffers)
                    $arFilter["IBLOCK_ID"] = array($arParams["IBLOCK_ID"], $arOffers["OFFERS_IBLOCK_ID"]);
                else
                    $arFilter["IBLOCK_ID"] = $arParams["IBLOCK_ID"];

                $rsElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                $arElement = $rsElement->GetNext();

                $arMaster = false;
                if($arElement && $arElement["IBLOCK_ID"] == $OFFERS_IBLOCK_ID)
                {
                    $rsMasterProperty = CIBlockElement::GetProperty($arElement["IBLOCK_ID"], $arElement["ID"], array(), array("ID" => $arOffers["OFFERS_PROPERTY_ID"], "EMPTY" => "N"));
                    if($arMasterProperty = $rsMasterProperty->Fetch())
                    {
                        $rsMaster = CIBlockElement::GetList(
                            array()
                            ,array(
                                "ID" => $arMasterProperty["VALUE"],
                                "IBLOCK_ID" => $arMasterProperty["LINK_IBLOCK_ID"],
                                "ACTIVE" => "Y",
                            )
                            ,false, false, $arSelect);
                        $arMaster = $rsMaster->GetNext();
                    }
                }

                if($arMaster)
                {
                    $arMaster["NAME"] = $arElement["NAME"];
                    $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$id] = $arMaster;
                }
                elseif($arElement)
                {
                    $_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$id] = $arElement;
                }
            }
            else{
                unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$id]);
            }
        }

        /*************************************************************************
        Handling the Remove link
        *************************************************************************/

        elseif($_REQUEST["action"]=="DELETE_FROM_COMPARE_LIST" && $id > 0)
        {
            unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$id]);
        }
        elseif($action=='ADD_DELAY2BASKET' && intval($_REQUEST['id'])>0){
            $dbBasketItems = CSaleBasket::GetList(array(),array("ID" => $id,"FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID", "QUANTITY"));
            if ($arItems = $dbBasketItems->Fetch())CSaleBasket::Update($arItems["ID"], array("DELAY" => "N"));
        } 
        elseif($action=='ADD2DELAY' && (intval($_REQUEST['id'])>0 || count($_REQUEST['id'])>0)){
            $ids=array();
            if(is_array($_REQUEST['id']) && count($_REQUEST['id'])>0){
                foreach($_REQUEST['id'] as $d)$ids[]=$d;
            }
            else $ids[]=$_REQUEST['id'];
            foreach($ids as $id){
            $mxResult = CCatalogSku::GetProductInfo($id);
            if (is_array($mxResult))$parentid=$mxResult['ID'];
            else $parentid=$id;

            $dbBasketItems = CSaleBasket::GetList(array(),array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID", "PRODUCT_ID"));
            while ($arItems = $dbBasketItems->Fetch()){
                $mxResult = CCatalogSku::GetProductInfo($arItems['PRODUCT_ID']);

                if ((is_array($mxResult) && $mxResult['ID']==$parentid) || $arItems['PRODUCT_ID']==$parentid){

                    CSaleBasket::Delete($arItems['ID']); 
                    $bool=true;
                }
            }
            if(!$bool){
                Add2BasketByProductID(
                    $id, 
                    1, 
                    array('DELAY' => 'Y'), 
                    array()
                );  
            }
           }
        }
        elseif($action=='DELETE_FROM_DELAY' && intval($_REQUEST['id'])>0){    
            $dbBasketItems = CSaleBasket::GetList(array(),array("PRODUCT_ID" => $id,"FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID"));
            if ($arItems = $dbBasketItems->Fetch())CSaleBasket::Delete($arItems['ID']);
        }        
        elseif($action=='DELETEALL_FROM_DELAY'){
            $dbBasketItems = CSaleBasket::GetList(array(),array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID"));
            while ($arItems = $dbBasketItems->Fetch())CSaleBasket::Delete($arItems['ID']);
        }
        elseif($action=='DELETEFROMCART' && intval($_REQUEST['id'])>0){
            $dbBasketItems = CSaleBasket::GetList(array(),array("ID" => $id,"FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID"));
            if ($arItems = $dbBasketItems->Fetch())CSaleBasket::Delete($arItems['ID']);
        }
        elseif($action=='ADDALLDELAYED2BASKET'){
            $dbBasketItems = CSaleBasket::GetList(array(),array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => $site,"ORDER_ID" => "NULL"),false,false,array("ID"));
            while ($arItems = $dbBasketItems->Fetch()){
                CSaleBasket::Update($arItems["ID"], array("DELAY" => "N"));
            }
        }
        LocalRedirect($APPLICATION->GetCurPageParam('', array('action', 'id')));   
    }


    $bReady = false;
    $bDelay = false;
    $bNotAvail = false;
    $bSubscribe = false;
    $arItems = array();
    $arReadyItems = array();
    $allSum = 0.0;
    $allWeight = 0.0;
    $arBasketItems = array();
    $arSetParentWeight = array();
    $noneprops=Array('CATALOG.XML_ID', 'PRODUCT.XML_ID', 'ARTNUMBER');
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
        $res = CIBlockElement::GetList(Array(), Array("ID"=>IntVal($arItem['PRODUCT_ID'])), false, false, Array('ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO'));
        if($ob = $res->GetNext()){
            $img=$ob['PREVIEW_PICTURE']?$ob['PREVIEW_PICTURE']:($ob['DETAIL_PICTURE'])?$ob['DETAIL_PICTURE']:$ob['PROPERTY_MORE_PHOTO'][0];
            if(!$img){
                $mxResult = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
                if (is_array($mxResult))
                {   
                    $parentres = CIBlockElement::GetList(Array(), Array("ID"=>IntVal($mxResult['ID'])), false, false, Array('ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO'));
                    if($obparent = $parentres->GetNext()){
                        $img=$obparent['PREVIEW_PICTURE']?$obparent['PREVIEW_PICTURE']:($obparent['DETAIL_PICTURE'])?$obparent['DETAIL_PICTURE']:$obparent['PROPERTY_MORE_PHOTO'][0];
                    }
                }
            }
            $method=$arParams['DISPLAY_IMG_PROP']=='Y'?BX_RESIZE_IMAGE_PROPORTIONAL:BX_RESIZE_IMAGE_EXACT;
            if($img)$file = CFile::ResizeImageGet($img, array('width'=>$arParams['DISPLAY_IMG_WIDTH'], 'height'=>$arParams['DISPLAY_IMG_HEIGHT']), $method, true); 
            else $file['src']=SITE_TEMPLATE_PATH.'/images/nophoto.png'; 
            $arItem['PICTURE']=Array('ID'=>$img, 'SRC'=>$file['src'], 'HEIGHT'=>$file['height'], 'WIDTH'=>$file['width']);    
            unset($img);           
            unset($file);           
        }
        $db_res = CSaleBasket::GetPropsList(
            array(
                "SORT" => "ASC",
                "NAME" => "ASC"
            ),
            array("BASKET_ID" => $arItem['ID'])
        );
        while ($ar_res = $db_res->Fetch())
        {
            if(!in_array($ar_res['CODE'], $noneprops))
                $arItem['PROPS'][]= $ar_res;
        }
        $arBasketItems[] = $arItem;

        if (CSaleBasketHelper::isSetItem($arItem))
            $arSetParentWeight[$arItem["SET_PARENT_ID"]] += $arItem["WEIGHT"] * $arItem['QUANTITY'];
    }

    // count weight for set parent products
    foreach ($arBasketItems as &$arItem)
    {
        if (CSaleBasketHelper::isSetParent($arItem))
            $arItem["WEIGHT"] = $arSetParentWeight[$arItem["ID"]] / $arItem["QUANTITY"];    
    }
    unset($arItem);
    $count=0;
    foreach ($arBasketItems as &$arItem)
    {
        if (CSaleBasketHelper::isSetItem($arItem))
            continue;

        $boolOneReady = false;
        if ($arItem["DELAY"]=="N" && $arItem["CAN_BUY"]=="Y")
        {
            $boolOneReady = true;
            $bReady = true;
            $allSum += ($arItem["PRICE"] * $arItem["QUANTITY"]);
            $allWeight += ($arItem["WEIGHT"] * $arItem["QUANTITY"]);
            $count++;
        }
        elseif ($arItem["DELAY"]=="Y" && $arItem["CAN_BUY"]=="Y")
        {
            if ('N' == $arParams['SHOW_DELAY'])
                continue;
            $bDelay = true;
        }
        elseif ($arItem["CAN_BUY"]=="N" && $arItem["SUBSCRIBE"]=="N")
        {
            if ('N' == $arParams['SHOW_NOTAVAIL'])
                continue;
            $bNotAvail = true;
        }
        elseif ($arItem["CAN_BUY"]=="N" && $arItem["SUBSCRIBE"]=="Y")
        {
            if ('N' == $arParams['SHOW_SUBSCRIBE'])
                continue;
            $bSubscribe = true;
        }

        if (!$boolOneReady)
        {
            $arItem["PRICE_FORMATED"] = SaleFormatCurrency($arItem["PRICE"], $arItem["CURRENCY"]);
            $arItems[] = $arItem;
        }
        else
        {
            $arReadyItems[] = $arItem;
        }
    }

    if (!empty($arReadyItems))
    {
        $arOrder = array(
            'SITE_ID' => $site,
            'USER_ID' => $USER->GetID(),
            'ORDER_PRICE' => $allSum,
            'ORDER_WEIGHT' => $allWeight,
            'BASKET_ITEMS' => $arReadyItems
        );

        $arOptions = array();

        $arErrors = array();

        CSaleDiscount::DoProcessOrder($arOrder, $arOptions, $arErrors);

        foreach ($arOrder['BASKET_ITEMS'] as &$arOneItem)
        {
            $arOneItem["PRICE_FORMATED"] = SaleFormatCurrency($arOneItem["PRICE"], $arOneItem["CURRENCY"]);
        }
        if (isset($arOneItem))
            unset($arOneItem);

        $arItems = array_merge($arOrder['BASKET_ITEMS'], $arItems);
    }
    $arCompare = $_SESSION[$arParams["NAME"]];
    if($arCompare)foreach($arCompare as $ib=>$arIblock)
    if($arIblock['ITEMS'])foreach($arIblock['ITEMS'] as $id=>$arItem)
    {
        $arCompare[$ib]['ITEMS'][$id]["DELETE_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=DELETE_FROM_COMPARE_LIST&id=".$arItem["ID"], array("action", "id")));
    }
    $arResult = array(
        'READY' => ($bReady ? "Y" : "N"),
        'DELAY' => ($bDelay ? "Y" : "N"),
        'NOTAVAIL' => ($bNotAvail ? "Y" : "N"),
        'SUBSCRIBE' => ($bSubscribe ? "Y" : "N"),
        'PRICE' => $allSum,
        'COUNT' => $count,
        'PRICE_FORMATED' => SaleFormatCurrency($allSum, CCurrency::GetBaseCurrency()),
        'ITEMS' => $arItems,
        'COMPARE' => $arCompare
    );
   
    if(!function_exists('digital')){
        function digital($n, $form1, $form2, $form3)
        {
            $n = abs($n) % 100;
            $n1 = $n % 10;
            if ($n > 10 && $n < 20) return $form3;
            if ($n1 > 1 && $n1 < 5) return $form2;
            if ($n1 == 1) return $form1;
            return $form3;
        }
    }

    $this->IncludeComponentTemplate();
?>
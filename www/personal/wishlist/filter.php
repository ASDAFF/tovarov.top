<?
    CModule::includeModule('catalog');
    CModule::includeModule('iblock');
    CModule::includeModule('sale');
    $dbBasketItems = CSaleBasket::GetList(array(),array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'Y', "LID" => SITE_ID,"ORDER_ID" => "NULL"),false,false,array("ID", "PRODUCT_ID"));
    while($arItems = $dbBasketItems->Fetch()){          
        $mxResult = CCatalogSku::GetProductInfo($arItems['PRODUCT_ID']);
        if (is_array($mxResult))$id=$mxResult['ID'];
        else $id=$arItems['PRODUCT_ID'];
        $GLOBALS['wished']['ID'][]=$id;
    } 
    
?>
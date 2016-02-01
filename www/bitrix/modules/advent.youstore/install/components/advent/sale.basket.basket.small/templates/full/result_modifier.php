<?
    if($arResult["ITEMS"])foreach ($arResult["ITEMS"] as &$arItem){ 
        if ($arItem["DELAY"]=="N" && $arItem["CAN_BUY"]=="Y"){
            $id=$arItem['PRODUCT_ID'];
            $arSelect = Array("ID", "CATALOG_GROUP_1", "PROPERTY_ARTNUMBER");
            $arFilter = Array("IBLOCK_ID"=>CIBlockElement::GetIBlockByID($id), "ID"=>$id, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
            if($arFields = $res->GetNext())
            {
                $arItem['CATALOG']=$arFields;
                $arItem['ARTNUMBER']=$arFields['PROPERTY_ARTNUMBER_VALUE'];
            }
        }  
    }
?>
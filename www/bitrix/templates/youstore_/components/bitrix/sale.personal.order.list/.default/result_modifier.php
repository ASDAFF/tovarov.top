<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    CModule::IncludeModule("iblock");
    $arResult["PHOTOS"] = array();

    if($arResult["ORDERS"])foreach($arResult["ORDERS"] as &$val){
        foreach($val["BASKET_ITEMS"] as $vval){

            $dbEl = CIBlockElement::GetByID($vval["PRODUCT_ID"]);
            if($rsEl = $dbEl->GetNext()){
                $arResult["PHOTOS"][$rsEl["ID"]] = CFile::GetPath($rsEl["PREVIEW_PICTURE"]);
                if(empty($arResult["PHOTOS"][$rsEl["ID"]])){
                    $dbPhoto = CIBlockElement::GetProperty($rsEl["IBLOCK_ID"], $rsEl["ID"], "id", "asc", array("CODE" => $arParams["IMG_PROPERTY"]));
                    if($arPhoto = $dbPhoto->GetNext()){
                        $photo = CFile::ResizeImageGet($arPhoto["VALUE"], array("width" => 36, "height" => 36));
                        $arResult["PHOTOS"][$rsEl["ID"]] = $photo['src'];
                    }
                }
                if(empty($arResult["PHOTOS"][$rsEl["ID"]])) $arResult["PHOTOS"][$rsEl["ID"]] = SITE_TEMPLATE_PATH."/images/no_photo.png";
            }else{
                $arResult["PHOTOS"][$vval["PRODUCT_ID"]] = SITE_TEMPLATE_PATH."/images/no_photo.png";
            }
        }
        if ($arPaySys = CSalePaySystem::GetByID($val['ORDER']['PAY_SYSTEM_ID'], $val['ORDER']['PERSON_TYPE_ID']))
        { 
            $pathToAction = $_SERVER["DOCUMENT_ROOT"].$arPaySys["PSA_ACTION_FILE"];

            $pathToAction = str_replace("\\", "/", $pathToAction);
            while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
                $pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);

            if (file_exists($pathToAction))
            {
                if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
                    $pathToAction .= "/payment.php";

               $val['ORDER']['PSA_ACTION_FILE'] = $pathToAction;
            }   
             

        }

    }
?>
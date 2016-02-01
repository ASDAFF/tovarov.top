<?
    CModule::IncludeModule('highloadblock');
    foreach($arResult['ITEMS'] as &$arItem){

        if(is_array($arItem['PREVIEW_PICTURE'])){
            $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],array('width'=>124,'height'=>167),BX_RESIZE_IMAGE_EXACT,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
            $arItem['HAS_PIC'] = 'Y';
        }

        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $arItem['PROPERTIES']['BG']['USER_TYPE_SETTINGS']['TABLE_NAME'])))->fetch();
        if (!isset($hlblock['ID']))
            continue;
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $rsPropEnums = $entity_data_class::getList(  array(
                'select' => array('ID','UF_NAME','UF_FILE','UF_TYPE'),
                'filter' => array('UF_XML_ID'=>$arItem['PROPERTIES']['BG']['VALUE']),
                'order' => array('ID' => 'ASC'),
                'limit' => 100,
            )
        );
        while ($arEnum = $rsPropEnums->fetch())
        {
            if($arEnum["UF_TYPE"]){$rsGender = CUserFieldEnum::GetList(array(), array("ID" => $arEnum["UF_TYPE"],));
                if($arGender = $rsGender->GetNext())
                    $arItem['BG_TYPE'] = $arGender["XML_ID"];
            }
            $arItem['PROPERTIES']['BG']['BG_SRC'] = CFile::GetPath($arEnum['UF_FILE']);
        }
        $arResult['ACTION_END'][$arItem['ID']] = $arItem["DATE_ACTIVE_TO"]; 
        $seconds = strtotime($arItem["DATE_ACTIVE_TO"])-time();
        if($seconds>0){
            $dt = new DateTime('@' . $seconds, new DateTimeZone('UTC'));
            $arItem['ACTION_END'] = $dt->format('z');  
        }  
    }

    $cp = $this->__component; 
    if (is_object($cp))
    {
        $cp->SetResultCacheKeys(array('ACTION_END')); 
    }
?>


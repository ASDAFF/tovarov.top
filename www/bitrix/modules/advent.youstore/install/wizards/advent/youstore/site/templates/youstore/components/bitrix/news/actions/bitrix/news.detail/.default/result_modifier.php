<?
$seconds = strtotime($arResult["DATE_ACTIVE_TO"])-time();
        if($seconds>0){
            $dt = new DateTime('@' . $seconds, new DateTimeZone('UTC'));
            $arResult['ACTION_END'] = $dt->format('z');  
        } 
        
         $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $arResult['PROPERTIES']['BG_DET']['USER_TYPE_SETTINGS']['TABLE_NAME'])))->fetch();
        if (!isset($hlblock['ID']))
            continue;
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $rsPropEnums = $entity_data_class::getList(  array(
                'select' => array('ID','UF_NAME','UF_FILE'),
                'filter' => array('UF_XML_ID'=>$arResult['PROPERTIES']['BG_DET']['VALUE']),
                'order' => array('ID' => 'ASC'),
                'limit' => 100,
            )
        );
        while ($arEnum = $rsPropEnums->fetch())
        {      
           /* if($arEnum["UF_TYPE"]){$rsGender = CUserFieldEnum::GetList(array(), array("ID" => $arEnum["UF_TYPE"],));
                if($arGender = $rsGender->GetNext())
                    $arItem['BG_TYPE'] = $arGender["XML_ID"];
            } */
            $arResult['PROPERTIES']['BG_DET']['BG_SRC'] = CFile::GetPath($arEnum['UF_FILE']);
        }
?>
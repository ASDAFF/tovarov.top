<?
    /*  if(is_array($arResult['PROPERTIES']['TABS']['VALUE']))
    {
    foreach($arResult['PROPERTIES']['TABS']['VALUE'] as $key=>$tab){
    $obj = CIblockElement::GetList(array(),array('ID'=>$tab),false,false,array('PREVIEW_TEXT','PREVIEW_PICTURE','IBLOCK_SECTION_ID','IBLOCK_ID',));
    while($res = $obj->GetNext()){

    $photos = array(); $i=0;
    $resPh = CIBlockElement::GetProperty($res['IBLOCK_ID'], $tab, "sort", "asc", array("CODE" => "MORE_PHOTO"));
    while ($ob = $resPh->GetNext())
    {
    $photos[$i] = CFile::ResizeImageGet($ob['VALUE'],array('width'=>847,'height'=>421),BX_RESIZE_IMAGE_EXACT,true);
    $photos[$i]['DESCRIPTION'] = $ob['DESCRIPTION'];
    $i++;

    }

    $arFilter = array('IBLOCK_ID' => $res['IBLOCK_ID'], 'ID'=>$res['IBLOCK_SECTION_ID']);
    $rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter,false,array('NAME'));
    while ($arSction = $rsSections->Fetch())
    {
    $name =  $arSction['NAME']; 
    } 
    $arResult['TABS'][$key]['NAME']   = $name;

    $arResult['TABS'][$key]['TEXT'] = $res['~PREVIEW_TEXT'] ;
    $arResult['TABS'][$key]['PICTURES'] =$photos; ?>

    <?         }
    }
    unset($arResult['PROPERTIES']['TABS']); 
    unset($arResult['DISPLAY_PROPERTIES']['TABS']); 
    }*/

    for($i=1;$i<11;$i++){
        if(!empty($arResult['PROPERTIES']['TAB_'.$i.'_TYPE']['VALUE'])){
            $arTabs[$i]['TYPE'] = $arResult['PROPERTIES']['TAB_'.$i.'_TYPE'];
            unset($arResult['PROPERTIES']['TAB_'.$i.'_TYPE']);
            unset($arResult['DISPLAY_PROPERTIES']['TAB_'.$i.'_TYPE']);
            $arTabs[$i]['PHOTOS'] = $arResult['PROPERTIES']['TAB_'.$i.'_PHOTOS']; 
            unset($arResult['PROPERTIES']['TAB_'.$i.'_PHOTOS']);
            unset($arResult['DISPLAY_PROPERTIES']['TAB_'.$i.'_PHOTOS']);
            $arTabs[$i]['TEXT'] = $arResult['PROPERTIES']['TAB_'.$i.'_TEXT']; 
            unset($arResult['PROPERTIES']['TAB_'.$i.'_TEXT']);
            unset($arResult['DISPLAY_PROPERTIES']['TAB_'.$i.'_TEXT']);
        }
    }    
    // подключаем модули

    CModule::IncludeModule('highloadblock');
    foreach($arTabs as &$tab){
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $tab['TYPE']['USER_TYPE_SETTINGS']['TABLE_NAME'])))->fetch();
        if (!isset($hlblock['ID']))
            continue;
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $rsPropEnums = $entity_data_class::getList(  array(
                'select' => array('ID','UF_NAME','UF_FILE'),
                'filter' => array('UF_XML_ID'=>$tab['TYPE']['VALUE']),
                'order' => array('ID' => 'ASC'),
                'limit' => 100,
            )
        );
        while ($arEnum = $rsPropEnums->fetch())
        {
            $type['NAME'] = $arEnum['UF_NAME'];
            $type['ICO'] = CFile::GetPath($arEnum['UF_FILE']);
        }
        $tab['TYPE'] = $type;
        if($tab['PHOTOS']['VALUE'])foreach($tab['PHOTOS']['VALUE'] as $key => $photo){   //дополнительные фото

        
            $photos[$key] = CFile::ResizeImageGet($photo,array('width'=>847,'height'=>421),BX_RESIZE_IMAGE_EXACT,true);
            $description = $tab['PHOTOS']['DESCRIPTION'];
            $tab['PHOTOS']['PICS'] =  $photos;
            $tab['PHOTOS']['DESC'] =  $description;
        }
        $tab['TEXT'] = $tab['TEXT']['~VALUE']['TEXT'];   // текст вкладки
    }
    $arResult['TABS'] = $arTabs;
?>

<?
    foreach($arResult['ITEMS'] as &$arItem){
        if(is_array($arItem['PREVIEW_PICTURE'])){
            $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],array('width'=>93,'height'=>94),BX_RESIZE_IMAGE_EXACT,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }
        elseif(is_array($arItem['DETAIL_PICTURE'])){
            $file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>93,'height'=>94),BX_RESIZE_IMAGE_EXACT,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }
    }
  
    
?>

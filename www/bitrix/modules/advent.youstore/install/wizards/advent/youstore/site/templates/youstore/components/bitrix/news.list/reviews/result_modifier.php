<?
    foreach($arResult['ITEMS'] as &$arItem){
        if($arItem['PROPERTIES']['AVATAR']['VALUE']){
            $file = CFile::ResizeImageGet($arItem['PROPERTIES']['AVATAR']['VALUE'],array('width'=>46,'height'=>45),BX_RESIZE_IMAGE_EXACT,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }
       /* elseif(is_array($arItem['DETAIL_PICTURE'])){
            $file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>46,'height'=>45),BX_RESIZE_IMAGE_EXACT,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }*/
    }
  
    
?>

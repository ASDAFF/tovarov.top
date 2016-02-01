<?
    foreach($arResult['ITEMS'] as &$arItem){
        if(is_array($arItem['PREVIEW_PICTURE'])){
             
            $width = round(($arItem['PREVIEW_PICTURE']['WIDTH']*177)/$arItem['PREVIEW_PICTURE']['HEIGHT']);
            $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],array('width'=>$width,'height'=>177),BX_RESIZE_IMAGE_PROPORTIONAL,true);
           
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }
        elseif(is_array($arItem['DETAIL_PICTURE'])){
            $width = round(($arItem['DETAIL_PICTURE']['WIDTH']*177)/$arItem['DETAIL_PICTURE']['HEIGHT']);
            $file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>$width,'height'=>177),BX_RESIZE_IMAGE_PROPORTIONAL,true);
            $arItem['RESIZE_PICTURE'] = array_change_key_case($file,CASE_UPPER);
        }
    }
  
    
?>

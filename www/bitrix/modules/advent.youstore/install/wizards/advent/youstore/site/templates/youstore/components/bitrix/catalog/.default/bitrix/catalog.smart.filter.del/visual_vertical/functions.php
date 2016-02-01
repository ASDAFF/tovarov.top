<?
	function getPropDirectory(&$property){
		if (empty($property))
            return false;
        if (!is_array($property))
            return false;
        if (!isset($property['USER_TYPE_SETTINGS']['TABLE_NAME']) || empty($property['USER_TYPE_SETTINGS']['TABLE_NAME']))
            return false;
			
        $highLoadInclude = \Bitrix\Main\Loader::includeModule('highloadblock');

        $highBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $property['USER_TYPE_SETTINGS']['TABLE_NAME'])))->fetch();
        if (!isset($highBlock['ID']))
            return false;
		
		$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highBlock);
        $entityDataClass = $entity->getDataClass();
		$entityList = $entityDataClass::getList();
		while($arEntityItem = $entityList->Fetch()){
			$val = &$property["VALUES"][$arEntityItem["UF_XML_ID"]];
			//foreach($property["VALUES"] as &$val){
				if(!empty($arEntityItem["UF_FILE"])){
					$property["PICTURE_INCLUDED"] = true;
					$arEntityItem["~UF_FILE"] = $arEntityItem["UF_FILE"];
					$arEntityItem["PICTURE"] = CFile::GetPath($arEntityItem["~UF_FILE"]);
				}
				if(!empty($arEntityItem))
				    $val = array_merge($val, $arEntityItem);
			//}
			//echo'<pre>';print_r($arEntityItem);echo'</pre>';
		}
		
		return true;
	}
?>
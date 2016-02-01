<?	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
        return;

    if(COption::GetOptionString("youstore", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
        return;


	$res = CIBlock::GetList(Array(), Array("=CODE"=>'catalog'), true);
	while($ar_res = $res->Fetch())
	{
		$iblockId = $ar_res['ID'];
	}

	if(intval($iblockId)>0){
		//Добавление пользовательского свойства
		$oUserTypeEntity = new CUserTypeEntity();
		$aUserFields = array(
			'ENTITY_ID'         => 'IBLOCK_'.$iblockId.'_SECTION', //Идентификатор сущности, к которой будет привязано свойство. Для секция формат следующий - IBLOCK_{IBLOCK_ID}_SECTION
			'FIELD_NAME'        => 'UF_SECTION_ICON', //Код поля. Всегда должно начинаться с UF_
			'USER_TYPE_ID'      => 'file', // Указываем, что тип нового пользовательского свойства файл
			'XML_ID'            => 'UF_SECTION_ICON', //XML_ID пользовательского свойства. Используется при выгрузке в качестве названия поля
			'SORT'              => 100, //Сортировка
			'MULTIPLE'          => 'N', //Является поле множественным или нет
			'MANDATORY'         => 'N', //Обязательное или нет свойство
			'SHOW_FILTER'       => 'N', //Показывать в фильтре списка. Возможные значения: не показывать = N, точное совпадение = I, поиск по маске = E, поиск по подстроке = S
			'SHOW_IN_LIST'      => '', //Не показывать в списке. Если передать какое-либо значение, то будет считаться, что флаг выставлен (недоработка разработчиков битрикс).
			'EDIT_IN_LIST'      => '', //Не разрешать редактирование пользователем. Если передать какое-либо значение, то будет считаться, что флаг выставлен (недоработка разработчиков битрикс).
			'IS_SEARCHABLE'     => 'N', //Значения поля участвуют в поиске
			'SETTINGS'          => array( //Дополнительные настройки поля (зависят от типа). В нашем случае для типа файл
				'SIZE'          => '20', //Размер поля ввода для отображения
				'LIST_WIDTH'    => '200', //Максимальная ширина для отображения в списке
				'LIST_HEIGHT'   => '200', //Максимальная высота для отображения в списке
				'MAX_SHOW_SIZE' => '0', //Максимально допустимый размер для показа в списке (0 - не ограничивать)
				'MAX_ALLOWED_SIZE' => '0', //Максимально допустимый размер файла для загрузки (0 - не проверять)
				'EXTENSIONS'    => 'jpg, gif, bmp, png, jpeg', //Расширения
			),
			'EDIT_FORM_LABEL'   => array( //Подпись в форме редактирования
				'ru'    => 'Section icon',
				'en'    => 'Section icon',
			),
			'LIST_COLUMN_LABEL' => array( //Заголовок в списке
				'ru'    => 'Section icon',
				'en'    => 'Section icon',
			),
			'LIST_FILTER_LABEL' => array( //Подпись фильтра в списке
				'ru'    => 'Section icon',
				'en'    => 'Section icon',
			),
			'ERROR_MESSAGE'     => array( //Сообщение об ошибке (не обязательное)
				'ru'    => 'Error',
				'en'    => 'Error',
			),
			'HELP_MESSAGE'      => array( //Помощь
				'ru'    => 'Help',
				'en'    => 'Help',
			),
		);
		if($iUserFieldId = $oUserTypeEntity->Add( $aUserFields )){ // int
			$arSections = array();
			$arFilter = array('IBLOCK_ID' => $iblockId);
			$rsSect = CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,array('ID','CODE'));
			while ($arSect = $rsSect->GetNext())
			{
				$arSections[$arSect['CODE']] = $arSect['ID'];
			}
			
			$arChangeSect = array('bytovaya-tekhnika', 'chasy_i_aksessuary_', 'chasy_', 'gps', 'igrushki', 'kompyutery', 'koshelki_', 'krupnaya-bytovaya-tekhnika', 'melkaya-bytovaya-tekhnika', 'ochki', 'remni', 'smartfony', 'telefony', 'zdorove-i-sport');
			foreach($arChangeSect as $code){
				if(intval($arSections[$code])>0 && file_exists($_SERVER["DOCUMENT_ROOT"]."/upload/uf_section_icon/".$code.".png")){
					//добавляем картинку разделу
					$bs = new CIBlockSection;
					$arFields = Array(
						"IBLOCK_ID" => $iblockId,
						"UF_SECTION_ICON" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/uf_section_icon/".$code.".png")
					);
					$bs->Update($arSections[$code], $arFields);
				}
			}
		}
	}
	##############################################################################



	//Изменение описания часов
	$ELEMENT_CODE = 'braslet_lifetrack_move_c_300_cherno_zelenyy';  
	$el = new CIBlockElement;

	// Установим новое значение для данного свойства данного элемента
	$dbr = CIBlockElement::GetList(array(), array("=CODE"=>"braslet_lifetrack_move_c_300_cherno_zelenyy"), false, false, array("ID", "IBLOCK_ID"));
	if ($dbr_arr = $dbr->Fetch())
	{
	  $watchID = $dbr_arr["ID"];
	}

	$arLoadProductArray = Array(
	  "DETAIL_TEXT"    => "Удивительно, но такие часы понравились моему сыну, ему 10 лет. И его совсем не волнует, что в них нет сетевого сервиса, он скорее соревнуется со мной и постоянно узнает, сколько я прошел. Но тут вопрос в том, что он не видел альтернатив и пока не понимает различий между разными устройствами. А для вас такие различия видны значительно лучше. Недорого, но странно – вот такой вывод я могу сделать относительно этих часов для здорового образа жизни. С инженерной точки зрения все сделано отлично, а вот софт подкачал, также как и дизайн устройства. Поэтому низкая цена видится вполне оправданной.",
	  );

	$res = $el->Update($watchID, $arLoadProductArray);


?>
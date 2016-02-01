<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    if (!IsModuleInstalled("highloadblock") && file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/"))
    {
        $installFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/install/index.php";
        if (!file_exists($installFile))
            return false;

        include_once($installFile);

        $moduleIdTmp = str_replace(".", "_", "highloadblock");
        if (!class_exists($moduleIdTmp))
            return false;

        $module = new $moduleIdTmp;
        if (!$module->InstallDB())
            return false;
        $module->InstallEvents();
        if (!$module->InstallFiles())
            return false;
    }

    if (!CModule::IncludeModule("highloadblock"))
        return;

    if (!WIZARD_INSTALL_DEMO_DATA)
        return;

    use Bitrix\Highloadblock as HL;

    $dbHblock = HL\HighloadBlockTable::getList(
        array(
            "filter" => array("TABLE_NAME" => "b_color")
        )
    );
    if (!$dbHblock->Fetch())
    {
        $data = array(
            'NAME' => 'Color',
            'TABLE_NAME' => 'b_color',
        );

        $result = HL\HighloadBlockTable::add($data);
        $ID = $result->getId();

        $_SESSION["YOUSTORE_HBLOCK_COLOR_ID"] = $ID;

        $hldata = HL\HighloadBlockTable::getById($ID)->fetch();
        $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

        //adding user fields
        $arUserFields = array (
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_NAME',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_COLOR_NAME',
                'SORT' => '100',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FILE',
                'USER_TYPE_ID' => 'file',
                'XML_ID' => 'UF_COLOR_FILE',
                'SORT' => '200',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_LINK',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_COLOR_LINK',
                'SORT' => '300',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_SORT',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'UF_COLOR_SORT',
                'SORT' => '400',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_DEF',
                'USER_TYPE_ID' => 'boolean',
                'XML_ID' => 'UF_COLOR_DEF',
                'SORT' => '500',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),

            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_DARK_COLOR',
                'USER_TYPE_ID' => 'boolean',
                'XML_ID' => 'UF_DARK_COLOR',
                'SORT' => '500',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_XML_ID',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_XML_ID',
                'SORT' => '600',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'Y',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            )
        );
        $arLanguages = Array();
        $rsLanguage = CLanguage::GetList($by, $order, array());
        while($arLanguage = $rsLanguage->Fetch())
            $arLanguages[] = $arLanguage["LID"];

        $obUserField  = new CUserTypeEntity;
        foreach ($arUserFields as $arFields)
        {
            $dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
            if ($dbRes->Fetch())
                continue;

            $arLabelNames = Array();
            foreach($arLanguages as $languageID)
            {
                WizardServices::IncludeServiceLang("references.php", $languageID);
                $arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
            }

            $arFields["EDIT_FORM_LABEL"] = $arLabelNames;
            $arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
            $arFields["LIST_FILTER_LABEL"] = $arLabelNames;

            $ID_USER_FIELD = $obUserField->Add($arFields);
        }
    }

    $dbHblock = HL\HighloadBlockTable::getList(
        array(
            "filter" => array("TABLE_NAME" => "background")
        )
    );
    $br=$dbHblock->Fetch(); 
    if (!$br)
    {
        $data = array(
            'NAME' => 'Background',
            'TABLE_NAME' => 'background',
        );

        $result = HL\HighloadBlockTable::add($data);
        $ID = $result->getId();

        $_SESSION["YOUSTORE_HBLOCK_BACK_ID"] = $ID;

        $hldata = HL\HighloadBlockTable::getById($ID)->fetch();
        $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

        //adding user fields
        $arUserFields = array (
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_NAME',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_BACK_NAME',
                'SORT' => '100',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FILE',
                'USER_TYPE_ID' => 'file',
                'XML_ID' => 'UF_BACK_FILE',
                'SORT' => '200',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_TYPE',
                'USER_TYPE_ID' => 'enumeration',
                'XML_ID' => 'UF_BACK_TYPE',
                'SORT' => '300',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_BACK_DESCR',
                'SORT' => '400',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FULL_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_BACK_FULL_DESCR',
                'SORT' => '500',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_SORT',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'UF_BACK_SORT',
                'SORT' => '600',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_EXTERNAL_CODE',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_BACK_EXTERNAL_CODE',
                'SORT' => '700',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_XML_ID',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_BACK_XML_ID',
                'SORT' => '800',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'Y',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            )
        );
        $arLanguages = Array();
        $rsLanguage = CLanguage::GetList($by, $order, array());
        while($arLanguage = $rsLanguage->Fetch())
            $arLanguages[] = $arLanguage["LID"];

        $obUserField  = new CUserTypeEntity;
        foreach ($arUserFields as $arFields)
        {
            $dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
            if ($dbRes->Fetch())
                continue;

            $arLabelNames = Array();
            foreach($arLanguages as $languageID)
            {
                WizardServices::IncludeServiceLang("references.php", $languageID);
                $arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
            }

            $arFields["EDIT_FORM_LABEL"] = $arLabelNames;
            $arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
            $arFields["LIST_FILTER_LABEL"] = $arLabelNames;

            $ID_USER_FIELD = $obUserField->Add($arFields);
            if($arFields['FIELD_NAME']=='UF_TYPE'){
                $obEnum = new CUserFieldEnum;
                $obEnum->SetEnumValues(
                    $ID_USER_FIELD,         //ID пользовательского пол€  
                    array( 
                        'n0' => array( //ƒобавить новое значение
                            'VALUE' => GetMessage('UF_TYPE_sv'),
                            'USER_FIELD_ID' => $ID_USER_FIELD, 
                            'DEF' => 'N',
                            'SORT' => 100,
                            'XML_ID' => 'sv'
                        ),
                        'n1' => array( //ƒобавить новое значение
                            'VALUE' => GetMessage('UF_TYPE_tm'),
                            'USER_FIELD_ID' => $ID_USER_FIELD, 
                            'DEF' => 'N',
                            'SORT' => 200,
                            'XML_ID' => 'tm'
                        )
                    )
                );
            }
        }

    }

    $dbHblock = HL\HighloadBlockTable::getList( 
        array(
            "filter" => array("TABLE_NAME" => "backgrounddet")
        )
    );
    $br=$dbHblock->Fetch(); 
    if (!$br)
    {
        $data = array(
            'NAME' => 'BackgroundDet',
            'TABLE_NAME' => 'backgrounddet',
        );

        $result = HL\HighloadBlockTable::add($data);
        $ID = $result->getId();

        $_SESSION["YOUSTORE_HBLOCK_DBACK_ID"] = $ID;

        $hldata = HL\HighloadBlockTable::getById($ID)->fetch();
        $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

        //adding user fields
        $arUserFields = array (
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_NAME',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_NAME',
                'SORT' => '100',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FILE',
                'USER_TYPE_ID' => 'file',
                'XML_ID' => 'UF_DBACK_FILE',
                'SORT' => '200',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_LINK',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_LINK',
                'SORT' => '300',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_DESCR',
                'SORT' => '400',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FULL_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_FULL_DESCR',
                'SORT' => '500',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_SORT',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'UF_DBACK_SORT',
                'SORT' => '600',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_EXTERNAL_CODE',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_EXTERNAL_CODE',
                'SORT' => '700',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_XML_ID',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_DBACK_XML_ID',
                'SORT' => '800',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'Y',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            )
        );
        $arLanguages = Array();
        $rsLanguage = CLanguage::GetList($by, $order, array());
        while($arLanguage = $rsLanguage->Fetch())
            $arLanguages[] = $arLanguage["LID"];

        $obUserField  = new CUserTypeEntity;
        foreach ($arUserFields as $arFields)
        {
            $dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
            if ($dbRes->Fetch())
                continue;

            $arLabelNames = Array();
            foreach($arLanguages as $languageID)
            {
                WizardServices::IncludeServiceLang("references.php", $languageID);
                $arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
            }

            $arFields["EDIT_FORM_LABEL"] = $arLabelNames;
            $arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
            $arFields["LIST_FILTER_LABEL"] = $arLabelNames;

            $ID_USER_FIELD = $obUserField->Add($arFields);
        }
    }

    $dbHblock = HL\HighloadBlockTable::getList( 
        array(
            "filter" => array("TABLE_NAME" => "tab")
        )
    );
    $br=$dbHblock->Fetch(); 
    if (!$br)
    {
        $data = array(
            'NAME' => 'Tab',
            'TABLE_NAME' => 'tab',
        );

        $result = HL\HighloadBlockTable::add($data);
        $ID = $result->getId();

        $_SESSION["YOUSTORE_HBLOCK_TABS_ID"] = $ID;

        $hldata = HL\HighloadBlockTable::getById($ID)->fetch();
        $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

        //adding user fields
        $arUserFields = array (
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_NAME',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_TAB_NAME',
                'SORT' => '100',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FILE',
                'USER_TYPE_ID' => 'file',
                'XML_ID' => 'UF_TAB_FILE',
                'SORT' => '200',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_TAB_DESCR',
                'SORT' => '400',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_FULL_DESCRIPTION',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_TAB_FULL_DESCR',
                'SORT' => '500',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'Y',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_SORT',
                'USER_TYPE_ID' => 'double',
                'XML_ID' => 'UF_TAB_SORT',
                'SORT' => '600',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            ),
            array (
                'ENTITY_ID' => 'HLBLOCK_'.$ID,
                'FIELD_NAME' => 'UF_XML_ID',
                'USER_TYPE_ID' => 'string',
                'XML_ID' => 'UF_XML_ID',
                'SORT' => '800',
                'MULTIPLE' => 'N',
                'MANDATORY' => 'Y',
                'SHOW_FILTER' => 'N',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
            )
        );
        $arLanguages = Array();
        $rsLanguage = CLanguage::GetList($by, $order, array());
        while($arLanguage = $rsLanguage->Fetch())
            $arLanguages[] = $arLanguage["LID"];

        $obUserField  = new CUserTypeEntity;
        foreach ($arUserFields as $arFields)
        {
            $dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
            if ($dbRes->Fetch())
                continue;

            $arLabelNames = Array();
            foreach($arLanguages as $languageID)
            {
                WizardServices::IncludeServiceLang("references.php", $languageID);
                $arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
            }

            $arFields["EDIT_FORM_LABEL"] = $arLabelNames;
            $arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
            $arFields["LIST_FILTER_LABEL"] = $arLabelNames;

            $ID_USER_FIELD = $obUserField->Add($arFields);
        }
    }


?>
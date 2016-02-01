<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    if(!CModule::IncludeModule("iblock"))
        return;

    $iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/vakansii.xml";
    $iblockCode = "vakansii_".WIZARD_SITE_ID; 
    $iblockType = "content";

    $rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
    $iblockID = false; 
    if ($arIBlock = $rsIBlock->Fetch())
    {
        $iblockID = $arIBlock["ID"];
    }

    if($iblockID == false)
    {
        $iblockID = WizardServices::ImportIBlockFromXML(
            $iblockXMLFile, 
            'vakansii_'.WIZARD_SITE_ID, 
            $iblockType, 
            WIZARD_SITE_ID, 
            $permissions = Array(
                "1" => "X",
                "2" => "R",
                WIZARD_PORTAL_ADMINISTRATION_GROUP => "X",
                WIZARD_PERSONNEL_DEPARTMENT_GROUP => "W",
            )
        );

        if ($iblockID < 1)
            return;

        //IBlock fields settings
        $iblock = new CIBlock;
        $arFields = Array(
            "ACTIVE" => "Y",
            "FIELDS" => array (
                'CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'UNIQUE' => 'Y', 'TRANSLITERATION' => 'Y', 'TRANS_LEN' => 100, 'TRANS_CASE' => 'L', 'TRANS_SPACE' => '_', 'TRANS_OTHER' => '_', 'TRANS_EAT' => 'Y', 'USE_GOOGLE' => 'Y', ), ),
            ),   

            "CODE" => $iblockCode, 
            "XML_ID" => $iblockCode,
            //"NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME")
        );


        $iblock->Update($iblockID, $arFields);

    }
    else
    {
        $arSites = array(); 
        $db_res = CIBlock::GetSite($iblockID);
        while ($res = $db_res->Fetch())
            $arSites[] = $res["LID"]; 
        if (!in_array(WIZARD_SITE_ID, $arSites))
        {
            $arSites[] = WIZARD_SITE_ID; 
            $iblock = new CIBlock;
            $iblock->Update($iblockID, array("LID" => $arSites));
        }
    }
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("VACANCIES_IBLOCK_ID" => $iblockID));

?>
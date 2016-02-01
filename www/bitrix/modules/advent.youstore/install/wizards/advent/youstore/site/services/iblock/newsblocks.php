<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    if(!CModule::IncludeModule("iblock"))
        return;

    $iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/newsblocks.xml";
    $iblockCode = "newsblocks_".WIZARD_SITE_ID; 
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
            'newsblocks_'.WIZARD_SITE_ID, 
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
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."include/bottom-feed.php", Array("NEWS_BLOCKS_IBLOCK_ID" => $iblockID));
?>
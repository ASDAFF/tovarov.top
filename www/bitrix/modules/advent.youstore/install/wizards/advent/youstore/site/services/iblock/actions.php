<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock"))
    return;
    
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/actions.xml";
$iblockCode = "actions_".WIZARD_SITE_ID; 
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
        'actions_'.WIZARD_SITE_ID, 
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
$res = CIBlockProperty::GetByID("BG", $iblockID, false);
        if($ar_res = $res->GetNext()){
            $arFields1 = array(
                'USER_TYPE_SETTINGS' => array(
                    'size' => '1',
                    'width' => '0',
                    'group' => 'N',
                    'multiple' => 'N',
                    'TABLE_NAME' => 'background',
                ),
                'USER_TYPE' => 'directory'
            );
            $ibp = new CIBlockProperty();
            $ibp->Update($ar_res['ID'], $arFields1);
        }       
        
        $res = CIBlockProperty::GetByID("BG_DET", $iblockID, false);
        if($ar_res = $res->GetNext()){
            $arFields2 = array(
                'USER_TYPE_SETTINGS' => array(
                    'size' => '1',
                    'width' => '0',
                    'group' => 'N',
                    'multiple' => 'N',
                    'TABLE_NAME' => 'backgrounddet',
                ),
                'USER_TYPE' => 'directory'
            );
            $ibp = new CIBlockProperty();
            $ibp->Update($ar_res['ID'], $arFields2);
        }
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("ACTIONS_IBLOCK_ID" => $iblockID));

?>
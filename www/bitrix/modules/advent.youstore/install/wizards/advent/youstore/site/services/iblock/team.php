<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock"))
    return;
    
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/team.xml";
$iblockCode = "team_".WIZARD_SITE_ID; 
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
        'team_'.WIZARD_SITE_ID, 
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
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("TEAM_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("TEAM_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("TEAM_IBLOCK_ID" => $iblockID));

?>
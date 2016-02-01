<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock"))
    return;
    
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/props.xml";
$iblockCode = "props_".WIZARD_SITE_ID; 
$iblockType = "catalog";

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
        'props_'.WIZARD_SITE_ID, 
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
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("PROPS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("PROPS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("PROPS_IBLOCK_ID" => $iblockID));


$res = CIBlock::GetList(Array(), Array("=CODE"=>'catalog'), true);
while($ar_res = $res->Fetch())
{
    $catalogIblockId = $ar_res['ID'];
}
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/bitrix/templates/youstore_/components/bitrix/catalog/.default/bitrix/catalog.element/.default/template.php", 
    array(
        "ES_IBLOCK_GROUP_ID" => $iblockID,
        "ES_IBLOCK_CATALOG_ID" => $catalogIblockId
    )
);
?>
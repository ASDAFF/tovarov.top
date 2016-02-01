<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock"))
    return;
    
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/brands.xml";
$iblockCode = "brands_".WIZARD_SITE_ID; 
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
        'brands_'.WIZARD_SITE_ID, 
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
$_SESSION['YOUSTORE_BRAND_IBLOCKID']=$iblockID;
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("BRANDS_IBLOCK_ID" => $iblockID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("BRANDS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("BRANDS_IBLOCK_ID" => $iblockID));

?>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
	return;

function ___writeToAreasFile($path, $text)
{
	//if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
	//	@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($path, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($path, BX_FILE_PERMISSIONS);
}

if (COption::GetOptionString("main", "upload_dir") == "")
	COption::SetOptionString("main", "upload_dir", "upload");

if(COption::GetOptionString("youstore", "wizard_installed", "N", WIZARD_SITE_ID) == "N" || WIZARD_INSTALL_DEMO_DATA)
{
	if(file_exists(WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"))
	{
		CopyDirFiles(
			WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/",
			WIZARD_SITE_PATH,
			$rewrite = true,
			$recursive = true,
			$delete_after_copy = false
		);
	}
}

$wizard =& $this->GetWizard();
___writeToAreasFile(WIZARD_SITE_PATH."include/company_name.php", $wizard->GetVar("siteName"));
___writeToAreasFile(WIZARD_SITE_PATH."include/copyright.php", $wizard->GetVar("siteCopy"));
//___writeToAreasFile(WIZARD_SITE_PATH."include/schedule.php", $wizard->GetVar("siteSchedule"));
___writeToAreasFile(WIZARD_SITE_PATH."include/telephone.php", $wizard->GetVar("siteTelephone"));

/*if ($wizard->GetVar("templateID") != "youstore")
{
	$arSocNets = array("shopFacebook" => "facebook", "shopTwitter" => "twitter", "shopVk" => "vk", "shopGooglePlus" => "google");
	foreach($arSocNets as $socNet=>$includeFile)
	{
		$curSocnet = $wizard->GetVar($socNet);
		if ($curSocnet)
		{
			$text = '<a href="'.$curSocnet.'"></a>';
			___writeToAreasFile(WIZARD_SITE_PATH."include/socnet_".$includeFile.".php", $text);
		}
	}
}
*/

if(COption::GetOptionString("youstore", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
	return;

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."urlrewrite.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
//siteid
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."ajax/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."include/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."sales/", Array("SITE_ID" => WIZARD_SITE_ID));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".actions.menu.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".catalog.menu_ext.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".dop.menu.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".top.menu.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."404.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_breadcrumbs-photo.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sect_footer_text.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."sitemap.php", Array("SITE_ID" => WIZARD_SITE_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."urlrewrite.php", Array("SITE_ID" => WIZARD_SITE_ID));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.".section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));
copy(WIZARD_THEME_ABSOLUTE_PATH."favicon.ico", WIZARD_SITE_PATH."favicon.ico");

$arUrlRewrite = array(); 
if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
}

$arNewUrlRewrite = array(
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."about/obzor/(.*)/(.*)#",
        "RULE" => "CODE=\$1",
        "ID" => "",
        "PATH" => WIZARD_SITE_DIR."about/obzor/detail.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."about/jobs/(.*)/(.*)#",
        "RULE" => "CODE=\$1",
        "ID" => "",
        "PATH" => WIZARD_SITE_DIR."about/jobs/detail.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."brands/(.*)/(.*)#",
        "RULE" => "CODE=\$1",
        "ID" => "",
        "PATH" => WIZARD_SITE_DIR."brands/detail.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."about/actions/#",
        "RULE" => "",
        "ID" => "bitrix:news",
        "PATH" => WIZARD_SITE_DIR."about/actions/index.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."news/(.*)/(.*)#",
        "RULE" => "CODE=\$1",
        "ID" => "",
        "PATH" => WIZARD_SITE_DIR."news/detail.php",
    ),
    array(
        "CONDITION" => "#^".WIZARD_SITE_DIR."catalog/#",
        "RULE" => "",
        "ID" => "bitrix:catalog",
        "PATH" => WIZARD_SITE_DIR."catalog/index.php",
    ),
);

foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
	{
		CUrlRewriter::Add($arUrl);
	}
}
?>
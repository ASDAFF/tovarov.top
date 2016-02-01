<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!CModule::IncludeModule("highloadblock"))
	return;

if (!WIZARD_INSTALL_DEMO_DATA)
	return;
WizardServices::IncludeServiceLang("references.php", LANGUAGE_ID);

use Bitrix\Highloadblock as HL;
global $USER_FIELD_MANAGER;

$COLOR_ID = $_SESSION["YOUSTORE_HBLOCK_COLOR_ID"];
unset($_SESSION["YOUSTORE_HBLOCK_COLOR_ID"]);
if ($COLOR_ID)
{
	$hldata = HL\HighloadBlockTable::getById($COLOR_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	$entity_data_class = $hlentity->getDataClass();
	$arColors = array(
		"red",
		"black",
		"green",
		"cyan",
		"MPisaU0L",
		"yellow",
		
	);
	$sort = 0;
	foreach($arColors as $colorName)
	{
		$sort+= 100;
		$arData = array(
			'UF_NAME' => GetMessage("WZD_REF_COLOR_".ToUpper($colorName)),
            'UF_FILE' =>
                array (
                    'name' => ($colorName).".jpg",
                    'type' => 'image/jpg',
                    'tmp_name' => WIZARD_ABSOLUTE_PATH."/site/services/iblock/colors/".$colorName.'.jpg'
                ),
			'UF_SORT' => $sort,
			'UF_DEF' => ($sort > 100) ? "0" : "1",
			'UF_XML_ID' => ($colorName),
            'UF_DARK_COLOR'=> ($colorName == 'yellow') ? "0" : "1",
		);
		$USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$COLOR_ID, $arData);
		$USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$COLOR_ID, null, $arData);

		$result = $entity_data_class::add($arData);
	}
} 

$BACK_ID = $_SESSION["YOUSTORE_HBLOCK_BACK_ID"];
unset($_SESSION["YOUSTORE_HBLOCK_BACK_ID"]);
if ($BACK_ID)
{
    $hldata = HL\HighloadBlockTable::getById($BACK_ID)->fetch();
    $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

    $entity_data_class = $hlentity->getDataClass();
    $sort = 0;
    for($b=1; $b<=10; $b++)
    {
        $sort+= 100;
        $arData = array(
            'UF_NAME' => GetMessage('WZD_REF_BACK').$b,
            'UF_FILE' =>
                array (
                    'name' => ($b).".png",
                    'type' => 'image/png',
                    'tmp_name' => WIZARD_ABSOLUTE_PATH."/site/services/iblock/backs/".$b.'.png'
                ),
            'UF_SORT' => $sort,
            'UF_DESCRIPTION' => '',
            'UF_FULL_DESCRIPTION' => '',
            'UF_XML_ID' => 'fon_'.$b,
            'UF_TYPE' => $b==10?'tm':$b==7?'sv':''
        );
        $USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$BACK_ID, $arData);
        $USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$BACK_ID, null, $arData);

        $result = $entity_data_class::add($arData);
    }
}


$DBACK_ID = $_SESSION["YOUSTORE_HBLOCK_DBACK_ID"];
unset($_SESSION["YOUSTORE_HBLOCK_DBACK_ID"]);
if ($DBACK_ID)
{
    $hldata = HL\HighloadBlockTable::getById($DBACK_ID)->fetch();
    $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

    $entity_data_class = $hlentity->getDataClass();
    $sort = 0;
    for($b=1; $b<=10; $b++)
    {
        $sort+= 10;
        $arData = array(
            'UF_NAME' => GetMessage('WZD_REF_BACK').$b,
             'UF_SORT' => $sort,
            'UF_DESCRIPTION' => '',
            'UF_FULL_DESCRIPTION' => '',
            'UF_XML_ID' => 'fon_'.$b,
           
        );
        $USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$DBACK_ID, $arData);
        $USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$DBACK_ID, null, $arData);

        $result = $entity_data_class::add($arData);
    }
}

$TABS_ID = $_SESSION["YOUSTORE_HBLOCK_TABS_ID"];
unset($_SESSION["YOUSTORE_HBLOCK_TABS_ID"]);
if ($TABS_ID)
{
    $hldata = HL\HighloadBlockTable::getById($TABS_ID)->fetch();
    $hlentity = HL\HighloadBlockTable::compileEntity($hldata);

    $entity_data_class = $hlentity->getDataClass();
    $arTabs = array(
        "appirance",
        "monitor",
        "nachinka",
        "photo",
        "review",
        "tovar",
        
    );
    $sort = 0;
    foreach($arTabs as $tabName)
    {
        $sort+= 100;
        $arData = array(
            'UF_NAME' => GetMessage("WZD_REF_TABS_".($tabName)),
            'UF_SORT' => $sort,
            'UF_FILE' =>
                array (
                    'name' => ($tabName).".png",
                    'type' => 'image/png',
                    'tmp_name' => WIZARD_ABSOLUTE_PATH."/site/services/iblock/tabs/".$tabName.'.png'
                ),
            'UF_XML_ID' => ($tabName),
         );
        $USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$TABS_ID, $arData);
        $USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$TABS_ID, null, $arData);

        $result = $entity_data_class::add($arData);
    }
}




?>
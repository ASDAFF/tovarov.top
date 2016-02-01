<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(strlen($_REQUEST['send_account_info']) && strlen($_REQUEST['USER_EMAIL'])){
	$cUser = new CUser; 
	$sort_by = "ID";
	$sort_ord = "ASC";
	$arFilter = array("ACTIVE" => "Y", "EMAIL" => $_REQUEST['USER_EMAIL']);
	$dbUsers = $cUser->GetList($sort_by, $sort_ord, $arFilter);
	while ($arUser = $dbUsers->Fetch()) 
	{
		$arResult['id_user'] = $arUser["ID"];
	}

	if(intval($arResult['id_user'])<=0){
		$arResult['EMAIL_WRANG'] = 'Y';
	}
	$arResult['REQUEST_EMAIL'] = $_REQUEST['USER_EMAIL'];
}
?>
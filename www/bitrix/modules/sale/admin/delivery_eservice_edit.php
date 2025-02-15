<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Delivery\ExtraServices;

Loc::loadMessages(__FILE__);
Bitrix\Main\Loader::includeModule('sale');

/** @var  CMain $APPLICATION */
$saleModulePermissions = $APPLICATION->GetGroupRight("sale");

if ($saleModulePermissions < "W")
	$APPLICATION->AuthForm(Loc::getMessage("SALE_DSE_ACCESS_DENIED"));

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/prolog.php");

$ID = isset($_REQUEST["ID"]) ? intval($_REQUEST["ID"]) : 0;
$strError = "";
$fields = array();
$tabControlName = "tabControl";
$isItSavingProcess = ($_SERVER['REQUEST_METHOD'] == "POST" && (strlen($_POST["save"]) > 0 || strlen($_POST["apply"]) > 0)) ? true : false;
$isFormReloading = $_SERVER['REQUEST_METHOD'] == "POST" && !$isItSavingProcess;

if($saleModulePermissions == "W" && check_bitrix_sessid())
{
	if ($isItSavingProcess || $isFormReloading)
	{
		if(isset($_POST["ID"]))				$fields["ID"] = intval($_POST["ID"]);
		if(isset($_POST["CODE"]))			$fields["CODE"] = trim($_POST["CODE"]);
		if(isset($_POST["NAME"]))			$fields["NAME"] = trim($_POST["NAME"]);
		if(isset($_POST["SORT"]))			$fields["SORT"] = $_POST["SORT"];
		if(isset($_POST["ACTIVE"]))			$fields["ACTIVE"] = trim($_POST["ACTIVE"]);
		if(isset($_POST["INIT_VALUE"]))		$fields["INIT_VALUE"] = trim($_POST["INIT_VALUE"]);
		if(isset($_POST["CLASS_NAME"]))		$fields["CLASS_NAME"] = trim($_POST["CLASS_NAME"]);
		if(isset($_POST["DESCRIPTION"]))	$fields["DESCRIPTION"] = trim($_POST["DESCRIPTION"]);
		if(isset($_POST["DELIVERY_ID"]))	$fields["DELIVERY_ID"] = intval($_POST["DELIVERY_ID"]);
		if(isset($_POST["PARAMS"], $_POST["PARAMS"]["PARAMS"]))	$fields["PARAMS"] = $_POST["PARAMS"]["PARAMS"];

		if(isset($_POST["RIGHTS"]))
			$fields["RIGHTS"] = $_POST["RIGHTS"];
		else
			$fields["RIGHTS"] = array("Y", "N", "N");

		if($isItSavingProcess)
		{
			if($fields["DELIVERY_ID"] > 0)
			{
				$fields = ExtraServices\Manager::prepareParamsToSave($fields);

				if($ID > 0)
					$res = ExtraServices\Table::update($ID, $fields);
				else
					$res = ExtraServices\Table::add($fields);

				if(!$res->isSuccess())
					$strError .= Loc::getMessage("SALE_ESDE_ERROR_SAVE").": ".implode("<br>",$res-> getErrorMessages());
				elseif($ID <= 0)
					$ID = $res->getId();
			}
			else
			{
				$strError .= Loc::getMessage("SALE_ESDE_ERROR_ID").'.<br>\n';
			}

			if(strlen($strError) <= 0)
			{
				if (strlen($_POST["apply"]) > 0)
					LocalRedirect($APPLICATION->GetCurPageParam("ID=".$ID, array('ID')));
				elseif(strlen($_POST["save"]) > 0)
					LocalRedirect((isset($_REQUEST["back_url"]) ? $_REQUEST["back_url"] : "sale_delivery_service_edit.php?lang=".LANG."&ID=".$fields["DELIVERY_ID"]));
			}
		}
	}
}

if($ID > 0)
{
	$res = ExtraServices\Table::getById($ID);
	$fields = $res->fetch();
}

if(isset($fields["DELIVERY_ID"]))
	$DELIVERY_ID = $fields["DELIVERY_ID"];
elseif(isset($_REQUEST["DELIVERY_ID"]))
	$DELIVERY_ID = $_REQUEST["DELIVERY_ID"];
else
	$DELIVERY_ID = 0;

$DELIVERY_ID = intval($DELIVERY_ID);

if($DELIVERY_ID <= 0)
	$strError .= Loc::getMessage("SALE_ESDE_ERROR_ID");

$currencyLang = "";
$deliveryService = null;

if($DELIVERY_ID > 0)
{
	$deliveryService = \Bitrix\Sale\Delivery\Services\Manager::getService($DELIVERY_ID);

	if($deliveryService && \Bitrix\Main\Loader::includeModule('currency'))
	{
		$curFormat = \CCurrencyLang::getCurrencyFormat($deliveryService->getCurrency());
		$currencyLang = trim(str_replace("#", '', $curFormat["FORMAT_STRING"]));
	}
	else
	{
		$currencyLang = $deliveryService->getCurrency();
	}
}

if($deliveryService && $ID <= 0 && isset($_GET["ES_CODE"]) && strlen($_GET["ES_CODE"]) > 0)
{
	$embeddedList = $deliveryService->getEmbeddedExtraServicesList();

	if(isset($embeddedList[$_GET["ES_CODE"]]))
	{
		$fields = $embeddedList[$_GET["ES_CODE"]];
		$fields["CODE"] = $_GET["ES_CODE"];
		$fields["ID"] = strval(mktime());
	}
}

$aTabs = array(
	array(
		"DIV" => "edit_main",
		"TAB" => Loc::getMessage("SALE_ESDE_TAB_GENERAL"),
		"ICON" => "sale",
		"TITLE" => Loc::getMessage("SALE_ESDE_TAB_GENERAL_TITLE")
	)
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);
$APPLICATION->SetTitle(Loc::getMessage("SALE_ESDE_PAGE_TITLE").($ID > 0 ? " ID: ".$ID : ""));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

\Bitrix\Sale\Internals\Input\Manager::initJs();

$aMenu = array(
	array(
		"TEXT" => GetMessage("SALE_ESDE_TO_LIST"),
		"LINK" => isset($_GET["back_url"]) ? $_GET["back_url"] : "/bitrix/admin/sale_delivery_service_list.php?lang=".LANGUAGE_ID."&ID=".$DELIVERY_ID,
		"ICON" => "btn_list"
	)
);

if ($ID > 0 && $saleModulePermissions >= "W")
{
	$aMenu[] = array("SEPARATOR" => "Y");

	$aMenu[] = array(
		"TEXT" => Loc::getMessage("SALE_ESDE_CREATE_NEW"),
		"LINK" => "/bitrix/admin/sale_delivery_eservice_edit.php?lang=".LANGUAGE_ID."&DELIVERY_ID=".$DELIVERY_ID.(isset($_REQUEST["back_url"]) ? "&back_url=".urlencode($_REQUEST["back_url"]) : ""),
		"ICON" => "btn_new"
	);

	if(!isset($fields["RIGHTS"]["ADMIN"]) || $fields["RIGHTS"]["ADMIN"] == "Y")
	{
		$aMenu[] = array(
			"TEXT" => Loc::getMessage("SALE_ESDE_DELETE_ITEM"),
			"LINK" => "javascript:if(confirm('".Loc::getMessage("SALE_ESDE_CONFIRM_DEL_MESSAGE")."')) window.location='".
				"sale_delivery_service_edit.php?lang=".LANG."&ID=".$DELIVERY_ID."&action=delete_extra_service".
				"&ES_ID=".$ID."&".bitrix_sessid_get()."'",
			"ICON" => "btn_delete"
		);
	}
}

$context = new CAdminContextMenu($aMenu);
$context->Show();

if(strlen($strError) > 0)
	CAdminMessage::ShowMessage(Array("DETAILS"=>$strError, "TYPE"=>"ERROR", "MESSAGE"=>Loc::getMessage("SALE_DSE_ERROR"), "HTML"=>true));

?>
<form method="POST" action="<?=$APPLICATION->GetCurPageParam()?>" name="form1" enctype="multipart/form-data">
<input type="hidden" name="lang" value="<?=LANGUAGE_ID;?>">
<input type="hidden" name="ID" value="<?=$ID?>">
<input type="hidden" name="DELIVERY_ID" value="<?=$DELIVERY_ID?>">
<?=bitrix_sessid_post()?>

<?
$tabControl->Begin();
/* General settings */
$tabControl->BeginNextTab();
$manager = new ExtraServices\Manager(array($fields), $deliveryService->getCurrency());
?>
<tr class="adm-detail-required-field">
	<td width="40%"><?=Loc::getMessage("SALE_ESDE_FIELD_TYPE")?>:</td>
	<td width="60%">
		<?if(!isset($fields["RIGHTS"]["ADMIN"]) || $fields["RIGHTS"]["ADMIN"] == "Y" || $ID <= 0):?>
			<select name="CLASS_NAME" onchange="top.BX.showWait(); this.form.submit(); /* elements.apply.click();*/">
				<option value=""></option>
				<?foreach(ExtraServices\Manager::getClassesList() as $class):?>
					<option value="<?=$class?>"<?=($fields["CLASS_NAME"] == $class ? " selected" : "")?>><?=$class::getClassTitle()?></option>
				<?endforeach;?>
			</select>
		<?else:?>
			<input type="text" name="CLASS_NAME_DISABLED" value="<?=$fields["CLASS_NAME"]::getClassTitle()?>" readonly>
			<input type="hidden" name="CLASS_NAME" value="<?=$fields["CLASS_NAME"]?>">
		<?endif;?>
	</td>
</tr>

	<tr class="adm-detail-required-field">
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_NAME")?>:</td>
		<td>
			<input type="text" name="NAME" value="<?=htmlspecialcharsbx($fields["NAME"])?>">
		</td>
	</tr>

	<tr>
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_DESCRIPTION")?>:</td>
		<td>
			<textarea name="DESCRIPTION"><?=htmlspecialcharsbx($fields["DESCRIPTION"])?></textarea>
		</td>
	</tr>

	<tr>
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_RIGHTS")?>:</td>
		<td>
			<?=Loc::getMessage("SALE_ESDE_FIELD_MANAGER")?>: <input type="checkbox" name="RIGHTS[<?=ExtraServices\Manager::RIGHTS_MANAGER_IDX?>]" value="Y"<?=(isset($fields["RIGHTS"][ExtraServices\Manager::RIGHTS_MANAGER_IDX]) &&  $fields["RIGHTS"][ExtraServices\Manager::RIGHTS_MANAGER_IDX] == "Y" ? " checked" : "")?>>&nbsp;&nbsp;
			<?=Loc::getMessage("SALE_ESDE_FIELD_CLIENT")?>: <input type="checkbox" name="RIGHTS[<?=ExtraServices\Manager::RIGHTS_CLIENT_IDX?>]" value="Y"<?=(isset($fields["RIGHTS"][ExtraServices\Manager::RIGHTS_CLIENT_IDX]) && $fields["RIGHTS"][ExtraServices\Manager::RIGHTS_CLIENT_IDX] == "Y" ? " checked" : "")?>>
		</td>
	</tr>

	<?if(isset($fields["CLASS_NAME"]) && strlen($fields["CLASS_NAME"]) > 0):?>
		<tr>
			<td><?=(is_callable($fields["CLASS_NAME"].'::getAdminParamsName') ? htmlspecialcharsbx($fields["CLASS_NAME"]::getAdminParamsName()) : Loc::getMessage("SALE_ESDE_FIELD_PARAMS"))?>:</td>
			<td>
				<?=$fields["CLASS_NAME"]::getAdminParamsControl("PARAMS", $fields, $currencyLang);?>
			</td>
		</tr>

		<?if($ID > 0):?>
			<tr>
				<td><?=Loc::getMessage("SALE_ESDE_FIELD_INITIAL")?>:</td>
				<td>
						<?=$manager->getItem($ID)->getAdminDefaultControl("INIT_VALUE", isset($fields["INIT_VALUE"]) ? $fields["INIT_VALUE"] : null);?>
				</td>
			</tr>
		<?endif;?>
	<?endif;?>

	<tr>
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_ACTIVE")?>:</td>
		<td>
			<input type="checkbox" name="ACTIVE" value="Y"<?=(isset($fields["ACTIVE"]) && $fields["ACTIVE"] == "Y" ? " checked" : "")?>>
		</td>
	</tr>

	<tr>
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_SORT")?>:</td>
		<td>
			<input type="text" name="SORT" value="<?=(isset($fields["SORT"]) ? $fields["SORT"] : "100")?>">
		</td>
	</tr>

	<tr>
		<td><?=Loc::getMessage("SALE_ESDE_FIELD_CODE")?>:</td>
		<td>
			<input type="text" name="CODE" value="<?=(isset($fields["CODE"]) ? $fields["CODE"] : "")?>">
		</td>
	</tr>
<?
$tabControl->Buttons(
	array(
		"disabled" => ($saleModulePermissions < "W"),
		"back_url" => isset($_REQUEST["back_url"]) ? $_REQUEST["back_url"] : ("/bitrix/admin/sale_delivery_service_edit.php?lang=".LANGUAGE_ID.'&ID='.(isset($_REQUEST["DELIVERY_ID"]) ? $_REQUEST["DELIVERY_ID"] :0))
	)
);

$tabControl->End();
?>
</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
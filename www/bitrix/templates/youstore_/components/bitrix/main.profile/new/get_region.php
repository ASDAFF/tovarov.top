<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
IncludeTemplateLangFile(__FILE__);
if( empty($_REQUEST['country_id']) ){
    die();
}
CModule::IncludeModule("sale");
$arrFilter=array("LID" => LANGUAGE_ID);
$arrFilter["COUNTRY_ID"]=$_REQUEST['country_id'];

$db_vars = CSaleLocation::GetList(Array("REGION_NAME"=>"ASC"), $arrFilter);
$arrRegion=array();

				while ($vars = $db_vars->Fetch()):
					if(in_array($vars["REGION_ID"], $arrRegion)) continue;
					if($vars["REGION_NAME"]=="") continue;
					if( count($arrRegion)==0) echo '<option value="">'.GetMessage('CHOOSE_REGION').'</option>';
					$arrRegion[]=$vars["REGION_ID"];
				  ?>
				  <option value="<?=$vars["REGION_ID"]?>"><?=$vars["REGION_NAME"]?></option>
				  <?
			   endwhile;
?>

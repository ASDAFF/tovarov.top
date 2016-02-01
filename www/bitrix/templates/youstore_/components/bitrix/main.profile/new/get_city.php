<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
IncludeTemplateLangFile(__FILE__);
if( empty($_REQUEST['country_id']) && empty($_REQUEST['region_id']) ){
    //die();
}
CModule::IncludeModule("sale");
$arrFilter=array("LID" => LANGUAGE_ID);
if($_REQUEST['country_id']) $arrFilter["COUNTRY_ID"]=$_REQUEST['country_id'];
if($_REQUEST['region_id']) $arrFilter["REGION_ID"]=$_REQUEST['region_id'];

$db_vars = CSaleLocation::GetList(Array("CITY_NAME_LANG"=>"ASC"), $arrFilter);
?>
<option value=""><?=GetMessage('CHOOSE_CITY')?></option>
<?
				while ($vars = $db_vars->Fetch()):
					if($vars["CITY_NAME"]=="") continue;
					//if( intval($_REQUEST['region_id'])>0 && $vars["REGION_ID"]!=$_REQUEST['region_id'] )continue;
				  ?>
				  <option  value="<?=$vars["ID"]?>"><?=$vars["CITY_NAME"]?></option>
				  <?
			   endwhile;
?>

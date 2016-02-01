<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"]) && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
    {
		//site_log("REQUEST");
		//site_log(print_r($_REQUEST, true));
		//site_log(print_r($_FILES["AVATAR"], true));
		if(empty($_FILES["AVATAR"]) || empty($_FILES["AVATAR"]["tmp_name"])){
			$_FILES["AVATAR"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$_REQUEST["SERVER_AVATAR"]);
		}
    }
?>
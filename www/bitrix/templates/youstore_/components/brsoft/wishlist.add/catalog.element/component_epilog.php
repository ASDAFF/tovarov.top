<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
if(isset($templateData["JS_OBJ_ID"])){
	?>
	<script>
		BX.ready(
			BX.defer(function(){
				if (!!window.<?=$templateData["JS_OBJ_ID"];?>)
				{
					window.<?=$templateData["JS_OBJ_ID"];?>.bindEvents();
				}
			})
		);
	</script>
	<?
}
?>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$arAuthServices = $arPost = array();
if(is_array($arParams["~AUTH_SERVICES"]))
{
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if(is_array($arParams["~POST"]))
{
	$arPost = $arParams["~POST"];
}
?>

<?if(($arParams["~CURRENT_SERVICE"] <> '') && $arParams["~FOR_SPLIT"] != 'Y'):?>
<script type="text/javascript">
	BX.ready(function(){BxShowAuthService('<?=CUtil::JSEscape($arParams["~CURRENT_SERVICE"])?>', '<?=$arParams["~SUFFIX"]?>')});
</script>
<?endif?>
<?
if(!function_exists("prepareService")){
	function prepareService($html, $class){
		$matches = array();
		preg_match('/\<a(.*)\/a\>/i', $html, &$matches);
		$a = "<a ".$matches[1]."/a>";
		//$a = preg_replace('/class\\s*=\\s*["\'](.*)["\']/', "class='".$class."'", $a);
		return "<li class='$class'>".$a."</li>";
		
		return $html;
	}
}
?>
<div class="popup-socials">
	<form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">
		<p><?=GetMessage("socserv_as_user_note")?></p>
		<?if($arParams["~FOR_SPLIT"] != 'Y'):?>
			<ul class="socials-list">
				<?foreach($arAuthServices as $service):?>
					<?/*<li class="<?=strtolower($service["ID"])?>"><a href="javascript:void(0)" onclick="BxShowAuthService('<?=$service["ID"]?>', '<?=$arParams["SUFFIX"]?>')" id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>"><i class="bx-ss-icon <?=htmlspecialcharsbx($service["ICON"])?>"></i><b><?=htmlspecialcharsbx($service["NAME"])?></b></a></li>*/?>
					<?if(($arParams["~FOR_SPLIT"] != 'Y') || (!is_array($service["FORM_HTML"]))):?>	
						<?
							$class = strtolower($service["ID"]);						
						?>
						<?print_r(prepareService($service["FORM_HTML"], $class))?>
					<?endif;?>
				<?endforeach?>
			</ul>
		<?endif;?>
		<div class="bx-auth-service-form" id="bx_auth_serv<?=$arParams["SUFFIX"]?>" style="display:none">
			<?foreach($arAuthServices as $service):?>
				<?if(($arParams["~FOR_SPLIT"] != 'Y') || (!is_array($service["FORM_HTML"]))):?>
					<div id="bx_auth_serv_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>" style="display:none"><?=$service["FORM_HTML"]?></div>
				<?endif;?>
			<?endforeach?>
		</div>
		<?foreach($arPost as $key => $value):?>
			<?if(!preg_match("|OPENID_IDENTITY|", $key)):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endif;?>
		<?endforeach?>
		<input type="hidden" name="auth_service_id" value="" />
	</form>
</div>
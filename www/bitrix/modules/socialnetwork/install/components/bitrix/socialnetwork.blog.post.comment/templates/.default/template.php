<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 */
CJSCore::Init(array("tooltip", "popup", "fx", "viewer"));

if(!empty($arResult["FATAL_MESSAGE"]))
{
	?><div class="feed-add-error">
		<span class="feed-add-info-text"><span class="feed-add-info-icon"></span><?=$arResult["FATAL_MESSAGE"]?></span>
	</div><?
}
else if($arResult["imageUploadFrame"] == "Y")
{
?>
<script type="text/javascript">
	<?if(!empty($arResult["Image"])):?>
	if(!top.arImagesId) { top.arImagesId = []; }
	if(!top.arImagesSrc) { top.arImagesSrc = []; }
	top.arImagesId.push('<?=$arResult["Image"]["ID"]?>');
	top.arImagesSrc.push('<?=CUtil::JSEscape($arResult["Image"]["SRC"])?>');
	top.bxBlogImageId = '<?=$arResult["Image"]["ID"]?>';
	top.bxBlogImageIdWidth = '<?=CUtil::JSEscape($arResult["Image"]["WIDTH"])?>';
	top.bxBlogImageIdSrc = '<?=CUtil::JSEscape($arResult["Image"]["SRC"])?>';
	<?elseif(strlen($arResult["ERROR_MESSAGE"]) > 0):?>
	top.bxBlogImageError = '<?=CUtil::JSEscape($arResult["ERROR_MESSAGE"])?>';
	<?endif;?>
</script>
<?
die();
}

$rights = "N";
if (
	CSocNetUser::IsCurrentUserModuleAdmin() 
	||$APPLICATION->GetGroupRight("blog") >= "W"
)
{
	$rights = "ALL";
}
else if (
	IsModuleInstalled("intranet") 
	&& $USER->IsAuthorized()
)
{
	$rights = "OWN";
}
else if (!IsModuleInstalled("intranet"))
{
	$rights = ($arResult["Perm"] < BLOG_PERMS_FULL ? "OWNLAST" : "ALL");
}
$eventHandlerID = AddEventHandler('main', 'system.field.view.file', Array('CBlogTools', 'blogUFfileShow'));
$arResult["OUTPUT_LIST"] = $APPLICATION->IncludeComponent(
	"bitrix:main.post.list",
	"",
	array(
		"TEMPLATE_ID" => 'BLOG_COMMENT_BG_',
		"RATING_TYPE_ID" => ($arParams["SHOW_RATING"] == "Y" ? "BLOG_COMMENT" : ""),
		"ENTITY_XML_ID" => $arParams["ENTITY_XML_ID"],
		"RECORDS" => $arResult["RECORDS"],
		"NAV_STRING" => $arResult["NAV_STRING"],
		"NAV_RESULT" => $arResult["NAV_RESULT"],
		"PREORDER" => "N",
		"RIGHTS" => array(
			"MODERATE" => ($arResult["Perm"] >= BLOG_PERMS_MODERATE ? "Y" : "N"),
			"EDIT" => $rights,
			"DELETE" => $rights
		),
		"VISIBLE_RECORDS_COUNT" => $arResult["newCount"],

		"ERROR_MESSAGE" => ($arResult["ERROR_MESSAGE"] ?: $arResult["COMMENT_ERROR"]),
		"OK_MESSAGE" => $arResult["MESSAGE"],
		"RESULT" => ($arResult["ajax_comment"] ?: $_GET["commentId"]),
		"PUSH&PULL" => $arResult["PUSH&PULL"],
		"VIEW_URL" => str_replace(array("##comment_id#", "#comment_id#"), array("", "#ID#"), $arResult["commentUrl"]),
		"EDIT_URL" => "__blogEditComment('#ID#', '".$arParams["ID"]."');",
		"MODERATE_URL" => str_replace(
			array("#source_post_id#", "#post_id#", "#comment_id#", "&".bitrix_sessid_get(), "hide_comment_id="),
			array($arParams["ID"], $arParams["ID"], "#ID#", "", "#action#_comment_id="),
			$arResult["urlToHide"]
		),
		"DELETE_URL" => str_replace(
			array("#source_post_id#", "#post_id#", "#comment_id#", "&".bitrix_sessid_get()),
			array($arParams["ID"], $arParams["ID"], "#ID#", ""),
			$arResult["urlToDelete"]
		),
		"AUTHOR_URL" => $arParams["PATH_TO_USER"],

		"AVATAR_SIZE" => $arParams["AVATAR_SIZE_COMMENT"],
		"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
		"SHOW_LOGIN" => $arParams['SHOW_LOGIN'],

		"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
		"LAZYLOAD" => $arParams["LAZYLOAD"],

		"NOTIFY_TAG" => ($arParams["bFromList"] ? "BLOG|COMMENT" : ""),
		"NOTIFY_TEXT" => ($arParams["bFromList"] ? TruncateText(str_replace(Array("\r\n", "\n"), " ", $arParams["POST_DATA"]["~TITLE"]), 100) : ""),
		"SHOW_MINIMIZED" => "Y",
		"SHOW_POST_FORM" => ($arResult["CanUserComment"] ? "Y" : "N"),

		"IMAGE_SIZE" => $arParams["IMAGE_SIZE"],
		"mfi" => $arParams["mfi"]
	),
	$this->__component
);
if ($eventHandlerID > 0 )
	RemoveEventHandler('main', 'system.field.view.file', $eventHandlerID);

?><div class="feed-comments-block" id="blg-comment-<?=$arParams["ID"]?>"<?if(empty($arResult["CommentsResult"])){ ?> style="display:none;"<? }?>><?
	?><a name="comments"></a><?
	?><?=$arResult["OUTPUT_LIST"]["HTML"]?><?
?></div><?
?><script>
BX.ready(function() {
	BX.bind(BX("blg-post-img-<?=$arResult["Post"]["ID"]?>"), "mouseup", function(e){ checkForQuote(e, this, '<?=$arParams["ENTITY_XML_ID"]?>', 'bp_<?=$arResult["Post"]["ID"]?>')});
	BX.addCustomEvent(window, 'OnUCAfterRecordAdd', function(ENTITY_XML_ID, response) {
		if (ENTITY_XML_ID == '<?=$arParams["ENTITY_XML_ID"]?>')
		{
			__blogOnUCAfterRecordAdd(ENTITY_XML_ID, response);
		}
	});

} );
</script>
<?

if ($GLOBALS["USER"]->IsAuthorized() && CModule::IncludeModule("pull") && CPullOptions::GetNginxStatus()) { ?>
<script type="text/javascript">
BX.addCustomEvent("onPullEvent-unicomments", function(command, params) { if (params["ENTITY_XML_ID"] == '<?=$arParams["ENTITY_XML_ID"]?>') { BX.show(BX('blg-comment-<?=$arParams["ID"]?>')); } } );
</script>
<? }
if ($arResult["CanUserComment"])
{
	?>
	<script>
		BX.viewElementBind(
			'blg-comment-<?=$arParams["ID"]?>',
			{},
			function(node){
				return BX.type.isElementNode(node) && (node.getAttribute('data-bx-viewer') || node.getAttribute('data-bx-image'));
			}
		);
		top.postFollow<?=$arParams["ID"]?> = postFollow<?=$arParams["ID"]?> = '<?=$arParams["FOLLOW"]?>';
	</script>
	<?
	if ( empty($_REQUEST["bxajaxid"]) && empty($_REQUEST["logajax"]) ||
		($_REQUEST["RELOAD"] == "Y" && !(empty($_REQUEST["bxajaxid"]) && empty($_REQUEST["logajax"])) )
	)
	{
		include_once(__DIR__."/script.php");
	}
	__sbpc_bind_post_to_form($arParams["ENTITY_XML_ID"], null, $arParams);
}
?>
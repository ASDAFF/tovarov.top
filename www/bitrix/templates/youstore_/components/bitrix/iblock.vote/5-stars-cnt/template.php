<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$arParams["DISPLAY_AS_RATING"] = "vote_avg";

if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
{
	if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
		$votesValue = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
	else
		$votesValue = 0;
}
else
	$votesValue = intval($arResult["PROPERTIES"]["rating"]["VALUE"]);

$votesCount = intval($arResult["PROPERTIES"]["vote_count"]["VALUE"]);

if(isset($arParams["AJAX_CALL"]) && $arParams["AJAX_CALL"]=="Y")
{
	$APPLICATION->RestartBuffer();

	die(json_encode( array(
		"value" => $votesValue,
		"votes" => $votesCount,
		"show_vc" => $arParams["SHOW_VOTE_COUNT"] == "Y"
		)
	));
}

CJSCore::Init(array("ajax"));
$strObName = "bx_vo_".$arParams["IBLOCK_ID"]."_".$arParams["ELEMENT_ID"].'_'.mt_rand(100, 10000);
$arJSParams = array(
	"progressId" => $strObName."_progr",
	"ratingId" => $strObName."_rating",
	"starsId" => $strObName."_stars",
	"ajaxUrl" => $componentPath."/component.php",
	"voteId" => $arResult["ID"],
	"voteSum" => $arResult["PROPERTIES"]["vote_sum"]["VALUE"],
	"voteCount" => $arResult["PROPERTIES"]["vote_count"]["VALUE"],
	"voteRating" => $arResult["PROPERTIES"]["rating"]["VALUE"],
	"voteValue" => $votesValue, 
	"paramsShowRatingAs" => $arParams["DISPLAY_AS_RATING"]
);
$templateData = array(
	'JS_OBJ' => $strObName,
	'ELEMENT_ID' => $arParams["ELEMENT_ID"]
);
?>
<link rel="stylesheet" href="<?=$templateFolder."/style.css?".time()?>" />
<div class="rating-holder">
	<table align="center" class="bx_item_detail_rating">
		<tr>
			<td>
				<div class="bx_item_rating">
					<div class="bx_stars_container">
						<div id="<?=$arJSParams["starsId"]?>" class="bx_stars_bg"></div>
						<div id="<?=$arJSParams["progressId"]?>" class="bx_stars_progres"></div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<a class="rate-count">(<span class="vc" style="float:none;clear:both;line-height: 21px;"><?=intval($arResult["PROPERTIES"]["vote_count"]["VALUE"])?></span> <?=GetMessage("VOTES")?>)</a>
<script type="text/javascript">
BX.ready(function(){
	window.<?=$strObName;?> = new JCIblockVoteStars(<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);

	window.<?=$strObName?>.ajaxParams = <?=$arResult["AJAX_PARAMS"]?>;
	window.<?=$strObName?>.setValue("<?=$votesCount > 0 ? ($votesValue+1)*20 : 0?>");
});
</script>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?//test_dump($arResult);?>
<?foreach($arResult["ITEMS"] as $arItem):

    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

    $strMainID = $this->GetEditAreaId($arItem['ID']);
    $arItemIDs = array(
        "ID" => $strMainID."_mainID",
        "VOTE_PLUS" => $strMainID . "_plus",
        "VOTE_MINUS" => $strMainID . "_minus",
        "REPLY" => $strMainID . "_reply",
        "COMMENT_ID" => $arItem["ID"],
        "AJAX_URL" => $templateFolder."/ajax.php"
    );
    ?>
    <div class="item" id="<?=$arItemIDs["ID"]?>">
        <div class="header">
            <div class="author">
                <div class="avatar">
                    <img alt="image" src="<?$avatar = CFile::ResizeImageGet($arItem["PROPERTIES"]["AVATAR"]["VALUE"], array("width" => 57, "height" => 57), BX_RESIZE_IMAGE_EXACT); echo $avatar["src"];?>">
                </div>
                <h2 class="name"><a href="#"><?=$arItem["NAME"]?></a></h2>
                <em class="date"><?=CIBlockFormatProperties::DateFormat("d F Y H:i:s", MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat()));?></em>
            </div>
            <div class="votes">
                <a href="javascript:void(0)" id="<?=$arItemIDs["VOTE_PLUS"]?>" class="vote plus"><?=intval($arItem["PROPERTIES"]["VOTE_PLUS"]["VALUE"])?></a>
                <a href="javascript:void(0)" id="<?=$arItemIDs["VOTE_MINUS"]?>" class="vote minus"><?=intval($arItem["PROPERTIES"]["VOTE_MINUS"]["VALUE"])?></a>
            </div>
        </div>
        <div class="advantages">
            <?if(!empty($arItem["PROPERTIES"]["POSITIVE_MESSAGE"]["VALUE"]["TEXT"])):?>
                <div class="row plus">
                    <h3><?=$arItem["PROPERTIES"]["POSITIVE_MESSAGE"]['NAME']?>:</h3>
                    <p><?=$arItem["PROPERTIES"]["POSITIVE_MESSAGE"]["~VALUE"]["TEXT"]?></p>
                </div>
            <?endif?>
            <?if(!empty($arItem["PROPERTIES"]["NEGATIVE_MESSAGE"]["VALUE"]["TEXT"])):?>
                <div class="row minus">
                    <h3><?=$arItem["PROPERTIES"]["NEGATIVE_MESSAGE"]['NAME']?>:</h3>
                    <p><?=$arItem["PROPERTIES"]["NEGATIVE_MESSAGE"]["~VALUE"]["TEXT"]?></p>
                </div>
            <?endif?>
        </div>
        <?if(!empty($arItem["PREVIEW_TEXT"])):?>
            <div class="comment-text">
                <p><?=$arItem["PREVIEW_TEXT"]?></p>
            </div>
        <?endif?>
        <div class="comment-mark">
            <strong><?=GetMessage('RATE')?></strong>
            <div class="stars">
                <span class="rating" style="width: <?=intval($arItem["PROPERTIES"]["RATING"]["VALUE"] / 5 * 100)?>%"><?=$arItem["PROPERTIES"]["RATING"]["VALUE"]?> from 5 stars</span>
            </div>
            <?/*<a href="#" id="<?=$arItemIDs["REPLY"]?>" class="link-comment">��������������</a>*/?>
        </div>
    </div>
    <script type="text/javascript">
        BX.ready(function(){
            window.uv_<?=$strMainID;?> = new JCReviewUserVote(<?=CUtil::PhpToJSObject($arItemIDs, false, true);?>);
            window.uv_<?=$strMainID;?>.bindEvents();
        });
    </script>
<?endforeach;?>
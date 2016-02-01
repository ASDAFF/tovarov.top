<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>


<div class="reviews-list">
    <?foreach($arResult['ITEMS'] as $key=> $arItem):?>
        <div class="item">
            <div class="header">
                <div class="avatar">
                    <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>" />
                </div>
                <h2 class="name"><a href="#"><?=$arItem['NAME']?></a></h2>
                <em class="date"><?=CIBlockFormatProperties::DateFormat("d F Y H:i", MakeTimeStamp($arItem["DATE_CREATE"], CSite::GetDateFormat()));?></em>
            </div>
            <div class="text-holder">
                <p><?=$arItem['PREVIEW_TEXT']?></p>
            </div>
            <div class="summary">
                <div class="stars">
                <?$perc = intval($arItem["PROPERTIES"]["RATING"]["VALUE"] / 5 * 100);?>
                    <span class="rating" style="width: <?=$perc?>%"><?=$arItem["PROPERTIES"]["RATING"]["VALUE"]?> <?=GetMessage('FIVESTARS')?></span>
                </div>
                 <?if($perc>1 && $perc <33):?>
                 <p><?=GetMessage('BAD')?></p>
                 <?elseif($perc>33 && $perc <66):?>
                  <p><?=GetMessage('GOOD')?></p>
                 <?elseif($perc>66 && $perc <101):?>
                 <p><?=GetMessage('BEST')?></p>
                <?endif;?>
            </div>
        </div>
        <?endforeach;?> 
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

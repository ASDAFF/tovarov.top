<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="our-team">
    <h2><?=$arResult['NAME']?></h2>
    <div class="items">
    <?foreach($arResult['ITEMS'] as $arItem):?>
        <div class="item">
            <div class="image">
                <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>" />
            </div>
            <div class="text">
                <div class="title">
                    <h2><?=$arItem['NAME']?></h2>
                    <h3><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></h3>
                </div>
                <p><?=$arItem['PREVIEW_TEXT']?></p>
            </div>
        </div>
      <?endforeach;?>
    </div>
</div>
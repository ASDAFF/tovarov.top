<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixComponent $component */
    $this->setFrameMode(true);

?>
<div class="day-action">
    <div class="day-title green">
        <h2> <?=($arResult['PROPERTIES']['DETAIL_TITLE']['VALUE'])?$arResult['PROPERTIES']['DETAIL_TITLE']['VALUE']:$arResult['NAME']?></h2>
        <span>
            <?if($arResult['ACTION_END']):?>
                <?=GetMessage('TO_ACTION_END')?> <?=sklonen($arResult['ACTION_END'], GetMessage('DAY_1'),GetMessage('DAY_2'),GetMessage('DAY_3'))?>
            <?else:?>
                <?=GetMessage('IS_OVER');?>
            <?endif;?> 
        </span>
    </div>
    <div class="text">
        <?=$arResult['DETAIL_TEXT']?>
    </div>
</div>
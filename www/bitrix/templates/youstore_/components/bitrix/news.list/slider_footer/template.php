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
<?if(count($arResult['ITEMS'])>0):?>
    <div class="fade-items">
        <?foreach($arResult['ITEMS'] as $key=>$arItem):?>
            <div class="item <?=($key==0)?'active':''?>">
                <img alt="image" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" />
            </div>
            <?endforeach;?>
    </div>
<?endif;?>
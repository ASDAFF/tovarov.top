<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult)):?>
    <ul class="account-tabs">
        <?foreach($arResult as $arItem):?>
            <li><a class="<?=$arItem["PARAMS"]["CLASS"]?> <?if($arItem["SELECTED"]):?>active<?endif?>" href="<?=$arItem["LINK"]?>"><span><?=strtoupper($arItem["TEXT"])?></span></a></li>
        <?endforeach;?>
    </ul>
<?endif;?>
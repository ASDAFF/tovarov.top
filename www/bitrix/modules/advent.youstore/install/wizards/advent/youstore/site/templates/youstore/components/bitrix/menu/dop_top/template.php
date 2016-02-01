<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult)):?>
    <div class="more-link"><a class="link" href="#"><?=GetMessage('MORE')?>...</a>
        <ul class="sub">
         <?foreach($arResult as $arItem):?>
            <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
          <?endforeach;?>
        </ul>
    </div>
<?endif?>
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
<div class="color-boxes">

    <?foreach($arResult["ITEMS"] as $arItem):?>
       <?$cl='';
       if($arItem['BG_TYPE']=='tm'){
         $cl = 'colors2';  
       }
       elseif($arItem['BG_TYPE']=='sv'){
          $cl = 'colors1'; 
       }?>
        <div class="box <?=($arItem['HAS_PIC'])?'':'centered'?> <?=$cl?>">        <?/*centered colors2*/?>
            <div class="bg">
                <img alt="bg" src="<?=$arItem['PROPERTIES']['BG']['BG_SRC']?>" />
            </div>
            <div class="holder">
                <span class="stripes">&nbsp;</span>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>">&nbsp;</a>
                <div class="text">
                    <h2><?=$arItem['NAME']?></h2>
                    <span class="border">&nbsp;</span>
                    <h3><?=$arItem['PREVIEW_TEXT']?></h3>

                    <p id="<?=$arItem['ID']?>"> 
                        <?if($arItem['ACTION_END']):?>
                            <?=GetMessage('TO_ACTION_END')?> <?=sklonen($arItem['ACTION_END'], GetMessage('DAY_1'),GetMessage('DAY_2'),GetMessage('DAY_3'))?>
                        <?else:?>
                            <?=GetMessage('IS_OVER');?>
                        <?endif;?>  
                    </p>
                </div> 
                <?if($arItem['HAS_PIC']):?>
                 <div class="image">
                    <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>" />
                  </div>
                <?endif;?>   
            </div>
        </div>

        <?endforeach;?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
        <?endif;?>
</div>
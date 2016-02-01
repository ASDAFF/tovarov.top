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


<div class="side-banners">
<?foreach($arResult["ITEMS"] as $arItem):?> 
    <?if($arItem['PROPERTIES']['VIDEO_HREF']['VALUE']):?>
		<div class="box">
			<img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>">
			<div class="border">&nbsp;</div>
			<div class="frame">
				<div class="include">
					<a href="<?=str_replace('/embed/', '/v/',$arItem['PROPERTIES']['VIDEO_HREF']['VALUE']);?>" class="video-link banner-ico fb_video">
						<span><?=$arItem['NAME']?></span>
					</a>
				</div>
			</div>
		</div>    
     <?/* <div class="box">
        <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>">
        <div class="border">&nbsp;</div>
        <div class="frame">
            <div class="include">
                <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" data-id="<?=$arItem['ID']?>" class="video-link banner-ico">
                    <span><?=$arItem['NAME']?></span>
                </a>
            </div>
            <div class="video-content video-cont<?=$arItem['ID']?>">
          <?=$arItem['PROPERTIES']['VIDEO']['~VALUE']['TEXT']?>
          </div>
        </div>
    </div>*/?>
    
    <?elseif($arItem['PROPERTIES']['LINK']['VALUE']):?> 
    <div class="box">
        <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>">
        <div class="border">&nbsp;</div>
        <div class="frame">
            <div class="include">
                <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="section">
                    <span class="text">
                        <strong><?=$arItem['NAME']?></strong>
                       <?=$arItem['PREVIEW_TEXT']?>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <?endif;?>
<?endforeach;?>
</div>
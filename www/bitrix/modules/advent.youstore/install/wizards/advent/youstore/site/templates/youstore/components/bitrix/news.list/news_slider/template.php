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


<div class="videos-section">
    <div class="mask">
      <ul class="videos-list">
    <?foreach($arResult["ITEMS"] as $arItem):?> 
    <?if($arItem['PROPERTIES']['VIDEO_HREF']['VALUE']):?>
		<li>
          <a href="<?=str_replace('/embed/', '/v/',$arItem['PROPERTIES']['VIDEO_HREF']['VALUE']);?>" class="video-link image fb_video">
          
            <img alt="image" src="<?=$arItem["RESIZE_PICTURE"]['SRC']?>" />
     
            <span class="frame">&nbsp;</span>
            <span class="expand">
              <span class="holder">
                <span class="video-text"><?=$arItem['NAME']?></span>
              </span>
            </span>
          </a>
        </li>	
       <?/* <li>
          <a href="#" data-id="<?=$arItem['ID']?>" class="video-link image fb_video">
          
            <img alt="image" src="<?=$arItem["RESIZE_PICTURE"]['SRC']?>" />
     
            <span class="frame">&nbsp;</span>
            <span class="expand">
              <span class="holder">
                <span class="video-text"><?=$arItem['NAME']?></span>
              </span>
            </span>
          </a>
          <div class="video-content  video-cont<?=$arItem['ID']?>">
          <?=$arItem['PROPERTIES']['VIDEO']['~VALUE']['TEXT']?>
          </div>
        </li>
		*/?>
     <?elseif($arItem['PROPERTIES']['LINK']['VALUE']):?>   
        <li>
          <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="image">
            <img alt="image" src="<?=$arItem["RESIZE_PICTURE"]['SRC']?>" />
            <span class="frame">&nbsp;</span>
            <span class="expand">
              <span class="holder">
                <span class="text">
                  <strong><?=$arItem['NAME']?></strong>
                  <span><?=$arItem['PREVIEW_TEXT']?></span>
                </span>
              </span>
            </span>
          </a>
        </li>
        <?endif;?>
     <?endforeach;?>
      </ul>
    </div>
    <div class="controls">
      <a href="#" class="prev-slide">Prev Slide</a>
      <a href="#" class="next-slide">Next Slide</a>
    </div>
</div>
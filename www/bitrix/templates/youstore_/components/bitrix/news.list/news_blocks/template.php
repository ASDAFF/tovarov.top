<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="footer-blocks">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="block">
		    <a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>">
		        <img alt="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" />
		        <span class="block-holder">
		            <span class="block-frame">
		                <strong><?=$arItem["~NAME"]?></strong>
		            </span>
		        </span>
		    </a>
		</div>
	<?endforeach;?>
</div>







<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="faq-section">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="row">
			<a href="#" class="link-show plus"><?=$arItem["NAME"]?></a>
			<div class="expander">
				<p><?=$arItem["PREVIEW_TEXT"]?></p>
			</div>
		</div>
	<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"):?>
	<?=$arResult["NAV_STRING"]?>
<?endif?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="faq-section">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="row" itemscope itemtype="http://schema.org/Question">
			<a itemprop="name" href="#" class="link-show plus"><?=$arItem["NAME"]?></a>
			<div class="expander" itemprop="acceptedAnswer" itemscope itemtype="http://schema.org/Answer">
				<p itemprop="text"><?=$arItem["PREVIEW_TEXT"]?></p>
			</div>
		</div>
	<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"):?>
	<?=$arResult["NAV_STRING"]?>
<?endif?>
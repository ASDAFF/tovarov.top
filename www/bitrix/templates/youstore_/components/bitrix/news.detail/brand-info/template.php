<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="brand-about">
	<?if(!empty($arResult["DETAIL_PICTURE"]["SRC"])):?>
	<div class="brand-img">
		<img alt="image" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="203">
	</div>
	<?endif?>
	<div class="brand-text">
		<h2><?=$arResult["NAME"]?></h2>
		<?=$arResult["DETAIL_TEXT"]?>
	</div>
</div>
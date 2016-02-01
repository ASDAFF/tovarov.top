<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult)):?>
	<ul class="items" style="width: 826px;">
		<?foreach($arResult as $arItem):?>
			<li <?if($arItem["SELECTED"]):?>class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?endforeach;?>
	</ul>
<?endif?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult)):?>
	<p class="head-text"><?=GetMessage("TITLE")?></p>
	<ul class="footer-menu">
		<?foreach($arResult as $arItem):?>
			<li>
				<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			</li>
		<?endforeach;?>
	</ul>
<?endif?>
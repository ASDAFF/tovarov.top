<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
	<div class="other-reviews">
		<?=$arParams["TITLE"]?"<h2>{$arParams["TITLE"]}</h2>":""?>
		<div class="items">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<div class="item">
					<?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])):?>
						<div class="image">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img alt="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"></a>
						</div>
					<?endif?>
                    <div class="text-holder">
						<h3><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a></h3>
						<?if(!empty($arItem["DISPLAY_ACTIVE_FROM"])):?>
							<em class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></em>
						<?endif?>
						<p><?=$arItem["PREVIEW_TEXT"]?></p>
						<div class="link-holder">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=GetMessage('DETAIL')?></a>
						</div>
                    </div>
                </div>
			<?endforeach;?>
		</div>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif?>
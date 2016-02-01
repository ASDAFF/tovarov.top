<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?if(!empty($arResult["ITEMS"])):?>
	<h2><?=$arResult["NAME"]?></h2>
	<div class="job-items">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<div class="item">
				<div class="photo">
					<div class="holder">
						<div class="image">&nbsp;</div>
					</div>
				</div>
				<div class="text">
					<div class="holder">
						<h3><?=$arItem["NAME"]?></h3>
						<?=$arItem["PREVIEW_TEXT"]?>
					</div>
				</div>
				<div class="link">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>?AJAX=Y"><?=GetMEssage('DETAIL')?></a>
				</div>
			</div>
		<?endforeach;?>
	</div>
<?/*else:?>
	<p>Ќа данный момент у нас нет открытых вакансий</p>
<?*/endif?>
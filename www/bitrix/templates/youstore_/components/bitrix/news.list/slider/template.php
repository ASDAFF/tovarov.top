<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div id="visual">
	<div class="mask">
		<ul id="owl-demo" class="slides">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<li class="item">
					<img alt="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" />
					<div class="tile">
						<div class="container">
							<div class="left-col">
								<div class="cell">
									<div class="title">
										<?=$arItem["~NAME"]?>
									</div>
									<?if(!empty($arItem["PREVIEW_TEXT"])):?>
										<div class="text">
											<p><?=$arItem["PREVIEW_TEXT"]?></p>
										</div>
									<?endif?>
									<?if(!empty($arItem["PROPERTIES"]["URL"]["VALUE"])):?>
										<a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>" class="button"><?=GetMessage("DETAIL_TEXT")?></a>
									<?endif?>
								</div>
							</div>
                            <?if($arItem['PROPERTIES']['CIRCLE_LINK']['VALUE'] && $arItem['PROPERTIES']['CIRCLE_TEXT']['VALUE']):?>
							<div class="right-col">
								<div class="cell">
									<div class="circle-box">
										<a href="<?=$arItem['PROPERTIES']['CIRCLE_LINK']['VALUE']?>" class="holder">
											<span class="frame"><?=$arItem['PROPERTIES']['CIRCLE_TEXT']['VALUE']?></span>
										</a>
									</div>
								</div>
							</div>
                        <?endif;?>
						</div>
					</div>
				</li>
			<?endforeach;?>
		</ul>
	</div>
</div>
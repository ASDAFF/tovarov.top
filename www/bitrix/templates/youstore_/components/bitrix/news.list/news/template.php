<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="news-container">
	<div class="news-rows">
		<?
			$theme = $arParams["THEME_CODE"]?:"tmpl_1";
		?>
		<div class='row'>
			<?foreach($arResult["ITEMS"] as $index => $arItem):
				
				list($day, $month) = explode(" ", $arItem["DISPLAY_ACTIVE_FROM"]);
				$month = strtoupper($month);
				
				$tools =   "<ul class='img-tools'>".((!empty($day))?"
							<li class='date'>
								<div class='frame'>
									<strong>$day</strong>$month
								</div>
							</li>":"").
						    "<li class='views'>
								<div class='frame'>
									<a>".intval($arItem["SHOW_COUNTER"])."</a>
								</div>
							</li>
							<li class='share'>
								<div class='frame'>
									<a class='share-ico' href='#'>share</a>
									<div class='share-box'>
										<div class='share-form' action='#'>
											
												<span class='text-shadow'>&nbsp;</span>
												<input type='text' class='text' value='http://".$_SERVER["HTTP_HOST"].$arItem["DETAIL_PAGE_URL"]."'>
												<ul class='soc'>
													<li><a onclick=\"Share.vk('http://{$_SERVER["HTTP_HOST"]}{$arItem["DETAIL_PAGE_URL"]}', '{$arItem["NAME"]}', 'http://{$_SERVER["HTTP_HOST"]}{$arItem["PREVIEW_PICTURE"]["SRC"]}', '".substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)."...')\" class='vkontakte'>vkontakte</a></li>
													<li><a onclick=\"Share.fb('http://{$_SERVER["HTTP_HOST"]}{$arItem["DETAIL_PAGE_URL"]}', '{$arItem["NAME"]}', 'http://{$_SERVER["HTTP_HOST"]}{$arItem["PREVIEW_PICTURE"]["SRC"]}', '".substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)."...')\" class='facebook'>facebook</a></li>
													<li><a onclick=\"Share.twitter('http://{$_SERVER["HTTP_HOST"]}{$arItem["DETAIL_PAGE_URL"]}', '{$arItem["NAME"]}', 'http://{$_SERVER["HTTP_HOST"]}{$arItem["PREVIEW_PICTURE"]["SRC"]}', '".substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)."...')\" class='twitter'>twitter</a></li>
													<li><a onclick=\"Share.gplus('http://{$_SERVER["HTTP_HOST"]}{$arItem["DETAIL_PAGE_URL"]}')\" class='google'>google</a></li>
												</ul>
												<a href='#' class='btn-close'>close</a>
											
										</div>
									</div>
								</div>
							</li>
						</ul>";
			?>
				<?
					if(($theme == "tmpl_1" || $index % 2 == 0) && $index > 0){
						echo "</div><div class='row'>";
					}
					switch($theme){
						case 'tmpl_1': //На всю ширину с картинкой
							?>
								<div class="box wide" itemscope itemtype="http://schema.org/Blog">
									<?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])):?>
										<div class="image">
											<img itemprop="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" />
											<?=$tools?>
											<?if(empty($arItem["PREVIEW_TEXT"])):?>
												<div class="title">
													<h2 itemprop="name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
												</div>
											<?endif?>
										</div>
									<?else:?>
										<div class="top">
											<?=$tools?>
										</div>
									<?endif?>
									<?if(!empty($arItem["PREVIEW_TEXT"])):?>
										<div class="text">
											<h2 itemprop="name"><?=$arItem["NAME"]?></h2>
											<p itemprop="description"><?=$arItem["PREVIEW_TEXT"]?></p>
											<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link-more"><?=GetMessage('DETAIL')?></a>
										</div>
									<?endif?>
								</div>
							<?
						break;
						case 'tmpl_2': //2 колонки
							?>
								<div class="box <?if($index % 2 == 0) echo "left"; else echo "right";?>" itemscope itemtype="http://schema.org/Blog">
									<?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])):?>
										<div class="image">
											<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img itemprop="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" /></a>
											<?=$tools?>
											<?if(empty($arItem["PREVIEW_TEXT"])):?>
												<div class="title">
													<h2 itemprop="name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
												</div>
											<?endif?>
										</div>
									<?else:?>
										<div class="top">
											<?=$tools?>
										</div>
									<?endif?>
									<?if(!empty($arItem["PREVIEW_TEXT"])):?>
										<div class="text">
											<h2 itemprop="name"> <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem["NAME"]?></a></h2>
											<p itemprop="description"><?=$arItem["PREVIEW_TEXT"]?></p>
											<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link-more"><?=GetMessage('DETAIL')?></a>
										</div>
									<?endif?>
								</div>
							<?
						break;
					}
				?>
			<?endforeach;?>
		</div>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"):?>
		<?=$arResult['NAV_STRING']?>
	<?endif?>
</div>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var CBitrixComponentTemplate $this */
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CDatabase $DB */
    /** @uses 404, accessories in catalog/catalog.element, list products in catalog/catalog.sections (where list of sections)
    */
?>
<?$this->setFrameMode(true);?>
<?if(!empty($arResult['ITEMS'])):?>

<div class="advice-box">
    <a href="#" class="link-prev"><?=GetMessage('PREV')?></a>
    <div class="mask">
        <ul class="items">
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <li class="item">
                    <div class="image">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                            <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>" />
                        </a>
                    </div>
                    <h2><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h2>
					<?if($arItem["PROPERTIES"]["vote_count"]["VALUE"]){
						$votesValue = round($arItem["PROPERTIES"]["vote_sum"]["VALUE"]/$arItem["PROPERTIES"]["vote_count"]["VALUE"], 2);
					}else{
						$votesValue = 0;
					}?>
					<table align="center" class="bx_item_detail_rating centered">
						<tr>
							<td>
								<div class="bx_item_rating">
									<div class="bx_stars_container">
										<div class="bx_stars_bg"></div>
										<div class="bx_stars_progres" style="width:<?=$arItem["PROPERTIES"]["vote_count"]["VALUE"] > 0 ? ($votesValue+1)*20 : 0?>%;"></div>
									</div>
								</div>
							</td>
						</tr>
					</table>
                    <?/*$APPLICATION->IncludeComponent(
                            "bitrix:iblock.vote",
                            "5-stars",
                            array(
                                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                "ELEMENT_ID" => $arItem['ID'],
                                "ELEMENT_CODE" => "",
                                "MAX_VOTE" => "5",
                                "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                                "SET_STATUS_404" => "N",
                                "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                                "CACHE_TYPE" => "N",//$arParams['CACHE_TYPE'],
                                "CACHE_TIME" => "1"//$arParams['CACHE_TIME']
                            ),
                            false
                        );*/?>
                    <!--div class="stars">
                    <span style="width: 55%" class="rating">3 from 5 stars</span>
                    </div-->
                    <?if(!empty($arItem['PRICES'])):?>
                    <div class="price">
                        <strong class="new-price"><?=number_format($arItem['PRICES']['BASE']['DISCOUNT_VALUE'],0,'.',' ')?><sup><?=GetMessage('CATALOG_CURR')?></sup></strong>
                    </div>
                    <?endif;?>    
                </li>
                <?endforeach;?>

        </ul>
    </div>
    <a href="#" class="link-next"><?=GetMessage('NEXT')?></a>
</div>
<?endif;?>

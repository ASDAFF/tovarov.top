<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
//test_dump($arResult);

$frame = $this->createFrame()->begin("");

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$injectId = 'bigdata_recommeded_products_'.rand();

?>

<script type="application/javascript">
	BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
	BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
	BX.current_server_time = '<?=time()?>';

	function bx_rcm_recommndation_event_attaching(rcm_items_cont)
	{

		var detailLinks = BX.findChildren(rcm_items_cont, {'className':'bx_rcm_view_link'}, true);

		if (detailLinks)
		{
			for (i in detailLinks)
			{
				BX.bind(detailLinks[i], 'click', function(e){
					window.JCCatalogBigdataProducts.prototype.RememberRecommendation(
						BX(this),
						BX(this).getAttribute('data-product-id')
					);
				});
			}
		}
	}

	BX.ready(function(){
		bx_rcm_recommndation_event_attaching(BX('<?=$injectId?>_items'));
	});

</script>

<?

if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>" class="bigdata_recommended_products_container"></span>

	<script type="application/javascript">

		BX.ready(function(){

			var params = <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>;
			var url = 'https://analytics.bitrix.info/crecoms/v1_0/recoms.php';
			var data = BX.ajax.prepareData(params);

			if (data)
			{
				url += (url.indexOf('?') !== -1 ? "&" : "?") + data;
				data = '';
			}

			var onready = function(response) {

				if (!response.items)
				{
					response.items = [];
				}
				BX.ajax({
					url: '/bitrix/components/bitrix/catalog.bigdata.products/ajax.php?'+BX.ajax.prepareData({'AJAX_ITEMS': response.items, 'RID': response.id}),
					method: 'POST',
					data: {'parameters':'<?=CUtil::JSEscape($signedParameters)?>', 'template': '<?=CUtil::JSEscape($signedTemplate)?>', 'rcm': 'yes'},
					dataType: 'html',
					processData: false,
					start: true,
					onsuccess: function (html) {
						var ob = BX.processHTML(html);

						// inject
						BX('<?=$injectId?>').innerHTML = ob.HTML;
						BX.ajax.processScripts(ob.SCRIPT);
					}
				});
			};

			BX.ajax({
				'method': 'GET',
				'dataType': 'json',
				'url': url,
				'timeout': 3,
				'onsuccess': onready,
				'onfailure': onready
			});
		});
	</script>

	<?
	$frame->end();
	return;
}

//echo '123<pre>'; print_r($arResult); echo '</pre>321';
if (!empty($arResult['ITEMS']))
{
	?>
	<script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',

		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
	</script>
	<span id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
	<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
	<?

	$arSkuTemplate = array();
	if(is_array($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
		{
			$arSkuTemplate[$iblockId] = array();
			foreach ($skuProps as &$arProp)
			{
				ob_start();
				if ('TEXT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_size full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_size';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_size_scroller_container">
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>;"
									><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
									</li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				elseif ('PICT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_scu full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_scu';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
									><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
							<span class="cnt"><span class="cnt_item"
													style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
													title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
									></span></span></li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				$arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
				ob_end_clean();
				unset($arProp);
			}
		}
	}

	?>
	<div class="prod-similar">
		<div class="tab-box">
			<h3 class="box-title icon5"><? echo GetMessage('CVP_TPL_MESS_RCM') ?></h3>
			<div class="similars">
			
	<div class="items-include">
        <a href="#" class="btn-prev">prev</a>
        <div class="mask">
            <div class="tab-items">
				<?
				foreach ($arResult['ITEMS'] as $key => $arItem)
				{
					$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

					$arItemIDs = array(
						'ID' => $strMainID,
						'PICT' => $strMainID . '_pict',
						'SECOND_PICT' => $strMainID . '_secondpict',
						'MAIN_PROPS' => $strMainID . '_main_props',

						'QUANTITY' => $strMainID . '_quantity',
						'QUANTITY_DOWN' => $strMainID . '_quant_down',
						'QUANTITY_UP' => $strMainID . '_quant_up',
						'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
						'BUY_LINK' => $strMainID . '_buy_link',
						'BASKET_ACTIONS' => $strMainID.'_basket_actions',
						'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
						'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

						'PRICE' => $strMainID . '_price',
						'DSC_PERC' => $strMainID . '_dsc_perc',
						'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

						'PROP_DIV' => $strMainID . '_sku_tree',
						'PROP' => $strMainID . '_prop_',
						'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
						'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
					);

					$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

					$strTitle = (
					isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
						? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
						: $arItem['NAME']
					);
					$showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";
					?>
					
				<div id="<? echo $strMainID; ?>" class="product-item mix <?if(!empty($arItem["PROPERTIES"]["DAY_ITEM"]["VALUE"])):?>day-item<?endif?> category-<?=$arItem["PROPERTIES"]["SEX"]["VALUE_ENUM_ID"]?> <?if(!$arItem["CAN_BUY"] || empty($arItem['MIN_PRICE']) || $arItem['CATALOG_QUANTITY']<=0):?>unavailable<?endif?>">
				<div class="holder">
					<?if(!empty($arItem["PROPERTIES"]["DAY_ITEM"]["VALUE"])):?>
						<div class="strong-box">
							<strong><?=GetMessage('CATALOG_OFFERDAY')?></strong>
						</div>
					<?endif?>
					<?
					if (!empty($arItem['MIN_PRICE']) && $arItem['CAN_BUY'] && empty($productLabel))
					{
						if ($arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
						{
						?><span class="discount">-<?=$arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"]?>%</span><?
						}
					}
					?>
					<?if(!empty($productLabel)):?>
						<span class="<?=$productLabel?>"><?=$arItem["PROPERTIES"]["LABEL"]["VALUE"]?></span>
					<?endif?>
					<?if(!empty($arItem["PROPERTIES"]["YOUTUBE_VIDEO_HREF"]["VALUE"])):?>
						<a href="<?=str_replace('/embed/', '/v/',$arItem["PROPERTIES"]["YOUTUBE_VIDEO_HREF"]["VALUE"]);?>" class="video-link fb_video"><?=GetMessage('PLAY')?></a>
					<?endif?>
					<div class="image">
						<a id="<?=$arItemIDs['PICT'];?>" href="<?=$arItem['DETAIL_PAGE_URL']; ?>" class="image-box" title="<? echo $strTitle; ?>">
							<?
							if(!empty($arItem["PREVIEW_PICTURE"]["ID"]))
								$photo = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array("width" => 181, "height" => 165));
							else
								$photo['src'] = $arItem["PREVIEW_PICTURE"]["SRC"];
							?>
							<?if(!empty($arItem["PROPERTIES"]["PRODUCT_LABEL_TEXT"]["VALUE"])):?>
								<span class="deal-holder">
									<span class="good-deal"><?=$arItem["PROPERTIES"]["PRODUCT_LABEL_TEXT"]["VALUE"]?></span>
								</span>
							<?endif?>
							<img src="<? echo $photo['src']; ?>" />
							<a href="<?=SITE_DIR?>ajax/quick.php?ID=<?=$arItem["ID"]?>" class="quick-view" rel="nofollow"><?=GetMessage('CATALOG_QUICK')?></a>
						</a>
					</div>
					<div class="title">
						<h3>
							<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $arItem['NAME']; ?>"><? echo $arItem['NAME']; ?></a>
						</h3>
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
					</div>
					<div id="<? echo $arItemIDs['PRICE']; ?>" class="price">
						<?
							if (!empty($arItem['MIN_PRICE'])/* && $arItem['CAN_BUY']*/)
							{
								if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
								{
								?><strong class="old-price"><? echo number_format($arItem['MIN_PRICE']['VALUE'],0,'.',' '); ?></strong><?
								}
								?>
								<strong class="new-price"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'],0,'.',' ')?> <sup><?=GetMessage("CURRENCY_".$arItem["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sup></strong>
								<?
							}
						?>
					</div>
					<div class="expand">
						<div class="expand-holder">
							<?
							if ($arItem['CAN_BUY'] && $arItem['CATALOG_QUANTITY']>0)
							{
								switch($arItem["CATALOG_TYPE"]){
									case 3: 
									?>
									<?if(count($arItem["OFFERS"]) > 1):?>
										<a class="bx_bt_button bx_medium buy-quick button btn-cart" href="<?=SITE_DIR?>ajax/buy.php?ID=<?=$arItem["ID"]?>" rel="nofollow">
											<span><?echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?></span>
										</a>
										<?else:?>
										<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium button btn-cart" href="javascript:void(0)" rel="nofollow">
											<span><?echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?></span>
										</a>
										<?endif?>
									<?
										break;
									default:?>
									<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium button btn-cart" href="javascript:void(0)" rel="nofollow">
										<span><?echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));?></span>
									</a>
									<? break;
								}
							}
							else
							{
								?>
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium button btn-cart" href="javascript:void(0)" rel="nofollow">
									<span><? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?></span>
								</a>
								<?
							}
							if (!empty($arItem['MIN_PRICE'])/* && $arItem['CAN_BUY']*/)
							{
								if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
								{
									?>
									<p class="message"><?=GetMEssage('CATALOG_ECONOMI')?> <strong><?=$arItem['MIN_PRICE']["DISCOUNT_DIFF"]?></strong> <sub><?=GetMessage("CURRENCY_".$arItem["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sub>.</p>
									<?
								}
							}?>
							<ul class="tools">
								<li>
									<a class="link-wishlist item<?=$arItem['ID']?>" data-id="<?=$arItem['ID']?>" data-action="ADD2DELAY"  href="<?=SITE_DIR?>ajax/wishlist.php"><?=GetMessage('WISHLIST')?></a>
									<a data-id="<?=$arItem['ID']?>" data-action="ADD2DELAY"  href="<?=SITE_DIR?>ajax/wishlist.php" class="link-wishlist-delete item<?=$arItem['ID']?>" style="display: none;"><?=GetMessage('WISHLIST_DEL')?></a>
								</li>
							</ul>
							<?if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']))
							{
								foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
								{
									if(empty($arOneProp["DISPLAY_VALUE"]))
										continue;?>
									<span>
										<?
										$string = preg_replace('~(.*)\[(.*)\]~', "\$1", $arOneProp["NAME"]);
										echo $string;
										?>:
										<b>
											<?echo (
												is_array($arOneProp['DISPLAY_VALUE'])
												? implode('<br>', $arOneProp['DISPLAY_VALUE'])
												: $arOneProp['DISPLAY_VALUE']
											);?>
										</b>
									</span>
									<?
								}
							}?>
						</div>
					</div>
					<?
					if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
					{
						if (!empty($arItem['OFFERS_PROP']))
						{
							$arSkuProps = array();
							?>
							<div class="bx_catalog_item_scu" style="display:none;" id="<? echo $arItemIDs['PROP_DIV']; ?>">
								<?
								foreach ($arSkuTemplate as $code => $strTemplate)
								{
									if (!isset($arItem['OFFERS_PROP'][$code]))
										continue;
									echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
								}
								foreach ($arResult['SKU_PROPS'] as $arOneProp)
								{
									if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
										continue;
									$arSkuProps[] = array(
										'ID' => $arOneProp['ID'],
										'SHOW_MODE' => $arOneProp['SHOW_MODE'],
										'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
									);
								}
								foreach ($arItem['JS_OFFERS'] as &$arOneJs)
								{
									if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
										$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
								}
								unset($arOneJs);
								?>
							</div>
							<?
							if ($arItem['OFFERS_PROPS_DISPLAY'])
							{
								foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
								{
									$strProps = '';
									if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
									{
										foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
										{
											$strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
												is_array($arOneProp['VALUE'])
												? implode(' / ', $arOneProp['VALUE'])
												: $arOneProp['VALUE']
											).'</strong>';
										}
									}
									$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
								}
							}

							$arJSParams = array(
								'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
								'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
								'SHOW_ADD_BASKET_BTN' => false,
								'SHOW_BUY_BTN' => true,
								'SHOW_ABSENT' => true,
								'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
								'SECOND_PICT' => $arItem['SECOND_PICT'],
								'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
								'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
								'DEFAULT_PICTURE' => array(
									'PICTURE' => $arItem['PRODUCT_PREVIEW'],
									'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
								),
								'VISUAL' => array(
									'ID' => $arItemIDs['ID'],
									'PICT_ID' => $arItemIDs['PICT'],
									'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
									'QUANTITY_ID' => $arItemIDs['QUANTITY'],
									'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
									'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
									'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
									'PRICE_ID' => $arItemIDs['PRICE'],
									'TREE_ID' => $arItemIDs['PROP_DIV'],
									'TREE_ITEM_ID' => $arItemIDs['PROP'],
									'BUY_ID' => $arItemIDs['BUY_LINK'],
									'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
									'DSC_PERC' => $arItemIDs['DSC_PERC'],
									'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
									'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
								),
								'BASKET' => array(
									'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
									'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE']
								),
								'PRODUCT' => array(
									'ID' => $arItem['ID'],
									'NAME' => $arItem['~NAME']
								),
								'OFFERS' => $arItem['JS_OFFERS'],
								'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
								'TREE_PROPS' => $arSkuProps,
								'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
							);?>
							<script type="text/javascript">
								var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
							</script>
							<?
						}else{
							$arJSParams = array(
								'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
								'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
								'SHOW_ADD_BASKET_BTN' => true,
								'SHOW_BUY_BTN' => false,
								'SHOW_ABSENT' => true,
								'PRODUCT' => array(
									'ID' => $arItem['ID'],
									'NAME' => $arItem['~NAME'],
									'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
									'CAN_BUY' => $arItem["CAN_BUY"],
									'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
									'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
									'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
									'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
									'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
									'ADD_URL' => $arItem['~ADD_URL'],
									'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
								),
								'BASKET' => array(
									'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
									'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
									'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
									'EMPTY_PROPS' => $emptyProductProperties
								),
								'VISUAL' => array(
									'ID' => $arItemIDs['ID'],
									'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
									'QUANTITY_ID' => $arItemIDs['QUANTITY'],
									'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
									'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
									'PRICE_ID' => $arItemIDs['PRICE'],
									'BUY_ID' => $arItemIDs['BUY_LINK'],
									'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
								),
								'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
							);
							unset($emptyProductProperties);?>
							<script type="text/javascript">
								var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
							</script>
							<?
						}
					}else{
						$arJSParams = array(
							'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
							'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
							'SHOW_ADD_BASKET_BTN' => true,
							'SHOW_BUY_BTN' => false,
							'SHOW_ABSENT' => true,
							'PRODUCT' => array(
								'ID' => $arItem['ID'],
								'NAME' => $arItem['~NAME'],
								'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
								'CAN_BUY' => $arItem["CAN_BUY"],
								'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
								'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
								'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
								'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
								'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
								'ADD_URL' => $arItem['~ADD_URL'],
								'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
							),
							'BASKET' => array(
								'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
								'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'EMPTY_PROPS' => $emptyProductProperties
							),
							'VISUAL' => array(
								'ID' => $arItemIDs['ID'],
								'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
								'QUANTITY_ID' => $arItemIDs['QUANTITY'],
								'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
								'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
								'PRICE_ID' => $arItemIDs['PRICE'],
								'BUY_ID' => $arItemIDs['BUY_LINK'],
								'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
							),
							'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
						);
						unset($emptyProductProperties);
						?>
						<script type="text/javascript">
							var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
						</script>
						<?
					}
				?>

				<?/*
				<a id="<? echo $arItemIDs['PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" data-product-id="<?=$arItem['ID']?>" class="bx_catalog_item_images bx_rcm_view_link"<? if ($arParams['SHOW_IMAGE'] == "Y")
					{
						?> style="background-image: url(<? echo($arParams['SHOW_IMAGE'] == "Y" ? $arItem['PREVIEW_PICTURE']['SRC'] : ""); ?>)"<?
					} ?> title="<? echo $strTitle; ?>"><?
					if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
					{
						?>
						<div id="<? echo $arItemIDs['DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo(0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
							-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
						</div>
					<?
					}
					if ($arItem['LABEL'])
					{
						?><div class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div><?
					}
					?>
				</a><?
				if ($arItem['SECOND_PICT'])
				{
					?><a id="<? echo $arItemIDs['SECOND_PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_catalog_item_images_double bx_rcm_view_link" data-product-id="<?=$arItem['ID']?>"<? if ($arParams['SHOW_IMAGE'] == "Y")
				{
					?> style="background-image: url(<? echo(
					!empty($arItem['PREVIEW_PICTURE_SECOND'])
						? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
						: $arItem['PREVIEW_PICTURE']['SRC']
					); ?>)"<?
				} ?> title="<? echo $strTitle; ?>"><?
					if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
					{
						?>
						<div id="<? echo $arItemIDs['SECOND_DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo(0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
							-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
						</div>
					<?
					}
					if ($arItem['LABEL'])
					{
						?><div class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div><?
					}
					?>
					</a><?
				}
				?>
				<? if ($arParams['SHOW_NAME'] == "Y")
				{
					?>
					<div class="bx_catalog_item_title"><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_rcm_view_link" data-product-id="<?=$arItem['ID']?>" title="<? echo $arItem['NAME']; ?>"><? echo $arItem['NAME']; ?></a></div>
				<?
				}?>
				<div class="bx_catalog_item_price">
					<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price"><?
						if (!empty($arItem['MIN_PRICE']))
						{
							if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
							{
								echo GetMessage(
									'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
									array(
										'#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
										'#MEASURE#' => GetMessage(
											'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
											array(
												'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
												'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
											)
										)
									)
								);
							}
							else
							{
								echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
							}
							if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
							{
								?> <span style="color: #a5a5a5;font-size: 12px;font-weight: normal;white-space: nowrap;text-decoration: line-through;"><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span><?
							}
						}
						?></div>
				</div>
				*/?>
				<?/*
				if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) // Simple Product
				{
					?>
					<div class="bx_catalog_item_controls"><?
						if ($arItem['CAN_BUY'])
						{
							if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
							{
								?>
								<div class="bx_catalog_item_controls_blockone">
									<div style="display: inline-block;position: relative;">
										<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
										<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
										<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
										<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>" class="bx_cnt_desc"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
									</div>
								</div>
							<?
							}
							?>
							<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
									echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
									?></a>
							</div>
						<?
						}
						else
						{
							?>
							<div class="bx_catalog_item_controls_blockone">
								<a class="bx_medium bx_bt_button_type_2 bx_rcm_view_link" data-product-id="<?=$arItem['ID']?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" rel="nofollow">
									<?	echo('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CVP_TPL_MESS_BTN_DETAIL')); ?>
								</a>
							</div><?
							if ('Y' == $arParams['PRODUCT_SUBSCRIPTION'] && 'Y' == $arItem['CATALOG_SUBSCRIPTION'])
							{
								?>
								<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?
									echo('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CVP_TPL_MESS_BTN_SUBSCRIBE'));
									?>
								</a>
								</div><?
							}
						}
						?>
						<div style="clear: both;"></div><?

						?></div><?
				if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']))
				{
				?>
					<div class="bx_catalog_item_articul">
						<?
						foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
						{
							?><br><? echo $arOneProp['NAME']; ?> <strong><?
							echo(
							is_array($arOneProp['DISPLAY_VALUE'])
								? implode('/', $arOneProp['DISPLAY_VALUE'])
								: $arOneProp['DISPLAY_VALUE']
							); ?></strong><?
						}
						?>
					</div>
				<?
				}


				$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
				if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
				{
				?>
					<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
						<?
						if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
						{
							foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
							{
								?>
								<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
								<?
								if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
									unset($arItem['PRODUCT_PROPERTIES'][$propID]);
							}
						}
						$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);

						if (!$emptyProductProperties)
						{

							?>
							<table>
								<?
								foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo)
								{
									?>
									<tr>
										<td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
										<td>
											<?
											if (
												'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
												&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
											)
											{
												foreach ($propInfo['VALUES'] as $valueID => $value)
												{
													?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
												}
											}
											else
											{
												?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
												foreach ($propInfo['VALUES'] as $valueID => $value)
												{
													?>
													<option value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
												}
												?></select><?
											}
											?>
										</td>
									</tr>
								<?
								}
								?>
							</table>
						<?
						}
						?>
					</div>
				<?
				}
				$arJSParams = array(
					'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_ADD_BASKET_BTN' => false,
					'SHOW_BUY_BTN' => true,
					'SHOW_ABSENT' => true,
					'PRODUCT' => array(
						'ID' => $arItem['ID'],
						'NAME' => $arItem['~NAME'],
						'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
						'CAN_BUY' => $arItem["CAN_BUY"],
						'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
						'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
						'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
						'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
						'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
						'ADD_URL' => $arItem['~ADD_URL'],
						'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
					),
					'BASKET' => array(
						'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
						'EMPTY_PROPS' => $emptyProductProperties
					),
					'VISUAL' => array(
						'ID' => $arItemIDs['ID'],
						'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
						'QUANTITY_ID' => $arItemIDs['QUANTITY'],
						'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
						'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
						'PRICE_ID' => $arItemIDs['PRICE'],
						'BUY_ID' => $arItemIDs['BUY_LINK'],
						'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
					),
					'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
				);
				?>
					<script type="text/javascript">
						var <? echo $strObName; ?> = new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
					</script><?
				}
				else // Wth Sku
				{
				?>
					<div class="bx_catalog_item_controls no_touch">
						<?
						if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
						{
							?>
							<div class="bx_catalog_item_controls_blockone">
								<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
								<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
								<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
								<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
							</div>
						<?
						}
						?>
						<div class="bx_catalog_item_controls_blocktwo">
							<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
								echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
								?></a>
						</div>
						<div style="clear: both;"></div>
					</div>

					<div class="bx_catalog_item_controls touch">
						<a class="bx_bt_button_type_2 bx_medium bx_rcm_view_link" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" data-product-id="<?=$arItem['ID']?>"><?
							echo('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CVP_TPL_MESS_BTN_DETAIL'));
							?></a>
					</div>
				<?
				$boolShowOfferProps =  !!$arItem['OFFERS_PROPS_DISPLAY'];
				$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
				if ($boolShowProductProps || $boolShowOfferProps)
				{
				?>
					<div class="bx_catalog_item_articul">
						<?
						if ($boolShowProductProps)
						{
							foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
							{
								?><br><? echo $arOneProp['NAME']; ?><strong> <?
								echo(
								is_array($arOneProp['DISPLAY_VALUE'])
									? implode(' / ', $arOneProp['DISPLAY_VALUE'])
									: $arOneProp['DISPLAY_VALUE']
								); ?></strong><?
							}
						}

						?>
						<span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
					</div>
				<?
				}

				if (!empty($arItem['OFFERS']) && isset($arSkuTemplate[$arItem['IBLOCK_ID']]))
				{
				$arSkuProps = array();
				?>
					<div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
						foreach ($arSkuTemplate[$arItem['IBLOCK_ID']] as $code => $strTemplate)
						{
							if (!isset($arItem['OFFERS_PROP'][$code]))
								continue;
							echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
						}

						if (isset($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']]))
						{
							foreach ($arResult['SKU_PROPS'][$arItem['IBLOCK_ID']] as $arOneProp)
							{
								if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
									continue;
								$arSkuProps[] = array(
									'ID' => $arOneProp['ID'],
									'SHOW_MODE' => $arOneProp['SHOW_MODE'],
									'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
								);
							}
						}
						foreach ($arItem['JS_OFFERS'] as &$arOneJs)
						{
							if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
								$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-' . $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] . '%';
						}

						?></div><?
				if ($arItem['OFFERS_PROPS_DISPLAY'])
				{
					foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
					{
						$strProps = '';
						if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
						{
							foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
							{
								$strProps .= '<br>' . $arOneProp['NAME'] . ' <strong>' . (
									is_array($arOneProp['VALUE'])
										? implode(' / ', $arOneProp['VALUE'])
										: $arOneProp['VALUE']
									) . '</strong>';
							}
						}
						$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
					}
				}
				$arJSParams = array(
					'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_ADD_BASKET_BTN' => false,
					'SHOW_BUY_BTN' => true,
					'SHOW_ABSENT' => true,
					'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
					'SECOND_PICT' => ($arParams['SHOW_IMAGE'] == "Y" ? $arItem['SECOND_PICT'] : false),
					'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
					'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
					'DEFAULT_PICTURE' => array(
						'PICTURE' => $arItem['PRODUCT_PREVIEW'],
						'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
					),
					'VISUAL' => array(
						'ID' => $arItemIDs['ID'],
						'PICT_ID' => $arItemIDs['PICT'],
						'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
						'QUANTITY_ID' => $arItemIDs['QUANTITY'],
						'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
						'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
						'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
						'PRICE_ID' => $arItemIDs['PRICE'],
						'TREE_ID' => $arItemIDs['PROP_DIV'],
						'TREE_ITEM_ID' => $arItemIDs['PROP'],
						'BUY_ID' => $arItemIDs['BUY_LINK'],
						'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
						'DSC_PERC' => $arItemIDs['DSC_PERC'],
						'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
						'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
					),
					'BASKET' => array(
						'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
						'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE']
					),
					'PRODUCT' => array(
						'ID' => $arItem['ID'],
						'NAME' => $arItem['~NAME']
					),
					'OFFERS' => $arItem['JS_OFFERS'],
					'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
					'TREE_PROPS' => $arSkuProps,
					'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
				);
				?>
					<script type="text/javascript">
						var <? echo $strObName; ?> = new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
					</script>
				<?
				}
				}
				*/?>
				
				</div>
				</div>
				
				
				<?
				}
				?>
            </div>
        </div><!--.mask-->
        <a href="#" class="btn-next">next</a>
    </div>
    <script type="text/javascript">
        BX.message({
                MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_BUY')); ?>',
                MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
                MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
                BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
                BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
                ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
                TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
                TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
                TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
                BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
                BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
                BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
        });
    </script>
			</div>
		</div>
	</div>
	
	
	<?/*
	<div class="bx_item_list_you_looked_horizontal col<? echo $arParams['LINE_ELEMENT_COUNT']; ?> <? echo $templateData['TEMPLATE_CLASS']; ?>">
		<div class="bx_item_list_title"><? echo GetMessage('CVP_TPL_MESS_RCM') ?></div>
		<div class="bx_item_list_section">
			<div class="bx_item_list_slide active">

			</div>
		</div>
	</div>
	*/?>
	</span>
<?
}

$frame->end();?>

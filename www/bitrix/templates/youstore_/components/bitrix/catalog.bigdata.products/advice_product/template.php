<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

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
	<div class="advice-box">
        <a href="#" class="link-prev">prev</a>
        <div class="mask">
            <ul class="items">
				<?
				foreach ($arResult['ITEMS'] as $key => $arItem)
				{
					if(is_array($arItem['PREVIEW_PICTURE']) && intval($arItem['PREVIEW_PICTURE']['ID'])>0){
						$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'],array('width'=>146,'height'=>160),BX_RESIZE_IMAGE_EXACT,true);
						$file = array_change_key_case($file,CASE_UPPER);
					}elseif(is_array($arItem['DETAIL_PICTURE']) && intval($arItem['DETAIL_PICTURE']['ID'])>0){
						$file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'],array('width'=>146,'height'=>160),BX_RESIZE_IMAGE_EXACT,true);
						$file = array_change_key_case($file,CASE_UPPER);
					}elseif(is_array($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'])){
						$file = CFile::ResizeImageGet($arItem['PROPERTIES']['MORE_PHOTO']['VALUE'][0],array('width'=>146,'height'=>160),BX_RESIZE_IMAGE_EXACT,true);
						$file = array_change_key_case($file,CASE_UPPER);
					}
					?>
					<li class="item">
						<div class="image">
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
								<img alt="image" src="<?=$file['SRC']?>" />
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
							<strong class="new-price"><?=number_format($arItem['PRICES']['BASE']['DISCOUNT_VALUE'],0,'.',' ')?><sup><?=GetMessage('CURRENCY_RUB_TITLE')?></sup></strong>
						</div>
						<?endif;?>    
					</li>
				<?
				}
				?>
            </ul>
        </div><!--.mask-->
        <a href="#" class="link-next">next</a>
    </div>
	<script>
	    jQuery('.advice-box').scrollGallery({
            sliderHolder: '.mask',
            slider:'>ul',
            slides: '>li',
            step:1,
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
    });
	</script>
	</span>
<?
}
$frame->end();?>

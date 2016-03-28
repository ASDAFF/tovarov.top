<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var CBitrixComponentTemplate $this */
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CDatabase $DB */
$this->setFrameMode(true);?>

<?// test_dump($arResult);
    if (!empty($arResult['ITEMS']))
    {
        $templateData = array(
            'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
            'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
        );

        CJSCore::Init(array("popup"));
        $arSkuTemplate = array();

        if (!empty($arResult['SKU_PROPS']))
        {
            foreach ($arResult['SKU_PROPS'] as &$arProp)
            {
                ob_start();
                if ('TEXT' == $arProp['SHOW_MODE'])
                {
                    if (5 < $arProp['VALUES_COUNT'])
                    {
                        $strClass = 'bx_item_detail_size full';
                        $strWidth = ($arProp['VALUES_COUNT']*20).'%';
                        $strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
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
                                    ?><li
                                        data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"
                                        data-onevalue="<? echo $arOneValue['ID']; ?>"
                                        style="width: <? echo $strOneWidth; ?>;"
                                        ><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li><?
                                    }
                                ?>
                            </ul>
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
                        $strWidth = ($arProp['VALUES_COUNT']*20).'%';
                        $strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
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
                                    ?><li
                                        data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
                                        data-onevalue="<? echo $arOneValue['ID']; ?>"
                                        style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
                                        ><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
                                        <span class="cnt"><span class="cnt_item"
                                                style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
                                                title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
                                                ></span></span></li><?
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                        <div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                    </div>
                </div><?
                }
                $arSkuTemplate[$arProp['CODE']] = ob_get_contents();
                ob_end_clean();
            }
            unset($arProp);
        }

        $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
        $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
        $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
    ?>
    <?
        $itemSize = count($arResult["ITEMS"]);
        foreach ($arResult['ITEMS'] as $key => $arItem)
        {
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
            $strMainID = $this->GetEditAreaId($arItem['ID']);

            $arItemIDs = array(
                'ID' => $strMainID,
                'PICT' => $strMainID.'_pict',
                'SECOND_PICT' => $strMainID.'_secondpict',
                'MAIN_PROPS' => $strMainID.'_main_props',

                'QUANTITY' => $strMainID.'_quantity',
                'QUANTITY_DOWN' => $strMainID.'_quant_down',
                'QUANTITY_UP' => $strMainID.'_quant_up',
                'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
                'BUY_LINK' => $strMainID.'_buy_link',
                'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

                'PRICE' => $strMainID.'_price',
                'DSC_PERC' => $strMainID.'_dsc_perc',
                'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

                'PROP_DIV' => $strMainID.'_sku_tree',
                'PROP' => $strMainID.'_prop_',
                'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
                'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
            );

            $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

            $strTitle = (
                isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
                ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
                : $arItem['NAME']
            );

            if(!empty($arItem["OFFERS"])){
                foreach($arItem["OFFERS"] as $offer){
                    if($offer["CAN_BUY"]) $arItem["CAN_BUY"] = true;
                }
            }

            $productLabel = $arItem["PROPERTIES"]["LABEL"]["VALUE_XML_ID"];
        ?>
        
        <div id="<? echo $strMainID; ?>" class="product-item mix <?if(!empty($arItem["PROPERTIES"]["DAY_ITEM"]["VALUE"])):?>day-item<?endif?> category-<?=$arItem["PROPERTIES"]["SEX"]["VALUE_ENUM_ID"]?> <?if(!$arItem["CAN_BUY"] || empty($arItem['MIN_PRICE']) /*|| $arItem['CATALOG_QUANTITY']<=0*/):?>unavailable<?endif?>">
            <div class="holder">
                <?if(!empty($arItem["PROPERTIES"]["DAY_ITEM"]["VALUE"])):?>
                    <div class="strong-box">
                        <strong><?=GetMEssage('CATALOG_OFFERDAY')?></strong>
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


                <?if(!empty($arItem["PROPERTIES"]["YOUTUBE_VIDEO"]["VALUE"]['TEXT'])):?>
                    <?$link = $arItem["PROPERTIES"]["YOUTUBE_VIDEO"]["VALUE"]['TEXT']?>
                    <?if (strrpos($link, "iframe") !== false):?>
                        <a data-id="<?=$arItem['ID']?>" class="video-link" rel="nofollow"><?=GetMessage('PLAY')?></a>
                        <div class="video-content video-cont<?=$arItem['ID']?>"><?=$arItem['PROPERTIES']['YOUTUBE_VIDEO']['~VALUE']['TEXT']?></div>
                    <?else:?>
                        <a rel="nofollow" class="video-link-fancybox fancybox.iframe" href="<?='https://youtube.com/embed/'.$link?>"><?=GetMessage('PLAY')?></a>
                    <?endif?>
                <?endif?>
                <div class="image">
                    <a id="<? echo $arItemIDs['PICT']; ?>"
                        href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"
                        class="image-box"
                        title="<? echo $strTitle; ?>">
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
                        <a href="<?=SITE_DIR?>ajax/quick.php?ID=<?=$arItem["ID"]?>" class="quick-view" rel="nofollow"><?=GetMEssage('CATALOG_QUICK')?></a>
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
                        if (!empty($arItem['MIN_PRICE'])/* && $arItem['CAN_BUY']*/) //uncomment if need show @not_available message for products where price is set and product not available
                        {
                            if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
                            {
                            ?>
                            <strong class="old-price"><? echo number_format($arItem['MIN_PRICE']['VALUE'],0,'.',' '); ?></strong><?
                            }
                        ?>
                        <strong class="new-price"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'],0,'.',' ')?> <sup><?=GetMessage("CURRENCY_".$arItem["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sup></strong>
                        <?
                        }/*else{  
                        ?>
                        <strong class="new-price unavailable"><? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?></strong>
                        <?
                        }  */
                    ?>
                </div>
                <div class="expand">
                    <div class="expand-holder">
                    <?if($arParams['USE_PRODUCT_QUANTITY']):?>
                    <input type="hidden" value="1" id="<?=$arItemIDs['QUANTITY']?>">
                    <?endif;?>
                        <?
                            if ($arItem['CAN_BUY'] /*&& $arItem['CATALOG_QUANTITY']>0*/)
                            {
                                switch($arItem["CATALOG_TYPE"]){
                                    case 3: 
                                    ?>
                                    <?if(count($arItem["OFFERS"]) > 1):?>
                                        <a  class="bx_bt_button bx_medium buy-quick button btn-cart" href="<?=SITE_DIR?>ajax/buy.php?ID=<?=$arItem["ID"]?>" rel="nofollow">
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
                            ?>

                            <?
                            }
                            else
                            {     
                            ?>
                            <a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium button btn-cart" href="javascript:void(0)" rel="nofollow">
                                <span><? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?></span>
                            </a>
                            <?
                            }
                        ?>
                        <?/*if(!empty($arItem["PREVIEW_TEXT"])):?>
                            <div class="detail">
                            <p><?=$arItem["PREVIEW_TEXT"]?></p>
                            </div>
                        <?endif*/?>
                        <?
                            if (!empty($arItem['MIN_PRICE'])/* && $arItem['CAN_BUY']*/)
                            {
                                if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
                                {
                                ?>
                                <p class="message"><?=GetMessage('CATALOG_ECONOMY')?> <strong><?=$arItem['MIN_PRICE']["DISCOUNT_DIFF"]?></strong> <sub><?=GetMessage("CURRENCY_".$arItem["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sub>.</p>
                                <?
                                }
                        }?>
                        <ul class="tools">
                            <li>
                                <a rel="nofollow" class="link-wishlist item<?=$arItem['ID']?>" data-id="<?=$arItem['ID']?>" data-action="ADD2DELAY"  href="<?=SITE_DIR?>ajax/wishlist.php"><?=GetMessage('WISHLIST')?></a>
                                <a rel="nofollow" data-id="<?=$arItem['ID']?>" data-action="DELETE_FROM_DELAY"  href="<?=SITE_DIR?>ajax/wishlist.php" class="link-wishlist-delete item<?=$arItem['ID']?>" style="display: none;"><?=GetMessage('WISHLIST_DEL')?></a>
                            </li> 
                        </ul>
                        <?if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']))
                            {
                            ?>
                            <?
                                foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp)
                                {
                                    if(empty($arOneProp["DISPLAY_VALUE"])) continue;
                                ?>
                                <span>
                                    <?
                                        $string = preg_replace('~(.*)\[(.*)\]~', "\$1", $arOneProp["NAME"]);
                                        echo $string;
                                    ?>: 
                                    <b><?
                                            echo (
                                                is_array($arOneProp['DISPLAY_VALUE'])
                                                ? implode('<br>', $arOneProp['DISPLAY_VALUE'])
                                                : $arOneProp['DISPLAY_VALUE']
                                            );
                                    ?></b>
                                </span>
                                <?
                                }
                            ?>
                            <?
                        }?>
                    </div>
                </div>
                <?
                    if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
                    {
                        if (!empty($arItem['OFFERS_PROP']))
                        {
                            $arSkuProps = array();
                        ?><div class="bx_catalog_item_scu" style="display:none;" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
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
                            );
                        ?>
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
                            unset($emptyProductProperties);
                        ?>
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
            </div>
        </div>
        <?
        }
    ?>
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
    <br/><br/>
    <?=$arResult["NAV_STRING"]?>
    <?
    }
?>
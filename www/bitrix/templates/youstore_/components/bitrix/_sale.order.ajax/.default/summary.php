<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
<div class="step">
    <div class="title">
        <div class="step-label">
            <div class="label-holder">
                <strong><?=++$currentOrderStep?></strong>
                <p>шаг</p>
            </div>
        </div>
        <h2><?=strtoupper(GetMessage("SALE_PRODUCTS_SUMMARY"));?></h2>
    </div>

	<div class="holder">
        <div class="order-summary">
		    <table class="order-table">
                <thead>
                    <tr>
                        <?
                        $bPreviewPicture = false;
                        $bDetailPicture = false;
                        $imgCount = 0;

                        // prelimenary column handling
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
                        {
                            if ($arColumn["id"] == "PROPS")
                                $bPropsColumn = true;

                            if ($arColumn["id"] == "NOTES")
                                $bPriceType = true;

                            if ($arColumn["id"] == "PREVIEW_PICTURE")
                                $bPreviewPicture = true;

                            if ($arColumn["id"] == "DETAIL_PICTURE")
                                $bDetailPicture = true;

                            if($arColumn["id"] == "PROPERTY_MORE_PHOTO_VALUE")
                                $bDetailPicture = true;
                        }

                        if ($bPreviewPicture || $bDetailPicture)
                            $bShowNameWithPicture = true;


                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

                            if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES", "PROPERTY_MORE_PHOTO_VALUE"))) // some values are not shown in columns in this template
                                continue;

                            if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                                continue;

                            if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
                            ?>
                                <th class="item">
                            <?
                                echo GetMessage("SALE_PRODUCTS");
                            elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
                            ?>
                                <th class="item">
                            <?
                                echo $arColumn["name"];
                            elseif ($arColumn["id"] == "PRICE"):
                            ?>
                                <th class="price">
                            <?
                                echo $arColumn["name"];
                            else:
                            ?>
                                <th class="custom">
                            <?
                                echo $arColumn["name"];
                            endif;
                            ?>
                                </th>
                        <?endforeach;?>
                    </tr>
                </thead>

                <tbody>
                    <?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):
                        //echo'<pre>';print_r($arData);echo'</pre>';
                    ?>
                    <tr>
                        <?
                        // prelimenary check for images to count column width
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
                        {
                            $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
                            if (is_array($arItem[$arColumn["id"]]))
                            {
                                foreach ($arItem[$arColumn["id"]] as $arValues)
                                {
                                    if ($arValues["type"] == "image")
                                        $imgCount++;
                                }
                            }
                        }

                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

                            $class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

                            if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES", "PROPERTY_MORE_PHOTO_VALUE"))) // some values are not shown in columns in this template
                                continue;

                            if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                                continue;

                            $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

                            if ($arColumn["id"] == "NAME"):
                                $width = 70 - ($imgCount * 20);
                            ?>
                                <td class="item">
                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                        <?
                                        if ($bShowNameWithPicture):
                                            ?>

                                                <span class="image">
                                                    <?
													$url = "";
                                                    if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
                                                        $url = $arData["data"]["PREVIEW_PICTURE_SRC"];
                                                    elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
                                                        $url = $arData["data"]["DETAIL_PICTURE_SRC"];
                                                    elseif(!empty($arData["data"]["PROPERTY_MORE_PHOTO_VALUE"])):
														if(!is_array($arData["data"]["PROPERTY_MORE_PHOTO_VALUE"])){
															$arData["data"]["PROPERTY_MORE_PHOTO_VALUE"] = array_map("trim", explode(",", $arData["data"]["PROPERTY_MORE_PHOTO_VALUE"]));
														}
														
                                                        foreach($arData["data"]["PROPERTY_MORE_PHOTO_VALUE"] as $photo){
															if(!is_array($photo) && !empty($photo)){
																$photo = array("id" => $photo);
															}
                                                            if(!empty($photo['value'])){
                                                                $url = $photo['value'];
                                                                break;
                                                            }elseif(!empty($photo['id'])){
																$url = CFile::GetPath($photo['id']);
																break;
															}
                                                        }
                                                    else:
                                                        $url = $templateFolder."/images/order_no_photo.png";
                                                    endif;?>
                                                        <img src="<?=$url?>" width="31" />

                                                </span>
                                                <?
                                                    if (!empty($arData["data"]["BRAND"])):
                                                        ?>
                                                        <div class="bx_ordercart_brand">
                                                            <img alt="" src="<?=$arData["data"]["BRAND"]?>" />
                                                        </div>
                                                    <?
                                                    endif;
                                                ?>

                                        <?
                                        endif;
                                        ?>


                                        <?=$arItem["NAME"]?>
                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>

                                    <?
                                    if ($bPropsColumn && !empty($arItem["PROPS"])):?>
                                        <div class="bx_ordercart_itemart">
                                            <?
                                            if ($bPropsColumn):
                                                foreach ($arItem["PROPS"] as $val):
                                                    echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    <?endif?>
                                    <?
                                    if (is_array($arItem["SKU_DATA"])):
                                        foreach ($arItem["SKU_DATA"] as $propId => $arProp):

                                            // is image property
                                            $isImgProperty = false;
                                            foreach ($arProp["VALUES"] as $id => $arVal)
                                            {
                                                if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
                                                {
                                                    $isImgProperty = true;
                                                    break;
                                                }
                                            }

                                            $full = (count($arProp["VALUES"]) > 5) ? "full" : "";

                                            if ($isImgProperty): // iblock element relation property
                                            ?>
                                                <div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

                                                    <span class="bx_item_section_name_gray">
                                                        <?=$arProp["NAME"]?>:
                                                    </span>

                                                    <div class="bx_scu_scroller_container">

                                                        <div class="bx_scu">
                                                            <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
                                                            <?
                                                            foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                $selected = "";
                                                                foreach ($arItem["PROPS"] as $arItemProp):
                                                                    if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                    {
                                                                        if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                            $selected = "class=\"bx_active\"";
                                                                    }
                                                                endforeach;
                                                            ?>
                                                                <li style="width:10%;" <?=$selected?>>
                                                                    <a href="javascript:void(0);">
                                                                        <span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
                                                                    </a>
                                                                </li>
                                                            <?
                                                            endforeach;
                                                            ?>
                                                            </ul>
                                                        </div>

                                                        <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                        <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                    </div>

                                                </div>
                                            <?
                                            else:
                                            ?>
                                                <div class="bx_item_detail_size_small_noadaptive <?=$full?>">

                                                    <span class="bx_item_section_name_gray">
                                                        <?=$arProp["NAME"]?>:
                                                    </span>

                                                    <div class="bx_size_scroller_container">
                                                        <div class="bx_size">
                                                            <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
                                                                <?
                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                    $selected = "";
                                                                    foreach ($arItem["PROPS"] as $arItemProp):
                                                                        if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                        {
                                                                            if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                                $selected = "class=\"bx_active\"";
                                                                        }
                                                                    endforeach;
                                                                ?>
                                                                    <li style="width:10%;" <?=$selected?>>
                                                                        <a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
                                                                    </li>
                                                                <?
                                                                endforeach;
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                        <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                    </div>

                                                </div>
                                            <?
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>
                                </td>
                            <?
                            elseif ($arColumn["id"] == "PRICE_FORMATED"):
                            ?>
                                <td class="price right">
                                    <div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
                                    <div class="old_price right">
                                        <?
                                        if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
                                            echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
                                            $bUseDiscount = true;
                                        endif;
                                        ?>
                                    </div>

                                    <?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
                                        <div style="text-align: left">
                                            <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                            <div class="type_price_value"><?=$arItem["NOTES"]?></div>
                                        </div>
                                    <?endif;?>
                                </td>
                            <?
                            elseif ($arColumn["id"] == "DISCOUNT"):
                            ?>
                                <td class="custom right">
                                    <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
                                </td>
                            <?
                            elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
                            ?>
                                <td class="itemphoto">
                                    <div class="bx_ordercart_photo_container">
                                        <?
                                        $url = "";
                                        if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
                                            $url = $arData["data"]["DETAIL_PICTURE_SRC"];

                                        if ($url == "")
                                            $url = $templateFolder."/images/no_photo.png";

                                        if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                            <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                                        <?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                    </div>
                                </td>
                            <?
                            elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED", "SUM"))):
                            if($arColumn["id"] == "SUM") {
								?>
									<td class="custom right">
										<strong><?=number_format($arItem["QUANTITY"] * $arItem["PRICE"], 2, ".", " ")?></strong>
										<?=GetMessage("CURRENCY_".$arItem["CURRENCY"]."_TITLE")?>
									</td>
								<?
							}else{
							?>
                                <td class="custom right">
                                    <?=$arItem[$arColumn["id"]]?>
                                </td>
                            <?}
                            else: // some property value

                                if (is_array($arItem[$arColumn["id"]])):

                                    foreach ($arItem[$arColumn["id"]] as $arValues)
                                        if ($arValues["type"] == "image")
                                            $columnStyle = "width:20%";
                                ?>
                                <td class="custom" style="<?=$columnStyle?>">
                                    <span><?=getColumnName($arColumn)?>:</span>
                                    <?
                                    foreach ($arItem[$arColumn["id"]] as $arValues):
                                        if ($arValues["type"] == "image"):
                                        ?>
                                            <div class="bx_ordercart_photo_container">
                                                <div class="bx_ordercart_photo" style="background-image:url('<?=$arValues["value"]?>')"></div>
                                            </div>
                                        <?
                                        else: // not image
                                            echo $arValues["value"]."<br/>";
                                        endif;
                                    endforeach;
                                    ?>
                                </td>
                                <?
                                else: // not array, but simple value
                                ?>
                                <td class="custom" style="<?=$columnStyle?>">
                                    <span><?=getColumnName($arColumn)?>:</span>
                                    <?
                                        echo $arItem[$arColumn["id"]];
                                    ?>
                                </td>
                                <?
                                endif;
                            endif;

                        endforeach;
                        ?>
                    </tr>
                    <?endforeach;?>
                </tbody>
            </table>
            <table class="summary-table">
                <tbody>
                    <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_WEIGHT_SUM")?></td>
                        <td class="custom_t2" colspan="1" class="price"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></td>
                    </tr>
                    <tr>
                        <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY")?></td>
                        <td class="custom_t2" colspan="1" class="price"><?=$arResult["ORDER_PRICE_FORMATED"]?></td>
                    </tr>
                    <?
                    if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
                    {
                        ?>
                        <tr>
                            <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</td>
                            <td class="custom_t2" colspan="1" class="price"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?></td>
                        </tr>
                    <?
                    }
                    if(!empty($arResult["TAX_LIST"]))
                    {
                        foreach($arResult["TAX_LIST"] as $val)
                        {
                            ?>
                            <tr>
                                <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
                                <td class="custom_t2" colspan="1" class="price"><?=$val["VALUE_MONEY_FORMATED"]?></td>
                            </tr>
                        <?
                        }
                    }
                    if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
                    {
                        ?>
                        <tr>
                            <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></td>
                            <td class="custom_t2" colspan="1" class="price"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></td>
                        </tr>
                    <?
                    }
                    if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
                    {
                        ?>
                        <tr>
                            <td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></td>
                            <td class="custom_t2" colspan="1" class="price"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></td>
                        </tr>
                    <?
                    }

                    if ($bUseDiscount):
                        ?>
                        <tr>
                            <td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
                            <td class="custom_t2 fwb" colspan="1" class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
                        </tr>
                        <tr>
                            <td class="custom_t1" colspan="<?=$colspan?>"></td>
                            <td class="custom_t2" colspan="1" style="text-decoration:line-through; color:#828282;"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></td>
                        </tr>
                    <?
                    else:
                        ?>
                        <tr>
                            <td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
                            <td class="custom_t2 fwb" colspan="1" class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
                        </tr>
                    <?
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
	</div>
</div>
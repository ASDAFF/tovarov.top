<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<pre>
<?
    // print_r($arResult)
 ?>
</pre>                                        
<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;

if ($normalCount > 0):
?>
	<table class="minicart-table">
		<tbody>
			<?    $i = 0;
			foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $k => $arItem):
				////if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
              ///  while($i<5): $i++;
      if($k<5):          
			?>
				<tr <?/*id="<?=$arItem["ID"]?>"*/?>>
					<?
						if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
							$url = $arItem["PREVIEW_PICTURE_SRC"];
						elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
							$url = $arItem["DETAIL_PICTURE_SRC"];
						elseif(!empty($arItem["~PROPERTY_MORE_PHOTO_VALUE"])):
							$url = CFile::GetPath(reset(explode(",",$arItem["~PROPERTY_MORE_PHOTO_VALUE"])));
						else:
							$url = $templateFolder."/images/no_photo.png";
						endif;
					?>
					<td>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<img class="image" src="<?=$url?>" alt="<?=$arItem["NAME"]?>" width="36" />
							<p>
								<?=br($arItem["NAME"], 28)?>
							</p>
						</a>
					</td>
					<td>
						<span class="number"><?=$arItem["QUANTITY"]?> <?=$arItem["MEASURE_TEXT"]?></span>
					</td>
					<td>
						<span class="price"><?=$arItem["PRICE"];?> <sup><?=GetMessage("CURRENCY_".$arItem["CURRENCY"]."_TITLE")?></sup></span>
					</td>
					<td>
						<a class="btn-remove remove-basket-btn" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=GetMessage("SALE_DELETE")?></a>
					</td>
				</tr>
				<? //endwhile;
				endif;
			endforeach;?>
		</tbody>
	</table>
    <?if(count($arResult['ITEMS']['AnDelCanBuy'])>5):?>
    <div class="cart-message">
              <p><?=GetMessage('SALE_YET')?> <?=sklonen(count($arResult["ITEMS"]["AnDelCanBuy"])-5,GetMessage('SALE_TOVAR_1'),GetMessage('SALE_TOVAR_2'),GetMessage('SALE_TOVAR_3'))?>. <a href="<?=$arParams["PATH_TO_BASKET"]?>"><?=GetMessage('SALE_BASKET')?></a></p>
    </div>
    <?endif;?>
	<div class="bottom-box">
		<a class="button" href="<?=$arParams["PATH_TO_ORDER"]?>"><?=GetMessage("SALE_ORDER")?></a>
		<div class="total">
			<p><?=GetMessage("SALE_TOTAL")?><p> <strong><?=$arResult["allSum"]?> <sup><?=GetMessage("CURRENCY_".$arItem["CURRENCY"]."_TITLE")?></sup></strong>
		</div>
	</div>
<?
endif;
?>
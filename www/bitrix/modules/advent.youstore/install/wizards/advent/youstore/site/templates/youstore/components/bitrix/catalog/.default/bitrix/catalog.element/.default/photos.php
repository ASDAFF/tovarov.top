<?
	reset($arResult['MORE_PHOTO']);
	$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
<div class="tab-content">
	<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
		<div class="bx_bigimages">
			<div class="bx_bigimages_imgcontainer">
				<?/*<span class="bx_bigimages_aligner"></span>*/?>
				<img 
					id="<? echo $arItemIDs['PICT']; ?>"
					src="<? echo $arFirstPhoto['SRC']; ?>"
					alt="<? echo $strAlt; ?>"
					title="<? echo $strTitle; ?>"
					style="max-width: 370px"
				/>
			</div>
		</div>
	<?
	
	if ($arResult['SHOW_SLIDER'])
	{
		if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
		{
			if (3 < $arResult['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = '89px';//(100/$arResult['MORE_PHOTO_COUNT']).'%';
				$strWidth = /*(25*$arResult['MORE_PHOTO_COUNT']).'%'*/ (89 * $arResult['MORE_PHOTO_COUNT'] + 18* ($arResult['MORE_PHOTO_COUNT']-1))."px";
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '89px';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
	?>
		<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
			<div class="bx_slider_scroller_container">
				<div class="bx_slide">
					<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
	<?
			foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
			{
	?>
				<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><img width="100%" style="max-height: 100%;" rel="item-images" src="<? echo $arOnePhoto['SRC']; ?>" /></span></li>
	<?
			}
			unset($arOnePhoto);
	?>
					</ul>
				</div>
				<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
				<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
			</div>
		</div>
	<?
		}
		else
		{
			foreach ($arResult['OFFERS'] as $key => $arOneOffer)
			{
				if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
					continue;
				$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
				if (4 < $arOneOffer['MORE_PHOTO_COUNT'])
				{
					$strClass = 'bx_slider_conteiner full';
					$strOneWidth = (80/$arOneOffer['MORE_PHOTO_COUNT']).'%';
					$strWidth = (25*$arOneOffer['MORE_PHOTO_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_slider_conteiner';
					$strOneWidth = '20%';
					$strWidth = '100%';
					$strSlideStyle = 'display: none;';
				}
	?>
		<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
			<div class="bx_slider_scroller_container">
				<div class="bx_slide">
					<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
	<?
				foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
				{
	?>
						<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><img width="100%" class="fancybox-mini" rel="item-images" src="<? echo $arOnePhoto['SRC']; ?>" /></span></li>
	<?
				}
				unset($arOnePhoto);
	?>
					</ul>
				</div>
				<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
				<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
			</div>
		</div>
	<?
			}
		}
	}
	?>
	</div>
</div>
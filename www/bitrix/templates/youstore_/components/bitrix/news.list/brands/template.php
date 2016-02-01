<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="brands-box">
    <ul>
        <?foreach($arResult["LETTERS"] as $let):?>
            <li><a <?if($arParams["CURRENT_LETTER"] == $let):?>class="active"<?endif?> href="<?=SITE_DIR?>brands/?letter=<?=$let?>"><?=$let?></a></li>
        <?endforeach;?>
    </ul>
</div>

<?
if(!empty($arResult["ITEMS"])):?>
	<div class="brand-items">
		<?foreach($arResult["ITEMS"] as $index => $arItem):
			if(empty($arItem["PREVIEW_PICTURE"]["SRC"])){
				$arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
			}
		?>
			<div class="item">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])):
                        $photo = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array("width" => 180, "height" => 80));
                        $arItem["PREVIEW_PICTURE"]["SRC"] = $photo['src'];
                        ?>
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>">
                    <?endif?>
					<span><?=$arItem["NAME"]?></span>
                </a>
			</div>
		<?endforeach;?>
	</div>
<?else:?>
	<p><?=GetMessage('NOBRANDS')?></p><br/>
<?endif?>

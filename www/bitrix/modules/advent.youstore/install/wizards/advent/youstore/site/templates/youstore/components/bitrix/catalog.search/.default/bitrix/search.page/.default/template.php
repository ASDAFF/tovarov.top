<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);?>
<form class="side-search" action="" method="get">
	<fieldset>
		<input class="text" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
		<input class="submit" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
	</fieldset>
</form>

<?if(!empty($arResult["SECTIONS"])):
    $all_cnt = 0;
    foreach($arResult["SECTIONS"] as $s_cnt) $all_cnt += $s_cnt;
    ?>
    <div class="cats-filter">
        <h2 class="side-title"><?=GetMessage('SEARCH_CATEGORIES')?> <span><?=intval($all_cnt)?> <?=GetMessage('SEARCH_PRODUCTS')?></span></h2>
        <ul class="cats-list">
            <?foreach($arResult["SECTIONS"] as $s_id=>$s_cnt):?>
                <?
                $dbSect = CIBlockSection::GetByID($s_id);
                    if($rsSect = $dbSect->GetNext()):
                ?>
                    <li><a href="<?=SITE_DIR?>search/?SECTION_ID=<?=$rsSect["ID"]?>&q=<?=$arResult["REQUEST"]["QUERY"]?><?//=$rsSect["SECTION_PAGE_URL"]?>"><?=$rsSect["NAME"]?></a> <span>(<?=$s_cnt?>)</span></li>
                <?endif?>
            <?endforeach?>
        </ul>
    </div>
<?endif?>

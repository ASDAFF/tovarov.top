<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
if(!empty($arResult["SECTIONS"])){
?>
    <div class="cats-filter">
        <h2 class="side-title"><?=GetMessage('CAT_CAT')?></h2>
        <ul class="cats-list">
        <?
            foreach($arResult['SECTIONS'] as $arSection){
                ?>
                    <li <?if($arParams["ACTIVE_SECTION_CODE"] == $arSection["CODE"]):?>class="active"<?endif?>><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?> (<?=intval($arSection["ELEMENT_CNT"])?>)</a></li>
                <?
            }
        ?>
        </ul>
    </div>
	<?
}
?>
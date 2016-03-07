<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$arResult['FORM_ACTION']=str_replace('index.php','',$arResult['FORM_ACTION']);
//test_dump($arResult)?>
<?CJSCore::Init(array("fx"));?>
<?require_once($_SERVER["DOCUMENT_ROOT"] . $templateFolder. "/functions.php"); ?>
<h2 class="side-title"><?=GetMessage('CT_BCSF_FILTER_TITLE')?></h2>
<?
    $arResult["FORM_ACTION"] = rtrim(str_replace("ajax_filter=y", "", $arResult["FORM_ACTION"]), "?& ");
?>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" method="get" id="filter_form">
	<fieldset>
		<?foreach($arResult["HIDDEN"] as $arItem):
            if($arItem["CONTROL_NAME"] == "ajax_filter") continue;
            ?>
			<input
				type="hidden"
				name="<?echo $arItem["CONTROL_NAME"]?>"
				id="<?echo $arItem["CONTROL_ID"]?>"
				value="<?echo $arItem["HTML_VALUE"]?>"
			/>
		<?endforeach;?>
		<?foreach($arResult["ITEMS"] as $key=>$arItem):
			if ($arItem['CODE']=="CALIBER") $step=0.1; else $step=null;
			$num=$key;
			$key = md5($key);
			?>
			<?if(isset($arItem["PRICE"]) or $arItem["PROPERTY_TYPE"] == "N"):?>
				<?
				if (!is_set($arItem["VALUES"]["MIN"]["VALUE"]) || !is_set($arItem["VALUES"]["MAX"]["VALUE"]) || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
					continue;


				$min= is_set($arItem["VALUES"]["MIN"]["FILTERED_VALUE"])?$arItem["VALUES"]["MIN"]["FILTERED_VALUE"]:$arItem["VALUES"]["MIN"]["VALUE"];
				$max= is_set($arItem["VALUES"]["MAX"]["FILTERED_VALUE"])?$arItem["VALUES"]["MAX"]["FILTERED_VALUE"]:$arItem["VALUES"]["MAX"]["VALUE"];
				?>
				<div class="filter box">
					<div class="title"><h3><?=$arItem['NAME']?>:</h3></div>
					<div class="range-box">
						<div id="slider_<?=$num?>"></div>
						<div class="slider-row">
							<div class="slider-cell">
								<input
									class="minCost_<?=$num?> text"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $min?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/>
							</div>
							<div class="slider-cell">
								<label for="maxCost"><?=GetMessage('CT_BCSF_FILTER_TO')?></label>
								<input
									class="maxCost_<?=$num?> text"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $max?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/>
							</div>
						</div>
					</div>
					<script>
						$(function(){
							priceSliderInit(
								'<?=$num?>',
								<?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
								<?=$arItem["VALUES"]["MAX"]["VALUE"]?>,
								<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] ?: $arItem["VALUES"]["MIN"]["VALUE"]?>,
								<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] ?: $arItem["VALUES"]["MAX"]["VALUE"]?>
								<?=is_set($step)?','.$step:''?>
							);
						});
					</script>
				</div>
			<?endif?>
		<?endforeach?>
		
		<?foreach($arResult["ITEMS"] as $key => $arItem):?>
			<?if($arItem["PROPERTY_TYPE"] == "N" ):
				continue;
			?>
			<?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
				<?	
					$boxClass = "sizes";
					
					if($arItem["CODE"] == "MANUFACTURER"){
						$boxClass = "brands";
					}
					
					if(!empty($arItem["USER_TYPE_SETTINGS"]) && !empty($arItem["USER_TYPE_SETTINGS"]["TABLE_NAME"])){
						$boxClass = "colors";
					}
				?>
				
				<div class="<?=$boxClass?> box">
					<div class="title">
						<h3><?=$arItem["NAME"]?>: </h3>
						<?/*<a href="#" class="link-all">������� ����</a>*/?>
					</div>

					<?
						switch($boxClass){
							case 'colors':
								$ulClass = "colors-choose";
							break;
							case 'brands':
								$ulClass = "";
							break;
							case 'sizes':
							default:
								$ulClass = "size-choose";
							break;
						}
					?>
					<?if(empty($ulClass)):?>
						<div class="brands-list">
					<?endif?>
					<ul class="<?=$ulClass?>">
						<?
						$valCnt = 0;
						if($boxClass == "colors"){
							// ���������� ������
							/*if(	
								CModule::IncludeModule('iblock') &&
								CModule::IncludeModule('highloadblock')){*/
								//CIBlockPriceTools::checkPropDirectory($arItem, true);
							/*}*/
							getPropDirectory($arItem);
							//echo'<pre>';print_r($arItem);echo'</pre>';
						}
						
						foreach($arItem["VALUES"] as $val => $ar):?>
							<li>
								<?if($arItem["PICTURE_INCLUDED"]):?>
                                    <?if(empty($ar["PICTURE"])) continue;?>
									<a class="color-pick <?echo $ar["CHECKED"]? 'active': ''?> <?if ($ar["DISABLED"]):?>disabled-color<?endif?> <?if($ar["UF_DARK_COLOR"]):?>dark-color<?endif?>" data-name="<?echo $ar["CONTROL_NAME"]?>" onclick="javascript:void(0)" style="background-image: url('<?=$ar["PICTURE"]?>')"><span></span><?=$ar["VALUE"]?></a></a>
                                    <input
										class="hidden"
										type="checkbox"
										value="<?echo $ar["HTML_VALUE"]?>"
										name="<?echo $ar["CONTROL_NAME"]?>"
										id="<?echo $ar["CONTROL_ID"]?>"
										<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
										onchange="smartFilter.click(this)"
										<?if ($ar["DISABLED"]):?>disabled<?endif?>
									/>
								<?else:?>
									<input
										type="checkbox"
										value="<?echo $ar["HTML_VALUE"]?>"
										name="<?echo $ar["CONTROL_NAME"]?>"
										id="<?echo $ar["CONTROL_ID"]?>"
										<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
										onchange="smartFilter.click(this)"
										<?if ($ar["DISABLED"]):?>disabled<?endif?>
									/>
									<label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>
								<?endif?>
							</li>
						<?$valCnt++;endforeach;?>
					</ul>
					<?if(empty($ulClass)):?>
						</div>
					<?endif?>
				</div>
			<?endif;?>

		<?endforeach;?>
		<input type="submit" id="set_filter" class="button filter-apply" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" action="<?=$arResult['SEF_SET_FILTER_URL']?>"/>
		<input type="submit" id="del_filter" class="button filter-apply" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" action="<?=$arResult['SEF_DEL_FILTER_URL']?>"/>
	</fieldset>
</form>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
	
	$(function(){
		/*$('body').on('click', '.color-pick', function(){
			var name = $(this).data('name'),
				$check = $('[name='+ name +']'),
				checkState = !($check.is(':checked')),
				disabled = $(this).hasClass('disabled-color');
			
			console.log(name, $check, checkState, disabled);
			
			if(!disabled){
				$(this).toggleClass('active');
                //$check.attr('checked', checkState);
                $check.click();
			}
		});*/
        $('.color-pick').click(function(){
            var name = $(this).data('name'),
                $check = $('[name='+ name +']'),
                checkState = !($check.is(':checked')),
                disabled = $(this).hasClass('disabled-color');

            console.log(name, $check, checkState, disabled);

            if(!disabled){
                $(this).toggleClass('active');
                //$check.attr('checked', checkState);
                $check.click();
            }
        });
	});
</script>
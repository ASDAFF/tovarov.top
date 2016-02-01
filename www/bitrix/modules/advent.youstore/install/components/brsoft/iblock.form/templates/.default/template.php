<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="brsoft-tab-cell">
	<?if(!empty($arResult["ERROR_MESSAGE"]))
	{
		foreach($arResult["ERROR_MESSAGE"] as $v)
			ShowError($v);
	}
	if(strlen($arResult["OK_MESSAGE"]) > 0)
	{
		echo $arResult["OK_MESSAGE"];
	}
	?>
	<form id="brsoft-form" name="brsoft-form" action="<?=$APPLICATION->GetCurPage(false)?>" method="POST" enctype="multipart/form-data">
		<fieldset>
			<?=bitrix_sessid_post();$cnt = 1;?>
			<table class="brsoft-main-table">
				<?foreach($arResult["FIELDS"] as $f):?>
					<tr>
						<td>
							<label>
								<?=$cnt?>. <?=$f["NAME"]?>
							</label>
						</td>
						<td>
							<div>
								<?switch($f["INPUT_TYPE"]){
									case 'E':case 'G': ?>
										<select  <?if($f["MULTIPLE"] == "Y"):?>multiple<?endif?>  name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>">
											<option value=""><?=GetMessage("BRSOFT_FC_DEFAULT_OPTION")?></option>
											<?
											foreach($f["VALUES"] as $k => $v){
												?>
													<option value="<?=$k?>"><?=$v?></option>
												<?
											}?>
										</select>
									<?break;
									case 'C':
										foreach($f["VALUES"] as $k => $v){
											?>
											<input  
												<?if($f["MULTIPLE"] == "Y"):?>
													<?if(in_array($k, $_POST[$f["CODE"]])):?>checked="checked"<?endif?>
												<?else:?>
													<?if($_POST[$f["CODE"]] == $k):?>checked="checked"<?endif?>
												<?endif?>
												type="<?if($f["MULTIPLE"] == "Y"):?>checkbox<?else:?>radio<?endif?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$k?>">
												<label><?=$v?></label></br>
										<?}
									break;
									case 'L':?>
										<select <?if($f["MULTIPLE"] == "Y"):?>multiple<?endif?>  name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>">
											<?
											foreach($f["VALUES"] as $k => $v){
												?>
													<option <?if($f["MULTIPLE"] == "Y"):?><?if(in_array($k,$_POST[$f["CODE"]])):?>selected="selected"<?endif?><?else:?><?if($_POST[$f["CODE"]] == $k):?>selected="selected"<?endif?><?endif?> value="<?=$k?>"><?=$v?></option>
												<?
											}?>
										</select><?
									break;
									case 'T':case 'H':
											if(!empty($_REQUEST[$f["CODE"]])):
												if(!is_array($_REQUEST[$f["CODE"]])) $_REQUEST[$f["CODE"]] = array($_REQUEST[$f["CODE"]]);
											?>
												<?foreach ($_REQUEST[$f["CODE"]] as $v):?>
													<textarea  placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" class="brsoft-textarea"><?=$v?></textarea>
												<?endforeach?>
											<?else:?>
												<textarea  placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" class="brsoft-textarea"><?=$_REQUEST[$f["CODE"]]?></textarea>
											<?endif?>
											<?if($f["MULTIPLE"] == "Y"):?>
												<input type="button" href="javascript:void(0)" class="brsoft-add-fields" id="addBtn<?=$f["CODE"]?>" value="+">
											<?endif;
									break;
									case 'D':
										if(!empty($_REQUEST[$f["CODE"]])):?>
											<?if(is_array($_REQUEST[$f["CODE"]])):?>
												<?foreach ($_REQUEST[$f["CODE"]] as $key=>$v):?>
													<input  type="text" class="brsoft-date-input" placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$v?>">
													<img src="/bitrix/js/main/core/images/calendar-icon.gif" class="brsoft-calendar-icon" />
												<?endforeach?>
											<?else:?>
												<input type="text" class="brsoft-date-input" placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?>" value="<?=$_REQUEST[$f["CODE"]]?>">
												<img src="/bitrix/js/main/core/images/calendar-icon.gif" class="brsoft-calendar-icon" />
											<?endif?>
										<?else:?>
											<input  type="text" id="<?=$f["CODE"]?>" class="brsoft-date-input" placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$_REQUEST[$f["CODE"]]?>">
											<img src="/bitrix/js/main/core/images/calendar-icon.gif" class="brsoft-calendar-icon" />  
										<?
										endif;
										if($f["MULTIPLE"] == "Y"):?>
											<input type="button" href="javascript:void(0)" class="brsoft-add-fields" id="addBtn<?=$f["CODE"]?>" value="+">
										<?endif;
									break;
									case 'F':
										?><input  type="file" class="brsoft-text" placeholder="<?=$f["HINT"]?>" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$_REQUEST[$f["CODE"]]?>">
										<?if($f["MULTIPLE"] == "Y"):?>
											<input type="button" href="javascript:void(0)" class="brsoft-add-fields" id="addBtn<?=$f["CODE"]?>" value="+">
										<?endif;
									break;
									case 'S':
									default:
										if(!empty($_REQUEST[$f["CODE"]])):
											if(!is_array($_REQUEST[$f["CODE"]])) $_REQUEST[$f["CODE"]] = array($_REQUEST[$f["CODE"]]);
										?>
											<?foreach ($_REQUEST[$f["CODE"]] as $v):?>
												<input  placeholder="<?=$f["HINT"]?>" type="text" class="brsoft-text" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$v?>">
											<?endforeach?>
										<?else:?>
											<input  placeholder="<?=$f["HINT"]?>" type="text" class="brsoft-text" name="<?=$f["CODE"]?><?if($f["MULTIPLE"] == "Y"):?>[]<?endif?>" value="<?=$_REQUEST[$f["CODE"]]?>">
										<?endif?>
										<?if($f["MULTIPLE"] == "Y"):?>
											<input type="button" href="javascript:void(0)" class="brsoft-add-fields" id="addBtn<?=$f["CODE"]?>" value="+">
										<?endif;
									break;
								}?>
							</div>
						</td>
					</tr>
				<?$cnt++;
				endforeach;?>
					<tr>
						<?if($arParams["USE_CAPTCHA"] == "Y"):?>
								<td>
									
									<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
								</td>
								<td>
									<input type="text" data-validation="required" class="brsoft-text" name="captcha_word" size="30" maxlength="50" value="">
								</td>
						<?endif;?>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
							<input type="submit" name="submit" class="submit" value="<?=GetMessage("BRSOFT_FC_SUBMIT")?>">
						</td>
						<td>
							<input type="reset" class="reset" value="<?=GetMessage("BRSOFT_FC_RESET")?>">
						</td>
					</tr>
			</table>
		</fieldset>
	</form>
</div>
<script>
	BX(function(){
		var addFieldsButtons = BX.findChildren(document.body, {'className': 'brsoft-add-fields'}, true);
		window.addFieldsButtonsObj = [];
		for(var i in addFieldsButtons){
			var addFieldsPrev = BX.findPreviousSibling(addFieldsButtons[i], {"tag" : "input"});
			if(addFieldsPrev === null){
				addFieldsPrev = BX.findPreviousSibling(addFieldsButtons[i], {"tag" : "textarea"});
			}
			var type = addFieldsPrev.type;
			var name = addFieldsPrev.getAttribute('name');
			var className = addFieldsPrev.getAttribute('class');
			window.addFieldsButtonsObj[i] = new brAddField({'self': addFieldsButtons[i], 'parentBox': BX(addFieldsButtons[i].parentNode), 'inputType': type, 'name': name ,'className': className});
			
		}
		var addDateFields = BX.findChildren(document.body, {'className': 'brsoft-date-input'}, true);
		for(var i in addDateFields){
			BX.bind(BX(addDateFields[i]),
			'click',
				function(){
					BX.calendar({node: this, field: this.id, form: 'brsoft-form', bTime: 'true', currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: 'true'})
				}
			)
		} 
	});
	BX.ready(
        BX.defer(function(){
			for(var i in window.addFieldsButtonsObj){
				window.addFieldsButtonsObj[i].bindEvents();
			}
		})
	);
</script>
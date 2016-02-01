<?
CModule::IncludeModule("iblock");
if(!empty($_POST['template_color_submit']) && strlen($_POST['template_color_theme'])>0){
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_COLOR");
	$arFilter = Array("IBLOCK_CODE"=>"color_theme", "CODE"=>"template_color_theme");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$element_id = $arFields['ID'];
		$iblock_id = $arFields['IBLOCK_ID'];
		$arProps = $ob->GetProperties();
	}
	$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "CODE"=>"COLOR"));
	while($enum_fields = $property_enums->GetNext())
	{
		if($enum_fields['XML_ID']==$_POST['template_color_theme']){
			$property_enum_id = intval($enum_fields['ID']);
		}
	}
	if($element_id>0 && $property_enum_id>0){
		CIBlockElement::SetPropertyValuesEx($element_id, false, array('COLOR' => $property_enum_id));
	}
}

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_COLOR");
$arFilter = Array("IBLOCK_CODE"=>"color_theme", "CODE"=>"template_color_theme");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arProps = $ob->GetProperties();
}
if(strlen($arProps['COLOR']['VALUE_XML_ID'])>0){
	$template_color_theme = $arProps['COLOR']['VALUE_XML_ID'];
}
if(isset($template_color_theme) && strlen($template_color_theme)>0){
	switch ($template_color_theme) {
		case 'red':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#ea543f',
						'@btn-border'		: '#d44031',
						'@btn-hover'		: '#e14233',
						'@btn-border-hover'	: '#c24f43',
						'@transparent'		: 'rgba(234,84,63,0.75)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'orange':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#eb642d',
						'@btn-border'		: '#e24e37',
						'@btn-hover'		: '#e05322',
						'@btn-border-hover'	: '#d63a1c',
						'@transparent'		: 'rgba(235,100,45,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'yellow':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#f49e3a',
						'@btn-border'		: '#e28222',
						'@btn-hover'		: '#f18921',
						'@btn-border-hover'	: '#e57510',
						'@transparent'		: 'rgba(244,158,58,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'violet':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#634494',
						'@btn-border'		: '#47377f',
						'@btn-hover'		: '#543b89',
						'@btn-border-hover'	: '#422f7a',
						'@transparent'		: 'rgba(99,68,148,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'green':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#4f9c63',
						'@btn-border'		: '#388246',
						'@btn-hover'		: '#428c50',
						'@btn-border-hover'	: '#377c43',
						'@transparent'		: 'rgba(79,156,99,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'blue':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#436daf',
						'@btn-border'		: '#325f96',
						'@btn-hover'		: '#2463a1',
						'@btn-border-hover'	: '#145992',
						'@transparent'		: 'rgba(67,109,175,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
		case 'cyan':
			?><script type="text/javascript">
					less.modifyVars({
						'@btn-color'		: '#26afae',
						'@btn-border'		: '#1f9a94',
						'@btn-hover'		: '#0d9f9b',
						'@btn-border-hover'	: '#04918a',
						'@transparent'		: 'rgba(38,175,174,0.85)'
					});
					less.refreshStyles();
			</script><?
			break;
	}
}
?>
<?global $USER; 
if ($USER->IsAdmin()){?>
	<div class="tweak-bar">
		<a href="#" class="tweak-btn">tweak</a>
		<div class="tweak-box">
			<ul class="colors">
				<li><a href="#" class="color-1" onclick="$('#template_color_theme').val('red');">color-1</a></li>
				<li><a href="#" class="color-2" onclick="$('#template_color_theme').val('orange');">color-2</a></li>
				<li><a href="#" class="color-3" onclick="$('#template_color_theme').val('yellow');">color-3</a></li>
				<li><a href="#" class="color-4" onclick="$('#template_color_theme').val('violet');">color-4</a></li>
				<li><a href="#" class="color-5" onclick="$('#template_color_theme').val('green');">color-5</a></li>
				<li><a href="#" class="color-6" onclick="$('#template_color_theme').val('blue');">color-6</a></li>
				<li><a href="#" class="color-7" onclick="$('#template_color_theme').val('cyan');">color-7</a></li>
			</ul>
			<a href="javascript:void(0);" class="btn-save" onclick="$('#template_color_submit').click();">Сохранить</a>
			<form action="" method="post">
				<input type="hidden" name="template_color_theme" id="template_color_theme" value="">
				<input type="submit" name="template_color_submit" value="Отправить" id="template_color_submit" style="display:none;">
			</form>
		</div>
	</div>
	<?
}?>
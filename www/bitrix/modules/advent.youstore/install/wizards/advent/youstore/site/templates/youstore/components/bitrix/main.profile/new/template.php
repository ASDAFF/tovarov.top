<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
    
$this->setFrameMode(true);?>
<div class="tab general" id="acc-1">
	<div class="title">
		<h2><?=GetMessage('PROFILE_TITLE')?></h2>
	</div>
	<div class="profiles-list">
		<? foreach($arResult["DELIVERY_ADDR"] as $index => $delivery){
			$email=""; $adres=""; $phone=""; $f_name=""; $name=""; $last_name=""; $location=array();
			$email_id=""; $adres_id=""; $phone_id=""; $f_name_id=""; $name_id=""; $last_name_id=""; $city_id="";
		?>
			<div class="profile-item">
                  <div class="item-holder">
                    <div class="main-info">
                      <h2>
					  	<?foreach($delivery["PROPS"] as $prop):
                        if($prop['PROP_CODE']=='FIO'){
                            
                            echo $prop['VALUE'];
                            $fio=explode(' ', $prop['VALUE']);
                            $f_name=$fio[2]; $f_name_id=$prop["ID"];
                            $name=$fio[0]; $name_id=$prop["ID"];
                            $last_name=$fio[1]; $last_name_id=$prop["ID"];
                        }
                        endforeach;
                        ?> 
						
					  </h2>
                      <p>
					  <? foreach($delivery["PROPS"] as $prop){
							if($prop["NAME"]==GetMessage('PROFILE_MESTO')){
								echo $prop["VALUE_"]["COUNTRY_NAME_LANG"].", ";
								if($prop["VALUE_"]["REGION_NAME_LANG"]) echo $prop["VALUE_"]["REGION_NAME_LANG"].", ";
								echo $prop["VALUE_"]["CITY_NAME_LANG"];
								$location=$prop["VALUE_"];
								$city_id=$prop["ID"];
							}
                    	}?>
					  </p>
                    </div>
                    <div class="links">
                      <a href="#popup_<?=$delivery["ID"]?>" class="profile-edit"><?=GetMessage('PROFILE_EDIT')?></a>
                      <a href="?action=delete&id=<?=$delivery["ID"]?>" class="profile-delete"><?=GetMessage('PROFILE_DEL')?></a>
                    </div>
                    <div class="add-info">
                      <div class="item-holder">
                        <ul>
							<?foreach($delivery["PROPS"] as $prop):?>
								<? if($prop["NAME"]==GetMessage('PROFILE_ADDR') ):?>
									<? $adres=$prop["VALUE"]; $adres_id=$prop["ID"]; ?>
									<? if($prop["VALUE"]):?>
									 	<li><?=$prop["VALUE"]?></li>
									<? endif;?>
								<? endif;?>
                    		<?endforeach;?>
							<?foreach($delivery["PROPS"] as $prop):?>
								<? if($prop["NAME"]==GetMessage('PROFILE_PHONE') ):?>
									<? $phone=$prop["VALUE"];  $phone_id=$prop["ID"];?>
									<? if($prop["VALUE"]):?>
									 	<li><?=$prop["VALUE"]?></li>
									<? endif;?>
								<? endif;?>
                    		<?endforeach;?>
							<?foreach($delivery["PROPS"] as $prop):?>
								<? if($prop["NAME"]=="Email" ):?>
									<? $email=$prop["VALUE"]; $email_id=$prop["ID"]; ?>
									<? if($prop["VALUE"]):?>
									 	<li><a href="mailto:<?=$prop["VALUE"]?>"><?=$prop["VALUE"]?></a></li>
									<? endif;?>
								<? endif;?>
                    		<?endforeach;?>
                        </ul>
                      </div>
                    </div>
                  </div>
				  
	<div class="popup popup-edit" id="popup_<?=$delivery["ID"]?>" >
    <div class="holder">
      <a href="#" class="btn-close">close</a>
      <div class="title">
        <h2><?=GetMEssage('PROFILE_EDIT_TITLE')?></h2>
      </div>
      <form class="popup-form" >
	  	<input name="action" value="update" type="hidden" />
		<input name="id" value="<?=$delivery["ID"]?>" type="hidden" />
        <fieldset>
          <div class="row">
            <input type="text" class="text" name="name" value="<?=$name?>" placeholder="<?=GetMEssage('NAME1')?>" />
			<input name="name_id" value="<?=$name_id?>" type="hidden" />
          </div>
          <div class="row">
            <input type="text" class="text" name="f_name" value="<?=$f_name?>" placeholder="<?=GetMEssage('LAST_NAME')?>" />
			<input name="f_name_id" value="<?=$f_name_id?>" type="hidden" />
          </div>
          <div class="row">
            <input type="text" class="text" name="last_name" value="<?=$last_name?>" placeholder="<?=GetMEssage('SECOND_NAME')?>" />
			<input name="last_name_id" value="<?=$last_name_id?>" type="hidden" />
          </div>
          <div class="row">
            <input type="text" class="text" name="email" value="<?=$email?>" placeholder="<?=GetMEssage('EMAIL')?>" />
			<input name="email_id" value="<?=$email_id?>" type="hidden" />
          </div>
          <div class="row">
            <input type="text" class="text" name="phone" value="<?=$phone?>" placeholder="<?=GetMEssage('PHONE')?>" />
			<input name="phone_id" value="<?=$phone_id?>" type="hidden" />
          </div>
          <div class="row">
			<select name="country">
			<option value=""><?=GetMEssage("PROFILE_COUNTRY")?></option>
			<?
			$db_vars = CSaleLocation::GetCountryList(Array("NAME_LANG"=>"ASC"));
			while ($vars = $db_vars->Fetch()):
			  ?>
			  <option  value="<?=$vars["ID"]?>" <? if($location["COUNTRY_ID"]==$vars["ID"])echo 'selected="selected"';?> ><?=$vars["NAME"]?></option>
			  <?
		   endwhile;
			?>
			</select>
        
          </div>
          <div class="row" <? if($location["REGION_ID"]=="")echo 'style="display:block;"';?> >
            <select name="region">
              <? if($location["REGION_ID"]):?>
			  <option value=""><?=GetMEssage("PROFILE_REGION")?></option>
			  	<?
				$db_vars = CSaleLocation::GetList(Array("REGION_NAME"=>"ASC"), array("REGION_ID"=>$location["REGION_ID"], "LID" => LANGUAGE_ID));
				while ($vars = $db_vars->Fetch()):
					if($vars["REGION_NAME"]=="") continue;
				  ?>
				  <option  value="<?=$vars["REGION_ID"]?>" <? if($location["REGION_ID"]==$vars["REGION_ID"])echo 'selected="selected"';?> ><?=$vars["REGION_NAME"]?></option>
				  <?
			   endwhile;
				?>
			  <? endif;?>
            </select>
          </div>
          <div class="row">
		  	<input name="city_id" value="<?=$city_id?>" type="hidden" />
            <select name="city">
             <? if($location["CITY_ID"]):?>
			 	<option value=""><?=GetMEssage("PROFILE_CITY")?></option>
			  	<?
				$db_vars = CSaleLocation::GetList(Array("CITY_NAME_LANG"=>"ASC"), array("COUNTRY_ID"=>$location["COUNTRY_ID"], "LID" => LANGUAGE_ID));
				while ($vars = $db_vars->Fetch()):
					if($vars["CITY_NAME"]=="") continue;
				  ?>
				  <option  value="<?=$vars["ID"]?>" <? if($location["CITY_ID"]==$vars["CITY_ID"])echo 'selected="selected"';?> ><?=$vars["CITY_NAME"]?></option>
				  <?
			   endwhile;
				?>
			  <? endif;?>
            </select>
          </div>
          <div class="row">
            <input type="text" name="adres" class="text" value="<?=$adres?>" placeholder="<?=GetMEssage('PROFILE_ADDR')?>" />
			<input name="adres_id" value="<?=$adres_id?>" type="hidden" />
          </div>
          <div class="row">
            <input type="submit" class="submit button" value="<?=GetMEssage('SAVE')?>" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  
                </div>

         <?}?>
		 
                <div class="add-item profile-item">
                  <div class="item-holder">
                    <a href="#" class="add-link"><span><?=GetMEssage('PROFILE_ADDPROFILE')?></span></a>
                  </div>
                </div>
     </div>
</div>


 <div class="popup add-profile">
    <div class="holder">
      <a href="#" class="btn-close">close</a>
      <div class="title">
        <h2><?=GetMEssage('PROFILE_ADDPROFILE_TITLE')?></h2>
      </div>
      <form class="popup-form" >
	  	<input name="action" value="add" type="hidden" />
        <fieldset>
          <div class="row">
            <input type="text" class="text" name="name" value="" placeholder="<?=GetMEssage('NAME1')?>" />
          </div>
          <div class="row">
            <input type="text" class="text" name="f_name" value="" placeholder="<?=GetMEssage('LAST_NAME')?>" />
          </div>
          <div class="row">
            <input type="text" class="text" name="last_name" value="" placeholder="<?=GetMEssage('SECOND_NAME')?>" />
          </div>
          <div class="row">
            <input type="text" class="text" name="email" value="" placeholder="<?=GetMEssage('EMAIL')?>" />
          </div>
          <div class="row">
            <input type="text" class="text" name="phone" value="" placeholder="<?=GetMEssage('PHONE')?>" />
          </div>
          <div class="row">
		  	<select name="country">
			<option value=""><?=GetMEssage("PROFILE_COUNTRY")?></option>
			<?
			$db_vars = CSaleLocation::GetCountryList(Array("NAME_LANG"=>"ASC"));
			while ($vars = $db_vars->Fetch()):
			  ?>
			  <option  value="<?=$vars["ID"]?>" ><?=$vars["NAME"]?></option>
			  <?
		   endwhile;
			?>
        	</select>
          </div>
          <div class="row">
            <select name="region">
            </select>
          </div>
          <div class="row">
            <select name="city">
            </select>
          </div>
          <div class="row">
            <input type="text" name="adres" class="text" value="" placeholder="<?=GetMessage('PROFILE_ADDR')?>" />
          </div>
          <div class="row">
            <input type="submit" class="submit button" value="<?=GetMessage('PROFILE_ADD')?>" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
 
<script type="text/javascript">
$(document).ready(function(){
	// add profile popup
  jQuery('.add-item .add-link').click(function(e) {
    e.preventDefault();
    jQuery('.popup.add-profile').bPopup({
      closeClass: 'btn-close',
      modalColor: '#fff',
      onOpen: function() {
      	jQuery('.popup-form input, .popup-form select').styler(); 
      }
    });
  });
  
  // profile edit 
  $('.profile-item a.profile-edit').click(function(e){
		e.preventDefault();
		
		$id = $(this).attr('href');

		jQuery($id).bPopup({
			 closeClass: 'btn-close',
			  modalColor: '#fff',
			  onOpen: function() {
				jQuery($id).find('.popup-form input, .popup-form select').styler(); 
			  }
		});
	});
	
	$('.popup-form select[name=country]').change(function(){
		var elem=$(this);
		$.post("<?=$this->GetFolder()?>/get_city.php", {
				country_id: $(this).val()
				}, function(d) {
					$(elem).parents('.popup-form:first').find('select[name=city]').html(d).trigger('refresh');

		});
		$.post("<?=$this->GetFolder()?>/get_region.php", {
				country_id: $(this).val()
				}, function(d) {
					$(elem).parents('.popup-form:first').find('select[name=region]').html(d).trigger('refresh');
		});
		 
	});
	
	$('.popup-form select[name=region]').change(function(){
		var elem=$(this);
		var country=$(this).parents('.popup-form:first').find('select[name=country]').val();
		$.post("<?=$this->GetFolder()?>/get_city.php", {
				region_id: $(this).val(),
				country_id: country
				}, function(d) {
					$(elem).parents('.popup-form:first').find('select[name=city]').html(d).trigger('refresh');

		});
	});
  
});

</script>

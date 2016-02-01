<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["PERSON_TYPE"]) > 1)
{
    $currentOrderStep++;
    ?>
    <div class="step">
        <div class="title">
            <div class="step-label">
                <div class="label-holder">
                    <strong><?=$currentOrderStep?></strong>
                    <p><?=GetMessage('SOA_TEMPL_SHAG')?></p>
                </div>
            </div>
            <h2><?=strtoupper(GetMessage("SOA_TEMPL_PERSON_TYPE"))?></h2>
        </div>
        <div class="holder">
            <div class="account-type">
                <?foreach($arResult["PERSON_TYPE"] as $v):?>
                    <div class="row">
                        <input type="radio" class="radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> onClick="submitForm()">
                        <label for="PERSON_TYPE_<?=$v["ID"]?>"><?=$v["NAME"]?></label>
                    </div>
                <?endforeach;?>
            </div>
        </div>
        <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
        <script>
            $(function(){
                $(document.body).on('change', '.account-type input[type=radio]', function(){submitForm();});
            });
        </script>
    </div>
    <?
}
else
{
    if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
    {
        //for IE 8, problems with input hidden after ajax
        ?>
        <span style="display:none;">
            <input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
            <input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
        </span>
        <?
    }
    else
    {
        foreach($arResult["PERSON_TYPE"] as $v)
        {
            ?>
            <input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
            <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
            <?
        }
    }
}
?>
<span class="title">О нашем магазине:</span>
<?
    $APPLICATION->IncludeComponent("bitrix:menu","aside",Array(
            "ROOT_MENU_TYPE" => "top", 
            "MAX_LEVEL" => "1", 
            "CHILD_MENU_TYPE" => "top", 
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "Y",
            "MENU_CACHE_TYPE" => "N", 
            "MENU_CACHE_TIME" => "3600", 
            "MENU_CACHE_USE_GROUPS" => "Y", 
            "MENU_CACHE_GET_VARS" => "" 
        )
    );
?>
<?/*
<span class="title">Акции и скидки:</span>
<?
    $APPLICATION->IncludeComponent("bitrix:menu","aside",Array(
            "ROOT_MENU_TYPE" => "sales", 
            "MAX_LEVEL" => "1", 
            "CHILD_MENU_TYPE" => "sales", 
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "Y",
            "MENU_CACHE_TYPE" => "N", 
            "MENU_CACHE_TIME" => "3600", 
            "MENU_CACHE_USE_GROUPS" => "Y", 
            "MENU_CACHE_GET_VARS" => "" 
        )
    );
?>*/?>

<span class="title">Сервисы:</span>
<?
    $APPLICATION->IncludeComponent("bitrix:menu","aside",Array(
            "ROOT_MENU_TYPE" => "services", 
            "MAX_LEVEL" => "1", 
            "CHILD_MENU_TYPE" => "services", 
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "Y",
            "MENU_CACHE_TYPE" => "N", 
            "MENU_CACHE_TIME" => "3600", 
            "MENU_CACHE_USE_GROUPS" => "Y", 
            "MENU_CACHE_GET_VARS" => "" 
        )
    );
?>
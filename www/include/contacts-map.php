<?$APPLICATION->IncludeComponent(
    "bitrix:map.google.view",
    ".default",
    array(
        "COMPONENT_TEMPLATE" => ".default",
        "INIT_MAP_TYPE" => "ROADMAP",
        "MAP_DATA" => "a:4:{s:10:\"google_lat\";d:55.819707342668885;s:10:\"google_lon\";d:37.742743768310554;s:12:\"google_scale\";i:14;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:4:\"TEXT\";s:37:\"Магазин пиротехники\";s:3:\"LON\";d:37.751179933548;s:3:\"LAT\";d:55.819201918207;}}}",
        "MAP_WIDTH" => "100%",
        "MAP_HEIGHT" => "500",
        "CONTROLS" => array(
            0 => "SMALL_ZOOM_CONTROL",
            1 => "TYPECONTROL",
            2 => "SCALELINE",
        ),
        "OPTIONS" => array(
            0 => "ENABLE_SCROLL_ZOOM",
            1 => "ENABLE_DBLCLICK_ZOOM",
            2 => "ENABLE_DRAGGING",
            3 => "ENABLE_KEYBOARD",
        ),
        "MAP_ID" => ""
    ),
    false
);?>
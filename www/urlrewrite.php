<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^#SITE_DIR#about/obzor/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "#SITE_DIR#about/obzor/detail.php",
	),
	array(
		"CONDITION" => "#^#SITE_DIR#about/jobs/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "#SITE_DIR#about/jobs/detail.php",
	),
	array(
		"CONDITION" => "#^#SITE_DIR#brands/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "#SITE_DIR#brands/detail.php",
	),
	array(
		"CONDITION" => "#^#SITE_DIR#about/actions/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "#SITE_DIR#about/actions/index.php",
	),
	array(
		"CONDITION" => "#^#SITE_DIR#news/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "#SITE_DIR#news/detail.php",
	),
	array(
		"CONDITION" => "#^/about/obzor/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "/about/obzor/detail.php",
	),
	array(
		"CONDITION" => "#^/about/jobs/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "/about/jobs/detail.php",
	),
	array(
		"CONDITION" => "#^#SITE_DIR#catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "#SITE_DIR#catalog/index.php",
	),
	array(
		"CONDITION" => "#^/brands/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "/brands/detail.php",
	),
	array(
		"CONDITION" => "#^/news/(.*)/(.*)#",
		"RULE" => "CODE=\$1",
		"ID" => "",
		"PATH" => "/news/detail.php",
	),
	array(
		"CONDITION" => "#^/about/actions/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/about/actions/index.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	)
);

?>
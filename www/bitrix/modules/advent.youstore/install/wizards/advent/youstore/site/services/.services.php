<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy bitrix files
			"search.php", // Indexing files
			"template.php", // Install template
			"theme.php", // Install theme
			"menu.php", // Install menu
			"settings.php",
		),
	),
	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
		"STAGES" => Array(
			"types.php",
            "slider.php",
            "references.php",//reference of colors
            "references2.php",
            "actions.php",
            "brands.php",
            "comments.php",
            "faq.php",
            "feedback.php",
            "news.php",
            "props.php",
            "reviews.php",
            "rss.php",
            "shop_reviews.php",
            "team.php",
            "callback.php",
            "resumes.php",
            "vakansii.php",
			"catalog.php",//catalog iblock import
			"catalog2.php",//offers iblock import
			"catalog3.php",
			"catalog4.php",
			"newsblocks.php",
		),
	),
	"sale" => Array(
		"NAME" => GetMessage("SERVICE_SALE_DEMO_DATA"),
		"STAGES" => Array(
			"step1.php", "step2.php", "step3.php"
		),
	),
	"catalog" => Array(
		"NAME" => GetMessage("SERVICE_CATALOG_SETTINGS"),
		"STAGES" => Array(
			"index.php"
			//"eshopapp.php",
		),
	)//,
//	"forum" => Array(
//		"NAME" => GetMessage("SERVICE_FORUM")
//	)
);
?>
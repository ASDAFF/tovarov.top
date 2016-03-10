<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<ul class="breadcrumbs"  vocab="http://schema.org/" typeof="BreadcrumbList">';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($index<(count($arResult)-1)) {
		if ($arResult[$index]["LINK"] <> "")
			$strReturn .= '<li property="itemListElement" typeof="ListItem">
								<a property="item" typeof="WebPage" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">
									<span property="name">' . $title . '
									</span>
								</a>'.'
								 <meta property="position" content="'.($index+1).'">'.'
							</li>';
		else
			$strReturn .= '<li property="itemListElement" typeof="ListItem">
								<span property="name">' . $title . '
								</span>'.'
								 <meta property="position" content="'.($index+1).'">'.'
							</li>';
	}
}

$strReturn .= '</ul>';
return $strReturn;
?>

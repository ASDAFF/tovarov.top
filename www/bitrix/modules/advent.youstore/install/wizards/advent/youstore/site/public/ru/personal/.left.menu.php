<?
$aMenuLinks = Array(
	Array(
		"Общая<br/> информация", 
		"./", 
		Array(), 
		Array("CLASS"=>"general"), 
		"\$USER->IsAuthorized()" 
	),
	Array(
		"Лист<br/> желаний", 
		"wishlist/", 
		Array(), 
		Array("CLASS"=>"wishlist"), 
		"" 
	),
	Array(
		"Просмотренные<br/> товары", 
		"visited/", 
		Array(), 
		Array("CLASS"=>"viewed"), 
		"" 
	),
	Array(
		"История<br/> покупок", 
		"history/", 
		Array(), 
		Array("CLASS"=>"history"), 
		"\$USER->IsAuthorized()" 
	),
	Array(
		"Обратная<br/> связь", 
		"message/", 
		Array(), 
		Array("CLASS"=>"feedback"), 
		"\$USER->IsAuthorized()" 
	)
);
?>
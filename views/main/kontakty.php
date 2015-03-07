<?php
/*
PageName: Контакты
*/
/*
PageContent: <p>[*YandexMap*]</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

*/
?> 
<h1><?php echo $title; ?></h1><div><?php echo $content; ?></div><a href='/page/update/<?php echo $_GET["id"]; ?>'>Редактировать</a><a href='/page/delete/<?php echo $_GET["id"]; ?>'>Удалить</a>
<input type="text" name=""/>
<input type="submit" class="btn btn-primary"/>
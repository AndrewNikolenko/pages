<?php
/*
PageName: Новая страница для теста
*/
/*
PageContent: <p>Привет всем!</p>
*/
?>
<?php namespace app\modules\eaPanel\components; ?><h1><?php echo $title; ?></h1><div><?php echo $content; ?></div><a href='/page/update/<?php echo $_GET["id"]; ?>'>Редактировать</a><a href='/page/delete/<?php echo $_GET["id"]; ?>'>Удалить</a>
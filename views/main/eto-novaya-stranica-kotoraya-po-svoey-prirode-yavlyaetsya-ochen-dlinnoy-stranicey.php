<?php
/*
PageName: Это новая страница которая по своей природе является очень длинной страницей
*/
/*
PageContent: <p>111</p>
*/
?>
<?php namespace app\modules\eaPanel\components; ?><h1><?php echo $title; ?></h1><div><?php echo $content; ?></div><a href='/page/update/<?php echo $_GET["id"]; ?>'>Редактировать</a><a href='/page/delete/<?php echo $_GET["id"]; ?>'>Удалить</a>
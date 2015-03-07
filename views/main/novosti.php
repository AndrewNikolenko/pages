<?php
/*
PageName: Новости
*/
/*
PageContent: <img src="http://start-app.loc/images/54e19925340fd.jpg"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<span></span></p>
	<span rel="font-size: 12px;" style="font-size: 12px;"></span><img src="http://start-app.loc/images/54e0ab388a8e5.jpg" alt="54e0ab388a8e5.jpg">
</p>
<table>
<tbody>
<tr>
	<td>
		111
	</td>
	<td>
		111
	</td>
	<td>
		11111
	</td>
</tr>
<tr>
	<td>
		111
	</td>
	<td>
		11
	</td>
	<td>
		111
	</td>
</tr>
</tbody>
</table>
<p>
	<span style="color: rgb(192, 80, 77);"><span style="background-color: rgb(255, 255, 0);" data-redactor-style="background-color: rgb(255, 255, 0);">Lorem ipsum dolor sit amet</span></span>, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex<span style="font-size: 18px;" rel="font-size: 18px;"> ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillu</span>m dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<span></span><br>
</p>
<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=rObv6B8ovyq1LcpToS7CxaKQgvuKG5Pb&width=600&height=450"></script>
*/
?>
<h1><?php echo $title; ?></h1><div><?php echo $content; ?></div><a href='/page/update/<?php echo $_GET["id"]; ?>'>Редактировать</a><a href='/page/delete/<?php echo $_GET["id"]; ?>'>Удалить</a>
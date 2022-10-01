<?php
require_once('blog.php');
//ini_set('display_errors', "On");
$blog = new Blog();
$blogData = $blog->getAll();

function h($s){
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content = "width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>留言板</title>
</head>
<body>
	<h2>留言板</h2>
	<p><a href="/check_place.html">新增留言</a></p>
	<!--<p><a href="/form.html">新增留言</a></p>-->
	<p><a href="/search_comment.html">搜尋留言</a></p>
	<p><a href="/">返回首頁</a></p>
	<table>
	<tr>
		<!--<th>No</th>-->
		<th>使用者ID</th>
		<th>發文日期</th>
		<th>日期</th>
		<th>縣市</th>
		<th>景點名稱</th>
		<th>評價</th>
		<th>心得</th>
		<th>空氣</th>
		<th>天氣</th>
	</tr>
	<?php foreach($blogData as $column):?>
	<tr>
		<td><?php echo h($column['user_id']) ?></td>
		<td><?php echo h($column['post_at']) ?></td>
		<td><?php echo h($column['date']) ?></td>
		<td><?php echo h($column['city']) ?></td>
		<td><?php echo h($column['place']) ?></td>
		<td><?php echo h($column['rating']) ?></td>
		<td><?php echo mb_substr(h($column['comment']), 0, 5, 'utf-8') ?></td>

		
		<td><?php echo h($blog->setAir($column['air'])) ?></td>
		<td><?php echo h($blog->setWeather($column['weather'])) ?></td>
		<td><a href="/detail.php?id=<?php echo $column['id'] ?>">全文</a></td>
		<td><a href="/update_form.php?id=<?php echo $column['id'] ?>">編輯</a></td>
		<td><a href="/blog_delete.php?id=<?php echo $column['id'] ?>">刪除</a></td>
		
	</tr>
	<?php endforeach; ?>
	</table>
</body>
</html>
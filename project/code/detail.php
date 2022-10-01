<?php
require_once('blog.php');
$blog = new Blog();
$result = $blog->getById($_GET['id']);
?>

<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content = "width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>心得全文</title>
</head>
<body>
	<h2>心得全文</h2>
	<hr>
	<p> 發文者ID: <?php echo $result['user_id'] ?></h3>
	<p> 發文日期: <?php echo $result['post_at'] ?></h3>
	<p> 旅遊日期: <?php echo $result['date'] ?></h3>
	<hr>
	<p> 縣市: <?php echo $result['city'] ?></h3>
	<p> 景點名稱: <?php echo $result['place'] ?></p>
	<p> 評分: <?php echo $result['rating'] ?></p>
	<p> 心得: <?php echo $result['comment'] ?></h3>
	<p> 空氣: <?php echo $blog->setAir($result['air']) ?></h3>
	<p> 天氣: <?php echo $blog->setWeather($result['weather']) ?></p>
	<p><a href="/index_comment.php">返回留言板</a></p>
	<p><a href="/">返回首頁</a></p>
</body>

</html>
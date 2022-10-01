<?php
ini_set('display_errors', "On");
require_once('blog.php');
$blogs = $_POST;
$blog = new Blog();
$blog->placeValidate($blogs);
$result = $blog->checkPlace($blogs);
//var_dump($result[0]['name']);
function h($s){
	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bulletin Board Form</title>
</head>
<body>
    <h2>新增留言</h2>
    <form action="blog_create.php" method="POST">
        <input type="hidden" name="place" value = "<?php echo $result[0]['name'] ?>" >
        <input type="hidden" name="city" value = "<?php echo $result[0]['region'] ?>" >
        <p>使用者ID: </p>
        <input type="text" name="user_id">
        <p>旅遊日期: </p>
        <input type="date" id="date" name="date">
        <p>評分:(5為最高) </p>
        <input type="radio" name="rating" value="1" checked>1分
        <input type="radio" name="rating" value="2">2分
        <input type="radio" name="rating" value="3">3分
        <input type="radio" name="rating" value="4">4分
        <input type="radio" name="rating" value="5">5分
        <br>
        <p>心得: </p>
        <textarea name="comment" id="comment" cols="50" rows="10"></textarea>
        <br>
        <p>空氣品質: </p>
        <input type="radio" name="air" value="1" >非常糟
        <input type="radio" name="air" value="2">糟
        <input type="radio" name="air" value="3" checked>普通
        <input type="radio" name="air" value="4">好
        <input type="radio" name="air" value="5">非常好
        <br>
        <p>天氣: </p>
        <input type="radio" name="weather" value="1" >雨天
        <input type="radio" name="weather" value="2" checked>多雲
        <input type="radio" name="weather" value="3">晴天
        <br>

		<input type="submit" value="送出">
    </form>
    <p><a href="/index_comment.php">返回留言板</a></p>
    <p><a href="/">返回首頁</a></p>
</body>
</html>
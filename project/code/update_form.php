<?php

require_once('blog.php');

$blog = new Blog();
$result = $blog->getById($_GET['id']);

$id = $result['id']; 
$user_id = $result['user_id'];
$date = $result['date'];
$city = $result['city'];
$place = $result['place'];
$rating = (int)$result['rating'];
$comment = $result['comment'];
$air = (int)$result['air'];
$weather = (int)$result['weather'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>更新留言</title>
</head>
<body>
    <h2>更新留言</h2>
    <form action="blog_update.php" method="POST">
        <input type="hidden" name="id" value = "<?php echo $id ?>" >
        <p>使用者ID: </p>
        <input type="text" name="user_id" value="<?php echo $user_id ?>">
        <p>旅遊日期: </p>
        <input type="date" id="date" name="date" value="<?php echo $date ?>">
        <p>縣市: </p>
        <select name="city">
            <option value="臺北市" <?php if($city === '臺北市') echo "selected" ?> >臺北市</option>
            <option value="新北市" <?php if($city === '新北市') echo "selected" ?> >新北市</option>
            <option value="基隆市" <?php if($city === '基隆市') echo "selected" ?> >基隆市</option>
            <option value="桃園市" <?php if($city === '桃園市') echo "selected" ?> >桃園市</option>
            <option value="新竹市" <?php if($city === '新竹市') echo "selected" ?> >新竹市</option>
            <option value="新竹縣" <?php if($city === '新竹縣') echo "selected" ?> >新竹縣</option>
            <option value="苗栗縣" <?php if($city === '苗栗縣') echo "selected" ?> >苗栗縣</option>
            <option value="台中市" <?php if($city === '台中市') echo "selected" ?> >台中市</option>
            <option value="彰化縣" <?php if($city === '彰化縣') echo "selected" ?> >彰化縣</option>
            <option value="南投縣" <?php if($city === '南投縣') echo "selected" ?> >南投縣</option>
            <option value="雲林縣" <?php if($city === '雲林縣') echo "selected" ?> >雲林縣</option>
            <option value="嘉義市" <?php if($city === '嘉義市') echo "selected" ?> >嘉義市</option>
            <option value="嘉義縣" <?php if($city === '嘉義縣') echo "selected" ?> >嘉義縣</option>
            <option value="台南市" <?php if($city === '台南市') echo "selected" ?> >台南市</option>
            <option value="高雄市" <?php if($city === '高雄市') echo "selected" ?> >高雄市</option>
            <option value="屏東縣" <?php if($city === '屏東縣') echo "selected" ?> >宜蘭縣</option>
            <option value="花蓮縣" <?php if($city === '花蓮縣') echo "selected" ?> >花蓮縣</option>
            <option value="台東縣" <?php if($city === '台東縣') echo "selected" ?> >台東縣</option>
            <option value="澎湖縣" <?php if($city === '澎湖縣') echo "selected" ?> >澎湖縣</option>
            <option value="金門縣" <?php if($city === '金門縣') echo "selected" ?> >金門縣</option>
            <option value="連江縣" <?php if($city === '連江縣') echo "selected" ?> >連江縣</option>      
            <option value="其他" <?php if($city === '其他') echo "selected" ?> >其他</option>     
        </select>
        <br>
        <p>景點名稱: </p>
        <input type="text" name="place" value = "<?php echo $place ?>">
        <p>評分:(5為最高) </p>
        <input type="radio" name="rating" value="1" <?php if($rating === 1) echo "checked" ?> >1分
        <input type="radio" name="rating" value="2" <?php if($rating === 2) echo "checked" ?> >2分
        <input type="radio" name="rating" value="3" <?php if($rating === 3) echo "checked" ?> >3分
        <input type="radio" name="rating" value="4" <?php if($rating === 4) echo "checked" ?> >4分
        <input type="radio" name="rating" value="5" <?php if($rating === 5) echo "checked" ?> >5分
        <br>
        <p>心得: </p>
        <textarea name="comment" id="comment" cols="50" rows="10"><?php echo $comment ?></textarea>
        <br>
        <p>空氣品質: </p>
        <input type="radio" name="air" value="1" <?php if($air === 1) echo "checked" ?> >非常糟
        <input type="radio" name="air" value="2" <?php if($air === 2) echo "checked" ?> >糟
        <input type="radio" name="air" value="3" <?php if($air === 3) echo "checked" ?> >普通
        <input type="radio" name="air" value="4" <?php if($air === 4) echo "checked" ?> >好
        <input type="radio" name="air" value="5" <?php if($air === 5) echo "checked" ?> >非常好
        <br>
        <p>天氣: </p>
        <input type="radio" name="weather" value="1" <?php if($weather === 1) echo "checked" ?> >雨天
        <input type="radio" name="weather" value="3" <?php if($weather === 2) echo "checked" ?> >多雲
        <input type="radio" name="weather" value="4" <?php if($weather === 3) echo "checked" ?> >晴天
        <br>

		<input type="submit" value="更新">
    </form>
    <p><a href="/index_comment.php">返回留言板</a></p>
    <p><a href="/">返回首頁</a></p>
    
</body>
</html>
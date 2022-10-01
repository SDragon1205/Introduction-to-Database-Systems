<?php

require_once('blog.php');
$blogs = $_POST;
$blog = new Blog();
//var_dump($blogs);
$blog->blogValidate($blogs);
$blog->blogUpdate($blogs);



?>
<p><a href="/index_comment.php">返回留言板</a></p>
<p><a href="/">返回首頁</a></p>
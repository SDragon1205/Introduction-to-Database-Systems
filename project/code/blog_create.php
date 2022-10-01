<?php
ini_set('display_errors', "On");
require_once('blog.php');
$blogs = $_POST;
$blog = new Blog();
$blog->blogValidate($blogs);
$blog->blogCreate($blogs);
?>
<p><a href="/index_comment.php">返回留言板</a></p>
<p><a href="/">返回首頁</a></p>
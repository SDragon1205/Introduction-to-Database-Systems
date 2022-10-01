<?php

require_once('blog.php');
$blog = new Blog();
$blog->delete($_GET['id']);


?>
<p><a href="/index_comment.php">返回留言板</a></p>
<p><a href="/">返回首頁</a></p>
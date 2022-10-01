<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>查詢結果</title>
</head>

<body>
	<h2>以下是此地點中的景點</h2>
	<form action="imformation.php" method="POST">
		<p>輸入想去的景點名稱: （ex：海、湖、天后宮、書店，或複製貼上下面的景點）</p>
		<input type="text" name="place" placeholder="非必填">
		<p>選擇想要旅遊的日期: </p>
        <input type="date" id="date" name="date">
		<br><br>
		<input type="submit" value="確定">
		<br>
		<p><a href="/">返回首頁</a></p>
		<?php
		$dsn = 'mysql:host=localhost;dbname=final_project;charset=utf8'; //改dbname
		$user = 'root'; //預設'user'
		$pass = ''; //預設''

		try {
			$dbh = new PDO($dsn, $user, $pass, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			]);
			//$sql = "SELECT * FROM attraction WHERE Name LIKE BINARY '%" . $_GET['site'] . "%'";
			//$sql = "SELECT * FROM attraction WHERE Region LIKE BINARY '新竹%'";
			$sql = "SELECT * FROM attraction WHERE Region LIKE BINARY '%" . $_POST['city'] . "%' AND Town LIKE BINARY '%" . $_POST['place'] . "%'";
			if ($stmt = $dbh->query($sql)) {
				echo '找到' . $stmt->rowcount() . '筆資料<br><br>';
				$result = $stmt->fetchAll();
				foreach ($result as $datainfo) {
					echo $datainfo['name'] . "<br>" . $datainfo['toldescribe'] . "<br>";
					if ($datainfo[12] != NULL) {
						echo "<img src=$datainfo[12] width=400><br>";
					}
					echo "<br>";
				}
			} else {
				echo 'hello<br>';
			}
			$dbh = null;
		} catch (PDOException $e) {
			echo ' fail to connect' . $e->getMessage();
			exit();
		};
		?>
	</form>
</body>

</html>
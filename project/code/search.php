<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>查詢結果</title>
</head>

<body>
	<p><a href="/weather_form.html">返回搜尋</a></p>
	<h2>以下是符合天氣中的景點</h2>
		<br>
		<?php
		$dsn = 'mysql:host=localhost;dbname=final_project;charset=utf8'; //改dbname
		$user = 'root'; //預設'user'
		$pass = ''; //預設''

		try {
			$dbh = new PDO($dsn, $user, $pass, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			]);
			$d1 = '';
			$d2 = '';
			if (empty($_POST['date1'])) {
				$d1 = '2020-05-29 01:00';
			}else{
				$d1 = date('Y-m-d H:i', strtotime(str_replace("/","-",$_POST['date1'])));
				if( strtotime($d1) > strtotime('2021-05-29 00:00') ) {
					$d1 = substr($d1, 4, 12);
					$d1 = '2020'.$d1;
					if( strtotime($d1) < strtotime('2020-05-29 01:00') ) {
						$d1 = substr($d1, 4, 12);
						$d1 = '2021'.$d1;
					}
				}
			};
			if (empty($_POST['date2'])) {
				$d2 = '2021-05-29 00:00';
			}else{
				$d2 = date('Y-m-d H:i', strtotime(str_replace("/","-",$_POST['date2'])));
				if( strtotime($d2) > strtotime('2021-05-29 00:00') ) {
					$d2 = substr($d2, 4, 12);
					$d2 = '2020'.$d2;
					if( strtotime($d2) < strtotime('2020-05-29 01:00') ) {
						$d2 = substr($d2, 4, 12);
						$d2 = '2021'.$d2;
					}
				}
			};

			if (empty($_POST['tem1'])) {
				$_POST['tem1'] = '0';
			};
			if (empty($_POST['tem2'])) {
				$_POST['tem2'] = '999.9';
			};
			if (empty($_POST['hum1'])) {
				$_POST['hum1'] = '0';
			};
			if (empty($_POST['hum2'])) {
				$_POST['hum2'] = '99999.9';
			};
			
			$sql = "SELECT* FROM 
			(SELECT * FROM one_year 
			WHERE date >= '" . $d1 . "' 
			AND date <= '" . $d2 . "' 
			AND temp >= '" . $_POST['tem1'] . "' 
			AND temp <= '" . $_POST['tem2'] . "' 
			AND humidity >= '" . $_POST['hum1'] . "' 
			AND humidity <= '" . $_POST['hum2'] . "' 
			AND wind_speed LIKE BINARY '%" . $_POST['spe'] . "%' 
			AND precipitation LIKE BINARY '%" . $_POST['pre'] . "%' 
			AND sunshine LIKE BINARY '%" . $_POST['sun'] . "%'
			group by station_id) AS A, 
			(SELECT s.name, s.toldescribe,s.description, s.tel,s.add,s.opentime,s.travellinginfo,
			s.ticketinfo,s.remarks,s.picdescribe1,s.picdescribe2,s.picdescribe3, N.station_id 
			FROM (SELECT N.name, MIN(N.distance) AS m, N.toldescribe,N.description,N.tel,N.add,N.opentime,N.travellinginfo,N.ticketinfo,N.remarks,N.picdescribe1,N.picdescribe2,N.picdescribe3 
			FROM (SELECT SQRT((attraction.Px-station.px)*(attraction.Px-station.px)+(attraction.Py-station.py)*(attraction.Py-station.py)) AS distance, attraction.name , station.station_name , 
			station.station_id, attraction.id,attraction.toldescribe,attraction.description, attraction.tel,attraction.add,attraction.opentime,attraction.travellinginfo,attraction.ticketinfo,
			attraction.remarks,attraction.picdescribe1,attraction.picdescribe2,attraction.picdescribe3 
			FROM attraction, station) AS N GROUP BY N.name) AS s, 
			(SELECT SQRT((attraction.Px-station.px)*(attraction.Px-station.px)+(attraction.Py-station.py)*(attraction.Py-station.py)) AS distance, attraction.name , station.station_name , 
			station.station_id, attraction.id 
			FROM attraction, station) AS N 
			WHERE N.distance = s.m AND N.name = s.name) AS B 
			WHERE A.station_id =B.station_id
			LIMIT 10";
			

			
			if ($stmt = $dbh->query($sql)) {
				echo '找到' . $stmt->rowcount() . '筆資料<br><br>';
				$result = $stmt->fetchAll();
				foreach ($result as $datainfo) {
					//var_dump($datainfo);
					echo $datainfo['name'] . "<br>" . $datainfo['toldescribe'] . "<br>";

					if($datainfo['description']!= NULL){
						if ($datainfo['toldescribe'][0] != $datainfo['description'][0]) {
							echo $datainfo['description'] . "<br>";
						}
					}
					
					echo "電話：" . $datainfo['tel'] . "<br>地址：" . $datainfo['add'] . "<br>開放時間：" . $datainfo['opentime'] . "<br>";
					if ($datainfo['travellinginfo'] != NULL) {
						echo "旅遊資訊：" . $datainfo['travellinginfo'] . "<br>";
					}
					if ($datainfo['ticketinfo'] != NULL) {
						echo "收費方式：" . $datainfo['ticketinfo'] . "<br>";
					}
					if ($datainfo['remarks'] != NULL) {
						echo "註記：" . $datainfo['remarks'] . "<br>";
					}
					/*
					if ($datainfo[12] != NULL) {
						//var_dump($datainfo[12]);
						echo "<img src=$datainfo[12] width=400><br>";
					}
					if ($datainfo['picdescribe1'] != NULL) {
						echo $datainfo['picdescribe1'] . "<br>";
					}
					if ($datainfo[14] != NULL) {
						//var_dump($datainfo[14]);
						echo "<img src=$datainfo[14] width=400><br>";
					}
					if ($datainfo['picdescribe2'] != NULL) {
						echo $datainfo['Picdescribe2'] . "<br>";
					}
					if ($datainfo[16] != NULL) {
						//var_dump($datainfo[16]);
						echo "<img src=$datainfo[16] width=400><br>";
					}
					if ($datainfo['picdescribe3'] != NULL) {
						echo $datainfo['Picdescribe3'] . "<br>";
					}*/

					$place = $datainfo['name'];
					$sql = "SELECT ROUND(avg(rating), 1) FROM board WHERE place = '$place'";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						if ($result[0][0] == NULL) {
							echo "使用者評分: 尚無人評分<br>";
						} else {
							echo  "使用者評分: " . $result[0][0] .  "<br>";
						}

						//echo "</tr>";

					}

					
					$sql = "SELECT *
					FROM(
					SELECT COUNT(*)
					FROM board
					WHERE air = 5 AND place = '$place') AS a,
					(SELECT COUNT(*) 
					FROM board
					WHERE place = '$place') AS b";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						echo  "使用者評空氣品質(非常好/全部資料): " . $result[0][0] . "/" . $result[0][1] . "<br>";
						//echo "</tr>";

					}

					$sql = "SELECT *
					FROM(
					SELECT COUNT(*)
					FROM board
					WHERE weather = 3 AND place = '$place') AS a,
					(SELECT COUNT(*) 
					FROM board
					WHERE place = '$place') AS b";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						echo  "使用者評天氣好壞(晴天/全部資料): " . $result[0][0] . "/" . $result[0][1] . "<br>";
					}


		
					echo "<br>";
				}
			} else {
				echo 'error404<br>';
			}
			$dbh = null;
		} catch (PDOException $e) {
			echo ' fail to connect' . $e->getMessage();
			exit();
		};
		?>
</body>
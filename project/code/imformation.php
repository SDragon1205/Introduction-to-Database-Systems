<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>景點詳細資訊</title>
</head>

<body>
	<h2>景點詳細資訊</h2>
	<form>
		<?php
		define('MAX', '10');
		$dsn = 'mysql:host=localhost;dbname=final_project;charset=utf8'; //改dbname
		$user = 'root'; //預設'user'
		$pass = ''; //預設''

		try {
			if (empty($_POST['place'])) {
				echo '資料有缺，請再次填寫<br>';
				exit();
			};
			$dbh = new PDO($dsn, $user, $pass, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			]);
			//$sql = "SELECT * FROM attraction WHERE Name LIKE BINARY '%" . $_GET['site'] . "%'";
			//$sql = "SELECT * FROM attraction WHERE Region LIKE BINARY '新竹%'";
			$sql = "SELECT * FROM attraction WHERE Name LIKE BINARY '%" . $_POST['place'] . "%' OR Keyword LIKE BINARY '%" . $_POST['place'] . "%'";
			if ($stmt = $dbh->query($sql)) {
				echo '找到' . $stmt->rowcount() . '筆資料<br><br>';
				$result = $stmt->fetchAll();
				foreach ($result as $datainfo) {

					//var_dump($datainfo);
					$citename = $datainfo['name'];
					echo $datainfo['name'] . "<br>" . $datainfo['toldescribe'] . "<br>";
					//var_dump($datainfo['toldescribe'][0]);
					//var_dump($datainfo['description'][0]);
					if ($datainfo['description'] != NULL) {
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
					if ($datainfo[12] != NULL) {
						echo "<img src=$datainfo[12] width=400><br>";
					}
					if ($datainfo['picdescribe1'] != NULL) {
						echo $datainfo['picdescribe1'] . "<br>";
					}
					if ($datainfo[14] != NULL) {
						echo "<img src=$datainfo[14] width=400><br>";
					}
					if ($datainfo['picdescribe2'] != NULL) {
						echo $datainfo['Picdescribe2'] . "<br>";
					}
					if ($datainfo[16] != NULL) {
						echo "<img src=$datainfo[16] width=400><br>";
					}
					if ($datainfo['picdescribe3'] != NULL) {
						echo $datainfo['Picdescribe3'] . "<br>";
					}
					echo "根據過去資料，以下為此景點和日期的天氣資訊（如無選擇日期，將顯示全年資料）：<br>";
					echo "<table>";
					echo "<th>降雨機率</th>";
					echo "<th>平均雨量</th>";
					echo "<th>平均溫度</th>";
					echo "<th>平均相對濕度</th>";
					echo "<th>平均風速</th>";
					echo "<th>使用者評分</th>";
					echo "<th>使用者評空氣品質(非常好/全部資料)</th>";
					echo "<th>使用者評天氣好壞(晴天/全部資料)</th>";
					echo "</tr>";
					$stationarr = array("", "");
					$sql1 = "SELECT station.station_id, station.station_name FROM attraction, station WHERE attraction.Name = '" . $datainfo['name'] . "' ORDER BY SQRT((attraction.Px-station.px)*(attraction.Px-station.px)+(attraction.Py-station.py)*(attraction.Py-station.py)) limit 2";
					if ($stmt1 = $dbh->query($sql1)) {
						$result1 = $stmt1->fetchAll();
						$i = 0;
						foreach ($result1 as $datainfo1) {
							$stationarr[$i] = $datainfo1[0];
							$i = $i + 1;
						}
					}
					$datestr1 = '';
					$datestr2 = '';
					$datestr3 = '';
					$datestr4 = '';
					$datestr5 = '';
					$datestr6 = '';
					$datestr7 = '';
					$datestr8 = '';
					$datestr9 = '';
					$sql = "SELECT ADDDATE('" . $_POST['date'] . "', INTERVAL 4 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr4 =  $datainfo[0];
						}
					}
					$sql = "SELECT ADDDATE('" . $_POST['date'] . "', INTERVAL 3 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr5 =  $datainfo[0];
						}
					}
					$sql = "SELECT ADDDATE('" . $_POST['date'] . "', INTERVAL 2 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr6 =  $datainfo[0];
						}
					}
					$sql = "SELECT ADDDATE('" . $_POST['date'] . "', INTERVAL 1 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr1 =  $datainfo[0];
						}
					}
					$datestr2 =  $_POST['date'];
					$sql = "SELECT SUBDATE('" . $_POST['date'] . "', INTERVAL 1 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr3 =  $datainfo[0];
						}
					}
					$sql = "SELECT SUBDATE('" . $_POST['date'] . "', INTERVAL 2 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr9 =  $datainfo[0];
						}
					}
					$sql = "SELECT SUBDATE('" . $_POST['date'] . "', INTERVAL 3 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr8 =  $datainfo[0];
						}
					}
					$sql = "SELECT SUBDATE('" . $_POST['date'] . "', INTERVAL 4 DAY)";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							$datestr7 =  $datainfo[0];
						}
					}
					$datestr1 = substr($datestr1, 4, 6);
					$datestr2 = substr($datestr2, 4, 6);
					$datestr3 = substr($datestr3, 4, 6);
					$datestr4 = substr($datestr4, 4, 6);
					$datestr5 = substr($datestr5, 4, 6);
					$datestr6 = substr($datestr6, 4, 6);
					$datestr7 = substr($datestr7, 4, 6);
					$datestr8 = substr($datestr8, 4, 6);
					$datestr9 = substr($datestr9, 4, 6);
					$station = '臺中';
					$sql = "SELECT * FROM dy_report WHERE station_id = '" . $stationarr[0] . "' AND (date LIKE '%" . $datestr1 . "%' OR date LIKE '%" . $datestr2 . "%' OR date LIKE '%" . $datestr3 . "%') AND precipitation != 0";
					if ($stmt = $dbh->query($sql)) {
						echo "<tr>";
						if ($datestr2 != "") {
							echo "<td>" . number_format($stmt->rowcount() / 27, 2) .  "</td>";
						} else {
							echo "<td>" . number_format($stmt->rowcount() / 3285, 2) .  "</td>";
						}
					}
					$sql = "SELECT ROUND(avg(precipitation), 2) as ave FROM dy_report WHERE station_id = '" . $stationarr[0] . "' AND (date LIKE '%" . $datestr1 . "%' OR date LIKE '%" . $datestr2 . "%' OR date LIKE '%" . $datestr3 . "%')";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						foreach ($result as $datainfo) {
							echo "<td>" . $datainfo['ave'] .  "</td>";
						}
					}
					$v1 = array(0.0, 0.0, 0.0);
					$v2 = array(0.0, 0.0, 0.0);
					$sql = "SELECT temp, humidity, date FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND (station_id LIKE '%" . $stationarr[0] . "%' OR station_id LIKE '%" . $stationarr[1] . "%')";
					if ($stmt = $dbh->query($sql)) {
						if ($stmt->rowcount() > 300) {
							$sql1 = "SELECT ROUND(avg(temp), 2), ROUND(AVG(humidity), 2), ROUND(AVG(wind_speed), 2) FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND station_id LIKE '%" . $stationarr[0] . "%'";
							//$sql = "SELECT temp, humidity, date FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND (station_id LIKE '%" . $stationarr[0] . "%' OR station_id LIKE '%" . $stationarr[1] . "%')";
							if ($stmt1 = $dbh->query($sql1)) {
								$result1 = $stmt1->fetchAll();
								foreach ($result1 as $column1) {
									$v1[0] = $column1[0];
									$v1[1] = $column1[1];
									$v1[2] = $column1[2];
									//echo "</tr>";
								}
								//echo "</table>";
							}
							$sql2 = "SELECT ROUND(avg(temp), 2), ROUND(AVG(humidity), 2), ROUND(AVG(wind_speed), 2) FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND station_id LIKE '%" . $stationarr[1] . "%'";
							//$sql = "SELECT temp, humidity, date FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND (station_id LIKE '%" . $stationarr[0] . "%' OR station_id LIKE '%" . $stationarr[1] . "%')";
							if ($stmt2 = $dbh->query($sql2)) {
								$result2 = $stmt2->fetchAll();
								foreach ($result2 as $column2) {
									$v2[0] = $column2[0];
									$v2[1] = $column2[1];
									$v2[2] = $column2[2];
									//echo "</tr>";
								}
								//echo "</table>";
							}
							echo "<td>" . round($v1[0] * 0.7 + $v2[0] * 0.3, 2) .  "</td>";
							echo "<td>" . round($v1[1] * 0.7 + $v2[1] * 0.3, 2) .  "</td>";
							echo "<td>" . round($v1[2] * 0.7 + $v2[2] * 0.3, 2) .  "</td>";
						} else {
							$sql = "SELECT ROUND(avg(temp), 2), ROUND(AVG(humidity), 2), ROUND(AVG(wind_speed), 2) FROM one_year WHERE (date LIKE '%" . $datestr1 . "%:00' OR date LIKE '%" . $datestr2 . "%:00' OR date LIKE '%" . $datestr3 . "%:00' OR date LIKE '%" . $datestr4 . "%:00' OR date LIKE '%" . $datestr5 . "%:00' OR date LIKE '%" . $datestr6 . "%:00' OR date LIKE '%" . $datestr7 . "%:00' OR date LIKE '%" . $datestr8 . "%:00' OR date LIKE '%" . $datestr9 . "%:00') AND (station_id LIKE '%" . $stationarr[0] . "%' OR station_id LIKE '%" . $stationarr[1] . "%')";
							if ($stmt = $dbh->query($sql)) {
								$result = $stmt->fetchAll();
								foreach ($result as $column) {
									echo "<td>" . $column[0] .  "</td>";
									echo "<td>" . $column[1] .  "</td>";
									echo "<td>" . $column[2] .  "</td>";
								}
								//echo "</tr>";
							}
						}
						//echo "</table>";
					}
					//var_dump($citename);

					$sql = "SELECT ROUND(avg(rating), 1) FROM board WHERE place = '$citename'";
					//var_dump($sql);

					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						if ($result[0][0] == NULL) {
							echo "<td>尚無人評分</td>";
						} else {
							echo  "<td>" . $result[0][0] .  "</td>";
						}

						//echo "</tr>";

					}

					$sql = "SELECT *
					FROM(
					SELECT COUNT(*)
					FROM board
					WHERE air = 5 AND place = '$citename') AS a,
					(SELECT COUNT(*) 
					FROM board
					WHERE place = '$citename') AS b";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						echo  "<td>" . $result[0][0] . "/" . $result[0][1] . "</td>";
						//echo "</tr>";

					}

					$sql = "SELECT *
					FROM(
					SELECT COUNT(*)
					FROM board
					WHERE weather = 3 AND place = '$citename') AS a,
					(SELECT COUNT(*) 
					FROM board
					WHERE place = '$citename') AS b";
					if ($stmt = $dbh->query($sql)) {
						$result = $stmt->fetchAll();
						//var_dump($result);
						echo  "<td>" . $result[0][0] . "/" . $result[0][1] . "</td>";
						echo "</tr>";
					}
					//echo "<form action='http://localhost/form_place.html' method='POST'><input type='submit' value='新增留言'></form>";
					echo "</table>";
					echo "<br><br>";
				}
			}
			$dbh = null;
		} catch (PDOException $e) {
			echo ' fail to connect' . $e->getMessage();
			exit();
		};
		?>
		<p><a href="/">返回首頁</a></p>
	</form>
</body>

<!--

echo "<form action='form_place.html' method='POST'>";
					echo "<input type='hidden' name='city' value = $datainfo['region']  >";
					echo "<input type='hidden' name='place' value = $datainfo['name']  >";
					echo "<input type='submit' value='新增留言'></form>";
	-->
<?php
require_once('dbc.php');

Class Blog extends Dbc{
	
	protected $table_name = 'board';
	

	public function setAir($air){
		if($air === '1'){
			return '非常糟';
		}elseif($air ==='2'){
			return '糟';
		}elseif($air ==='3'){
			return '普通';
		}elseif($air ==='4'){
			return '好';
		}else{
			return '非常好';
		}
	}
	public function setWeather($weather){
		if($weather === '1'){
			return '雨天';
		}elseif($weather ==='2'){
			return '多雲';
		}else{
			return '晴天';
		}
	}

	public function blogCreate($blogs){
		$sql = "INSERT INTO 
					$this->table_name(user_id, date, city, place, rating, comment, air, weather)
				VALUES
					(:user_id, :date, :city, :place, :rating, :comment, :air, :weather)";
		$dbh = 	$this->dbConnect();
		$dbh->beginTransaction();
		try{
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':user_id', $blogs['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':date', $blogs['date'], PDO::PARAM_STR);
			$stmt->bindValue(':city', $blogs['city'], PDO::PARAM_STR);
			$stmt->bindValue(':place', $blogs['place'], PDO::PARAM_STR);
			$stmt->bindValue(':rating', $blogs['rating'], PDO::PARAM_INT);
			$stmt->bindValue(':comment', $blogs['comment'], PDO::PARAM_STR);
			$stmt->bindValue(':air', $blogs['air'], PDO::PARAM_INT);
			$stmt->bindValue(':weather', $blogs['weather'], PDO::PARAM_INT);
			$stmt->execute();
			$dbh->commit();
			echo '已新增心得';
			
		}catch(PDOException $e){
			$dbh->rollBack();
			exit($e);	
		}
	}

	public function blogValidate($blogs){
		//var_dump($blogs);
		
		if(empty($blogs['user_id'])){
			exit('請輸入使用者ID');
		}

		if(empty($blogs['date'])){
			exit('請輸入旅遊日期');
		}
		
		if(empty($blogs['city'])){
			exit('請輸入縣市');
		}
		if(empty($blogs['place'])){
			exit('請輸入景點名稱(20字以內)');
		}	
		if(mb_strlen($blogs['place']) > 20){
			exit('請輸入景點名稱(20字以內)');
		}
		if(empty($blogs['rating'])){
			exit('請輸入評分');
		}
		if(empty($blogs['comment'])){
			exit('請輸入心得');
		}
		if(empty($blogs['air'])){
			exit('請輸入空氣品質');
		}
		if(empty($blogs['weather'])){
			exit('請輸入天氣');
		}
	}

	public function placeValidate($blogs){
		if(empty($blogs['place'])){
			exit('請輸入景點名稱(20字以內)');
		}	
		if(mb_strlen($blogs['place']) > 20){
			exit('請輸入景點名稱(20字以內)');
		}
	}

	public function blogUpdate($blogs){
		$sql = "UPDATE  $this->table_name SET 
					user_id = :user_id, date = :date, city = :city, place = :place, rating = :rating, comment = :comment, air = :air, weather = :weather
				WHERE
					id = :id";
		$dbh = 	$this->dbConnect();
		$dbh->beginTransaction();
		try{
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':id', $blogs['id'], PDO::PARAM_INT);
			$stmt->bindValue(':user_id', $blogs['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':date', $blogs['date'], PDO::PARAM_STR);
			$stmt->bindValue(':city', $blogs['city'], PDO::PARAM_STR);
			$stmt->bindValue(':place', $blogs['place'], PDO::PARAM_STR);
			$stmt->bindValue(':rating', $blogs['rating'], PDO::PARAM_INT);
			$stmt->bindValue(':comment', $blogs['comment'], PDO::PARAM_STR);
			$stmt->bindValue(':air', $blogs['air'], PDO::PARAM_INT);
			$stmt->bindValue(':weather', $blogs['weather'], PDO::PARAM_INT);
			$stmt->execute();
			$dbh->commit();
			echo '已更新留言';
			
		}catch(PDOException $e){
			$dbh->rollBack();//ミスに気づき、変更をロールバックする
			exit($e);	
		}
	}

	public function checkPlace($blogs){
		$dbh = 	$this->dbConnect();
		$sql = "SELECT name, region  FROM  attraction  WHERE name = :place";  
		//var_dump($sql);
		
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':place', $blogs['place'], PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		
		if(!$result){
			//echo '<a href="/new_attraction.html">新增景點</a>';
			exit('景點資料庫中無相符資料');
		}	
		return $result;
		$dbh = null;
	}	

	/*public function checkPlace($blogs){
		$dbh = 	$this->dbConnect();
		$sql = "SELECT name, region, add  FROM  attraction  WHERE name LIKE CONCAT( '%', :place, '%')";
		//var_dump($sql);
		
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':place', $blogs['place'], PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		
		if(!$result){
			echo 
			exit('景點資料庫中無相符資料');
		}	
		return $result;
		$dbh = null;
	}	*/
}
?>
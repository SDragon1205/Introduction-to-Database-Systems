<?php
require_once('env.php');
//namespace Blog\Yt_1;
// /PDO

Class Dbc{
	protected $table_name;

	public function dbConnect(){
		$host = DB_HOST;
		$dbname = DB_NAME;
		$user = DB_USER;
		$pass = DB_PASS;
		$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";//改dbname
		
		try{
			$dbh = new PDO($dsn, $user, $pass,[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);		
		} catch(PDOException $e){
			echo ' fail to connect'. $e->getMessage();
			exit();
		};
		return $dbh;
	}

	public function getAll(){
		//$dbh=dbConnect();
		$dbh=$this->dbConnect();
		$sql = "SELECT * FROM $this->table_name";
		$stmt = $dbh->query($sql);
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		return $result;
		
		$dbh = null;
	}

	public function getById($id){
		if(empty($id)){
			exit('留言ID錯誤');
		}

		//$dbh = dbConnect();
		$dbh = $this->dbConnect();

		$stmt = $dbh->prepare("SELECT * FROM $this->table_name WHERE id = :id");
		$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$result){
			exit('沒有這則留言');
		}	
		return $result;
	}

	public function delete($id){
		if(empty($id)){
			exit('留言ID錯誤');
		}

		$dbh = $this->dbConnect();

		$stmt = $dbh->prepare("DELETE FROM $this->table_name WHERE id = :id");
		$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
		
		$stmt->execute();
		echo '已刪除留言';
	}

	public function searchByPlace($key){
		if(empty($key)){
			exit('留言ID錯誤');
		}

		$dbh = $this->dbConnect();
		$sql = "SELECT * FROM $this->table_name WHERE place LIKE CONCAT( '%', :key, '%')";
		//var_dump($sql);
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':key', $key, PDO::PARAM_STR);
		//var_dump($sql);
		$stmt->execute();
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);

		if(!$result){
			exit('沒有相符資料');
		}	
		return $result;
		$dbh = null;
	}
	

}









?>




<?php 
	define('DB_SERVER', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'bbt1105');
	
	class DBConnector{
		public $conn;
		
		function _construct(){
			$this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die ("Error connecting to DB".mysqli_error());
			mysqli_select_db($this->conn, DB_NAME);

            if($this->conn->connect_error) {
                exit('Error connecting to database'); //Should be a message a typical user could understand in production
            }
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->conn->set_charset("utf8mb4");
		}
		
		public function closeDatabase(){
				mysqli_close($this->conn);
		}
	}

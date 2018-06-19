<?php
	include "Crud.php";
	include "authenticator.php";
	include_once 'DBConnector.php';
	
	class User implements Crud, Authenticator {
		private $userID;
		private $firstName;
		private $lastName;
		private $cityName;

//		variables for the authenticator class
        private $username;
        private $password;

/*        Initialize values using hte constructor
		member variables cannot be instantiated from elsewhere. They are private*/
		function __construct($firstName, $lastName, $cityName, $username, $password){
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->cityName = $cityName;
            $this->username = $username;
            $this->password = $password;
		}

//        username setter
        public function setUsername($username){
            $this->username = $username;
        }
//        username getter
        public function getUsername(){
            return$this->username;
        }

//        password setter
        public function setPassword($password){
            $this->password = $password;
        }

//        password getter
        public function getPassword(){
            return $this->password;
        }

		public function setUserID($userID){
			$this->userID = $userID;
		}

		public function getUserID(){
			return $userID;
		}

		public function save(){
			$fn = $this->firstName;
			$ln = $this->lastName;
			$city = $this->cityName;
			$username = $this->username;
			$this->hashPasssword();
			$pass = $this->password;
			$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME);
			mysqli_select_db($con,DB_NAME);
			$res = mysqli_query($con, "INSERT INTO user
				(firstName, last_name, user_city, username, password) VALUES ('$fn',
				'$ln','$city', '$username', '$pass')") or die ("Error" .mysqli_error($con));
			return $res;
		}

		public function readAll(){
            $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME);
            mysqli_select_db($con,DB_NAME);
            $res = mysqli_query($con, "SELECT * FROM user")
                or die ("Error" .mysqli_error($con));
            if ($res->num_rows > 0) {
                // output data of each row
                while($row = $res->fetch_assoc()) {
                    echo "id: " . $row["id"]. " - First Name: " . $row["firstName"]. " - Last Name: " . $row["Lastname"].
                        " - City: " . $row["user_city"]."<br>";
                }
            } else {
                echo "0 results";
            }
            return $res;
		}

		public function readUnique(){
			return null;
		}

		public function search(){
			return null;
		}

		public function update(){
			return null;
		}

		public function removeOne(){
			return null;
		}

		public function removeAll(){
			return null;
		}

		public function validateForm()
        {
            //Returns true if the values are not empty
            $fn = $this->firstName;
            $ln = $this->lastName;
            $city = $this->cityName;
            if($fn == "" || $ln == "" || $city == ""){
                return false;
            }
            return true;
        }

        public function createFormErrorSessions()
        {
            session_start();
            $_SESSION['form_errors'] = "All fields are required";
        }

        /*
         * Static constructor
         */
        public static function create(){
		    $instance = new self();
		    return $instance;
        }



        public function hashPasssword()
        {
//            in-built function password_hash hashes our password
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        public function isPasswordCorrect()
        {
            $dbc = new DBConnector;
            $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME);
            $found = false;
            $res = mysqli_query($con,"SELECT * FROM user") or die("Error" . mysqli_error());

            while($row=mysqli_fetch_array($res)){
                if(password_verify($this->getPassword(), $row['password']) && $this->getUsername() == $row['username']){
                    $found = true;
                }
            }
//            close database connection
            $dbc->closeDatabase();
            return $found;
        }

        public function login()
        {
            if($this->isPasswordCorrect()){
//                Correct password input. We have to load the protected page
                header("Location:private_page.php");
            }
        }

        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }

        public function logout()
        {
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("Location:register.php");
        }

        public function isUserExists(){
            $dbc = new DBConnector;
            $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS, DB_NAME);
            $username = $this->username;
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res) > 0){
                return false;
            }else {
                return true;
            }
        }
    }
<?php
	include_once 'Session.php';//both are in same folder,no need path
	include 'Database.php';


	class User{
		private $db;
		
		public function __construct(){
			$this->db = new Database(); //create db obj
		}

		
		//===========Registration===============
		public function userRegistration($data){
			//passing $data is actually array
			$name	  = $data['name'];
			$username = $data['username'];
			$email    = $data['email'];
			$password = $data['password'];
			$pass_len = strlen($data['password']);

			$chk_email = $this->checkEmail($email); //method call


			if ($name =="" OR $username =="" OR $email =="" OR $password ==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Field must not be empty!</span>" ;

				return $msg;
			}

			if (strlen($username) < 3){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Username is too short!</span>" ;

				return $msg;

			}elseif(preg_match('/[^a-z0-9_-]+/i',$username)){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Username must contain only alphanumeric,dashes,underscore!</span>" ;

				return $msg;

			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Invalid email!</span>" ;

				return $msg;
			}

			if ($chk_email == true){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Email already exist!</span>" ;

				return $msg;
			}

			if ($pass_len<6){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password should be 6 or more characters!</span>" ;

				return $msg;
			}



			$sql = "INSERT INTO tbl_user(Name, Username, Email, Password)
					VALUES(:Name, :Username, :Email, :Password)";

			$query = $this->db->conn->prepare($sql); //$this->db=object,accessing var $conn
			$query->bindValue(':Name',$name);
			$query->bindValue(':Username',$username);
			$query->bindValue(':Email',$email);
			$query->bindValue(':Password',md5($password)); //md5 for encrypt pass in db
			$result = $query->execute();

			if ($result){
				$msg = "<span class='alert alert-success'><strong>*</strong>Registered successfully!</span>" ;

				return $msg;
			}

			
		}//userRegistration method


		//==============Login============
		public function userLogin($data){
			//passing $data is actually array
			$email    = $data['email'];
			$password = $data['password'];
			$pass_len = strlen($data['password']);

			$chk_email = $this->checkEmail($email); //method call


			if ($email =="" OR $password ==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Field must not be empty!</span>" ;

				return $msg;
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Invalid email!</span>" ;

				return $msg;
			}

			if ($chk_email != true){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Email not exist!</span>" ;

				return $msg;
			}

			if ($pass_len<6){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password should be 6 or more characters!</span>" ;

				return $msg;
			}


			//passing parameter to check it is on the db or not.Receiving all values from db
			$rtn_values = $this->getUserLogin($email,$password);
			if ($rtn_values){
				
				Session::init();
				Session::set("login", true);
				Session::set("id", $rtn_values->Id);
				Session::set("name", $rtn_values->Name);
				Session::set("username", $rtn_values->Username);
				Session::set("loginMsg", "<span class='alert alert-success'><strong>Successfully logged In!</strong></span>");

				header("Location:index.php");

			}else{
				$msg = "<span class='alert alert-danger'><strong>*</strong>Incorrect email or password!</span>" ;

				return $msg;
			}


		}//end userLogin method

		//check email,it is already used or not
		public function checkEmail($email){

			$sql = "SELECT Email FROM tbl_user WHERE Email = :Email ";
			
			$query = $this->db->conn->prepare($sql); //$this->db=object,accessing var $conn
			$query->bindValue(':Email',$email);
			$query->execute();

			if ( $query->rowCount() > 0 ){
				return true;

			}else{
				return false;

			}

		}//checkEmail method

		//method to check email,password is exist in db or not
		public function getUserLogin($email,$password){
			$sql = "SELECT * FROM tbl_user WHERE Email =:Email AND Password =:Password LIMIT 1 ";

			$query = $this->db->conn->prepare($sql);
			$query->bindValue(':Email',$email);
			$query->bindValue(':Password',md5($password));
			$query->execute();

			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;

		}

		

		//======method to get all data from db========
		public function getUserData(){
			$sql = "SELECT * FROM tbl_user ORDER BY Id DESC";
			$query = $this->db->conn->prepare($sql);
			$query->execute();

			$result = $query->fetchAll();
			return $result;
		}


		
		//================show data while update==============
		public function getUserById($userId){
			$sql = "SELECT * FROM tbl_user WHERE Id=:Id LIMIT 1 ";

			$query = $this->db->conn->prepare($sql);
			$query->bindValue(':Id',$userId);
			$query->execute();

			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}
	
		

		//===========update User===============
		public function userUpdate($userId,$data){

			$name	  = $data['name'];
			$username = $data['username'];
			$email    = $data['email'];


			if ($name =="" OR $username =="" OR $email ==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Field must not be empty!</span>" ;

				return $msg;
			}

			if (strlen($username) < 3){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Username is too short!</span>" ;

				return $msg;

			}elseif(preg_match('/[^a-z0-9_-]+/i',$username)){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Username must contain only alphanumeric,dashes,underscore!</span>" ;

				return $msg;

			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Invalid email!</span>" ;

				return $msg;
			}


			$sql = "UPDATE tbl_user set
					Name 	 =:Name,
					Username =:Username,
					Email 	 =:Email
					WHERE id =:Id";

			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Name',$name);
			$query->bindValue(':Username',$username);
			$query->bindValue(':Email',$email);
			$query->bindValue(':Id',$userId);
			$result = $query->execute();

			if ($result){
				$msg = "<span class='alert alert-success'><strong>*</strong>Updated successfully!</span>" ;

				return $msg;

			}else{
				$msg = "<span class='alert alert-danger'><strong>*</strong>Not Updated!</span>" ;

				return $msg;

			}

		} //end updated user



		//====update password========
		public function updatePassword($userId,$data){
			$old_password = $data['old_password'];
			$new_password = $data['new_password'];

			if ($old_password=="" OR $new_password==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Field must not be empty!</span>" ;

				return $msg;
			}


			$chk_pass = $this->checkPassword($userId,$old_password);
			
			if ($chk_pass == false){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Old password not matched!</span>" ;

				return $msg;

			}

			if (strlen($new_password) < 6){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password should be 6 or more characters!</span>" ;

				return $msg;
			}


			$newPassword = md5($new_password);

			$sql = "UPDATE tbl_user set
					Password =:Password
					WHERE Id =:Id";

			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Id',$userId);
			$query->bindValue(':Password',$newPassword);
			
			$result = $query->execute();

			if ($result){
				$msg = "<span class='alert alert-success'><strong>*</strong>Password updated successfully!</span>" ;

				return $msg;

			}else{
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password Not Updated!</span>" ;

				return $msg;

			}



		}//end updatePassword

		//check old password
		private function checkPassword($userId,$old_password){
			$old_password = md5($old_password);
			
			$sql = "SELECT Password FROM tbl_user WHERE Id=:Id AND Password=:Password ";

			$query = $this->db->conn->prepare($sql);
			$query->bindValue(':Id',$userId);
			$query->bindValue(':Password',$old_password);
			$query->execute();

			if ($query->rowCount() > 0){
				return true;
			}else{
				return false;
			}

		}








	}//=======End user class==========

?>
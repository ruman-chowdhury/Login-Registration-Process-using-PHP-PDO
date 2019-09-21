<?php  
	include_once 'lib/Session.php';
	include 'lib/Database.php';

class Process{
		private $db;

		public function __construct(){

			$this->db =  new Database();
		}

//============================================Process of work===============================
		//=====================Registration=======================
		public function userRegistration($data){
			$name = $data['name'];
			$username = $data['username'];
			$email = $data['email'];
			$password = $data['password'];

			$chk_email = $this->checkEmail($email);



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

			if (strlen($password) < 6){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password should be 6 or more characters!</span>" ;

				return $msg;
			}


			$sql = "INSERT INTO tbl_user(Name, Username, Email, Password)
			VALUES(:Name, :Username, :Email, :Password)";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(":Name", $name);
			$query->bindValue(":Username", $username);
			$query->bindValue(":Email", $email);
			$query->bindValue(":Password", md5($password));
			$result = $query->execute();

			if ($result){
				$msg = "<span class='alert alert-success'><strong>*</strong>Registered successfully!</span>" ;

				return $msg;
			}

		} //end userRegistration

//===========================existance checking=======================================	
		//check email existance
		public function checkEmail($email){
			$sql = "SELECT Email FROM tbl_user WHERE Email=:Email LIMIT 1";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Email', $email);
			$query->execute();

			if ($query->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		//check username existance
		public function checkUsername($username){
			$sql = "SELECT Username FROM tbl_user WHERE Username=:Username LIMIT 1";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Username', $username);
			$query->execute();

			if ($query->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		//check password existance
		public function checkPassword($id, $old_pass){
			$sql = "SELECT Password FROM tbl_user WHERE Id =:Id AND Password=:Password LIMIT 1";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Id', $id);
			$query->bindValue(':Password', md5($old_pass));
			$query->execute();

			if ($query->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}
//====================================================================================	


		//=============Login===================
		public function userLogin($data){
			$usernameEmail = $data['usernameEmail'];
			$password = $data['password'];


			
			if ($usernameEmail =="" OR $password ==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Field must not be empty!</span>" ;

				return $msg;
			}
			
			//checking it is email address or username
			if (filter_var($usernameEmail,FILTER_VALIDATE_EMAIL) == true){
				
				$chk_email = $this->checkEmail($usernameEmail);
				if ($chk_email == false){
					$msg = "<span class='alert alert-danger'><strong>*</strong>Email not exist!</span>" ;

					return $msg;
				}


			}else{

				if (strlen($usernameEmail) < 3){
					$msg = "<span class='alert alert-danger'><strong>*</strong> Username is too short!</span>" ;

					return $msg;

				}elseif(preg_match('/[^a-z0-9_-]+/i',$usernameEmail)){
					$msg = "<span class='alert alert-danger'><strong>*</strong> Username must contain only alphanumeric,dashes,underscore!</span>" ;

					return $msg;
				}

				$chk_username = $this->checkUsername($usernameEmail);
				if ($chk_username == false){
					$msg = "<span class='alert alert-danger'><strong>*</strong>Username not exist!</span>" ;

					return $msg;
				}


			} 


			$value = $this->getRegisteredUser($usernameEmail, $password);
			if ($value){
				Session::init();
				Session::set('login', true);
				Session::set('id', $value->Id);
				Session::set('name', $value->Name);
				Session::set('username', $value->Username);
				Session::set('loginMsg', "<span class='alert alert-success'><strong>*</strong>Successfully logged in!</span>");

				header("Location:index.php");

			}else{
				$msg = "<span class='alert alert-danger'><strong>*</strong>Incorrect email or password!</span>" ;

				return $msg;
			}



		} //end userLogin

		// check user is registered or not
		public function getRegisteredUser($usernameEmail, $password){
			$password = md5($password);

			$sql = "SELECT * FROM tbl_user WHERE (Email=:usernameEmail OR Username=:usernameEmail) AND Password =:Password LIMIT 1";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':usernameEmail', $usernameEmail);
			$query->bindValue(':Password', $password);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);

			return $result;
		}



		//=====================select User Data==========================
		public function selectData(){
			$sql = "SELECT * FROM tbl_user ORDER BY Id ASC";
			$query = $this->db->conn->prepare($sql);

			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_OBJ);
			return $result;
		}

		//======================update user data========================
		public function getEmployeeById($id){
			$sql = "SELECT * FROM tbl_user WHERE Id =:Id ";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue('Id', $id);
			$query->execute();

			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function updateData($id,$data){
			$name = $data['name'];
			$username = $data['username'];
			$email = $data['email'];
			

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


			$sql = "UPDATE tbl_user 
					SET Name =:Name, Username =:Username, Email =:Email WHERE Id =:Id";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Id', $id);
			$query->bindValue(':Name', $name);
			$query->bindValue(':Username', $username);
			$query->bindValue(':Email', $email);

			$update_row = $query->execute();		  

			if ($update_row){
				$msg = "<span class='alert alert-success'><strong>*</strong>Updated Successfully!</span>" ;
				return $msg;
			}


		}



		//=======================Delete User data=========================
		public function deleteData($id){
			
				$sql = "DELETE FROM tbl_user WHERE Id =:Id";
				$query = $this->db->conn->prepare($sql);

				$query->bindValue(':Id', $id);
				$query->execute();

				header('Location:index.php');

		}
		


		//==================change Password========================
		public function updatePassword($id,$data){
			$old_pass = $data['old_password'];
			$new_pass = $data['new_password'];


			if ($old_pass =="" OR $new_pass ==""){
				$msg = "<span class='alert alert-danger'><strong>*</strong> Field must not be empty!</span>" ;

				return $msg;
			}

			if (strlen($new_pass) < 6){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password should be 6 or more characters!</span>" ;

				return $msg;
			}

			$chk_pass = $this->checkPassword($id, $old_pass);
			if ($chk_pass == false){
				$msg = "<span class='alert alert-danger'><strong>*</strong>Old password not matched!</span>" ;

				return $msg;

			}


			$sql = "UPDATE tbl_user
					SET Password =:Password WHERE Id =:Id ";
			$query = $this->db->conn->prepare($sql);

			$query->bindValue(':Id', $id);
			$query->bindValue(':Password',	md5($new_pass));

			$result = $query->execute();

			if ($result){
				$msg = "<span class='alert alert-success'><strong>*</strong>Password updated successfully!</span>" ;

				return $msg;

			}else{
				$msg = "<span class='alert alert-danger'><strong>*</strong>Password Not Updated!</span>" ;

				return $msg;

			}

		}






	} //end Process class

?>
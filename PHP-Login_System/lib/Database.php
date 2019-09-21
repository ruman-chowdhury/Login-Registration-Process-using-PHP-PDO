<?php
  
  class Database{
    
    private $servername = "localhost";
    private $db_name = "db_login";
    private $db_user = "root";
    private $db_pass = "";
    
    public $conn; //global property

    public function __construct(){
      
    	if (!isset($this->conn)){
    		
    		try{
    			//creating object of PDO class,passing arguments to its constructor.
		    	//we are accessing Database class property from inside method,that's why 'this' keyword
		      $pdo_obj = new PDO("mysql:host=".$this->servername. ";dbname=".$this->db_name, $this->db_user,$this->db_pass);

		      
		      $pdo_obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      $pdo_obj->exec("SET character set utf8");
		      $this->conn = $pdo_obj; //assign $pdo_obj to global '$conn'
		      //echo "Connected successfully";


    		}catch(PDOException $e){
    			die("Connection Failed! ".$e->getMessage()); 
                //if not connected,it will show message and will stop the program

    		}


    	}//if condition

    }//constructor




  }//Database class

?>
<?php
require_once 'dbSetting.php';
$db = new DBHandler;
$con = $db->connect();
$username = $db->SecurityCheck($con, $_POST['username']);
$password = $db->SecurityCheck($con, $_POST['password']);
$email =  $db->SecurityCheck($con, $_POST['email']);
$role = $db->SecurityCheck($con, $_POST['role']);
VerifyEnteredData($username, $password, $email,$role); // Verify if the data is correct
if ($role != 3383567736368 && $role != 2666864228466) { // Check if the role is valid
	header('Location: ../php_template/RegisterHtml.php?erreur=6');
	exit();
}elseif ($role == 3383567736368) {
	$role = "developpement";
}elseif ($role == 2666864228466) {
	$role = "communication";
}
$longueurKey = 15;
$key = "";
for ($i = 1; $i < $longueurKey; $i++) { //Generate a random key
	$key .= mt_rand(0, 9);
}
$newUsers = new Users($db->IdGenrerate(), $username, $password, $email, $key,$role); // Create a new Users object
$newUsers->dbUserPush(); // Call the dbUserPush function


class Users
{
	public  $id;
	public $name;
	public $password;
	public $email;
	public $key;
	public $db;
	public $role;
	function __construct($id, $name, $password, $email, $key,$role)
	{
		$this->id = $id;
		$this->name = $name;
		$this->password = password_hash($password, PASSWORD_DEFAULT);
		$this->email = $email;
		$this->key = $key;
		$this->db = new DBHandler;
		$this->role = $role;
	}
	public function dbUserPush()
	{
		$data = array(
			"id" => $this->id,
			"name" => $this->name,
			"password" => $this->password,
			"email" => $this->email,
			"confirmkey" => $this->key,
			"role" => $this->role
		);
		$this->db->getFromDbByParam("users", "email", $this->email); 
		if ($this->db->getFromDbByParam("users", "email", $this->email) != null) {// Check if the username is already taken
			header('Location: ../php_template/RegisterHtml.php?erreur=4');
			exit();
		} else {
			$this->db->insert($data, 'users'); // Insert the data into the database
			SendMail($this->email, $this->key, $this->name); // Call the SendMail function
			header('Location: ../php_template/loginHtml.php');
		}
	}
}
function VerifyEnteredData($username, $password, $email,$role)
{
	if (!isset($username, $password, $email,$role)) { // Check if the data is set
		header('Location: /..php_template/RegisterHtml.php?erreur=1');
		exit();
	}
	if (empty($username) || empty($password) || empty($email)|| empty($role)) { // Check if the data is empty
		header('Location: ../php_template/RegisterHtml.php?erreur=1');
		exit();
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Check if the email is valid
		header('Location: ../php_template/RegisterHtml.php?erreur=2');
		exit();
	}
	if (preg_match('/[A-Za-z0-9]+/', $username) == 0) { // Check if the username is valid
		header('Location: ../php_template/RegisterHtml.php?erreur=3');
		exit();
	}
	if (preg_match('/[0-9]+/', $role)==0) { // Check if the role is valid
		header('Location: ../php_template/RegisterHtml.php?erreur=5');
		exit();
	}
}
	function SendMail($email,$key,$username){ // Send a mail to the user
			$to = $email;
			$header = "From: habitenforcer66@gmail.com";
			$header.='Content-Type:text/html; charset="uft-8"'."\n";
			$header.='Content-Transfer-Encoding: 8bit';
        	$subject = "mail de confirmation";
        	$message ="https://ypn666.000webhostapp.com/HACKATHON/function/confirm.php?username=" . urlencode($username) . "&key=" . $key;
        	mail($to,$subject,$message,$header);
	}
?>
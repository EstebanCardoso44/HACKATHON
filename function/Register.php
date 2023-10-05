<?php
error_reporting(0);  // Turn off all error reporting
ini_set('display_errors', 0);  // Don't display errors to the user
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

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
			"verif" => 0,
			"confirmkey" => $this->key,
			"role" => $this->role
		);
		$this->db->getFromDbByParam("users", "Email", $this->email); 
		if ($this->db->getFromDbByParam("users", "Email", $this->email) != null && $this->db->getFromDbByParam("users", "name", $this->name) != null ) {// Check if the username is already taken
			header('Location: ../php_template/RegisterHtml.php?erreur=4');
			exit();
		} else {
				$this->db->insert($data, 'users'); // Insert the data into the database
			SendMail($this->email, $this->key, $this->name); // Call the SendMail function
				
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
		$mail = new PHPMailer;
		$mail->isSMTP(); 
		$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
		$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
		$mail->Port = 587; // TLS only
		$mail->SMTPSecure = 'tls'; // ssl is deprecated
		$mail->SMTPAuth = true;
		$mail->Username = 'hackathonynov@gmail.com'; // email
		$mail->Password = 'gjnf rrzj dqyv ltjj'; // password
		$mail->setFrom('hackathonynov@gmail.com', 'Adrien Raynaud'); // From email and name
		$mail->addAddress($email, $username); // to email and name
		$mail->Subject = 'mail de confirmation';
		$mail->msgHTML("https://ypn666.000webhostapp.com/HACKATHON/function/confirm.php?username=" . urlencode($username) . "&key=" . $key); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
		$mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
		// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
		$mail->SMTPOptions = array(
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);
						if(!$mail->send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
		header('Location: ../php_template/loginHtml.php');
				exit();
		}
	}
?>


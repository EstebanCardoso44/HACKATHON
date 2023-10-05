<?php
require_once 'dbSetting.php';
$re = new Confirm;
$re->confirm();
class Confirm {
    public function __construct() {
    }
    public function confirm() {
        $db = new DBHandler;
        $con = $db->connect();
        if (isset($_GET['username']) && isset($_GET['key']) AND !empty($_GET['username']) AND !empty($_GET['key'])) {
            $username = $db->SecurityCheck($con, $_GET['username']);
            $key = $_GET['key'];
            $requser = $con->prepare("SELECT * FROM users WHERE name = ? AND confirmkey = ?");
            $requser-> execute(array($username, $key));
            $userexist = $requser->fetch();
            $userAdd = $db -> getConfimeWithName("users", $username);
            if ($userexist != null) {
                $user = $requser->fetch();
                if ($user['verif'] == 0) {
                    try{
                        $updateUser = $con->prepare("UPDATE users SET verif = 1 WHERE name = ? AND confirmkey = ?");
                    $updateUser->execute(array($username, $key));
                    }catch(Exception $e){
                        header('Location: ../php_template/loginHtml.php');
                    }
                    exit();
                
                } else {
                    echo "Votre compte a déjà été confirmé !";
                }
            }else {
                echo "L'utilisateur n'existe pas !";
            }
        }else {
            echo "Erreur";
        }
            }
        }
?>
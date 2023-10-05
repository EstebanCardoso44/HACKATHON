<?php
date_default_timezone_set('Europe/Paris');
class DBHandler
{
    private $name;
    private $user;
    private $password;
    private $host;

    function __construct()
    {
        $this->name = 'id21350906_hackathon';
        $this->user = 'id21350906_root';
        $this->password = 'root49*A';
        $this->host = 'localhost';
    }

    public function connect()
    {
        $link = mysqli_connect($this->host, $this->user, $this->password, $this->name);
        return $link;
    }

    public function insert(array $data, string $table)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $columns = array_keys($data);
        $values = array_values($data);
        $sql = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (\"" . implode("\", \"", $values) . "\" )";
        if ($stmt = $con->prepare($sql)) {
            $stmt->execute();
        } else {
            echo "there has been an issue with : " . $sql . " " . mysqli_error($con);
        }
        mysqli_close($con);
    }


    public function getFromDbByParam(string $table, string $param, string $condition)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM " . $table . " WHERE " . $param . " = '" . $condition . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $result = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $result->fetch_assoc();
    }

    public function getConfimeWithName(string $table, string $name)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $sql = "SELECT verif FROM " . $table . " WHERE name = '" . $name . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $resultQuerry = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $resultQuerry->fetch_assoc()['verif'];
    }
    public function IdGenrerate()
    {
        $id = uniqid();
        $id = str_replace(".", "", $id);
        return $id;
    }


    function SecurityCheck($con, $data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($con, $data);
        return $data;
    }

    public function getPasswordWithName(string $table, string $name)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $date = date("Y-m-d H:i:s", time());
        $sql = "SELECT password FROM " . $table . " WHERE name = '" . $name . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $resultQuerry = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $resultQuerry->fetch_assoc()['password'];
    }
    
    public function getIDwithName(string $table, string $name)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $sql = "SELECT ID FROM " . $table . " WHERE name = '" . $name . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $resultQuerry = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $resultQuerry->fetch_assoc()['id'];
    }
    
    public function getEmailwithName(string $table, string $name)
    {
        $con = $this->connect();
        if ($con == false) {
            die("ERROR : couldn't connect properly to database : " . mysqli_connect_error());
        }
        $sql = "SELECT Email FROM " . $table . " WHERE name = '" . $name . "'";
        if ($request = $con->prepare($sql)) {
            $request->execute();
            $resultQuerry = $request->get_result();
        } else {
            die("Can't prepare the sql request properly : " . $sql . " " . mysqli_error($con));
        }
        mysqli_close($con);
        return $resultQuerry->fetch_assoc()['email'];
    }
    public function Haiku (){
         $dansLeReseau = true;
        $vpn = true;

        if ($vpn) {
        $stealth = true;
        if ($dansLeReseau && $stealth) {
            ("Dans le vaste réseau,");
            ("Un VPN, tel un fantôme,");
            ("Masque mes pas secrets.");
        }
        }
    }
}

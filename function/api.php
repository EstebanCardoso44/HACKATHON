<?php
$con = mysqli_connect("localhost", "root","root","hackathon");
$response = array();
if($con) {
$sql = "select * from users";
$result = mysqli_query($con,$sql);
if($result) {
    header("Content-Type: JSON");
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
    $response[$i]['id'] = $row['id'];
    $response[$i]['Name'] = $row['Name'];
    $response[$i]['Email'] = $row['Email'];
    $response[$i]['confirmkey'] = $row['confirmkey'];
    $response[$i]['password'] = $row['password'];
    $i++;}
}
echo json_encode($response, JSON_PRETTY_PRINT);
}
?>      
<?php
$con = mysqli_connect("localhost", "id21350906_root","root49*A","id21350906_hackathon");
$response = array();
if($con) {
$sql = "SELECT * FROM users WHERE verif = 1";
$result = mysqli_query($con,$sql);
if($result) {
    header("Content-Type: JSON");
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
    $response[$i]['Email'] = $row['Email'];
    $i++;}
}
echo json_encode($response, JSON_PRETTY_PRINT);
}
?>      
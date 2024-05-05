<?php
$name=$_POST['name'];
$mail=$_POST['mail1'];
$password=$_POST['password'];

// var_dump($name,$mail,$password);

$servername="localhost";
$username="root";
$password1="";
$dbname="loginDB";

$conn= mysqli_connect($servername,$username,$password1,$dbname,3307);
if(!$conn){
    die("Connection failed : ".mysqli_connect_error());
}
else{
    $stmt=$conn->prepare("insert into credentials(name,password,email)
    values(?,?,?) ");

    $stmt->bind_param("sss",$name,$password,$mail);
    $stmt->execute();
    echo"registration successfully...";
    $stmt->close();
    $conn->close();
}?>

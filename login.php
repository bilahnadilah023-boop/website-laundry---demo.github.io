<?php 
session_start();
include "koneksi.php";

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($query);

if($cek > 0){

$_SESSION['login'] = true;

header("Location: dashboard.php");

}else{

echo "<script>alert('Username atau Password salah');</script>";

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Laundry</title>

<style>

body{
font-family:Arial;
background:linear-gradient(135deg,#ff9ecf,#ff6fa5);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.login{
background:white;
padding:40px;
width:320px;
border-radius:12px;
box-shadow:0 0 15px rgba(0,0,0,0.2);
text-align:center;
}

.login img{
width:90px;
margin-bottom:10px;
}

h2{
color:#ff4f94;
margin-bottom:20px;
}

input{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ddd;
border-radius:5px;
}

button{
width:100%;
padding:12px;
background:#ff4f94;
color:white;
border:none;
border-radius:6px;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#ff2f7c;
}

</style>
</head>

<body>

<div class="login">

<img src="https://cdn-icons-png.flaticon.com/512/892/892458.png">

<h2>Login Laundry</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>

</form>

</div>

</body>
</html>
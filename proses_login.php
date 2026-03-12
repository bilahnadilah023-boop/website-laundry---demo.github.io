<?php
if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Contoh sederhana: Jika user & pass apa saja, langsung masuk
    if ($user != "" && $pass != "") {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Isi username dan password!'); window.location.href='login.php';</script>";
    }
}
?>
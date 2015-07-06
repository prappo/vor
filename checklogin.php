<?php
include('lib/auto_load.php');
include('lib/config.php');
session_start();
if(isset($_SESSION["username"])){
    header('Location: index.php');
}
include('lib/function.php');
 
$message = array();

if(!empty($_POST)) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $remember = (isset($_POST['remember'])) ? true : false ;

    db_connect();
    $query = "SELECT * FROM vor_admin where username = ? AND password = ?";

    try{
        $result = $pdo->prepare($query);
        $result->bindParam(1, $username);
        $result->bindParam(2, $password);
        $result->execute();
        if($result->rowCount() > 0) {
            $message['message'] = 1;
            
            $_SESSION["username"] = $_POST["username"];
            $date = date("l jS \of F Y h:i:s A");
            $content = $username." loged in";
            $ip = $_SERVER['REMOTE_ADDR'];
            $pdo->query("UPDATE vor_admin SET last_login = '{$ip}'");
            
            $pdo->query("INSERT INTO vor_notify(class, content, time, status) VALUES('info', '$content', '$date', 'unread')");
        } else {
            $message['message'] = 0;
        }
    } catch(PDOException $e) {
        echo $e->getMessage().'<br>';
        die();
    }
}

if(!empty($message)) {
    echo json_encode($message);
}
?>
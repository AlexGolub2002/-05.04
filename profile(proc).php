<?php
    header("Content-Type: text/html; charset = utf-8");
    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
    function generateCode($lenght = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while(strlen($code) < $lenght)
        {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
    if(isset($_POST['enter']))
    {
        session_start();
        $login = $_POST['login'];
        $_SESSION['counterforinputmip'] = 0;
        $queryfornotexist = mysqli_query($link, "SELECT ID_users, Password FROM users WHERE Login LIKE '%".mysqli_real_escape_string($link, $_POST['login'])."%'");
        $countrow = mysqli_num_rows($queryfornotexist);
        $assocmasfornotexist = mysqli_fetch_assoc($queryfornotexist);
        if($countrow < 1)
        {
            $_SESSION['is_exist'] = " ";
            header("Location: profile.php");

        }
        else
        {
            if($assocmasfornotexist['Password'] === $_POST['Password'])
            {

                    setcookie("login", $login, time() - 3600, "/", null, null, true);

                    header("Location: index.php");
            }
            else
            {
                    $_SESSION['unknown_log_error'] = " ";
                    header("Location: profile.php");
            }

        }
    }
    if(isset($_POST['registration']))
    {
        session_start();
        $login = $_POST['login'];
        $Password = $_POST['Password'];
        $err = array();
        $queryforexistpatient = mysqli_query($link, "SELECT Login FROM users");
        $countrow = mysqli_num_rows($queryforexistpatient);
        for($i = 0; $i < $countrow; $i++)
        {
            $assocmass = mysqli_fetch_assoc($queryforexistpatient);
            if($assocmass['Login'] === $login)
            {

                $err = " ";
                $_SESSION['exist_patient'] = " ";
                header("Location: profile.php");
                break;
            }
        }
        if(count($err) == 0)
        {
 
            $insertinpatients = mysqli_query($link, "INSERT INTO users VALUES(NULL, '".$login."', '".$Password."')");
            if($insertinpatients)
            {

                setcookie("login", $login, time() + 3600, "/", null, null, true);
                header("Location: profile.php");
            }
            else
            {

                $_SESSION['unknown_reg_error'] = " ";
                header("Location: profile.php");
            }
        }
        else
        {

           header("Location: profile.php");
        }
    }



?>
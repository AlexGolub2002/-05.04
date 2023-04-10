<?php
    header("Content-Type: text/html; charset = utf-8");
    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
    session_start();
    if(isset($_COOKIE['login']))
    {
        header("Location: index.php");
    }
    else
    {
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style3.css">
    <link rel="shortcut icon" href="image\1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script2.js " defer></script>
    <title>Профиль</title>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <div class="header__profile"><img src="image\profile.png" ail="Профиль"></div>
                <div class="profile__title">Профиль</div>
                <div class="header__logo"><a href="index.php"><img class="logo" src="image\1.png" alt="Логотип"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="container _container">
        <selection class="block">
            <div class="block__item block-item">
                <h2 class="block-item__title">Уже есть аккаунт?</h2>
                <button class="block-item__btn signin-btn">Войти</button>
            </div>
            <div class="block__item block-item">
                <h2 class="block-item__title">Нет аккаунта?</h2>
                <button class="block-item__btn signup-btn">Зарегистрироваться</button>
            </div>
        </selection>
        <div class="form-box">
            <form action="profile(proc).php"  method="POST" class="form form_signin">
                <h3 class="form__title">Вход</h3>
                <p>
                    <input class="form__input" name="login" id="FIO_input_id" type="text" placeholder="Введите логин" pattern="^[-A-Za-z0-9_@\.]+$" minlength="5" maxlength="50" required><br>
                </p>
                <p>
                    <input class="form__input" name="Password" id="mip_input_id" type="password" placeholder="Введите пароль" pattern="^[-A-Za-z0-9_@\.]+$" minlength="10" maxlength="50" required>
                </p>
                <p>
                    <button class="form__btn" name = "enter" type="submit">Войти</button>
                </p>
            </form>
            
            <form action="profile(proc).php" method="POST" class="form form_signup">
                <h3 class="form__title">Регистрация</h3>
                <p>
                    <input class="form__input" name="login" id="FIO_input_id" type="text" placeholder="Введите логин" pattern="^[-A-Za-z0-9_@\.]+$" minlength="5" maxlength="50" required><br>
                </p>
                <p>
                <input class="form__input" name="Password" id="mip_input_id" type="password" placeholder="Введите пароль" pattern="^[-A-Za-z0-9_@\.]+$" minlength="10" maxlength="50" required>
                </p>
                <p>
                    <button name = "registration" type="submit" class="form__btn form__btn_signup">Зарегистрироваться</button>
                </p>

            </form>
        </div>
            <script type="text/javascript">
                    let fio_by_id = document.getElementById('FIO_input_id');
                    let mip_by_id = document.getElementById('mip_input_id');
                    fio_by_id.addEventListener("input", function (event) {
                        if(fio_by_id.validity.patternMismatch && fio_by_id.validity.tooShort) {
                            fio_by_id.setCustomValidity("Логин может состоять только из букв английского алфавита, пробелов и дефисов!\nЛогин пациента может быть длиной от 5 до 50 символов!");
                        }
                        else if(fio_by_id.validity.patternMismatch) {
                            fio_by_id.setCustomValidity("Логин  может состоять только из букв английского алфавита, пробелов и дефисов!");
                        }
                        else if(fio_by_id.validity.tooShort) {
                            fio_by_id.setCustomValidity("Логин может быть длиной от 5 до 200 символов!");
                        }
                        else {
                            fio_by_id.setCustomValidity("");
                        }
                    });
                    mip_by_id.addEventListener("input", function (event) {
                        if(mip_by_id.validity.patternMismatch && mip_by_id.validity.tooShort) {
                            mip_by_id.setCustomValidity("Пароль может состоять только из букв английского алфавита, пробелов и дефисов!\nЛогин пациента может быть длиной от 5 до 50 символов!");
                        }
                        else if(mip_by_id.patternMismatch) {
                            mip_by_id.setCustomValidity("Пароль может состоять только из букв английского алфавита, пробелов и дефисов!");
                        }
                        else if(mip_by_id.validity.tooShort) {
                            mip_by_id.setCustomValidity("Пароль может быть длиной от 5 до 200 символов!");
                        }
                        else {
                            mip_by_id.setCustomValidity("");
                        }
                    });
                </script>
                <?php
                    if(isset($_SESSION['is_exist']))
                    {
                ?>
                        <div class="with_message1_div">
                            <p class="not_exist_message_reg">Пользователя с такими данными не существует! Пройдите регистрацию &uArr;</p>
                        </div>
                        <div class="with_message2_div">
                            <p class="error">При входе произошла ошибка</p>
                        </div>
                <?php
                    }
                    if(isset($_SESSION['wrong_mip']))
                    {
                ?>
                        <div class="with_message3_div">
                            <p class="wrong">Введён неправильно пароль</p>
                        </div>
                        <?php
                            if(isset($_SESSION['block_message']))
                            {
                        ?>
                                <div class="with_block_message_div">
                                    <p class="block_message">Доступ к вашему личному кабинету был заблокирован, так как слишком много раз был введён неправильный номер СМП</p>
                                </div>
                        <?php
                            }
                        ?>
                <?php
                    }
                    if(isset($_SESSION['unknown_log_error']))
                    {
                ?>
                        <div class="with_unknown_error_div">
                            <p class="unknown_error">При входе произошла неизвестная ошибка</p>
                        </div>
                <?php
                    }
                ?>

                <?php
                    session_destroy();
                ?>
    </div>
</body>

</html>
<?php
    }
?>
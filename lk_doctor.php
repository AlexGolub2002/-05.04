<?php
    header("Content-Type: text/html; charset = utf-8");
    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
    if(isset($_COOKIE['doctors_name']) && isset($_COOKIE['doctors_reg_log_ip']) && isset($_COOKIE['doctors_reg_log_hash']))
    {
        $stringarray = explode(" ", $_COOKIE['doctors_name']);
        $queryforoutFIO = mysqli_query($link, "SELECT doctors_name FROM Doctors WHERE doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmasoutFIO = mysqli_fetch_assoc($queryforoutFIO);
        $queryforspecialization_id = mysqli_query($link, "SELECT Specialization.specialization_name FROM Specialization, Doctors WHERE Specialization.specialization_id  = Doctors.specialization_id AND doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmasspecialization_id = mysqli_fetch_assoc($queryforspecialization_id);
        $queryforcabinets_id = mysqli_query($link, "SELECT Cabinets.cabinets_number  FROM Cabinets, Doctors WHERE Cabinets.cabinets_id  = Doctors.cabinets_id AND doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmascabinets_id = mysqli_fetch_assoc($queryforcabinets_id);
        $queryfordoctors_work_day_start = mysqli_query($link, "SELECT doctors_work_day_start FROM Doctors WHERE doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmasdoctors_work_day_start = mysqli_fetch_assoc($queryfordoctors_work_day_start);
        $queryfordoctors_work_day_end = mysqli_query($link, "SELECT doctors_work_day_end  FROM Doctors WHERE doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmasdoctors_work_day_end = mysqli_fetch_assoc($queryfordoctors_work_day_end);
        $queryfordoctors_photo = mysqli_query($link, "SELECT doctors_photo FROM Doctors WHERE doctors_name = '".$_COOKIE['doctors_name']."'");
        $assocmasdoctors_photo = mysqli_fetch_assoc($queryfordoctors_photo);
        
?>
        <!DOCTYPE html>
        <html lang="ru">
        <!-- заголовок -->
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Личный кабинет врача</title>
            <link rel="shortcut icon" href="imgico/favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="lk_doctor.css" type="text/css">
        </head>
        <body>
            <!-- верхний слой -->
            <div class="upper_div">
                <!-- картинка с сердцем -->
                <img class="heart_image" src="img/g.png" alt="сердце">
                <!-- надпись "Поликлиника" -->
                <p class="insc_clinic">Поликлиника</p>
            </div>
            <!-- слой с фоном -->
            <div class="biggest_div">
                <!-- надпись "Главная" и ссылка -->
                <p class="insc_main_page"><a class="main_page_ref" href="index.php">Главная</a></p>
            <div style="display:inline-flex; justify-content: space-between; white-space: nowrap; position: relative;">
                <h1 style="margin-left:60px; margin-top: 30px; font-size: 60px; color: #0B9933; margin-bottom: 0px; height: 70px;">Личный кабинет</h1>
                <p class="greeting_doctor">Приветствуем вас, <?php echo $stringarray[1] ?>!</p>
                <button class="logout_btn" onclick="document.location='logoutdoctor.php'" type="button">Выйти</button>
                <div style="margin-right: 25% ; font-size: 30px; position: relative; height: 919px;">
                    <h1 style=" margin-top: 42px; font-size: 40px; ">Персональные данные</h1>

                    <p class="insc_patient_FIO">ФИО врача: <?php echo $assocmasoutFIO['doctors_name']; ?></p>
                    <p class="insc_birth_date">Специальность: <?php echo $assocmasspecialization_id['specialization_name']; ?></p>
                    <p class="insc_mip_number">Кабинет: <?php echo $assocmascabinets_id['cabinets_number']; ?></p>
                    <p class="insc_passport_number">Начало рабочего дня: <?php echo $assocmasdoctors_work_day_start['doctors_work_day_start']; ?></p>
                    <p class="insc_patient_address">Конец рабочего дня: <?php echo $assocmasdoctors_work_day_end['doctors_work_day_end']; ?></p>
                    <p class="insc_status">Фото врача:</p>
                    <img style = "width: 382px; height: 335px;" src = '<?php echo $assocmasdoctors_photo['doctors_photo']; ?>'>

                    <h6><a class = "insc_bl" href="Patient_personal_card(main).php">Электронная карта пaциентов</a></h6>
                    <h6><a class = "insc_bl" href="grafic.php">График работы</a></h6>
                    <h6><a class = "insc_bl" href="appointment_(main).php">Запись на приём</a></h6>
                    <h6><a class = "insc_bl" href="visit_history_doctor(main).php">История приёмов</a></h6>
                </div>
                <div style="margin-top: 10%; position: absolute; white-space:nowrap; font-size: 14px; width: 885px;">
                    <h2 style="margin-left: 18px; margin-top: -5%;">Расписание</a> 

                    <?php
                            $query = mysqli_query($link, "SELECT Coupons.coupons_id, Coupons.coupons_date, Schedule.schedule_timetable, Doctors.doctors_name, Patients.patients_name, Cabinets.cabinets_number FROM Coupons, Schedule, Doctors, Patients, Cabinets
                            WHERE Coupons.schedule_id = Schedule.schedule_id AND Coupons.doctors_id = Doctors.doctors_id AND Coupons.patients_id = Patients.patients_id AND Coupons.cabinets_id = Cabinets.cabinets_id AND doctors_name = '".$_COOKIE['doctors_name']."'");
                            $count_row = mysqli_num_rows($query);
                            echo '<table border = "1px" style = "margin-top: 2.5%; height: 130px; font-size: 18px;">
                            <tr style="text-align:center; font-weight: bold; border: 1px solid #000000;">
                                <td>ID</td>
                                <td>Дата приёма</td>
                                <td>Время приёма</td>
                                <td>ФИО врача</td>
                                <td>ФИО пациента</td>
                                <td>Номер кабинета</td>
                            </tr>';
                            for ($i = 0; $i < $count_row; $i++)
                            {
                                $row = mysqli_fetch_row($query);
                                echo "<tr>";
                                for($j = 0; $j < 6; $j++)
                                {
                                
                                    echo "<td style='text-align: center'; border: 1px solid #000000;>".$row[$j]."</td>";
                                }
                                echo "</tr>";
                            }
                            echo '</table>';

                        ?>

                </div>
            </div>
            </div>
        </body>
        </html>
<?php
    }
    else
    {
?>
        <!DOCTYPE html>
        <html lang="ru">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Личный кабинет</title>
                <link rel="shortcut icon" href="imgico/favicon.ico" type="image/x-icon">
                <link rel="stylesheet" href="styles/personalstyle.css" type="text/css">
            </head>
            <body>
                <div class="all_page_div">
                    <p class="not_log_cookie_message">Вход не выполнен или время cookie истекло. Войдите, пожалуйста, в личный кабинет</p>
                    <p class="insc_to_log"><a class="to_log_ref" href="logindoctoradmin_(main).php">Войти</a></p>
                </div>
            </body>
        </html>
<?php
    }
?>
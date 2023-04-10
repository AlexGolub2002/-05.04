<?php
    header("Content-Type: text/html; charset = utf-8");
    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
    session_start();
    $_SESSION['delete'];
    $_SESSION['sql'];
    // if(isset($_COOKIE['login']))
    // {
    //     header("Location: Manufacturers.php");
    // }
    // else
    // {
        require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
        require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
        require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
        if(isset($_POST['Upload']))
        {
            $xls = new PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            
            // Шапка
            $sheet->getStyle("A1:E1")->getFont()->setBold(true);
            $sheet->setCellValue("A1", 'Уникальный номер производства');
            $sheet->setCellValue("B1", 'Название производителя');
            $sheet->setCellValue("C1", 'Адрес производства');
            $sheet->setCellValue("D1", 'Название категории');
            $sheet->setCellValue("E1", 'Название подкатегории');
            
            $sheet->getColumnDimension("A")->setWidth(7);
            $sheet->getColumnDimension("B")->setWidth(35);
            $sheet->getColumnDimension("C")->setWidth(25);
            $sheet->getColumnDimension("D")->setWidth(40);
            $sheet->getColumnDimension("E")->setWidth(10);
            // Выборка из БД
            $sth = mysqli_query($link, $_SESSION['sql']);
            $items = mysqli_fetch_all($sth, MYSQLI_ASSOC);
            $index = 2;
            foreach($items as $row)
            {
                $sheet->setCellValue("A" . $index, $row['ID_manufacturers']);
                $sheet->setCellValue("B" . $index, $row['title_manufacturers']);
                $sheet->setCellValue("C" . $index, $row['address_manufacturers']);
                $sheet->setCellValue("D" . $index, $row['product_category_manufacturers']);
                $sheet->setCellValue("E" . $index, $row['subcategory_manufacturers']);
                $index++;
            }
            
            // Отдача файла в браузер
            // ob_end_clean();
            header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=Производители.xls");
            $objWriter = PHPExcel_IOFactory::createWriter($xls, "Excel2007");
            $objWriter->save('php://output');
            exit();
        }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <link rel="stylesheet" href="manufacturers.css">
    <link rel="shortcut icon" href="image\1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Производители</title>
</head>

<body>
<header class="header">
        <div class="container">
            <!-- <div class="header__inner"> -->
                <!-- <div class="header__logo"> -->
                    <a class="logo_ref" href="index.php"><img class="logo" src="image\1.png" alt="Логотип"></a>
                <!-- </div> -->
                <div class="nav">
                    <a class="nav__link" href="Sales.php">Продажи</a>
                    <a class="nav__link" href="Products.php">Товары</a>
                    <a class="nav__link" href="Manufacturers.php">Производители</a>
                </div>
                <!-- <div class="header__profile"><a href="profile.php"><img src="image\profile.png" ail="Профиль"></a> -->
            <!-- </div> -->
        </div>
    </header>

    
        <div style="position: relative; white-space:nowrap; font-size: 14px;margin: 1% auto;width: 55%;height: 821px;">
                    <h2 style=" margin-top: -5%; text-align: center;"></a> 

                    <form class="bt1" action="Manufacturers.php" method="GET" enctype="multipart/form-data">
                                <div class="bt11">
                                <p  style="text-decoration: underline;">Производители</p>
                                        <p>Наименование производителя:</p>
                                        <input type = 'text' name = 'title_manufacturers'><br>
                                        <p>Введите название категории:</p>
                                        <select name="product_category_manufacturers">
                                            <option></option>
                                            <?php
                                                $query_for_time = mysqli_query($link, "SELECT DISTINCT category_product FROM Product_categories ORDER BY category_product ASC");
                                                $count_row = mysqli_num_rows($query_for_time);
                                                    for($i1 = 0; $i1 < $count_row; $i1++)
                                                    {
                                                            $row = mysqli_fetch_row($query_for_time);
                                                            for($i2 = 0; $i2 < 1; $i2++)
                                                            {
                                                                    
    
                                                                echo "<option>".$row[$i2]."</option>";
                                                            }
                                                    }
                                            ?>
                                        </select></p>
                                        <p>Введите название подкатегории:</p>
                                        <select name="subcategory_manufacturers">
                                            <option></option>
                                            <?php
                                                $query_for_time = mysqli_query($link, "SELECT DISTINCT subcategory_product FROM Product_categories ORDER BY subcategory_product ASC");
                                                $count_row = mysqli_num_rows($query_for_time);
                                                    for($i1 = 0; $i1 < $count_row; $i1++)
                                                        {
                                                            $row = mysqli_fetch_row($query_for_time);
                                                            for($i2 = 0; $i2 < 1; $i2++)
                                                            {
                                                                echo "<option>".$row[$i2]."</option>";
                                                            }
                                                        }

                                            ?><br>
                                        </select></p>
                                        <input type = 'submit' name = 'filteranu' value = 'Отфильтровать'>
                    </form>
                    <?php
                                $erru = array();
                                if(isset($_GET['filteranu']))
                                {
                                    $title_manufacturers = $_GET['title_manufacturers'];
                                    $product_category_manufacturers = $_GET['product_category_manufacturers'];
                                    $subcategory_manufacturers = $_GET['subcategory_manufacturers'];


                                    if(count($erru) == 0)
                                    {
                                        if(empty($title_manufacturers) && empty($product_category_manufacturers) && empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers";
                                        }
                                        if(!empty($title_manufacturers) && empty($product_category_manufacturers) && empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%'";
                                        }
                                        if(empty($title_manufacturers) && !empty($product_category_manufacturers) && empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%'";
                                        }
                                        if(empty($title_manufacturers) && empty($product_category_manufacturers) && !empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers WHERE subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                        }
                                        if(!empty($title_manufacturers) && !empty($product_category_manufacturers) && empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND product_category_manufacturers LIKE '%".$product_category_manufacturers."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND product_category_manufacturers LIKE '%".$product_category_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND product_category_manufacturers LIKE '%".$product_category_manufacturers."%'";
                                        }
                                        if(!empty($title_manufacturers) && empty($product_category_manufacturers) && !empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE title_manufacturers LIKE '%".$title_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                        }
                                        if(empty($title_manufacturers) && !empty($product_category_manufacturers) && !empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'");
                                            $_SESSION['sql'] = "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%'";
                                        }
                                        if(!empty($title_manufacturers) && !empty($product_category_manufacturers) && !empty($subcategory_manufacturers))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%' AND title_manufacturers LIKE '%".$title_manufacturers."%'");
                                            $_SESSION['sql'] = "SELECT * FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%' AND title_manufacturers LIKE '%".$title_manufacturers."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Manufacturers WHERE product_category_manufacturers LIKE '%".$product_category_manufacturers."%' AND subcategory_manufacturers LIKE '%".$subcategory_manufacturers."%' AND title_manufacturers LIKE '%".$title_manufacturers."%'";
                                        }
                                        $countrow = mysqli_num_rows($query);
                                        if($countrow < 1)
                                        {
                                            echo "<p style = 'font-size: 20px'>Не найдено</p>";
                                        }
                                        else
                                        {
                                            echo "<h1>Таблица: Производители</h1>";
                                            echo "<h3>Количество позиций: ".$countrow."</h3>";
                                            $count_row = mysqli_num_rows($query);
                                            echo '<table border = "1px solid grey" style = "margin-top: 2.5%; height: 250px; font-size: 12px; background: #FFDBB9; color: grey;;
                                            border-radius: 20px; display: block; overflow-x: auto; white-space: nowrap;">
                                            <tr style="text-align:center; font-weight: bold;position: -webkit-sticky;position: sticky;top: -3px;z-index: 2;background: #FFDBB9;">  

                                                <th>Уникальный номер производства</th>
                                                <th>Название производителя</th>
                                                <th>Адрес производства</th>
                                                <th>Название категории</th>
                                                <th>Название подкатегории</th>
                                            </tr>';
                                        }
                                        for ($i = 0; $i < $count_row; $i++)
                                        {
                                            $row = mysqli_fetch_row($query);
                                            echo "<tr>";
                                            for($j = 0; $j < 5; $j++)
                                            {
                                            
                                                echo "<td style='text-align: center';>".$row[$j]."</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        echo '</table>';

                                    }
                                }
                                // require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
                                // require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
                                // require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
                                            // if(isset($_POST['Upload']))
                                            // {
                                            //     $xls = new PHPExcel();
                                            //     $xls->setActiveSheetIndex(0);
                                            //     $sheet = $xls->getActiveSheet();
                                                
                                            //     // Шапка
                                            //     $sheet->getStyle("A1:E1")->getFont()->setBold(true);
                                            //     $sheet->setCellValue("A1", 'Уникальный номер производства');
                                            //     $sheet->setCellValue("B1", 'Название производителя');
                                            //     $sheet->setCellValue("C1", 'Адрес производства');
                                            //     $sheet->setCellValue("D1", 'Название категории');
                                            //     $sheet->setCellValue("E1", 'Название подкатегории');
                                            //     // Выборка из БД
                                            //     $sth = mysqli_query($link, $_SESSION['sql']);
                                            //     $items = mysqli_fetch_all($sth, MYSQLI_ASSOC);
                                            //     $index = 2;
                                            //     foreach($items as $row)
                                            //     {
                                            //         $sheet->setCellValue("A" . $index, $row['ID_manufacturers']);
                                            //         $sheet->setCellValue("B" . $index, $row['title_manufacturers']);
                                            //         $sheet->setCellValue("C" . $index, $row['address_manufacturers']);
                                            //         $sheet->setCellValue("D" . $index, $row['product_category_manufacturers']);
                                            //         $sheet->setCellValue("E" . $index, $row['subcategory_manufacturers']);
                                            //         $index++;
                                            //     }
                                                
                                            //     // Отдача файла в браузер
                                            //     // ob_end_clean();
                                            //     header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                                            //     header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                                            //     header("Cache-Control: no-cache, must-revalidate");
                                            //     header("Pragma: no-cache");
                                            //     header("Content-type: application/vnd.ms-excel");
                                            //     header("Content-Disposition: attachment; filename=Производители.xls");
                                            //     $objWriter = PHPExcel_IOFactory::createWriter($xls, "Excel2007");
                                            //     $objWriter->save('php://output');
                                            //     exit();
                                            // }
                                            if(isset($_POST['App']))
                                            {
                                                    $permittedextensions = '/^(xlsx|xls)/';
                                                    $fileextension = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                                                    $err = array();
                                                    if($_FILES['userfile']['error'] > 0 || $_FILES['userfile']['size'] > 524288000)
                                                    {
                                                        $err = " ";

                                                    }
                                                    if(!preg_match($permittedextensions, $fileextension))
                                                    {
                                                        $err = " ";

                                                    }
                                                    if(count($err) == 0)
                                                    {
                                                        $file = "files/".$_FILES['userfile']['name'];
                                                        move_uploaded_file($_FILES['userfile']['tmp_name'], $file);
                                                        $loadfile = pathinfo($_FILES['userfile']['name'], PATHINFO_BASENAME); // получаем имя загруженного файла
                                                        $objPHPExcel = PHPExcel_IOFactory::load('files/'.$loadfile.'');
                                                        foreach($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
                                                        {
                                                            $highestRow = $worksheet->getHighestRow(); // получаем количество строк
                                                            $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок
                                                            
                                                            for($row = 2; $row <= $highestRow; $row++) // обходим все строки
                                                            {

                                                                $cell2 = $worksheet->getCellByColumnAndRow(1, $row); //наименование
                                                                $cell3 = $worksheet->getCellByColumnAndRow(2, $row); //адрес
                                                                $cell4 = $worksheet->getCellByColumnAndRow(3, $row); //категория
                                                                $cell5 = $worksheet->getCellByColumnAndRow(4, $row); //подкатегория

                                                                $query = mysqli_query($link, "INSERT INTO Manufacturers VALUES(NULL, '".$cell2."', '".$cell3."', '".$cell4."', '".$cell5."')") or die('Ошибка чтения записи: '.mysqli_error($link));
                                                            }
                                                        }
                                                    }
                                            }
                                            if(isset($_POST['Delete']))
                                            {
                                                $query = mysqli_query($link, $_SESSION['delete'].mysqli_error($link));                    
                                            }
                    ?>
                            <form action="Manufacturers.php" method = "POST" enctype = 'multipart/form-data'>
                                <div >
                                    <button name = "Upload" type="submit">Выгрузить</button>
                                    <!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
                                                <form  action="Manufacturers.php" enctype="multipart/form-data" action="__URL__" method="POST">
                                                    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="524288000">
                                                    <!-- Название элемента input определяет имя в массиве $_FILES -->
                                                    <input  name="userfile" type="file">
                                                    <input  type="submit" name = "App" value="Добавить" />
                                                </form>
                                    <button name = "Delete" type="submit">Удалить</button>
                                </div>
                            </form>
                </div>
            </div>

    </body>

    </html>
<?php
//  session_destroy();
    // }
?>
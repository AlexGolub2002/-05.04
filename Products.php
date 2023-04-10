<?php
    header("Content-Type: text/html; charset = utf-8");

    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
    session_start();
    require_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
    require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
    require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

                                            if(isset($_POST['Upload']))
                                            {
                                                $xls = new PHPExcel();
                                                $xls->setActiveSheetIndex(0);
                                                $sheet = $xls->getActiveSheet();
                                                
                                                // Шапка
                                                $sheet->getStyle("A1:I1")->getFont()->setBold(true);
                                                $sheet->setCellValue("A1", 'Уникальный номер');
                                                $sheet->setCellValue("B1", 'Название категории');
                                                $sheet->setCellValue("C1", 'Название подкатегории');
                                                $sheet->setCellValue("D1", 'Наименование продукта');
                                                $sheet->setCellValue("E1", 'Производитель');
                                                $sheet->setCellValue("F1", 'Стоимость');
                                                $sheet->setCellValue("G1", 'Характеристика');
                                                $sheet->setCellValue("H1", 'Вес или количество');
                                                $sheet->setCellValue("I1", 'Упаковка');
                                                
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
                                                    $sheet->setCellValue("A" . $index, $row['ID_products']);
                                                    $sheet->setCellValue("B" . $index, $row['category_products']);
                                                    $sheet->setCellValue("C" . $index, $row['subcategory_products']);
                                                    $sheet->setCellValue("D" . $index, $row['product_name']);
                                                    $sheet->setCellValue("E" . $index, $row['manufacturer_products']);
                                                    $sheet->setCellValue("F" . $index, $row['estimated_cost']);
                                                    $sheet->setCellValue("G" . $index, $row['product_detail']);
                                                    $sheet->setCellValue("H" . $index, $row['weight_quantity_products']);
                                                    $sheet->setCellValue("I" . $index, $row['package_products']);
                                                    $index++;
                                                }
                                                
                                                // Отдача файла в браузер
                                                ob_end_clean();
                                                header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                                                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                                                header("Cache-Control: no-cache, must-revalidate");
                                                header("Pragma: no-cache");
                                                header("Content-type: application/vnd.ms-excel");
                                                header("Content-Disposition: attachment; filename=Товары.xls");
                                                $objWriter = PHPExcel_IOFactory::createWriter($xls, "Excel2007");
                                                $objWriter->save('php://output');
                                                exit();
                                            }
    if(isset($_COOKIE['login']))
    {
        header("Location: Products.php");
    }
    else
    {
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <link rel="stylesheet" href="products.css">
    <link rel="shortcut icon" href="image\1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Товары</title>
</head>

<body>
    <header class="header">
        <div class="container">
            <!-- <div class="header__inner"> -->
                <!-- <div class="header__logo"> -->
                    <a class="logo_ref" href="index.php"><img class="logo" src="image\1.png" alt="Логотип"></a>
                <!-- </div> -->
                <nav class="nav">
                    <a class="nav__link" href="Sales.php">Продажи</a>
                    <a class="nav__link" href="Products.php">Товары</a>
                    <a class="nav__link" href="Manufacturers.php">Производители</a>
                </nav>
                <!-- <div class="header__profile"><a href="profile.php"><img src="image\profile.png" ail="Профиль"></a> -->
                </div>
            <!-- </div> -->
        </div>
    </header>
        <div style="position: relative; white-space:nowrap; font-size: 14px;margin: 1% auto;width: 55%; height: 821px;">
                    <h2 style=" margin-top: -5%; text-align: center;"></a> 

                    <form class="bt1" action="Products.php">
                                <div class="bt11">
                                <form method = 'GET' enctype = 'multipart/form-data' name = 'filteru'>
                                <p  style="text-decoration: underline;">Товары</p>
                                        <p>Наименование товара:</p>
                                        <input type = 'text' name = 'title_products'><br>
                                        <p>Введите название категории:</p>
                                        <select name="product_category_products">
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
                                        <select name="subcategory_products">
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
                                        <input type = 'submit' action="Products.php" name = 'filteranu' value = 'Отфильтровать'>
                                </form>
                    <?php
                                $erru = array();
                                if(isset($_GET['filteranu']))
                                {
                                    $title_products = $_GET['title_products'];
                                    $product_category_products = $_GET['product_category_products'];
                                    $subcategory_products = $_GET['subcategory_products'];


                                    if(count($erru) == 0)
                                    {
                                        if(empty($title_products) && empty($product_category_products) && empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products");
                                            $_SESSION['sql'] =  "SELECT * FROM Products";
                                            $_SESSION['delete'] =  "DELETE FROM Products";
                                        }
                                        if(!empty($title_products) && empty($product_category_products) && empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE product_name LIKE '%".$title_products."%'";
                                        }
                                        if(empty($title_products) && !empty($product_category_products) && empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE category_products LIKE '%".$product_category_products."%'";
                                        }
                                        if(empty($title_products) && empty($product_category_products) && !empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE subcategory_products LIKE '%".$subcategory_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE subcategory_products LIKE '%".$subcategory_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE subcategory_products LIKE '%".$subcategory_products."%'";
                                        }
                                        if(!empty($title_products) && !empty($product_category_products) && empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%' AND category_products LIKE '%".$product_category_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%' AND category_products LIKE '%".$product_category_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE product_name LIKE '%".$title_products."%' AND category_products LIKE '%".$product_category_products."%'";
                                        }
                                        if(!empty($title_products) && empty($product_category_products) && !empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'");
                                            $$_SESSION['sql'] =  "SELECT * FROM Products WHERE product_name LIKE '%".$title_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE product_name LIKE '%".$title_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'";
                                        }
                                        if(empty($title_products) && !empty($product_category_products) && !empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%'";
                                        }
                                        if(!empty($title_products) && !empty($product_category_products) && !empty($subcategory_products))
                                        {
                                            $query = mysqli_query($link, "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%' AND product_name LIKE '%".$title_products."%'");
                                            $_SESSION['sql'] =  "SELECT * FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%' AND product_name LIKE '%".$title_products."%'";
                                            $_SESSION['delete'] =  "DELETE FROM Products WHERE category_products LIKE '%".$product_category_products."%' AND subcategory_products LIKE '%".$subcategory_products."%' AND product_name LIKE '%".$title_products."%'";
                                        }
                                        $countrow = mysqli_num_rows($query);
                                        if($countrow < 1)
                                        {
                                            echo "<p style = 'font-size: 20px'>Не найдено</p>";
                                        }
                                        else
                                        {
                                            echo "<h1>Таблица: Продажи</h1>";
                                            echo "<h3>Количество позиций: ".$countrow."</h3>";
                                            $count_row = mysqli_num_rows($query);
                                            echo '<table border = "1px solid grey" style = "margin-top: 2.5%; height: 250px;width: 1169px; font-size: 12px; background: #FFDBB9; color: grey;;
                                            border-radius: 20px; display: block; overflow-x: auto; white-space: nowrap;">
                                            <tr style="text-align:center; font-weight: bold;position: -webkit-sticky;position: sticky;top: -3px;z-index: 2;background: #FFDBB9;">  

                                                <th>Уникальный номер производства</th>
                                                <th>Название категориия</th>
                                                <th>Название подкатегории</th>
                                                <th>Наименование товара</th>
                                                <th>Производитель</th>
                                                <th>Стоимость</th>
                                                <th>Характеристика</th>
                                                <th>Вес или количество</th>
                                                <th>Упаковка</th>
                                            </tr>';
                                        }
                                        for ($i = 0; $i < $count_row; $i++)
                                        {
                                            $row = mysqli_fetch_row($query);
                                            echo "<tr>";
                                            for($j = 0; $j < 9; $j++)
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

                                //             if(isset($_POST['Upload']))
                                //             {
                                //                 $xls = new PHPExcel();
                                //                 $xls->setActiveSheetIndex(0);
                                //                 $sheet = $xls->getActiveSheet();
                                                
                                //                 // Шапка
                                //                 $sheet->getStyle("A1:E1")->getFont()->setBold(true);
                                //                 $sheet->setCellValue("A1", 'Уникальный номер');
                                //                 $sheet->setCellValue("B1", 'Название категории');
                                //                 $sheet->setCellValue("C1", 'Название подкатегории');
                                //                 $sheet->setCellValue("D1", 'Наименование продукта');
                                //                 $sheet->setCellValue("E1", 'Стоимость');
                                //                 // Выборка из БД
                                //                 $sth = mysqli_query($link, $_SESSION['sql']);
                                //                 $items = mysqli_fetch_all($sth, MYSQLI_ASSOC);
                                //                 $index = 2;
                                //                 foreach($items as $row)
                                //                 {
                                //                     $sheet->setCellValue("A" . $index, $row['ID_sales']);
                                //                     $sheet->setCellValue("B" . $index, $row['category_sales']);
                                //                     $sheet->setCellValue("C" . $index, $row['subcategory_sales']);
                                //                     $sheet->setCellValue("D" . $index, $row['product_sales']);
                                //                     $sheet->setCellValue("E" . $index, $row['cost_sales']);
                                //                     $index++;
                                //                 }
                                                
                                //                 // Отдача файла в браузер
                                //                 ob_end_clean();
                                //                 header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                                //                 header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                                //                 header("Cache-Control: no-cache, must-revalidate");
                                //                 header("Pragma: no-cache");
                                //                 header("Content-type: application/vnd.ms-excel");
                                //                 header("Content-Disposition: attachment; filename=Товары.xls");
                                //                 $objWriter = PHPExcel_IOFactory::createWriter($xls, "Excel2007");
                                //                 $objWriter->save('php://output');
                                //                 exit();
                                //             }
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

                                                                $cell2 = $worksheet->getCellByColumnAndRow(1, $row);
                                                                $cell3 = $worksheet->getCellByColumnAndRow(2, $row); 
                                                                $cell4 = $worksheet->getCellByColumnAndRow(3, $row); 
                                                                $cell5 = $worksheet->getCellByColumnAndRow(4, $row); 
                                                                $cell6 = $worksheet->getCellByColumnAndRow(5, $row); 
                                                                $cell7 = $worksheet->getCellByColumnAndRow(6, $row); 
                                                                $cell8 = $worksheet->getCellByColumnAndRow(7, $row); 
                                                                $cell9 = $worksheet->getCellByColumnAndRow(8, $row); 

                                                                $query = mysqli_query($link, "INSERT INTO Products VALUES(NULL, '".$cell2."', '".$cell3."', '".$cell4."', '".$cell5."', '".$cell6."', '".$cell7."', '".$cell8."', '".$cell9."')") or die('Ошибка чтения записи: '.mysqli_error($link));
                                                            }
                                                        }
                                                    }                 
                    }
                    if(isset($_POST['Delete']))
                    {
                        $_SESSION['delete'];
                        $query = mysqli_query($link, $_SESSION['delete'].mysqli_error($link));                    
                    }
                    ?>
                            <form action="Products.php" method = "POST" enctype = 'multipart/form-data'>
                                <div >
                                    <button name = "Upload" type="submit">Выгрузить</button>
                                    <!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
                                                <form  action="Products.php" enctype="multipart/form-data" action="__URL__" method="POST">
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
    }
?>
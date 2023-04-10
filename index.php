<?php
    header("Content-Type: text/html; charset = utf-8");
    require_once 'connection.php';
    $link = mysqli_connect($host, $user, $password, $db) or die("Ошибка ".mysqli_error($link));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Справочник товаров</title>
	<link rel="stylesheet" href="style2.css" type="text/css">
	<link rel="shortcut icon" href="image\1.png" type="image/x-icon">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap"rel="stylesheet'>
	<link rel="stylesheet" href="style.css">

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
	<!-- partial:index.partial.html -->
	<div class="app">
		<div class="cardList">
			<button class="cardList__btn btn btn--left">
				<div class="icon">
					<svg>
						<use xlink:href="#arrow-left"></use>
					</svg>
				</div>
			</button>

			<div class="cards__wrapper">
				<div class="card current--card">
					<div class="card__image">
						<img src="slider1.2.png" alt="" />
					</div>
				</div>

				<div class="card next--card">
					<div class="card__image">
						<img src="slider2.2.png" alt="" />
					</div>
				</div>

				<div class="card previous--card">
					<div class="card__image">
						<img src="tander1.jpg" alt="" />
					</div>
				</div>
			</div>

			<button class="cardList__btn btn btn--right">
				<div class="icon">
					<svg>
						<use xlink:href="#arrow-right"></use>
					</svg>
				</div>
			</button>
		</div>

		<div class="infoList">
			<div class="info__wrapper">
				<div class="info current--info">
					<h1 class="text name">Кратко</h1>
					<p class="text location">«АО Тандер»</p>
					<p class="text description">«Магнит» является одной из ведущих розничных сетей<br>
						в России по торговле продуктами питания,<br> лидером по количеству магазинов<br>
						и географии их расположения.</p>
				</div>

				<div class="info next--info">
					<h1 class="text name">Компания</h1>
					<p class="text location">2021</h4>
					<p class="text description">&bull;&Tab;Старт пилотирования формата киосков;<br>
						&bull;&Tab;Приобретение розничной сети «Дикси»<br>
						&bull;&Tab;Запуск программы клубов для покупателей<br>
						в программе лояльности;<br>
						&bull;&Tab;Банк ВТБ продал Marathon Group свою долю в Компании;<br>
						&bull;&Tab;Преодолен рубеж в 100 тыс. онлайн-заказов в сутки.<br></p>
				</div>

				<div class="info previous--info">
					<h1 class="text name">Наша стратегия</h1>

					<p class="text description">
						&bull;&Tab;Продолжаем улучшать CVP, являющееся ключевым<br>
						драйвером роста плотности продаж и доходности<br>
						&bull;&Tab;Улучшаем способы работы бизнеса для обеспечения<br>
						роста доходности и аккумулирования денежного потока<br>
						&bull;&Tab;Продолжаем концентрироваться на «умной»<br>
						органической экспансии и ставим высокие критерии<br>
						доходности для новых открытий, при этом проводим<br>
						пилоты новых концепций магазинов и ниш</p>
				</div>
			</div>
		</div>


		<div class="app__bg">
			<div class="app__bg__image current--image">
				<img src="slider1.2.png" alt="" />
			</div>
			<div class="app__bg__image next--image">
				<img src="slider2.2.png" alt="" />
			</div>
			<div class="app__bg__image previous--image">
				<img src="tander1.jpg" alt="" />
			</div>
		</div>
	</div>

	<div class="loading__wrapper">
		<div class="loader--text">Loading...</div>
		<div class="loader">
			<span></span>
		</div>
	</div>


	<svg class="icons" style="display: none;">
		<symbol id="arrow-left" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
			<polyline points='328 112 184 256 328 400'
				style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
		</symbol>
		<symbol id="arrow-right" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
			<polyline points='184 112 328 256 184 400'
				style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
		</symbol>
	</svg>












	<!-- partial -->
	<script src='https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.3/gsap.min.js'></script>
	<script src="script.js"></script>

</body>

</html>
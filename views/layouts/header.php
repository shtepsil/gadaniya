<?php

use components\Debugger as d;
use models\User;

User::$info = User::getUserById($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Гадания</title>
        <link href="/template/css/bootstrap.min.css" rel="stylesheet">
        <link href="/template/css/font-awesome.min.css" rel="stylesheet">
        <link href="/template/css/animate.css" rel="stylesheet">
        <link href="/template/css/main.css" rel="stylesheet">
        <link rel="shortcut icon" href="/template/images/favicon.ico">
    </head><!--/head-->

    <body>
        <header id="header"><!--header-->
            <div class="header_top"><!--header_top-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="contactinfo">
                                <ul class="nav nav-pills">
                                    <li><a href="#"><i class="fa fa-phone"></i> +7 111 222 33 44</a></li>
                                    <li><a href="#"><i class="fa fa-envelope"></i> gadaniya@gmail.com</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="social-icons pull-right">
                                <ul class="nav navbar-nav">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header_top-->

            <div class="header-middle"><!--header-middle-->
              <div class="container">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="logo pull-left">
                      <a href="/"><img src="/template/images/home/gadaniya.png" alt="" /></a>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                      <ul class="nav navbar-nav">
                        <?php if(!User::isGuest()): ?>
                        <li><a href="#" class="no-link"><i class="fa fa-user"></i> ID: <?=$_SESSION['user_id']?>, <?=User::$info['name']?></a></li>
                        <li>
                            <a
                                href="/user/oauth2logout"
                                class="no-link link-logout"
                                data-user-id="<?=$_SESSION['user_id']?>"
                            >
                                <i class="fa fa-lock"></i> Выход
                            </a>
                        </li>
                      <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div><!--/header-middle-->

            <?php if(!User::isGuest()): ?>
            <!--header-bottom-->
            <div class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="mainmenu pull-left">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="/">Главная</a></li>
                                    <li><a href="/gadaniya">Погадать</a></li>
                                    <li><a href="/geks">Выбрать вариант</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header-bottom-->
            <?endif?>
            
        </header><!--/header-->
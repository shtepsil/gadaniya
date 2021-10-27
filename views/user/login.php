<?php

use components\Debugger as d;

?>
<br><br><br><br><br>
<section class="main w-login">
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">

                <div class="signup-form"><!--sign up form-->
                    <h2>Вход на сайт</h2>
                    <p>
                        Чтобы начать гадания, авторизуйтесь.
                    </p>
                    <form name="form_auth" action="/user/login" method="post" class="login-form">
                        <input type="email" name="email" placeholder="Email" value="" />
                        <input type="password" name="password" placeholder="Пароль" value="" />
                        <button type="button" name="auth" class="btn btn-default">
                            <img src="/template/images/animate/loading.gif" class="loading" />
                            Авторизация
                        </button>
                    </form>
                    <br>
                    <div class="error text-center dn"></div>
                </div><!--/sign up form-->
                <br>
                <div class="text-center">
                  <a href="/user/register">Регистрация</a>
                </div>
                <br/>
                <?d::res()?>
            </div>
        </div>
    </div>
</section>
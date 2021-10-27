<?php ?>
<br><br><br><br>
<section class="main">
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">
                
                <?php if ($data['result']): ?>
                    <p>Вы зарегистрированы!</p>
                <?php else: ?>
                    <?php if (count($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="signup-form"><!--sign up form-->
                        <h2>Регистрация на сайте</h2>
                        <form action="#" method="post">
                            <input type="text" name="name" placeholder="Имя" value="<?=($data['name'])?:''?>"/>
                            <input type="email" name="email" placeholder="E-mail" value="<?=($data['email'])?:''?>"/>
                            <input type="password" name="password" placeholder="Пароль" value="<?=($data['password'])?:''?>"/>
                            <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />
                        </form>
                    </div><!--/sign up form-->
                
                <?php endif; ?>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</section>
<?php

use components\Debugger as d;

?>
<section class="main w-geks">
    <div class="container geks-info">
        <div class="row">
            <div class="col-md-12">
                <a href="/gadaniya" class="btn btn-primary">По гадать снова</a><br><br>
                <br><br>
                <div class="h2 text-center">
                    <?if(empty($_GET['date'])):?>
                        Интерпретация гексограммы
                    <?else:?>
                        Ваш ответ на <?=$_GET['date']?>
                    <?endif?>
                </div>
                <br><br><br>
            </div>
        </div>
        <div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="info">
                        <div class="g-imgs">
                            <? $g_code = str_split($geks_info['code']); ?>
                            <?foreach($g_code as $c_i):?>
                                <img src="template/images/<?=($c_i)?:$c_i[0]?>.jpg" />
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="text-left">
                    <?=$geks_info['text']?>
                </div>
            </div>
        </div>
    </div>
</section>
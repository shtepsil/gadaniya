<?php

use components\Debugger as d;

?>
<section class="main w-geks" data-user-id="<?=$_SESSION['user_id']?>">
    <?if(!$geks_info):?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br><br>
                <div class="h2 text-center">Выберите свою гексограмму</div>
                <br><br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?if($geks AND count($geks)): shuffle($geks);?>
                    <?foreach($geks as $g):?>
                        <ul class="list-geks">
                            <li>
                                <a href="/geks?code=<?=$g['code']?>" title="Получить интерпретацию">
                                    <div class="imgs-geks">
                                        <? $code = str_split($g['code']); ?>
                                        <?foreach($code as  $c):?>
                                            <img src="template/images/<?=($c)?:$c[0]?>.jpg" />
                                        <?endforeach;?>
                                    </div>
                                </a>
                                <a href="/geks?code=<?=$g['code']?>"><?=$g['id']?></a>
                            </li>
                        </ul>
                    <?endforeach;?>
                <?endif?>
            </div>
        </div>
    </div>
    <?else:?>
    <div class="container geks-info">
        <div class="row">
            <div class="col-md-12">
                <a href="/geks">Вернуться к списку гексограмм</a><br><br>
                <br><br>
                <div class="h2 text-center">Интерпретация гексограммы</div>
                <br><br><br>
            </div>
        </div>
        <div>
            <div class="col-md-12">
                <div class="geks-info text-center">
                    <div class="info">
                        <div class="g-imgs">
                            <? $g_code = str_split($geks_info['code']); ?>
                            <?foreach($g_code as $c_i):?>
                                <img src="template/images/<?=($c_i)?:$c_i[0]?>.jpg" />
                            <?endforeach;?>
                        </div>
                        <br><br>
                        <div class="g-text text-left">
                            <?=$geks_info['text']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?endif?>
</section>
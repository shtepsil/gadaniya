<?php

use components\Debugger as d;

?>
<section class="main w-g" data-user-id="<?=$_SESSION['user_id']?>">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="gadaniya text-center">
                    <div class="click-layer"></div>
                    <ul class="geks"></ul>
                    <img src="/template/images/animate/loading.gif" class="loading" />
                </div>
                <br>
                <button type="button" name="view_history" onclick="location.reload()" class="btn btn-success dn">Показать всю историю</button>

                <?d::res()?>

            </div>
            <div class="col-md-9">
                <div class="instruction">
                    <p>
                        Для получения вашей гексограммы, кликайте по блоку слева,<br>
                        пока все 6 элементов гексограммы не заполнят блок.
                    </p>
                </div>
                <div class="interpretation dn">
                    <h3 class="int-h">Ваша интерпретация <span></span></h3>
                    <p class="text"></p>
                    <p class="errors"></p>
                    <p><button type="button" name="clear" class="btn btn-success">Начать снова</button></p>
                </div>
            </div>
        </div>
        <?if($history AND count($history)):?>
        <br><br>
        <div class="row">
            <div class="col-md-12 w-h">
                <div class="h3" style="position: relative;">
                    История ваших интерпретаций
                    <div class="result-history dn" style="position: absolute;font-size: 14px;margin-top: -4px;font-weight: normal;">История удалена</div>
                    <button type="button" name="clear_history" class="btn btn-success">
                        <img
                            src="/template/images/animate/loading.gif"
                            class="loading"
                            style="top: 2px;right:-35px;"
                        />
                        Очистить историю
                    </button>
                </div>
                <br>
                <ul class="history">
                    <?foreach($history as $h):?>
                        <li class="history-item">
                            <span class="h4">ID: <?=$h['user_id']?>, Создано:</span> <?=date('Y-m-d h:i:s',$h['created_at'])?><br><br>
                            <div class="h4">Интерпретация:</div>
                            <span class="text"><?=$h['text']?></span><br>
                            <button
                                type="button"
                                name="get_geks"
                                class="btn btn-primary"
                                data-code="<?=$h['code']?>"
                                data-date="<?=date('Y-m-d h:i:s',$h['created_at'])?>"
                            >
                                Получить гексограмму
                            </button>
                            <hr>
                        </li>
                    <?endforeach?>
                </ul>
            </div>
        </div>
        <?endif?>
    </div>
</section>
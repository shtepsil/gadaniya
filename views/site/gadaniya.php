<?php

use components\Debugger as d;

?>
<div class="geks-go-error dn" style="position:fixed; top: 40px;right: 10px;padding:10px;background-color:rgb(231,89,89);opacity:.8;color:white;border-radius:8px;">Ошибка, по побуйте снова.</div>
<section class="main w-g" data-user-id="<?=$_SESSION['user_id']?>">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?d::res('test')?>
                <label>Введите свой вопрос</label><br>
                <input type="text" name="user_question" class="form-control" value="" />
            </div>
            <div class="col-md-9"></div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="alert alert-warning dn" role="alert"></div>

                <button type="button" name="generation" class="btn btn-primary">
                    Генерировать ответ
                </button>
                <button type="button" name="choose" class="btn btn-primary">
                    Выбрать ответ
                </button>

            </div>
        </div>

        <br><br>
        <!-- Generation geks -->
        <div class="row geks-generation dn">
            <div class="col-md-3">
                <div class="gadaniya text-center">
                    <div class="click-layer"></div>
                    <ul class="geks"></ul>
                </div>
                <br>
                <button
                    type="button"
                    name="get_question"
                    class="btn btn-success dn"
                    data-code=""
                    data-type="get-questoin"
                    onclick="getInterpretation(this)"
                    >
                    <img
                        src="/template/images/animate/loading.gif"
                        class="loading"
                        style="top: 2px;left:-35px;"
                    />
                    Получить ответ
                </button>
                <div class="gq-errors dn">Ошибка, по побуйте снова.</div>

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
                    <p><button type="button" name="clear" class="btn btn-success">Начать снова</button></p>
                </div>
            </div>
        </div>
        <!-- /generation geks -->

        <!-- Geks -->
        <div class="w-geks dn">
            <div class="row">
                <div class="col-md-12">
                    <br><br>
                    <div class="h2 text-center">Выберите свою гексограмму</div>
                    <br><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="position:relative;">
                    <div class="load-layer dn" style="position:absolute;top:0;left:0;width:100%;height: 100%;background-color:rgba(255,255,255,.4);
    z-index: 2;"></div>
                    <?if($geks AND count($geks)): shuffle($geks);?>
                        <?foreach($geks as $g):?>
                            <ul class="list-geks">
                                <li>
                                    <a href="/geks?code=<?=$g['code']?>" class="no-link" title="Получить интерпретацию">
                                        <div class="imgs-geks" data-code="<?=$g['code']?>" data-type="geks" onclick="getInterpretation(this)">
                                            <? $code = str_split($g['code']); ?>
                                            <?foreach($code as  $c):?>
                                                <img src="template/images/<?=($c)?:$c[0]?>.jpg" />
                                            <?endforeach;?>
                                        </div>
                                    </a>
                                    <a href="/geks?code=<?=$g['code']?>" class="no-link"><?=$g['id']?></a>
                                </li>
                            </ul>
                        <?endforeach;?>
                    <?endif?>
                </div>
            </div>
        </div>
        <!-- /geks -->

        <?if($questions_history AND count($questions_history)):?>
            <br><br>
            <!-- Querstion history -->
            <section>
                <div class="row">
                    <div class="col-md-12 w-h">
                        <div class="h3" style="position: relative;">
                            История ваших вопросов
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
                            <?foreach($questions_history as $h):?>
                                <li class="history-item">
                                    <span class="h4">Создано:</span> <?=date('Y-m-d h:i:s',$h['created_at'])?><br><br>
                                    <div class="h4">Ваш вопрос:</div>
                                    <span class="text"><?=$h['question']?></span><br>
                                    <a href="/geks?code=<?=$h['code']?>&date=<?=date('Y-m-d h:i:s',$h['created_at'])?>" class="btn btn-primary">
                                        По смотреть ответ</a>
                                    <hr>
                                </li>
                            <?endforeach?>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- Querstion history -->
        <?endif?>
    </div>
</section>
<?php
spl_autoload_register(function ($class_name) {
    require_once 'Class/' . $class_name . '.php';
});
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutorial page </title>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="./css/my.css"/>
</head>
<body>
<a class="btn btn-lg btn-success"
   href="#" data-toggle="modal"
   data-target="#emission_card">Эмиссия карты</a>
<div class="modal fade" id="emission_card" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title" id="myModalLabel">Эмиссия карты</h4>
            </div>
            <div class="modal-body">
                <form action="/form.php" method="post">
                    <input type="hidden" name="operation" value="emission">
                    <div class="form-group row">
                        <label for="input_family" class="col-sm-2 form-control-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input type="text" name="family" class="form-control" id="input_family"
                                   placeholder="Пупкин">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_name" class="col-sm-2 form-control-label">Имя</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="input_name" placeholder="Василий">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patronymic" class="col-sm-2 form-control-label">Отчество</label>
                        <div class="col-sm-10">
                            <input type="text" name="patronymic" class="form-control" id="patronymic"
                                   placeholder="Иванович">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2">Выберите ваш пол</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="input_sex" id="gridRadios0" value="муж" checked>
                                    мужской
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="input_sex" id="gridRadios1" value="жен">
                                    женский
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_birthday" class="col-sm-2 form-control-label">Дата Рождения</label>
                        <div class="col-sm-10">
                            <input type="date" name="input_birthday" pattern="[0-9]{4}-[1-12]-[1-31]"
                                   class="form-control" id="input_birthday"
                                   placeholder="1975-05-19">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_birthplace" class="col-sm-2 form-control-label">Город Рождения</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_birthplace"
                                   class="form-control" id="input_birthplace"
                                   placeholder="Москва">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_mail" class="col-sm-2 form-control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="input_mail"
                                   class="form-control" id="input_mail"
                                   placeholder="mail@exemple.com">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_tel" class="col-sm-2 form-control-label">Номер сотового телефона</label>
                        <div class="col-sm-10">
                            <input type="tel" name="input_tel" pattern="+[0-9][0-9]{10}"
                                   class="form-control" id="input_tel"
                                   placeholder="+70000000000">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_RFNSPDocid" class="col-sm-2 form-control-label">RFNSPDocid</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_RFNSPDocid"
                                   class="form-control" id="input_RFNSPDocid"
                                   placeholder="21">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docseria" class="col-sm-2 form-control-label">Серия документа</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docseria"
                                   class="form-control" id="input_docseria"
                                   placeholder="7709">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docnum" class="col-sm-2 form-control-label">Номер документа</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docnum"
                                   class="form-control" id="input_docnum"
                                   placeholder="543987">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docissuingdate" class="col-sm-2 form-control-label">Дата получения
                            документа</label>
                        <div class="col-sm-10">
                            <input type="date" name="input_docissuingdate" pattern="[0-9]{4}-[1-12]-[1-31]"
                                   class="form-control" id="input_docissuingdate"
                                   placeholder="2011-01-01">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docissuer" class="col-sm-2 form-control-label">Место получения документа
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docissuer"
                                   class="form-control" id="input_docissuer"
                                   placeholder="УПРАВЛЕНИЕ ФЕДЕРАЛЬНОЙ МИГРАЦИОННОЙ СЛУЖБЫ РОССИИ ПО ГОР.МОСКВЕ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docissuercode" class="col-sm-2 form-control-label">Код подразделения</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docissuercode"
                                   class="form-control" id="input_docissuercode"
                                   placeholder="770-001">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_adress" class="col-sm-2 form-control-label">Адресс прописки</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_adress"
                                   class="form-control" id="input_adress"
                                   placeholder="Москва, Большая Садовая, 10, кв. 50">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_card_num" class="col-sm-2 form-control-label">Номер карточки</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_card_num"
                                   class="form-control" id="input_card_num"
                                   placeholder="6705721234567895">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_secret" class="col-sm-2 form-control-label">Кодовое слово</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_secret"
                                   class="form-control" id="input_secret"
                                   placeholder="Шарик">
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-secondary">Отпрввить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>

</div>

<a class="btn btn-lg btn-success"
   href="#" data-toggle="modal"
   data-target="#identification_user">Идентефикация юзера</a>
<div class="modal fade" id="identification_user" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title" id="myModalLabel">Идентефикация юзера</h4>
            </div>
            <div class="modal-body">
                <form action="/form.php" method="post">
                    <input type="hidden" name="operation" value="identification_user">
                    <div class="form-group row">
                        <label for="input_family" class="col-sm-2 form-control-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input type="text" name="family" class="form-control" id="input_family"
                                   placeholder="Пупкин">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_name" class="col-sm-2 form-control-label">Имя</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="input_name" placeholder="Василий">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patronymic" class="col-sm-2 form-control-label">Отчество</label>
                        <div class="col-sm-10">
                            <input type="text" name="patronymic" class="form-control" id="patronymic"
                                   placeholder="Иванович">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_tel" class="col-sm-2 form-control-label">Номер сотового телефона</label>
                        <div class="col-sm-10">
                            <input type="tel" name="input_tel" pattern="+[0-9][0-9]{10}"
                                   class="form-control" id="input_tel"
                                   placeholder="+70000000000">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_snils" class="col-sm-2 form-control-label">СНИЛС</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_snils"
                                   class="form-control" id="input_snils"
                                   placeholder="11223344595">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_RFNSPDocid" class="col-sm-2 form-control-label">RFNSPDocid</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_RFNSPDocid"
                                   class="form-control" id="input_RFNSPDocid"
                                   placeholder="21">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docseria" class="col-sm-2 form-control-label">Серия документа</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docseria"
                                   class="form-control" id="input_docseria"
                                   placeholder="7709">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_docnum" class="col-sm-2 form-control-label">Номер документа</label>
                        <div class="col-sm-10">
                            <input type="text" name="input_docnum"
                                   class="form-control" id="input_docnum"
                                   placeholder="543987">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-secondary">Отпрввить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</div>

</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</html>
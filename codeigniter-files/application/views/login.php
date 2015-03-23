        <content>
            <div class="container-fluid">
            <?
            $dept_array=['none' => 'Выберете подразделение'];
            foreach ($departments_list as $value){
                $dept_array[$value['department_name']] = $value ['department_name'];
            }
            ?>
            <div class="container">
                <div class="col-md-5 col-md-offset-3">
                    <div class="jumbotron">
                        <?echo form_open('Users/login','class="form-signin" id="login-form"')?>
                            <h2 class="form-signin-heading"><? echo $login_header;?></h2>
                            <p class="text-danger"><?echo $login_error?></p>
                            <label class="sr-only" for="inputEmail">Email</label>
                            <input name="email" id="inputEmail" class="form-control" type="email" autofocus="" required="" placeholder="Email адрес">
                            <label class="sr-only" for="inputPassword">Пароль</label>
                            <?echo form_password('password','','id="inputPassword" class="form-control" type="password" required="" placeholder="Пароль"')?>
<!--
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me">
                                    Запомнить меня
                                </label>
                            </div>
-->
                        <? echo form_close()?>
                        <button class="btn btn-primary" type="submit" form="login-form">Войти</button>
                        <button class="btn btn-default" type="button" data-toggle="modal" data-target="#registration-modal">Зарегестрироваться</button>
                    </div>

                </div>
            </div>
<!-- Модальное окно регистрации!-->
<div class="modal fade" id="registration-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Форма регистрации</h4>
            </div>
            <div class="modal-body">
                <? echo form_open('Users/registration','id="signup-form" class="form-horizontal"')?>
                    <div class="form-group">
                        <label for="first-name" class="col-sm-2 control-label">Имя</label>
                        <div class="col-md-9">
                            <? echo form_input('first_name','','id="first-name"class="form-control" placeholder="Имя" required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="patronymic" class="col-sm-2 control-label">Отчество</label>
                        <div class="col-md-9">
                            <? echo form_input('patronymic','','class="form-control" placeholder="Отчество"required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="second_name" class="col-sm-2 control-label">Фамилия</label>
                        <div class="col-md-9">
                            <? echo form_input('second_name','','id="second_name"class="form-control" placeholder="Фамилия" required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Телефон</label>
                        <div class="col-md-9">
                            <? echo form_input('phone','','id="phone"class="form-control" placeholder="Телефон"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="department" class="col-sm-2 control-label">Отдел</label>
                        <div class="col-md-9">
                            <? echo form_dropdown('department',$dept_array,'id="department"class="form-control" placeholder="Отдел" required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position" class="col-sm-2 control-label">Должность</label>
                        <div class="col-md-9">
                            <? echo form_input('position','','id="position" class="form-control" placeholder="Должность" required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-md-9">
                            <input name="email" type="email" id="email"class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Пароль</label>
                        <div class="col-md-9">
                            <? echo form_password('password','','id="email"class="form-control" placeholder="Пароль" required'); ?>
                        </div>
                    </div>
                <? echo form_close();?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-close-btn" data-dismiss="modal">Закрыть</button>
                <button class="btn btn-primary" id="modal-submit" type="submit" form="signup-form">Зарегестрироваться</button>
            </div>
        </div>
    </div>
</div>
</div>
        </content>
<script src="/themes/default/js/registration.js"></script>

        <content>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pageheader">
                            <h1><? echo $journal;?>
                                <small><? echo $main;?></small>
                            </h1>
                        </div>
                        <button class="btn btn-primary">Изменить данные</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-md-offset-3">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <col-md- class="label label-info">Внимание!</col-md->
                            Поля область и район не заполняются для областных и районных центров соответственно,
                            во всех остальных случаях заполнение полей обязательно.
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-3">
                        <?  echo form_open('/Contracts/added','id="add_contractor"');?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control" title="Тип контрагента" name="type" required >
                                            <option value=""></option>
                                        <?  foreach ($contractor_type as $value) {
                                                echo '<option value='.$value['type'].'>'.$value['description'].'</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?  echo form_input('name','','type="text" class="form-control" placeholder="Наименование" required');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?  echo form_input('post_code','','type="text" class="form-control" maxlength="6" placeholder="Индекс" required');?>
                                    </div>
                                    <div class="col-md-9">
                                        <?echo form_input('area','','type="text" class="form-control" placeholder="Область"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?  echo form_input('region','','type="text" class="form-control" id="focusedInput" placeholder="Район"');?>
                                    </div>
                                    <div class="col-md-4">
                                        <?  echo form_input('city','','type="text" class="form-control" id="focusedInput" placeholder="Город" required');?>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?  echo form_input('street','','type="text" class="form-control" placeholder="Улица" required');?>
                                    </div>
                                    <div class="col-md-2">
                                    <?  echo form_input('building','','type="text" class="form-control" placeholder="Дом" required');
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?  echo form_input('web_site','','type="text" class="form-control" placeholder="Веб-сайт" required');?>
                                    </div>
                                    <div class="col-md-6">
                                        <?  echo form_input('phone','','type="text" class="form-control" placeholder="Телефон" required');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="text-center text-info">Контактное лицо</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?  echo form_input('contact_person_name','','type="text" class="form-control" placeholder="Имя" required');?>
                                    </div>
                                    <div class="col-md-6">
                                        <?    echo form_input('contact_person_patronymic','','type="text" class="form-control" placeholder="Отчество" required');
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?  echo form_input('contact_person_surname','','type="text" class="form-control" placeholder="Фамилия" required');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="email" type="email" class="form-control" required placeholder="Электронная почта" required>
                                    </div>
                                    <div class="col-md-6">
                                        <?  echo form_input('contact_person_phone','','type="text" class="form-control" placeholder="Контактный телефон" required');?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 pull-right">
                                    <button type="reset" class="btn btn-danger" form="add_contractor">Очистить</button>
                                    <button type="submit" class="btn btn-primary" form="add_contractor">Добавить</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </content>
<script src="/themes/default/js/add_contractor.js"></script>

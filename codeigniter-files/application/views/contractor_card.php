        <content>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pageheader">
                            <h1><? echo $contractor_data['name'];?>
                                <small><? echo $journal;?></small>
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="lead">Тип:
                            <?
                            if ($contractor_data['type'] == '0'){
                                echo '<small class="text-danger"> Поставщик</small>';
                            }
                            else if ($contractor_data['type'] == '1'){
                                echo '<small class="text-success"> Заказчик</small>';
                            }
                            else {
                                echo '<small class="text-info"> Прочее</small>';
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?
                        if ($jurist == '1'){
                            echo '<button class="btn btn-primary" data-toggle="modal" data-target="#change_contractor">Изменить данные</button> ';
                            echo '<button class="btn btn-danger">Удалить контрагента</button>';
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h2>Контактная информация</h2>
                        <div class="col-md-12">
                            <p class="text-left lead">Индекс: <?echo $contractor_data['post_code']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Область: <?echo $contractor_data['area']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Район: <?echo $contractor_data['region']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Город: <?echo $contractor_data['city']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Улица: <?echo $contractor_data['street']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Дом: <?echo $contractor_data['building']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Телефон: <?echo $contractor_data['phone']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Сайт: <?echo '<a href="'.$contractor_data['web_site'].'">'.$contractor_data['web_site'].'</a>'?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <h2>Контактное лицо</h2>
                         <div class="col-md-12">
                            <p class="text-left lead"><?echo $contractor_data['contact_person_surname'].' '.$contractor_data['contact_person_name'].' '.$contractor_data['contact_person_patronymic']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Телефон: <?echo $contractor_data['contact_person_phone']?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-left lead">Электронная почта: <?echo '<a href="mailto:'.$contractor_data['email'].'">'.$contractor_data['email'].'</a>'?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-success">
                            <div class="panel-heading" role="tab" id="active_contracts">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#active_contracts_panel" aria-expanded="true" aria-controls="active_contracts">
                                        Активные договора
                                    </a>
                                </h4>
                            </div>
                            <div id="active_contracts_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="active_contracts">
                                <div class="panel-body">
                                    <?
                                    if (!empty ($all_contracts)){
                                        $all_contracts_count = count($all_contracts);
                                        echo '<table class="table table-responsive table-font">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Номер</th>
                                                    <th>Инициатор</th>
                                                    <th>Предмет договора</th>
                                                    <th>Статус</th>
                                                </tr>';
                                        for ($i=0; $i<$all_contracts_count;){
                                            $number = $i+1;
                                            if (time() < $all_contracts[$i]['validity']){
                                                echo '<tr>';
                                                echo '<td>'.$number.'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['initiator'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_subject'].'</td>';
                                                if($all_contracts[$i]['status'] == 'agreed'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-success" title="Согласован">Согласован</span></a></td>';
                                                }
                                                else if ($all_contracts[$i]['status'] == 'inprocess'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-warning" title="В процессе согласования">Согласование</span></a></td>';
                                                }
                                                else if ($all_contracts[$i]['status'] == 'disagree'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-danger" title="Не согласован">Не согласован</span></a></td>';

                                                }
                                                else if ($all_contracts[$i]['status'] == 'signed'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-primary" title="Договор подписан">Подписан</span></a></td>';

                                                }
                                                else {
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-info" title="Проект">Проект</span></a></td>';
                                                }
                                                echo '</tr>';
                                                $i++;
                                            }
                                            else {
                                                $i++;
                                            }
                                        }

                                    echo '</table>';
                                     }
                                     else {
                                        echo 'Нет активных договоров';
                                     }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-danger">
                            <div class="panel-heading" role="tab" id="archive_contracts">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#archive_contracts_panel" aria-expanded="true" aria-controls="archive_contracts">
                                        Не действующие договора
                                    </a>
                                </h4>
                            </div>
                            <div id="archive_contracts_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="archive_contracts">
                                <div class="panel-body">
                                    <?
                                    if (!empty ($all_contracts)){
                                        $all_contracts_count = count($all_contracts);
                                        $current_time = time();
                                        echo '<table class="table table-responsive table-font">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Номер</th>
                                                    <th>Инициатор</th>
                                                    <th>Предмет договора</th>
                                                    <th>Статус</th>
                                                </tr>';
                                        for ($i=0; $i<$all_contracts_count;){
                                            $number = $i+1;
                                            if (time() > $all_contracts[$i]['validity']){
                                                echo '<tr>';
                                                echo '<td>'.$number.'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['initiator'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_subject'].'</td>';
                                                if($all_contracts[$i]['status'] == 'agreed'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-success" title="Согласован">Согласован</span></a></td>';
                                                }
                                                else if ($all_contracts[$i]['status'] == 'inprocess'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-warning" title="В процессе согласования">Согласование</span></a></td>';
                                                }
                                                else if ($all_contracts[$i]['status'] == 'disagree'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-danger" title="Не согласован">Не согласован</span></a></td>';

                                                }
                                                else if ($all_contracts[$i]['status'] == 'signed'){
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-primary" title="Договор подписан">Подписан</span></a></td>';

                                                }
                                                else {
                                                    echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-info" title="Проект">Проект</span></a></td>';
                                                }
                                                echo '</tr>';
                                                $i++;
                                            }
                                            else {
                                                $i++;
                                            }
                                        }

                                    echo '</table>';
                                     }
                                     else {
                                        echo 'Нет не действующих договоров';
                                     }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Модальное окно изменения контрагента!-->
<div class="modal fade" id="change_contractor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить данные</h4>
            </div>
            <div class="modal-body">
                <?  echo form_open('/Contracts/change_contractor','id="contractor_form"');?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <?  echo form_input('name',$contractor_data['name'],'type="text" class="form-control" placeholder="'.$contractor_data['name'].'" required');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <?  echo form_input('post_code',$contractor_data['post_code'],'type="text" class="form-control" maxlength="6" placeholder="'.$contractor_data['post_code'].'" required');?>
                            </div>
                            <div class="col-md-9">
                                <?echo form_input('area',$contractor_data['area'],'type="text" class="form-control" placeholder="'.$contractor_data['area'].'"');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <?  echo form_input('region',$contractor_data['region'],'type="text" class="form-control" id="focusedInput" placeholder="'.$contractor_data['region'].'"');?>
                            </div>
                            <div class="col-md-4">
                                <?  echo form_input('city',$contractor_data['city'],'type="text" class="form-control" id="focusedInput" placeholder="'.$contractor_data['city'].'" required');?>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <?  echo form_input('street',$contractor_data['street'],'type="text" class="form-control" placeholder="'.$contractor_data['street'].'" required');?>
                            </div>
                            <div class="col-md-2">
                            <?  echo form_input('building',$contractor_data['building'],'type="text" class="form-control" placeholder="'.$contractor_data['building'].'" required');
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?  echo form_input('web_site',$contractor_data['web_site'],'type="text" class="form-control" placeholder="'.$contractor_data['web_site'].'" required');?>
                            </div>
                            <div class="col-md-6">
                                <?  echo form_input('phone',$contractor_data['phone'],'type="text" class="form-control" placeholder="'.$contractor_data['phone'].'" required');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="text-center text-info">Контактное лицо</p>
                        <div class="row">
                            <div class="col-md-6">
                                <?  echo form_input('contact_person_name',$contractor_data['contact_person_name'],'type="text" class="form-control" placeholder="'.$contractor_data['contact_person_name'].'" required');?>
                            </div>
                            <div class="col-md-6">
                                <?    echo form_input('contact_person_patronymic',$contractor_data['contact_person_patronymic'],'type="text" class="form-control" placeholder="'.$contractor_data['contact_person_patronymic'].'" required');
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <?  echo form_input('contact_person_surname',$contractor_data['contact_person_surname'],'type="text" class="form-control" placeholder="'.$contractor_data['contact_person_surname'].'" required');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="email" type="email" class="form-control" required placeholder="<?echo $contractor_data['email']?>" value="<?echo $contractor_data['email']?>" required>
                            </div>
                            <div class="col-md-6">
                                <?  echo form_input('contact_person_phone',$contractor_data['contact_person_phone'],'type="text" class="form-control" placeholder="'.$contractor_data['contact_person_phone'].'" required');?>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">Закрыть</button>
                <button id="change_contractor_btn" class="btn btn-primary" type="submit">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<!-- Конец модального окна!-->
        </content>
<script src="/themes/default/js/contractor_card.js"></script>

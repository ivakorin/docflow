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
                            echo '<button class="btn btn-primary">Изменить данные</button> ';
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
                                                    <th>Контрагент</th>
                                                    <th>Предмет договора</th>
                                                    <th>Статус</th>
                                                </tr>';
                                        for ($i=0; $i<$all_contracts_count;){
                                            $number = $i+1;
                                            if (time() < $all_contracts[$i]['validity']){
                                                echo '<tr>';
                                                echo '<td>'.$number.'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['contractor_name'].'</td>';
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
                                                    <th>Контрагент</th>
                                                    <th>Предмет договора</th>
                                                    <th>Статус</th>
                                                </tr>';
                                        for ($i=0; $i<$all_contracts_count;){
                                            $number = $i+1;
                                            if (time() > $all_contracts[$i]['validity']){
                                                echo '<tr>';
                                                echo '<td>'.$number.'</td>';
                                                echo '<td>'.$all_contracts[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                                echo '<td>'.$all_contracts[$i]['contractor_name'].'</td>';
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
        </content>
<script src="/themes/default/js/contract_card.js"></script>

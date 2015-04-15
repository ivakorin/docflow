        <content>
            <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                        <div class="pageheader">
                            <h1><? echo $journal;?>
                                <small><? echo $main;?></small>
                            </h1>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addContract"><? echo $add_contract;?></button>
                </div>
                <div class="col-md-6">
                <? if ($jurist == '1'){
                    echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-success">
                            <div class="panel-heading" role="tab" id="newContracts">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseNewContracts" aria-expanded="true" aria-controls="collapseNewContracts">
                                       Новые договора </a>';
                    if (!empty ($jurist_new_contracts)){
                                    echo '<span class="badge">'.$jurist_new_contracts_count.'</span>';
                    }
                    echo            '
                                </h4>
                            </div>
                            <div id="collapseNewContracts" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="newContracts">
                                <div class="panel-body">';
                    if (!empty ($jurist_new_contracts)){
                    echo            '<table class="table table-responsive table-font">
                                        <tr>
                                            <th>#</th>
                                            <th>Дата внесения</th>
                                            <th>Номер договора</th>
                                            <th>Контрагент</th>
                                            <th>Действия</th>
                                        </tr>';
                    for ($i=0; $i<$jurist_new_contracts_count;){
                                        $number = $i+1;
                                        echo '<tr>';
                                        echo '<td>'.$number.'</td>';
                                        echo '<td>'.date('d.m.Y',$jurist_new_contracts[$i]['incoming_date']).'</td>';
                                        echo '<td>'.$jurist_new_contracts[$i]['contract_number'].'</td>';
                                        echo '<td>'.$jurist_new_contracts[$i]['contractor_name'].'</td>';
                                        echo '<td><a class="btn btn-success btn-xs" href="/index.php/Contracts/contract_card/'.$jurist_new_contracts[$i]['contract_number'].'">Открыть</a></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                    echo        '
                                    </table>';
                    }
                    else {
                        echo '<p>Нет новых договоров</p>';
                    }
                    echo        '</div>
                            </div>
                        </div>';
                    echo '
                    <div class="panel panel-success">
                         <div class="panel-heading" role="tab" id="headingUserContracts">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseUserContracts" aria-expanded="false" aria-controls="collapseUserContracts">
                                    Сопровождаемые договора
                                </a>';
                                if (!empty ($jurist_contracts)){
                                    echo '<span class="badge">'.$jurist_contracts_count.'</span>';
                                }
                    echo    '</h4>
                        </div>
                        <div id="collapseUserContracts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUserContracts">
                            <div class="panel-body">';
                     if (!empty ($jurist_contracts)){
                        echo '<table class="table table-responsive table-font">
                                <tr>
                                    <th>#</th>
                                    <th>Номер</th>
                                    <th>Контрагент</th>
                                    <th>Предмет договора</th>
                                    <th>Статус</th>
                                </tr>';
                    for ($i=0; $i<$jurist_contracts_count;){
                        $number = $i+1;
                        echo '<tr>';
                        echo '<td>'.$number.'</td>';
                        echo '<td>'.$jurist_contracts[$i]['contract_number'].'/'.$jurist_contracts[$i]['letter_type'].'</td>';
                        echo '<td>'.$jurist_contracts[$i]['contractor_name'].'</td>';
                        echo '<td>'.$jurist_contracts[$i]['contract_subject'].'</td>';
                        if($jurist_contracts[$i]['status'] == 'agreed'){
                            echo '<td><a href="/index.php/Contracts/contract_card/'.$jurist_contracts[$i]['contract_number'].'"><span class="label label-success" title="Согласован">Согласован</span></a></td>';
                        }
                        else if ($jurist_contracts[$i]['status'] == 'inprocess'){
                            echo '<td><a href="/index.php/Contracts/contract_card/'.$jurist_contracts[$i]['contract_number'].'"><span class="label label-warning" title="В процессе согласования">Согласование</span></a></td>';
                        }
                        else if ($jurist_contracts[$i]['status'] == 'disagree'){
                            echo '<td><a href="/index.php/Contracts/contract_card/'.$jurist_contracts[$i]['contract_number'].'"><span class="label label-danger" title="Не согласован">Не согласован</span></a></td>';

                        }
                        else if ($jurist_contracts[$i]['status'] == 'signed'){
                            echo '<td><a href="/index.php/Contracts/contract_card/'.$jurist_contracts[$i]['contract_number'].'"><span class="label label-primary" title="Договор подписан">Подписан</span></a></td>';

                        }
                        else {
                            echo '<td><a href="/index.php/Contracts/contract_card/'.$jurist_contracts[$i]['contract_number'].'"><span class="label label-info" title="Проект">Проект</span></a></td>';
                        }
                        echo '</tr>';
                        $i++;
                    }

                    echo '</table>';
                     }
                     else {
                        echo 'Нет сопровождаемых договоров';
                     }
                    echo    '</div>
                        </div>
                    </div>
                    </div>';
                }
                ?>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Мои согласования
                            </a>
                                <?
                                if (!empty ($for_agree)){
                                    echo '<span class="badge">'.$for_agree_count.'</span>';
                                }
                                ?>
                          </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <?
                            if (!empty ($for_agree)){
                                echo '<table class="table table-responsive table-font">
                                        <tr>
                                            <th>#</th>
                                            <th>Номер</th>
                                            <th>Согласование с</th>
                                            <th>Действия</th>
                                        </tr>';
                                    for ($i=0; $i<$for_agree_count;){
                                        $number = $i+1;
                                        echo '<tr>';
                                        echo '<td>'.$number.'</td>';
                                        echo '<td>'.$for_agree[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                        echo '<td>'.date('d.m.Y',$for_agree[$i]['begin_time_stamp']).'</td>';
                                        echo '<td><a class="btn btn-primary btn-xs" href="/index.php/Contracts/member_agree/'.$for_agree[$i]['contract_number'].'/'.$for_agree[$i]['revision'].'">Открыть</a></td>';
                                        echo '</tr>';
                                        $i++;
                                    }

                                echo '</table>';
                            }
                            else {
                                echo 'Нет договоров ожидающих согласования';
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingTwo">
                          <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Иницированые договора
                            </a>
                            <?
                                if (!empty ($initiator)){
                                    echo '<span class="badge">'.$initiator_count.'</span>';
                                }
                            ?>
                          </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            <?
                                if (!empty ($all_contracts)){
                                    echo '<table class="table table-responsive table-font">
                                        <tr>
                                            <th>#</th>
                                            <th>Номер</th>
                                            <th>Контрагент</th>
                                            <th>Предмет договора</th>
                                            <th>Статус</th>
                                        </tr>';
                                    for ($i=0; $i<$initiator_count;){
                                        $number = $i+1;
                                        echo '<tr>';
                                        echo '<td>'.$number.'</td>';
                                        echo '<td>'.$initiator[$i]['contract_number'].'/'.$initiator[$i]['letter_type'].'</td>';
                                        echo '<td>'.$initiator[$i]['contractor_name'].'</td>';
                                        echo '<td>'.$initiator[$i]['contract_subject'].'</td>';
                                        if($initiator[$i]['status'] == 'agreed'){
                                            echo '<td><a href="/index.php/Contracts/contract_card/'.$initiator[$i]['contract_number'].'"><span class="label label-success" title="Согласован">Согласован</span></a></td>';
                                        }
                                        else if ($initiator[$i]['status'] == 'inprocess'){
                                            echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-warning" title="В процессе согласования">Согласование</span></a></td>';
                                        }
                                        else if ($initiator[$i]['status'] == 'disagree'){
                                            echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-danger" title="Не согласован">Не согласован</span></a></td>';

                                        }
                                        else if ($initiator[$i]['status'] == 'signed'){
                                            echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-primary" title="Договор подписан">Подписан</span></a></td>';

                                        }
                                        else {
                                            echo '<td><a href="/index.php/Contracts/contract_card/'.$all_contracts[$i]['contract_number'].'"><span class="label label-info" title="Проект">Проект</span></a></td>';
                                        }
                                        echo '</tr>';
                                        $i++;
                                    }

                                    echo '</table>';
                                }
                                else{
                                    echo 'Нет курируемых договоров';
                                }
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingThree">
                          <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              Курируемые договора
                            </a>
                            <?
                                if (!empty ($all_contracts)){
                                    echo '<span class="badge">'.$curator_count.'</span>';
                                }
                            ?>
                          </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                            <?
                                if (!empty ($all_contracts)){
                                    echo '<table class="table table-responsive table-font">
                                        <tr>
                                            <th>#</th>
                                            <th>Номер</th>
                                            <th>Контрагент</th>
                                            <th>Предмет договора</th>
                                            <th>Статус</th>
                                        </tr>';
                                    for ($i=0; $i<$curator_count;){
                                        $number = $i+1;
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

                                    echo '</table>';
                                }
                                else{
                                    echo 'Нет курируемых договоров';
                                }
                            ?>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
<script src="/themes/default/js/agree_list.js"></script>
            </div>
<!--Add contract modal -->
            <div class="modal fade" id="addContract" tabindex="-2" role="dialog" aria-labelledby="addContractorlabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" id="addContractorlabel"><? echo $add_contract;?></h4>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open_multipart('/Contracts/add_contract', array('id' => 'add_contract')); ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?echo form_input('contract_number',$contract_number,'type="text" class="form-control" disabled');?>
                                        </div>
                                        <div class="col-md-4">
                                            <?echo form_input('incoming_date',$date,'type="text" class="form-control" disabled');?>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name = "contract_species" title="Вид договора" required>
                                                <option value=""></option>
                                                <?
                                                    foreach ($species as $value){
                                                        echo '<option value='.$value['species'].'>'.$value['species'].'</option>';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?  echo form_input('incoming_contract_number','','type="text" class="form-control" id="focusedInput" placeholder="Номер у контрагента"');?>
                                        </div>
                                        <div class="col-md-6">
                                            <?echo form_input('incoming_contract_date','','type="text" class="form-control" id="contractor-date" data-provide="datepicker" data-date-language="ru" autocomplete="off" data-date-format="dd.mm.yyyy" placeholder="Дата у контрагента"');?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" name="contractor_name" class="form-control" id="contractor" autocomplete="off" placeholder="Контрагент" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="dropdown-contractor" class="well" hidden="true"></div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?  echo form_input('contract_subject','','type="text" class="form-control" placeholder="Предмет договора" required');?>
                                        </div>
                                        <div class="col-md-3">
                                            <?  echo form_input('contract_cost','','type="text" class="form-control" placeholder="Цена договора" required');?>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" name = "valute" title="Литера договора" required>
                                                <option value=""> </option>
                                                <?
                                                    foreach ($valute_list as $value){
                                                        echo '<option value='.$value['valute_name'].'>'.$value['valute_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?  echo form_input('initiator','','autocomplete="off" id="initiator" type="text" class="form-control" placeholder="Инициатор" required');?>
                                        </div>
                                    </div>
                                    <div id="dropdown-initiator" class="well" hidden="true"></div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="contract_type" class="form-control" required>
                                                <option value=""> </option>
                                                <?
                                                    foreach ($purchase_types as $value){
                                                        echo '<option value='.$value['type'].'>'.$value['type'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="purchase_method" id="purchase_method" class="form-control" required>
                                                <option value=""> </option>
                                                <?
                                                    foreach ($purchase_methods as $value){
                                                        echo '<option value="'.$value['type'].'">'.$value['type'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="validity" class="form-control" id="validity-date" data-provide="datepicker" data-date-language="ru" autocomplete="off" data-date-format="dd.mm.yyyy" placeholder="Срок действия" title="Срок действия договора">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?
                                    echo form_upload('userfile','','id="userfile" required');
                                    ?>
                                    <p class="help-block">Приложите проект договора</p>
                                </div>
                                <?echo form_hidden('curator', $curator);?>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary" form="add_contract">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
<script src="/themes/default/datepicker/js/bootstrap-datepicker.js"></script>
<script src="/themes/default/js/add_contract.js"></script>
        </content>

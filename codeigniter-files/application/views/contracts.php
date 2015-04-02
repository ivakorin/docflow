        <content>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pageheader">
                            <h1><? echo $journal;?>
                                <small><? echo $main;?></small>
                            </h1>
                        </div>
                        <?
                        if ($jurist == '1'){
                            echo '<a class="btn btn-default" href="/index.php/Contracts/add_contractor">'.$add_contractor.'</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-5">
                        <h2><? echo $contracts_list?></h2>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-condensed table-hover table-font">
                            <thead>
                                <tr>
                                    <th >№</th>
                                    <th>Литера</th>
                                    <!--<th>Сторона</th>!-->
                                    <th>Дата</th>
                                    <!--<th>Вх. № дог</th>!-->
                                    <th>Дата договора</th>
                                    <th>Контрагент</th>
                                    <th>Предмет</th>
                                    <th>Цена</th>
                                    <th>Валюта</th>
                                    <th>Инициатор</th>
                                    <th>Вид</th>
                                    <th>Способ</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?  foreach ($all_contracts as $row){
                                    if($row['status'] == 'agreed'){
                                        echo '<tr class="success">';
                                    }
                                    else if ($row['status'] == 'inprocess'){
                                        echo '<tr class="warning">';
                                    }
                                    else if ($row['status'] == 'disagree'){
                                        echo '<tr class="danger">';

                                    }
                                    else {
                                        echo '<tr class="info">';
                                    }
                                    echo '<td>'.$row['contract_number'].'</td>';
                                    echo '<td>'.$row['letter_type'].'</td>';
                                    //echo '<td>'.$row['contract_species'].'</td>';
                                    echo '<td>'.date('d.m.Y',$row['incoming_date']).'</td>';
                                    //echo '<td>'.$row['incoming_contract_number'].'</td>';
                                    if ($row['incoming_contract_date'] == '0'){
                                        echo '<td>Н/Д</td>';
                                    }
                                    else {
                                        echo '<td>'.date('d.m.Y',$row['incoming_contract_date']).'</td>';
                                    }
                                    echo '<td>'.$row['contractor_name'].'</td>';
                                    echo '<td>'.$row['contract_subject'].'</td>';
                                    echo '<td>'.str_replace('.',',',$row['contract_cost']).'</td>';
                                    echo '<td>'.$row['valute'].'</td>';
                                    echo '<td>'.$row['initiator'].'</td>';
                                    echo '<td>'.$row['contract_type'].'</td>';
                                    if ($row['purchase_method'] == "Не регламентируется"){
                                        echo '<td title="'.$row['purchase_method'].'">Н/Д</td>';
                                    }
                                    else{
                                        echo '<td>'.$row['purchase_method'].'</td>';
                                    }
                                    if($row['status'] == 'agreed'){
                                        echo '<td><span class="label label-success" title="Согласован">Согласован</span></td>';
                                    }
                                    else if ($row['status'] == 'inprocess'){
                                        echo '<td><span class="label label-warning" title="В процессе согласования">В процессе</span></td>';
                                    }
                                    else if ($row['status'] == 'disagree'){
                                        echo '<td><span class="label label-danger" title="Не согласован">Не согласован</span></td>';

                                    }
                                    else if ($row['status'] == 'signed'){
                                        echo '<td><span class="label label-primary" title="Договор подписан">Подписан</span></td>';

                                    }
                                    else {
                                        echo '<td><span class="label label-info" title="Проект">Проект</span></td>';
                                    }
                                    echo '<td><a class="btn btn-primary btn-xs" href="/index.php/Contracts/contract_card/'.$row['contract_number'].'">Открыть</a></td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
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
                                        <div class="col-md-3">
                                            <?echo form_input('contract_number',$contract_number,'type="text" class="form-control" disabled');?>
                                        </div>
                                        <div class="col-md-3">
                                            <?echo form_input('incoming_date',$date,'type="text" class="form-control" disabled');?>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" name = "letter_type" title="Литера договора" required>
                                                <option value=""> </option>
                                                <?
                                                    foreach ($letters_list as $value){
                                                        echo '<option value='.$value['letter'].'>'.$value['letter'].'</option>';
                                                    }
                                                ?>
                                            </select>
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
                                            <input type="text" name="validity" class="form-control" id="validity-date" data-provide="datepicker" data-date-language="ru" autocomplete="off" data-date-format="dd.mm.yyyy" placeholder="Срок действия" title="Срок действия договора"
                                        </div>
                                    </div>
                                </div>
                                <?echo form_hidden('curator', $curator);?>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary" form="add_contract">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </content>
<script src="/themes/default/datepicker/js/bootstrap-datepicker.js"></script>
<script src="/themes/default/js/add_contract.js"></script>

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
        </content>
<script src="/themes/default/datepicker/js/bootstrap-datepicker.js"></script>
<script src="/themes/default/js/add_contract.js"></script>

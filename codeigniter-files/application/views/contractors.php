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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Тип</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?  foreach ($all_contractors as $row){
                                    echo '<tr>';
                                    echo '<td>'.$row['name'].'</td>';
                                    if ($row['type'] == '0'){
                                        echo '<td>Поставщик</td>';
                                    }
                                    else if ($row['type'] == '1'){
                                        echo '<td>Заказчик</td>';
                                    }
                                    else {
                                        echo '<td>Прочее</td>';
                                    }
                                    echo '<td><a class="btn btn-primary btn-xs" href="/index.php/Contracts/contractor_card/'.$row['id'].'">Открыть</a> ';
                                    if ($jurist = '1'){
                                        echo '<a class="btn btn-danger btn-xs" href="#">Удалить</a>';
                                    }
                                    echo '</td>';
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

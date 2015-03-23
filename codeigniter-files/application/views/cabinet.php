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
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
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
                                echo '<table class="table table-responsive">
                                        <tr>
                                            <th>#</th>
                                            <th>Номер</th>
                                            <th>Действия</th>
                                        </tr>';
                                    for ($i=0; $i<$for_agree_count;){
                                        $number = $i+1;
                                        echo '<tr>';
                                        echo '<td>'.$number.'</td>';
                                        echo '<td>'.$for_agree[$i]['contract_number'].'/'.$all_contracts[$i]['letter_type'].'</td>';
                                        echo '<td><a class="btn btn-primary" href="/index.php/Contracts/member_agree/'.$for_agree[$i]['contract_number'].'/'.$for_agree[$i]['revision'].'">Открыть</a></td>';
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
                                    echo '<table class="table table-responsive">
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
                                    echo '<table class="table table-responsive">
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
<!--
                   <p class="lead">Курируемые договора</p>
                   <p class="lead">Мои согласования</p>
                   <p class="lead">Иницированые договора</p>
-->
                </div>
            </div>
<script src="/themes/default/js/agree_list.js"></script>
            </div>
        </content>

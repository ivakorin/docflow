        <content>
            <div class="container-fluid">
            <?
            if ($global_status =='inprocess'){
                $g_status =  '<span class="label label-warning" title="В процессе согласования">В процессе согласования</span> ';
            }
            else if ($global_status == 'disagree'){
                $g_status =  '<span class="label label-danger" title="Не согласован">Не согласовано</span> ';
            }
            else if ($global_status == 'agreed'){
                $g_status =  '<span class="label label-success" title="Согласован">Согласовано</span> ';
            }
            else {
                $g_status =  '<span class="label label-primary" title="Прерван">Процес согласования прерван</span> ';
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="pageheader">
                        <h1><? echo $journal.$revision.'(<a href=/index.php/Contracts/contract_card/'.$number.'>Договор № '.$number.'/'.$letter.'</a>)'?><small> <? echo $main;?></small></h1>
                        <h3 class="text-muted">Номер у контрагента: <?echo $incoming_contract_number?></h3>
                        <h2><? echo'<small>'.$g_status.'</small>'?></h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Предмет договора: <em>"<? echo $contract_subject;?>"</em>
                    <?
                    if ($contract_species == 'Расходный'){
                        echo '<strong class="text-danger">('.$contract_species.')</strong>';
                    }
                    else {
                        echo '<strong class="text-success">('.$contract_species.')</strong>';
                    }
                    ?>
                    </h3>
                    <h4>Документ: <?echo '<a href="'.$link_to_file.'">'.$file_name.'</a>'?></h4>
<!--
                    <h5>Статус: <?echo $g_status;?></h5>
-->
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h4>Участники согласования:</h4>
                    <?
                     $arr_length = count($members);
                     for ($i = 0; $i < $arr_length; $i++){
                        echo '<p>';
                        echo $members[$i]['member'];
                        if ($members[$i]['status'] =='inprocess'){
                            echo' <span class="text-warning" title="В процессе согласования">В процессе согласования</span> ';
                        }
                        else if ($members[$i]['status'] == 'disagree'){
                            echo' <span class="text-danger" title="Не согласован">Не согласен</span> ';
                        }
                        else if ($members[$i]['status'] == 'agreed'){
                            echo' <span class="text-success" title="Согласован">Согласен</span> ';
                        }
                        else {
                            echo' <span class="text-primary" title="Согласование прервно">Согласование прервно</span> ';
                        }
                        echo'</p>';
                        if (!empty ($members[$i]['note'])){
                            $id = 'heading'.$i;
                            $collapse = 'collapse'.$i;
                            $title = 'Замечания';
                            echo '<div class="panel panel-danger">
                                    <div class="panel-heading" role="tab" id="'.$id.'">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                        </h4>
                                    </div>
                                </div>
                                <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">
                                <div class="panel-body">
                                    '.$members[$i]['note'].'
                                </div>
                                </div>';
                        }
                        else{

                        }
                     }
                    if ($jt == '1'){
                        if ($global_status == 'inprocess'){
                            echo '<p><button class="btn btn-danger" id="break" type="button">Прервать согласование</button></p>';
                        }
                        else {
                        }
                    }
                    ?>
                    </div>
                    <div class="col-md-6">
                        <p>Куратор:
                            <?  echo '<a href="mailto:'.$email.'">';
                                echo $initials;
                                echo '</a>';
                            ?>
                        </p>
                        <p>Инициатор: <?echo $initiator;?></p>
                        <p>Отдел: <?echo $department;?></p>
                        <p>Контрагент: <strong><? echo $contractor_name;?></strong></p>
                        <p>Цена договора: <em><? echo str_replace('.',',',$contract_cost);?></em></p>
                        <p>Валюта: <em><? echo $valute_description;?></em></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingThree">
                              <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Все листы согласования
                                </a>
                              </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                  <div class="panel-body">
                                    <?
                                    $count_lists = count($all_lists);
                                    for ($i='0'; $i<$count_lists; $i++){
                                        echo '<p><a href="/index.php/Contracts/agree_list/'.$number.'/'.$all_lists[$i]['revision'].'">Лист согласования № '.$all_lists[$i]['revision'].'-';
                                            if ($all_lists[$i]['global_status'] =='inprocess'){
                                                echo' <span class="text-warning" title="В процессе согласования">В процессе</span></a></p>';
                                            }
                                            else if ($all_lists[$i]['global_status'] == 'disagree'){
                                                echo' <span class="text-danger" title="Не согласован">Не согласован</span></a></p>';
                                            }
                                            else if ($all_lists[$i]['global_status'] == 'agreed'){
                                                echo' <span class="text-success" title="Согласован">Согласован</span></a></p>';
                                            }
                                            else {
                                                echo' <span class="text-primary" title="Прерван">Прерван</span></a></p>';
                                            }
                                    }
                                    ?>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p hidden id="contract_number"><? echo $number?></p>
            <p hidden id="list_revision"><? echo $revision?></p>
<script src="/themes/default/js/agree_list.js"></script>
            </div>
        </content>

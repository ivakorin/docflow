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
                        <h4>Согласование:</h4>
                        <div class="col-md-12">
                        <?
                        if ($user_permission !=1){
                            echo '<p class="lead">Вы не являетесь участником согласования</p>';
                        }
                        else if($global_status == 'interrupted') {
                            echo '<p class="lead">Процесс согласования завершён</p>
                                <a class="btn btn-default" href="/index.php/Contracts/agree_list/'.$number.'/'.$revision.'">Перейти к листу согласования</a>';
                        }
                        else if ($voted != 0){
                            echo '<p class="lead">Вы уже завизировали документ</p><a class="btn btn-default" href="/index.php/Contracts/agree_list/'.$number.'/'.$revision.'">Перейти к листу согласования</a>';
                        }
                        else {
                            echo '<button class="btn btn-success" id="agreed">Согласен</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#notes">Не согласен</button>';
                        }
                        ?>
                        </div>
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
                <div class="col-md-11">
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
<!-- Модальное окно замечаний -->
<div class="modal fade" id="notes" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Замечания</h4>
      </div>
      <div class="modal-body">
        <form id="update_status">
        <textarea name="note" class="form-control has-error" rows="3" id="textarea"></textarea>
        <input hidden value="<?echo $active_user?>" name="member">
        <input hidden value="<?echo $number?>" name="contract_number">
        <input hidden value="<?echo $revision?>" name="revision">
        <input hidden value="1" name="voted">
        <input hidden value="disagree" name="status">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" form="update_status" class="btn btn-danger" id="disagree">Записать</button>
      </div>
    </div>
  </div>
</div>


<script src="/themes/default/js/member_agree.js"></script>
    </div>
        </content>

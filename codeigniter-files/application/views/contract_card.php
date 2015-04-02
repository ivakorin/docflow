        <content>
            <div class="container-fluid">
            <?  $files_list = ['none' => 'Выберете проект'];
                foreach ($files_list0 as $fv){
                    $files_list[$fv['file_name']]=$fv['file_name'];
                }
                $letters = ['none' => 'Выберете литеру'];
                foreach ($letters_list as $value){
                    $letters[$value['letter']] = $value['letter'];
                }
                unset ($value);
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pageheader">
                            <h1><? echo $journal;?>
                                <small><? echo $main;?></small>
                            </h1>
                        </div>
                    </div>
                </div>
                <?
                if ($jt == '1' && $letter_type == 'N/A' ){
                    echo '
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-danger"><strong>Внимание!</strong> Необходимо установить литеру договора</h1>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add_letter">Добавить литеру</button>
                        </div>
                        <div class="modal fade" tabindex="-1" id="add_letter"role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">';
                                echo form_open ('','class="form-inline" id="letter_form"');
                                echo    '<div class="form-group">
                                            <label for="letter">Литера</label>';
                                            echo form_dropdown ('letter', $letters, '','id="letter" class="form-control"');
                                echo    '</div>';
                                echo form_hidden ('contract_number', $contract_number);
                                echo form_hidden ('jurist', $user_email);
                                echo form_close();
                                echo '</div>
                              <div class="modal-footer">
                                <button type="close" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                <button type="submit" id="add_letters_btn" form="letter_form" class="btn btn-primary">Добавить</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>';
                }
                ?>
                <div class="row">
                    <div class="col-md-5">
                        <p class="lead">Договор №: <?echo $contract_number.'/'.$letter_type;?><small class="text-muted">/<? echo $incoming_contract_number;?></small>
                        <?
                        if (time() > $validity && $status == 'signed'){
                            echo '<em class="text-danger">(Не действующий)</em>';
                        }
                        else if (time() > $validity && $status == 'signed'){
                            echo '<em class="text-success">(Действующий)</em>';
                        }
                        ?>
                        </p>
                        <p>Куратор:
                            <?  echo '<a href="mailto:'.$email.'">';
                                echo $initials;
                                echo '</a>';
                            ?>
                        </p>
                        <p class="lead">Контрагент: <strong><?echo $contractor_name;?></strong></p>
                        <p class="lead">Предмет договора: <em>"<?echo $contract_subject;?>"</em></p>
                        <p class="lead">Цена договора: <em><?echo str_replace('.',',',$contract_cost);?></em></p>
                        <p class="lead">Валюта: <em><?echo $valute_description;?></em></p>
                        <p class="lead">Статус:
                            <?  if ($status == 'agreed'){
                                    echo '<em class="text-success" >Согласован</em>';
                                    if ($jt == '1'){
                                        echo '<div class="form-inline"><div class="form-group">';
                                        echo form_open ('Contracts/contract_signed','id="signed-form"');
                                        echo form_hidden('status','signed');
                                        echo form_hidden('contract_number', $contract_number);
                                        echo form_hidden ('curator_email', $email);
                                        echo '<button id="signed-btn" class="btn btn-primary">Договор подписан</button>';
                                        echo form_close();
                                        echo '</div></div>';
                                    }
                                }
                                else if ($status == 'inprocess'){
                                    echo '<em class="text-warning" >На согласовании</em>';
                                }
                                else if ($status == 'disagree'){
                                    echo '<em class="text-danger" >Не согласован</em>';
                                }
                                else if ($status == 'signed'){
                                    echo '<em class="text-primary" >Подписан</em>';
                                }
                                else{
                                    echo '<em class="text-info" >Проект</em>';
                                }
                            ?>
                        </p>
                        <p class="lead">Инициатор: <?echo $initiator;?></p>
                        <div class="col-md-4">
                            <dl>
                                <dt>Дата поступления</dt>
                                    <dd><p><? echo date('d.m.Y', $incoming_date);?></p></dd>
                                <dt>Дата у контрагента</dt>
                                    <dd><p><? echo date('d.m.Y', $incoming_contract_date);?></p></dd>
                                    <?
                                        if (time() > $validity){
                                            echo '<dt class="text-danger">Срок действия истёк</dt><dd><p class="text-danger">'.date('d.m.Y', $validity).'</p></dd>';
                                        }
                                        else {
                                            echo '<dt class="text-success">Срок действия</dt><dd><p class="text-success">'.date('d.m.Y', $validity).'</p></dd>';
                                        }

                                    ?>
                            </dl>
                        </div>
                        <div class="col-md-4">
                            <dl>
                                <dt>Вид договора</dt>
                                    <dd><?
                                        if ($contract_species == "Расходный"){
                                            echo '<p class="text-danger">'.$contract_species.'</p>';
                                        }
                                        else{
                                            echo '<p class="text-success">'.$contract_species.'</p>';
                                        }
                                    ?></dd>
                                <dt>Тип договора</dt>
                                <dd><p><?echo $contract_type;?></p></dd>
                                <dt>Способ закупки</dt>
                                <dd><p><?echo $purchase_method;?></p></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12">
                            <h3>Документы договора</h3>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?  if (!empty($files_list0)){
                                        $id = 'heading0';
                                        $collapse = 'collapse0';
                                        $title = 'Проект договора';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">';
                                        echo '<div class="panel-body">';
                                        echo '<div class="row">';
                                        foreach ($files_list0 as $row ){
                                            $create_date = strtotime($row['link_timestamp']);
                                            echo '<a href="'.$row['link_to_file'].'">';
                                            // ВНИМАНИЕ! класс ниже (col-md-8) используется в js для получения имени файла, при изменении также необходимо исправить js файл
                                            echo '<p class="col-md-8" >'.$row['file_name'].'</p>';
                                            echo '<p class="col-md-3">'.date('d.m.Y', $create_date).'</p>';
                                            echo '</a>';
                                            if ($jt == '1'){
                                            echo '<button type="submit" class="delete-contract-card" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                            }
                                        }
                                        echo '</div>
                                            </div>
                                    </div>';
                                    }
                                    else {
                                        $id = 'heading0';
                                        $collapse = 'collapse0';
                                        $title = 'Проект договора';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">
                                    <div class="panel-body">
                                    Документы отсутствуют
                                            </div>
                                    </div>';
                                    }
                                    if (!empty($files_list1)){
                                        $id = 'heading1';
                                        $collapse = 'collapse1';
                                        $title = 'Договорная переписка';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">';
                                        echo '<div class="panel-body">';
                                        echo '<div class="row">';
                                        foreach ($files_list1 as $row ){
                                            $create_date = strtotime($row['link_timestamp']);
                                            echo '<a href="'.$row['link_to_file'].'">';
                                            // ВНИМАНИЕ! класс ниже (col-md-8) используется в js для получения имени файла, при изменении также необходимо исправить js файл
                                            echo '<p class="col-md-8" >'.$row['file_name'].'</p>';
                                            echo '<p class="col-md-3">'.date('d.m.Y', $create_date).'</p>';
                                            echo '</a>';
                                            if ($jt == '1'){
                                            echo '<button type="submit" class="delete-contract-card" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                            }
                                        }
                                        echo '</div>
                                            </div>
                                    </div>';
                                    }
                                    else {
                                        $id = 'heading1';
                                        $collapse = 'collapse1';
                                        $title = 'Договорная переписка';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">
                                    <div class="panel-body">
                                    Документы отсутствуют
                                            </div>
                                    </div>';
                                    }
                                    if (!empty($files_list2)){
                                        $id = 'heading2';
                                        $collapse = 'collapse2';
                                        $title = 'Служебная переписка';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">';
                                        echo '<div class="panel-body">';
                                        echo '<div class="row">';
                                        foreach ($files_list2 as $row ){
                                            $create_date = strtotime($row['link_timestamp']);
                                            echo '<a href="'.$row['link_to_file'].'">';
                                            // ВНИМАНИЕ! класс ниже (col-md-8) используется в js для получения имени файла, при изменении также необходимо исправить js файл
                                            echo '<p class="col-md-8" >'.$row['file_name'].'</p>';
                                            echo '<p class="col-md-3">'.date('d.m.Y', $create_date).'</p>';
                                            echo '</a>';
                                            if ($jt == '1'){
                                            echo '<button type="submit" class="delete-contract-card" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                            }
                                        }
                                        echo '</div>
                                            </div>
                                    </div>';
                                    }
                                    else {
                                        $id = 'heading2';
                                        $collapse = 'collapse2';
                                        $title = 'Служебная переписка';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">
                                    <div class="panel-body">
                                    Документы отсутствуют
                                            </div>
                                    </div>';
                                    }
                                    if (!empty($files_list3)){
                                        $id = 'heading3';
                                        $collapse = 'collapse3';
                                        $title = 'Подписанные документы';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">';
                                        echo '<div class="panel-body">';
                                        echo '<div class="row">';
                                        foreach ($files_list3 as $row ){
                                            $create_date = strtotime($row['link_timestamp']);
                                            echo '<a href="'.$row['link_to_file'].'">';
                                            // ВНИМАНИЕ! класс ниже (col-md-8) используется в js для получения имени файла, при изменении также необходимо исправить js файл
                                            echo '<p class="col-md-8" >'.$row['file_name'].'</p>';
                                            echo '<p class="col-md-3">'.date('d.m.Y', $create_date).'</p>';
                                            echo '</a>';
                                            if ($jt == '1'){
                                            echo '<button type="submit" class="delete-contract-card" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                            }
                                        }
                                        echo '</div>
                                            </div>
                                    </div>';
                                    }
                                    else {
                                        $id = 'heading3';
                                        $collapse = 'collapse3';
                                        $title = 'Подписанные документы';
                                        echo '<div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="'.$id.'">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$collapse.'" aria-expanded="false" aria-controls="'.$collapse.'">'.$title.'</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div id="'.$collapse.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$id.'">
                                    <div class="panel-body">
                                    Документы отсутствуют
                                            </div>
                                    </div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12" id="show-add-div">
                            <?
                            if ($jt == '1' && $letter_type !='N/A'){
                                echo '<button class="btn btn-primary" id="show-add-form" type="button">Добавить файл</button>';
                            }
                            else if ($jt != '1'){

                            }
                            else{
                                echo '<p class="text-danger">Чтобы добавлять файлы необходимо установить литеру договора</p>';
                            }
                            ?>
                        </div>
                        <div class="col-md-12" id="upload-form" hidden>
                            <?
                                $droparray =[];
                                foreach ($files_types as $key => $types){
                                    array_push($droparray, $types['file_type']);
                                }
                            ?>
                            <? echo form_open_multipart('/Contracts/add_file','id="upload_file" ');?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <? echo form_upload('userfile','','id="userfile"');
                                           echo '<p class="help-block">Загрузка файлов договора</p>';
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <? echo form_dropdown('file_type',$droparray,'id=file-type');
                                           echo '<p class="help-block">Вид документа</p>';
                                           echo form_hidden('contract_number', $contract_number);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <? echo form_close();?>
                            <button type="submit" id="add-file" form="upload_file" class="btn btn-primary btn-sm">Добавить</button>
                        </div>
                        <div class="col-md-12">
                            <h3>Согласование договора</h3>
                            <?
                            $count_lists = count($all_lists);
                            for ($i='0'; $i<$count_lists; $i++){
                                echo '<p><a href="/index.php/Contracts/agree_list/'.$contract_number.'/'.$all_lists[$i]['revision'].'">Лист согласования № '.$all_lists[$i]['revision'].'-';
                                    if ($all_lists[$i]['global_status'] =='inprocess'){
                                        echo' <span class="text-warning" id="agree_status" title="В процессе согласования">В процессе согласования</span></a></p>';
                                    }
                                    else if ($all_lists[$i]['global_status'] == 'disagree'){
                                        echo' <span class="text-danger" title="Не согласован">Не согласован</span></a></p>';
                                    }
                                    else if ($all_lists[$i]['global_status'] == 'agreed'){
                                        echo' <span class="text-success" title="Согласован">Согласован</span></a></p>';
                                    }
                                    else {
                                        echo' <span class="text-primary" title="Прерван">Согласование прервано</span></a></p>';
                                    }
                            }
                            if ($jt == '1' && $letter_type !='N/A'){
                                echo '<button class="btn btn-success" type="button" data-toggle="modal" data-target="#beginAgree">Начать согласование</button>';
                            }
                            else if ($jt != '1'){

                            }
                            else{
                                echo '<p class="text-danger">Для начала согласования необходимо установить литеру договора</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
<!-- Модальное окно подтверждения удаления файлов!-->
<div class="modal fade bs-example-modal-sm" id="delete-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-danger text-center">Удалить файл?</h4>
            </div>
            <div class="modal-body bg-danger">
                <p class="text-danger"><strong>Внимание!</strong> Удалённый файл невозможно восстановить</p>
                <p class="text-danger"><strong>Вы уверены что хотите продолжить?</strong></p>
            </div>
            <div class="modal-footer bg-danger">
                <button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
                 <button type="button" id="delete-document" class="btn btn-danger" data-dismiss="modal">Да</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="beginAgree" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить участников</h4>
            </div>
            <div class="modal-body">
                <?echo form_open('/Contracts/push_negotiation_data','class="form-horizontal" id="agree-form"');?>
                    <div class="form-group">
                        <?echo form_dropdown('file_name',$files_list,'','class="form-control" id="project-select" placeholder="Имя участника"') ?>
                    </div>
                    <div class="form-group" id="member-group">
                        <?echo form_input('member','','id="member"class="form-control" placeholder="Имя участника" required') ?>
                    </div>
                    <div class="form-group">
                    <div id="dropdown-member" class="well" hidden></div>
                    </div>
                    <? echo form_hidden('contract_number',$contract_number)?>
                <?echo form_close();?>
                <div class="bg-danger" id="button-error"></div>
                <button type="submit" class="btn btn-info" id="add-member">Добавить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-success" form="agree-form">Начать</button>
            </div>
        </div>
    </div>
</div>
        </div>
        </content>
<script src="/themes/default/js/contract_card.js"></script>

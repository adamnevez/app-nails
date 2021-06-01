<?php
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$msg = "";

if (isset($data['BtnSuccess'])) {
    $empty_input = false;
    $data = array_map('trim',$data);
    // Acessa o if quando não há nenhum erro no formulário
    if (!$empty_input) {

        $data['created'] = date('Y-m-d H:i:s');             
        $query_hour ="INSERT INTO hour_schedule (date_weekly,time_weekly,id_weekly,created) 
        VALUES (:date_weekly,:time_weekly,:id_weekly,:created)";
        $add_hour = $conn->prepare($query_hour);
        $add_hour->bindParam(":date_weekly", $data['dateagendamento'],PDO::PARAM_STR);
        $add_hour->bindParam(":time_weekly", $data['timepicker']);
        $add_hour->bindParam(":id_weekly", $data['agendamento']);
        $add_hour->bindParam(":created", $data['created']);
        $add_hour->execute();               

        if (!isset($add_hour)) {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Tente novamente!</div>";
        } else {
            $msg = "<div class='alert alert-success' role='alert'>Cliente Cadastrado com Sucesso!</div>";        
        }
    }
}

?>
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <form method="POST" action="">
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="agendamento">Agedamento da Semana</label>
                        <select class="form-control" name="agendamento" id="agendamento" value=
                        "<?php if (isset($data['agendamento'])) { echo $data['agendamento']; } ?>">
                            <option value="">Selecione Semana</option>
                        <?php
                            $query_schedule ="SELECT id_weekly,weekly FROM weekly_schedule";
                            $result_schedule = $conn->prepare($query_schedule);
                            $result_schedule->execute(); 
                            while ($row_schedule = $result_schedule->fetch(PDO::FETCH_ASSOC)) {
                                extract($row_schedule);
                        ?>             
                            <option value="<?=$id_weekly?>"><?=$weekly?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dateagendamento">Data Agendamento</label>
                        <input type="date" name="dateagendamento" id="dateagendamento" class="form-control" value=
                        "<?php if(isset($data['dateagendamento'])) { echo $data['dateagendamento']; } ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="timepicker">Hora Agendamento</label>
                        <input class="form-control" id="timepicker" name="timepicker" value=
                        "<?php if(isset($data['timepicker'])) { echo $data['timepicker']; } ?>">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="BtnSuccess" class="btn btn-success" value="Enviar">Salvar</button>
                </div>
                
            </form>
        </div>
    </div>
</div>





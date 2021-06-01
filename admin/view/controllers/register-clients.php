<?php
//Receber os dados do formulário
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
// A variável recebe a mensagem de erro
$msg = "";
// Acessar o if quando o usuário clica no botão
if (isset($data['BtnSuccess'])) {
    $empty_input = false;
    $data = array_map('trim',$data);
    // Acessa o if quando não há nenhum erro no formulário
    if (!$empty_input) {
        
        $data['created'] = date('Y-m-d H:i:s');             
        $query_client ="INSERT INTO clients (first_name,last_name,cpf,phone,email,created) 
        VALUES (:first_name,:last_name,:cpf,:phone,:email,:created)";
        $add_client = $conn->prepare($query_client);

        $add_client->bindParam(":first_name", $data['first_name'], PDO::PARAM_STR);
        $add_client->bindParam(":last_name", $data['last_name']);
        $add_client->bindParam(":cpf", $data['cpf']);
        $add_client->bindParam(":phone", $data['phone']);
        $add_client->bindParam(":email", $data['email']);
        $add_client->bindParam(":created", $data['created']);
        $add_client->execute();               

        if (!isset($add_client)) {
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
                        <label for="first_name">Primeiro Nome</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Primeiro nome" value=
                        "<?php if(isset($data['first_name'])) { echo $data['first_name']; } ?>" autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Último Nome</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Último nome" value=
                        "<?php if(isset($data['last_name'])) { echo $data['last_name']; } ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Somente número do CPF" maxlength="14" oninput="maskCPF(this)" value="<?php if(isset($data['cpf'])) { echo $data['cpf']; } ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Telefone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone com o DDD" maxlength="14" oninput="maskPhone(this)" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Digite o seu melhor e-mail" value="
                    <?php if(isset($data['email'])) { echo $data['email']; } ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="BtnSuccess" class="btn btn-success" value="Enviar">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

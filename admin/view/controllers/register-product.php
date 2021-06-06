<?php

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$msg = "";

if (isset($data['BtnSuccess'])) {
    $empty_input = false;
    $data = array_map('trim',$data);
    
    if (!$empty_input) {

        $data['created'] = date('Y-m-d H:i:s');             
        $query_product ="INSERT INTO products (name,description,price,image,created) 
        VALUES (:name,:description,:price,:image,:created)";
        $add_procuct = $conn->prepare($query_product);

        $add_procuct->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $add_procuct->bindParam(":description", $data['description']);
        $add_procuct->bindParam(":price", $data['price']);
        $add_procuct->bindParam(":image", $data['file']);
        $add_procuct->bindParam(":created", $data['created']);
        $add_procuct->execute();               

        $query_create_folder="SELECT MAX(id) AS id FROM products";
        $result_query = $conn->prepare($query_create_folder);
        $result_query->bindParam(':id',$id,PDO::PARAM_INT);
        $result_query->execute();
        $row_query = $result_query->fetch(PDO::FETCH_ASSOC);
        extract($row_query);

        if ($result_query->rowCount() > 0) {
            $currentPath = $_SERVER['DOCUMENT_ROOT'].'Webstore/images/products/'.$id;
            if(!is_dir($currentPath)) {
                mkdir($currentPath,0777,true);
            } 
        } 

        if (!isset($add_procuct)) {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Tente novamente!</div>";
        } else {
            $msg = "<div class='alert alert-success' role='alert'>Produto Cadastrado com Sucesso!</div>";        
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
                            <label for="name">Nome do Serviço</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Primeiro nome" value=
                            "<?php if(isset($data['name'])) { echo $data['name']; } ?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Preço do Serviço</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Último nome" value=
                            "<?php if(isset($data['price'])) { echo $data['price']; } ?>" onKeyPress="return(moeda(this,'.','.',event))"required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="file">Inserir Imagem</label>
                            <input type="file" name="file" id="file" class="form-control-file" value=
                            "<?php if(isset($data['file'])) { echo $data['file']; } ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea class="form-control rounded-0" name="description" id="description" placeholder="Digite o texto de descrição" rows="6"><?php if(isset($data['description'])) { echo $data['description']; } ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="BtnSuccess" class="btn btn-success" value="Enviar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id = $_POST['id'];
$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$id'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$nome = $dados['nome'];
$endereco = $dados['endereco'];
$email = $dados['email'];
$fone = $dados['fone'];
$etapa = $dados['etapas'];
$media = $dados['media'];

$frase='';
if($etapa == 'Bimestre'){
    $frase = "4 Bimestres";
}elseif($etapa == 'Semestre'){
    $frase = "2 Semestres";
}

$db->close();

?>

<div data-role="panel" data-title-caption="Editar cadastro de escola" data-cls-title="bg-red fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <div class="form-group">            
            <input type="text" id="nome" value="<?php echo $nome ?>" name="nome" data-role="input" data-validate="required" data-prepend="Nome: ">
        </div>
        <div class="form-group">            
            <input type="text" id="endereco" value="<?php echo $endereco?>" data-role="input" data-prepend="Endereço: ">
        </div>
        <div class="form-group">            
            <input type="email" id="email" value="<?php echo $email  ?>" data-role="input" data-prepend="Email: ">
        </div>
        <div class="form-group">            
            <input type="phone" id="fone" value="<?php echo $fone ?>" data-role="input" data-prepend="Fone: ">
        </div>
        <div class="form-group">            
            <input type="number" value="<?php echo $media ?>" id="media" data-role="input" data-prepend="Média: ">
        </div>
        <div class="form-group">            
            <select id="etapa" data-role="select">
                <option value="<?php echo $etapa ?>"><?php echo $frase ?></option>
                <option value="Bimestre">4 Bimestres</option>
                <option value="Semestre">2 Semestres</option>
                
            </select>
        </div>
        <div class="form-group"> 
        <input type="hidden" value="<?php echo $id ?>" id="id">           
            <button class="button primary salvar" >Salvar edição</button>
            <button class="button cancelar" >Cancelar</button>
        </div>

    </form>
</div>
<script>
    $(function(){
        $(".salvar").click(function(e){
            e.preventDefault()
            nome = $("#nome").val()
            endereco = $("#endereco").val()
            email = $("#email").val()
            fone = $("#fone").val()
            id = $("#id").val()
            media = $("#media").val()
            etapa = $("#etapa").val()
            
            if(nome == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>O nome da escola não pode ficar em branco!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/escolas/salvar_edicao_escola.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'nome':nome, 'email':email, 'endereco':endereco,'fone':fone,'id':id, 'media':media,'etapa':etapa },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro editado com sucesso! Você precisará refazer o período de início de fim de cada Bimestre ou Semestre.", "Sucesso", {cls: "success"});
                            
                            $(".cadastro").load("admin/escolas/cadastro.php")
                            $(".tabela").load("admin/escolas/tabela.php")
                        }else{
                            Metro.dialog.create({
                                title: "Aviso",
                                content: "<div>"+response+"</div>",
                                closeButton: true
                            }); 
                            
                        }
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });

            }

        })
        $(".cancelar").click(function(e){
            e.preventDefault()
            $(".cadastro").load("admin/escolas/cadastro.php")          
            

        })
    })
</script>
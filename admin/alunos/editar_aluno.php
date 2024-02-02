<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
$id = $_POST['id'];
$lista = $db->query("SELECT * FROM cad_aluno  WHERE id = '$id'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$nome = $dados['nome'];
$id_escola = $dados['id_escola'];
$id_turma = $dados['id_turma'];
$obs = $dados['obs'];


$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$id_escola'");
$dados = $lista->fetchArray();
$nome_escola = $dados['nome'];



?>

<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

?>

<div data-role="panel" data-title-caption="Editar turma turmas" data-cls-title="bg-red fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <br>
        <h5><?php echo $nome_escola ?></h5>



    <input type="hidden" id="id" value="<?php echo $id ?>">  
        <div class="form-group">            
            <input type="text" value="<?php echo $nome ?>" id="nome" data-role="input" data-prepend="Nome: " >
        </div>
        <div class="form-group">            
            <input type="text" value="<?php echo $obs ?>" id="obs" data-role="input" data-prepend="Observação: " >
        </div>
        <div class="form-group"> 
            <label for="">Selecione uma turma:</label>           
            <select id="turma" data-role="select">
                <?php
                    $lista = $db->query("SELECT * FROM cad_turma  WHERE id = '$id_turma'");
                    $dados = $lista->fetchArray();
                    $id_turma = $dados['id'];
                    $ano = $dados['ano'];
                    $turma = $dados['turma'];
                    $turno = $dados['turno'];

                ?>
                <option value="<?php echo $id_turma ?>"><?php echo $ano.' '.$turma.' '.$turno ?></option>
               <?php
                  $lista = $db->query("SELECT * FROM cad_turma WHERE escola = '$id_escola' ORDER BY turno,ano,turma ASC
                  ");
                          while($dados = $lista->fetchArray()){
                              $id_turma = $dados['id'];
                              $ano = $dados['ano'];
                              $turma = $dados['turma'];
                              $turno = $dados['turno'];
                              ?>
                                  <option value="<?php echo $id_turma ?>"><?php echo $ano.' '.$turma.' '.$turno ?></option>
                              <?php
          
                          }

               ?>
            </select>
        </div>
         <div class="form-group">  
                 
            <button class="button success salvar" >Salvar edição</button>
            <button class="button cancelar" >Cancelar</button>
        </div>

    </form>
</div>

<script>
    $(function(){
        $(".salvar").click(function(e){
            e.preventDefault()
            nome = $("#nome").val()
            obs = $("#obs").val()
           
            turma = $("#turma").val()
            id = $("#id").val()
            
            if(nome == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Digite o nome do aluno!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/alunos/salvar_edita_aluno.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'nome':nome, 'turma':turma, 'id':id,'obs':obs },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro editado com sucesso!", "Sucesso", {cls: "success"});
                            
                            $(".cadastro").load("admin/alunos/cadastro.php")
                            $(".tabela").load("admin/alunos/tabela.php?id="+turma)
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
            $(".cadastro").load("admin/alunos/cadastro.php")
            

        })

       
    })
</script>
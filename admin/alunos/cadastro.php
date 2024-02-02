<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

?>

<div data-role="panel" data-title-caption="Cadastrar alunos" data-cls-title="bg-blue fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <div class="form-group">            
            <select id="escola" data-role="select">
               <option value="">Selecione uma escola...</option>
               <?php
                $lista = $db->query("SELECT * FROM cad_escola  ORDER BY nome ASC");
                while($dados = $lista->fetchArray()){
                    $id = $dados['id'];
                    $nome = $dados['nome'];
                    ?>
                        <option value="<?php echo $id ?>"><?php echo $nome ?></option>
                    <?php

                }

               ?>
            </select>
        </div>
        <div class="form-group mostra_turmas">  
                    
            
        </div>
       
        <div class="form-group">   
            <label for="">Disgite uma lista com nomes de alunos separados por ";"</label>         
           <textarea data-role="textarea" id="alunos_lista" data-prepend="<span class='mif-school'></span>"></textarea>
        </div>
        
        <div class="form-group">            
            <button class="button primary salvar" >Cadastrar</button>
            <button class="button cancelar" >Cancelar</button>
        </div>

    </form>
</div>

<script>
    $(function(){
        $(".salvar").click(function(e){
            e.preventDefault()
            escola = $("#escola").val()
            turma = $("#turma").val()
            alunos = $("#alunos_lista").val()
           
            
            if(escola == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione uma escola!</div>",
                    closeButton: true
                });
            }else if(turma == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione uma turma!</div>",
                    closeButton: true
                });
            }else if(alunos == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Digite o nome do(o) alunos(s)!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/alunos/salvar_aluno.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'escola':escola, 'turma':turma, 'alunos':alunos  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro realizado com sucesso!", "Sucesso", {cls: "success"});
                            
                            //$(".cadastro").load("admin/turmas/cadastro.php")
                            $("#turma").val("")
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

        $("#escola").change(function(){
            id = $(this).val()
            
            
            $(".mostra_turmas").load("admin/alunos/turmas_alunos.php?id="+id)

        })
     
    })
</script>
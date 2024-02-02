<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id_turma = "";
if(isset($_GET['id'])){
    $id_turma = $_GET['id'];
}

$lista = $db->query("SELECT * FROM cad_turma  WHERE id = '$id_turma'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$turno = $dados['turno'];
$ano = $dados['ano'];
$turma = $dados['turma'];
$escola = $dados['escola'];

$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$escola'");
$dados = $lista->fetchArray();
$nome_escola = $dados['nome'];

?>

<div data-role="panel" data-title-caption="Lista de alunos da turma: <?php echo $ano.' '.$turma.' '.$turno ?>" data-cls-title="bg-green fg-white" data-title-icon="<span class='mif-folder'></span>">
<table class="table striped table-border mt-4" id="tabela-categorias">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Nome
                        </th>
                        <th>
                            Observações
                        </th>
                         
                        <th style="text-align: center; width: 150px">Ações</th>                     
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ordem = 1;
                    $lista = $db->query("SELECT * FROM cad_aluno WHERE id_turma = '$id_turma'  ORDER BY nome ASC");
                    while($dados = $lista->fetchArray()){
                        $id = $dados['id'];
                        $nome = $dados['nome'];
                        $obs = $dados['obs'];
                                           

                        ?>
                            <tr class="cat_id" >
                                <td class="py-1" style="width: 50px"><?php echo $ordem ?></td>
                                <td><?php echo $nome ?> </td>
                                <td><?php echo $obs ?> </td>
                                
                                <td style="text-align: center">
                                    <button class="button link editar" style="text-decoration: none;" data-id="<?php echo $id ?>"><span class="mif-pencil"></span></button>
                                    <button class="button link fg-red excluir" style="text-decoration: none;" data-id="<?php echo $id ?>"><span class="mif-bin"></span></button>
                                </td>
                                
                                            
                            </tr>
                            <?php
                                $ordem++;
                                }

                                $db->close();
                            ?>           
                </tbody>
            </table>
</div>

<script>
    $(function(){
        $(".editar").click(function(e){
            e.preventDefault()
            id = $(this).data("id");
            $.ajax({
                    method: "POST",
                    url: "admin/alunos/editar_aluno.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id':id  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".cadastro").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });

        })
        $(".excluir").click(function(e){
            e.preventDefault()
            id = $(this).data("id");
            Metro.dialog.create({
                title: "Confirmar",
                content: "<div>Deseja realmente excluir este cadastro?</div>",
                actions: [
                    {
                        caption: "Sim",
                        cls: "js-dialog-close alert",
                        onclick: function(){
                            $.ajax({
                                method: "POST",
                                url: "admin/alunos/excluir_aluno.php", // Substitua pelo caminho do seu arquivo PHP
                                
                                data: {'id':id  },
                                success: function(response) {
                                    // Manipular a resposta do servidor, se necessário
                                    if(response == 1){
                                        Metro.notify.create("Cadastro excluído com sucesso!", "Sucesso", {cls: "primary"});
                                        
                                        $(".cadastro").load("admin/alunos/cadastro.php")
                                        $(".tabela").load("admin/alunos/tabela.php?id=<?php echo $id_turma ?>")
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
                    },
                    {
                        caption: "Não",
                        cls: "js-dialog-close",
                        onclick: function(){
                            
                        }
                    }
                ]
            });
        })

    })
</script>

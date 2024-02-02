<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

?>

<div data-role="panel" data-title-caption="Escolas cadastradas" data-cls-title="bg-green fg-white" data-title-icon="<span class='mif-folder'></span>">
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
                            Email
                        </th>
                        <th>
                            Endereço
                        </th>
                        <th>
                            Fone
                        </th> 
                        <th>
                            Média
                        </th> 
                        <th style="text-align: center; width: 150px">Ações</th>                     
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ordem = 1;
                    $lista = $db->query("SELECT * FROM cad_escola  ORDER BY nome ASC");
                    while($dados = $lista->fetchArray()){
                        $id = $dados['id'];
                        $nome = $dados['nome'];
                        $endereco = $dados['endereco'];
                        $email = $dados['email'];
                        $fone = $dados['fone'];
                        $etapa = $dados['etapas'];
                        $media = $dados['media'];
                    

                        ?>
                            <tr class="cat_id" >
                                <td class="py-1" style="width: 50px"><?php echo $ordem ?></td>
                                <td><?php echo $nome ?> </td>
                                <td><?php echo $email ?> </td>
                                <td><?php echo $endereco ?> </td>
                                <td><?php echo $fone ?> </td>
                                <td><?php echo $media ?> </td>
                                <td style="text-align: center">
                                    <button class="button link editar" style="text-decoration: none;" data-id="<?php echo $id ?>"><span class="mif-pencil"></span></button>
                                    <button class="button link fg-red excluir" style="text-decoration: none;" data-id="<?php echo $id ?>"><span class="mif-bin"></span></button>
                                    <button class="button link fg-green calendario" style="text-decoration: none;" data-id="<?php echo $id ?>"><span class="mif-calendar"></span></button>
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
                    url: "admin/escolas/editar_escola.php", // Substitua pelo caminho do seu arquivo PHP
                    
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
        $(".calendario").click(function(e){
            e.preventDefault()
            id = $(this).data("id");
            $.ajax({
                    method: "POST",
                    url: "admin/escolas/calendario_escola.php", // Substitua pelo caminho do seu arquivo PHP
                    
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
                                url: "admin/escolas/excluir_escola.php", // Substitua pelo caminho do seu arquivo PHP
                                
                                data: {'id':id  },
                                success: function(response) {
                                    // Manipular a resposta do servidor, se necessário
                                    if(response == 1){
                                        Metro.notify.create("Cadastro excluído com sucesso!", "Sucesso", {cls: "primary"});
                                        
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

<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

?>

<div data-role="panel" data-title-caption="Áreas do conhecimento cadastradas" data-cls-title="bg-green fg-white" data-title-icon="<span class='mif-folder'></span>">
<table class="table striped table-border mt-4" id="tabela-categorias">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Título
                        </th>
                        <th>
                            Abreviação
                        </th>
                        
                        <th style="text-align: center; width: 150px">Ações</th>                     
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ordem = 1;
                    $lista = $db->query("SELECT * FROM cad_area_conhecimento  ORDER BY titulo ASC");
                    while($dados = $lista->fetchArray()){
                        $id = $dados['id'];
                        $titulo = $dados['titulo'];
                        $abreviacao = $dados['abreviacao'];
                      

                        ?>
                            <tr class="cat_id" >
                                <td class="py-1" style="width: 50px"><?php echo $ordem ?></td>
                                <td><?php echo $titulo ?> </td>
                                <td><?php echo $abreviacao ?> </td>
                               
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
                    url: "admin/areas/editar_area.php", // Substitua pelo caminho do seu arquivo PHP
                    
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
                                url: "admin/areas/excluir_area.php", // Substitua pelo caminho do seu arquivo PHP
                                
                                data: {'id':id  },
                                success: function(response) {
                                    // Manipular a resposta do servidor, se necessário
                                    if(response == 1){
                                        Metro.notify.create("Cadastro excluído com sucesso!", "Sucesso", {cls: "primary"});
                                        
                                        $(".cadastro").load("admin/areas/cadastro.php")
                                        $(".tabela").load("admin/areas/tabela.php")
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

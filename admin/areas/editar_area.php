<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id = $_POST['id'];
$lista = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$titulo = $dados['titulo'];
$abreviacao = $dados['abreviacao'];


$db->close();

?>

<div data-role="panel" data-title-caption="Cadastrar Área do conhecimento" data-cls-title="bg-blue fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <div class="form-group">            
            <input type="text" id="titulo" value="<?php echo $titulo ?>" name="titulo" data-role="input" data-validate="required" data-prepend="Título: ">
        </div>
        <div class="form-group">            
            <input type="text" id="abreviacao" value="<?php echo $abreviacao ?>" name="abreviacao" data-role="input" data-validate="required" data-prepend="Abreviação: ">
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
            titulo = $("#titulo").val()
            abreviacao = $("#abreviacao").val()
            id = $("#id").val()
         
           
            if(titulo == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>O título da área do conhecimento não pode ficar em branco!</div>",
                    closeButton: true
                });
            }else if(abreviacao == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Escolha uma sigla para a área do conhecimento!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/areas/salvar_editar_area.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'titulo':titulo,'abreviacao':abreviacao,'id':id },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro editado com sucesso!", "Sucesso", {cls: "success"});
                            
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

        })
        $(".cancelar").click(function(e){
            e.preventDefault()
            $(".cadastro").load("admin/areas/cadastro.php")
            

        })
    })
</script>
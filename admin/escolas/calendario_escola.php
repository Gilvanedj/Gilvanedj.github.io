<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id=0;
if(isset($_GET['id'])){
    $id =  $_GET['id'];
}else{
    $id = $_POST['id'];
}


$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$id'");
$dados = $lista->fetchArray();
$etapa = $dados['etapas'];

$total_etapas = 0; $divisao = "";
if($etapa == 'Bimestre'){
    $total_etapas = 4;
    $divisao = "º Bim";
}else{
    $total_etapas = 2;
    $divisao = "º Sem";
}


?>

<div data-role="panel" data-title-caption="Editar calendário de <?php echo $etapa.'s' ?>" data-cls-title="bg-red fg-white" data-title-icon="<span class='mif-calendar'></span>">
<form action="" method="post" id="form">


    <div class="form-group">            
            <select id="etapa" data-role="select">
                <option value="">Selecione um <?php echo $etapa ?></option>
                <?php
                for($i=1;$i<=$total_etapas;$i++){
                    ?>
                        <option value="<?php echo $i.$divisao ?>"><?php echo $i.$divisao ?></option>
                    <?php
                }

                ?>                
                
            </select>
    </div>
    <div class="form-group">
        <input type="text" id="inicio"  data-role="calendarpicker" data-locale="pt-BR" data-format="%d %b %Y" placeholder="Início do <?php echo $etapa ?>."   data-dialog-mode="true">
    </div> 
    <div class="form-group">
        <input type="text" id="termino"  data-role="calendarpicker" data-locale="pt-BR" data-format="%d %b %Y" placeholder="Término do <?php echo $etapa ?>."   data-dialog-mode="true">
    </div> 
    <div class="form-group">            
        <button class="button primary salvar" >Atualizar</button>
        <button class="button cancelar" >Sair</button>
    </div>
</form>
<br>
<table class="table striped table-border mt-4">
    <thead>
                    <tr>
                        <th>
                            Período
                        </th>
                        <th>
                            Início
                        </th>
                        <th>
                            Término
                        </th>
                                             
                    </tr>
    </thead>
    <tbody>
        <?php
            $lista = $db->query("SELECT * FROM cad_periodo  WHERE id_escola = '$id' ORDER BY etapa ASC");
            while($dados = $lista->fetchArray()){
                $inicio = $dados['inicio']; 
                $termino = $dados['termino']; 
                $periodo = $dados['etapa'];    
                ?>
                <tr>
                    <td><?php echo $periodo ?></td>
                    <td><?php echo $inicio ?></td>
                    <td><?php echo $termino ?></td>
                </tr>

                <?php
            }
        ?>
    </tbody>

</table>


</div>



<script>
    $(function(){
        $('.cancelar').click(function(){
            $("#corpo").load("admin/escolas/painel.php")
        })
        $('.salvar').click(function(e){
            e.preventDefault()
            etapa = $("#etapa").val()
            inicio = $("#inicio").val()
            termino = $("#termino").val()
            id_escola = "<?php echo $id ?>"

            if(inicio=="" || termino ==""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione um data para início e fim de período!</div>",
                    closeButton: true
                });
            }else if(etapa=="" ){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione um período!</div>",
                    closeButton: true
                });
            }else{

           

            $.ajax({
                    method: "POST",
                    url: "admin/escolas/salva_calendario.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_escola':id_escola, 'inicio':inicio,'termino':termino,'etapa':etapa 
                      },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            $(".cadastro").load("admin/escolas/calendario_escola.php?id="+id_escola)
                        }else{
                            alert(response)
                        }
                        
                        
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });

            }

        })
    })
</script>
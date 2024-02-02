<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id = $_GET['id'];
$id_professor = $_GET['id_professor'];
$lista = $db->query("SELECT * FROM cad_turma  WHERE id = '$id'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$turno = $dados['turno'];
$ano = $dados['ano'];
$turma = $dados['turma'];
$escola = $dados['escola'];

$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$escola'");
$dados = $lista->fetchArray();
$nome_escola = $dados['nome'];
$etapas = $dados['etapas'];
$media = $dados['media'];
$total_etapas = 0; $divisao = "";
if($etapas == 'Bimestre'){
    $total_etapas = 4;
    $divisao = "º Bim";
}else{
    $total_etapas = 2;
    $divisao = "º Sem";
}


?>

<div data-role="panel" data-title-caption="Imprimir frequencia mensal da turma: <?php echo $ano.' '.$turma.' '.$turno ?> " data-cls-title="bg-blue fg-white" data-title-icon="<span class='mif-folder'></span>">

<div class="row">
    <div class="cell-2 p-2">
        <div class="form-group"> 
                <select id="disciplina" data-role="select">  
                <option value="">Selecione uma disciplina...</option>                  
                    <?php
                     $lista = $db->query("SELECT * FROM cad_carga  WHERE id_professor = '$id_professor' AND id_turma = '$id' ");
                     while($dados = $lista->fetchArray()){                      
                         
                         $id_area = $dados['id_area']; 
                         $lista2 = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id_area'");
                            $dados2 = $lista2->fetchArray();
                            $id_area2 = $dados2['id'];
                            $titulo = $dados2['titulo'];
                    ?>
                    <option value="<?php echo $id_area2 ?>"><?php echo $titulo ?></option>
                            
                    <?php
                     }

                    ?>
                    </select>
        </div> 
    </div>
    <div class="cell-2 p-2">
        <div class="form-group"> 
            <select id="mes" data-role="select">  
                <option value="">Selecione um mês</option>  
                <option value="1">Janeiro</option> 
                <option value="2">Fevereiro</option> 
                <option value="3">Março</option> 
                <option value="4">Abril</option> 
                <option value="5">Maio</option> 
                <option value="6">Junho</option> 
                <option value="7">Julho</option> 
                <option value="8">Agosto</option> 
                <option value="9">Setembro</option> 
                <option value="10">Outubro</option> 
                <option value="11">Novembro</option> 
                <option value="12">Dezembro</option>                  
                    
            </select>
        </div> 
    </div>
    <div class="cell-2 p-2">
        <div class="form-group"> 
            <input type="number" id="ano_letivo" name="ano" data-role="input" data-validate="required" data-prepend="Ano: ">
        </div> 
    </div>
    <div class="cell-2 p-2">
        <div class="form-group"> 
            <button class="button primary abre_planilha">Abrir planilha</button>
        </div> 
    </div>
    
    <div class="cell-12 p-2">
       <div class="mostra"></div>
    </div>
</dvi>
    
</div>

<script>
    $(function(){
        $('#ano').mask('0000', { reverse: true });
        $("#disciplina").change(function(){
            $(".mostra").html("")          
            
        })
        $("#mes").change(function(){
            $(".mostra").html("")          
            
        })
        $(".abre_planilha").click(function(){
            id_disciplina = $("#disciplina").val()
            mes = $("#mes").val()
            ano = $("#ano_letivo").val()
            id_turma = "<?php echo $id ?>"
            id_professor = "<?php echo $id_professor ?>"

            if(id_disciplina == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione uma disciplina!</div>",
                    closeButton: true
                });
            }else  if(mes == "" || ano == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione um mês e digite um ano!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/imprimir/planilha.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_disciplina':id_disciplina,'id_turma':id_turma,'id_professor':id_professor,'mes':mes,'ano':ano  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".mostra").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
            }
            
           
            
        })
    })
</script>


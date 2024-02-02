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


?>
<br>
<div data-role="panel" data-title-caption="Lançamento de frequência da turma: <?php echo $ano.' '.$turma.' '.$turno ?> " data-cls-title="bg-gray fg-white" data-title-icon="<span class='mif-folder'></span>">

<div class="row">
  
  <div class="cell-12 p-2">
    <div>
        <div class="row">

            <div class="cell-3 p-2">
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
                    <input type="text" id="data"  data-role="calendarpicker" data-locale="pt-BR" data-format="%d %b %Y" placeholder="Selecione uma data."   data-dialog-mode="true" >
                </div> 
            </div> 
            <div class="cell-2 p-2">
                <div class="form-group ver_tempos">            
                    <select id="tempo" data-role="select" multiple>
                        <option value="">Tempo de aula...</option>
                        <option value="1">1º</option>
                        <option value="2">2º</option>
                        <option value="3">3º</option>
                        <option value="4">4º</option>
                        <option value="5">5º</option>
                        <option value="6">6º</option>
                        <option value="7">7º</option>
                        <option value="8">8º</option>
                        <option value="9">9º</option>
                    </select>
                </div>
            </div>
           
            <div class="cell-1 p-2">
                <button class="button primary abrir_lista" >Abrir lista</button>
            </div>
            <div class="cell-12 p-2">
                <div class="mostra_conteudo"></div>
            </div>
        </div>
    </div>
  </div>
  
</div>
<hr class="bg-blue">
<div class="acao"></div>

 <div class="mostra_chamada"></div>
 

</div>



<script>
     
    $(function(){
       
        $(".abrir_lista").click(function(){
            id_turma = "<?php echo $id ?>" 
            data = $("#data").val();
            tempo = $("#tempo").val();
            escola = $("#escola").val();
            id_professor = $("#professor").val();
            id_disciplina = $("#disciplina").val();

        
            if(data == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione uma data!</div>",
                    closeButton: true
                });
            }else if(tempo == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione um tempo de aula!</div>",
                    closeButton: true
                });
            }else if(id_disciplina == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione uma disciplina!</div>",
                    closeButton: true
                });
            }else { 
                $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/frequencia/lanca_frequencia.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_turma':id_turma, 'data':data,'tempo':tempo,'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina  },
                    success: function(response) {
                      $(".mostra_chamada").html(response) 
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/frequencia/mostra_conteudo.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_turma':id_turma, 'data':data,'tempo':tempo,'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina  },
                    success: function(response) {
                      $(".mostra_conteudo").html(response) 
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
            }
        })

        $("#disciplina").change(function(){
            $(".mostra_conteudo").html("")
            $(".mostra_chamada").html("")
        })
        $("#tempo").change(function(){
            $(".mostra_conteudo").html("")
            $(".mostra_chamada").html("")
        })
        $("#data").change(function(){
            $(".mostra_conteudo").html("")
            $(".mostra_chamada").html("")
        })
    })

    
</script>

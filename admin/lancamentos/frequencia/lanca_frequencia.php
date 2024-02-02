<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id_dia = "";
if(isset($_POST['id_dia'])){
    $id_dia = $_POST['id_dia'];
    $lista = $db->query("SELECT * FROM cad_conteudo  WHERE   id = '$id_dia' ");
    $dados = $lista->fetchArray();

    $data = $dados['data_pt'];
    $tempo = $dados['tempo'];
    $escola = $dados['id_escola'];
    $id_professor = $dados['id_professor'];
    $id_disciplina = $dados['id_disciplina'];
    $id_turma = $dados['id_turma'];

    
    $separa_tempo = explode(',',$tempo);
    $total_tempos = count($separa_tempo);

    $tempo1 = $separa_tempo[0];
    
}else{
    $id_turma = $_POST['id_turma'];
    $data = $_POST['data'];
    $tempo = $_POST['tempo'];
    $escola = $_POST['escola'];
    $id_professor = $_POST['id_professor'];
    $id_disciplina = $_POST['id_disciplina'];

    $tempo = implode(',',$tempo);
    $separa_tempo = explode(',',$tempo);
    $total_tempos = count($separa_tempo);

    $tempo1 = $separa_tempo[0];
    

        
}





$query = "SELECT COUNT(*) as id FROM cad_frequencia WHERE id_turma = '$id_turma' AND data_pt = '$data' AND tempo = '$tempo1' AND id_disciplina != '$id_disciplina' ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['id'];

if($total == 0){

?>

<div class="row">
   
  <div class="cell-6 p-2">
    <?php
    $lista = $db->query("SELECT * FROM cad_conteudo  WHERE  data_pt = '$data' AND tempo = '$tempo' AND id_turma = '$id_turma' AND id_disciplina = '$id_disciplina' ");
    $dados = $lista->fetchArray();
    $id_conteudo = $dados['id'];
    $conteudo = $dados['conteudo'];
    $observacao = $dados['observacao'];
    
    ?>
    <p>Inserir conteúdo da aula</p>
    <textarea data-role="textarea" id="conteudo" data-prepend="<span class='mif-leanpub'></span>"><?php echo $conteudo ?></textarea>
    <br>
    <p>Observações</p>
    <textarea data-role="textarea" id="observacoes" data-prepend="<span class='mif-leanpub'></span>"><?php echo $observacao ?></textarea>
  </div>
  <div class="cell-6 p-2">
   <div class="editar_frequencia">
   
        <table class="table striped table-border mt-4" id="tabela-categorias">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle;">
                            #
                        </th>
                        <th rowspan="2" style="vertical-align: middle;">
                            Nome
                        </th>
                        
                         
                        <th style="text-align: center; vertical-align: middle;" colspan="<?php echo $total_tempos ?>">Tempos(s)</th>  
                        <th rowspan="2">
                            Observações
                        </th>                   
                    </tr>
                    <tr>
                        <?php
                                for($t=0;$t<$total_tempos;$t++){
                                ?>
                                <td style="text-align: center; width: 30px;">
                                   <?php echo $separa_tempo[$t]; ?>º
                                </td>
                                <?php
                                }

                                ?>
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
                            <tr  >
                                <td class="py-1" style="width: 50px"><?php echo $ordem ?></td>
                                <td><?php echo $nome ?> </td>
                                
                                <?php
                                for($t=0;$t<$total_tempos;$t++){
                                    $tempo_atual = $separa_tempo[$t];
                                    $lista2 = $db->query("SELECT * FROM cad_frequencia  WHERE id_aluno = '$id' AND data_pt = '$data' AND tempo = '$tempo_atual' AND id_disciplina = '$id_disciplina' ");
                                    $dados2 = $lista2->fetchArray();
                                    $id_frequencia = $dados2['id'];
                                    $valor_frequencia = $dados2['frequencia'];
                                    $classe = ""; 

                                    if( $valor_frequencia == ""){
                                        $valor_frequencia = "P";
                                        $classe = "success";
                                    }else if($valor_frequencia == "P"){
                                        
                                        $classe = "success";
                                    }elseif($valor_frequencia == "F"){
                                        $classe = "alert";
                                    }elseif($valor_frequencia == "J"){
                                        $classe = "warning";
                                    }
                                ?>
                                <td style="text-align: center; width: 30px;">
                                    <button class="button  small cycle freq <?php echo $classe ?>" data-id="<?php echo $id ?>" data-tempo="<?php echo $separa_tempo[$t]; ?>" value="<?php echo $valor_frequencia ?>"><?php echo $valor_frequencia ?></button>
                                </td>
                                <?php
                                }

                                ?>
                                
                                <td><?php echo $obs ?> </td>
                                
                                            
                            </tr>
                            <?php
                                $ordem++;
                                }

                                $db->close();  
                            ?>           
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        
                        <td colspan="3">
                                <div data-role="progress" data-type="buffer" class="mb-4"  id="progress_"></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        
                        <td colspan="3">
                            <button class="button primary" data-id="<?php echo $id_frequencia ?>" id="salvar_frequencia">Salvar frequência e conteudo</button>
                            <button class="button alert" data-id="<?php echo $id_frequencia ?>" id="excluir">Excluir frequência e conteudo</button>
                            
                        </td>
                    </tr>
                </tfoot>
            </table>

      
    
   </div>
  </div>
  
</div>
<?php
}else{
    $lista2 = $db->query("SELECT * FROM cad_frequencia  WHERE id_turma = '$id_turma' AND  data_pt = '$data' AND tempo = '$tempo'  ");
    $dados2 = $lista2->fetchArray();
    $id_professor = $dados2['id_professor'];
    $id_disciplina = $dados2['id_disciplina'];

    $lista = $db->query("SELECT * FROM cad_professor  WHERE id = '$id_professor'");
    $dados = $lista->fetchArray();
    $id = $dados['id'];
    $nome = $dados['nome'];

    $lista = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id_disciplina'");
    $dados = $lista->fetchArray();
    $titulo = $dados['titulo'];

    ?>
    <h6 class="fg-red">Neste dia e horário, esta turma já teve registrada uma frequência pelo(a) professor(a): <?php echo $nome ?> na disciplina de <?php echo $titulo ?>.
    
    <?php
}
?>
<script>
    $(function(){
        $(".freq").click(function(){
            valor = $(this).val();
            texto = $(this).text();

            
           
                if(valor == ""){
                    valor = "P"
                    $(this).val("P"); 
                    $(this).text("P");
                    $(this).addClass("success")
                }else if(valor == "P"){
                    valor = "F"
                    $(this).val("F"); 
                    $(this).text("F");
                    $(this).removeClass("success")
                    $(this).addClass("alert")
                }else if(valor == "F"){
                    valor = "J"
                    $(this).val("J"); 
                    $(this).text("J");
                    $(this).addClass("warning")
                    $(this).removeClass("alert")
                }else if(valor == "J"){
                    valor = "P"
                    $(this).val("P"); 
                    $(this).text("P");
                    $(this).addClass("success")
                    $(this).removeClass("warning")
                }
  
            
        })

        $("#excluir").click(function(e){
            e.preventDefault()
            id = $(this).data("id");
            Metro.dialog.create({
                title: "Confirmar",
                content: "<div>Deseja realmente excluir esta frequência e conteúdo?</div>",
                actions: [
                    {
                        caption: "Sim",
                        cls: "js-dialog-close alert",
                        onclick: function(){
                            $.ajax({
                                method: "POST",
                                url: "admin/lancamentos/frequencia/excluir.php", // Substitua pelo caminho do seu arquivo PHP
                                
                                data: {'id':id  },
                                success: function(response) {
                                    // Manipular a resposta do servidor, se necessário
                                    if(response == 1){
                                        Metro.notify.create("Cadastro excluído com sucesso!", "Sucesso", {cls: "primary"});
                                        
                                        $(".mostra_conteudo").html("")
                                        $(".mostra_chamada").html("")
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

        $("#salvar_frequencia2").click(function(){
            valor = 0;

                        
            $('.freq').each(function(){
                valor = $(this).val();
                texto = $(this).text();

                
                id_turma = "<?php echo $id_turma ?>"
                data = "<?php echo $data ?>"
                tempo = $(this).data("tempo")
                escola = "<?php echo $escola ?>"
                id_professor = $("#professor").val();
                id_disciplina = $("#disciplina").val();
                id_aluno = $(this).data('id');

                conteudo = $("#conteudo").val();
                observacoes = $("#observacoes").val();
                if(conteudo == ""){
                    Metro.dialog.create({
                        title: "Aviso",
                        content: "<div>É necessário inserir o conteúdo desta aula!</div>",
                        closeButton: true
                    });
                }else{

                    $.ajax({
                        method: "POST",
                        url: "admin/lancamentos/frequencia/salva_frequencia.php", // Substitua pelo caminho do seu arquivo PHP
                        
                        data: {'valor':valor,'id_turma':id_turma,'data':data,'tempo':tempo,'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina,'id_aluno':id_aluno,'conteudo':conteudo,'observacoes':observacoes  },
                        success: function(response) {
                            // Manipular a resposta do servidor, se necessário
                            //alert(response)
                        },
                        error: function(error) {
                            // Lidar com erros de requisição
                        
                        }
                    });


               
            }
            }) 
        })

        $("#salvar_frequencia").click(function() {
            var freqElements = $('.freq');
            var totalElements = freqElements.length;
            var currentIndex = 0;
            
                conteudo = $("#conteudo").val();
                    observacoes = $("#observacoes").val();
                if (conteudo == "") {
                        Metro.dialog.create({
                            title: "Aviso",
                            content: "<div>É necessário inserir o conteúdo desta aula!</div>",
                            closeButton: true
                        });
                } else {
                    function salvarProximaFrequencia() {
                        if (currentIndex < totalElements) {
                            var freqElement = freqElements.eq(currentIndex);
                            valor = freqElement.val();
                            texto = freqElement.text();

                            id_turma = "<?php echo $id_turma ?>"
                            data = "<?php echo $data ?>"
                            tempo = freqElement.data("tempo")
                            escola = "<?php echo $escola ?>"
                            id_professor = $("#professor").val();
                            id_disciplina = $("#disciplina").val();
                            id_aluno = freqElement.data('id');

                            conteudo = $("#conteudo").val();
                            observacoes = $("#observacoes").val();
                            
                                $.ajax({
                                    method: "POST",
                                    url: "admin/lancamentos/frequencia/salva_frequencia.php",
                                    data: {'valor':valor, 'id_turma':id_turma, 'data':data, 'tempo':tempo, 'escola':escola, 'id_professor':id_professor, 'id_disciplina':id_disciplina, 'id_aluno':id_aluno, 'conteudo':conteudo, 'observacoes':observacoes},
                                    success: function(response) {
                                        // Manipular a resposta do servidor, se necessário
                                        // alert(response)
                                        progresso_bar = ((currentIndex+1)/totalElements)*100


                                        $("#progress_").attr('data-value', progresso_bar);
                                        if(progresso_bar == 100){
                                            Metro.dialog.create({
                                                title: "Aviso",
                                                content: "<div>Frequência salva com sucesso!</div>",
                                                closeButton: true
                                            });
                                            $(".mostra_conteudo").html("")
                                            $(".mostra_chamada").html("")
                                        }
                                    },
                                    error: function(error) {
                                        // Lidar com erros de requisição
                                    },
                                    complete: function() {
                                        currentIndex++;
                                        // Chama a próxima iteração após 300 milissegundos (meio segundo)
                                        setTimeout(salvarProximaFrequencia, 300);
                                    }
                                });
                            }
                        }
                    

                    // Iniciar o processo chamando a função pela primeira vez
                    salvarProximaFrequencia();
            }
        });

    })
</script>
<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');


$escola = $_POST['escola'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];

$id_turma = $_POST['id_turma'];


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
$etapas = $dados['etapas'];
$media_escola = $dados['media'];
$total_etapas = 0; $divisao = "";
if($etapas == 'Bimestre'){
    $total_etapas = 4;
    $divisao = "º Bim";
}else{
    $total_etapas = 2;
    $divisao = "º Sem";
}



$lista = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id_disciplina'");
$dados = $lista->fetchArray();
$titulo = $dados['titulo'];
$abreviacao = $dados['abreviacao'];

$lista = $db->query("SELECT * FROM cad_professor  WHERE id = '$id_professor'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$nome = $dados['nome'];
$abreviacao = $dados['abreviacao'];

?>

<style>
        #tabela-categorias{
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            
        }
#tabela-categorias  td {
    padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
#tabela-categorias th {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
#tabela-categorias      th {
        background-color: #f2f2f2;
        font-weight: bold;
        
      }
     
#tabela-categorias tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      

       
        table thead {
            background-color: #f1f1f1; /* Cor de fundo do cabeçalho */
            position: sticky;
            top: 0; /* Ajuste conforme necessário para a altura do cabeçalho */
            z-index: 1; /* Garante que o cabeçalho esteja sobre o conteúdo da tabela */
        }
    </style>

<table class="" id="tabela-categorias">
    <thead>
        <tr>
            <th colspan="<?php echo $total_etapas + 5 ?>">
                <?php echo $nome_escola ?><br>
                Professor(a): <?php echo $nome ?><br>
                Média final da disciplina de: <?php echo $titulo ?><br>
                Turma: <?php echo $ano.' '.$turma.' '.$turno ?>
            
            </th>
        </tr>
        <tr>
                <th>
                    #
                </th>
                <th>
                    Aluno(a)
                </th>
               
                        
                <th style="text-align: right; width: 100px">Média</th> 
                <th style="text-align: right; width: 100px">Rec</th> 
                <th style="text-align: right; width: 100px">CC</th> 
                <th style="text-align: right; width: 100px">Média/Final</th> 
                <th style="text-align: right; width: 100px">Faltas</th>                       
            </tr>
    </thead>
    <tbody>
        <?php
                $ordem = 1; $mf = 0;
                $lista = $db->query("SELECT * FROM cad_aluno WHERE id_turma = '$id_turma'  ORDER BY nome ASC");
                while($dados = $lista->fetchArray()){
                    $id = $dados['id'];
                    $nome = $dados['nome'];
                    $obs = $dados['obs'];

                    ?>
                    <tr>
                        <td><?php echo $ordem ?></td>
                        <td><?php echo $nome ?></td>
                        <?php
                        $media_somada = 0;
                            for($i=1;$i<=$total_etapas;$i++){
                                //calcula o total de avaliações realizadas
                                $bimestre = $i.$divisao;
                                $query = "SELECT COUNT(*) as id FROM cad_avaliacao WHERE id_escola = '$escola' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma'  AND etapa_av = '$bimestre' ";
                                    $result = $db->query($query);

                                    $row = $result->fetchArray(SQLITE3_ASSOC);
                                    $total = $row['id'];

                                //verifica as avaliações realizadas pelo aluno 
                                $media = 0; $notas = 0;  $nota_ = "";
                                $lista2 = $db->query("SELECT * FROM cad_avaliacao WHERE id_turma = '$id_turma' AND id_disciplina = '$id_disciplina' AND etapa_av = '$bimestre'  ");
                                while($dados2 = $lista2->fetchArray()){
                                    $id_avaliacao = $dados2['id'];                                
                                    $numero_av = $dados2['numero_av'];

                                    $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND id_av = '$numero_av' AND etapa = '$bimestre' AND id_disciplina = '$id_disciplina' AND id_avaliacao = '$id_avaliacao'  ");
                                    $dados3 = $lista3->fetchArray();
                                    $id_nota = $dados3['id'];
                                    $nota = $dados3['nota'];
                                    if($nota != ""){
                                        $notas = $notas + $nota;
                                        $nota = number_format($nota, 1, ',', '.');
                                    }    



                                }
                                if($notas> 0){
                                    $media = $notas / $total;
                                    $media_bim =  number_format($media, 1, ',', '.');
                                }else{
                                    $media = 0;
                                    $media_bim =  number_format($media, 1, ',', '.');
                                }
                                 $media_somada = $media +$media_somada;  

                                ?>
                                
                                <?php

                            }

                            $media_geral = 0;
                            if($media_somada > 0){
                                $media_geral = $media_somada / $total_etapas;
                                $media_geral_convertida =  number_format($media_geral, 1, ',', '.');
                            }else{
                                $media_geral = 0;
                                $media_geral_convertida =  number_format($media_geral, 1, ',', '.');
                            }

                        ?>
                        <td style="text-align: right; " >
                        <input type="hidden" class="nota-input" data-id="<?php echo $id ?>" value="<?php echo $media_geral_convertida ?>">
                        <?php echo $media_geral_convertida ?></td>

                        <?php
                         $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND  etapa = 'Recuperação' AND id_disciplina = '$id_disciplina'   ");
                         $dados3 = $lista3->fetchArray();
                         $id_nota = $dados3['id'];
                         $nota = $dados3['nota'];
                         if($nota != ""){
                             $notas = $notas + $nota;
                             $nota_ = number_format($nota, 1, ',', '.');
                         }

                        ?>
                        
                        <td style="text-align: right; width: 60px; ">
                            <input type="text" style="text-align: right;width: 60px; height: 35px; font-size: 18px; padding: 3px;" class="id_aluno nota-input" data-clear-button="false" data-id="<?php echo $id ?>"   value="<?php echo $nota_ ?>"   placeholder="00,0" >
                        </td>

                        <?php
                         $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND  etapa = 'Conselho' AND id_disciplina = '$id_disciplina'   ");
                         $dados3 = $lista3->fetchArray();
                         $id_nota = $dados3['id'];
                         $nota_conselho = $dados3['nota'];
                         if($nota_conselho != ""){                            
                             $nota_conselho = number_format($nota_conselho, 1, ',', '.');
                         }

                        ?>

                        
                            <td style="text-align: right; width: 60px; ">
                                <input type="text" style="text-align: right;width: 60px; height: 35px; font-size: 18px; padding: 3px;" class="id_aluno2 nota-input2" data-clear-button="false" data-id="<?php echo $id ?>"   value="<?php echo $nota_conselho ?>"   placeholder="00,0" >
                            </td>

                        

                        <td id="media-<?php echo $id ?>" style="text-align: right; font-size: 18px;">
                        <?php
                       if($nota_conselho != "" || $nota_conselho > 0){
                        $media_com_recuperacao = $nota_conselho;
                        echo $media_com_recuperacao;
                       }elseif($media_geral < $media_escola){
                            $media_com_recuperacao = ($media_geral + $nota)/2;
                            echo number_format($media_com_recuperacao, 1, ',', '.');
                        }else{
                            $media_com_recuperacao = $media_geral;
                            echo number_format($media_com_recuperacao, 1, ',', '.');
                        }

                        ?>                        
                    
                        </td>
                        <?php
                            $query = "SELECT COUNT(*) as id FROM cad_frequencia WHERE id_aluno = '$id' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma'  AND frequencia = 'F'  ";
                            $result = $db->query($query);
                            
                            $row = $result->fetchArray(SQLITE3_ASSOC);
                            $total_faltas = $row['id'];

                            ?>
                            
                            <td style="text-align: right; width: 100px"><?php echo $total_faltas ?></td> 
                    </tr>

                    <?php
                $ordem++;
                }
        ?>
        <tr>
            <td colspan="<?php echo $total_etapas + 5 ?>">
                <p>Para salvar a nota basta digitar o valor em cada caixa de texto e clicar ENTER.</p>
            
            </td>
        </tr>
    </tbody>
    <tfoot>
            <tr>
                
                <th colspan="<?php echo 6+$total_etapas ?>">
                <br><br>
                    <div class="row">
                       <div class="cell-6 p-2">
                        <br>
                        
                        Professor(a): <?php echo $nome ?>
                       </div>
                       <div class="cell-6 p-2 " >
                       <center>
                        <br> Em 
                        <?php 
                        setlocale(LC_TIME, 'pt_BR'); // Configura o locale para português do Brasil

                        $dataFormatada = strftime('%d de %B de %Y');
                        echo $dataFormatada;
                        
                        ?>
                        </center>
                       </div>
                    </div>
                </th>
                
                
            </tr>
        </tfoot>


</table>

<script>
    $(function(){
        $('.id_aluno').mask('00,0', { reverse: true });
        $('.id_aluno2').mask('00,0', { reverse: true });
        $('.id_aluno').keypress(function(e) {
            if (e.which === 13) { // 13 é o código da tecla Enter
                e.preventDefault();

                // Obter valores relevantes
                var id_aluno = $(this).data('id');
                
                var valor = $(this).val();
               
                var id_disciplina = "<?php echo $id_disciplina ?>"
                
                valor_nota =  valor.replace(',', '.');
                if(valor_nota > 10){
                    Metro.dialog.create({
                        title: "Aviso",
                        content: "<div>O valor da nota não poderá ser maior que 10,0!</div>",
                        closeButton: true
                    });
                }else{

                
                    // Fazer a chamada AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'admin/lancamentos/aparatas/salva_recuperacao.php',
                        data: {
                            id_aluno: id_aluno,
                           
                            valor: valor,
                           
                            id_disciplina: id_disciplina
                        },
                        success: function(response) {
                            // Lidar com a resposta do servidor, se necessário
                            //alert(response)
                            Metro.notify.create("Nota atualizada com sucesso!", "Sucesso", {cls: "success"});
                        },
                        error: function(error) {
                            console.error('Erro na requisição AJAX:', error);
                        }
                    });
                }
            }
        });

        $('.id_aluno2').keypress(function(e) {
            if (e.which === 13) { // 13 é o código da tecla Enter
                e.preventDefault();

                // Obter valores relevantes
                var id_aluno = $(this).data('id');
                
                var valor = $(this).val();
               
                var id_disciplina = "<?php echo $id_disciplina ?>"
                
                valor_nota =  valor.replace(',', '.');
                if(valor_nota > 10){
                    Metro.dialog.create({
                        title: "Aviso",
                        content: "<div>O valor da nota não poderá ser maior que 10,0!</div>",
                        closeButton: true
                    });
                }else{

                
                    // Fazer a chamada AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'admin/lancamentos/aparatas/salva_conselho.php',
                        data: {
                            id_aluno: id_aluno,
                           
                            valor: valor,
                           
                            id_disciplina: id_disciplina
                        },
                        success: function(response) {
                            // Lidar com a resposta do servidor, se necessário
                            //alert(response)
                            Metro.notify.create("Nota atualizada com sucesso!", "Sucesso", {cls: "success"});
                        },
                        error: function(error) {
                            console.error('Erro na requisição AJAX:', error);
                        }
                    });
                }
            }
        });

        

         //rotina abaixo para calcular o valor da média de forma automatica quando alterar os valore dos inputs das notas
         $('.nota-input').on('input', function () {
            // Obter valores relevantes
            var id = $(this).data('id');
            var total = 2;
            var media_escola = <?php echo $media_escola ?>;

            // Calcular nova média
            var novaMedia = calcularNovaMedia(id, total);

            cor = ""
            media = novaMedia.replace(',', '.');
            if(media < media_escola){
                cor = "fg-red"
            }else{
                cor = "fg-blue"
            }           

            // Atualizar valor da célula de média
            $('#media-' + id).html('<span class="'+cor+'">'+novaMedia+'</span>');
        });
        $('.nota-input2').on('input', function () {
            // Obter valores relevantes
            var id = $(this).data('id');
            var valor_conselho = $(this).val()          

            // Atualizar valor da célula de média
            $('#media-' + id).html(valor_conselho);
        });

        // Função para calcular nova média
        function calcularNovaMedia(id, total) {
            var notas = 0;

            // Iterar sobre os inputs da linha
            $('.nota-input[data-id="' + id + '"]').each(function () {
                var nota = parseFloat($(this).val().replace(',', '.')) || 0;
                notas += nota;
            });

            // Calcular a nova média
            var novaMedia = notas / total;

            // Formatar e retornar a nova média
            return novaMedia.toFixed(1).replace('.', ',');
        }




    })
</script>

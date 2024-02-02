<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$etapa = $_POST['etapa'];
$divisao = $_POST['divisao'];
$etapa = $etapa.$divisao;


$escola = $_POST['escola'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];

$id_turma = $_POST['id_turma'];

$query = "SELECT COUNT(*) as id FROM cad_avaliacao WHERE id_escola = '$escola' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma'  AND etapa_av = '$etapa' ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['id'];

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

//verificar o período de inicio e termino do período(bimestre ou semestre)
$lista = $db->query("SELECT * FROM cad_periodo  WHERE id_escola = '$escola' AND etapa = '$etapa'");
$dados = $lista->fetchArray();
$inicio = $dados['inicio_sistema'];
$termino = $dados['termino_sistema'];





$lista = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id_disciplina'");
$dados = $lista->fetchArray();
$titulo = $dados['titulo'];
$abreviacao = $dados['abreviacao'];

$lista = $db->query("SELECT * FROM cad_professor  WHERE id = '$id_professor'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$nome = $dados['nome'];
$abreviacao = $dados['abreviacao'];


if($total == 0){
    echo '<br><br> <h3 class="fg-red">Ainda não foi criada nenhuma AV neste '.$etapas.'</h3>';
}else{
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
    <div class="p-4">
        
    <table class=""  id="tabela-categorias">
        <thead>
            <tr>
                <th colspan="4">
                <?php echo $nome_escola ?><br>
                Professor(a): <?php echo $nome ?><br>
                Aparata final da disciplina: <?php echo $titulo.' - '.$etapa ?><br>
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
                <th style="text-align: right; width: 100px">Faltas</th>                   
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
                            <?php
                            $media = 0; $notas = 0;
                             $lista2 = $db->query("SELECT * FROM cad_avaliacao WHERE id_turma = '$id_turma' AND id_disciplina = '$id_disciplina' AND etapa_av = '$etapa'  ");
                             while($dados2 = $lista2->fetchArray()){
                                $id_avaliacao = $dados2['id'];                                
                                $numero_av = $dados2['numero_av'];

                                $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND id_av = '$numero_av' AND etapa = '$etapa' AND id_disciplina = '$id_disciplina' AND id_avaliacao = '$id_avaliacao'  ");
                                    $dados3 = $lista3->fetchArray();
                                    $id_nota = $dados3['id'];
                                    $nota = $dados3['nota'];
                                    if($nota != ""){
                                        $notas = $notas + $nota;
                                        $nota = number_format($nota, 1, ',', '.');
                                    }
                                    
                                   
                                ?>
                                
                                <?php

                             }
                             $media = $notas / $total;
                             $cor="";
                             if($media < $media_escola){
                                $cor = "fg-red";
                             }else{
                                $cor = "fg-blue";
                             }
                             if($notas != 0){
                                 $media =  number_format($media, 1, ',', '.');
                                 
                             }else{
                                 $media = "0,0";
                             }
                            
                            ?>
                            
                            <td id="media-<?php echo $id ?>" style="text-align: right; font-size: 18px;">
                                <?php 
                                
                                echo "<span class='".$cor."'>".$media."</span>";
                                ?>
                               
                            </td>
                            <?php
                            $query = "SELECT COUNT(*) as id FROM cad_frequencia WHERE id_aluno = '$id' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma'  AND frequencia = 'F' AND data_sistema > '$inicio' AND data_sistema < '$termino' ";
                            $result = $db->query($query);
                            
                            $row = $result->fetchArray(SQLITE3_ASSOC);
                            $total_faltas = $row['id'];

                            ?>
                            <td style="text-align: right; width: 100px"><?php echo $total_faltas ?></td>  
                            
                                        
                        </tr>
                        <?php
                            $ordem++;
                            }

                            $db->close();
                            ?>
        </tbody>
        <tfoot>
            <tr>
                
                <th colspan="<?php echo 4 ?>">
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
    </div>
    <button class="shortcut success imprimir m-2" >
                <span class="badge"></span>
                <span class="caption">Imprimir</span>
                <span class="mif-printer icon"></span>
    </button>

    <?php
}

?>

<script>
    $(function(){
        $('.id_aluno').mask('00,0', { reverse: true });

        $('.id_aluno').keypress(function(e) {
            if (e.which === 13) { // 13 é o código da tecla Enter
                e.preventDefault();

                // Obter valores relevantes
                var id_aluno = $(this).data('id');
                var id_av = $(this).data('av');
                var id_avaliacao = $(this).data('idavaliacao');
                var valor = $(this).val();
                var bimestre = "<?php echo $etapa ?>"
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
                        url: 'admin/lancamentos/notas/salva_nota.php',
                        data: {
                            id_aluno: id_aluno,
                            id_av: id_av,
                            valor: valor,
                            bimestre: bimestre,
                            id_avaliacao: id_avaliacao,
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

        $('#salvar_todos').on('click', function() {
        // Iterar sobre todos os inputs com a classe "id_aluno"
            $('.id_aluno').each(function() {
                var id_aluno = $(this).data('id');
                var id_av = $(this).data('av');
                var id_avaliacao = $(this).data('idavaliacao');
                var valor = $(this).val();
                var bimestre = "<?php echo $etapa ?>"
                var id_disciplina = "<?php echo $id_disciplina ?>"

                // Fazer a chamada AJAX para cada input
                 // Fazer a chamada AJAX
                 $.ajax({
                    type: 'POST',
                    url: 'admin/lancamentos/notas/salva_nota.php',
                    data: {
                        id_aluno: id_aluno,
                        id_av: id_av,
                        valor: valor,
                        bimestre: bimestre,
                        id_avaliacao: id_avaliacao,
                        id_disciplina: id_disciplina
                    },
                    success: function(response) {
                        // Lidar com a resposta do servidor, se necessário
                        //alert(response)
                    },
                    error: function(error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });

                
            });
            Metro.notify.create("Notas atualizadas com sucesso!", "Sucesso", {cls: "success"});
            
        });
      
        //rotina abaixo para calcular o valor da média de forma automatica quando alterar os valore dos inputs das notas
        $('.nota-input').on('input', function () {
            // Obter valores relevantes
            var id = $(this).data('id');
            var total = <?php echo $total ?>;
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

        $('.imprimir').click(function(){
            $('#tabela-categorias').print({
                iframe : false,
                mediaPrint : false,
                noPrintSelector : ".avoid-this",
                //add título 
                prepend : "",
                append : ""
            });
        }) 

    })
</script>


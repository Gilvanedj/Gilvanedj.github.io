<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id = $_POST['id_turma'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];
$mes = $_POST['mes'];
$ano_letivo = $_POST['ano'];
$lista = $db->query("SELECT * FROM cad_turma  WHERE id = '$id'");
$dados = $lista->fetchArray();
$id_turma = $dados['id'];
$turno = $dados['turno'];
$ano = $dados['ano'];
$turma = $dados['turma'];
$escola = $dados['escola'];

$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$escola'");
$dados = $lista->fetchArray();
$nome_escola = $dados['nome'];
$etapas = $dados['etapas'];
$media = $dados['media'];

$lista = $db->query("SELECT * FROM cad_professor  WHERE id = '$id_professor'");
$dados = $lista->fetchArray();
$nome_professor = $dados['nome'];

$lista = $db->query("SELECT * FROM cad_area_conhecimento  WHERE id = '$id_disciplina'");
$dados = $lista->fetchArray();
$nome_disciplina = $dados['titulo'];

$mes_extenso = "";
if($mes == 1){
    $mes_extenso = "Janeiro";
}elseif($mes == 2){
    $mes_extenso = "Fevereiro";
}elseif($mes == 3){
    $mes_extenso = "Março";
}elseif($mes == 4){
    $mes_extenso = "Abril";
}elseif($mes == 5){
    $mes_extenso = "Maio";
}elseif($mes == 6){
    $mes_extenso = "Junho";
}elseif($mes == 7){
    $mes_extenso = "Julho";
}elseif($mes == 8){
    $mes_extenso = "Agosto";
}elseif($mes == 9){
    $mes_extenso = "Setembro";
}elseif($mes == 10){
    $mes_extenso = "Outubro";
}elseif($mes == 11){
    $mes_extenso = "Novembro";
}elseif($mes == 12){
    $mes_extenso = "Dezembro";
}

$query = "SELECT COUNT(*) as id FROM cad_conteudo WHERE id_turma = '$id' AND mes = '$mes' AND id_disciplina = '$id_disciplina'  ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total_aulas = $row['id'];




// Calcular a quantidade de dias no mês
$quantidadeDias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano_letivo);  

$query = "SELECT COUNT(*) as id FROM cad_aluno WHERE id_turma = '$id_turma' ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total_alunos = $row['id'];


?>

<style>
#tabela-categorias{
    width: 100%;
    
    border-collapse: collapse;
    font-family: Arial, sans-serif;
            
}
#tabela-categorias  td {
    border: 1px solid #ddd;
    padding: 1px;
    font-size: 12px;   
        border-bottom: 1px solid #ddd;
      }
#tabela-categorias th {
        padding: 1px;
        font-size: 12px;
        
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

<div>
    <table class=""  id="tabela-categorias">
        <thead>
            <tr>
                <th colspan="<?php echo $quantidadeDias+3 ?>" style="text-align: left;">
                <?php echo $nome_escola ?> <br>
                Professor(a): <?php echo $nome_professor ?><br>
                Componenete curricular: <?php echo $nome_disciplina ?> |  Turma: <?php echo $ano.' '.$turma.' '.$turno ?><br><br>
                </th>
            </tr>
            <tr>
                <th rowspan="2" style="vertical-align: middle;">#</th>
                <th rowspan="2" style="vertical-align: middle;">Aluno(a)</th>
                <th colspan="<?php echo $total_aulas ?>" class="border bg-yellow ">Dias com aulas do Mês de <?php echo $mes_extenso.' de '.$ano_letivo ?></th>
                
                
                <th rowspan="2" style="vertical-align: middle;">TF</th>
                
            </tr>
            <tr>
             <?php 
               
                    $lista = $db->query("SELECT * FROM cad_conteudo WHERE id_turma = '$id_turma' AND id_disciplina = '$id_disciplina' AND mes = '$mes' AND ano = '$ano_letivo'  ORDER BY dia ASC");
                    while($dados = $lista->fetchArray()){
                        $dia = $dados['dia'];
                        ?>
                        <th class="bg-yellow"><?php echo $dia ?></th>
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
                $id_aluno = $dados['id'];
                $nome_aluno = $dados['nome'];

                ?>
                <tr>
                    <td><?php echo $ordem; ?></td>
                    <td style="width: 200px;"><?php echo $nome_aluno; ?></td>
                    <?php
                    $total_faltas = 0;
                    $lista5 = $db->query("SELECT * FROM cad_conteudo WHERE id_turma = '$id_turma' AND id_disciplina = '$id_disciplina' AND mes = '$mes' AND ano = '$ano_letivo'  ORDER BY dia ASC");
                    while($dados5 = $lista5->fetchArray()){
                        $i = $dados5['dia'];

                        $lista2 = $db->query("SELECT * FROM cad_frequencia WHERE id_aluno = '$id_aluno' AND dia = '$i' AND mes = '$mes' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma' AND ano = '$ano_letivo' COLLATE BINARY");

                        $dados2 = $lista2->fetchArray();
                        $id_frequencia = $dados2['id'];
                        $valor_frequencia = $dados2['frequencia'];
                        $classe="";
                        if($valor_frequencia == "F"){
                            $classe = "fg-red";
                            $total_faltas++;
                        }else{
                            $classe = "fg-blue";
                        }
                        ?>
                        <td style="text-align: center; font-weight: bold; " class="<?php echo $classe ?>"><?php echo $valor_frequencia ?></td>
                        <?php
                    }

                    ?>
                    <td style="text-align: center; "><?php echo $total_faltas ?></td>

                    
                    <?php
                    /*
                    $lista2 = $db->query("SELECT * FROM cad_conteudo WHERE   mes = '$mes' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma' AND ano = '$ano_letivo' ");
                    while($dados2 = $lista2->fetchArray()){
                        $id_conteudo = $dados2['id'];

                        ?>
                            <td><?php echo $id_conteudo ?></td>
                            <td></td>
                        <?php
                    }

                        */
                    ?>

                    
                </tr>
                

                <?php
                $ordem++;
            }
            ?>

            <tr>
                <td colspan="<?php echo $total_aulas+3 ?>" style="text-align: left;">
                <p style="margin-top: 10px;font-weight: bold;">CONTEÚDO MINISTRADO</p>
                <table>
                    <tr>
                        <th class="p-2">Data</th>
                        <th class="p-2">Conteúdo</th>
                        <th class="p-2">Observações</th>
                    </tr>
                    
               
                <?php
                    $lista2 = $db->query("SELECT * FROM cad_conteudo WHERE   mes = '$mes' AND id_disciplina = '$id_disciplina' AND id_turma = '$id_turma' AND ano = '$ano_letivo' ");
                        while($dados2 = $lista2->fetchArray()){
                        $id_conteudo = $dados2['id'];
                        $conteudo = $dados2['conteudo'];
                        $observacao = $dados2['observacao'];
                        $data_pt = $dados2['data_pt'];
                        ?>
                        <tr>
                            <td class="p-1"><?php echo $data_pt ?></td>
                            <td class="p-1"><?php echo $conteudo ?></td>
                            <td class="p-1"><?php echo $observacao ?></td>
                        </tr>

                        <?php
                        }
                ?>


                </td>
            </tr>
            </table>
        </tbody>


    </table>
    <br>
    <button class="shortcut success imprimir m-2" >
                <span class="badge"></span>
                <span class="caption">Imprimir</span>
                <span class="mif-printer icon"></span>
    </button>                    
</div>

<script>
    $(function(){
        
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
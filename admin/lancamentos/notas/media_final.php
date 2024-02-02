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
        table thead {
            background-color: #f1f1f1; /* Cor de fundo do cabeçalho */
            position: sticky;
            top: 0; /* Ajuste conforme necessário para a altura do cabeçalho */
            z-index: 1; /* Garante que o cabeçalho esteja sobre o conteúdo da tabela */
        }
</style>

<table class="table striped table-border mt-4" id="tabela-categorias">
    <thead>
        <tr>
            <th colspan="<?php echo $total_etapas + 3 ?>">
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
                <?php
                for($i=1;$i<=$total_etapas;$i++){
                    ?>
                    <th style="text-align: center; width: 90px">
                      <button class="button primary">
                        <?php echo $i.$divisao ?>
                        
                        </button>
                    </th>
                    <?php
                }

                ?>
                        
                <th style="text-align: right; width: 100px">Média</th>                     
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
                                $media = 0; $notas = 0;  
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
                                <td style="text-align: center; width: 90px"> 
                                    <?php echo $media_bim ?>                               
                                </td>
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
                        <td style="text-align: right; "><?php echo $media_geral_convertida ?></td>
                    </tr>

                    <?php
                $ordem++;
                }
        ?>
    </tbody>

</table>

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
    padding: 3px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
#tabela-categorias th {
        padding: 2px;
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
<br>
<table class="" id="tabela-categorias">
    <thead>
        <tr>
            <th colspan="<?php echo $total_etapas + 7 ?>">
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
                      
                        <?php echo $i.$divisao ?>
                     
                    </th>
                    <?php
                }

                ?>
                        
                <th style="text-align: center; width:50px;">M</th> 
                <th style="text-align: center; width:50px;">Rec</th> 
                <th style="text-align: center; width: 50px">CC</th>
                <th style="text-align: center; width:50px;">M/F</th>
                <th style="text-align: center; width:50px; padding-right: 10px">F</th>                       
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
                                <td style="text-align: center; "> 
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
                        
                        <td style="text-align: center; "><?php echo $media_geral_convertida ?></td>
                        <?php
                        $nota_ = "";
                         $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND  etapa = 'Recuperação' AND id_disciplina = '$id_disciplina'   ");
                         $dados3 = $lista3->fetchArray();
                         $id_nota = $dados3['id'];
                         $nota = $dados3['nota'];
                         if($nota != ""){
                             $notas = $notas + $nota;
                             $nota_ = number_format($nota, 1, ',', '.');
                         }

                        ?>
                        
                        <td style="text-align: center; "><?php echo $nota_ ?></td>
                        <?php
                         $lista3 = $db->query("SELECT * FROM cad_nota WHERE id_aluno = '$id' AND  etapa = 'Conselho' AND id_disciplina = '$id_disciplina'   ");
                         $dados3 = $lista3->fetchArray();
                         $id_nota = $dados3['id'];
                         $nota_conselho = $dados3['nota'];
                         if($nota_conselho != ""){                            
                             $nota_conselho = number_format($nota_conselho, 1, ',', '.');
                         }

                        ?>

                        
                            <td style="text-align: center; ">
                                <?php echo $nota_conselho ?>
                            </td>
                      
                        <td  style="text-align: center; ">
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
                            <td style="text-align: center; padding-right: 10px"><?php echo $total_faltas ?></td> 
                    </tr>

                    <?php
                $ordem++;
                }
        ?>
    </tbody>

    <tfoot>
            <tr>
                
                <th colspan="<?php echo 7+$total_etapas ?>">
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

<br>
<button class="shortcut success imprimir m-2" >
                <span class="badge"></span>
                <span class="caption">Imprimir</span>
                <span class="mif-printer icon"></span>
    </button>

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



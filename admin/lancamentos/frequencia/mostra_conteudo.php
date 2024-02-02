<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id_turma = $_POST['id_turma'];
$data = $_POST['data'];
$tempo = $_POST['tempo'];
$escola = $_POST['escola'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];



?>

<select data-role="select" id="seleciona_conteudo">
    
   
    <?php
       $mes = "";
       for ($i = 1; $i < 13; $i++) {
           switch ($i) {
               case 1:
                   $mes = "Janeiro";
                   break;
               case 2:
                   $mes = "Fevereiro";
                   break;
               case 3:
                   $mes = "Março";
                   break;
               case 4:
                   $mes = "Abril";
                   break;
               case 5:
                   $mes = "Maio";
                   break;
               case 6:
                   $mes = "Junho";
                   break;
               case 7:
                   $mes = "Julho";
                   break;
               case 8:
                   $mes = "Agosto";
                   break;
               case 9:
                   $mes = "Setembro";
                   break;
               case 10:
                   $mes = "Outubro";
                   break;
               case 11:
                   $mes = "Novembro";
                   break;
               case 12:
                   $mes = "Dezembro";
                   break;
               default:
                   $mes = "Mês inválido";             

           }
           ?>
            <optgroup label="<?php echo $mes ?>">
            <?php
                $lista = $db->query("SELECT * FROM cad_conteudo  WHERE id_turma = '$id_turma' AND id_professor = '$id_professor' AND id_disciplina = '$id_disciplina' AND mes = '$i' ORDER BY data_sistema ASC ");
                    while($dados = $lista->fetchArray()){
                        $id_conteudo = $dados['id'];
                        $conteudo = $dados['conteudo'];
                        $mes = $dados['mes'];
                        $dia = $dados['dia'];
                        $data_pt = $dados['data'];
                        $tempo_conteudo = $dados['tempo'];
                       
                        $selecionado="";
                        if($data_pt == $data AND $tempo = $tempo_conteudo){
                            $selecionado = "selected";
                        }


            ?>
                 <option  value="<?php echo $id_conteudo ?>" selected="selected"><?php echo $dia.'/'.$mes.' - '. $conteudo.' ['.$tempo_conteudo.' Tempo]' ?></option>                       
            <?php
                }  
            ?>
               
            </optgroup>
                
       <?php

        }

             

        ?> 
</select>

<script>
$(function(){
    $("#seleciona_conteudo").change(function(){
        id = $(this).val();
       
        $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/frequencia/lanca_frequencia.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_dia':id  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".mostra_chamada").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
    })

})
</script>

<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id = $_GET['id'];

?>
<select id="turma" data-role="select">
    <option value="">Selecione uma turma...</option>
        <?php
        $lista = $db->query("SELECT * FROM cad_turma WHERE escola = '$id' ORDER BY turno,ano,turma ASC
        ");
                while($dados = $lista->fetchArray()){
                    $id_turma = $dados['id'];
                    $ano = $dados['ano'];
                    $turma = $dados['turma'];
                    $turno = $dados['turno'];
                    ?>
                        <option value="<?php echo $id_turma ?>"><?php echo $ano.' '.$turma.' '.$turno ?></option>
                    <?php

                }
                $db->close();
        ?>
</select>

<script>
    $(function(){
        $("#turma").change(function(){
            id = $(this).val()   
             
            $(".tabela").load("admin/alunos/tabela.php?id="+id)

        })
    })
</script>
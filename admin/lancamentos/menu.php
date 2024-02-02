<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

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

<div style="text-align: center;">
    <br>
    <h5>Turma: <?php echo $ano.' '.$turma.' '.$turno ?></h5>
    <button class="shortcut primary frequencia botao">
        <span class="badge"></span>
        <span class="caption">Frequência</span>
        <span class="mif-list icon"></span>
    </button>
    <button class="shortcut primary imprimir_frequencia botao">
        <span class="badge"></span>
        <span class="caption">Imprimir</span>
        <span class="mif-printer icon"></span>
    </button>
    <button class="shortcut primary notas botao">
        <span class="badge"></span>
        <span class="caption">Notas</span>
        <span class="mif-list-numbered icon"></span>
    </button>
    <button class="shortcut primary aparatas botao">
        <span class="badge"></span>
        <span class="caption">Aparatas</span>
        <span class="mif-clipboard icon"></span>
    </button>

</div>

<div class="mostra_disc"></div>

<script>
    $(function(){
        id_professor = "<?php echo $id_professor ?>"
        $(".frequencia").click(function(){
            troca_cor(this);
            $(".mostra_disc").load("admin/lancamentos/frequencia/frequencia.php?id=<?php echo $id ?>&&id_professor="+id_professor)
        })
        $(".notas").click(function(){
            troca_cor(this);
            id_professor = $("#professor").val()
            $(".mostra_disc").load("admin/lancamentos/notas/verifica_disciplina.php?id=<?php echo $id ?>&&id_professor="+id_professor)
        })
        $(".aparatas").click(function(){
            troca_cor(this);
            id_professor = $("#professor").val()
            $(".mostra_disc").load("admin/lancamentos/aparatas/verifica_disciplina.php?id=<?php echo $id ?>&&id_professor="+id_professor)
        })
        $(".imprimir_frequencia").click(function(){
            troca_cor(this);
            id_professor = $("#professor").val()
            $(".mostra_disc").load("admin/lancamentos/imprimir/verifica_disciplina.php?id=<?php echo $id ?>&&id_professor="+id_professor)
        })

        function troca_cor(botao){
            $(".botao").removeClass("success")
            $(".botao").addClass("primary")

            $(botao).removeClass("primary")
            $(botao).addClass("success")
        }
    })
</script>
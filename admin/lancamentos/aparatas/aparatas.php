<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id = $_POST['id_turma'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];
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
$etapas = $dados['etapas'];
$media = $dados['media'];
$total_etapas = 0; $divisao = "";
if($etapas == 'Bimestre'){
    $total_etapas = 4;
    $divisao = "º Bim";
}else{
    $total_etapas = 2;
    $divisao = "º Sem";
}


?>


   <div>
        
        <?php 
        for($i=1;$i<=$total_etapas;$i++){
           
            $etapa = $i.$divisao;
            $query = "SELECT COUNT(*) as id FROM cad_avaliacao WHERE id_escola = '$escola' AND id_disciplina = '$id_disciplina' AND id_turma = '$id'  AND etapa_av = '$etapa' ";
                $result = $db->query($query);

                $row = $result->fetchArray(SQLITE3_ASSOC);
                $total = $row['id'];

            ?>
            <button class="shortcut info bim" data-id="<?php echo $i ?>">
                <span class="badge"><?php echo $total ?></span>
                <span class="caption"><?php echo $i.$divisao ?></span>
                <span class="mif-table icon"></span>
            </button>
            <?php
        }

        ?>
        <button class="shortcut alert recuperacao" >
                <span class="badge"></span>
                <span class="caption">Recuperação</span>
                <span class="mif-table icon"></span>
        </button>
        <button class="shortcut success final" >
                <span class="badge"></span>
                <span class="caption">Final</span>
                <span class="mif-table icon"></span>
        </button>
        
   </div>

   <div class="mostra_tabela"></div>
</div>


<script>
    $(function(){
        $(".criar_av").click(function(){
            Metro.dialog.open('#criar_av')
        })

       
        $(".bim").click(function(){
            etapa = $(this).data('id');
            id_turma = "<?php echo $id ?>" 
            
            escola = $("#escola").val();
            id_professor = $("#professor").val();
            id_disciplina = $("#disciplina").val();
            divisao = "<?php echo $divisao ?>"
            $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/aparatas/mostra_tabela.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_turma':id_turma, 'etapa':etapa,'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina,'divisao':divisao  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".mostra_tabela").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });

            
        })

        $(".final").click(function(){
            
            id_turma = "<?php echo $id ?>" 
            
            escola = $("#escola").val();
            id_professor = $("#professor").val();
            id_disciplina = $("#disciplina").val();
            divisao = "<?php echo $divisao ?>"
            $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/aparatas/media_final.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_turma':id_turma, 'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina,'divisao':divisao  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".mostra_tabela").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
        })
        $(".recuperacao").click(function(){
            
            id_turma = "<?php echo $id ?>" 
            
            escola = $("#escola").val();
            id_professor = $("#professor").val();
            id_disciplina = $("#disciplina").val();
            divisao = "<?php echo $divisao ?>"
            $.ajax({
                    method: "POST",
                    url: "admin/lancamentos/aparatas/recuperacao_final.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'id_turma':id_turma, 'escola':escola,'id_professor':id_professor,'id_disciplina':id_disciplina,'divisao':divisao  },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        $(".mostra_tabela").html(response)
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });
        })

    })
</script>


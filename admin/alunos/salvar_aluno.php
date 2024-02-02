<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
$escola = $_POST['escola'];
$turma = $_POST['turma'];
$alunos = $_POST['alunos'];


$separa = explode(';',$alunos);

$conta = count($separa);
for($i=0;$i<$conta;$i++){
    if($separa[$i] != ''){
        $nome_aluno = $separa[$i];
        $insere = $db->query("INSERT INTO cad_aluno ( nome, id_escola, id_turma)"
    . "VALUES ('$nome_aluno','$escola','$turma')");
    }

   
}
echo 1;

$db->close();

?>
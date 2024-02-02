<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
$id = $_POST['id'];
$nome = $_POST['nome'];
$turma = $_POST['turma'];
$obs = $_POST['obs'];

   
    $insere = $db->query("UPDATE cad_aluno SET nome='$nome', id_turma='$turma',obs='$obs'  WHERE id = '$id'"); 

    echo '1';

/*

*/
?>
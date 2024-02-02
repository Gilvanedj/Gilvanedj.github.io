<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');
session_start(); 
  

$id = $_POST['id'];

$lista2 = $db->query("SELECT * FROM cad_frequencia  WHERE id = '$id'  ");
$dados2 = $lista2->fetchArray();
$id_turma = $dados2['id_turma'];
$data_pt = $dados2['data_pt'];
$tempo = $dados2['tempo'];

$exclui = $db->query("DELETE FROM cad_frequencia WHERE id_turma = '$id_turma' AND data_pt = '$data_pt' AND tempo = '$tempo' ");

$exclui = $db->query("DELETE FROM cad_conteudo WHERE id_turma = '$id_turma' AND data_pt = '$data_pt' AND tempo = '$tempo' ");

echo 1;
$db->close();
?>
<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
session_start(); 
  

$id = $_POST['id'];


$exclui = $db->query("DELETE FROM cad_aluno WHERE id = '$id'");

echo 1;
$db->close();
?>
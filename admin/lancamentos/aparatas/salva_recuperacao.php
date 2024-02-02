<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$id_aluno = $_POST['id_aluno'];

$id_disciplina = $_POST['id_disciplina'];
$nota = $_POST['valor'];
$nota = str_replace(",", ".", $nota);

$query = "SELECT COUNT(*) as id FROM cad_nota WHERE id_aluno = '$id_aluno'  AND etapa = 'Recuperação' AND id_disciplina = '$id_disciplina'   ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['id'];

if($total == 0){
    $insere = $db->query("INSERT INTO cad_nota ( id_aluno,nota,etapa,id_disciplina)"
    . "VALUES ('$id_aluno','$nota','Recuperação','$id_disciplina')");

    
}else{
    $insere = $db->query("UPDATE cad_nota SET nota='$nota'    WHERE id_aluno = '$id_aluno'  AND etapa = 'Recuperação' AND id_disciplina = '$id_disciplina' "); 
}

$db->close();
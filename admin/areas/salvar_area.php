<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$titulo = $_POST['titulo'];
$abreviacao = $_POST['abreviacao'];


$query = "SELECT COUNT(*) as titulo FROM cad_area_conhecimento WHERE titulo = '$titulo' or abreviacao = '$abreviacao' ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['titulo'];

if($total == 0){
    $insere = $db->query("INSERT INTO cad_area_conhecimento ( titulo,abreviacao)"
    . "VALUES ('$titulo','$abreviacao')");

    echo '1';
}else{
    echo 'Já existe uma àrea do conhecimento nome com este título ou abreviação!';
}

$db->close();
/*

*/
?>
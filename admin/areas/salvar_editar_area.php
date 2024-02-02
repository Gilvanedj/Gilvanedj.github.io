<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$abreviacao = $_POST['abreviacao'];


$query = "SELECT COUNT(*) as nome FROM cad_area_conhecimento WHERE (titulo = '$titulo' or abreviacao = '$abreviacao' ) and id<>'$id'  ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['nome'];

if($total == 0){
   
    $insere = $db->query("UPDATE cad_area_conhecimento SET titulo='$titulo', abreviacao='$abreviacao'   WHERE id = '$id'"); 

    echo '1';
}else{
    echo 'Já existe uma àrea do conhecimento nome com este título ou abreviação!';
}
/*

*/
?>
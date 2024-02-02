<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id_escola = $_POST['id_escola'];
$inicio = $_POST['inicio'];
$termino = $_POST['termino'];
$etapa = $_POST['etapa'];

$separa_data = explode(' ',$inicio);
$separa_termino = explode(' ',$termino);

$mes_inicio = "";
if($separa_data[1]== "Jan"){
    $mes_inicio = 1;
}elseif($separa_data[1]== "Fev"){
    $mes_inicio = 2;   
}elseif($separa_data[1]== "Mar"){
    $mes_inicio = 3;   
}elseif($separa_data[1]== "Abr"){
    $mes_inicio = 4;   
}elseif($separa_data[1]== "Mai"){
    $mes_inicio = 5;   
}elseif($separa_data[1]== "Jun"){
    $mes_inicio = 6;   
}elseif($separa_data[1]== "Jul"){
    $mes_inicio = 7;   
}elseif($separa_data[1]== "Ago"){
    $mes_inicio = 8;   
}elseif($separa_data[1]== "Set"){
    $mes_inicio = 9;   
}elseif($separa_data[1]== "Out"){
    $mes_inicio = 10;   
}elseif($separa_data[1]== "Nov"){
    $mes_inicio = 11;   
}elseif($separa_data[1]== "Dez"){
    $mes_inicio = 12;   
}

$mes_termino = "";
if($separa_termino[1]== "Jan"){
    $mes_termino = 1;
}elseif($separa_termino[1]== "Fev"){
    $mes_termino = 2;   
}elseif($separa_termino[1]== "Mar"){
    $mes_termino = 3;   
}elseif($separa_termino[1]== "Abr"){
    $mes_termino = 4;   
}elseif($separa_termino[1]== "Mai"){
    $mes = 5;   
}elseif($separa_termino[1]== "Jun"){
    $mes_termino = 6;   
}elseif($separa_termino[1]== "Jul"){
    $mes_termino = 7;   
}elseif($separa_termino[1]== "Ago"){
    $mes_termino = 8;   
}elseif($separa_termino[1]== "Set"){
    $mes_termino = 9;   
}elseif($separa_termino[1]== "Out"){
    $mes = 10;   
}elseif($separa_termino[1]== "Nov"){
    $mes_termino = 11;   
}elseif($separa_termino[1]== "Dez"){
    $mes_termino = 12;   
}

$inicio_sistema = $mes_inicio.$separa_data[0].$separa_data[2];
$termino_sistema = $mes_termino.$separa_termino[0].$separa_termino[2];

$insere = $db->query("UPDATE cad_periodo SET inicio='$inicio', termino='$termino', inicio_sistema='$inicio_sistema', termino_sistema='$termino_sistema'   WHERE id_escola = '$id_escola' AND etapa = '$etapa'"); 

echo '1';

?>


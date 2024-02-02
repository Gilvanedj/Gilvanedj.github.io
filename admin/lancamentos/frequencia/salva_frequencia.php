<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../../db/banco_dados.db');

$valor = $_POST['valor'];
$data = $_POST['data'];
$tempo = $_POST['tempo'];
$escola = $_POST['escola'];
$id_professor = $_POST['id_professor'];
$id_disciplina = $_POST['id_disciplina'];
$id_aluno = $_POST['id_aluno'];
$id_turma = $_POST['id_turma'];

$conteudo = $_POST['conteudo'];
$observacao = $_POST['observacoes'];

$separa_data = explode(' ',$data);

$dia = $separa_data[0];
$mes = "";
if($separa_data[1]== "Jan"){
    $mes = 1;
}elseif($separa_data[1]== "Fev"){
    $mes = 2;   
}elseif($separa_data[1]== "Mar"){
    $mes = 3;   
}elseif($separa_data[1]== "Abr"){
    $mes = 4;   
}elseif($separa_data[1]== "Mai"){
    $mes = 5;   
}elseif($separa_data[1]== "Jun"){
    $mes = 6;   
}elseif($separa_data[1]== "Jul"){
    $mes = 7;   
}elseif($separa_data[1]== "Ago"){
    $mes = 8;   
}elseif($separa_data[1]== "Set"){
    $mes = 9;   
}elseif($separa_data[1]== "Out"){
    $mes = 10;   
}elseif($separa_data[1]== "Nov"){
    $mes = 11;   
}elseif($separa_data[1]== "Dez"){
    $mes = 12;   
}

$ano = $separa_data[2];
$data_sistema = $mes.$separa_data[0].$separa_data[2];


$lista = $db->query("SELECT * FROM cad_frequencia  WHERE id_aluno = '$id_aluno' AND data_pt = '$data' AND tempo = '$tempo' ");
$dados = $lista->fetchArray();
$id = $dados['id'];

$lista = $db->query("SELECT * FROM cad_conteudo  WHERE  data_pt = '$data' AND tempo = '$tempo' AND id_turma = '$id_turma' ");
$dados = $lista->fetchArray();
$id_conteudo = $dados['id'];

if($id == ""){
    $insere = $db->query("INSERT INTO cad_frequencia ( id_aluno, id_turma, id_escola, data_pt, data_sistema, dia, mes, ano, id_disciplina, id_professor, tempo,frequencia)"
    . "VALUES ('$id_aluno','$id_turma','$escola','$data','$data_sistema','$dia','$mes','$ano','$id_disciplina','$id_professor','$tempo','$valor')");

 
}else{
    $insere = $db->query("UPDATE cad_frequencia SET frequencia='$valor' WHERE id = '$id'"); 
    
}

if($id_conteudo == ""){
    $insere = $db->query("INSERT INTO cad_conteudo (  id_turma, id_escola, data_pt, data_sistema, dia, mes, ano, id_disciplina, id_professor, tempo,conteudo,observacao)"
    . "VALUES ('$id_turma','$escola','$data','$data_sistema','$dia','$mes','$ano','$id_disciplina','$id_professor','$tempo','$conteudo','$observacao')");
}else{
    $insere = $db->query("UPDATE cad_conteudo SET conteudo='$conteudo', observacao = '$observacao' WHERE id = '$id_conteudo'");
}







?>


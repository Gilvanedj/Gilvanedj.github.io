<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$fone = $_POST['fone'];
$endereco = $_POST['endereco'];
$etapa = $_POST['etapa'];
$media = $_POST['media'];

$query = "SELECT COUNT(*) as nome FROM cad_escola WHERE nome = '$nome'and id<>'$id'  ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['nome'];

$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$id'");
$dados = $lista->fetchArray();
$periodo = $dados['etapas'];

if($total == 0){
   
    $insere = $db->query("UPDATE cad_escola SET nome='$nome', email='$email', endereco='$endereco', fone='$fone' , etapas='$etapa', media='$media' WHERE id = '$id'"); 

    if($periodo != $etapa){
        $exclui = $db->query("DELETE FROM cad_periodo WHERE id_escola = '$id'");
        $total_etapas = 0;$divisao="";
        if($etapa == 'Bimestre'){
           $total_etapas = 4;
           $divisao = "º Bim";
       }else{
           $total_etapas = 2;
           $divisao = "º Sem";
       }
   
        for($i=1;$i<=$total_etapas;$i++){
            $fase = $i.$divisao;
            $insere = $db->query("INSERT INTO cad_periodo ( id_escola, etapa)"
            . "VALUES ('$id','$fase' )");
        }
    }


    echo '1';
}else{
    echo 'Já existe uma escola com este nome!';
}
/*

*/
?>
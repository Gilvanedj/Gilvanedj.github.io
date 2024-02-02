<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$nome = $_POST['nome'];
$email = $_POST['email'];
$fone = $_POST['fone'];
$endereco = $_POST['endereco'];
$etapa = $_POST['etapa'];
$media = $_POST['media'];

$query = "SELECT COUNT(*) as nome FROM cad_escola  ";
$result = $db->query($query);

$row = $result->fetchArray(SQLITE3_ASSOC);
$total = $row['nome'];

if($total == 0){
    $insere = $db->query("INSERT INTO cad_escola ( nome, email, endereco, fone, etapas, media)"
    . "VALUES ('$nome','$email','$endereco','$fone','$etapa','$media')");

    
     // Obter o último ID inserido
     $ultimoId = $db->lastInsertRowID();

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
    . "VALUES ('$ultimoId','$fase' )");
}
    

    echo '1';
}else{
    echo 'Já existe uma escola cadastrada!';
}

$db->close();
/*

*/
?>
<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$id = $_GET['id'];
$lista = $db->query("SELECT * FROM cad_professor  WHERE id = '$id'");
$dados = $lista->fetchArray();

$id_escola = $dados['id_escola'];
$lista = $db->query("SELECT * FROM cad_escola  WHERE id = '$id_escola'");
$dados = $lista->fetchArray();
$id = $dados['id'];
$nome = $dados['nome'];

?>
<h6 style="text-align: center"><?php echo $nome ?></h6>
<input type="hidden" id="escola" value="<?php echo $id_escola ?>">
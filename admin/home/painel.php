<?php
//cria o banco de dados se ele não existir
$db = new SQLite3('../../db/banco_dados.db');

$lista = $db->query("SELECT * FROM cad_escola  ");
$dados = $lista->fetchArray();
$nome_escola = $dados['nome'];


?>

<style>
/* Estilos para centralizar a div */
body, html {
    height: 100%;
    margin: 0;
}

.centralizar-div {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

/* Estilos adicionais (opcional) */
.container {
    width: 80%;
    max-width: 600px; /* ajuste conforme necessário */
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #f8f8f8;
}
</style>
<div class="centralizar-div">
        <div class="container">
            <!-- Conteúdo da div centralizada -->
            <h2 style="text-align: center">DIÁRIO DIGITAL</h2>
            <h4 style="text-align: center"><?php echo $nome_escola ?></h4>
        </div>
    </div>
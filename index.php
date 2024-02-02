<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Diário Digital</title>
    <link rel="stylesheet" href="scripts/metro4/css/metro-all.min.css">
    <link rel="stylesheet" href="scripts/metro4/css/metro-icons.css">
    <script src="scripts/metro4/js/metro.min.js"></script>
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery_mask/jquery_mask.js" type="text/javascript"></script>
    <script src="scripts/jquery_mask/maskMoney.min.js" type="text/javascript"></script>
    <script src="scripts/printer/jQuery.print.js"></script>
    <script src="scripts/chart.min.js"></script>
   

</head>
<body class="bg-gray">

    <div data-role="appbar" data-expand-point="md"">
        
        <ul class="app-bar-menu " >
            <li>
                <a href="#" class="dropdown-toggle ">Início</a>
                <ul class="d-menu" data-role="dropdown">
                    
                    <li><a href="#" class="sair">Sair</a></li>
                </ul>

            </li>
            <li><a href="#" class="home">Home</a></li>
            <li>
                <a href="#" class="dropdown-toggle">Cadastros</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="#" class="escola">Escola</a></li>
                    <li><a href="#" class="turma">Turmas</a></li>
                    <li><a href="#" class="alunos">Alunos</a></li>
                    <li><a href="#" class="areas">Áreas do conhecimento</a></li>
                    <li><a href="#" class="professor">Professores</a></li>
                    
                </ul>
            
            </li>
            
            <li><a href="#" class="lancamentos">Lançamentos</a></li>
            <li><a href="#" class="config">Configurações</a></li>
            
            
        </ul>
    </div>
    <br><br>
    <div id="corpo"></div>


<script>
$(function(){
    $("#corpo").load("admin/home/painel.php")
    $(".sair").click(function(e){
        e.preventDefault()
        window.close();

    })
    $(".escola").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/escolas/painel.php")

    })
    $(".turma").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/turmas/painel.php")

    })
    $(".alunos").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/alunos/painel.php")

    })
    $(".areas").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/areas/painel.php")

    })
    $(".professor").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/professor/painel.php")

    })
    $(".lancamentos").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/lancamentos/painel.php")

    })
    $(".config").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/configuracoes/painel.php")

    })
    $(".home").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/home/painel.php")

    })
    $(".limpar").click(function(e){
        e.preventDefault()
        $("#corpo").load("admin/limpar/painel.php")

    })

})
</script>  
</body>
</html>
<div class="p-4 m-4 bg-white" style="min-height: 700px;">
   <h4>Cadastro de Áreas do Conhecimento</h4><hr>
   <div class="row">
        <div class="cell-4 p-2">
            <div class="cadastro"></div>
        </div>
        <div class="cell-8 p-2">
            <div class="tabela"></div>
        </div>
   </div>
</div>
<script>
    $(function(){
        $(".cadastro").load("admin/areas/cadastro.php")
        $(".tabela").load("admin/areas/tabela.php")
    })
</script>
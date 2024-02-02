<div data-role="panel" data-title-caption="Cadastrar Área do conhecimento" data-cls-title="bg-blue fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <div class="form-group">            
            <input type="text" id="titulo" name="titulo" data-role="input" data-validate="required" data-prepend="Título: ">
        </div>
        <div class="form-group">            
            <input type="text" id="abreviacao" name="abreviacao" data-role="input" data-validate="required" data-prepend="Abreviação: ">
        </div>
        
        <div class="form-group">            
            <button class="button primary salvar" >Cadastrar</button>
            <button class="button cancelar" >Cancelar</button>
        </div>

    </form>
</div>

<script>
    $(function(){
        $(".salvar").click(function(e){
            e.preventDefault()
            titulo = $("#titulo").val()
            abreviacao = $("#abreviacao").val()
         
           
            if(titulo == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>O título da área do conhecimento não pode ficar em branco!</div>",
                    closeButton: true
                });
            }else if(abreviacao == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Escolha uma sigla para a área do conhecimento!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/areas/salvar_area.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'titulo':titulo,'abreviacao':abreviacao },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro realizado com sucesso!", "Sucesso", {cls: "success"});
                            
                            $(".cadastro").load("admin/areas/cadastro.php")
                            $(".tabela").load("admin/areas/tabela.php")
                        }else{
                            Metro.dialog.create({
                                title: "Aviso",
                                content: "<div>"+response+"</div>",
                                closeButton: true
                            }); 
                            
                        }
                    },
                    error: function(error) {
                        // Lidar com erros de requisição
                       
                    }
                });

            }

        })
        $(".cancelar").click(function(e){
            e.preventDefault()
            $(".cadastro").load("admin/areas/cadastro.php")
            

        })
    })
</script>
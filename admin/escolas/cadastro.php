<div data-role="panel" data-title-caption="Cadastrar escola" data-cls-title="bg-blue fg-white" data-title-icon="<span class='mif-folder'></span>">
    <form action="" method="post" id="form">
        <div class="form-group">            
            <input type="text" id="nome" name="nome" data-role="input" data-validate="required" data-prepend="Nome: ">
        </div>
        <div class="form-group">            
            <input type="text" id="endereco" data-role="input" data-prepend="Endereço: ">
        </div>
        <div class="form-group">            
            <input type="email" id="email" data-role="input" data-prepend="Email: ">
        </div>
        <div class="form-group">            
            <input type="phone" id="fone" data-role="input" data-prepend="Fone: ">
        </div>
        <div class="form-group">            
            <input type="number" id="media" data-role="input" data-prepend="Média: ">
        </div>
        <div class="form-group">            
            <select id="etapa" data-role="select">
                <option value="">Selecione um tipo de etapa</option>
                <option value="Bimestre"> 4 Bimestres</option>
                <option value="Semestre">2 Semestres</option>
                
            </select>
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
            nome = $("#nome").val()
            endereco = $("#endereco").val()
            email = $("#email").val()
            fone = $("#fone").val()
            media = $("#media").val()
            etapa = $("#etapa").val()
            
            if(nome == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>O nome da escola não pode ficar em branco!</div>",
                    closeButton: true
                });
            }else if(media == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>A média da escola não poderá ficar em branco!</div>",
                    closeButton: true
                });
            }else if(etapa == ""){
                Metro.dialog.create({
                    title: "Aviso",
                    content: "<div>Selecione o tipo de etapas!</div>",
                    closeButton: true
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "admin/escolas/salvar_escola.php", // Substitua pelo caminho do seu arquivo PHP
                    
                    data: {'nome':nome, 'email':email, 'endereco':endereco,'fone':fone, 'media':media,'etapa':etapa },
                    success: function(response) {
                        // Manipular a resposta do servidor, se necessário
                        if(response == 1){
                            Metro.notify.create("Cadastro realizado com sucesso!", "Sucesso", {cls: "success"});
                            
                            $(".cadastro").load("admin/escolas/cadastro.php")
                            $(".tabela").load("admin/escolas/tabela.php")
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
            $("#nome").val("")
            $("#endereco").val("")
            $("#email").val("")
            $("#fone").val("")
            

        })
    })
</script>
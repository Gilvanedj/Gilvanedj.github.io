<?php
$REMOTE_ADDR;
$ip;
$remote_ip1 = $_SERVER['REMOTE_ADDR'];

@$remote_ip = gethostbyname($REMOTE_ADDR);  // Numero ip
//$hostname = $_SERVER['HTTP_X_REAL_IP'];

?>
<div class="p-4 m-4 bg-white" style="min-height: 700px;">
   <h4>Configurações do sistema</h4><hr class="bg-blue ">
   <div class="row">
        <div class="cell-12 p-2">
            <br>
            <div>
            <h6>Este é seu ip para acessar a partir de outros computadores ligados à sua rede wifi: <?php echo @$remote_ip ?>:54007</h6>
            Basta colar no browser no navegador conforme o exemplo abaixo. <br>
            <img src="imagens/foto.jpg" />
            </div>

        </div>
   </div>
</div>
<script>
    $(function(){
       
       
    })
</script>
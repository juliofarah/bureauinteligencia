       <link href="css/cotacoes.css" rel="stylesheet" type="text/css" />
<!--       <script type="text/javascript" language="javascript" src="../js/jquery-1.3.2.min.js"></script>-->
       <script type="text/javascript" language="javascript" src="../js/cotacao.js"></script>
       <script type="text/javascript" language="javascript">
            $(document).ready(function(){
                /*var hora = new Date();
                $("#conteudo").empty();
                if(hora.getHours() < 17 || (hora.getHours() == 17 && hora.getMinutes() < 40)){
                    //var intervalo = setTimeout(recarregar, 10000);
                    $("#conteudo").load("cotacoes.php", function(){
                        //var intervalo = setInterval(recarregar, 900000);                        
                        var intervalo = setInterval(recarregar, 1000*60);
                    });

                }*/
                function recarregar(){
                    if(new Date().getHours() > 17)
                        location.href = "http://localhost/agrocim/CotacoesRefactor/mostraCotacoes.php";
                    else
                        $("#conteudo").load("cotacoes.php");
                }
            });
        </script>
        <div class="corpoCotacao">
            <?include "cotacoes.php"?>
        </div>


<?php

    /*
     * Funcao posiciona APPS
     *
     * Recebe como parametro uma string que contem a configuracao dos APPS.
     * A posicao padrao esta definida no arquivo config.php
     */     
    function posicionaApps($conf_apps)
    {
        $colunas = explode('|', $conf_apps);


        foreach ($colunas as $chave => $coluna)
        {
            $apps = explode(',', $coluna);

            // Carrega estrutura HTML auxiliar
            if ($chave == 0) { require_once('assets/htmls_auxiliares/html_box-esquerdo.php'); }
            if ($chave == 1) { require_once('assets/htmls_auxiliares/html_box-meio.php'); }
            if ($chave == 2) { require_once('assets/htmls_auxiliares/html_box-direito.php'); }

            // Carrega cada app separadamente
            $connect = Connection::connect();
            foreach ($apps as $app)
            {
                if (!empty($app))
                {
                    require('apps/'.$app.'.php');
                }
            }

            // Carrega estrutura HTML auxiliar
            if ($chave == 0) { require_once('assets/htmls_auxiliares/html_fim_box-esquerdo.php'); }
            if ($chave == 1) { require_once('assets/htmls_auxiliares/html_fim_box-meio.php'); }
            if ($chave == 2) { require_once('assets/htmls_auxiliares/html_fim_box-direito.php'); }
        }
    }

    // ===================================================================================================
    // ===================================================================================================
    // ===================================================================================================    

    /*
     * Se cookie com as posicoes existe, entao carrega os apps conforme
     * a posicao nele especificada
     */
    /*echo Config::get("tempo_vida_cookie");
    echo ' '.time();*/
    if (isset($_COOKIE['Bureau_PosicaoApps']))
    {
        posicionaApps($_COOKIE['Bureau_PosicaoApps']);
    }

    /*
     * Se nao existe, entao carrega a posicao padra de acordo com o arquivo config.php
     */
    else
    {        
        posicionaApps(Config::get('posicao_padrao_apps'));
    }

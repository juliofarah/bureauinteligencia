<?
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<div id="welcome"> 
    Olá <strong><?echo SessionAdmin::getLoggedUser()->name()?></strong>, seja bem-vindo ao sistema de administração do Bureau de Inteligência do Café.    
    <br />
    <strong>Você está autorizado a administrar o site</strong>
    <br />
    <br />
    No administrador é possível definir os conteúdos padrões que serão exibidos na tela principal do sistema.
</div>

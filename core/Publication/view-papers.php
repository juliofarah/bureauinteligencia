<?php
    $response = PublicationHandler::getAllPapers(1);
?>
<div class="show-publications">
    <!--
    <table class='table-papers' border="1">
        <tbody>
            <tr>
                <td>nome</td>
                <td>icone</td>
            </tr>
            <tr>
                <td>nome</td>
                <td>ícone</td>
            </tr>
            
        </tbody>
    </table>
    -->
    <?if($response->count() > 0):?>
        <?PublicationHandler::printListPapers($response)?>
        <?foreach($response as $publication):?>                    
        <?endforeach?>
    <?endif?>    
    <a class="openSearch" id="paper">Buscar Artigos</a><br />        
</div>
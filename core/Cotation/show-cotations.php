<?
    require_once 'CotacoesRefactor/HtmlLib.php';    
    $allCots = HtmlLib::cotacoes();
?>
<div id="cotations-div">
    <div class="toolbars" style="border: 0 !important; padding-top: 0 !important;">
        <ul class="items-toolbars">
            <li class="item-selected" title="futuras" type="content-cotations">
                <a href="#futuras">Futuras</a>
            </li>
            <li title="fisicas" type="content-cotations">
                <a href="#fisicas">Físicas</a>
            </li>
            <li title="indicadores" type="content-cotations">
                <a href="#indicadores">Indicadores</a>
            </li>
        </ul>
        <!--divs-->
        <div class="content-cotations content-of-tab" id="futuras">
            <div id="bmf" class="table-cotation">
                <div class="title-cot">
                    <span class="title-cotation">BM&F - São Paulo</span>
                </div>
                <table class="table-values" border="0">
                    <thead>
                        <tr>
                            <th class="first">[Contrato]</th>
                            <th>ULT</th>
                            <th>DIF</th>
                            <th>CAberto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?$bmf = $allCots->get("BMF")?>                    
                        <?echo HtmlLib::buildLinesHtml($bmf)?>
                    </tbody>
                </table>
            </div>
            <div id="newyork" class="table-cotation">
                <div class="title-cot">
                    <span class="title-cotation">ICE - NY</span>
                </div>
                <table class="table-values" border="0">
                    <thead>
                        <tr>
                            <th class="first">[Contrato]</th>
                            <th>ULT</th>
                            <th>DIF</th>
                            <th>CAberto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?$ny = $allCots->get("NY")?>
                        <?echo HtmlLib::buildLinesHtml($ny)?>
                    </tbody>
                </table>
            </div>
            <div id="london" class="table-cotation">
                <div class="title-cot">
                    <span class="title-cotation">Londres</span>
                </div>
                <table class="table-values" border="0">
                    <thead>
                        <tr>
                            <th class="first">[Contrato]</th>
                            <th>ULT</th>
                            <th>DIF</th>
                            <th>CAberto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?$london = $allCots->get("London")?>
                        <?echo HtmlLib::buildLinesHtml($london)?>
                    </tbody>
                </table>             
            </div>
            <div id="chart-futuras">

            </div>
        </div>
        
        <div class="content-cotations content-of-tab" id="fisicas">
            <div id="bicadura" class="table-cotation">
                <div class="title-cot">
                    <span class="title-cotation">Café Arábica <sub style="font-size: 9.5px; color: #333">(R$/saca de 60kg)</sub></span>
                </div>
                <table class="table-values arabica" border="0">
                    <thead>
                        <tr>
                            <th class="first">[Tipo]</th>
                            <th>ULT</th>
                            <th>DIF</th>
                            <th>ANT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?$arabica = $allCots->get("Arabica");?>
                        <?echo HtmlLib::buildLinesHtml($arabica, true)?>
                    </tbody>
                </table>
            </div>
        </div>     
        
        <div class="content-cotations content-of-tab" id="indicadores">
            <div id="dolar" class="table-cotation last">
                <div class="title-cot">
                    <span class="title-cotation">Indicadores Financeiros</span>
                </div>
                <table class="table-values" border="0">
                    <thead>
                        <tr>                        
                            <th class="first"></th>
                            <th>ULT</th>
                            <th>DIF</th>
                            <th>ANT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="<?echo $allCots->get("Dolar")->offSetGet(0)->getCode()?>" class="cotation-values">
                            <?echo HtmlLib::buildLineWithCurrentFisicaOrIndicador($allCots->get("Dolar")->offSetGet(0), false);?>
                        </tr>
                        <tr id="<?echo $allCots->get("Euro")->offSetGet(0)->getCode()?>" class="cotation-values">                        
                            <?echo HtmlLib::buildLineWithCurrentFisicaOrIndicador(($allCots->get("Euro")->offSetGet(0)), false);?>
                        </tr>
                        <tr id="<?echo $allCots->get("IBovespa")->offSetGet(0)->getCode()?>" class="cotation-values">                        
                            <?echo HtmlLib::buildLineWithCurrentFisicaOrIndicador($allCots->get("IBovespa")->offSetGet(0), false);?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>        
        <span style="font-size: 11px; margin-top: 10px;">
            * Clique nos contratos para visualizar os gráficos
        </span>
    </div><!--end tollbars-->    
</div>
<div class="form-insert" id="insert-publication">
    <h2>Inserção da Análise. </h2>
    <form id="form-publication" class="analysis" action="<?echo LinkController::getBaseURL()?>/admin/analysis/insert" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="field">
                <label for="title">Título:</label> <input class="charLimits" maxlength="70" type="text" name="Título" id="title"/><div class="erro"></div><br />
                <div class="infofield">max. <span id="title-char">70</span> caracteres</div>
            </div>
<!--            <div class="field">
                <label for="link">Link:</label> <input type="text" name="Link" id="link"/><div class="erro"></div>
            </div>
-->
            <div class="fields" style="margin: 20px auto; text-align: left;">
                <label style="font-weight: bold">Texto da Análise</label>
                
                <textarea name="Texto" id="text">
                    
                </textarea>
            </div>

            <div class="field">
                <label>Assunto:</label> 
                <select id="subarea" class="subarea_analysis">
                    <option value=""></option>
                    <option value="12">Produção</option>
                    <option value="13">Consumo</option>
                    <option value="14">Indústria</option>
                    <option value="15">Varejo</option>
                </select><div class="erro"></div>
            </div>
            <!--<div class="field">
                <label>Tema:</label> <select id="subarea" disabled="disabled"><option value="">Selecione uma área</option></select> <div class="erro"></div>
            </div>-->
            <div class="field">
                <label>Estado:</label> <select id="state"><option value="">Aguarde...</option></select><div class="erro"></div>
            </div>
            <button type="submit" class="button-insert-analysis" onclick="tinyMCE.triggerSave(true,true);">Inserir</button>
        </fieldset>
    </form>
</div>
<a href="<?echo LinkController::getBaseURL()?>/admin/publicacoes" class="link-goback">Voltar</a>

<script type="text/javascript">
    tinyMCE.init({
        mode: "textareas",
        theme: "advanced",//,
        plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager, ibrowser",
        
        theme_advanced_buttons1: "bold, italic, underline, strikethrough, pasteword, link, undo, redo,|,bullist,numlist,|,sub,sup,|,forecolor,backcolor,|,cleanup,code,|,charmap",
        theme_advanced_buttons2: ""
    });
</script>

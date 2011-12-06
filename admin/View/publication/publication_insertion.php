<div class="form-insert" id="insert-publication">
    <h2>Insira o PDF da Artigo no formulário</h2>
    <form action="<?echo LinkController::getBaseURL()?>/admin/paper/insert" method="post" id="form-publication" enctype="multipart/form-data">
        <fieldset>
            <div class="field">
                <label>Escolha o .pdf</label>
                <input type="file" id="publication-file" name="Arquivo"/><div class="erro"></div>
            </div>
            <div class="field">
                <label for="title">Título:</label> <input class="charLimits" maxlength="70" type="text" name="Título" id="title"/><div class="erro"></div><br />
                <div class="infofield">max. <span id="title-char">70</span> caracteres</div>
            </div>
            <!--<div class="field">
                <label for="link">Link:</label> <input type="text" name="Link" id="link"/><div class="erro"></div>
            </div>-->
            <div class="field">
                <label>Área:</label> 
                <select id="area" type="select-one">
                    <option value=""></option>
                    <option value="1">Economia/Administração</option>
                    <option value="2">Agronomia</option>
                </select><div class="erro"></div>
            </div>
            <div class="field">
                <label>Tema:</label> <select type="select-one" id="subarea" disabled="disabled"><option value="">Selecione uma área</option></select> <div class="erro"></div>
            </div>
            <div class="field">
                <label>Tipo de Publicação: </label><select type="select-one" id="publicationType"><option value="">Aguarde...</option></select><div class="erro"></div>
            </div>
            <div class="field">
                <label>Ano de publicação: </label>
                <input type="text" id="publication-year" name="Ano de publicação" style="width: 150px"/><div class="erro"></div>
            </div>
            <!--
            <div class="field">
                <label>Selecione o tipo do Evento que este video pertence</label>
                <ul class="list-events-type">
                    <li>
                        <label for="curso">Curso </label><input id="curso" class="radio_button" type="radio" name="type_event" value="curso"/>
                    </li>
                    <li>
                        <label for="palestra">Palestra </label><input id="palestra" class="radio_button" type="radio" name="type_event" value="palestra"/> 
                    </li>
                    <li>
                        <label for="documentario">Documentário </label><input id="documentario" class="radio_button" type="radio" name="type_event" value="documentario"/>
                    </li>
                    <li>
                        <label for="reportagem">Reportagem </label><input id="reportagem" class="radio_button" type="radio" name="type_event" value="reportagem"/>
                    </li>
                    <li>
                        <label for="entrevista">Entrevista </label><input id="entrevista" class="radio_button" type="radio" name="type_event" value="entrevista"/>
                    </li>
                    <li>
                        <label for="outros">Outros </label><input id="outros" class="radio_button" type="radio" name="type_event" value="outros"/>
                    </li>                    
                </ul>
            </div>-->
            <button type="submit" class="button-insert-paper">Inserir</button>
        </fieldset>
    </form>
</div>
<a href="<?echo LinkController::getBaseURL()?>/admin/publicacoes" class="link-goback">Voltar</a>
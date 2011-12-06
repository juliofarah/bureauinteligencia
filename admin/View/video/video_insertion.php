<div class="form-insert" id="insert-video">
    <h2>Insira o link do video no formulário</h2>
    <form action="<?echo LinkController::getBaseURL()?>/admin/video/insert" method="post" id="form-video">
        <fieldset>
            <div class="field">
                <label for="title">Título:</label> <input type="text" name="Título" id="title"/><div class="erro"></div>
            </div>
            <div class="field">
                <label for="link">Link:</label> <input type="text" name="Link" id="link"/><div class="erro"></div>
            </div>
            <div class="field">
                <label>Área:</label> 
                <select id="area">
                    <option value=""></option>
                    <option value="1">Economia/Administração</option>
                    <option value="2">Agronomia</option>
                </select><div class="erro"></div>
            </div>
            <div class="field">
                <label>Tema:</label> <select id="subarea" disabled="disabled"><option value="">Selecione uma área</option></select> <div class="erro"></div>
            </div>
            <!--<div class="field">
                <label>Estado:</label> <select id="state"><option value="">Aguarde...</option></select><div class="erro"></div>
            </div>-->
            <div class="field">
                <label>Duração: </label>
                <input type="text" name="Duração" id="duration" style="width: 150px;"/><div class="erro"></div>
            </div>
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
            </div>
            <button type="submit" class="button-insert">Inserir</button>
        </fieldset>
    </form>
</div>
<a href="<?echo LinkController::getBaseURL()?>/admin/videos" class="link-goback">Voltar</a>
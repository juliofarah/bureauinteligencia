<div class="form-insert" id="insert-news">
    <h2>Insira o link do RSS no formulário</h2>
    <form action="<?echo LinkController::getBaseURL()?>/admin/news/insert" method="post" id="form-news">
        <fieldset>
            <div class="field">
                <label for="title">Título do RSS:</label> <input type="text" name="Título" id="title"/><div class="erro"></div>
            </div>
            <div class="field">
                <label for="link">Link:</label> <input type="text" name="Link" id="link"/><div class="erro"></div>
            </div>
            <button type="submit" class="button-insert">Inserir</button>
        </fieldset>
    </form>
</div>
<a href="<?echo LinkController::getBaseURL()?>/admin/noticias" class="link-goback">Voltar</a>
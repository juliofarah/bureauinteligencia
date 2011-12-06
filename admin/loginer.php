 <div class="login-div">
     <div class="body-login-div">
         <h1>Gerenciador Bureau</h1>
         <div class="login-form-div">
             <? //print_r($_GET)?>
             <?php if(!empty ($_GET)):?>
                <? if(!empty($_GET["empty"])):?>
                    <p class="error-login">Os campos devem estar preenchidos</p>
                <? elseif(!empty($_GET["loginfail"])):?>
                    <p class="error-login">Usuário e/ou senha inválidos!</p>
                <?endif?>
             <?endif?>
                    <form id="login-form" action="<?echo LinkController::getBaseURL()?>/admin/login" method="post">
                 <dl>
                     <dt>
                         <label for="username">usuário</label>
                     </dt>
                     <dd>
                         <input name="username" id="username" class="input" type="text" value="<??>"/>
                     </dd>
                     <dt>
                         <label for="password">senha</label>
                     </dt>
                     <dd>
                         <input name="password" id="password" class="input" type="password" value=""/>
                     </dd>
                     <dd>
                         <input id="loginButton" width="93" height="40" type="image" src="<?echo LinkController::getBaseURL()?>/images/login/login.gif"/>
                     </dd>
                 </dl>
             </form>
         </div>
     </div>
     <div id="formFooter"></div>
 </div>
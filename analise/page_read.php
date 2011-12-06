<?
session_start();
?>
<?$baseUrl = LinkController::getBaseURL();?>
<?
$link = substr(LinkController::link(), 0, -5);
?>
<? $analysis = PublicationHandler::getAnAnalysis($link);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Bureau de Intelig&ecirc;ncia do Caf&eacute;</title>

        <!--<link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/ui/jquery-ui-1.8.8.custom.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/ui/jquery-ui-1.8.15.custom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/main.css" media="screen" />        
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/dialog.css" media="screen" />        
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/read-analysis.css" media="screen" />

        <!--<script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-1.6.2.min.js"></script>
        <!--<script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui-1.8.8.custom.min.js"></script>-->
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui-1.8.15.custom.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cooquery.js"></script>                       
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cycle.min.js"></script>        
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/windows.js"></script>   
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/main.js"></script>        
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/AppAjax.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/EmailAjax.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.jqprint.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/events.js"></script>      
        <script type="text/javascript">
            $(document).ready(function(){
                postComment();
                //sendAnalysisToEmail();
                openMailDialog();
                printAnalysis();
                <?if(Session::isLogged()):?>
                $("#do-comment").click(function(){
                    var window = Window.New();
                    window.divName = "#div-comment-form";
                    window.title = "Comentar";
                    window.renderDialogWithForm();
                });
                <?endif?>
            });
        </script>
        <?if ($analysis != null):?>
        <title>Bureau de Inteligência do Café - <?echo $analysis->title();?></title>
        <?else:?>
        <title>Bureau de Inteligência do Café - Página não existente.</title>
        <?endif?>
    </head>
    <body>        
        <div class="container_12" style="text-align: center">
            <?include 'header.php'?>            
            <div id="aplicacoes">
                <div class="content-analysis">
                    <?if($analysis != null):?>                    
                    <div class="body-analysis">
                        <div class="title-analysis">
                            <h1><?echo $analysis->title();?></h1> 
                            <small><?echo $analysis->getDateFormatted()?></small>
                        </div>
                        <div class="text-analysis">
                            <?echo $analysis->text();?>
                        </div>
                        <?if(Session::isLogged()):?>
                        <div id="actions">
                            <ul>
                                <li>
                                    <img id="print" src="<?echo LinkController::getBaseURL()?>/images/ico_print.gif" title="Imprimir esta análise"/>                                    
                                </li>
                                <li>
                                    <img id="openMailDialog" src="<?echo LinkController::getBaseURL()?>/images/ico_email.gif" title="Enviar por email"/>                                    
                                </li>
                            </ul>
                            <!--<button id="openMailDialog">Envie esta análise por email</button>-->    
                        </div>                                                
                        <?endif?>                        
                    </div>                    
                    <div id="comments-list">
                        <div id="comentsList-header">
                            <span>Comentários (<?echo $analysis->getComments()->count()?>)</span>
                            <?if(Session::isLogged()):?>
                            <span id="do-comment">comente</span>
                            <?else:?>
                            <span id="do-comment">Faça login para comentar</span>
                            <?endif?>
                        </div>
                        <div id="comments">
                            <dl> 
                                <?$commentsIterator = $analysis->getComments()->getIterator();?>
                                <?while($commentsIterator->valid()):?>                            
                                    <?  PublicationHandler::printComment($commentsIterator->current());?>
                                <?$commentsIterator->next();?>
                                <?endwhile?>
                            </dl>
                        </div>
                    </div>                                    
                    
                    <?else:?>
                    <h1>Esta página não existe.</h1>
                    <?endif?>
                </div>                
            </div>
            <div class="clear"></div>

            <div class="grid_12 rodape">
                <p>Bureau de Intelig&ecirc;ncia Competitiva do Caf&eacute;</p>
            </div>            
        </div>        
        <!-- DIALOG DIVS -->
        <!--form to send a comment -->
        <div id="div-comment-form">
            <div id="box-comment-form">
                <form id="form-comment" 
                      action="<?echo LinkController::getBaseURL()?>/analysis/{<?echo $analysis->id()?>}/comment" 
                      method="post">
                    <div class="fields">
                        <label>Título</label>:
                        <input id="title" name="Título" value="" maxlength="80"/>
                    </div>
                    <div class="fields">
                        <label>Comentário:</label><br />
                        <textarea id="comment" value="">

                        </textarea>
                    </div>
                    <div class="fields button-field">
                        <button class="button-comment">enviar</button>
                    </div>
                </form>
            </div>                        
        </div>
        <!--form to send to email-->
        <div id="div-mailto" style="display: none">
            <div id="box-mailto">
                <form id="form-mailto">
                    <div class="fields">
                        <label>email do destinatário</label>:
                        <input type="text" id="to"/>
                    </div>
                    <div class="fields">
                        <label>nome do destinatário</label>:
                        <input type="text" id="name-to"/>
                    </div>
                    <div class="fields button-field">
                        <button id="sendEmail" title="<?echo $link?>">Enviar</button>
                    </div>
                </form>
            </div>
            <div id="sending-mailto" style="display: none">
                enviando... <img src="<?echo LinkController::getBaseURL()?>/images/ajax-loading-apps.gif" />
            </div>
        </div>
    </body>
</html>
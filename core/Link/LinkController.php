<?php
/**
 * Description of LinkController
 *
 * @author RAMONox
 */
class LinkController {

    private static $baseURL = 'http://localhost/BureauInteligencia';
    //private static $baseURL = 'http://www.agrocim.com.br/BureauInteligencia';
    //private static $baseURL = 'http://www.icafebr.com.br';
    
    /**
     * @var HashMap
     */
    private static $map_pages = array();

    /**
     * @var HashMap
     */
     private static $map_requests = array();

     /**
      * @var HashMap
      */
    private static $map_main_pages = array();
    
    /**
     * @var HashMap
     */
    private static $map_admin_pages = array();

    private static function initPages(){
        self::$map_pages = new HashMap();
        self::$map_pages->put('main', "View/Main.php");
        self::$map_pages->put("gea", "View/Main.php");
        self::$map_pages->put("comuns", "View/Main.php");
        self::$map_pages->put("users", "View/Main.php");
        self::$map_pages->put("logout", "Servlets/logout.php");
        self::$map_pages->put("news", "View/Main.php");
        self::$map_pages->put("bullet", "View/Main.php");
        self::$map_pages->put("search", "View/Main.php");
    }

    private static function mainPages(){
        self::$map_main_pages = new HashMap();
        self::$map_main_pages->put("main", "View/main_content.php");
        self::$map_main_pages->put("gea", "View/Gea.php");
        self::$map_main_pages->put("comuns","View/Common.php");
        self::$map_main_pages->put("users", "View/User/list_users.php");
        self::$map_main_pages->put("news", "View/Publication/news_insertion.php");
        self::$map_main_pages->put("bullet", "View/Publication/bullet_insertion.php");
        self::$map_main_pages->put("search", "View/Publication/Search/news_search_engine.php");
    }
    
    private static function initRequests(){
        self::$map_requests =  new HashMap();
        //self::$map_requests->put("login", "Servlets/do_login.php");
        self::$map_requests->put("login", "login_admin.php");
        self::$map_requests->put("city/list", "Servlets/list_cities.php");
        self::$map_requests->put("user/insert", "Servlets/insert_admin.php");
        self::$map_requests->put("user/update", "Servlets/update_admin.php");
        self::$map_requests->put("user/delete", "Servlets/delete_admin.php");        

        self::$map_requests->put("news/insert", "../core/News/save-new.php");
        self::$map_requests->put("news/delete", "../core/News/delete-new.php");
        self::$map_requests->put("news/update/index", "../core/News/update_indexes.php");
        
        self::$map_requests->put("perfil/positions/save", "core/User/save-config.php");

        self::$map_requests->put("video/insert", "../core/Video/save-video.php");
        self::$map_requests->put("video/find/related", "proccess_search_video.php");
        self::$map_requests->put("video/delete", "../core/Video/delete-video.php");
        
        self::$map_requests->put("rss/change", "core/News/change-rss.php");
        self::$map_requests->put("weather/change", "core/Weather/change-weather.php");

        self::$map_requests->put("admin/area", "../core/generics/get_areas.php");
        self::$map_requests->put("admin/subarea", "../core/generics/get_subareas.php");

        self::$map_requests->put("admin/state","../core/generics/get_states.php");
        
        self::$map_requests->put("admin/publicationTypes", "../core/generics/get_publicationTypes.php");
        
        self::$map_requests->put("cities", "core/generics/get_cities.php");
        
        self::$map_requests->put("activities", "core/generics/get_activities.php");

        self::$map_requests->put("search/subarea", "../core/generics/get_subareas.php");

        self::$map_requests->put("paper/find/related", "proccess_search_paper.php");
        
        self::$map_requests->put("analysis/find/related", "proccess_search_analysis.php");
        
        self::$map_requests->put("paper/insert", "../core/Publication/save-paper.php");
        self::$map_requests->put("analysis/insert", "../core/Publication/save-analysis.php");
        self::$map_requests->put("publication/delete", "../core/Publication/delete_publication.php");
        self::$map_requests->put("analysis/comment", "core/Publication/comment_analysis.php");
        self::$map_requests->put("analysis/send/email", "core/Publication/send_analysis_email.php");
        
        self::$map_requests->put("mainMultiColumn", "core/Charts/build_column3dchart_futuras.php");
        self::$map_requests->put("quotations/storaged", "core/Charts/build_linechart_of_a_quotation.php");
        self::$map_requests->put("quotations/futuras/storaded", "core/Charts/build_chandlechart.php");
        //self::$map_requests->put("qutotations/storaged", "core/Cotation/CotacoesRefactor/Storage/get-storaged-cotations.php");        
        
        self::$map_requests->put("user/subscribe", "../core/User/subscribe-user.php");
        self::$map_requests->put("user/forgetpassword", "core/User/forgot-password.php");
        
        /****Loading apps****/
        self::$map_requests->put("load", "apps/to_load/load_apps.php");        
        
        //routes to datacenters
        self::$map_requests->put("datacenter/table", "core/Datacenter/requests/buildTable.php");        
        self::$map_requests->put("datacenter/chart", "core/Datacenter/requests/buildChart.php");
        self::$map_requests->put("datacenter/param", "core/generics/datacenter/getParam.php");
    }

    private static function initAdminPages(){
        self::$map_admin_pages = new HashMap();
        self::$map_admin_pages->put("main", "View/main.php");
        self::$map_admin_pages->put("videos", "View/video/videos.php");
        self::$map_admin_pages->put("videos/list", "View/video/video_list.php");
        self::$map_admin_pages->put("videos/list/", "View/video/video_list.php");
        self::$map_admin_pages->put("videos/inserir", "View/video/video_insertion.php");

        self::$map_admin_pages->put("noticias", "View/news/news.php");
        self::$map_admin_pages->put("noticias/list", "View/news/news_list.php");
        self::$map_admin_pages->put("noticias/inserir", "View/news/news_insertion.php");

        self::$map_admin_pages->put("publicacoes", "View/publication/publications.php");
        self::$map_admin_pages->put("artigos/list", "View/publication/publication_list.php");
        self::$map_admin_pages->put("artigos/list/", "View/publication/publication_list.php");
        self::$map_admin_pages->put("artigo/inserir", "View/publication/publication_insertion.php");
        self::$map_admin_pages->put("analise/inserir", "View/publication/analysis_insertion.php");
        self::$map_admin_pages->put("analise/list", "View/publication/analysis_list.php");       
        self::$map_admin_pages->put("analise/list/", "View/publication/analysis_list.php");       
        
        self::$map_admin_pages->put("logoutAdmin", "logout_admin.php");
    }       

    public static function routeAdminPage(){
        self::initAdminPages();
        $link = self::link();                
        
        /**/
        if(SessionAdmin::isLogged()){
            if(self::$map_admin_pages->containsKey($link)){
                if(file_exists(self::$map_admin_pages->get($link))){
                    return self::$map_admin_pages->get($link);
                }else{
                    throw new FileNotFoundException("Arquivo não encontrado!");
                }
            }else{
                $linkCategory = explode("/", $link);
                $linkPages = explode("artigos/list/", $link);                
                if(sizeof($linkCategory) == 3){
                    if(sizeof($linkPages) == 2 && $linkPages[1] != null && is_numeric($linkPages[1])){
                        $_GET['page'] = $linkPages[1];                     
                        return "View/publication/publication_list.php";                        
                    }else{                        
                        $linkPages = explode("analise/list/", $link);
                        if(sizeof($linkPages) == 2 && $linkPages[1] != null && is_numeric($linkPages[1])){
                            $_GET['page'] = $linkPages[1];                            
                            return"View/publication/analysis_list.php";
                        }else{
                            $linkPages = explode("videos/list/", $link);
                            if(sizeof($linkPages) == 2 && $linkPages[1] != null && is_numeric($linkPages[1])){
                                $_GET['page'] = $linkPages[1];
                                return "View/video/video_list.php";
                            }else
                                throw new Exception("Destino não encontrado");
                        }
                    }
                }else{                    
                    throw new Exception("Destino não encontrado");
                }
            }
        }else{            
            throw new LoginException();
        }
    }
    
    public static function route(){
        if(Session::isLogged()){
            return self::page();
        }else{
            throw new LoginException();
        }
    }

    public static function routeMainPage(){
        return self::includeToMainPage();
    }
    
    public static function page(){
        self::initPages();
        $link = self::link();
        if(Session::isLogged()){
            if(self::$map_pages->containsKey($link)){
                if(file_exists(self::$map_pages->get($link)))
                    return self::$map_pages->get($link);
                throw new FileNotFoundException("Arquivo de inclusão não existente");
            }
            throw new Exception("Destino não encontrado");
        }else{
            throw new LoginException();
        }
    }
    
    public static function includeToMainPage(){
        self::mainPages();
        $link = self::link();        
        if(self::$map_main_pages->containsKey($link)){
            if(file_exists(self::$map_main_pages->get($link)))
                return self::$map_main_pages->get($link);
            throw new FileNotFoundException("Arquivo de inclusão não encontrado!");
        }
        throw new Exception("Destino não encontrado");
    }

    public static function isRequestToInsertPublication(){
        return self::link() == "publication/insert";
    }

    public static function restAdmin(){        
        self::initRequests();

        if(strpos(self::link(), "?") !== false)
            $link = substr(self::link(), 0, strpos(self::link(), "?"));
        else
            $link = self::link();        
        if(SessionAdmin::isLogged() || $link == 'login' || isset ($_REQUEST['no-must-online'])){            
            if(self::$map_requests->containsKey($link)){
                if(file_exists(self::$map_requests->get($link))){
                    return self::$map_requests->get($link);
                }
                throw new FileNotFoundException("Arquivo de requisição não encontrado!");
            }
            throw new Exception("Destino não encontrado!");
        }else
            throw new LoginException();
    }

    public static function rest(){
        self::initRequests();
        self::link();
        if(strpos(self::link(), "?") !== false)
            $link = substr(self::link(), 0, strpos(self::link(), "?"));
        else
            $link = self::link();
        if(Session::isLogged() || $link == 'login' || isset ($_REQUEST['no-must-online'])){
            if(self::$map_requests->containsKey($link)){
                if(file_exists(self::$map_requests->get($link))){                    
                    return self::$map_requests->get($link);
                }
                throw new FileNotFoundException("Arquivo de requisição não encontrado!");
            }
            throw new Exception("Destino não encontrado!");
        }else
            throw new LoginException();
    }       

    public static function restSubscribe(){
        self::initRequests();        
        if(strpos(self::link(), "?") !== false)
            $link = substr(self::link(), 0, strpos(self::link(), "?"));
        else
            $link = self::link();
        if(!Session::isLogged()){
            if(self::$map_requests->containsKey($link)){
                if(file_exists(self::$map_requests->get($link))){                    
                    return self::$map_requests->get($link);
                }
                throw new FileNotFoundException("Arquivo de requisição não encontrado!");
            }
            throw new Exception("Destino não encontrado!");
        }else
            throw new LoginException('Você não pode realizar seu cadastro com um usuário online.');
    }   
    
    private static function showNew(){
        $link = self::link();
        //$linksParams = explode("bullter/", $link);
        //$_GET['bullet'] = $linkParams[1];
        $linksParams = explode("noticia/", $link);

        $_GET['news'] = $linksParams[1];
        return 'Servlets/news.php';
    }
    
    public static function restWithParams(){
        $link = self::link();        
        $linkParams = explode("noticia/", $link);     

        if(sizeof($linkParams) > 1){
            echo $linkParams[1];
            $_POST['text'] = $linkParams[1];
            return 'Servlets/insert_new.php';
        }else{
            $linkParams = explode("bullet/", $link);            
            $_POST['text'] = $linkParams[1];
            return 'Servlets/insert_bullet.php';
        }
    }

    public static function link(){
        $URL = str_replace("index.php", "", $_SERVER['PHP_SELF']);
        /*echo "self = ".$_SERVER['PHP_SELF'];
        echo "\n";
        echo "uri = ".$_SERVER['REQUEST_URI']."\n";*/
        if($URL != "/")
            $codigo = str_replace($URL,"", $_SERVER['REQUEST_URI']);
        else
            $codigo = substr ($_SERVER['REQUEST_URI'], 1);
        /*if($codigo != '' && strpos($codigo, "/") === false)
            $codigo .= "/";*/
        if($codigo == '')
            $codigo = "main";
        return $codigo;
    }

    public static function getBaseURL(){
        return self::$baseURL;
    }    
}
?>

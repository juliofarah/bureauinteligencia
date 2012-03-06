<?php
    require_once '../core/generics/Param.php';
    require_once '../core/generics/datacenter/Country.php';
    require_once '../core/generics/Controller.php';
    require_once '../core/generics/GenericDao.php';
    
    $country_id = $_REQUEST['country'];
    
    $dao = new GenericDao(Connection::connect());
    $controller = new Controller($dao);

    $country = $controller->getCountry($country_id);
?>
<?if(!is_null($country)):?>
<div class="form-insert">
    <h2>Edição de país</h2>
    <form title="country" action="<?echo LinkController::getBaseURL()?>/admin/datacenter/country/update/<?echo $country->id()?>" method="post" id="form-country">
        <fieldset>
            <div class="field">
                <label>Nome do País:</label>
                <input type="text" value="<?echo utf8_encode($country->name())?>" id="name" />                
            </div>
            <button type="submit" class="button-edit">Editar</button>
        </fieldset>
    </form>
</div>
<?else:?>
<strong>Este país não existe</strong>
<? endif; ?>


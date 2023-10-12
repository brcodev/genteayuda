<?php

/*ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);*/

require_once __DIR__ . '/../includes/app.php';




use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\EventoController;
use Controllers\OrganizacionController;
use Controllers\VisitaController;
use Controllers\ZonaController;
use Controllers\SolicitudController;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use MiladRahimi\PhpRouter\Router;

$request = new ServerRequest();
$router = Router::create();
$router->setupView(__DIR__ . '/../views');

session_start();





if ( substr_count($_SERVER['REQUEST_URI'], '.') > 1) {

    $router->getPublisher()->publish(new HtmlResponse(include_once __DIR__ . '/../views/layout/page404.php', 404));

}else{


    $router->get('/', [VisitaController::class, 'index']);
    $router->post('/visita/save', [VisitaController::class, 'save']);
    $router->get('/nosotros', [VisitaController::class, 'nosotros']);
    $router->get('/contacto', [VisitaController::class, 'contacto']);
    $router->get('/categorias', [VisitaController::class, 'ayudas']);
    $router->get('/ayuda/{cat}', [OrganizacionController::class, 'index']);
    $router->get('/ayuda/{cat}/{region}', [OrganizacionController::class, 'region']);
    $router->post('/data', [OrganizacionController::class, 'dataOrg']);
    $router->post('/zone', [ZonaController::class, 'dataZona']);
    $router->get('/organizacion/{org}', [OrganizacionController::class, 'orgPage']);
    $router->get('/eventos', [EventoController::class, 'index']);
    $router->get('/evento/{event}', [EventoController::class, 'eventPage']);
    $router->post('/dataevent', [EventoController::class, 'dataEvent']);
    $router->get('/404', [VisitaController::class, 'notFound']);

    /* claims and suggestions */

    $router->post('/visita/sclaim', [VisitaController::class, 'claimSugg']);


    /* Sent first mail to org request */
    $router->post('/visita/org', [OrganizacionController::class, 'saveOrg']);

    /* Admin Login*/
    $router->get('/logaccsysclient/{access}', [LoginController::class, 'index']);
    $router->post('/loginpageorgphl', [LoginController::class, 'login']);


    /* Recover  */

    $router->get('/recaccsysclient/recover', [LoginController::class, 'forgot']);
    $router->post('/recaccsysclient/recover', [LoginController::class, 'forgot']);
    $router->get('/resetaccsysclient/reset', [LoginController::class, 'resetPage']);
    $router->post('/resetaccsysclient/resetValidation', [LoginController::class, 'resetClav']);





    /* ADMIN PROTEGIDAS */

    /* Admin managment */

    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {

        session_start();

        $router->get('/pagemanagephatuser', [AdminController::class, 'index']);

        if ($_SESSION['nivel'] == 2) {

            $router->get('/pagemanagephatuser/createadmin', [AdminController::class, 'createAdmin']);
            $router->post('/pagemanagephatuser/createadmin', [AdminController::class, 'createAdmin']);
            $router->post('/pagemanagephatuser/createadmin/checkmail', [AdminController::class, 'checkEmail']);
            $router->post('/pagemanagephatuser/createadmin/checkuser', [AdminController::class, 'checkUser']);
            $router->get('/pagemanagephatuser/adminlist', [AdminController::class, 'adminList']);
            $router->post('/pagemanagephatuser/userdelad/admin', [AdminController::class, 'deleteAdmin']);
            $router->get('/pagemanagephatuser/adminuser/{admin}', [AdminController::class, 'editAdmin']);
            $router->post('/pagemanagephatuser/adminuser/{admin}', [AdminController::class, 'editAdmin']);
            $router->post('/pagemanagephatuser/adminuser/accupdate', [AdminController::class, 'updateAccess']);
            $router->post('/pagemanagephatuser/accadsys/accdel', [AdminController::class, 'delAccess']);
        }


        /* Admin logout */

        $router->post('/pagemanagephatuser/logout', [AdminController::class, 'logout']);


        /* admin myself profile edit */

        $router->get('/pagemanagephatuser/profile', [AdminController::class, 'editProfile']);
        $router->post('/pagemanagephatuser/profile', [AdminController::class, 'editProfile']);
        $router->get('/pagemanagephatuser/change', [AdminController::class, 'changePass']);
        $router->post('/pagemanagephatuser/change', [AdminController::class, 'changePass']);

        /* Request managment */

        $router->get('/pagemanagephatuser/requestlist', [SolicitudController::class, 'listRequest']);
        $router->get('/pagemanagephatuser/request/{id}', [SolicitudController::class, 'details']);
        $router->get('/pagemanagephatuser/orgrequestlist', [OrganizacionController::class, 'orgListRequest']);
        $router->get('/pagemanagephatuser/orgrequest/{id}', [OrganizacionController::class, 'orgRequestDetail']);
        $router->post('/pagemanagephatuser/orgrequest/stupdate', [OrganizacionController::class, 'statusUpdate']);
        $router->post('/pagemanagephatuser/orgrequest/noteupdate', [OrganizacionController::class, 'obsUpdate']);

        /* suggestions and claims managment */

        $router->get('/pagemanagephatuser/suggestion', [SolicitudController::class, 'suggestList']);
        $router->get('/pagemanagephatuser/suggestion/{id}', [SolicitudController::class, 'suggDetails']);
        $router->get('/pagemanagephatuser/claim', [SolicitudController::class, 'claimList']);
        $router->get('/pagemanagephatuser/claim/{id}', [SolicitudController::class, 'claimDetail']);
        $router->post('/pagemanagephatuser/claim/clupdate', [SolicitudController::class, 'clUpdateStatus']);
        $router->post('/pagemanagephatuser/claim/clnote', [SolicitudController::class, 'claimObs']);






        /* Org managment */

        $router->get('/pagemanagephatuser/createorg', [OrganizacionController::class, 'createOrg']);
        $router->post('/pagemanagephatuser/createorg', [OrganizacionController::class, 'createOrg']);
        $router->get('/upload/images/?{org?}', [OrganizacionController::class, 'uploadImgOrg']);
        $router->post('/upload/images', [OrganizacionController::class, 'uploadImgOrg']);
        $router->get('/pagemanagephatuser/org-preview', [OrganizacionController::class, 'orgPreview']);
        $router->get('/pagemanagephatuser/orglist', [OrganizacionController::class, 'orgList']);
        $router->get('/pagemanagephatuser/registeredorg', [OrganizacionController::class, 'registeredList']);
        $router->get('/pagemanagephatuser/org/{id}/{ong}', [OrganizacionController::class, 'editOrg']);
        $router->post('/pagemanagephatuser/org/{id}/{ong}', [OrganizacionController::class, 'editOrg']);
        $router->post('/pagemanagephatuser/org/delete', [OrganizacionController::class, 'deleteOng']);
        $router->post('/pagemanagephatuser/img/delete', [OrganizacionController::class, 'deleteImg']);


        /* Event managment */

        $router->get('/pagemanagephatuser/create-event', [EventoController::class, 'createEvent']);
        $router->post('/pagemanagephatuser/create-event', [EventoController::class, 'createEvent']);
        $router->get('/pagemanagephatuser/event-list', [EventoController::class, 'eventList']);
        $router->get('/pagemanagephatuser/event/{id}/{evename}', [EventoController::class, 'editEvent']);
        $router->post('/pagemanagephatuser/event/{id}/{evename}', [EventoController::class, 'editEvent']);
        $router->post('/pagemanagephatuser/event/delete', [EventoController::class, 'deleteEvent']);
    }



    try {
        $router->dispatch();
    } catch (RouteNotFoundException $e) {
        // It's 404!
        $router->getPublisher()->publish(new HtmlResponse(include_once __DIR__ . '/../views/layout/page404.php', 404));
    }

}


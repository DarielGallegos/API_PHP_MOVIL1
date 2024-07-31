<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require $_SERVER['DOCUMENT_ROOT'].'/API_PHP_MOVIL1/vendor/autoload.php';
use Jumbojett\OpenIDConnectClient;
use Jumbojett\OpenIDConnectClientException;

$oidc = new OpenIDConnectClient(
    'http://localhost:15000/realms/myRealm',
    'myClient',
    "sfnommVTNN0mJuxceDUVyCgQuoPGPk51"
); //constructor de la clase OpenIDConnectClient
$oidc->setTimeout(120); //Tiempo de espera para la respuesta del servidor
$oidc->setRedirectURL('http://localhost/API_PHP_MOVIL1/controllers/IDConnect.php'); //URL de redireccion
if(isset($_SERVER['REQUEST_METHOD'])){
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            try{
                $oidc->authenticate(); //Autentica en el provedor de servicio OpenID Connect he inicializa la sesion
                $tokens = $oidc->getAccessToken(); //Obtiene el token de acceso
                $name = $oidc->requestUserInfo('given_name'); //Obtiene el nombre del usuario
                $email = $oidc->requestUserInfo('email'); //Obtiene el email del usuario
                $arr = array('name' => $name, 'email' => $email, 'token' => $tokens, 'error'=>"" ,'status' => true); //Crea el arreglo de respuesta
                $_SESSION['token'] = $tokens; //Guarda el token en la sesion
                echo json_encode($arr);
            }catch(OpenIDConnectClientException $e){
                $err = array('name' => "", 'email'=> "", 'token'=> "", 'error' => $e->getMessage(), 'status' => false); //Crea el arreglo de error
                echo json_encode($err);
            }
            break;

        case 'POST':
            break;
    }
}

?>
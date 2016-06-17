<?php

use Lcobucci\JWT\Builder;

class UserController extends \Phalcon\Mvc\Controller {

    protected $success;
    protected $message;
    protected $data;
    protected $adClientId = "AF645935B14444CA8AD4A94FE6B2AF68"; // El ID Client para el grupo sekur
    protected $cluteLimaId = "26C51A26367B4E97BEE8C6EC6ECD6F8B";
    protected $sekurLimaId = "F4CC51B76C4147019B0B88923623FBE2";
    protected $cluteId = "A823605601994B658319133117D23344";
    protected $sekurId = "3D64A6C76D214C31B43C58B8FF84CE50";
    protected $usuario;
    protected $token;

    public function initialize() {
        $this->success = true;
        $this->message = "";
        $this->data = "";
        $this->usuario = new User("", "");
    }

    public function setResponse($success, $message, $data) {
        $this->response->setStatusCode(200, "OK");
        $this->response->setHeader("Content-Type", "application/json");
        $this->data = array("success" => $success, "message" => $message, "data" => $data);
        $this->response->setJsonContent($this->data);
    }

    public function indexAction() {
        
    }

    public function generarJWT() {
        $host = "http://" . $this->request->getServerName() . $this->request->getURI();
        $token = (new Builder())->setIssuer($host) // Configures the issuer (iss claim)
                ->setAudience('http://localhost/xxx') // Configures the audience (aud claim)
                ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim) expirará en 1 hora desde que se generó
                ->set('username', $this->usuario->get_username()) // Configures a new claim, called "username"
                ->set('password', $this->usuario->get_password()) // Configures a new claim, called "password"
                ->set('firstname',  $this->usuario->get_name())
                ->set('lastname',  $this->usuario->get_lastname())
                ->set('userId', $this->usuario->get_userId()) // Configures a new claim, called "userId"
                ->set('orgId', $this->usuario->get_orgId()) // Configures a new claim, called "orgId"
                ->set('orgName', $this->usuario->get_orgName()) // Configures a new claim, called "orgName"
                ->set('orgParentName',  $this->usuario->get_orgParentName())
                ->set('orgParentId', $this->usuario->get_orgParentId()) // Configures a new claim, called "orgParentId"
                ->set('adClientId', $this->usuario->get_adClientId()) // Configures a new claim, called "clientId"
                ->set('cBPartnerId',  $this->usuario->get_cBPartnerId())
                ->getToken(); // Retrieves the generated token


        $token->getHeaders(); // Retrieves the token headers
        $token->getClaims(); // Retrieves the token claims
//
//        echo $token->getHeader('jti'); // will print "4f1g23a12aa"
//        echo $token->getClaim('iss'); // will print "http://example.com"
//        echo $token->getClaim('uid'); // will print "1"
        //echo $token; // The string representation of the object is a JWT string (pretty easy, right?)
        //echo $token->getClaim('password'); 

        $this->token = $token;
    }

    public function verificarAction() {
        // Check if request has made with POST
        if ($this->request->isPost() == true) {
            // Obtenemos la _URL desde donde se realizó la llamada al API
            // http://localhost/xxx/login es en este ejemplo(siempre debe ser desde el login)
            $host = $this->request->getHTTPReferer();
            // Access POST data      
            try {
                $userName = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                // Encriptamos la contraseña con un alg. base64, previamente encriptada con un sha1 (el TRUE significa que será retornado un 
                // valor binario de longitud 20; si es false, entonces retornará un valor hexadecimal de longitud 40)
                $userPassword = base64_encode(sha1($password, TRUE));
                // Es un número 1 o 2 según el combo del cliente
                $userOrgId = $this->request->getPost("orgId"); 
                // Obtenemos la info de la ORG
                $org = $this->obtenerDatosOrgPadre(intval($userOrgId));
                // Cargamos el Serivio DB, que nos permititá acceder a la BD
                $db = $this->di->get('db');
                // Retornamos un objeto Usuario si existe o null si no existe en la BD
                $this->usuario = User::Load($db, $userName, $org['IdHija'], $this->adClientId);
                if (!is_null($this->usuario)) {
                    if ($this->usuario->get_password() == $userPassword) {
                        // La contraseña es correcta
                        // Establecemos los IDs de la Org Padre e Hija a las que pertenece el usuario
                        $this->usuario->set_orgId($org['IdHija']);
                        $this->usuario->set_orgParentId($org['IdPadre']);
                        $this->usuario->set_orgName($org['name']);
                        $this->usuario->set_orgParentName($org['orgParentName']);
                        // Generamos el JSON WEB TOKEN
                        $this->generarJWT();
                        // Enviamos la respuesta
                        $this->setResponse(true, "¡Datos Correctos!", "$this->token");
                    } else {
                        // La contraseña es incorrecta
                        $this->setResponse(FALSE, "¡Contraseña incorrecta!", NULL);
                    }
                } else {
                    // El usuario no existe
                    $this->setResponse(FALSE, "No existe el nombre de USUARIO.", NULL);
                }
                $this->response->send();
            } catch (Exception $ex) {
                $mess = $ex->getMessage() . PHP_EOL;
                $this->setResponse(FALSE, $mess, NULL);
                $this->response->send();
            }
        }
    }

    public function obtenerDatosOrgPadre($orgId) {
        $org = array("IdPadre" => "", "IdHija" => "");
        if ($orgId == 1) {
            $org['name'] = "CLUTE - Región Lima";
            $org['orgParentName'] = "CLUTE S.A.";
            $org['IdHija'] = $this->cluteLimaId;
            $org['IdPadre'] = $this->cluteId;
        }
        if ($orgId == 2) {
            $org['name'] = "SEKUR PERU - Región Lima"; 
            $org['orgParentName'] = "SEKUR PERU S.A."; 
            $org['IdHija'] = $this->sekurLimaId;
            $org['IdPadre'] = $this->sekurId;
        }

        return $org;
    }

}

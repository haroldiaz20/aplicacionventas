<?php

use Lcobucci\JWT\Builder;

class LocationController extends \Phalcon\Mvc\Controller {

    protected $token;

    public function initialize() {
        $this->token = "";
    }

    public function indexAction() {
        
    }

    public function getToken() {
        $jwt = $this->request->getQuery("authToken");
        /**
         * ¡¡¡IMPORTANTE!!!
         * Quitar las dos comillas del string (con este método: str_replace) que se pasa a través de la URL. 
         * Si las quitamos manualmente, probablemente nos arroje un error.
         */
        $jwt = str_replace("\"", "", $jwt);
        /*
         * Obtenemos el JWT desde un string
         */
        $this->token = (new Parser())->parse((string) $jwt);  // Parses from a string
        $this->token->getHeaders(); // Retrieves the token header
        $this->token->getClaims(); // Retrieves the token claims
    }

    public function setResponse($success, $message, $data) {
        $this->response->setStatusCode(200, "OK");
        $this->response->setHeader("Content-Type", "application/json");
        $this->data = array("success" => $success, "message" => $message, "data" => $data);
        $this->response->setJsonContent($this->data);
    }

    public function listarPaises() {
        // Cargamos el Serivio DB, que nos permititá acceder a la BD
        $db = $this->di->get('db');
        $paises = Location::LoadCountries($db);

        return $paises;
    }

    public function listarRegiones($codigoPais) {
        $db = $this->di->get('db');
        $regiones = Location::LoadRegionsByIdCountry($db, $codigoPais);

        return $regiones;
    }

    public function paisesAction() {
        try {
            $paises = $this->listarPaises();

            $this->setResponse(true, "Países listados correctamente", $paises);
            $this->response->send();
        } catch (Exception $ex) {
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
    }

    public function regionesAction($codigoPais) {
        try {

            $regiones = $this->listarRegiones($codigoPais);
            if (is_null($regiones)) {
                $this->setResponse(false, "No se encontraron regiones para este país", null);
            } else {
                $this->setResponse(true, "Regiones listadas correctamente", $regiones);
            }
            $this->response->send();
        } catch (Exception $ex) {
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
    }

}

<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class ProductController extends \Phalcon\Mvc\Controller {

    protected $data;
    protected $token;
    public $pricelistIdSO_clute = "DF_PLDS_SO_CLUTE";
    public $pricelistIdSO_sekur = "DF_PLDS_SO_SEKUR";

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

    public function consultar($value) {

        try {
            /**
             * Obtenemos la información de JWT
             */
            $this->getToken();
            /**
             * Obtenemos los claims necesarios del JWT
             */
            $ad_client_id = $this->token->getClaim("adClientId");
            $ad_org_id = $this->token->getClaim("orgId");
            $org_name = $this->token->getClaim("orgName");

            /**
             * Obtenemos los parámetros desde la URL.
             */
            $currency_id = $this->request->getQuery("currency");
            $m_pricelist_id = $this->getPriceList($currency_id, $org_name);
            $m_warehouse_id = $this->request->getQuery("warehouse");

            //echo $value."<br>";
            //echo $m_warehouse_id;
            //return;

            /**
             * Obtenemos la instancia DB desdel el sevicio DI
             */
            $db = $this->di->get('db');
            $product = Product::Load($db, $value, $ad_client_id, $m_pricelist_id, $m_warehouse_id, $ad_org_id);
            
            if(is_null($product)){
                
                $this->setResponse(false, "No se encontró el producto especificado", $product);
            }else{
                unset($product->db);
                $this->setResponse(true, "Producto encontrado", $product);
            }
            $this->response->send();
        } catch (Exception $ex) {
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
    }

    public function getPriceList($currencyId, $orgName) {
        //  HALLAMOS EL PRICELIST //
        $pricelistIdSO_clute = "DF_PLDS_SO_CLUTE";
        $pricelistIdSO_sekur = "DF_PLDS_SO_SEKUR";

        $pricelist = "";
        if (strpos($orgName, 'CLUTE') !== FALSE) {
            $pricelist .= $this->pricelistIdSO_clute;
        }
        if (strpos($orgName, 'SEKUR') !== false) {
            $pricelist .= $this->pricelistIdSO_sekur;
        }

        if ($currencyId == 100) {
            $pricelist .= "USD";
        }
        if ($currencyId == 308) {
            $pricelist .= "PEN";
        }
        return $pricelist;
    }

}

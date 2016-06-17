<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class ClienteController extends \Phalcon\Mvc\Controller {

    protected $data;
    protected $token;
    public $pricelistIdSO_clute = "DF_PLDS_SO_CLUTE";
    public $pricelistIdSO_sekur = "DF_PLDS_SO_SEKUR";
    public $objLocation = null;
    public $objClient = null;
    public $objClientLocation = null;

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

    public function consultar($taxid) {
        try {
            /**
             * Obtenemos la información de JWT
             */
            $this->getToken();
            /**
             * Obtenemos los claims necesarios del JWT
             */
            $salesrep_id = $this->token->getClaim("cBPartnerId");
            /*
             * Obtenemos la instancia de la BD del servicio DI
             */
            $db = $this->di->get('db');
            $client = Cliente::Load($db, $taxid);

            if (is_null($client)) {
                $this->setResponse(false, "No se encontró el cliente especificado", null);
            } else {
                $idVendedorCliente = $client->get_salesrep_id();
                if ($idVendedorCliente != $salesrep_id) {
                    $message = "Este cliente ha sido registrado por otro vendedor.\nNo puede registrar una orden para este cliente";
                    $this->setResponse(false, $message, null);
                } else {
                    //OBTENEMOS LA INFORMACIÓN DEL CLIENTELOCATION
                    $clienteLocation = $this->obtainClienteLocationInfo($client->get_c_bpartner_id());
                    // COMPLETAMOS LOS CAMPOS CON LA INFORACIÓN DE LA UBICACIÓN DEL CLIENTE
                    $objLocation = $this->obtainLocationInfo($clienteLocation->getC_location_id());
                    // Preparamos el objeto antes de enviarlo
                    $objCliente = $this->prepareResponseToSend($client, $objLocation, $clienteLocation);
                    $this->setResponse(true, "¡Cliente encontrado!", $objCliente);
                }
            }
            $this->response->send();
        } catch (Exception $ex) {
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
    }

    /**
     * Nos permitirá obtener la información de la ubicación asociada a un cliente según su ID
     * @param string $c_location_id Es el Id único de la ubicación registrada para este cliente
     */
    public function obtainLocationInfo($c_location_id) {
        $db = $this->di->get('db');
        $objLocation = Location::Load($db, $c_location_id);
        if (is_null($objLocation)) {
            return null;
        } else {
            return $objLocation;
        }
    }

    /**
     * Este método nos permitirá obtener la información de la dirección asociada a un cliente específico.
     * @param string $c_bpartner_id <p>La búsqueda de la dirección se hará con el id único del cliente.</p>
     * @return string Devuelve el ID de la tabla c_bpartner_location
     */
    public function obtainClienteLocationInfo($c_bpartner_id) {
        $db = $this->di->get('db');
        $objClientLocation = ClientLocation::LoadByCBPartnerId($db, $c_bpartner_id);
        if (is_null($objClientLocation)) {
            return null;
        } else {
            return $objClientLocation;
        }
    }

    /**
     * This function returns an array of information formated to be shared with the client application.
     * @param Cliente $objCliente contains the main information about the client
     * @param Location $location containt the information about the client's location
     * @return array Client information formated in order to be sent to the client.
     */
    public function prepareResponseToSend(Cliente $objCliente, Location $location, ClientLocation $clienteLocation) {
        $cliente = array(
            "name" => $objCliente->get_name(),
            "value" => $objCliente->get_value(),
            "cBPartnerId" => $objCliente->get_c_bpartner_id(),
            "taxid" => $objCliente->get_taxid(),
            "cBPartnerLocationId" => $clienteLocation->getC_bpartner_location_id(),
            "address" => $location
        );
        return $cliente;
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

    public function find_payment_method_id($paymentMethodId) {
        $invoiceCtrl = new InvoiceController();
        $idMethod = $invoiceCtrl->obtenerMetodoDePago($paymentMethodId);
        return $idMethod;
    }

    public function find_scr_combo_item($doctype_id) {
        $invoiceCtrl = new InvoiceController();
        $comboItem = $invoiceCtrl->obtenerComboItem($doctype_id);
        return $comboItem;
    }

    public function saveClient($db) {
        /**
         * Obtenemos los claims necesarios del JWT
         */
        $ad_client_id = $this->token->getClaim("adClientId");
        $ad_org_id = $this->token->getClaim("orgId");
        $ad_user_id = $this->token->getClaim("userId");
        $sales_rep_id = $this->token->getClaim("cBPartnerId");
        $orgName = $this->token->getClaim("orgName");

        /*
         * Obtenemos los parámetros enviados por POST para ser guardados en la BD
         */
        $identificador = $this->request->getPost('identificador');
        $name = $this->request->getPost('nombreComercial');
        $taxid = $this->request->getPost('taxid');
        $payment_term_id = $this->request->getPost('payment_term_id');
        $moneda_id = $this->request->getPost('currency_id');
        $priceList = $this->getPricelist($moneda_id, $orgName);
        $payment_method_em = $this->request->getPost('payment_method_id');
        $doctype_id = $this->request->getPost('doctype_id');
        $payment_method_id = $this->find_payment_method_id($payment_method_em);
        $em_scr_combo_item = $doctype_id; //$this->find_scr_combo_item($doctype_id);

        /*
         * Creamos una nueva instancia de la clase Cliente
         */
        $this->objClient = new Cliente();
        $this->objClient->set_ad_client_id($ad_client_id);
        $this->objClient->set_ad_org_id($ad_org_id);
        $this->objClient->set_createdby($ad_user_id);
        $this->objClient->set_updatedby($ad_user_id);
        $this->objClient->set_value(trim($identificador));
        $this->objClient->set_name(trim($name));
        $this->objClient->set_taxid(trim($taxid));
        $this->objClient->set_c_paymentterm_id($payment_term_id);
        $this->objClient->set_m_pricelist_id($priceList);
        $this->objClient->set_fin_paymentmethod_id($payment_method_id);
        $this->objClient->set_em_scr_combo_item_id($em_scr_combo_item);
        $this->objClient->set_salesrep_id($sales_rep_id);
        /*
         * Guardamos el objeto Cliente
         */
        $response = $this->objClient->Save($db);
        return $response;
    }

    public function saveLocation($db) {
        /**
         * Obtenemos los claims necesarios del JWT
         */
        $ad_client_id = $this->token->getClaim("adClientId");
        $ad_org_id = $this->token->getClaim("orgId");
        $ad_user_id = $this->token->getClaim("userId");

        /*
         * Obtenemos los parámetros enviados por POST para ser guardados en la BD
         */
        $linea1 = $this->request->getPost('line1');
        $linea2 = $this->request->getPost('line2');
        $city = $this->request->getPost('city');
        $countryName = $this->request->getPost('countryName');
        $countryId = $this->request->getPost('countryId');
        $regionName = $this->request->getPost('regionName');
        $regionId = $this->request->getPost('regionId');
        $postal = $this->request->getPost('postal');

        /*
         * Instanciamos un objeto Location
         */
        $this->objLocation = new Location();
        $this->objLocation->setAd_client_id($ad_client_id);
        $this->objLocation->setAd_org_id($ad_org_id);
        $this->objLocation->setCreatedby($ad_user_id);
        $this->objLocation->setUpdatedby($ad_user_id);
        $this->objLocation->setAddress1($linea1);
        $this->objLocation->setAddress2($linea2);
        $this->objLocation->setCity(trim($city));
        $this->objLocation->setNombrePais($countryName);
        $this->objLocation->setC_country_id($countryId);
        $this->objLocation->setNombreRegion($regionName);
        $this->objLocation->setC_region_id($regionId);
        $this->objLocation->setPostal($postal);
        /*
         * Guardamos el objeto Location
         */
        $response = $this->objLocation->SaveLocation($db);
        return $response;
    }

    public function saveClientLocation($db) {
        /**
         * Obtenemos los claims necesarios del JWT
         */
        $ad_client_id = $this->token->getClaim("adClientId");
        $ad_org_id = $this->token->getClaim("orgId");
        $ad_user_id = $this->token->getClaim("userId");
        /*
         * Obtenemos los parámetros enviados por POST para ser guardados en la BD
         */
        $linea1 = $this->request->getPost('line1');
        $linea2 = $this->request->getPost('line2');
        $address = $linea1 . "; " . $linea2;

        /*
         * Instanciamos un objeto de la clase ClientLocation
         */
        $this->objClientLocation = new ClientLocation();
        $this->objClientLocation->setAd_client_id($ad_client_id);
        $this->objClientLocation->setAd_org_id($ad_org_id);
        $this->objClientLocation->setCreatedby($ad_user_id);
        $this->objClientLocation->setUpdatedby($ad_user_id);
        $this->objClientLocation->setName($linea1);
        $this->objClientLocation->setC_bpartner_id($this->objClient->get_c_bpartner_id());
        $this->objClientLocation->setC_location_id($this->objLocation->getC_location_id());
        /*
         * Guardamos el objeto ClientLocation
         */
        $success = $this->objClientLocation->SaveClienteLocation($db);
        return $success;
    }

    public function save() {
        /*
         * Obtenemos la instancia de la BD del servicio DI
         */
        $db = $this->di->get('db');
        try {
            /**
             * Obtenemos la información de JWT
             */
            $this->getToken();

            //////////////////// INICIAMOS LA TRANSACCION /////////////////
            $db->begin();

            $response = $this->saveClient($db);
            if ($response == true || $response == 1) {
                // If response is true we procede to store its location
                $resp2 = $this->saveLocation($db);
                if ($resp2 == true || $resp2 == 1) {
                    $resp3 = $this->saveClientLocation($db);
                    if ($resp3 == true || $resp3 == 1) {
                        $clientFinal = $this->prepareResponseToSend($this->objClient, $this->objLocation);
                        $this->setResponse($resp2, "Cliente guardado correctamente", $clientFinal);
                    } else {
                        $this->setResponse($resp2, "No se pudo guardar el objeto ClienteLocation", null);
                    }
                } else {
                    $this->setResponse($resp2, "No se pudo guardar la dirección del cliente", null);
                }
            } else {
                $this->setResponse($response, "No se pudo guardar este cliente", null);
            }

            /////// SI TODO SALIÓ BIEN HACEMOS UN COMMIT A LA TRANSACCIÓN ////////////////////
            $db->commit();
            $this->response->send();
        } catch (Exception $ex) {
            ///////////// SI TODO SALIÓ MAL HACEMOS UN ROLLBACK A LA TRANSACCIÓN ////////////////////
            $db->rollback();
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, "Hubo un error: " . $mess, NULL);
            $this->response->send();
        }
    }

}

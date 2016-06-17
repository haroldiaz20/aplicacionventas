<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class InvoiceController extends \Phalcon\Mvc\Controller {

    protected $data;
    protected $invoice;
    protected $token;

    public function indexAction() {
        
    }

    public function setResponse($success, $message, $data) {
        $this->response->setStatusCode(200, "OK");
        $this->response->setHeader("Content-Type", "application/json");
        $this->data = array("success" => $success, "message" => $message, "data" => $data);
        $this->response->setJsonContent($this->data);
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

    public function newInvoice() {
        //if ($this->request->isPost() == true) {
        try {
            // Obtenemos la información de JWT
            $this->getToken();
            // Obtenemos los claims necesarios del JWT
            $orgName = $this->token->getClaim("orgName");
            $orgParentId = $this->token->getClaim("orgParentId");
            // Cargamos el servicio DB desde el bi
            $db = $this->di->get('db');
            //Creamos un nuevo objeto Invoice
            $this->invoice = new Invoice($db);
            $documento = $this->invoice->generarNumeroDocumento($orgParentId);
            $almacenes = $this->obtenerAlmacenes($orgName);
            $monedas = $this->obtenerMonedas();
            $fechaInvoice = date("d/m/Y", strtotime("now"));
            $pedidoGenerar = $this->obtenerPedidoAGenerar();
            $formasPago = $this->obtenerFormasPago();
            $tiposPedido = $this->obtenerTiposPedido();
            $tiposEntrega = $this->obtenerTiposEntrega();
            $org = $this->obtenerOrgInfo();
            $vendor = $this->obtenerVendorInfo();
            $paises = $this->obtenerPaises();
            $tiposDocumento = $this->obtenerTiposDocumento();
            // Invoice Final
            $invoiceFinal = array("org" => $org, "vendor" => $vendor, "fecha" => $fechaInvoice, "documento" => $documento, "almacenes" => $almacenes, "monedas" => $monedas, "pedidosGenerar" => $pedidoGenerar, "formasPago" => $formasPago, "tiposPedido" => $tiposPedido, "tiposEntrega" => $tiposEntrega, "paises" => $paises, "tiposDocumento" => $tiposDocumento);
            // Pasamos los valores al objeto Response
            $this->setResponse(TRUE, "Información cargada correctamente", $invoiceFinal);
            // Enviamos la respuesta
            $this->response->send();
        } catch (Exception $ex) {
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
        //}
    }

    public function obtenerTiposDocumento() {
        $adClientId = $this->token->getClaim("adClientId");
        $db = $this->di->get('db');
        $tiposDocumento = Invoice::ListarTiposDocumentoIdent($db, $adClientId);
        return $tiposDocumento;
    }

    public function obtenerOrgInfo() {
        $orgName = $this->token->getClaim("orgName");
        $orgId = $this->token->getClaim("orgId");
        $org = array("name" => $orgName, "orgId" => $orgId);
        return $org;
    }

    public function obtenerVendorInfo() {
        $vendorName = $this->token->getClaim("firstname") . " " . $this->token->getClaim("lastname");
        $vendorId = $this->token->getClaim("cBPartnerId");
        $vendor = array("fullName" => $vendorName, "cBPartnerId" => $vendorId);
        return $vendor;
    }

    public function obtenerPaises() {
        $paisCtrl = new LocationController();
        $paises = $paisCtrl->listarPaises();
        return $paises;
    }

    public function obtenerPedidoAGenerar() {
        $pedidoGenerar = array(array("name" => 'Orden de venta', "value" => 100));
        return $pedidoGenerar;
    }

    public function obtenerMonedas() {
        $arrayMonedas = array(
            array("name" => "Nuevo sol peruano", "value" => 308, "id" => 308),
            array("name" => "Dólar EE.UU.", "value" => 100, "id" => 100));

        return $arrayMonedas;
    }

    public function obtenerAlmacenes($orgName) {

        $almacen1 = array();
        $almacen2 = array();
        if (substr($orgName, 0, 1) == 'S') {
            $almacen1 = array("name" => 'SEKUR ALM. VENTAS LIMA - CORPAC', "value" => 'ALMSK-10');
            $almacen2 = array("name" => 'SEKUR ALM. VENTAS LIMA - VILLA SALVADOR', "value" => 'ALMSK-39');
        }

        if (substr($orgName, 0, 1) == 'C') {
            $almacen1 = array("name" => 'CLUTE ALM. VENTAS LIMA - CORPAC', "value" => 'E1C746F36C0949F4937AE0BA0C0F24C2');
            $almacen2 = array("name" => 'CLUTE ALM. VENTAS LIMA - VILLA SALVADOR', "value" => 'D20A89FC323B4514AB5F54908778EDE4');
        }

        $arrayAlmacenes = array($almacen1, $almacen2);
        return $arrayAlmacenes;
    }

    public function obtenerNroDocumento() {
        // Cargamos el control
        $db = $this->di->get('db');
        $invoice = new Invoice($db);
        // Generamos el Nro. del documento basándonos en el ID de la ORG Padre
        $document = $invoice->generarNumeroDocumento("3D64A6C76D214C31B43C58B8FF84CE50");
        $this->setResponse(true, "Nro. de documento cargado correctamente", $document);
        if (!is_null($document) && !empty($document)) {
            $this->setResponse(true, "Nro. de documento cargado correctamente", $document);
        } else {
            $this->setResponse(false, "No se pudo cargar el Nro. de documento", null);
        }
        $this->response->send();
    }

    public function obtenerFormasPago() {
        $array0 = array("name" => "CHEQUE", "value" => "SCOCHECK");
        $array1 = array("name" => "Depósito en cuenta", "value" => "SCODEPOSIT");
        $array2 = array("name" => "Crédito", "value" => "SCOCREDIT");
        $array3 = array("name" => "Transferencia Bancaria", "value" => "SCOWIRETRANSFER");
        $array4 = array("name" => "Efectivo", "value" => "SCOCASH");
        $array5 = array("name" => "Letra", "value" => "SCOBILLOFEXCHANGE");
        $array6 = array("name" => "Sin definir", "value" => "SCONOTDEFINED");

        $arrayPayment = array($array0, $array1, $array2, $array3, $array4, $array5, $array6);
        return $arrayPayment;
    }

    public function listarNroDias($codigo) {
        $db = $this->di->get('db');
        $arrayNroDias = Invoice::ListarNroDias($db, $codigo);

        if (!is_null($arrayNroDias)) {
            // Pasamos los valores al objeto Response
            $this->setResponse(TRUE, "Información cargada correctamente", $arrayNroDias);
            // Enviamos la respuesta
            $this->response->send();
        } else {
            // Pasamos los valores al objeto Response
            $this->setResponse(false, "No se encontró la información solicitada", null);
            // Enviamos la respuesta
            $this->response->send();
        }
    }

    public function obtenerTiposPedido() {
        $tipos = array(
            array(
                'value' => 'facturadeventa', 'name' => 'Factura de venta'),
            array('value' => 'boletadeventa', 'name' => 'Boleta de venta')
        );

        return $tipos;
    }

    public function obtenerTiposEntrega() {
        $tiposEntrega = array(
            array('value' => 'D', 'name' => 'DESPACHO (CON GUÍA)')
        );
        return $tiposEntrega;
    }

    public function obtenerMetodoDePago($paymentMethod) {
        // Cargamos el servicio DB desde el bi
        $db = $this->di->get('db');
        $finPaymentM = Invoice::FindPaymentMethodByValue($db, $paymentMethod);
        return $finPaymentM;
    }

    public function obtenerComboItem($doctypeId) {
        // Cargamos el servicio DB desde el bi
        $db = $this->di->get('db');
        $comboItemId = Invoice::FindScrComboItemByValue($db, $doctypeId);
        return $comboItemId;
    }
    
    protected function getPriceList($currencyId, $orgName) {
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

            /**
             * Obtenemos los claims necesarios del JWT
             */
            $ad_client_id = $this->token->getClaim("adClientId");
            $ad_org_id = $this->token->getClaim("orgId");
            $orgParentId = $this->token->getClaim("orgParentId");
            $ad_user_id = $this->token->getClaim("userId");
            $org_name = $this->token->getClaim("orgName");
            $sales_rep_id = $this->token->getClaim("cBPartnerId");
            /*
             * Receive information about the ORDER from the JSON input
             */
            $data = json_decode(file_get_contents('php://input'), false);

            //////////////////// INICIAMOS LA TRANSACCION /////////////////
            $db->begin();
            $objOrder = new Order();
            $objOrder->set_ad_client_id($ad_client_id);
            $objOrder->set_ad_org_id($ad_org_id);
            $objOrder->set_createdby($ad_user_id);
            $objOrder->set_updatedby($ad_user_id);
            $objOrder->set_documentno($data->documento->documentNo);
            // c_doctype_id
            $c_doctypetarget_id = Invoice::FindCDoctypeIdByOrgParentId($db, $orgParentId);
            $objOrder->set_c_doctypetarget_id($c_doctypetarget_id);
            //////////////////
            $objOrder->set_salesrep_id($sales_rep_id);
            /// date promised
            $datePromised = date('Y-m-d 00:00:00', strtotime($data->fechaEnvio));
            $objOrder->set_datepromised($datePromised);
            ////////////////////
            $objOrder->set_c_bpartner_id($data->cliente->id);
            $objOrder->set_c_bpartner_location_id($data->cliente->clienteAddressId);
            $objOrder->set_c_currency_id($data->moneda->value);
            $objOrder->set_c_paymentterm_id($data->nroDias->value);
            $objOrder->set_m_warehouse_id($data->almacen->value);
            // pricelist
            $m_pricelist_id = $this->getPriceList($data->moneda->value, $org_name);
            $objOrder->set_m_pricelist_id($m_pricelist_id);
            ///////////////
            $objOrder->set_delivery_location_id($data->cliente->address->id);
            // fin_paymentmethod_id
            $fin_paymentmethod_id = $this->obtenerMetodoDePago($data->formaPago->value);
            $objOrder->set_fin_paymentmethod_id($fin_paymentmethod_id);
            
            $objOrder->SaveOrder();


//            $orderlines = $objOrder->get_arrayOrderline();
//            foreach ($orderlines as $orderline) {
//                $objOrderline = new Orderline();
//                $objOrderline->SaveOrderline();
//            }

            /////// SI TODO SALIÓ BIEN HACEMOS UN COMMIT A LA TRANSACCIÓN ////////////////////
            $db->commit();
            $this->response->send();
        } catch (Exception $ex) {

            ///////////// SI TODO SALIÓ MAL HACEMOS UN ROLLBACK A LA TRANSACCIÓN ////////////////////
            $db->rollback();
            $mess = $ex->getMessage() . PHP_EOL;
            $this->setResponse(FALSE, $mess, NULL);
            $this->response->send();
        }
    }

}

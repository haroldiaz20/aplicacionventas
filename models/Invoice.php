<?php

/**
 * Description of Invoice
 * @author Harold
 */
class Invoice {

    public $invoiceId;
    public $documentoNo;
    public $orgId;
    public $createdBy;
    public $db;

    public function __construct($db) {
        // Database Adapter que nos permitirá hacer consultas usando Phalcon
        $this->db = $db;
        $this->invoiceId = strtoupper(md5(uniqid()));
        $this->documentoNo = "";
        $this->orgId = "";
        $this->createdBy = "";
    }

    /**
     * Esta función nos devolverá información sobre el Nro de documento actual, el adsecuence y el número de documento siguiente.
     * @param string $orgParentId
     * @return array $data Devuelve un array que contiene información sobre el documentNo, adSecuence y el nextDocumentNo
     * @return NULL Devuelve NULL en caso no haya encontrado nada.
     */
    public function generarNumeroDocumento($orgParentId) {
        $docNumber = "";
        $ad_sequence = "";
        $nextDocumentNo = "";
        // Query para obtener el número de documento de la Factura
        $query = "select d.c_doctype_id, d.docnosequence_id,s.currentnext,s.prefix,s.suffix,s.incrementno from c_doctype d inner join ad_sequence s on d.docnosequence_id = s.ad_sequence_id where d.em_sco_specialdoctype = 'SSASTANDARDORDER' and d.ad_org_id='$orgParentId'";

//        return $query;

        $result_set = $this->db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            // $result_set es un array con múltiples filas, pero solo tomaremos la primera, es decir la fila [0]
            $rs = $result_set[0];
            $ad_sequence = $rs['docnosequence_id'];
            $nextDocumentNo = (int) $rs['currentnext'] + (int) $rs['incrementno'];
            if ($rs['prefix'] != null) {
                $docNumber.= $rs['prefix'];
            }
            $docNumber.= $rs['currentnext'];
            if ($rs['suffix'] != null) {
                $docNumber .= $rs['suffix'];
            }
            $data = array("documentNo" => $docNumber, "adSequence" => $ad_sequence, "nextDocumentNo" => $nextDocumentNo);
            return $data;
        } else {
            return NULL;
        }
    }

    public static function ListarTiposDocumentoIdent($db, $adClientId) {

        $query = "select scr_combo_item_id,name from SCR_Combo_Item where SCR_Combo_Category_ID=(SELECT scr_combo_category_id FROM scr_combo_category where value='Tipo de Documento de Identidad' AND ad_client_id='$adClientId' limit 1) and ad_client_id='$adClientId'";

        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $data = array();
            foreach ($result_set as $rs) {
                $data[] = array("value" => $rs["scr_combo_item_id"], "name" => $rs["name"]);
            }
            return $data;
        } else {
            return null;
        }
    }

    public static function ListarNroDias($db, $codigo) {
        $specialMethod = $codigo;
        $query = " select c_paymentterm_id, name from c_paymentterm where ((COALESCE('$specialMethod','.')='SCOBILLOFEXCHANGE') OR (COALESCE('$specialMethod','.')<>'SCOBILLOFEXCHANGE') AND (em_sco_isboeterm<>'Y' OR em_sco_isboeterm IS NULL))";

        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $data = array();
            foreach ($result_set as $rs) {
                $data[] = array("name" => $rs['name'], "value" => $rs['c_paymentterm_id']);
            }
            return $data;
        } else {
            return null;
        }
    }

    public static function FindScrComboItemByValue($db, $val) {

        $query = "SELECT scr_combo_item_id from scr_combo_item WHERE value='$val';";
        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);
        echo $query;
        if (count($result_set) > 0) {
            // Obtenemos la primera fila del result set
            $rs = $result_set[0];
            $comboItemId = $rs['scr_combo_item_id'];
            return $comboItemId;
        } else {
            return null;
        }
    }

    public static function FindPaymentMethodByValue($db, $val) {

        $query = "select fin_paymentmethod_id, ad_client_id,em_sco_specialmethod from fin_paymentmethod where em_sco_specialmethod = '$val';";
        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            // Obtenemos la primera fila del result set
            $rs = $result_set[0];
            $payment_method_id = $rs['fin_paymentmethod_id'];
            return $payment_method_id;
        } else {
            return null;
        }
    }

    public static function FindCDoctypeIdByOrgParentId($db, $adOrgId) {
        $query = "SELECT c_doctype_id from c_doctype WHERE ad_org_id='$adOrgId' AND em_sco_specialdoctype='SSASTANDARDORDER'";
        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            // Obtenemos la primera fila del result set
            $rs = $result_set[0];
            $c_doctype_id = $rs['c_doctype_id'];
            return $c_doctype_id;
        } else {
            return null;
        }
    }

}

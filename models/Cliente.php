<?php

class Cliente {

    public $c_bpartner_id;
    public $ad_client_id;
    public $ad_org_id;
    public $isactive;
    public $created;
    public $createdby;
    public $updated;
    public $updatedby;
    public $value;
    public $name;
    public $name2;
    public $description;
    public $issummary;
    public $c_bp_group_id;
    public $isonetime;
    public $isprospect;
    public $isvendor;
    public $iscustomer;
    public $isemployee;
    public $issalesrep;
    public $taxid;
    public $istaxexempt;
    public $paymentrule;
    public $so_creditlimit;
    public $so_creditused;
    public $c_paymentterm_id;
    public $m_pricelist_id;
    public $isdiscountprinted;
    public $invoicerule;
    public $socreditstatus;
    public $showpriceinorder;
    public $invoicegrouping;
    public $isworker;
    public $fin_paymentmethod_id;
    public $fin_financial_account_id;
    public $customer_blocking;
    public $vendor_blocking;
    public $so_payment_blocking;
    public $po_payment_blocking;
    public $so_invoice_blocking;
    public $po_invoice_blocking;
    public $so_order_blocking;
    public $po_order_blocking;
    public $so_goods_blocking;
    public $po_goods_blocking;
    public $iscashvat;
    public $em_sco_hasGoodRep;
    public $em_sco_retencionAgent;
    public $em_sco_percepcionAgent;
    public $em_sco_aval_id;
    public $em_scr_combo_item_id;
    public $salesrep_id;

    /**
     * Variables estÃ¡ticas
     */
    const cbGroupId = '15AD9F024A04467D81A9F0599C26C22A'; // valor por defecto del CBGroupID
    const paymentRule = '4';
    const creditLimit = 0.00;
    const creditUsed = 0.00;
    const invoiceGrouping = '000000000000000';

    public function __construct() {
        $this->c_bpartner_id = strtoupper(md5(uniqid()));
        $this->ad_client_id = '';
        $this->ad_org_id = '';
        $this->isactive = 'Y';
        $this->created = 'localtimestamp(3)';
        $this->createdby = '';
        $this->updated = 'localtimestamp(3)';
        $this->updatedby = '';
        $this->value = '';
        $this->name = '';
        $this->name2 = '';
        $this->description = '';
        $this->issummary = 'N';
        $this->c_bp_group_id = Cliente::cbGroupId;
        $this->isonetime = 'N';
        $this->isprospect = 'N';
        $this->isvendor = 'N';
        $this->iscustomer = 'Y';
        $this->isemployee = 'N';
        $this->issalesrep = 'N';
        $this->taxid = '';
        $this->istaxexempt = 'N';
        $this->paymentrule = Cliente::paymentRule;
        $this->so_creditlimit = Cliente::creditLimit;
        $this->so_creditused = Cliente::creditUsed;
        $this->c_paymentterm_id = '';
        $this->m_pricelist_id = '';
        $this->isdiscountprinted = 'N';
        $this->invoicerule = 'I';
        $this->socreditstatus = 'O';
        $this->showpriceinorder = 'Y';
        $this->invoicegrouping = Cliente::invoiceGrouping;
        $this->isworker = 'N';
        $this->fin_paymentmethod_id = '';
        $this->fin_financial_account_id = 'NULL';
        $this->customer_blocking = 'N';
        $this->vendor_blocking = 'N';
        $this->so_payment_blocking = 'N';
        $this->po_payment_blocking = 'Y';
        $this->so_invoice_blocking = 'Y';
        $this->po_invoice_blocking = 'Y';
        $this->so_order_blocking = 'Y';
        $this->po_order_blocking = 'Y';
        $this->so_goods_blocking = 'Y';
        $this->po_goods_blocking = 'N';
        $this->iscashvat = 'N';
        $this->em_sco_hasGoodRep = 'N';
        $this->em_sco_retencionAgent = 'N';
        $this->em_sco_percepcionAgent = 'N';
        $this->em_sco_aval_id = 'NULL';
        $this->em_scr_combo_item_id = '';
        $this->salesrep_id = '';
    }

    public function get_c_bpartner_id() {
        return $this->c_bpartner_id;
    }

    public function get_ad_client_id() {
        return $this->ad_client_id;
    }

    public function get_ad_org_id() {
        return $this->ad_org_id;
    }

    public function get_isactive() {
        return $this->isactive;
    }

    public function get_created() {
        return $this->created;
    }

    public function get_createdby() {
        return $this->createdby;
    }

    public function get_updated() {
        return $this->updated;
    }

    public function get_updatedby() {
        return $this->updatedby;
    }

    public function get_value() {
        return $this->value;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_name2() {
        return $this->name2;
    }

    public function get_description() {
        return $this->description;
    }

    public function get_issummary() {
        return $this->issummary;
    }

    public function get_c_bp_group_id() {
        return $this->c_bp_group_id;
    }

    public function get_isonetime() {
        return $this->isonetime;
    }

    public function get_isprospect() {
        return $this->isprospect;
    }

    public function get_isvendor() {
        return $this->isvendor;
    }

    public function get_iscustomer() {
        return $this->iscustomer;
    }

    public function get_isemployee() {
        return $this->isemployee;
    }

    public function get_issalesrep() {
        return $this->issalesrep;
    }

    public function get_taxid() {
        return $this->taxid;
    }

    public function get_istaxexempt() {
        return $this->istaxexempt;
    }

    public function get_paymentrule() {
        return $this->paymentrule;
    }

    public function get_so_creditlimit() {
        return $this->so_creditlimit;
    }

    public function get_so_creditused() {
        return $this->so_creditused;
    }

    public function get_c_paymentterm_id() {
        return $this->c_paymentterm_id;
    }

    public function get_m_pricelist_id() {
        return $this->m_pricelist_id;
    }

    public function get_isdiscountprinted() {
        return $this->isdiscountprinted;
    }

    public function get_invoicerule() {
        return $this->invoicerule;
    }

    public function get_socreditstatus() {
        return $this->socreditstatus;
    }

    public function get_showpriceinorder() {
        return $this->showpriceinorder;
    }

    public function get_invoicegrouping() {
        return $this->invoicegrouping;
    }

    public function get_isworker() {
        return $this->isworker;
    }

    public function get_fin_paymentmethod_id() {
        return $this->fin_paymentmethod_id;
    }

    public function get_fin_financial_account_id() {
        return $this->fin_financial_account_id;
    }

    public function get_customer_blocking() {
        return $this->customer_blocking;
    }

    public function get_vendor_blocking() {
        return $this->vendor_blocking;
    }

    public function get_so_payment_blocking() {
        return $this->so_payment_blocking;
    }

    public function get_po_payment_blocking() {
        return $this->po_payment_blocking;
    }

    public function get_so_invoice_blocking() {
        return $this->so_invoice_blocking;
    }

    public function get_po_invoice_blocking() {
        return $this->po_invoice_blocking;
    }

    public function get_so_order_blocking() {
        return $this->so_order_blocking;
    }

    public function get_po_order_blocking() {
        return $this->po_order_blocking;
    }

    public function get_so_goods_blocking() {
        return $this->so_goods_blocking;
    }

    public function get_po_goods_blocking() {
        return $this->po_goods_blocking;
    }

    public function get_iscashvat() {
        return $this->iscashvat;
    }

    public function get_em_sco_hasGoodRep() {
        return $this->em_sco_hasGoodRep;
    }

    public function get_em_sco_retencionAgent() {
        return $this->em_sco_retencionAgent;
    }

    public function get_em_sco_percepcionAgent() {
        return $this->em_sco_percepcionAgent;
    }

    public function get_em_sco_aval_id() {
        return $this->em_sco_aval_id;
    }

    public function get_em_scr_combo_item_id() {
        return $this->em_scr_combo_item_id;
    }

    public function get_salesrep_id() {
        return $this->salesrep_id;
    }

    public function set_c_bpartner_id($c_bpartner_id) {
        $this->c_bpartner_id = $c_bpartner_id;
    }

    public function set_ad_client_id($ad_client_id) {
        $this->ad_client_id = $ad_client_id;
    }

    public function set_ad_org_id($ad_org_id) {
        $this->ad_org_id = $ad_org_id;
    }

    public function set_isactive($isactive) {
        $this->isactive = $isactive;
    }

    public function set_created($created) {
        $this->created = $created;
    }

    public function set_createdby($createdby) {
        $this->createdby = $createdby;
    }

    public function set_updated($updated) {
        $this->updated = $updated;
    }

    public function set_updatedby($updatedby) {
        $this->updatedby = $updatedby;
    }

    public function set_value($value) {
        $this->value = $value;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_name2($name2) {
        $this->name2 = $name2;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function set_issummary($issummary) {
        $this->issummary = $issummary;
    }

    public function set_c_bp_group_id($c_bp_group_id) {
        $this->c_bp_group_id = $c_bp_group_id;
    }

    public function set_isonetime($isonetime) {
        $this->isonetime = $isonetime;
    }

    public function set_isprospect($isprospect) {
        $this->isprospect = $isprospect;
    }

    public function set_isvendor($isvendor) {
        $this->isvendor = $isvendor;
    }

    public function set_iscustomer($iscustomer) {
        $this->iscustomer = $iscustomer;
    }

    public function set_isemployee($isemployee) {
        $this->isemployee = $isemployee;
    }

    public function set_issalesrep($issalesrep) {
        $this->issalesrep = $issalesrep;
    }

    public function set_taxid($taxid) {
        $this->taxid = $taxid;
    }

    public function set_istaxexempt($istaxexempt) {
        $this->istaxexempt = $istaxexempt;
    }

    public function set_paymentrule($paymentrule) {
        $this->paymentrule = $paymentrule;
    }

    public function set_so_creditlimit($so_creditlimit) {
        $this->so_creditlimit = $so_creditlimit;
    }

    public function set_so_creditused($so_creditused) {
        $this->so_creditused = $so_creditused;
    }

    public function set_c_paymentterm_id($c_paymentterm_id) {
        $this->c_paymentterm_id = $c_paymentterm_id;
    }

    public function set_m_pricelist_id($m_pricelist_id) {
        $this->m_pricelist_id = $m_pricelist_id;
    }

    public function set_isdiscountprinted($isdiscountprinted) {
        $this->isdiscountprinted = $isdiscountprinted;
    }

    public function set_invoicerule($invoicerule) {
        $this->invoicerule = $invoicerule;
    }

    public function set_socreditstatus($socreditstatus) {
        $this->socreditstatus = $socreditstatus;
    }

    public function set_showpriceinorder($showpriceinorder) {
        $this->showpriceinorder = $showpriceinorder;
    }

    public function set_invoicegrouping($invoicegrouping) {
        $this->invoicegrouping = $invoicegrouping;
    }

    public function set_isworker($isworker) {
        $this->isworker = $isworker;
    }

    public function set_fin_paymentmethod_id($fin_paymentmethod_id) {
        $this->fin_paymentmethod_id = $fin_paymentmethod_id;
    }

    public function set_fin_financial_account_id($fin_financial_account_id) {
        $this->fin_financial_account_id = $fin_financial_account_id;
    }

    public function set_customer_blocking($customer_blocking) {
        $this->customer_blocking = $customer_blocking;
    }

    public function set_vendor_blocking($vendor_blocking) {
        $this->vendor_blocking = $vendor_blocking;
    }

    public function set_so_payment_blocking($so_payment_blocking) {
        $this->so_payment_blocking = $so_payment_blocking;
    }

    public function set_po_payment_blocking($po_payment_blocking) {
        $this->po_payment_blocking = $po_payment_blocking;
    }

    public function set_so_invoice_blocking($so_invoice_blocking) {
        $this->so_invoice_blocking = $so_invoice_blocking;
    }

    public function set_po_invoice_blocking($po_invoice_blocking) {
        $this->po_invoice_blocking = $po_invoice_blocking;
    }

    public function set_so_order_blocking($so_order_blocking) {
        $this->so_order_blocking = $so_order_blocking;
    }

    public function set_po_order_blocking($po_order_blocking) {
        $this->po_order_blocking = $po_order_blocking;
    }

    public function set_so_goods_blocking($so_goods_blocking) {
        $this->so_goods_blocking = $so_goods_blocking;
    }

    public function set_po_goods_blocking($po_goods_blocking) {
        $this->po_goods_blocking = $po_goods_blocking;
    }

    public function set_iscashvat($iscashvat) {
        $this->iscashvat = $iscashvat;
    }

    public function set_em_sco_hasGoodRep($em_sco_hasGoodRep) {
        $this->em_sco_hasGoodRep = $em_sco_hasGoodRep;
    }

    public function set_em_sco_retencionAgent($em_sco_retencionAgent) {
        $this->em_sco_retencionAgent = $em_sco_retencionAgent;
    }

    public function set_em_sco_percepcionAgent($em_sco_percepcionAgent) {
        $this->em_sco_percepcionAgent = $em_sco_percepcionAgent;
    }

    public function set_em_sco_aval_id($em_sco_aval_id) {
        $this->em_sco_aval_id = $em_sco_aval_id;
    }

    public function set_em_scr_combo_item_id($em_scr_combo_item_id) {
        $this->em_scr_combo_item_id = $em_scr_combo_item_id;
    }

    public function set_salesrep_id($salesrep_id) {
        $this->salesrep_id = $salesrep_id;
    }

    /**
     * Función estática que devuelve un cliente directamente según su taxid.
     * @param string $taxid <p>Este parámetro vendría a ser el R.U.C. o el D.N.I. del cliente o de la empresa.</p>
     * @return Cliente <p>Devuelve un objeto de la clase Cliente.</p>
     * @return NULL <p>Si no esta registrado ese cliente, devolverá NULL.</p>
     */
    public static function Load($db, $taxid) {
        $objCliente = new Cliente();

        /////////////////// PREPARAMOS LA CONSULTA  //////////////////
        $queryCliente = "SELECT c_bpartner_id, ad_client_id, ad_org_id, isactive, created, createdby, updated, updatedby, value, name, name2, description, issummary, c_bp_group_id, isonetime, isprospect, isvendor, iscustomer, isemployee, issalesrep, taxid, istaxexempt, paymentrule, so_creditlimit, so_creditused, c_paymentterm_id, m_pricelist_id, isdiscountprinted, invoicerule, socreditstatus, showpriceinorder, invoicegrouping, isworker, fin_paymentmethod_id, fin_financial_account_id, customer_blocking, vendor_blocking, so_payment_blocking, po_payment_blocking, so_invoice_blocking, po_invoice_blocking, so_order_blocking, po_order_blocking, so_goods_blocking, po_goods_blocking, iscashvat, em_sco_hasGoodRep, em_sco_retencionAgent, em_sco_percepcionAgent, em_sco_aval_id, em_scr_combo_item_id, salesrep_id FROM c_bpartner WHERE taxid = '$taxid' AND iscustomer='Y' order by created desc limit 1;";

        $result_set = $db->query($queryCliente);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $rs = $result_set[0];
            foreach ($rs as $name => $value) {
                $objCliente->$name = $value;
            }
            return $objCliente;
        } else {
            return null;
        }
    }

    /**
     * Función que permite guardar los datos de un cliente.
     * 
     */
    public function Save($db) {

        $sql = "INSERT INTO c_bpartner(c_bpartner_id, ad_client_id, ad_org_id, isactive, created, createdby, updated, updatedby, value, name, name2, description, issummary, c_bp_group_id, isonetime, isprospect, isvendor, iscustomer, isemployee, issalesrep, taxid, istaxexempt, paymentrule, so_creditlimit, so_creditused, c_paymentterm_id, m_pricelist_id, isdiscountprinted, invoicerule, socreditstatus, showpriceinorder, invoicegrouping, isworker, fin_paymentmethod_id, fin_financial_account_id, customer_blocking, vendor_blocking, so_payment_blocking, po_payment_blocking, so_invoice_blocking, po_invoice_blocking, so_order_blocking, po_order_blocking, so_goods_blocking, po_goods_blocking, iscashvat, em_sco_hasGoodRep, em_sco_retencionAgent, em_sco_percepcionAgent, em_sco_aval_id, em_scr_combo_item_id, salesrep_id ) VALUES ('" . $this->get_c_bpartner_id() . "', '" . $this->get_ad_client_id() . "', '" . $this->get_ad_org_id() . "', '" . $this->get_isactive() . "', " . $this->get_created() . ", '" . $this->get_createdby() . "', " . $this->get_updated() . ", '" . $this->get_updatedby() . "', '" . $this->get_value() . "', '" . $this->get_name() . "', '" . $this->get_name2() . "', '" . $this->get_description() . "', '" . $this->get_issummary() . "', '" . $this->get_c_bp_group_id() . "', '" . $this->get_isonetime() . "', '" . $this->get_isprospect() . "', '" . $this->get_isvendor() . "', '" . $this->get_iscustomer() . "', '" . $this->get_isemployee() . "', '" . $this->get_issalesrep() . "', '" . $this->get_taxid() . "', '" . $this->get_istaxexempt() . "', '" . $this->get_paymentrule() . "', " . $this->get_so_creditlimit() . ", " . $this->get_so_creditused() . ", '" . $this->get_c_paymentterm_id() . "', '" . $this->get_m_pricelist_id() . "', '" . $this->get_isdiscountprinted() . "', '" . $this->get_invoicerule() . "', '" . $this->get_socreditstatus() . "', '" . $this->get_showpriceinorder() . "', '" . $this->get_invoicegrouping() . "', '" . $this->get_isworker() . "', '" . $this->get_fin_paymentmethod_id() . "', " . $this->get_fin_financial_account_id() . ", '" . $this->get_customer_blocking() . "', '" . $this->get_vendor_blocking() . "', '" . $this->get_so_payment_blocking() . "', '" . $this->get_po_payment_blocking() . "', '" . $this->get_so_invoice_blocking() . "', '" . $this->get_po_invoice_blocking() . "', '" . $this->get_so_order_blocking() . "', '" . $this->get_po_order_blocking() . "', '" . $this->get_so_goods_blocking() . "', '" . $this->get_po_goods_blocking() . "', '" . $this->get_iscashvat() . "', '" . $this->get_em_sco_hasGoodRep() . "', '" . $this->get_em_sco_retencionAgent() . "', '" . $this->get_em_sco_percepcionAgent() . "', " . $this->get_em_sco_aval_id() . ", '" . $this->get_em_scr_combo_item_id() . "', '" . $this->get_salesrep_id() . "');";

        // Ejecutamos la consulta y retornamos el estado de la transacción
        $success = $db->execute($sql);

        return $success;
    }

}

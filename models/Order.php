<?php

class Order {

    protected $c_order_id;
    protected $ad_client_id;
    protected $ad_org_id;
    protected $isactive;
    protected $created;
    protected $createdby;
    protected $updated;
    protected $updatedby;
    protected $issotrx;
    protected $documentno;
    protected $docstatus;
    protected $docaction;
    protected $processing;
    protected $processed;
    protected $c_doctype_id;
    protected $c_doctypetarget_id;
    protected $description;
    protected $isdelivered;
    protected $isinvoiced;
    protected $isprinted;
    protected $isselected;
    protected $salesrep_id;
    protected $dateordered;
    protected $datepromised;
    protected $dateprinted;
    protected $dateacct;
    protected $c_bpartner_id;
    protected $billto_id;
    protected $c_bpartner_location_id;
    protected $poreference;
    protected $c_currency_id;
    protected $paymentrule;
    protected $c_paymentterm_id;
    protected $invoicerule;
    protected $deliveryrule;
    protected $freightcostrule;
    protected $deliveryviarule;
    protected $priorityrule;
    protected $m_warehouse_id;
    protected $m_pricelist_id;
    protected $posted;
    protected $delivery_location_id;
    protected $fin_paymentmethod_id;
    protected $em_obwpl_generatepicking;
    protected $em_obwpl_isinpickinglist;
    protected $em_obwpl_readypl;
    protected $em_scr_credit_eval_updated;
    protected $em_scr_disc_eval_updated;
    protected $em_ssa_disc_evaluation_status;
    protected $em_ssa_credit_eval_status;
    protected $em_ssa_sales_area_cbo_item_id;
    protected $em_ssa_combo_item_id;

    /*
     * ARRAY DE ORDER LINES
     */
    protected $arrayOrderline;

    public function __construct() {
        $this->c_order_id = strtoupper(md5(uniqid()));
        $this->ad_client_id = "";
        $this->ad_org_id = "";
        $this->isactive = 'Y';
        $this->created = 'LOCALTIMESTAMP(3)'; //5 LOCALTIMESTAMP(3) --> Returns datetime without time zone
        $this->createdby = "";
        $this->updated = 'LOCALTIMESTAMP(3)'; //7
        $this->updatedby = "";
        $this->issotrx = 'Y';
        $this->documentno = "";
        $this->docstatus = 'DR';
        $this->docaction = 'CO';
        $this->processing = 'N';
        $this->processed = 'N';
        $this->c_doctype_id = "0";
        $this->c_doctypetarget_id = "";
        $this->description = "";
        $this->isdelivered = "N";
        $this->isinvoiced = "N";
        $this->isprinted = "N";
        $this->isselected = "N";
        $this->salesrep_id = "";
        $this->dateordered = 'LOCALTIMESTAMP(3)'; //23 LOCALTIMESTAMP(3) --> Returns datetime without time zon= ""e
        $this->datepromised = "NULL"; //24 
        $this->dateprinted = 'LOCALTIMESTAMP(3)'; //25 LOCALTIMESTAMP(3) --> Returns datetime without time zone= "";
        $this->dateacct = 'LOCALTIMESTAMP(3)'; //26 LOCALTIMESTAMP(3) --> Returns datetime without time zone= "";
        $this->c_bpartner_id = "";
        $this->billto_id = "NULL"; //28
        $this->c_bpartner_location_id = "";
        $this->poreference = "";
        $this->c_currency_id = "";
        $this->paymentrule = "P";
        $this->c_paymentterm_id = "";
        $this->invoicerule = "I";
        $this->deliveryrule = "A";
        $this->freightcostrule = "I";
        $this->deliveryviarule = "D";
        $this->priorityrule = 5;
        $this->m_warehouse_id = "";
        $this->m_pricelist_id = "";
        $this->posted = "D";
        $this->delivery_location_id = "";
        $this->fin_paymentmethod_id = "";
        $this->em_obwpl_generatepicking = "N";
        $this->em_obwpl_isinpickinglist = "N";
        $this->em_obwpl_readypl = "Y";
        $this->em_scr_credit_eval_updated = 'LOCALTIMESTAMP(3)'; //47
        $this->em_scr_disc_eval_updated = 'LOCALTIMESTAMP(3)'; //48
        $this->em_ssa_disc_evaluation_status = "DR";
        $this->em_ssa_credit_eval_status = "DR";
        $this->em_ssa_sales_area_cbo_item_id = 'NULL'; //51
        $this->em_ssa_combo_item_id = "SSASTANDARDORDER";

        $this->arrayOrderline = array();
    }

    public function get_c_order_id() {
        return $this->c_order_id;
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

    public function get_issotrx() {
        return $this->issotrx;
    }

    public function get_documentno() {
        return $this->documentno;
    }

    public function get_docstatus() {
        return $this->docstatus;
    }

    public function get_docaction() {
        return $this->docaction;
    }

    public function get_processing() {
        return $this->processing;
    }

    public function get_processed() {
        return $this->processed;
    }

    public function get_c_doctype_id() {
        return $this->c_doctype_id;
    }

    public function get_c_doctypetarget_id() {
        return $this->c_doctypetarget_id;
    }

    public function get_description() {
        return $this->description;
    }

    public function get_isdelivered() {
        return $this->isdelivered;
    }

    public function get_isinvoiced() {
        return $this->isinvoiced;
    }

    public function get_isprinted() {
        return $this->isprinted;
    }

    public function get_isselected() {
        return $this->isselected;
    }

    public function get_salesrep_id() {
        return $this->salesrep_id;
    }

    public function get_dateordered() {
        return $this->dateordered;
    }

    public function get_datepromised() {
        return $this->datepromised;
    }

    public function get_dateprinted() {
        return $this->dateprinted;
    }

    public function get_dateacct() {
        return $this->dateacct;
    }

    public function get_c_bpartner_id() {
        return $this->c_bpartner_id;
    }

    public function get_billto_id() {
        return $this->billto_id;
    }

    public function get_c_bpartner_location_id() {
        return $this->c_bpartner_location_id;
    }

    public function get_poreference() {
        return $this->poreference;
    }

    public function get_c_currency_id() {
        return $this->c_currency_id;
    }

    public function get_paymentrule() {
        return $this->paymentrule;
    }

    public function get_c_paymentterm_id() {
        return $this->c_paymentterm_id;
    }

    public function get_invoicerule() {
        return $this->invoicerule;
    }

    public function get_deliveryrule() {
        return $this->deliveryrule;
    }

    public function get_freightcostrule() {
        return $this->freightcostrule;
    }

    public function get_deliveryviarule() {
        return $this->deliveryviarule;
    }

    public function get_priorityrule() {
        return $this->priorityrule;
    }

    public function get_m_warehouse_id() {
        return $this->m_warehouse_id;
    }

    public function get_m_pricelist_id() {
        return $this->m_pricelist_id;
    }

    public function get_posted() {
        return $this->posted;
    }

    public function get_delivery_location_id() {
        return $this->delivery_location_id;
    }

    public function get_fin_paymentmethod_id() {
        return $this->fin_paymentmethod_id;
    }

    public function get_em_obwpl_generatepicking() {
        return $this->em_obwpl_generatepicking;
    }

    public function get_em_obwpl_isinpickinglist() {
        return $this->em_obwpl_isinpickinglist;
    }

    public function get_em_obwpl_readypl() {
        return $this->em_obwpl_readypl;
    }

    public function get_em_scr_credit_eval_updated() {
        return $this->em_scr_credit_eval_updated;
    }

    public function get_em_scr_disc_eval_updated() {
        return $this->em_scr_disc_eval_updated;
    }

    public function get_em_ssa_disc_evaluation_status() {
        return $this->em_ssa_disc_evaluation_status;
    }

    public function get_em_ssa_credit_eval_status() {
        return $this->em_ssa_credit_eval_status;
    }

    public function get_em_ssa_sales_area_cbo_item_id() {
        return $this->em_ssa_sales_area_cbo_item_id;
    }

    public function get_em_ssa_combo_item_id() {
        return $this->em_ssa_combo_item_id;
    }

    public function get_arrayOrderline() {
        return $this->arrayOrderline;
    }

    public function set_c_order_id($c_order_id) {
        $this->c_order_id = $c_order_id;
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

    public function set_issotrx($issotrx) {
        $this->issotrx = $issotrx;
    }

    public function set_documentno($documentno) {
        $this->documentno = $documentno;
    }

    public function set_docstatus($docstatus) {
        $this->docstatus = $docstatus;
    }

    public function set_docaction($docaction) {
        $this->docaction = $docaction;
    }

    public function set_processing($processing) {
        $this->processing = $processing;
    }

    public function set_processed($processed) {
        $this->processed = $processed;
    }

    public function set_c_doctype_id($c_doctype_id) {
        $this->c_doctype_id = $c_doctype_id;
    }

    public function set_c_doctypetarget_id($c_doctypetarget_id) {
        $this->c_doctypetarget_id = $c_doctypetarget_id;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function set_isdelivered($isdelivered) {
        $this->isdelivered = $isdelivered;
    }

    public function set_isinvoiced($isinvoiced) {
        $this->isinvoiced = $isinvoiced;
    }

    public function set_isprinted($isprinted) {
        $this->isprinted = $isprinted;
    }

    public function set_isselected($isselected) {
        $this->isselected = $isselected;
    }

    public function set_salesrep_id($salesrep_id) {
        $this->salesrep_id = $salesrep_id;
    }

    public function set_dateordered($dateordered) {
        $this->dateordered = $dateordered;
    }

    public function set_datepromised($datepromised) {
        $this->datepromised = $datepromised;
    }

    public function set_dateprinted($dateprinted) {
        $this->dateprinted = $dateprinted;
    }

    public function set_dateacct($dateacct) {
        $this->dateacct = $dateacct;
    }

    public function set_c_bpartner_id($c_bpartner_id) {
        $this->c_bpartner_id = $c_bpartner_id;
    }

    public function set_billto_id($billto_id) {
        $this->billto_id = $billto_id;
    }

    public function set_c_bpartner_location_id($c_bpartner_location_id) {
        $this->c_bpartner_location_id = $c_bpartner_location_id;
    }

    public function set_poreference($poreference) {
        $this->poreference = $poreference;
    }

    public function set_c_currency_id($c_currency_id) {
        $this->c_currency_id = $c_currency_id;
    }

    public function set_paymentrule($paymentrule) {
        $this->paymentrule = $paymentrule;
    }

    public function set_c_paymentterm_id($c_paymentterm_id) {
        $this->c_paymentterm_id = $c_paymentterm_id;
    }

    public function set_invoicerule($invoicerule) {
        $this->invoicerule = $invoicerule;
    }

    public function set_deliveryrule($deliveryrule) {
        $this->deliveryrule = $deliveryrule;
    }

    public function set_freightcostrule($freightcostrule) {
        $this->freightcostrule = $freightcostrule;
    }

    public function set_deliveryviarule($deliveryviarule) {
        $this->deliveryviarule = $deliveryviarule;
    }

    public function set_priorityrule($priorityrule) {
        $this->priorityrule = $priorityrule;
    }

    public function set_m_warehouse_id($m_warehouse_id) {
        $this->m_warehouse_id = $m_warehouse_id;
    }

    public function set_m_pricelist_id($m_pricelist_id) {
        $this->m_pricelist_id = $m_pricelist_id;
    }

    public function set_posted($posted) {
        $this->posted = $posted;
    }

    public function set_delivery_location_id($delivery_location_id) {
        $this->delivery_location_id = $delivery_location_id;
    }

    public function set_fin_paymentmethod_id($fin_paymentmethod_id) {
        $this->fin_paymentmethod_id = $fin_paymentmethod_id;
    }

    public function set_em_obwpl_generatepicking($em_obwpl_generatepicking) {
        $this->em_obwpl_generatepicking = $em_obwpl_generatepicking;
    }

    public function set_em_obwpl_isinpickinglist($em_obwpl_isinpickinglist) {
        $this->em_obwpl_isinpickinglist = $em_obwpl_isinpickinglist;
    }

    public function set_em_obwpl_readypl($em_obwpl_readypl) {
        $this->em_obwpl_readypl = $em_obwpl_readypl;
    }

    public function set_em_scr_credit_eval_updated($em_scr_credit_eval_updated) {
        $this->em_scr_credit_eval_updated = $em_scr_credit_eval_updated;
    }

    public function set_em_scr_disc_eval_updated($em_scr_disc_eval_updated) {
        $this->em_scr_disc_eval_updated = $em_scr_disc_eval_updated;
    }

    public function set_em_ssa_disc_evaluation_status($em_ssa_disc_evaluation_status) {
        $this->em_ssa_disc_evaluation_status = $em_ssa_disc_evaluation_status;
    }

    public function set_em_ssa_credit_eval_status($em_ssa_credit_eval_status) {
        $this->em_ssa_credit_eval_status = $em_ssa_credit_eval_status;
    }

    public function set_em_ssa_sales_area_cbo_item_id($em_ssa_sales_area_cbo_item_id) {
        $this->em_ssa_sales_area_cbo_item_id = $em_ssa_sales_area_cbo_item_id;
    }

    public function set_em_ssa_combo_item_id($em_ssa_combo_item_id) {
        $this->em_ssa_combo_item_id = $em_ssa_combo_item_id;
    }

    public function set_arrayOrderline($arrayOrderline) {
        $this->arrayOrderline = $arrayOrderline;
    }

    /**
     * Este método nos permite guardar una orden.
     * Una vez guardada la orden, se actualizará el número de documento en la tabla AD_SECUENCE. 
     */
    public function SaveOrden($db) {

        $query = "INSERT INTO c_order (
c_order_id, 
ad_client_id,
ad_org_id, 
isactive, 
created, 
createdby, 
updated, 
updatedby, 
issotrx, 
documentno, 
docstatus, 
docaction, 
processing, 
processed, 
c_doctype_id, 
c_doctypetarget_id, 
description, 
isdelivered, 
isinvoiced, 
isprinted, 
isselected, 
salesrep_id, 
dateordered, 
datepromised, 
dateprinted, 
dateacct, 
c_bpartner_id, 
billto_id, 
c_bpartner_location_id,
poreference, 
c_currency_id, 
paymentrule,
c_paymentterm_id,
invoicerule,
deliveryrule,
freightcostrule,
deliveryviarule,
priorityrule, 
m_warehouse_id,
m_pricelist_id,
posted,
delivery_location_id,
fin_paymentmethod_id,
em_obwpl_generatepicking,
em_obwpl_isinpickinglist,
em_obwpl_readypl,
em_scr_credit_eval_updated,
em_scr_disc_eval_updated,
em_ssa_disc_evaluation_status,
em_ssa_credit_eval_status,
em_ssa_sales_area_cbo_item_id,
em_ssa_combo_item_id) VALUES (
'" . $this->get_c_order_id() . "' 
'" . $this->get_ad_client_id() . "'
'" . $this->get_ad_org_id() . "' 
'" . $this->get_isactive() . "' 
" . $this->get_created() . " 
'" . $this->get_createdby() . "' 
" . $this->get_updated() . "
'" . $this->get_updatedby() . "' 
'" . $this->get_issotrx() . "' 
'" . $this->get_documentno() . "' 
'" . $this->get_docstatus() . "' 
'" . $this->get_docaction() . "' 
'" . $this->get_processing() . "' 
'" . $this->get_processed() . "' 
'" . $this->get_c_doctype_id() . "' 
'" . $this->get_c_doctypetarget_id() . "' 
'" . $this->get_description() . "' 
'" . $this->get_isdelivered() . "' 
'" . $this->get_isinvoiced() . "' 
'" . $this->get_isprinted() . "' 
'" . $this->get_isselected() . "' 
'" . $this->get_salesrep_id() . "' 
" . $this->get_dateordered() . "
'" . $this->get_datepromised() . "' 
" . $this->get_dateprinted() . " 
" . $this->get_dateacct() . "
'" . $this->get_c_bpartner_id() . "' 
" . $this->get_billto_id() . " 
'" . $this->get_c_bpartner_location_id() . "'
'" . $this->get_poreference() . "' 
'" . $this->get_c_currency_id() . "' 
'" . $this->get_paymentrule() . "'
'" . $this->get_c_paymentterm_id() . "'
'" . $this->get_invoicerule() . "'
'" . $this->get_deliveryrule() . "'
'" . $this->get_freightcostrule() . "'
'" . $this->get_deliveryviarule() . "'
'" . $this->get_priorityrule() . "' 
'" . $this->get_m_warehouse_id() . "'
'" . $this->get_m_pricelist_id() . "'
'" . $this->get_posted() . "'
'" . $this->get_delivery_location_id() . "'
'" . $this->get_fin_paymentmethod_id() . "'
'" . $this->get_em_obwpl_generatepicking() . "'
'" . $this->get_em_obwpl_isinpickinglist() . "'
'" . $this->get_em_obwpl_readypl() . "'
" . $this->get_em_scr_credit_eval_updated() . "
" . $this->get_em_scr_disc_eval_updated() . "
'" . $this->get_em_ssa_disc_evaluation_status() . "'
'" . $this->get_em_ssa_credit_eval_status() . "'
" . $this->get_em_ssa_sales_area_cbo_item_id() . "
'" . $this->get_em_ssa_combo_item_id() . "')";
        
        echo $query;
        // Ejecutamos la consulta y retornamos el estado de la transacción
        $success = $db->execute($query);

        return $success;
    }

}

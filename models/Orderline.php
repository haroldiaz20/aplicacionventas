<?php

class Orderline {

    protected $c_orderline_id;
    protected $ad_client_id;
    protected $ad_org_id;
    protected $isactive;
    protected $created;
    protected $createdby;
    protected $updated;
    protected $updatedby;
    protected $c_order_id;
    protected $line;
    protected $c_bpartner_id;
    protected $c_bpartner_location_id;
    protected $dateordered;
    protected $description;
    protected $m_product_id;
    protected $m_warehouse_id;
    protected $c_uom_id;
    protected $qtyordered;
    protected $qtyreserved;
    protected $qtydelivered;
    protected $qtyinvoiced;
    protected $c_currency_id;
    protected $pricelist;
    protected $priceactual;
    protected $pricelimit;
    protected $linenetamt;
    protected $discount;
    protected $c_tax_id;
    protected $pricestd;
    protected $taxbaseamt;
    protected $em_obwpl_readypl;
    protected $product;

    /*
     * VARIABLES CONSTANTES
     */

    /**
     * Es el id del I.G.V. que es constante para las ventas y se saca de la base de datos.
     */
    const tax_id = "B07308F5E28C4D9CB2CB906375CE8C3E";

    /**
     * Constructor por defecto de la clase Orderline.
     */
    public function __construct() {
        $this->c_orderline_id = strtoupper(md5(uniqid()));
        $this->ad_client_id = "";
        $this->ad_org_id = "";
        $this->isactive = "Y";
        $this->created = 'localtimestamp(3)';
        $this->createdby = "";
        $this->updated = 'localtimestamp(3)';
        $this->updatedby = "";
        $this->c_order_id = "";
        $this->line = 0;
        $this->c_bpartner_id = "";
        $this->c_bpartner_location_id = "";
        $this->dateordered = 'localtimestamp(3)';
        $this->description = "";
        $this->m_product_id = "";
        $this->m_warehouse_id = "";
        $this->c_uom_id = ""; //$producto->getC_uom_id();
        $this->qtyordered = 0;
        $this->qtyreserved = 0;
        $this->qtydelivered = 0;
        $this->qtyinvoiced = 0;
        $this->c_currency_id = "";
        $this->pricelist = ""; //$producto->getPricelist();
        $this->priceactual = 0.00;
        $this->pricelimit = 0.00;
        $this->linenetamt = 0.00;
        $this->discount = 0.00;
        $this->c_tax_id = Orderline::tax_id;
        $this->pricestd = 0.00; // precio unitario
        $this->taxbaseamt = 0.00; // lineamount
        $this->em_obwpl_readypl = "N";

        $this->product = new Producto();
    }

     public function SaveOrderline() {

       

            /////////////////// PREPARAMOS LA CONSULTA  //////////////////
            $queryOrderline = sprintf("INSERT INTO c_orderline (c_orderline_id, ad_client_id, ad_org_id, isactive, created, createdby, updated, updatedby, c_order_id, line, c_bpartner_id, c_bpartner_location_id, dateordered, description, m_product_id, m_warehouse_id, c_uom_id, qtyordered, qtyreserved, qtydelivered, qtyinvoiced, c_currency_id, pricelist,priceactual, pricelimit, linenetamt, discount, c_tax_id, pricestd, taxbaseamt, em_obwpl_readypl)  VALUES ('%s', '%s', '%s', '%s', %s, '%s', %s, '%s', '%s',%d,'%s','%s',%s,'%s','%s','%s','%s',%s,%s,%s,%s,'%s',%s,%s,%s,%s,%s,'%s',%s,%s,'%s')", $this->getC_orderline_id(), $this->getAd_client_id(), $this->getAd_org_id(), $this->getIsactive(), $this->getCreated(), $this->getCreatedby(), $this->getUpdated(), $this->getUpdatedby(), $this->getC_order_id(), $this->getLine(), $this->getC_bpartner_id(), $this->getC_bpartner_location_id(), $this->getDateordered(), $this->getDescription(), $this->getM_product_id(), $this->getM_warehouse_id(), $this->getC_uom_id(), $this->getQtyordered(), $this->getQtyreserved(), $this->getQtydelivered(), $this->getQtyinvoiced(), $this->getC_currency_id(), $this->getPricelist(), $this->getPriceactual(), $this->getPricelimit(), $this->getLinenetamt(), $this->getDiscount(), $this->getC_tax_id(), $this->getPricestd(), $this->getTaxbaseamt(), $this->getEm_obwpl_readypl());

            // $array = array("mensaje" => $queryOrderline);
            //  QApplication::DisplayAlert(json_encode($array));
            //////////////////// EJECUTAMOS LA CONSULTA////////////////////
            $objDatabase->NonQuery($queryOrderline);

            ///////////// SI TODO SALIÓ BIEN HACEMOS UN COMMIT A LA TRANSACCIÓN ////////////////////
            $objDatabase->TransactionCommit();
       
    }
    
}

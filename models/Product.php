<?php

/**
 * Description of Product
 *
 * @author Harold
 */
class Product {

    public $productId;
    public $value;
    public $name;
    public $adOrgId;
    public $adOrgName;
    public $cUomId;
    public $uomName;
    public $stock;
    public $mWarehouseId;
    public $mWarehouseName;
    public $priceList;
    public $db;

    public function __construct($db) {
        $this->db = $db;
        $this->productId = strtoupper(md5(uniqid()));
        $this->value = "";
        $this->name = "";
        $this->adOrgId = "";
        $this->cUomId = "";
        $this->stock = 0;
        $this->priceList = 0.00;
    }
    
    function getPriceList() {
        return $this->priceList;
    }

    function setPriceList($priceList) {
        $this->priceList = floatval($priceList);
    }

    
    public function getProductId() {
        return $this->productId;
    }

    public function getValue() {
        return $this->value;
    }

    public function getName() {
        return $this->name;
    }

    public function getAdOrgId() {
        return $this->adOrgId;
    }

    public function getAdOrgName() {
        return $this->adOrgName;
    }

    public function getCUomId() {
        return $this->cUomId;
    }

    public function getUomName() {
        return $this->uomName;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getMWarehouseId() {
        return $this->mWarehouseId;
    }

    public function getMWarehouseName() {
        return $this->mWarehouseName;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAdOrgId($adOrgId) {
        $this->adOrgId = $adOrgId;
    }

    public function setAdOrgName($adOrgName) {
        $this->adOrgName = $adOrgName;
    }

    public function setCUomId($cUomId) {
        $this->cUomId = $cUomId;
    }

    public function setUomName($uomName) {
        $this->uomName = $uomName;
    }

    public function setStock($stock) {
        $this->stock = intval($stock);
    }

    public function setMWarehouseId($mWarehouseId) {
        $this->mWarehouseId = $mWarehouseId;
    }

    public function setMWarehouseName($mWarehouseName) {
        $this->mWarehouseName = $mWarehouseName;
    }

    /**
     * Obtenemos la información de un producto de acuerdo a su código(value).
     * @param strign $db Es la instancia de la BD extraída desde el servicio BI de Phalcon.
     * @param string $value <p>Viene a ser el código único del producto.</p>
     * @param string $ad_client_id <p>Es el id del vendedor quien esta realizando la venta.</p>
     * @param string $m_pricelist_id <p>El precio de lista según la moneda en la cual se esta consultando.</p>     
     * @param string $m_warehouse_id <p>Es el Id del almacén en donde se realizará la búsqueda del producto.</p>
     * @param string $ad_org_id <p>Es el Id de la organización a la cual pertenece el vendedor que registra la orden.</p>
     * @return Producto <p>Si todo salió bien, devuelve un objeto de la clase Producto.</p>
     * @return NULL <p>En caso no haya encontrado el producto especificado.</p>
     */
    public static function Load($db, $value, $ad_client_id, $m_pricelist_id, $m_warehouse_id, $ad_org_id) {
        // Instanciamos un objeto de la clase Product
        $objProduct = new Product($db);
        $m_product_id = "";

        //////////// OBTENEMOS EL M_PRODUCT_ID SEGÚN EL VALUE DEL PRODUCTO ////////////////
        $query_to_obtainID = "SELECT p.m_product_id from m_product p WHERE p.value='$value';";
        $result_set = $db->query($query_to_obtainID);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);
        //echo $query_to_obtainID;
        if (count($result_set) > 0) {
            // $result_set es un array con múltiples filas, pero solo tomaremos la primera, es decir la fila [0]
            $rs = $result_set[0];
            /*
             * Obtenemos el ID del producto
             */
            $m_product_id = $rs['m_product_id'];
            /*
             * Preparamos la consulta
             */

            $query = "SELECT ppwv.qty_available,ppwv.pricelist,p.name,p.c_uom_id,p.m_product_id,o.ad_org_id,o.name as ad_org_name,u.uomsymbol,p.value,p.m_product_id,w.m_warehouse_id,w.name as m_warehouse_name
                FROM m_product_price_warehouse_v ppwv
                INNER JOIN m_product p ON p.m_product_id=ppwv.m_product_id 
                INNER JOIN ad_org o ON o.ad_org_id = p.ad_org_id
                INNER JOIN m_productprice pp ON pp.m_productprice_id=ppwv.m_productprice_id
                INNER JOIN m_pricelist_version plv ON plv.m_pricelist_version_id=pp.m_pricelist_version_id
                INNER JOIN m_pricelist pl ON pl.m_pricelist_id=plv.m_pricelist_id
                INNER JOIN m_warehouse w ON w.m_warehouse_id=ppwv.m_warehouse_id
                INNER JOIN c_uom u ON u.c_uom_id = p.c_uom_id
                WHERE pp.m_pricelist_version_id=plv.m_pricelist_version_id 
                AND p.ad_client_id='$ad_client_id' 
                AND p.m_product_id='$m_product_id'  
                AND (pl.m_pricelist_id='$m_pricelist_id')
                AND (plv.m_pricelist_version_id=(SELECT m_pricelist_version_id FROM m_pricelist_version 
                    WHERE m_pricelist_id = '$m_pricelist_id' AND validfrom <=NOW() 
                    ORDER BY validfrom DESC LIMIT 1))
                AND pl.ad_client_id='$ad_client_id'
                AND w.m_warehouse_id='$m_warehouse_id'
                AND AD_ISORGINCLUDED('$ad_org_id', p.ad_org_id,'$ad_client_id') > -1
                AND AD_ISORGINCLUDED('$ad_org_id', ppwv.orgwarehouse,'$ad_client_id') > -1 LIMIT 1";
            $result_set_2 = $db->query($query);
            $result_set_2->setFetchMode(Phalcon\Db::FETCH_ASSOC);
            $result_set_2 = $result_set_2->fetchAll($result_set_2);

            if (count($result_set_2) > 0) {
                /*
                 * Como el resulset nos devuelve un array varias filas, obtenemos la primera simplemente.
                 */
                $rs2 = $result_set_2[0];
                /*
                 * Ahora establecemos cada uno de los atributos del objeto product
                 */
                $objProduct->setProductId($rs2['m_product_id']);
                $objProduct->setName($rs2['name']);
                $objProduct->setAdOrgId($ad_org_id);
                $objProduct->setAdOrgName($rs2['ad_org_name']);
                $objProduct->setValue($rs2['value']);
                $objProduct->setUomName($rs2['uomsymbol']);
                $objProduct->setCUomId($rs2['c_uom_id']);
                $objProduct->setMWarehouseId($rs2['m_warehouse_id']);
                $objProduct->setMWarehouseName($rs2['m_warehouse_name']);
                $objProduct->setPriceList($rs2['pricelist']);
            } else {
                
            }

            ///////// CONSULTA PARA HALLAR EL STOCK DEL PRODUCTO //////////
            $queryStock = sprintf("SELECT CASE WHEN wtqv.qtyonhand-wtqv.qtyreserved < 0 THEN 0 ELSE wtqv.qtyonhand-wtqv.qtyreserved END as qtyavailable FROM scr_warehouse_total_qty_v wtqv, m_product p, m_warehouse w WHERE p.m_product_id=wtqv.m_product_id AND wtqv.m_warehouse_id='%s' AND p.m_product_id='%s' AND p.ad_client_id='%s' AND AD_ISORGINCLUDED('%s', p.ad_org_id,'%s') > -1 AND AD_ISORGINCLUDED('%s', w.ad_org_id,'%s') > -1 LIMIT 1;", $m_warehouse_id, $m_product_id, $ad_client_id, $ad_org_id, $ad_client_id, $ad_org_id, $ad_client_id);

            $result_set_3 = $db->query($queryStock);
            $result_set_3->setFetchMode(Phalcon\Db::FETCH_ASSOC);
            $result_set_3 = $result_set_3->fetchAll($result_set_3);
            // echo $queryStock;
            if (count($result_set_3) > 0) {
                /*
                 * Como el resulset nos devuelve un array varias filas, obtenemos la primera simplemente.
                 */
                $rs3 = $result_set_3[0];
                $objProduct->setStock($rs3['qtyavailable']);
            } else {
                $objProduct->setStock("0.00");
            }

            /*
             * Una vez que hemos establecido todos los atributos del objeto producto, retornamos el objeto product
             */

            return $objProduct;
        } else {
            return NULL;
        }
    }

}

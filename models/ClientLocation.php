<?php

/**
 * Esta clase nos permitirá manejar la información relacionada a la ubicación específica de un cliente.
 *
 * @author Harold
 */
class ClientLocation {

    public $c_bpartner_location_id;
    public $ad_client_id;
    public $ad_org_id;
    public $isactive;
    public $created;
    public $createdby;
    public $updated;
    public $updatedby;
    public $name;
    public $isbillto;
    public $isshipto;
    public $ispayfrom;
    public $isremitto;
    public $phone;
    public $phone2;
    public $fax;
    public $c_bpartner_id;
    public $c_location_id;
    public $istaxlocation;

    public function __construct() {

        $this->c_bpartner_location_id = strtoupper(md5(uniqid()));
        $this->ad_client_id = "";
        $this->ad_org_id = "";
        $this->isactive = "Y";
        $this->created = 'localtimestamp(3)';
        $this->createdby = "";
        $this->updated = 'localtimestamp(3)';
        $this->updatedby = "";
        $this->name = "";
        $this->isbillto = "Y";
        $this->isshipto = "Y";
        $this->ispayfrom = "Y";
        $this->isremitto = "Y";
        $this->phone = "";
        $this->phone2 = "";
        $this->fax = "";
        $this->c_bpartner_id = "";
        $this->c_location_id = "";
        $this->istaxlocation = "N";
    }

    public function getC_bpartner_location_id() {
        return $this->c_bpartner_location_id;
    }

    public function getAd_client_id() {
        return $this->ad_client_id;
    }

    public function getAd_org_id() {
        return $this->ad_org_id;
    }

    public function getIsactive() {
        return $this->isactive;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getCreatedby() {
        return $this->createdby;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function getUpdatedby() {
        return $this->updatedby;
    }

    public function getName() {
        return $this->name;
    }

    public function getIsbillto() {
        return $this->isbillto;
    }

    public function getIsshipto() {
        return $this->isshipto;
    }

    public function getIspayfrom() {
        return $this->ispayfrom;
    }

    public function getIsremitto() {
        return $this->isremitto;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getPhone2() {
        return $this->phone2;
    }

    public function getFax() {
        return $this->fax;
    }

    public function getC_bpartner_id() {
        return $this->c_bpartner_id;
    }

    public function getC_location_id() {
        return $this->c_location_id;
    }

    public function getIstaxlocation() {
        return $this->istaxlocation;
    }

    public function setC_bpartner_location_id($c_bpartner_location_id) {
        $this->c_bpartner_location_id = $c_bpartner_location_id;
    }

    public function setAd_client_id($ad_client_id) {
        $this->ad_client_id = $ad_client_id;
    }

    public function setAd_org_id($ad_org_id) {
        $this->ad_org_id = $ad_org_id;
    }

    public function setIsactive($isactive) {
        $this->isactive = $isactive;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function setCreatedby($createdby) {
        $this->createdby = $createdby;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    public function setUpdatedby($updatedby) {
        $this->updatedby = $updatedby;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setIsbillto($isbillto) {
        $this->isbillto = $isbillto;
    }

    public function setIsshipto($isshipto) {
        $this->isshipto = $isshipto;
    }

    public function setIspayfrom($ispayfrom) {
        $this->ispayfrom = $ispayfrom;
    }

    public function setIsremitto($isremitto) {
        $this->isremitto = $isremitto;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setPhone2($phone2) {
        $this->phone2 = $phone2;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function setC_bpartner_id($c_bpartner_id) {
        $this->c_bpartner_id = $c_bpartner_id;
    }

    public function setC_location_id($c_location_id) {
        $this->c_location_id = $c_location_id;
    }

    public function setIstaxlocation($istaxlocation) {
        $this->istaxlocation = $istaxlocation;
    }

    /**
     * Este método nos devuelve un objeto de la clase ClienteLocation, una vez que ha sido buscado según el c_bpartner_id.
     * @param string $c_bpartner_id <p>Es el id único del cbpartner, del cuál se desea obtener la información de su ubicación.</p>
     * @return ClienteLocation <p>Si encontró la dirección asociada a ese cliente, entonces devolverá un objeto de la clase ClienteLcoation. Si no econtró una dirección asociada a ese cliente, devolverá <b>NULL</b>.</p>
     */
    public static function LoadByCBPartnerId($db, $c_bpartner_id) {
        $objClienteLocation = new ClientLocation();
        //////////////////// INICIAMOS LA TRANSACCION /////////////////
        // PREPARAMOS LA CONSULTA
        $partnerLocation = "SELECT c_bpartner_location_id, ad_client_id, ad_org_id, isactive, created, createdby, updated, updatedby, name, isbillto, isshipto, ispayfrom, isremitto, phone, phone2, fax, c_bpartner_id,c_location_id, istaxlocation FROM c_bpartner_location WHERE c_bpartner_id = '$c_bpartner_id' AND em_sco_nulllocation='N';";

        $result_set = $db->query($partnerLocation);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $rs = $result_set[0];
            foreach ($rs as $name => $value) {
                $objClienteLocation->$name = $value;
            }
            return $objClienteLocation;
        } else {
            return null;
        }
    }

    /**
     * Este método nos permititá guardar la ubicación relacionada con un cliente.
     */
    public function SaveClienteLocation($db) {

        // PREPARAMOS LA CONSULTA
        $partnerLocation = sprintf("INSERT INTO c_bpartner_location(c_bpartner_location_id, ad_client_id, ad_org_id, isactive, created,createdby, updated, updatedby, name, isbillto, isshipto, ispayfrom,isremitto, phone, phone2, fax, c_bpartner_id,c_location_id, istaxlocation) VALUES ('%s', '%s', '%s', '%s', %s, '%s', %s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", $this->getC_bpartner_location_id(), $this->getAd_client_id(), $this->getAd_org_id(), $this->getIsactive(), $this->getCreated(), $this->getCreatedby(), $this->getUpdated(), $this->getUpdatedby(), $this->getName(), $this->getIsbillto(), $this->getIsshipto(), $this->getIspayfrom(), $this->getIsremitto(), $this->getPhone(), $this->getPhone2(), $this->getFax(), $this->getC_bpartner_id(), $this->getC_location_id(), $this->getIstaxlocation());


        // Ejecutamos la consulta y retornamos el estado de la transacción
        $success = $db->execute($partnerLocation);

        return $success;
    }

}

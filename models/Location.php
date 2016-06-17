<?php

/**
 * La Clase Location, nos permitirá almacenar y manejar la información sobre la ubicación de un cliente.
 * @author Harold
 */
class Location {

    public $c_location_id;
    public $ad_client_id;
    public $ad_org_id;
    public $isactive;
    public $created;
    public $createdby;
    public $updated;
    public $updatedby;
    public $address1;
    public $address2;
    public $city;
    public $c_region_id;
    public $c_country_id;
    public $postal;

    /*
     * Nombres de la ciudad y provincia
     */
    public $nombre_pais;
    public $nombre_region;

    public function __construct() {
        $this->c_location_id = strtoupper(md5(uniqid()));
        $this->ad_client_id = "";
        $this->ad_org_id = "";
        $this->isactive = "Y";
        $this->created = 'localtimestamp(3)';
        $this->createdby = "";
        $this->updated = 'localtimestamp(3)';
        $this->updatedby = "";
        $this->address1 = "";
        $this->address2 = "";
        $this->city = "";
        $this->c_region_id = "";
        $this->c_country_id = "";
        $this->postal = "";
        $this->nombre_pais = "";
        $this->nombre_region = "";
    }

    public function getC_location_id() {
        return $this->c_location_id;
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

    public function getAddress1() {
        return $this->address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getCity() {
        return $this->city;
    }

    public function getC_region_id() {
        return $this->c_region_id;
    }

    public function getC_country_id() {
        return $this->c_country_id;
    }

    public function setC_location_id($c_location_id) {
        $this->c_location_id = $c_location_id;
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

    public function setAddress1($address1) {
        $this->address1 = $address1;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setC_region_id($c_region_id) {
        $this->c_region_id = $c_region_id;
    }

    public function setC_country_id($c_country_id) {
        $this->c_country_id = $c_country_id;
    }

    public function getPostal() {
        return $this->postal;
    }

    public function setPostal($postal) {
        $this->postal = $postal;
    }

    ///////////////////////////////////////////
    public function getNombrePais() {
        return $this->nombre_pais;
    }

    public function getNombreRegion() {
        return $this->nombre_region;
    }

    public function setNombrePais($nombrepais) {
        $this->nombre_pais = $nombrepais;
    }

    public function setNombreRegion($nombreregion) {
        $this->nombre_region = $nombreregion;
    }

    ///////////////////////////////////////////
    /*
     * Esta función nos devolverá un listado de todos los países listados en la BD
     */
    public static function LoadCountries($db) {
        $query = "select c_country_id, name from c_country_trl order by name;";
        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $paises = array();
            foreach ($result_set as $rs) {
                $paises[] = array("value" => $rs["c_country_id"], "name" => $rs["name"]);
            }
            return $paises;
        } else {
            return null;
        }
    }

    /**
     * Esta función nos devolverá las regiones que le pertenecen a un país determinado
     */
    public static function LoadRegionsByIdCountry($db, $idCountry) {
        $query = "select c_region_id, description from c_region where c_country_id='$idCountry' order by name;";
        $result_set = $db->query($query);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $regiones = array();
            foreach ($result_set as $rs) {
                $regiones[] = array("value" => $rs["c_region_id"], "name" => $rs["description"]);
            }
            return $regiones;
        } else {
            return null;
        }
    }

    /**
     * Este método nos permitirá cargar un objeto de la clase Location según el idLocation.
     * @param string $c_location_id <p>Es el id único de la ubicación almacenada en la base de datos.</p>
     */
    public static function Load($db, $c_location_id) {

        $objLocation = new Location();

        // PREPARAMOS LA CONSULTA
        $queryLocation = "SELECT loc.c_location_id, loc.ad_client_id, loc.ad_org_id, loc.isactive, loc.created, loc.createdby, loc.updated, loc.updatedby, loc.address1, loc.address2, loc.city, loc.c_region_id, loc.c_country_id, loc.postal, reg.name as nombre_region,cou.name as nombre_pais FROM c_location loc left join c_region reg on loc.c_region_id = reg.c_region_id left join c_country cou on loc.c_country_id = cou.c_country_id WHERE loc.c_location_id = '$c_location_id';";

        // EJECUTAMOS LA CONSULTA
        $result_set = $db->query($queryLocation);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);

        if (count($result_set) > 0) {
            $rs = $result_set[0];
            foreach ($rs as $name => $value) {
                $objLocation->$name = $value;
            }
            return $objLocation;
        } else {
            return null;
        }
    }

    /**
     * Este método nos permitirá guardar la ubicación de un cliente.
     */
    public function SaveLocation($db) {

        // PREPARAMOS LA CONSULTA
        $queryLocation = sprintf("INSERT INTO c_location(c_location_id, ad_client_id, ad_org_id, isactive, created, createdby, updated, updatedby, address1, address2, city, c_region_id, c_country_id, postal,regionname) VALUES ('%s', '%s', '%s','%s', %s, '%s', %s, '%s', '%s', '%s', '%s', '%s', '%s','%s','%s')", $this->getC_location_id(), $this->getAd_client_id(), $this->getAd_org_id(), $this->getIsactive(), $this->getCreated(), $this->getCreatedby(), $this->getUpdated(), $this->getUpdatedby(), $this->getAddress1(), $this->getAddress2(), $this->getCity(), $this->getC_region_id(), $this->getC_country_id(), $this->getPostal(),  $this->getNombreRegion());

        // Ejecutamos la consulta y retornamos el estado de la transacción
        $success = $db->execute($queryLocation);

        return $success;
    }

}

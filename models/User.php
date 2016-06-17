<?php

/**
 * 
 * @author Harold
 */

use Phalcon\Db;

class User{

    public $userId;
    public $username;
    public $password;
    public $name;
    public $lastname;
    public $orgId;
    public $orgName;
    public $orgParentId;
    public $orgParentName;
    public $adRoleId;
    public $adClientId;
    public $cBPartnerId;

    public function __construct($username, $password) {
        $this->userId = strtoupper(md5(uniqid()));
        $this->username = $username;
        $this->password = $password;
        $this->name = "";
        $this->lastname = "";
        $this->orgId = "";
        $this->orgName = "";
        $this->orgParentId = "";
        $this->orgParentName = "";
        $this->adRoleId = "";
        $this->adClientId = "";
        $this->cBPartnerId = "";
    }
    public function get_lastname() {
        return $this->lastname;
    }

    public function set_lastname($lastname) {
        $this->lastname = $lastname;
    }

        
    public function get_userId() {
        return $this->userId;
    }

    public function get_username() {
        return $this->username;
    }

    public function get_password() {
        return $this->password;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_orgId() {
        return $this->orgId;
    }

    public function get_orgName() {
        return $this->orgName;
    }

    public function get_orgParentId() {
        return $this->orgParentId;
    }

    public function get_orgParentName() {
        return $this->orgParentName;
    }

    public function get_adRoleId() {
        return $this->adRoleId;
    }

    public function get_adClientId() {
        return $this->adClientId;
    }

    public function get_cBPartnerId() {
        return $this->cBPartnerId;
    }

    public function set_userId($userId) {
        $this->userId = $userId;
    }

    public function set_username($username) {
        $this->username = $username;
    }

    public function set_password($password) {
        $this->password = $password;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_orgId($orgId) {
        $this->orgId = $orgId;
    }

    public function set_orgName($orgName) {
        $this->orgName = $orgName;
    }

    public function set_orgParentId($orgParentId) {
        $this->orgParentId = $orgParentId;
    }

    public function set_orgParentName($orgParentName) {
        $this->orgParentName = $orgParentName;
    }

    public function set_adRoleId($adRoleId) {
        $this->adRoleId = $adRoleId;
    }

    public function set_adClientId($adClientId) {
        $this->adClientId = $adClientId;
    }

    public function set_cBPartnerId($cBPartnerId) {
        $this->cBPartnerId = $cBPartnerId;
    }

    /**
     * Esta función nos devolverá un usuario, si existe, en base a su <b>username</b> y su <b>orgId</b>. 
     * @param DI $db Es una instancia del DB service registrado.
     * @param string $username El nombre de usuario único.
     * @param string $orgId EL id de la organización hija a la que pertenece el usuario.
     * @param string $adClientId Es el ID único del cliente al cual pertenece el usuario.
     */
    public static function Load($db,$username, $orgId, $adClientId) {
        
        $sql = "select u.ad_user_id,u.username,u.firstname,u.lastname,u.password,ur.ad_role_id, u.c_bpartner_id, o.name as org_name, o.ad_org_id
from ad_user u inner join ad_user_roles ur on ur.ad_user_id = u.ad_user_id inner join ad_org o on o.ad_org_id = '$orgId' where u.username='$username'";

        $result_set = $db->query($sql);
        $result_set->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $result_set = $result_set->fetchAll($result_set);


        if (count($result_set) > 0) {
            // $result_set es un array con múltiples filas, pero solo tomaremos la primera, es decir la fila [0]
            $rs = $result_set[0];
            $usuario = new User($rs['username'], $rs['password']);
            $usuario->set_userId($rs['ad_user_id']);
            $usuario->set_name($rs['firstname']);
            $usuario->set_lastname($rs['lastname']);
            $usuario->set_cBPartnerId($rs['c_bpartner_id']);
            $usuario->set_adRoleId($rs['ad_role_id']);
            $usuario->set_adClientId($adClientId);
            return $usuario;
        } else {
            return NULL;
        }
    }

}

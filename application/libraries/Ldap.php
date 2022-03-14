<?php

/**
 * Description of Ldap
 *
 * @author fanambinantsoa
 */
class Ldap {

    const ERROR_EMPTY_USER = 0x01;
    const ERROR_EMPTY_PASSWORD = 0x02;
    const ERROR_SERVER_UNREACHEABLE = 0x03;
    const ERROR_PROTOCOL_V1 = 0x04;
    const ERROR_PROTOCOL_V2 = 0x05;
    const ERROR_LOGIN = 0x06;
    const ERROR_ACCESS = 0x07;

    protected $host;
    protected $port;
    protected $conn;
    protected $bind;

    /**
     * Constructeur
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Connect to ldap server
     * @return type
     */
    public function connect() {
        // connexion
        $this->conn = ldap_connect($this->host, $this->port);
        if (!$this->conn)
            return self::ERROR_SERVER_UNREACHEABLE;

        // option v1
        $res1 = ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        if (!$res1)
            return self::ERROR_PROTOCOL_V1;

        // option v2
        $res2 = ldap_set_option($this->conn, LDAP_OPT_REFERRALS, 0);
        if (!$res2)
            return self::ERROR_PROTOCOL_V2;
        return true;
    }

    /**
     * Authentification LDAP
     * @param string $user
     * @param string $pass
     * @return int
     */
    public function auth($user, $pass) {
        $filteredUser = "TELMA\\" . trim($user);
        $filteredPass = trim($pass);
        if (empty($user))
            return self::ERROR_EMPTY_USER;
        if (empty($filteredPass))
            return self::ERROR_EMPTY_PASSWORD;

        if (!$this->conn)
            return self::ERROR_SERVER_UNREACHEABLE;

        $this->bind = @ldap_bind($this->conn, $filteredUser, $filteredPass);
        if (!$this->bind)
            return self::ERROR_LOGIN;

       //$hasAccess = $this->userIsInGroup("OU=Utilisateurs,DC=corp,DC=telma,DC=mg", $filteredUser, "AccessProdKPI");
       //$hasAccess |= $this->userIsInGroup("OU=UtilisateursDirecteurs,DC=corp,DC=telma,DC=mg", $filteredUser, "AccessProdKPI");

        //return $hasAccess ? true : self::ERROR_ACCESS;
        return true ;
    }

    /**
     * 
     * @param type $dn
     * @param type $login
     * @return boolean
     */
    private function userIsInGroup($dn, $login, $group_name) {
        if (!$this->bind)
            return self::ERROR_LOGIN;
        $search = ldap_search($this->conn, $dn, "SAMAccountName=" . $login);
        $info = ldap_get_entries($this->conn, $search);
        for ($i = 0; $i < $info["count"]; $i++) {
            foreach ($info[$i]['memberof'] as $group) {
                $temp = str_replace("CN=", "", substr($group, 0, strpos($group, ",")));
                if ($temp == $group_name)
                    return true;
            }
        }
        return false;
    }

    /**
     * Close connexion
     */
    public function __destruct() {
        if ($this->conn)
            ldap_close($this->conn);
    }

}

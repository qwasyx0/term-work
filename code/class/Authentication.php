<?php


class Authentication
{
    static private $instance = NULL;
    static private $identity = NULL;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new Authentication();
        }
        return self::$instance;
    }

    function __construct()
    {
        if (isset($_SESSION['identity'])) {
            self::$identity = $_SESSION['identity'];
        }
    }

    function login(string $email, string $password)
    {
        $db = new Database();
        $db->query('SELECT * FROM uzivatele WHERE email= :email and password = :password');
        $db->bind(":email", $email);
        $db->bind(":password", $password);
        $r = $db->single();

        if ($r != false) {
            if (count($r) > 0) {
                $profil = array('idciselpod' => $r['idciselpod'],'email' => $r['email'], 'role' => $r['role']);
                $_SESSION['identity'] = $profil;
                self::$identity = $profil;
                return true;
            } else {
                self::$identity = NULL;
                return false;
            }
        } else {
            return false;
        }
    }

    function hasIdentity()
    {
        if (self::$identity == NULL) {
            return false;
        }
        return true;
    }

    function getIdentity()
    {
        if (self::$identity == NULL) {
            return false;
        }
        return self::$identity;
    }

    function logout()
    {
        unset($_SESSION['identity']);
        $_SESSION = array();
        session_destroy();
        self::$identity = NULL;
    }
}
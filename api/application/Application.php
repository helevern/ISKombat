<?php
//responsing to client
require_once('ISKombat/ISKombat.php');
require_once("user/User.php");
require_once("db/DB.php");
require_once("lobby/Lobby.php");

class Application {

    function __construct() {
        $db = new DB();
        $this->user = new User($db);
        $this->lobby = new Lobby($db);
        $this->iskombat = new ISKombat();
    } 

    // user
    public function login($params) {
        if ($params["login"] && $params["pass"]) {
            return $this->user->login($params["login"], $params["pass"]);
        }
        return false;
    }

    public function register($params) {
        if ($params["login"] && $params["pass"]) {
            return $this->user->register($params["login"], $params["pass"]);
        }
        return false;
    }

    public function logout($params) {
        if ($params["token"]) {
            return $this->user->logout($params["token"]);
        }
        return false;
    }

    public function getAllUsers($params) {
        if ($params['token']) {
            $user = $this->user->getUserByToken($params['token']);
            if ($user) {
                return $this->lobby->getLobbyUsers($user->id);
            }
        }
        return false;
    }

    public function newChallenge($params) {
        if ($params['token'] && $params['id']) {
            $user = $this->user->getUserByToken($params['token']);
            if ($user) {
                $this->lobby->newChallenge($user->id, $params['id']);
            }
        }
        return false;
    }

    // game
    public function move($params) {
        if ($params["token"]) {
            $user = $this->db->getUserByToken($params["token"]);
            if ($user && $params["direction"]) {
                return $this->iskombat->move(
                    $user->id,           
                    $params['direction'] 
                );
            }
        }
        return false;
    }

    public function hit($params) {
        if ($params["id"] && $params["hitType"]) {
            return $this->iskombat->hit(
                $params['id'],       
                $params['hitType']     
            );
        }
        return false;
    }

    public function setState($params) {
        if ($params["id"] && $params["state"]) {
            return $this->iskombat->setState(
                $params['id'],      
                $params['state']      
            );
        }
        return false;
    }
}

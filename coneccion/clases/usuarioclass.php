<?php

class USUARIOCLASS {
    
    //tabla userapp
    private int $id_userapp;
    private string $mail_user;
    private string $pass_user;

    public function __construct() {}

    //Getter
    public function getIduser() { return $this->id_userapp; }
    public function getMail() { return $this->mail_user; }
    public function getClave() { return $this->pass_user; }
        
    //Setter
    public function setIduser($id_userapp) { $this->id_userapp = $id_userapp; }
    public function setMail($mail_user) { $this->mail_user = $mail_user; }
    public function setClave($pass_user) { $this->pass_user = $pass_user; }

}

?>
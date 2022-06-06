<?php

class Reset_password
{
    private string $id_user;
    private string $mail;

    function __construct(string $id_user, string $mail) {
        $this->id_user=$id_user;
        $this->mail=$mail;
    }

    public function getIdUser(): string
    {
        return $this->id_user;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

}
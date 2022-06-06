<?php

class Login
{
    private string $login;
    private string $password;

    function __construct(string $login, string $password) {
        $this->login=$login;
        $this->password=$password;
    }

    public function getLogin(): string
    {
        return  $this->login;
    }

    public function getPassword(): string
    {
        return  $this->password;
    }
}
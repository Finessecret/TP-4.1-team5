<?php

class User
{
private string $name;
private string $login;
private string $password;
private int $facutyCode;
private int $userCode;
private int $groupCode;

    function __construct(string $name, string $login, string $password, int $facutyCode, int $userCode, $groupCode) {
        $this->name=$name;
        $this->login=$login;
        $this->password=$password;
        $this->facutyCode=$facutyCode;
        $this->userCode=$userCode;
        $this->groupCode=$groupCode;
    }

    public function getName(): string
    {
        return  $this->name;
    }

    public function getLogin(): string
    {
        return  $this->login;
    }

    public function getPassword(): string
    {
        return  $this->password;
    }

    public function getFacutyCode(): string
    {
        return  $this->facutyCode;
    }

    public function getUserCode(): string
    {
        return  $this->userCode;
    }

    public function getGroupCode(): string
    {
        return  $this->groupCode;
    }
}
?>
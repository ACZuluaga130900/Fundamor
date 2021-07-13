<?php

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    private $op;
    private $host = "http://localhost";

    public function setUp(): void
    {
        $this->op = new AdminTest();
    }

    public function testSumar()
    {
        $this->assertEquals(7, $this->op->sumar(5, 2));
    }

    public function testConsultaReadHistory()
    {
        $req = "/maltrato_animal/model/admin.php?action=readHistory";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaReadUsers()
    {
        $req = "/maltrato_animal/model/admin.php?action=readUsers";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaReadRols()
    {
        $req = "/maltrato_animal/model/admin.php?action=readRols";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaReadDocumentType()
    {
        $req = "/maltrato_animal/model/admin.php?action=readDocumentType";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaReadCrypto()
    {
        $req = "/maltrato_animal/model/admin.php?action=readCrypto";
        $data = [
            "text" => "U2FsdGVkX1+b6+tux5jzUNLTb/sP8LaRBuW+rS2QugI=",
        ];
        $this->assertEquals(true, $this->op->consultaData($this->host, $req, $data));
    }

    public function testConsultaReadUser()
    {
        $req = "/maltrato_animal/model/admin.php?action=readUser";
        $data = [
            "document_number" => "1094975613",
        ];
        $this->assertEquals(true, $this->op->consultaData($this->host, $req, $data));
    }

    public function testConsultaCreateHistory()
    {
        $req = "/maltrato_animal/model/admin.php?action=createHistory";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaCreateUser()
    {
        $req = "/maltrato_animal/model/admin.php?action=createUser";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaCreateCrypto()
    {
        $req = "/maltrato_animal/model/admin.php?action=createCrypto";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaUpdateUser()
    {
        $req = "/maltrato_animal/model/admin.php?action=UpdateUser";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }

    public function testConsultaDeleteCrypto()
    {
        $req = "/maltrato_animal/model/admin.php?action=deleteUser";
        $this->assertEquals(true, $this->op->consulta($this->host, $req));
    }
}

<?php
class Conexao {
    private $host = 'localhost';
    private $banco = 'sistema';
    private $usuario = 'root';
    private $senha = '';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->banco;charset=utf8mb4", $this->usuario, $this->senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexão falhou: " . $e->getMessage());
        }
    }

    public function conectar() {
        return $this->pdo;
    }
}
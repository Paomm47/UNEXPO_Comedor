<?php

namespace App\Models;

use Config\Connect;
use PDO;
use PDOException;

class comensalmodel extends Connect
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT 
                    c.Cedula_Comensal, 
                    c.PrimerNombre, 
                    c.SegundoNombre, 
                    c.PrimerApellido, 
                    c.SegundoApellido, 
                    c.Genero, 
                    c.Codigo_Tipocomensal,
                    t.Nombre AS TipoNombre,
                    c.Codigo_Nucleo,
                    n.Nombre AS NucleoNombre,
                    c.Codigo_Departamento,
                    d.Nombre AS DepartamentoNombre,
                    c.Estado
                FROM comensales c
                LEFT JOIN tiposcomensales t ON c.Codigo_Tipocomensal = t.Codigo_Tipocomensal
                LEFT JOIN nucleos n ON c.Codigo_Nucleo = n.Codigo_Nucleo
                LEFT JOIN departamentos d ON c.Codigo_Departamento = d.Codigo_Departamento";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(string $cedula): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM comensales WHERE Cedula_Comensal = ?");
        $stmt->execute([$cedula]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO comensales (
                    Cedula_Comensal, PrimerNombre, SegundoNombre, 
                    PrimerApellido, SegundoApellido, Genero, 
                    Codigo_Tipocomensal, Codigo_Nucleo, Codigo_Departamento, Estado
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['cedula'],
            $data['pnom'],
            $data['snom'],
            $data['pape'],
            $data['sape'],
            $data['genero'],
            $data['tipo'],
            $data['nucleo'],
            $data['departamento'],
            $data['estado']
        ]);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE comensales SET 
                    PrimerNombre = ?, 
                    SegundoNombre = ?, 
                    PrimerApellido = ?, 
                    SegundoApellido = ?, 
                    Genero = ?, 
                    Codigo_Tipocomensal = ?, 
                    Codigo_Nucleo = ?, 
                    Codigo_Departamento = ?, 
                    Estado = ?
                WHERE Cedula_Comensal = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['pnom'],
            $data['snom'],
            $data['pape'],
            $data['sape'],
            $data['genero'],
            $data['tipo'],
            $data['nucleo'],
            $data['departamento'],
            $data['estado'],
            $data['cedula']
        ]);
    }

    public function delete(string $cedula): bool
    {
        $stmt = $this->db->prepare("DELETE FROM comensales WHERE Cedula_Comensal = ?");
        return $stmt->execute([$cedula]);
    }

    public function getTiposComensal(): array
    {
        $stmt = $this->db->query("SELECT * FROM tiposcomensales");
        return $stmt->fetchAll();
    }

    public function getNucleos(): array
    {
        $stmt = $this->db->query("SELECT * FROM nucleos");
        return $stmt->fetchAll();
    }

    public function getDepartamentos(): array
    {
        $stmt = $this->db->query("SELECT * FROM departamentos");
        return $stmt->fetchAll();
    }
}

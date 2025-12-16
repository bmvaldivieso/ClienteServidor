<?php
/**
 * Modelo de Préstamo (Loan)
 * Acceso a datos para gestionar préstamos de equipos.
 */

require_once __DIR__ . '/../config/database.php';

class Loan {
    private $db;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    /**
     * Obtiene todos los préstamos uniendo con la tabla de miembros
     */
    public function getAll() {
        // Usamos JOIN para traer el nombre del miembro en lugar de solo su ID
        $sql = "SELECT l.*, m.name as member_name 
                FROM loans l 
                JOIN members m ON l.member_id = m.id 
                ORDER BY l.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM loans WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO loans (member_id, equipment_name, loan_date, notes) 
                VALUES (:member_id, :equipment_name, :loan_date, :notes)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'member_id' => $data['member_id'],
            'equipment_name' => $data['equipment_name'],
            'loan_date' => $data['loan_date'],
            'notes' => $data['notes'] ?? null
        ]);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE loans 
                SET member_id = :member_id, 
                    equipment_name = :equipment_name, 
                    loan_date = :loan_date,
                    return_date = :return_date,
                    status = :status,
                    notes = :notes
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Si el estado cambia a 'returned' y no hay fecha, asignamos hoy
        $returnDate = $data['return_date'];
        if ($data['status'] === 'returned' && empty($returnDate)) {
            $returnDate = date('Y-m-d');
        }

        return $stmt->execute([
            'id' => $id,
            'member_id' => $data['member_id'],
            'equipment_name' => $data['equipment_name'],
            'loan_date' => $data['loan_date'],
            'return_date' => $returnDate ?: null,
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM loans WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
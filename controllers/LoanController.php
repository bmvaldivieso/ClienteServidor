<?php
/**
 * Controlador de Préstamos
 */

require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Member.php'; // Necesario para listar miembros

class LoanController {
    private $loanModel;
    private $memberModel;
    
    public function __construct() {
        $this->loanModel = new Loan();
        $this->memberModel = new Member();
    }
    
    public function index() {
        $loans = $this->loanModel->getAll();
        require_once __DIR__ . '/../views/loans/index.php';
    }
    
    public function create() {
        // Obtenemos miembros para el <select>
        $members = $this->memberModel->getAll(); // Asumiendo que Member tiene getAll()
        $errors = [];
        require_once __DIR__ . '/../views/loans/create.php';
    }
    
    public function store() {
        $errors = $this->validate($_POST);
        
        if (empty($errors)) {
            $this->loanModel->create($_POST);
            header('Location: /index.php?controller=loan&action=index&success=created');
            exit;
        }
        
        // Si hay error, recargamos la lista de miembros para el formulario
        $members = $this->memberModel->getAll();
        require_once __DIR__ . '/../views/loans/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) header('Location: /index.php?controller=loan&action=index');
        
        $loan = $this->loanModel->getById($id);
        $members = $this->memberModel->getAll(); // Para el select en edición
        $errors = [];
        
        if (!$loan) header('Location: /index.php?controller=loan&action=index&error=not_found');
        
        require_once __DIR__ . '/../views/loans/edit.php';
    }
    
    public function update() {
        $id = $_POST['id'] ?? null;
        $errors = $this->validate($_POST);
        
        if (empty($errors)) {
            $this->loanModel->update($id, $_POST);
            header('Location: /index.php?controller=loan&action=index&success=updated');
            exit;
        }
        
        $loan = $this->loanModel->getById($id);
        $members = $this->memberModel->getAll();
        require_once __DIR__ . '/../views/loans/edit.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) $this->loanModel->delete($id);
        header('Location: /index.php?controller=loan&action=index&success=deleted');
        exit;
    }
    
    private function validate($data) {
        $errors = [];
        if (empty($data['member_id'])) $errors['member_id'] = 'Debe seleccionar un miembro';
        if (empty($data['equipment_name'])) $errors['equipment_name'] = 'El nombre del equipo es requerido';
        if (empty($data['loan_date'])) $errors['loan_date'] = 'La fecha de préstamo es requerida';
        return $errors;
    }
}
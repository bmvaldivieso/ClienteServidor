<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Préstamo / Devolución</h2>

<form method="POST" action="/index.php?controller=loan&action=update" class="form">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($loan['id']); ?>">
    
    <div class="form-group">
        <label for="member_id">Miembro *</label>
        <select id="member_id" name="member_id" required>
            <?php foreach ($members as $member): ?>
                <option value="<?php echo $member['id']; ?>" <?php echo ($loan['member_id'] == $member['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($member['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="equipment_name">Equipo *</label>
        <input type="text" id="equipment_name" name="equipment_name" required 
               value="<?php echo htmlspecialchars($loan['equipment_name']); ?>">
    </div>
    
    <div class="form-group">
        <label for="loan_date">Fecha Préstamo *</label>
        <input type="date" id="loan_date" name="loan_date" required 
               value="<?php echo htmlspecialchars($loan['loan_date']); ?>">
    </div>

    <hr>

    <div class="form-group">
        <label for="status">Estado del Préstamo *</label>
        <select id="status" name="status" required onchange="toggleReturnDate()">
            <option value="active" <?php echo $loan['status'] === 'active' ? 'selected' : ''; ?>>Prestado (Activo)</option>
            <option value="returned" <?php echo $loan['status'] === 'returned' ? 'selected' : ''; ?>>Devuelto</option>
        </select>
    </div>

    <div class="form-group">
        <label for="return_date">Fecha de Devolución</label>
        <input type="date" id="return_date" name="return_date" 
               value="<?php echo htmlspecialchars($loan['return_date'] ?? ''); ?>">
        <small>Dejar en blanco para usar la fecha de hoy al devolver.</small>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="/index.php?controller=loan&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
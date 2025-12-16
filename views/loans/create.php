<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Registrar Préstamo</h2>

<form method="POST" action="/index.php?controller=loan&action=store" class="form">
    <div class="form-group">
        <label for="member_id">Miembro *</label>
        <select id="member_id" name="member_id" required>
            <option value="">Seleccione un miembro...</option>
            <?php foreach ($members as $member): ?>
                <option value="<?php echo $member['id']; ?>" <?php echo (isset($_POST['member_id']) && $_POST['member_id'] == $member['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($member['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['member_id'])): ?>
            <span class="error-message"><?php echo htmlspecialchars($errors['member_id']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="equipment_name">Equipo Prestado *</label>
        <input type="text" id="equipment_name" name="equipment_name" required 
               placeholder="Ej: Balón Medicinal 5kg"
               value="<?php echo htmlspecialchars($_POST['equipment_name'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label for="loan_date">Fecha de Préstamo *</label>
        <input type="date" id="loan_date" name="loan_date" required 
               value="<?php echo htmlspecialchars($_POST['loan_date'] ?? date('Y-m-d')); ?>">
    </div>

    <div class="form-group">
        <label for="notes">Notas Adicionales</label>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
        <a href="/index.php?controller=loan&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
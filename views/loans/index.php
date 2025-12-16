<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Gestión de Préstamos</h2>

<div class="actions">
    <a href="/index.php?controller=loan&action=create" class="btn btn-primary">➕ Nuevo Préstamo</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Miembro</th>
            <th>Equipo</th>
            <th>Fecha Préstamo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($loans)): ?>
            <tr><td colspan="6" class="text-center">No hay préstamos activos</td></tr>
        <?php else: ?>
            <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?php echo htmlspecialchars($loan['id']); ?></td>
                    <td><?php echo htmlspecialchars($loan['member_name']); ?></td>
                    <td><?php echo htmlspecialchars($loan['equipment_name']); ?></td>
                    <td><?php echo htmlspecialchars($loan['loan_date']); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $loan['status'] === 'active' ? 'warning' : 'success'; ?>">
                            <?php echo $loan['status'] === 'active' ? 'Prestado' : 'Devuelto'; ?>
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="/index.php?controller=loan&action=edit&id=<?php echo $loan['id']; ?>" class="btn btn-sm btn-secondary">Editar/Devolver</a>
                        <a href="/index.php?controller=loan&action=delete&id=<?php echo $loan['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('¿Eliminar registro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
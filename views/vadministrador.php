<?php
session_start();
if (!isset($_SESSION['idusuario']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

// Obtener estadísticas
$stmt = $pdo->query("SELECT COUNT(*) as total FROM usuario WHERE idubi IS NOT NULL");
$totalUsuarios = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM paseador");
$totalPaseadores = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM mascotas");
$totalMascotas = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM paseo WHERE estado = 'activo'");
$paseosActivos = $stmt->fetch()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UrbanPaws</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav style="background-color: var(--primary-blue); padding: 1rem 2rem;">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <div style="color: white; font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-paw"></i> UrbanPaws Admin
            </div>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="admin_dashboard.php" style="color: white; text-decoration: none;">Dashboard</a>
                <a href="admin_usuarios.php" style="color: white; text-decoration: none;">Usuarios</a>
                <a href="admin_paseadores.php" style="color: white; text-decoration: none;">Paseadores</a>
                <a href="admin_paseos.php" style="color: white; text-decoration: none;">Paseos</a>
                <div style="display: flex; align-items: center; gap: 0.5rem; color: white;">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $_SESSION['nombre']; ?></span>
                    <a href="logout.php" style="color: white; margin-left: 1rem;">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div style="max-width: 1400px; margin: 2rem auto; padding: 0 2rem;">
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="card" style="border-left: 4px solid var(--primary-blue);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Total Usuarios</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $totalUsuarios; ?></h3>
                    </div>
                    <i class="fas fa-users" style="font-size: 2.5rem; color: var(--primary-blue); opacity: 0.3;"></i>
                </div>
            </div>

            <div class="card" style="border-left: 4px solid var(--primary-orange);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Paseadores</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $totalPaseadores; ?></h3>
                    </div>
                    <i class="fas fa-walking" style="font-size: 2.5rem; color: var(--primary-orange); opacity: 0.3;"></i>
                </div>
            </div>

            <div class="card" style="border-left: 4px solid var(--success);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Mascotas Registradas</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $totalMascotas; ?></h3>
                    </div>
                    <i class="fas fa-dog" style="font-size: 2.5rem; color: var(--success); opacity: 0.3;"></i>
                </div>
            </div>

            <div class="card" style="border-left: 4px solid var(--dark-orange);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Paseos Activos</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $paseosActivos; ?></h3>
                    </div>
                    <i class="fas fa-route" style="font-size: 2.5rem; color: var(--dark-orange); opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Pending Walker Validations -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem; color: var(--dark-blue);">
                <i class="fas fa-clock"></i> Validaciones de Paseadores Pendientes
            </h3>
            <?php
            $stmt = $pdo->query("
                SELECT u.idusuario, u.nomusu, u.email, p.antecedentes, u.telefono
                FROM paseador p
                JOIN usuario u ON p.idpase = u.idusuario
                WHERE p.validado = 0
            ");
            $paseadoresPendientes = $stmt->fetchAll();
            ?>
            
            <?php if (count($paseadoresPendientes) > 0): ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--bg-gray);">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Nombre</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Email</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Teléfono</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Antecedentes</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paseadoresPendientes as $paseador): ?>
                                <tr style="border-bottom: 1px solid var(--border-gray);">
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($paseador['nomusu']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($paseador['email']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($paseador['telefono']); ?></td>
                                    <td style="padding: 12px;">
                                        <?php if ($paseador['antecedentes']): ?>
                                            <span style="color: var(--success);"><i class="fas fa-check"></i> Verificado</span>
                                        <?php else: ?>
                                            <span style="color: var(--danger);"><i class="fas fa-times"></i> Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px;">
                                        <a href="validar_paseador.php?id=<?php echo $paseador['idusuario']; ?>&accion=aprobar" 
                                           class="btn-primary" style="padding: 6px 12px; font-size: 0.875rem;">
                                            <i class="fas fa-check"></i> Aprobar
                                        </a>
                                        <a href="validar_paseador.php?id=<?php echo $paseador['idusuario']; ?>&accion=rechazar" 
                                           class="btn-secondary" style="padding: 6px 12px; font-size: 0.875rem; background-color: var(--danger);">
                                            <i class="fas fa-times"></i> Rechazar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: var(--text-gray); text-align: center; padding: 2rem;">
                    No hay validaciones pendientes
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
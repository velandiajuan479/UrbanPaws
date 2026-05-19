<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
$idPaseador = $_SESSION['idusuario'];

// Verificar si es paseador y está validado
$stmt = $pdo->prepare("SELECT * FROM paseador WHERE idpase = ?");
$stmt->execute([$idPaseador]);
$paseador = $stmt->fetch();

if (!$paseador) {
    header('Location: registro_paseador.php');
    exit();
}

// Obtener paseos asignados
$stmt = $pdo->prepare("
    SELECT p.*, m.nombre as nombre_mascota, u.nomusu as nombre_dueno, u.telefono
    FROM paseo p
    JOIN mascotas m ON p.idmasc = m.idmasc
    JOIN duenomasc d ON m.iddueno = d.iddueno
    JOIN usuario u ON d.iddueno = u.idusuario
    WHERE p.idpase = ?
    ORDER BY p.fecha DESC
");
$stmt->execute([$idPaseador]);
$paseosAsignados = $stmt->fetchAll();

// Estadísticas del paseador
$stmt = $pdo->prepare("
    SELECT COUNT(*) as total, 
           SUM(CASE WHEN estado = 'completado' THEN 1 ELSE 0 END) as completados,
           SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as activos
    FROM paseo
    WHERE idpase = ?
");
$stmt->execute([$idPaseador]);
$estadisticas = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Paseador - UrbanPaws</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav style="background-color: var(--primary-orange); padding: 1rem 2rem;">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <div style="color: white; font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-walking"></i> UrbanPaws Paseadores
            </div>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="paseador_dashboard.php" style="color: white; text-decoration: none;">Inicio</a>
                <a href="mis_paseos.php" style="color: white; text-decoration: none;">Mis Paseos</a>
                <a href="mi_disponibilidad.php" style="color: white; text-decoration: none;">Disponibilidad</a>
                <a href="mis_ganancias.php" style="color: white; text-decoration: none;">Ganancias</a>
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
        <!-- Validación Status -->
        <?php if (!$paseador['validado']): ?>
            <div class="card" style="background-color: #fef3c7; border-left: 4px solid var(--primary-orange);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: var(--primary-orange);"></i>
                    <div>
                        <h4 style="color: #92400e; margin-bottom: 0.25rem;">Cuenta en validación</h4>
                        <p style="color: #78350f;">
                            Tu perfil está siendo revisado. Incluye validación de antecedentes, datos personales y ubicación.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="card" style="border-left: 4px solid var(--primary-orange);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Total Paseos</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $estadisticas['total']; ?></h3>
                    </div>
                    <i class="fas fa-route" style="font-size: 2.5rem; color: var(--primary-orange); opacity: 0.3;"></i>
                </div>
            </div>

            <div class="card" style="border-left: 4px solid var(--success);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Completados</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $estadisticas['completados']; ?></h3>
                    </div>
                    <i class="fas fa-check-circle" style="font-size: 2.5rem; color: var(--success); opacity: 0.3;"></i>
                </div>
            </div>

            <div class="card" style="border-left: 4px solid var(--primary-blue);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Paseos Activos</p>
                        <h3 style="font-size: 2rem; margin-top: 0.5rem;"><?php echo $estadisticas['activos']; ?></h3>
                    </div>
                    <i class="fas fa-clock" style="font-size: 2.5rem; color: var(--primary-blue); opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Paseos Asignados -->
        <div class="card">
            <h3 style="color: var(--dark-blue); margin-bottom: 1.5rem;">
                <i class="fas fa-clipboard-list"></i> Mis Paseos Asignados
            </h3>

            <?php if (count($paseosAsignados) > 0): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php foreach ($paseosAsignados as $paseo): ?>
                        <div style="border: 2px solid var(--border-gray); border-radius: 8px; padding: 1.5rem; 
                                    background-color: <?php echo $paseo['estado'] == 'activo' ? '#eff6ff' : 'white'; ?>;">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <h4 style="font-size: 1.25rem; color: var(--dark-blue);">
                                            <?php echo htmlspecialchars($paseo['nombre_mascota']); ?>
                                        </h4>
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;
                                                    background-color: <?php 
                                                        echo $paseo['estado'] == 'activo' ? 'var(--primary-blue)' : 
                                                            ($paseo['estado'] == 'completado' ? 'var(--success)' : 'var(--bg-gray)'); 
                                                    ?>; color: white;">
                                            <?php echo ucfirst($paseo['estado']); ?>
                                        </span>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; color: var(--text-gray);">
                                        <p><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($paseo['fecha'])); ?></p>
                                        <p><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($paseo['fecha'])); ?></p>
                                        <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($paseo['nombre_dueno']); ?></p>
                                        <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($paseo['telefono']); ?></p>
                                    </div>
                                </div>
                                
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="ver_detalle_paseo.php?id=<?php echo $paseo['idpaseo']; ?>" 
                                       class="btn-secondary" style="padding: 8px 16px;">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <?php if ($paseo['estado'] == 'activo'): ?>
                                        <a href="iniciar_paseo.php?id=<?php echo $paseo['idpaseo']; ?>" 
                                           class="btn-primary" style="padding: 8px 16px;">
                                            <i class="fas fa-play"></i> Iniciar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 3rem; color: var(--text-gray);">
                    <i class="fas fa-inbox" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>No tienes paseos asignados aún</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información del Paseador -->
        <div class="card" style="margin-top: 1.5rem;">
            <h3 style="color: var(--dark-blue); margin-bottom: 1.5rem;">
                <i class="fas fa-user-check"></i> Mi Perfil de Paseador
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div style="padding: 1rem; background-color: var(--bg-gray); border-radius: 8px;">
                    <p style="color: var(--text-gray); font-size: 0.875rem; margin-bottom: 0.25rem;">Antecedentes</p>
                    <p style="font-weight: 600;">
                        <?php if ($paseador['antecedentes']): ?>
                            <span style="color: var(--success);"><i class="fas fa-check"></i> Verificados</span>
                        <?php else: ?>
                            <span style="color: var(--danger);"><i class="fas fa-times"></i> Pendiente</span>
                        <?php endif; ?>
                    </p>
                </div>
                
                <div style="padding: 1rem; background-color: var(--bg-gray); border-radius: 8px;">
                    <p style="color: var(--text-gray); font-size: 0.875rem; margin-bottom: 0.25rem;">Estado de Validación</p>
                    <p style="font-weight: 600;">
                        <?php if ($paseador['validado']): ?>
                            <span style="color: var(--success);"><i class="fas fa-check"></i> Validado</span>
                        <?php else: ?>
                            <span style="color: var(--primary-orange);"><i class="fas fa-clock"></i> En revisión</span>
                        <?php endif; ?>
                    </p>
                </div>
                
                <div style="padding: 1rem; background-color: var(--bg-gray); border-radius: 8px;">
                    <p style="color: var(--text-gray); font-size: 0.875rem; margin-bottom: 0.25rem;">Foto de Perfil</p>
                    <p style="font-weight: 600;">
                        <?php if ($paseador['foto']): ?>
                            <span style="color: var(--success);"><i class="fas fa-check"></i> Cargada</span>
                        <?php else: ?>
                            <span style="color: var(--danger);"><i class="fas fa-times"></i> No cargada</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            
            <a href="editar_perfil_paseador.php" class="btn-primary" style="margin-top: 1rem;">
                <i class="fas fa-edit"></i> Editar Información
            </a>
        </div>
    </div>
</body>
</html>
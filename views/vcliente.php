<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
$idUsuario = $_SESSION['idusuario'];

// Obtener mascotas del cliente
$stmt = $pdo->prepare("
    SELECT m.*, d.iddueno
    FROM mascotas m
    JOIN duenomasc d ON m.iddueno = d.iddueno
    WHERE d.iddueno = ?
");
$stmt->execute([$idUsuario]);
$mascotas = $stmt->fetchAll();

// Obtener paseos recientes
$stmt = $pdo->prepare("
    SELECT p.*, pa.nomusu as nombre_paseador, m.nombre as nombre_mascota
    FROM paseo p
    LEFT JOIN paseador pas ON p.idpase = pas.idpase
    LEFT JOIN usuario pa ON pas.idpase = pa.idusuario
    LEFT JOIN mascotas m ON p.idmasc = m.idmasc
    WHERE p.iddueno = ?
    ORDER BY p.fecha DESC
    LIMIT 5
");
$stmt->execute([$idUsuario]);
$paseosRecientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - UrbanPaws</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav style="background-color: var(--primary-blue); padding: 1rem 2rem;">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <div style="color: white; font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-paw"></i> UrbanPaws
            </div>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="cliente_dashboard.php" style="color: white; text-decoration: none;">Inicio</a>
                <a href="mis_mascotas.php" style="color: white; text-decoration: none;">Mis Mascotas</a>
                <a href="programar_paseo.php" style="color: white; text-decoration: none;">Programar Paseo</a>
                <a href="mis_facturas.php" style="color: white; text-decoration: none;">Facturas</a>
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
        <!-- Welcome Section -->
        <div class="card" style="background: linear-gradient(135deg, var(--primary-blue), var(--light-blue)); color: white;">
            <h2 style="margin-bottom: 0.5rem;">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! 👋</h2>
            <p>¿Listo para pasear a tu mejor amigo?</p>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
            <!-- Mis Mascotas -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="color: var(--dark-blue);">
                        <i class="fas fa-dog"></i> Mis Mascotas
                    </h3>
                    <a href="agregar_mascota.php" class="btn-primary">
                        <i class="fas fa-plus"></i> Agregar
                    </a>
                </div>

                <?php if (count($mascotas) > 0): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                        <?php foreach ($mascotas as $mascota): ?>
                            <div style="border: 2px solid var(--border-gray); border-radius: 8px; padding: 1rem; text-align: center;">
                                <?php if ($mascota['fotvac']): ?>
                                    <img src="<?php echo htmlspecialchars($mascota['fotvac']); ?>" 
                                         alt="<?php echo htmlspecialchars($mascota['nombre']); ?>"
                                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 0.5rem;">
                                <?php else: ?>
                                    <div style="width: 100px; height: 100px; border-radius: 50%; background-color: var(--bg-gray); 
                                                display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem;">
                                        <i class="fas fa-dog" style="font-size: 3rem; color: var(--primary-orange);"></i>
                                    </div>
                                <?php endif; ?>
                                <h4 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($mascota['nombre']); ?></h4>
                                <p style="color: var(--text-gray); font-size: 0.875rem;">
                                    <?php echo htmlspecialchars($mascota['raza']); ?> • <?php echo $mascota['edad']; ?> años
                                </p>
                                <a href="editar_mascota.php?id=<?php echo $mascota['idmasc']; ?>" 
                                   style="color: var(--primary-blue); text-decoration: none; font-size: 0.875rem;">
                                    Ver detalles
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem; color: var(--text-gray);">
                        <i class="fas fa-dog" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p>No tienes mascotas registradas</p>
                        <a href="agregar_mascota.php" class="btn-primary" style="margin-top: 1rem; display: inline-block;">
                            Agregar tu primera mascota
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Próximo Paseo -->
            <div class="card">
                <h3 style="color: var(--dark-blue); margin-bottom: 1.5rem;">
                    <i class="fas fa-calendar-alt"></i> Próximo Paseo
                </h3>
                
                <?php
                $stmt = $pdo->prepare("
                    SELECT p.*, pa.nomusu as nombre_paseador
                    FROM paseo p
                    LEFT JOIN paseador pas ON p.idpase = pas.idpase
                    LEFT JOIN usuario pa ON pas.idpase = pa.idusuario
                    WHERE p.iddueno = ? AND p.fecha >= CURDATE()
                    ORDER BY p.fecha ASC
                    LIMIT 1
                ");
                $stmt->execute([$idUsuario]);
                $proximoPaseo = $stmt->fetch();
                ?>

                <?php if ($proximoPaseo): ?>
                    <div style="background-color: var(--bg-gray); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <p style="font-weight: 600; margin-bottom: 0.5rem;">
                            <i class="fas fa-clock" style="color: var(--primary-orange);"></i> 
                            <?php echo date('d/m/Y H:i', strtotime($proximoPaseo['fecha'])); ?>
                        </p>
                        <p style="color: var(--text-gray); font-size: 0.875rem;">
                            <i class="fas fa-walking"></i> Paseador: <?php echo htmlspecialchars($proximoPaseo['nombre_paseador']); ?>
                        </p>
                    </div>
                    <a href="ver_paseo.php?id=<?php echo $proximoPaseo['idpaseo']; ?>" 
                       class="btn-secondary" style="width: 100%; text-align: center; display: block;">
                        Ver detalles
                    </a>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--text-gray);">
                        <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p style="margin-bottom: 1rem;">No tienes paseos programados</p>
                        <a href="programar_paseo.php" class="btn-primary">
                            Programar ahora
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Historial de Paseos -->
        <div class="card" style="margin-top: 1.5rem;">
            <h3 style="color: var(--dark-blue); margin-bottom: 1.5rem;">
                <i class="fas fa-history"></i> Historial de Paseos Recientes
            </h3>
            
            <?php if (count($paseosRecientes) > 0): ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--bg-gray);">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Fecha</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Mascota</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Paseador</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Estado</th>
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--border-gray);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paseosRecientes as $paseo): ?>
                                <tr style="border-bottom: 1px solid var(--border-gray);">
                                    <td style="padding: 12px;">
                                        <?php echo date('d/m/Y H:i', strtotime($paseo['fecha'])); ?>
                                    </td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($paseo['nombre_mascota']); ?></td>
                                    <td style="padding: 12px;"><?php echo htmlspecialchars($paseo['nombre_paseador'] ?? 'No asignado'); ?></td>
                                    <td style="padding: 12px;">
                                        <?php
                                        $estadoColors = [
                                            'pendiente' => 'var(--primary-orange)',
                                            'activo' => 'var(--primary-blue)',
                                            'completado' => 'var(--success)',
                                            'cancelado' => 'var(--danger)'
                                        ];
                                        $color = $estadoColors[$paseo['estado']] ?? 'var(--text-gray)';
                                        ?>
                                        <span style="color: <?php echo $color; ?>; font-weight: 600;">
                                            <?php echo ucfirst($paseo['estado']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 12px;">
                                        <a href="ver_paseo.php?id=<?php echo $paseo['idpaseo']; ?>" 
                                           style="color: var(--primary-blue); text-decoration: none;">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: var(--text-gray); text-align: center; padding: 2rem;">
                    No tienes paseos registrados
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
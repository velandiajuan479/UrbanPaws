<?php
session_start();
if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
$idUsuario = $_SESSION['idusuario'];

// Obtener datos del usuario
$stmt = $pdo->prepare("
    SELECT u.*, p.* 
    FROM usuario u
    LEFT JOIN perfil p ON u.idperf = p.idperf
    WHERE u.idusuario = ?
");
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch();

// Obtener ubicación
$stmt = $pdo->prepare("SELECT * FROM ubicacion WHERE idubi = ?");
$stmt->execute([$usuario['idubi']]);
$ubicacion = $stmt->fetch();

// Mensaje de éxito/error
$mensaje = $_SESSION['mensaje'] ?? '';
$tipoMensaje = $_SESSION['tipo_mensaje'] ?? '';
unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - UrbanPaws</title>
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
                <a href="dashboard.php" style="color: white; text-decoration: none;">Inicio</a>
                <a href="perfil_usuario.php" style="color: white; text-decoration: none;">Mi Perfil</a>
                <a href="logout.php" style="color: white;">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <div style="max-width: 1000px; margin: 2rem auto; padding: 0 2rem;">
        <?php if ($mensaje): ?>
            <div class="card" style="background-color: <?php echo $tipoMensaje == 'success' ? '#d1fae5' : '#fee2e2'; ?>; 
                                    border-left: 4px solid <?php echo $tipoMensaje == 'success' ? 'var(--success)' : 'var(--danger)'; ?>;">
                <p style="color: <?php echo $tipoMensaje == 'success' ? '#065f46' : '#991b1b'; ?>;">
                    <?php echo htmlspecialchars($mensaje); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="card">
            <h2 style="margin-bottom: 1.5rem; color: var(--dark-blue);">
                <i class="fas fa-user-circle"></i> Mi Perfil
            </h2>

            <form action="procesar_perfil.php" method="POST" enctype="multipart/form-data">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Datos Personales -->
                    <div style="grid-column: 1 / -1;">
                        <h3 style="margin-bottom: 1rem; color: var(--primary-blue); border-bottom: 2px solid var(--border-gray); padding-bottom: 0.5rem;">
                            Datos Personales
                        </h3>
                    </div>

                    <div class="form-group">
                        <label for="nomusu">Nombre completo *</label>
                        <input type="text" id="nomusu" name="nomusu" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['nomusu']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico *</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="edad">Edad</label>
                        <input type="number" id="edad" name="edad" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['edad'] ?? ''); ?>" min="18" max="100">
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="foto">Foto de perfil</label>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <?php if ($usuario['foto']): ?>
                                <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" 
                                     alt="Foto de perfil" 
                                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 80px; height: 80px; border-radius: 50%; background-color: var(--bg-gray); 
                                            display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user" style="font-size: 2.5rem; color: var(--text-gray);"></i>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="foto" name="foto" class="form-control" accept="image/*" 
                                   style="max-width: 300px;">
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div style="grid-column: 1 / -1; margin-top: 1rem;">
                        <h3 style="margin-bottom: 1rem; color: var(--primary-blue); border-bottom: 2px solid var(--border-gray); padding-bottom: 0.5rem;">
                            Ubicación
                        </h3>
                    </div>

                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" id="pais" name="pais" class="form-control" 
                               value="<?php echo htmlspecialchars($ubicacion['pais'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="departamento">Departamento/Estado</label>
                        <input type="text" id="departamento" name="departamento" class="form-control" 
                               value="<?php echo htmlspecialchars($ubicacion['departamento'] ?? ''); ?>">
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" class="form-control" 
                               value="<?php echo htmlspecialchars($ubicacion['ciudad'] ?? ''); ?>">
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div style="grid-column: 1 / -1; margin-top: 1rem;">
                        <h3 style="margin-bottom: 1rem; color: var(--primary-blue); border-bottom: 2px solid var(--border-gray); padding-bottom: 0.5rem;">
                            Seguridad
                        </h3>
                    </div>

                    <div class="form-group">
                        <label for="contraseña_actual">Contraseña actual</label>
                        <input type="password" id="contraseña_actual" name="contraseña_actual" class="form-control">
                        <small style="color: var(--text-gray);">Déjalo en blanco si no deseas cambiarla</small>
                    </div>

                    <div class="form-group">
                        <label for="contraseña_nueva">Nueva contraseña</label>
                        <input type="password" id="contraseña_nueva" name="contraseña_nueva" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="confirmar_contraseña">Confirmar nueva contraseña</label>
                        <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" class="form-control">
                    </div>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="dashboard.php" class="btn-secondary" style="background-color: var(--text-gray);">
                        Cancelar
                    </a>
                    <button type="submit" name="accion" value="actualizar" class="btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional según tipo de usuario -->
        <?php
        // Verificar si es paseador
        $stmt = $pdo->prepare("SELECT * FROM paseador WHERE idpase = ?");
        $stmt->execute([$idUsuario]);
        $esPaseador = $stmt->fetch();

        // Verificar si es dueño de mascota
        $stmt = $pdo->prepare("SELECT * FROM duenomasc WHERE iddueno = ?");
        $stmt->execute([$idUsuario]);
        $esDueno = $stmt->fetch();
        ?>

        <?php if ($esPaseador): ?>
            <div class="card" style="margin-top: 1.5rem;">
                <h3 style="margin-bottom: 1rem; color: var(--dark-blue);">
                    <i class="fas fa-walking"></i> Información de Paseador
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div style="padding: 1rem; background-color: var(--bg-gray); border-radius: 8px;">
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Antecedentes</p>
                        <p style="font-weight: 600;">
                            <?php if ($esPaseador['antecedentes']): ?>
                                <span style="color: var(--success);">Verificados</span>
                            <?php else: ?>
                                <span style="color: var(--danger);">Pendiente</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div style="padding: 1rem; background-color: var(--bg-gray); border-radius: 8px;">
                        <p style="color: var(--text-gray); font-size: 0.875rem;">Validación</p>
                        <p style="font-weight: 600;">
                            <?php if ($esPaseador['validado']): ?>
                                <span style="color: var(--success);">Aprobado</span>
                            <?php else: ?>
                                <span style="color: var(--primary-orange);">En revisión</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <a href="perfil_paseador.php" class="btn-secondary" style="margin-top: 1rem;">
                    Ver perfil completo de paseador
                </a>
            </div>
        <?php endif; ?>

        <?php if ($esDueno): ?>
            <div class="card" style="margin-top: 1.5rem;">
                <h3 style="margin-bottom: 1rem; color: var(--dark-blue);">
                    <i class="fas fa-dog"></i> Mis Mascotas
                </h3>
                <a href="mis_mascotas.php" class="btn-primary">
                    <i class="fas fa-paw"></i> Ver mis mascotas
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
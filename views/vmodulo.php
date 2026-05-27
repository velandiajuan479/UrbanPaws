<main class="main-content">
    
    <!-- SECCIÓN 1: FORMULARIO DE CREACIÓN -->
    <section id="registro-modulo">
        <h2 class="section-title">
            <span class="icon-circle"><i class="bi bi-plus-lg"></i></span>
            Nuevo Módulo
        </h2>

        <div class="form-card">
            <form action="guardar_modulo.php" method="post">
                <div class="row g-3"> <!-- Usando Bootstrap Grid para la estructura -->
                    
                    <!-- ID Módulo -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="idmod">
                                <i class="bi bi-hash"></i> Id Módulo <span class="required">*</span>
                            </label>
                            <input type="number" id="idmod" name="idmod" class="form-control-custom" placeholder="Ej: 1" required>
                        </div>
                    </div>

                    <!-- Nombre Módulo -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nommod">
                                <i class="bi bi-tag-fill"></i> Nombre Módulo <span class="required">*</span>
                            </label>
                            <input type="text" id="nommod" name="nommod" class="form-control-custom" placeholder="Ej: Configuración" required>
                        </div>
                    </div>

                    <!-- Estado Actual -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mb-2 d-block">
                                <i class="bi bi-toggle-on"></i> Estado Actual <span class="required">*</span>
                            </label>
                            <div class="radio-group mt-2">
                                <label>
                                    <input type="radio" name="estmod" value="1" checked> Activo
                                </label>
                                <label>
                                    <input type="radio" name="estmod" value="0"> Inactivo
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Usuarios con Acceso (Permisos) -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="mb-2 d-block">
                                <i class="bi bi-people-fill"></i> Usuarios con acceso al módulo
                            </label>
                            <div class="checkbox-group mt-2 p-3 border rounded" style="background-color: var(--gris-claro); border-color: var(--gris-medio) !important;">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <label><input type="checkbox" name="permisos[]" value="admin"> Admin</label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label><input type="checkbox" name="permisos[]" value="Paseador"> Paseador</label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label><input type="checkbox" name="permisos[]" value="acudiente"> Acudiente</label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label><input type="checkbox" name="permisos[]" value="Cliente"> Cliente</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary-custom">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-save"></i> Crear Módulo
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- SECCIÓN 2: TABLA DE REGISTROS -->
    <section id="listado-modulos">
        <h2 class="section-title">
            <span class="icon-circle"><i class="bi bi-grid-3x3-gap-fill"></i></span>
            Listado de Módulos
        </h2>

        <div class="table-section">
            <!-- Cabecera de la tabla con búsqueda -->
            <div class="table-header">
                <h2><i class="bi bi-collection-fill"></i> Módulos del Sistema <span class="table-badge">3</span></h2>
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Buscar módulo...">
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>idmod</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Registro 1 -->
                        <tr>
                            <td class="td-number">1</td>
                            <td class="td-name">Inicio</td>
                            <td><span class="badge bg-success text-white">Activo</span></td>
                            <td class="fw-bold">Admin</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        
                        <!-- Registro 2 -->
                        <tr>
                            <td class="td-number">2</td>
                            <td class="td-name">Mascotas</td>
                            <td><span class="badge bg-success text-white">Activo</span></td>
                            <td class="fw-bold">Admin, Cliente, Paseador</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <!-- Registro 3 -->
                        <tr>
                            <td class="td-number">3</td>
                            <td class="td-name">Configuración</td>
                            <td><span class="badge bg-danger text-white">Inactivo</span></td>
                            <td class="fw-bold">Admin</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer de la tabla -->
            <div class="table-footer">
                <div class="table-footer-info">Mostrando <strong>1</strong> a <strong>3</strong> de <strong>3</strong> módulos</div>
                <ul class="pagination-css">
                    <li class="active"><a href="#">1</a></li>
                </ul>
            </div>
        </div>
    </section>

</main>
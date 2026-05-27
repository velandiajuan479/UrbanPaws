<main class="main-content">
    
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <section id="registro-pagina">
        <h2 class="section-title">
            <span class="icon-circle"><i class="bi bi-file-earmark-plus"></i></span>
            Nuevo Registro
        </h2>

        <div class="form-card">
            <form action="guardar_pagina.php" method="post">
                <div class="form-grid">
                    
                    <!-- ID Página -->
                    <div class="form-group">
                        <label for="idpag">
                            <i class="bi bi-hash"></i> ID Página <span class="required">*</span>
                        </label>
                        <input type="number" id="idpag" name="idpag" class="form-control-custom" placeholder="Ej: 1" min="1" max="999" required>
                    </div>

                    <!-- Nombre de Página -->
                    <div class="form-group">
                        <label for="nompag">
                            <i class="bi bi-tag-fill"></i> Nombre de Página <span class="required">*</span>
                        </label>
                        <input type="text" id="nompag" name="nompag" class="form-control-custom" placeholder="Ej: Inicio" maxlength="25" required>
                    </div>

                    <!-- Archivo -->
                    <div class="form-group">
                        <label for="archpag">
                            <i class="bi bi-file-earmark-code"></i> Archivo <span class="required">*</span>
                        </label>
                        <input type="text" id="archpag" name="archpag" class="form-control-custom" placeholder="Ej: index.php" required>
                    </div>
                    <div class="form-group">
                        <label for="mospag">
                            <i class="bi bi-eye-fill"></i> Mostrar en Menú <span class="required">*</span>
                        </label>
                        <select id="mospag" name="mospag" class="form-control-custom select-yes-no" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label for="despag">
                            <i class="bi bi-text-paragraph"></i> Descripción <span class="required">*</span>
                        </label>
                        <textarea id="despag" name="despag" class="form-control-custom" rows="2" placeholder="Ej: Página principal del sistema" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="ordpag">
                            <i class="bi bi-sort-numeric-down"></i> Orden
                        </label>
                        <input type="number" id="ordpag" name="ordpag" class="form-control-custom" placeholder="Ej: 1" min="0" max="999" value="0">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn-secondary-custom">
                        <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                    </button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-save"></i> Registrar Página
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section id="listado-paginas">
        <h2 class="section-title">
            <span class="icon-circle"><i class="bi bi-grid-3x3-gap-fill"></i></span>
            Listado de Páginas Registradas
        </h2>

        <div class="table-section">
            <div class="table-header">
                <h2><i class="bi bi-collection-fill"></i> Páginas del Sistema <span class="table-badge">3</span></h2>
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Buscar página...">
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Archivo</th>
                            <th>Mostrar</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-number">1</td>
                            <td class="td-name">Inicio</td>
                            <td class="td-description">index.php</td>
                            <td><span class="badge-male">Sí</span></td>
                            <td class="td-description">Página principal del sistema</td>
                                <td>
                                <button class="btn btn-sm btn-outline-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>                        
                        <tr>
                            <td class="td-number">2</td>
                            <td class="td-name">Usuarios</td>
                            <td class="td-description">usuarios.php</td>
                            <td><span class="badge-male">Sí</span></td>
                            <td class="td-description">Gestión de usuarios</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-number">3</td>
                            <td class="td-name">Facturas</td>
                            <td class="td-description">factura.php</td>
                            <td><span class="badge-female">No</span></td>
                            <td class="td-description">Visualización de facturas</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer de la tabla -->
            <div class="table-footer">
                <div class="table-footer-info">Mostrando <strong>1</strong> a <strong>3</strong> de <strong>3</strong> páginas</div>
                <ul class="pagination-css">
                    <li class="active"><a href="#">1</a></li>
                </ul>
            </div>
        </div>
    </section>

</main>
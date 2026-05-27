<main class="main-content">
    <section id="configuracion">
        <h2 class="section-title">
            <span class="icon-circle"><i class="bi bi-sliders2"></i></span>
            Ajustes Generales
        </h2>

        <div class="form-card">
            <form action="guardar_config.php" method="post">
                <div class="form-grid">
                    
                    <!-- Nombre Empresa (maps to nomconf) -->
                    <div class="form-group">
                        <label for="nombre_empresa">
                            <i class="bi bi-building"></i> Nombre de la Empresa <span class="required">*</span>
                        </label>
                        <input type="text" id="nombre_empresa" name="nomconf" class="form-control-custom" placeholder="Ej: SIREMC" required>
                    </div>

                    <!-- NIT -->
                    <div class="form-group">
                        <label for="nit">
                            <i class="bi bi-card-checklist"></i> NIT <span class="required">*</span>
                        </label>
                        <input type="text" id="nit" name="nit" class="form-control-custom" placeholder="Ej: 123456789" required>
                    </div>

                    <!-- Email (maps to emlconf) -->
                    <div class="form-group">
                        <label for="email">
                            <i class="bi bi-envelope-fill"></i> Email <span class="required">*</span>
                        </label>
                        <input type="email" id="email" name="emlconf" class="form-control-custom" placeholder="correo@ejemplo.com" required>
                    </div>

                    <!-- Teléfono (maps to tefconf) -->
                    <div class="form-group">
                        <label for="telefono">
                            <i class="bi bi-telephone-fill"></i> Teléfono
                        </label>
                        <input type="tel" id="telefono" name="tefconf" class="form-control-custom" placeholder="3000000000">
                    </div>

                    <!-- Celular -->
                    <div class="form-group">
                        <label for="celular">
                            <i class="bi bi-phone-fill"></i> Celular
                        </label>
                        <input type="tel" id="celular" name="celular" class="form-control-custom" placeholder="3100000000">
                    </div>

                    <!-- Dirección -->
                    <div class="form-group">
                        <label for="direccion">
                            <i class="bi bi-geo-alt-fill"></i> Dirección <span class="required">*</span>
                        </label>
                        <input type="text" id="direccion" name="direccion" class="form-control-custom" placeholder="Calle 00 #00-00" required>
                    </div>

                    <!-- Logo (maps to logoconf) -->
                    <div class="form-group full-width">
                        <label for="logo">
                            <i class="bi bi-image-fill"></i> Logo (ruta o URL)
                        </label>
                        <input type="text" id="logo" name="logoconf" class="form-control-custom" placeholder="https://... o uploads/...">
                    </div>

                    <!-- Descripción -->
                    <div class="form-group full-width">
                        <label for="descripcion">
                            <i class="bi bi-textarea-resize"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" class="form-control-custom" rows="4" placeholder="Breve descripción..."></textarea>
                    </div>
                    
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary-custom" onclick="history.back()">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-save"></i> Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

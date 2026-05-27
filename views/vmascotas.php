<main class="main-content">

    <!-- FORMULARIO -->
    <section id="registro">
      <h2 class="section-title">
        <span class="icon-circle"><i class="bi bi-plus-lg"></i></span>
        Nuevo Registro de Mascota
      </h2>
      <div class="form-card">
        <form action="#" method="post" enctype="multipart/form-data">
          <div class="form-grid">
            <div class="form-group">
              <label for="fecha"><i class="bi bi-calendar-event-fill"></i> Fecha <span class="required">*</span></label>
              <input type="date" id="fecha" name="fecha" class="form-control-custom" value="2025-05-15" required>
            </div>
            <div class="form-group">
              <label for="nombre"><i class="bi bi-heart-fill"></i> Nombre <span class="required">*</span></label>
              <input type="text" id="nombre" name="nombre" class="form-control-custom" placeholder="Ej: Luna, Max..." required>
            </div>
            <div class="form-group">
              <label for="sexo"><i class="bi bi-gender-ambiguous"></i> Sexo <span class="required">*</span></label>
              <select id="sexo" name="sexo" class="form-control-custom" required>
                <option value="" disabled selected>Seleccionar...</option>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
              </select>
            </div>
            <div class="form-group">
              <label for="edad"><i class="bi bi-hourglass-split"></i> Edad (años) <span class="required">*</span></label>
              <input type="number" id="edad" name="edad" class="form-control-custom" placeholder="Ej: 3" min="0" max="30" required>
            </div>
            <div class="form-group">
              <label for="raza"><i class="bi bi-paw-fill"></i> Raza <span class="required">*</span></label>
              <select id="raza" name="raza" class="form-control-custom" required>
                <option value="" disabled selected>Seleccionar raza...</option>
                <option value="labrador">Labrador Retriever</option>
                <option value="pastor-aleman">Pastor Alemán</option>
                <option value="bulldog">Bulldog (Inglés / Francés)</option>
                <option value="poodle">Poodle / Caniche</option>
                <option value="cocker">Cocker Spaniel</option>
                <option value="schnauzer">Schnauzer</option>
                <option value="beagle">Beagle</option>
                <option value="criollo">Criollo Colombiano</option>
                <option value="golden">Golden Retriever</option>
                <option value="mestizo">Mestizo / Mixto</option>
              </select>
            </div>
            <div class="form-group">
              <label><i class="bi bi-camera-fill"></i> Carnet de Vacunas</label>
              <div class="file-upload-area">
                <i class="bi bi-cloud-arrow-up"></i>
                <span>Subir foto o PDF</span>
                <small>JPG, PNG o PDF (máx. 5MB)</small>
                <input type="file" name="carnet_vacunas" accept=".pdf,.jpg,.jpeg,.png">
              </div>
            </div>
            <div class="form-group full-width">
              <label for="descripcion"><i class="bi bi-text-paragraph"></i> Descripción / Notas</label>
              <textarea id="descripcion" name="descripcion" class="form-control-custom" rows="3" placeholder="Temperamento, rutina, preferencias..."></textarea>
            </div>
            <div class="form-group full-width">
              <label for="enfermedades"><i class="bi bi-clipboard2-pulse"></i> Enfermedades / Alergias</label>
              <textarea id="enfermedades" name="enfermedades" class="form-control-custom" rows="2" placeholder="Escribe 'Ninguna' o detalla condiciones..."></textarea>
            </div>
          </div>
          <div class="form-actions">
            <button type="reset" class="btn-secondary-custom"><i class="bi bi-arrow-counterclockwise"></i> Limpiar</button>
            <button type="button" class="btn-accent-custom"><i class="bi bi-eye-fill"></i> Vista Previa</button>
            <button type="submit" class="btn-primary-custom"><i class="bi bi-check-circle-fill"></i> Guardar Registro</button>
          </div>
        </form>
      </div>
    </section>

    <!-- TABLA HISTORIAL (SOLO 2 REGISTROS) -->
    <section id="historial">
      <h2 class="section-title">
        <span class="icon-circle"><i class="bi bi-journal-medical"></i></span>
        Historial de Mis Mascotas
      </h2>
      <div class="table-section">
        <div class="table-header">
          <h2><i class="bi bi-collection-fill"></i> Mis Registros <span class="table-badge">2</span></h2>
          <div class="search-container">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Buscar en mi historial...">
          </div>
        </div>

        <div class="table-responsive-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>#</th><th>Fecha</th><th>Foto</th><th>Nombre</th><th>Sexo</th>
                <th>Edad</th><th>Raza</th><th>Descripción</th><th>Enfermedades</th><th>Carnet</th>
              </tr>
            </thead>
            <tbody>
              <!-- Registro 1: LUNA -->
              <tr>
                <td class="td-number">1</td>
                <td class="td-date">15/01/2024</td>
                <td><div class="td-photo"><i class="bi bi-person-fill"></i></div></td>
                <td class="td-name">Luna</td>
                <td><span class="td-sex"><span class="badge-female"><i class="bi bi-venus"></i> Hembra</span></span></td>
                <td class="td-age">2 años</td>
                <td class="td-breed">Labrador Retriever</td>
                <td class="td-description">Juguetona y cariñosa, le encanta el agua y los parques de Bogotá</td>
                <td class="td-disease"><span class="none">Ninguna</span></td>
                <td><div class="td-photo-upload tooltip-wrapper" data-tooltip="Ver carnet"><i class="bi bi-file-earmark-medical"></i></div></td>
              </tr>
              <!-- Registro 2: MAX -->
              <tr>
                <td class="td-number">2</td>
                <td class="td-date">15/01/2024</td>
                <td><div class="td-photo"><i class="bi bi-person-fill"></i></div></td>
                <td class="td-name">Max</td>
                <td><span class="td-sex"><span class="badge-male"><i class="bi bi-mars"></i> Macho</span></span></td>
                <td class="td-age">5 años</td>
                <td class="td-breed">Pastor Alemán</td>
                <td class="td-description">Protector y leal, excelente perro de guardia en casa</td>
                <td class="td-disease"><span class="has">Displasia de cadera</span></td>
                <td><div class="td-photo-upload tooltip-wrapper" data-tooltip="Ver carnet"><i class="bi bi-file-earmark-medical"></i></div></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="table-footer">
          <div class="table-footer-info">Mostrando <strong>1</strong> a <strong>2</strong> de <strong>2</strong> registros personales</div>
          <ul class="pagination-css">
            <li class="active"><a href="#">1</a></li>
          </ul>
        </div>
      </div>
    </section>

  </main>
</body>
</html>
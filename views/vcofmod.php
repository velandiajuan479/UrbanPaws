<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Módulo
    </h4> 
    
    <form action="" method="POST" class="row g-3">
    <!--Nombre del módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre del módulo</label>
            <input type="text" class="form-control" placeholder="Módulo" required>
        </div>
    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Estado</label>
            <div class="w-100"></div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="actv" value="" required>
            <label class="form-check-label" for="actv">Activo</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="inactv" value="" required>
            <label class="form-check-label" for="inactv">Inactivo</label>
            </div>
        </div>
    <!--Selección del icono-->
        <div class="col-md-4">
            <i class="fa-solid fa-shapes"></i>
            <label class="form-label" for="">Icono</label>
            <div class="input-group">
                <select name="icono" id="" class="form-control form-select">
                    <option value="0">Selecciona un icono...</option>
                    <option value="1">Logo</option>
                </select>
            </div>
        </div>
        <div class="col-md-2"></div>
    <!--Selección de usuarios-->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label" for="">Usuarios con acceso</label>
            <div class="input-group">
                <select name="icono" id="" class="form-control form-select">
                    <option value="0">Sin usuarios</option>
                    <option value="1">Admin</option>
                </select>
            </div>
        </div>
    <!--Orden de carga-->
        <div class="col-md-3">
            <i class="fa-solid fa-sort"></i>
            <label class="form-label" for="">Orden de carga</label>
            <input type="number" class="form-control" name="" id="" placeholder="Ej:10">
        </div>
    <!--Botones-->
        <div class="col-md-12 mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>

</div>
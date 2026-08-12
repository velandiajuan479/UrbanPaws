<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nueva Página
    </h4> 
    
    <form action="" method="POST" class="row g-3">
    <!--Nombre del módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre de la página</label>
            <input type="text" class="form-control" placeholder="Servicio" required>
        </div>
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Titulo de la página</label>
            <input type="text" class="form-control" placeholder="Reporte de PQRS" required>
        </div>
    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Mostrar Página</label>
            <div class="w-100"></div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="si" value="" required>
            <label class="form-check-label" for="actv">Si</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="no" value="" required>
            <label class="form-check-label" for="inactv">No</label>
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
        
    <!--Ruta de la página-->
        <div class="col-md-4">
            <i class="fa-solid fa-folder"></i>
            <label class="form-label" for="">Ruta de la página</label>
            <input class="form-control" type="text" name="" id="" placeholder="views/vcofcof.php">
        </div>
    <!--Orden de carga-->
        <div class="col-md-4">
            <i class="fa-solid fa-sort"></i>
            <label class="form-label" for="">Orden de carga</label>
            <input type="number" class="form-control" name="" id="" placeholder="Ej:10">
        </div>
        <div class="col-md-4"></div>
    <!--Descripción de la página-->
        <div class="col-md-4">
            <i class="fa-solid fa-clipboard"></i>
            <label class="form-label" for="">Descripción corta</label>
            <input class="form-control" type="text" name="" id="" placeholder="descripción">
        </div>
        <div class="col-md-2"></div>
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

<div class="table-container mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de páginas
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Página</th>
                    <th>Descripcion</th>
                    <th>Mostrar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>
                            <i class="fa fa-box"></i>
                            1 Módulo
                            <br>
                        </strong>
                        <small>
                            Titulo: Módulo Ruta: views/vcofmod.php
                            <br>
                            Orden: 1
                        </small>
                    </td>
                    <td>
                        <small>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt architecto voluptatibus distinctio commodi neque aperiam voluptate labore. Adipisci, eveniet. Esse ad quibusdam voluptates aliquam blanditiis quidem. Quas voluptatibus excepturi iusto.
                        </small>
                    </td>
                    <td>No</td>
                    <td>
                        <a href="" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="" title="borrar">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Página</th>
                    <th>Mostrar</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>
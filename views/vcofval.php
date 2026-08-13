<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Valor
    </h4> 
    
    <form action="" method="POST" class="row g-3">
    <!--Selección de dominio-->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label" for="">Dominio</label>
            <div class="input-group">
                <select name="icono" id="" class="form-control form-select">
                    <option value="0">Selecciona Dominio</option>
                    <option value="1">Tipo Documento</option>
                </select>
            </div>
        </div>
    <!--Nombre del módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre de valor</label>
            <input type="text" class="form-control" placeholder="C.C" required>
        </div>
    <!--Parametros del valor-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Parametros</label>
            <input type="text" class="form-control" required>
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
        Lista de valores
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Dominio</th>
                    <th>Valores</th>
                    <th>Parametros</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        Tipo de documento
                    </td>
                    <td>
                        C.C
                    </td>
                    <td></td>
                    <td>Activo</td>
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
                    <th>Codigo</th>
                    <th>Dominio</th>
                    <th>Valores</th>
                    <th>Parametros</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

Lorem ipsum dolor sit amet consectetur, adipisicing elit.
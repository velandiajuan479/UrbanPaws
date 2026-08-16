Paseo
<section class="container  mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Paseos
        </div>

        <div class="card">
            <h1>Información Ruta y precio</h1>
            <p>.........................</p>
        </div>
    </section>

    <section class="form-grid">
        <section>
            <span>Ubicación de Ruta(Punto A - B)</span>
            <div class="card col-10">
                Api ..... mapa de la ruta
            </div>
        </section>

        <section>
            <span>Información del Paceador a cargo de la ruta</span>
            <form action="#" class="card form-grid" method="POST" id="formpas">
                <div class="form-group col-md-11">
                    <label for="---">Nombre Paceador: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="---">Foto: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="---">Distancia: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="---">Precio: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="---">Nombre Ruta: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>

                <div class="form-group col-md-6">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Solicitar Paseo">
                </div>
            </form>
        </section>
    </section>

</section>
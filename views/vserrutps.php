Ruta Paseador
<section class="container  mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Tus Rutas
        </div>

        <!--<div class="card">
            <h1>Información Cliente</h1>
            <p>.........................</p>
        </div>-->
    </section>

    <section class="form-grid">
        <section>
            <span>Crea tu Ruta</span>
            <form class="card form-grid " id="formrutps" action="#" method="POST">
                <div class="form-group col-md-11">
                    <label for="---">Nombre Ruta: </label>
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
                    <label for="---">Hora inicio: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="---">Hora fin: </label>
                    <input type="text" name="---" id="---" class="form-control"
                        value="<?= $dtOn ? $dtOn['---'] : '' ?>">
                </div>

                <div class="form-group col-md-6">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Crear Ruta">
                </div>
            </form>
        </section>

        <section>
            <span>Tus Rutas</span>
            <table id="" class="card col-12">
                <!--<thead>
                    <tr>
                        <th>ruta venecia</th>
                    </tr>
                </thead>-->
                <tbody>
                    <tr>
                        <td>Ruta chia</td>
                        <td>Hora inicio: 15:00</td>
                        <td>Hora final: 16:00 </td>
                        <td>Precio de la ruta: 18.000</td>
                        <td><strong>Activa</strong></td>
                    </tr>
                    <tr>
                        <td>Ruta chia</td>
                        <td>Hora inicio: 15:00</td>
                        <td>Hora final: 16:00 </td>
                        <td>Precio de la ruta: 18.000</td>
                        <td><strong>Inactiva</strong></td>
                    </tr>

                    <tr>
                        <td>Ruta chia</td>
                        <td>Hora inicio: 15:00</td>
                        <td>Hora final: 16:00 </td>
                        <td>Precio de la ruta: 18.000</td>
                        <td><strong>Activa</strong>
                    </tr>
                    </tr>
                </tbody>
            </table>
        </section>
    </section>

</section>
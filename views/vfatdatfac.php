<main class="container" style="padding: 2.5rem 1.5rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem;">

        <div>
            <h1 style="color: var(--brand-dark); font-size: 2rem; margin-bottom: .3rem;">
                Detalle de Factura
            </h1>

            <p style="color: var(--text-muted);">
                Información detallada de lo que se le cobra.
            </p>
        </div>

        <button class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf"></i>
            Descargar factura
        </button>

    </div>

    <section class="card" style="margin-bottom: 1.5rem;">

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">

            <div>
                <span class="form-label">Número de factura</span>
                <strong>#FAC-00001</strong>
            </div>

            <div>
                <span class="form-label">Fecha</span>
                <strong>05/05/2026</strong>
            </div>

            <div>
                <span class="form-label">Cliente</span>
                <strong>Wilson Baratijas</strong>
            </div>

            <div>
                <span class="form-label">Estado</span>
                <span class=>PAGADA</span>
            </div>

        </div>

    </section>

    <section class="card">

        <h2 class="section-title">
            <span class="icon-circle">
                <i class="bi bi-list-ul"></i>
            </span>
            Conceptos de la factura
        </h2>

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Mascota</th>
                        <th>Ruta</th>
                        <th>Tiempo</th>
                        <th>Subtotal</th>
                        <th>Cargos adicionales</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Paseo Premium</td>
                        <td>Luna</td>
                        <td>Ruta Valvanera</td>
                        <td>45 min</td>
                        <td>$ 35.000</td>
                        <td>$ 5.000</td>
                        <td><strong>$ 40.000</strong></td>
                    </tr>

                    <tr>
                        <td>Paseo Express</td>
                        <td>Coco</td>
                        <td> Ruta Centro Chia</td>
                        <td>30 min</td>
                        <td>$ 25.000</td>
                        <td>$ 0</td>
                        <td><strong>$ 25.000</strong></td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">

            <div style="width: 320px;">

                <div style="display: flex; justify-content: space-between; padding: .7rem 0;">
                    <span>Subtotal</span>
                    <strong>$ 60.000</strong>
                </div>

                <div style="display: flex; justify-content: space-between; padding: .7rem 0;">
                    <span>Cargos adicionales</span>
                    <strong>$ 5.000</strong>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 1rem; margin-top: .5rem; background: var(--brand-dark); color: white; border-radius: 8px;">
                    <strong>TOTAL</strong>
                    <strong>$ 65.000 COP</strong>
                </div>

            </div>

        </div>

    </section>

    <section class="card" style="margin-top: 1.5rem;">

        <h2 class="section-title">
            <span class="icon-circle">
                <i class="bi bi-chat-left-text"></i>
            </span>
            Observaciones
        </h2>

        <p style="color: var(--text-muted);">
            Factura generada por servicios de paseo realizados.
        </p>

    </section>

</main>
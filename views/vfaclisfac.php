<main class="container" style="padding: 2.5rem 1.5rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">

        <div>
            <h1 style="color: var(--brand-dark); font-size: 2rem; margin-bottom: .3rem;">
                Listado de Facturas
            </h1>

            <p style="color: var(--text-muted);">
                Historial y gestión de facturas generadas.
            </p>
        </div>

        <a href="#" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Nueva factura
        </a>

    </div>

    <section class="card" style="margin-bottom: 1.5rem;">

        <h2 class="section-title">
            <span class="icon-circle">
                <i class="bi bi-funnel"></i>
            </span>
            Filtros de búsqueda
        </h2>

        <form method="GET">

            <div class="form-grid">

                <div>
                    <label class="form-label">
                        Cliente
                    </label>

                    <input
                        type="text"
                        name="cliente"
                        class="input-control"
                        placeholder="Buscar cliente">
                </div>

                <div>
                    <label class="form-label">
                        Estado
                    </label>

                    <select name="estado" class="input-control">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="pagada">Pagada</option>
                        <option value="vencida">Vencida</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">
                        Fecha inicial
                    </label>

                    <input
                        type="date"
                        name="fecha_inicio"
                        class="input-control">
                </div>

                <div>
                    <label class="form-label">
                        Fecha final
                    </label>

                    <input
                        type="date"
                        name="fecha_fin"
                        class="input-control">
                </div>

                <div>
                    <label class="form-label">
                        Monto mínimo
                    </label>

                    <input
                        type="number"
                        name="monto_min"
                        class="input-control"
                        placeholder="$ 0">
                </div>

                <div>
                    <label class="form-label">
                        Monto máximo
                    </label>

                    <input
                        type="number"
                        name="monto_max"
                        class="input-control"
                        placeholder="$ 0">
                </div>

            </div>

            <div style="display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.25rem;">

                <button type="reset" class="btn btn-outline">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Limpiar
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Buscar
                </button>

            </div>

        </form>

    </section>

    <section class="card">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">

            <h2 class="section-title" style="margin-bottom: 0;">
                <span class="icon-circle">
                    <i class="bi bi-receipt"></i>
                </span>
                Facturas registradas
            </h2>

            <span style="color: var(--text-muted);">
                30 registros
            </span>

        </div>

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#FAC-00030</td>
                        <td>05/05/2026</td>
                        <td>Valentina Castillo</td>
                        <td>Paseo Premium</td>
                        <td>$ 35.000</td>
                        <td>$ 40.000</td>
                        <td>
                            <span class="badge badge-active">PAGADA</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-outline" style="padding: .4rem .7rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>#FAC-00029</td>
                        <td>04/05/2026</td>
                        <td>Laura Gómez</td>
                        <td>Paseo Básico</td>
                        <td>$ 30.000</td>
                        <td>$ 35.000</td>
                        <td>
                            <span class="badge badge-female">PENDIENTE</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-outline" style="padding: .4rem .7rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>#FAC-00028</td>
                        <td>03/05/2026</td>
                        <td>Carlos Ruiz</td>
                        <td>Paseo Express</td>
                        <td>$ 25.000</td>
                        <td>$ 25.000</td>
                        <td>
                            <span class="badge" style="background: #fee2e2; color: #dc2626;">
                                VENCIDA
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-outline" style="padding: .4rem .7rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>#FAC-00027</td>
                        <td>02/05/2026</td>
                        <td>Mariana López</td>
                        <td>Paseo Senior</td>
                        <td>$ 38.000</td>
                        <td>$ 45.000</td>
                        <td>
                            <span class="badge badge-active">PAGADA</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-outline" style="padding: .4rem .7rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; flex-wrap: wrap; gap: 1rem;">

            <span style="color: var(--text-muted); font-size: .85rem;">
                Mostrando 1 a 4 de 30 registros
            </span>

            <div style="display: flex; gap: .4rem;">

                <a href="#" class="btn btn-outline" style="padding: .5rem .8rem;">
                    Anterior
                </a>

                <a href="#" class="btn btn-primary" style="padding: .5rem .8rem;">
                    1
                </a>

                <a href="#" class="btn btn-outline" style="padding: .5rem .8rem;">
                    2
                </a>

                <a href="#" class="btn btn-outline" style="padding: .5rem .8rem;">
                    3
                </a>

                <a href="#" class="btn btn-outline" style="padding: .5rem .8rem;">
                    Siguiente
                </a>

            </div>

        </div>

    </section>

</main>
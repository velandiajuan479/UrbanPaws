<main class="container" style="padding: 2.5rem 1.5rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">

        <div>
            <h1 style="color: var(--brand-dark); font-size: 2rem; margin-bottom: .3rem;">
                Reporte de Facturas
            </h1>

            <p style="color: var(--text-muted);">
                Análisis financiero de facturación, ingresos y estados de cuenta.
            </p>
        </div>

        <div style="display: flex; gap: .7rem;">

            <button class="btn btn-outline">
                <i class="bi bi-file-earmark-pdf"></i>
                PDF
            </button>

            <button class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i>
                Excel
            </button>

        </div>

    </div>

    <section class="card" style="margin-bottom: 1.5rem;">

        <h2 class="section-title">
            <span class="icon-circle">
                <i class="bi bi-funnel"></i>
            </span>
            Parámetros del reporte
        </h2>

        <form method="GET">

            <div class="form-grid">

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
                        Estado de pago
                    </label>

                    <select name="estado" class="input-control">
                        <option value="">Todos los estados</option>
                        <option value="pagada">Pagada</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="vencida">Vencida</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">
                        Cliente
                    </label>

                    <input
                        type="text"
                        name="cliente"
                        class="input-control"
                        placeholder="Nombre del cliente">
                </div>

            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 1.25rem;">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-bar-chart"></i>
                    Generar reporte
                </button>

            </div>

        </form>

    </section>

    <section style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">

        <div class="card" style="padding: 1.4rem;">
            <span style="color: var(--text-muted); font-size: .85rem;">
                Total facturado
            </span>

            <h2 style="color: var(--brand-dark); margin-top: .4rem;">
                $ 2.450.000
            </h2>
        </div>

        <div class="card" style="padding: 1.4rem;">
            <span style="color: var(--text-muted); font-size: .85rem;">
                Facturas pagadas
            </span>

            <h2 style="margin-top: .4rem;">
                $ 1.850.000
            </h2>
        </div>

        <div class="card" style="padding: 1.4rem;">
            <span style="color: var(--text-muted); font-size: .85rem;">
                Pendiente de pago
            </span>

            <h2 style="margin-top: .4rem;">
                $ 450.000
            </h2>
        </div>

        <div class="card" style="padding: 1.4rem;">
            <span style="color: var(--text-muted); font-size: .85rem;">
                Facturas vencidas
            </span>

            <h2 style=" margin-top: .4rem;">
                $ 150.000
            </h2>
        </div>

    </section>

    <section style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

        <div class="card">

            <h2 class="section-title">
                <span class="icon-circle">
                    <i class="bi bi-bar-chart"></i>
                </span>
                Ingresos por periodo
            </h2>

            <div style="height: 280px; display: flex; align-items: end; justify-content: space-around; gap: 1rem; border-bottom: 1px solid #d1d5db; padding: 1rem;">

                <div style="height: 45%; width: 12%; background: var(--brand-primary); border-radius: 6px 6px 0 0;"></div>

                <div style="height: 60%; width: 12%; background: var(--brand-primary); border-radius: 6px 6px 0 0;"></div>

                <div style="height: 52%; width: 12%; background: var(--brand-primary); border-radius: 6px 6px 0 0;"></div>

                <div style="height: 75%; width: 12%; background: var(--brand-primary); border-radius: 6px 6px 0 0;"></div>

                <div style="height: 88%; width: 12%; background: var(--brand-accent); border-radius: 6px 6px 0 0;"></div>

                <div style="height: 68%; width: 12%; background: var(--brand-primary); border-radius: 6px 6px 0 0;"></div>

            </div>

            <div style="display: flex; justify-content: space-around; color: var(--text-muted); font-size: .8rem; margin-top: .6rem;">
                <span>Ene</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Abr</span>
                <span>May</span>
                <span>Jun</span>
            </div>

        </div>

        <div class="card">

            <h2 class="section-title">
                <span class="icon-circle">
                    <i class="bi bi-pie-chart"></i>
                </span>
                Estado de facturación
            </h2>

            <div style="display: flex; flex-direction: column; gap: 1rem;">

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: .4rem;">
                        <span>Pagadas</span>
                        <strong>75%</strong>
                    </div>

                    <div style="height: 10px; background: #e5e7eb; border-radius: 10px;">
                        <div style="height: 100%; width: 75%; background: #10b981; border-radius: 10px;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: .4rem;">
                        <span>Pendientes</span>
                        <strong>18%</strong>
                    </div>

                    <div style="height: 10px; background: #e5e7eb; border-radius: 10px;">
                        <div style="height: 100%; width: 18%; background: #f59e0b; border-radius: 10px;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: .4rem;">
                        <span>Vencidas</span>
                        <strong>7%</strong>
                    </div>

                    <div style="height: 10px; background: #e5e7eb; border-radius: 10px;">
                        <div style="height: 100%; width: 7%; background: #ef4444; border-radius: 10px;"></div>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class="card">

        <h2 class="section-title">
            <span class="icon-circle">
                <i class="bi bi-table"></i>
            </span>
            Resumen financiero
        </h2>

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Facturas</th>
                        <th>Pagadas</th>
                        <th>Pendientes</th>
                        <th>Vencidas</th>
                        <th>Total facturado</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Enero 2026</td>
                        <td>32</td>
                        <td>25</td>
                        <td>5</td>
                        <td>2</td>
                        <td>$ 850.000</td>
                    </tr>

                    <tr>
                        <td>Febrero 2026</td>
                        <td>38</td>
                        <td>30</td>
                        <td>6</td>
                        <td>2</td>
                        <td>$ 970.000</td>
                    </tr>

                    <tr>
                        <td>Marzo 2026</td>
                        <td>42</td>
                        <td>35</td>
                        <td>5</td>
                        <td>2</td>
                        <td>$ 1.120.000</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </section>

</main>
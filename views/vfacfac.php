<main class="container" style="padding: 2.5rem 1.5rem;">

    <div style="margin-bottom: 2rem;">
        <h1 style="color: var(--brand-dark); font-size: 2rem; margin-bottom: .3rem;">
            Factura
        </h1>
        <p style="color: var(--text-muted);">
            Generación y gestión de la factura por servicios prestados.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; align-items: start;">

        <section class="card">

            <h2 class="section-title">
                <span class="icon-circle">
                    <i class="bi bi-receipt"></i>
                </span>
                Registro de Factura
            </h2>

            <form method="POST">

                <div class="form-grid">

                    <div>
                        <label class="form-label">
                            <i class="bi bi-person"></i>
                            Cliente
                        </label>
                        <input
                            type="text"
                            name="cliente"
                            class="input-control"
                            placeholder="Nombre del cliente">
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="bi bi-card-text"></i>
                            Identificación
                        </label>
                        <input
                            type="text"
                            name="documento"
                            class="input-control"
                            placeholder="Documento del cliente">
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="bi bi-calendar"></i>
                            Fecha de factura
                        </label>
                        <input
                            type="date"
                            name="fecha"
                            class="input-control">
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="bi bi-credit-card"></i>
                            Estado
                        </label>
                        <select name="estado" class="input-control">
                            <option value="">Seleccione un estado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagada">Pagada</option>
                            <option value="vencida">Vencida</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="bi bi-cash"></i>
                            Precio final
                        </label>
                        <input
                            type="number"
                            name="preciofin"
                            class="input-control"
                            placeholder="0">
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="bi bi-percent"></i>
                            Descuento
                        </label>
                        <input
                            type="number"
                            name="descuento"
                            class="input-control"
                            placeholder="0">
                    </div>

                </div>

                <div style="margin-top: 1.25rem;">
                    <label class="form-label">
                        <i class="bi bi-chat-left-text"></i>
                        Comentarios
                    </label>

                    <textarea
                        name="comentarios"
                        class="input-control"
                        rows="4"
                        placeholder="Comentarios de la factura"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.5rem;">

                    <button type="reset" class="btn btn-outline">
                        <i class="bi bi-x-circle"></i>
                        Limpiar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i>
                        Generar factura
                    </button>

                </div>

            </form>

        </section>

        <section class="card">

            <h2 class="section-title">
                <span class="icon-circle">
                    <i class="bi bi-calculator"></i>
                </span>
                Resumen de Factura
            </h2>

            <div style="display: flex; flex-direction: column; gap: 0;">

                <div style="display: flex; justify-content: space-between; padding: .9rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="color: var(--text-muted);">Subtotal</span>
                    <strong>$ 35.000</strong>
                </div>

                <div style="display: flex; justify-content: space-between; padding: .9rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="color: var(--text-muted);">Descuentos</span>
                    <strong>$ 0</strong>
                </div>

                <div style="display: flex; justify-content: space-between; padding: .9rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="color: var(--text-muted);">Cargos adicionales</span>
                    <strong>$ 5.000</strong>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 1.1rem 0; background: var(--brand-dark); color: white; margin: 1rem -2rem -2rem; padding-left: 2rem; padding-right: 2rem; border-radius: 0 0 12px 12px;">
                    <strong>TOTAL</strong>
                    <strong>$ 40.000 COP</strong>
                </div>

            </div>

        </section>

    </div>

</main>
<?php
ob_start();
session_start();

if (isset($_SESSION['iduser'])) {
    header('Location: home.php');
    exit;
}

require_once __DIR__ . '/models/conexion.php';
$authPage = isset($_GET['pg']) ? (int) $_GET['pg'] : 29;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#20372d">
    <meta name="description" content="UrbanPaws: organiza el cuidado, los paseos y los servicios de tu mascota en un solo lugar.">
    <title>UrbanPaws — Cuidado en cada paso</title>
    <link rel="icon" type="image/png" sizes="64x64" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body class="auth-page">
    <div class="auth-layout">
        <aside class="auth-brand-panel" aria-label="Acerca de UrbanPaws">
            <a class="auth-brand" href="index.php" aria-label="UrbanPaws, inicio">
                <span class="logo-icon"><img class="logo-img" src="img/logo-web.png" alt=""></span>
                <span><strong>UrbanPaws</strong><small>Cuidado en cada paso</small></span>
            </a>
            <div class="auth-story">
                <span class="eyebrow">Una vida más feliz, juntos</span>
                <h1>Su mundo merece el mejor cuidado.</h1>
                <p>Un espacio tranquilo para organizar sus paseos, sus servicios y todos esos pequeños momentos que importan.</p>
                <span class="auth-story-mark"><i class="fa-solid fa-paw" aria-hidden="true"></i> Bienestar pensado para ellos</span>
            </div>
            <div class="auth-footnote">Hecho con cariño en Colombia · <?= date('Y') ?></div>
        </aside>

        <main class="auth-content" id="main-content">
            <div class="auth-content-inner">
                <a class="auth-mobile-brand" href="index.php" aria-label="UrbanPaws, inicio">
                    <span class="logo-icon"><img class="logo-img" src="img/logo-web.png" alt=""></span>
                    <span><strong>UrbanPaws</strong><small>Cuidado en cada paso</small></span>
                </a>
                <div class="mb-2">
                    <span class="eyebrow">Tu espacio de cuidado</span>
                    <h1 class="welcome-title">Te damos la bienvenida</h1>
                    <p class="welcome-lead">Gestiona con calma todo lo que hace bien a tu mascota.</p>
                </div>

                <ul class="nav auth-tabs" id="authTabs" role="tablist" aria-label="Acceso a UrbanPaws">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-auth-tab="login" type="button" role="tab" aria-controls="login" aria-selected="true">
                            <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i>Ingresar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="registro-tab" data-auth-tab="registro" type="button" role="tab" aria-controls="registro" aria-selected="false">
                            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>Crear cuenta
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="authTabsContent">
                    <section class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                        <?php include __DIR__ . '/controllers/cextini.php'; ?>
                    </section>
                    <section class="tab-pane fade" id="registro" role="tabpanel" aria-labelledby="registro-tab" tabindex="0">
                        <?php include __DIR__ . '/controllers/cextregis.php'; ?>
                    </section>
                    <section class="tab-pane fade" id="recuperar" role="tabpanel" tabindex="0">
                        <div id="recovery-request">
                            <?php include __DIR__ . '/controllers/cextolv.php'; ?>
                        </div>
                        <div id="recovery-reset" class="d-none">
                            <?php include __DIR__ . '/controllers/cextreccon.php'; ?>
                        </div>
                    </section>
                </div>
                <div class="auth-secondary-links d-none" id="authSecondaryLinks">
                    <a href="#recuperar" data-auth-recovery="request">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/auth-toggle.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const page = params.get('pg');
        const loginTab = document.querySelector('#login-tab');
        const registrationTab = document.querySelector('#registro-tab');
        const authTabs = document.querySelector('#authTabs');
        const secondaryLinks = document.querySelector('#authSecondaryLinks');
        const recoveryPane = document.querySelector('#recuperar');
        const requestStep = document.querySelector('#recovery-request');
        const resetStep = document.querySelector('#recovery-reset');

        function openRecovery(step) {
            authTabs.classList.add('d-none');
            secondaryLinks.classList.add('d-none');
            requestStep.classList.toggle('d-none', step === 'reset');
            resetStep.classList.toggle('d-none', step !== 'reset');
            authTabs.querySelectorAll('[role="tab"]').forEach(function (tab) {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            document.querySelectorAll('#authTabsContent > .tab-pane').forEach(function (pane) {
                pane.classList.remove('show', 'active');
            });
            recoveryPane.classList.add('show', 'active');
            history.replaceState(null, '', 'index.php?pg=' + (step === 'reset' ? '30' : '31'));
        }

        function openAuthTab(tab) {
            authTabs.classList.remove('d-none');
            secondaryLinks.classList.toggle('d-none', tab !== 'registro');
            const selectedButton = tab === 'registro' ? registrationTab : loginTab;
            const selectedPane = document.getElementById(tab === 'registro' ? 'registro' : 'login');
            authTabs.querySelectorAll('[role="tab"]').forEach(function (button) {
                const isSelected = button === selectedButton;
                button.classList.toggle('active', isSelected);
                button.setAttribute('aria-selected', isSelected ? 'true' : 'false');
            });
            document.querySelectorAll('#authTabsContent > .tab-pane').forEach(function (pane) {
                pane.classList.remove('show', 'active');
            });
            selectedPane.classList.add('show', 'active');
            history.replaceState(null, '', 'index.php?pg=' + (tab === 'registro' ? '28' : '29'));
        }

        document.addEventListener('click', function (event) {
            const recoveryLink = event.target.closest('[data-auth-recovery]');
            const authLink = event.target.closest('[data-auth-tab]');
            if (recoveryLink) {
                event.preventDefault();
                openRecovery(recoveryLink.dataset.authRecovery);
            }
            if (authLink) {
                event.preventDefault();
                openAuthTab(authLink.dataset.authTab);
            }
            const backLink = event.target.closest('[data-auth-back]');
            if (backLink) {
                event.preventDefault();
                openAuthTab('login');
            }
            const resetLink = event.target.closest('[data-auth-reset]');
            if (resetLink) {
                event.preventDefault();
                openRecovery('reset');
            }
        });

        if (page === '28') {
            openAuthTab('registro');
        } else if (page === '30') {
            openRecovery('reset');
        } else if (page === '31') {
            openRecovery('request');
        }
    });
    </script>
</body>
</html>

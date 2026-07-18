<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'VitaLit') — VitaLit</title>

    {{-- Police moderne depuis Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Icônes Tabler (celles utilisées dans la maquette) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.0.0/dist/tabler-icons.min.css">

    {{-- Leaflet CSS pour les cartes interactives --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        /* ------- Réinitialisation et bases ------- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f8f8;
            color: #1a2233;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* ------- Couleurs de la charte (à réutiliser partout) ------- */
        :root {
            --vert-sante: #0b8a7a;
            --vert-clair: #eaf5f3;
            --bleu-marine: #093f5c;
            --gris-fond: #f4f8f8;
            --gris-texte: #5a6678;
            --gris-clair: #f0f5f5;
            --orange: #f39c12;
            --rouge: #e74c3c;
            --blanc: #ffffff;
        }

        /* ------- En-tête (présent sur toutes les pages) ------- */
        .app-header {
            background: white;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .app-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .app-header .logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--vert-sante);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }
        .app-header .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: var(--bleu-marine);
        }
        .app-header .actions {
            display: flex;
            gap: 8px;
        }
        .app-header .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gris-fond);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bleu-marine);
            font-size: 16px;
        }
        .app-header .action-btn:hover {
            background: var(--vert-clair);
            color: var(--vert-sante);
        }

        /* ------- Contenu principal ------- */
        .app-content {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
    </style>

    @stack('styles')
</head>
<body>

    <header class="app-header">
        <div class="logo">
            <div class="logo-icon"><i class="ti ti-heartbeat"></i></div>
            <div class="logo-text">VitaLit</div>
        </div>
        <div class="actions">
            <button class="action-btn" id="btn-recherche" title="Rechercher"><i class="ti ti-search"></i></button>
            <button class="action-btn" id="btn-localiser" title="Me localiser"><i class="ti ti-current-location"></i></button>
        </div>
    </header>

    <main class="app-content">
        @yield('contenu')
    </main>

    {{-- Leaflet JS pour les cartes interactives --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @stack('scripts')
</body>
</html>
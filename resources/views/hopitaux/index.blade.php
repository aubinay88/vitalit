@extends('layouts.app')

@section('titre', 'Trouver un centre')

@push('styles')
<style>
    /* ------- Barre de filtres ------- */
    .filtres {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 8px;
        margin-bottom: 20px;
        scrollbar-width: none;
    }
    .filtres::-webkit-scrollbar { display: none; }

    .filtre {
        background: var(--vert-clair);
        color: var(--vert-sante);
        font-size: 13px;
        padding: 8px 16px;
        border-radius: 20px;
        white-space: nowrap;
        cursor: pointer;
        border: none;
        align-items: center;
        gap: 5px;
        font-family: inherit;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
    }
    .filtre.actif {
        background: var(--vert-sante);
        color: white;
    }
    .filtre:hover:not(.actif) {
        background: #d5ebe6;
    }

    /* ------- Carte d'hôpital ------- */
    .hopital-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        border: 0.5px solid rgba(0, 0, 0, 0.06);
        display: flex;
        gap: 12px;
        transition: transform 0.15s, box-shadow 0.15s;
        cursor: pointer;
    }
    .hopital-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(11, 138, 122, 0.08);
    }

    .lits-badge {
        min-width: 60px;
        background: var(--vert-clair);
        border-radius: 12px;
        padding: 10px 6px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .lits-badge.tendu { background: #faeeda; }
    .lits-badge.plein { background: #fbe6e3; }
    .lits-badge .chiffre {
        font-size: 22px;
        font-weight: 600;
        color: var(--vert-sante);
        line-height: 1;
    }
    .lits-badge.tendu .chiffre { color: #a5680a; }
    .lits-badge.plein .chiffre { color: #a52a1a; }
    .lits-badge .libelle {
        font-size: 10px;
        color: var(--vert-sante);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
    }
    .lits-badge.tendu .libelle { color: #a5680a; }
    .lits-badge.plein .libelle { color: #a52a1a; }

    .hopital-infos {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    .hopital-nom {
        font-size: 15px;
        font-weight: 600;
        color: var(--bleu-marine);
        margin-bottom: 2px;
    }
    .hopital-meta {
        font-size: 12px;
        color: var(--gris-texte);
        margin-bottom: 8px;
    }
    .distance-badge {
    background: var(--vert-clair);
    color: var(--vert-sante);
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 6px;
    font-weight: 500;
    }
    .specialites-pastilles {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 10px;
    }
    .specialite-pastille {
        background: var(--gris-clair);
        color: var(--bleu-marine);
        font-size: 10px;
        padding: 3px 9px;
        border-radius: 10px;
    }
    .generaliste-note {
        font-size: 11px;
        color: var(--gris-texte);
        font-style: italic;
        margin-bottom: 10px;
    }

    .actions {
        display: flex;
        gap: 8px;
    }
    .btn {
        flex: 1;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-family: inherit;
    }
    .btn-secondaire {
        background: white;
        color: var(--bleu-marine);
        border: 0.5px solid #d0dcda;
    }
    .btn-secondaire:hover { background: var(--gris-fond); }
    .btn-principal {
        background: var(--vert-sante);
        color: white;
        flex: 1.4;
    }
    .btn-principal:hover { background: #09796b; }

    /* ------- Fresh info ------- */
    .fresh-info {
        margin-top: 20px;
        padding: 10px 14px;
        background: white;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: var(--gris-texte);
    }

    /* ------- Carte interactive ------- */
    .carte-container {
        height: 380px;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        border: 0.5px solid rgba(0, 0, 0, 0.06);
        position: relative;
    }
    #carte {
        width: 100%;
        height: 100%;
    }
    .marqueur-vitalit {
        background: transparent;
        border: none;
    }
    .marqueur-vitalit .goutte {
        width: 36px;
        height: 44px;
        position: relative;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .marqueur-vitalit .goutte-svg {
        width: 100%;
        height: 100%;
    }
    .marqueur-vitalit .chiffre {
        position: absolute;
        top: 8px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        color: white;
    }
    .barre-recherche {
    display: none;
    background: white;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 16px;
    border: 0.5px solid rgba(0,0,0,0.08);
    align-items: center;
    gap: 10px;
    }
    .barre-recherche.visible { display: flex; }
    .barre-recherche input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 14px;
        font-family: inherit;
        color: var(--bleu-marine);
        background: transparent;
    }
    .barre-recherche input::placeholder { color: #93a1ac; }
    .barre-recherche i { color: var(--vert-sante); font-size: 18px; }
    .barre-recherche .fermer-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        color: var(--gris-texte);
        font-size: 18px;
        padding: 0;
    }

        @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); color: #f39c12; }
        100% { transform: scale(1); }
    }
</style>
@endpush

@section('contenu')

    <h1 style="font-size: 22px; font-weight: 600; color: var(--bleu-marine); margin-bottom: 4px;">
        Trouver un centre de santé
    </h1>
    <p style="color: var(--gris-texte); font-size: 13px; margin-bottom: 20px;">
        {{ $hopitaux->count() }} centres référencés · Ouagadougou
    </p>

    {{-- Barre de recherche (masquée par défaut) --}}
    <form action="/hopitaux" method="GET" class="barre-recherche {{ isset($recherche) && $recherche ? 'visible' : '' }}" id="barre-recherche">
        <i class="ti ti-search"></i>
        <input type="text" name="q" placeholder="Rechercher un centre de santé..." value="{{ $recherche ?? '' }}" autofocus>
        @if($specialiteFiltree)
            <input type="hidden" name="specialite" value="{{ $specialiteFiltree }}">
        @endif
        @if($filtreDispo === 'libres')
            <input type="hidden" name="dispo" value="libres">
        @endif
        <button type="button" class="fermer-btn" onclick="fermerRecherche()"><i class="ti ti-x"></i></button>
    </form>

    {{-- Carte interactive avec les hôpitaux --}}
    <div class="carte-container">
        <div id="carte"></div>
    </div>

    {{-- Barre de filtres par spécialité --}}
    {{-- Barre de filtres --}}
    <div class="filtres">
        <a href="{{ request()->fullUrlWithQuery(['dispo' => $filtreDispo === 'libres' ? 'tous' : 'libres']) }}"
            class="filtre {{ $filtreDispo === 'libres' ? 'actif' : '' }}">
            <i class="ti ti-bed"></i> Lits libres
        </a>
        <span style="width: 1px; height: 24px; background: #d0dcda; margin: 0 6px; display: inline-block; align-self: center;"></span>
        <a href="/hopitaux{{ $filtreDispo === 'libres' ? '?dispo=libres' : '' }}" class="filtre {{ !$specialiteFiltree ? 'actif' : '' }}">Tous</a>
        @foreach($toutesSpecialites as $spec)
            <a href="/hopitaux?specialite={{ urlencode($spec) }}{{ $filtreDispo === 'libres' ? '&dispo=libres' : '' }}"
            class="filtre {{ $specialiteFiltree === $spec ? 'actif' : '' }}">
                {{ $spec }}
            </a>
        @endforeach
    </div>

    {{-- Liste des hôpitaux --}}
    @foreach ($hopitaux as $hopital)
        @php
            $ratio = $hopital->lits_total > 0 ? $hopital->lits_libres / $hopital->lits_total : 0;
            $classeBadge = $ratio > 0.5 ? '' : ($ratio > 0 ? 'tendu' : 'plein');
        @endphp

    <div class="hopital-card" id="hopital-card-{{ $hopital->id }}">
        <div class="lits-badge {{ $classeBadge }}">
            <div class="chiffre">{{ $hopital->lits_libres }}</div>
            <div class="libelle">libres</div>
        </div>

        <div class="hopital-infos">
            <div class="hopital-nom">{{ $hopital->nom }}</div>
            <div class="hopital-meta">
                {{ $hopital->type }} · {{ $hopital->quartier }}, {{ $hopital->ville }}
                <span class="distance-badge" id="distance-{{ $hopital->id }}" style="display: none;"></span>
            </div>

            @if($hopital->specialites->count() > 0)
                <div class="specialites-pastilles">
                    @foreach($hopital->specialites->take(3) as $spec)
                        <span class="specialite-pastille">{{ $spec->nom }}</span>
                    @endforeach
                    @if($hopital->specialites->count() > 3)
                        <span class="specialite-pastille">+{{ $hopital->specialites->count() - 3 }}</span>
                    @endif
                </div>
            @else
                <div class="generaliste-note">Centre généraliste</div>
            @endif

                <div class="actions">
                    <a href="/hopitaux/{{ $hopital->id }}" class="btn btn-secondaire" style="text-decoration: none;">Détails</a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $hopital->latitude }},{{ $hopital->longitude }}"
                        target="_blank"
                        class="btn btn-principal"
                        style="text-decoration: none;">
                            <i class="ti ti-navigation"></i> Y aller
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <div class="fresh-info">
        <div><i class="ti ti-refresh"></i> Données mises à jour à l'instant</div>
        <div>{{ $hopitaux->sum('lits_libres') }} lits libres sur {{ $hopitaux->sum('lits_total') }}</div>
    </div>

@endsection


@push('scripts')
<script>
    // Initialisation de la carte centrée sur Ouagadougou
    const carte = L.map('carte').setView([12.3686, -1.5275], 13);

    // Fond de carte OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
        maxZoom: 19
    }).addTo(carte);

    // Les hôpitaux (envoyés depuis PHP vers JavaScript)
    const hopitaux = [
    @foreach ($hopitaux as $hopital)
    {
        id: {{ $hopital->id }},
        nom: @json($hopital->nom),
        lat: {{ $hopital->latitude }},
        lng: {{ $hopital->longitude }},
        libres: {{ $hopital->lits_libres }},
        total: {{ $hopital->lits_total }},
        type: @json($hopital->type)
    },
    @endforeach
    ];
    // Fonction pour créer un marqueur en forme de goutte colorée
    function creerMarqueur(hopital) {
        const ratio = hopital.total > 0 ? hopital.libres / hopital.total : 0;
        const couleur = ratio > 0.5 ? '#0b8a7a' : (ratio > 0 ? '#f39c12' : '#e74c3c');

        const html = `
            <div class="goutte">
                <svg class="goutte-svg" viewBox="0 0 36 44" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 18 2 C 8 2, 2 10, 2 20 C 2 30, 10 34, 18 42 C 26 34, 34 30, 34 20 C 34 10, 28 2, 18 2 Z"
                          fill="${couleur}" stroke="white" stroke-width="2"/>
                </svg>
                <div class="chiffre">${hopital.libres}</div>
            </div>
        `;

        const icone = L.divIcon({
            html: html,
            className: 'marqueur-vitalit',
            iconSize: [36, 44],
            iconAnchor: [18, 44]
        });

        return L.marker([hopital.lat, hopital.lng], { icon: icone })
                .bindPopup(`<strong>${hopital.nom}</strong><br>${hopital.type} · ${hopital.libres}/${hopital.total} lits libres`);
    }

    // On ajoute chaque hôpital sur la carte
    hopitaux.forEach(h => creerMarqueur(h).addTo(carte));

    // ---------- Géolocalisation de l'utilisateur ----------
    let marqueurUtilisateur = null;

    function localiserUtilisateur() {
        if (!navigator.geolocation) {
            alert("Votre navigateur ne supporte pas la géolocalisation.");
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                const iconeUtilisateur = L.divIcon({
                    html: `
                        <div style="position: relative; width: 30px; height: 30px;">
                            <div style="position: absolute; inset: 0; border-radius: 50%; background: #378ADD; opacity: 0.2;"></div>
                            <div style="position: absolute; inset: 6px; border-radius: 50%; background: #378ADD; opacity: 0.4;"></div>
                            <div style="position: absolute; inset: 11px; border-radius: 50%; background: #378ADD; border: 2px solid white;"></div>
                        </div>
                    `,
                    className: 'marqueur-utilisateur',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                if (marqueurUtilisateur) {
                    carte.removeLayer(marqueurUtilisateur);
                }

                marqueurUtilisateur = L.marker([lat, lng], { icon: iconeUtilisateur })
                                       .bindPopup("Vous êtes ici")
                                       .addTo(carte);

                // ---------- Calcul et affichage des distances ----------
                function calculerDistance(lat1, lng1, lat2, lng2) {
                    // Formule de Haversine — distance à vol d'oiseau en km
                    const R = 6371; // Rayon de la Terre en km
                    const toRad = deg => deg * Math.PI / 180;
                    const dLat = toRad(lat2 - lat1);
                    const dLng = toRad(lng2 - lng1);
                    const a = Math.sin(dLat/2) ** 2 +
                              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                              Math.sin(dLng/2) ** 2;
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    return R * c;
                }

                // Calculer la distance pour chaque hôpital et l'ajouter dans son objet
                hopitaux.forEach(h => {
                    h.distance = calculerDistance(lat, lng, h.lat, h.lng);
                });

                // Trier les hôpitaux par distance (du plus proche au plus loin)
                hopitaux.sort((a, b) => a.distance - b.distance);

                // Afficher la distance sur chaque carte de la liste
                hopitaux.forEach(h => {
                    const badge = document.getElementById('distance-' + h.id);
                    if (badge) {
                        badge.textContent = h.distance.toFixed(1) + ' km';
                        badge.style.display = 'inline-block';
                    }
                });

                // Réordonner physiquement les cartes dans la liste
                const conteneurCartes = document.querySelector('.hopital-card').parentNode;
                hopitaux.forEach(h => {
                    const badge = document.getElementById('distance-' + h.id);
                    if (badge) {
                        const carteHopital = badge.closest('.hopital-card');
                        if (carteHopital) conteneurCartes.appendChild(carteHopital);
                    }
                });                       
                carte.setView([lat, lng], 14);
            },
            function (erreur) {
                let message = "Impossible de récupérer votre position.";
                if (erreur.code === 1) message = "Vous avez refusé l'accès à votre position.";
                else if (erreur.code === 2) message = "Position indisponible.";
                else if (erreur.code === 3) message = "La requête a pris trop de temps.";
                alert(message);
            }
        );
    }

    // Brancher la fonction sur le clic du bouton "Me localiser"
    document.getElementById('btn-localiser').addEventListener('click', localiserUtilisateur);

        // ---------- Barre de recherche ----------
    const btnRecherche = document.getElementById('btn-recherche');
    if (btnRecherche) {
        btnRecherche.addEventListener('click', function () {
            const barre = document.getElementById('barre-recherche');
            barre.classList.add('visible');
            barre.querySelector('input').focus();
        });
    }

    function fermerRecherche() {
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        window.location.href = url.toString();
    }

    // ---------- Rafraîchissement automatique toutes les 15 secondes ----------
    function rafraichirEtatReseau() {
        fetch('/api/etat-reseau')
            .then(response => response.json())
            .then(data => {
                let totalLibres = 0;
                let totalMax = 0;

                data.hopitaux.forEach(h => {
                    totalLibres += h.lits_libres;
                    totalMax += h.lits_total;

                    // Trouver la carte de cet hôpital par son id unique
                    const carte = document.getElementById(`hopital-card-${h.id}`);
                    if (!carte) return;

                    const badge = carte.querySelector('.lits-badge .chiffre');
                    if (badge && badge.textContent.trim() !== String(h.lits_libres)) {
                        badge.textContent = h.lits_libres;
                        badge.style.animation = 'pulse 0.6s ease';
                        setTimeout(() => badge.style.animation = '', 700);

                        // Mettre à jour aussi la couleur du badge selon le ratio
                        const badgeContainer = carte.querySelector('.lits-badge');
                        badgeContainer.classList.remove('tendu', 'plein');
                        const ratio = h.lits_total > 0 ? h.lits_libres / h.lits_total : 0;
                        if (ratio === 0) badgeContainer.classList.add('plein');
                        else if (ratio <= 0.5) badgeContainer.classList.add('tendu');
                    }
                });

                // Mettre à jour le total en bas
                const infoDiv = document.querySelector('.fresh-info div:last-child');
                if (infoDiv) infoDiv.textContent = `${totalLibres} lits libres sur ${totalMax}`;

                // Mettre à jour l'indicateur de fraîcheur
                const freshLabel = document.querySelector('.fresh-info div:first-child');
                if (freshLabel) freshLabel.innerHTML = `<i class="ti ti-refresh"></i> Mis à jour à l'instant`;
            })
            .catch(err => console.log('Erreur rafraîchissement:', err));
    }

    // Lancer toutes les 15 secondes
    setInterval(rafraichirEtatReseau, 15000);

</script>
@endpush
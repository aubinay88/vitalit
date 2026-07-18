@extends('layouts.app')

@section('titre', $hopital->nom)

@push('styles')
<style>
    .retour-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: white;
        border: 0.5px solid rgba(0,0,0,0.08);
        border-radius: 10px;
        color: var(--bleu-marine);
        text-decoration: none;
        font-size: 13px;
        margin-bottom: 16px;
        cursor: pointer;
    }
    .retour-btn:hover { background: var(--gris-fond); }

    .banniere {
        position: relative;
        height: 140px;
        border-radius: 18px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--vert-sante) 0%, var(--bleu-marine) 100%);
        margin-bottom: 16px;
        padding: 20px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .badge-online {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(255,255,255,0.95);
        color: var(--vert-sante);
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 500;
    }
    .banniere-titre { font-size: 22px; font-weight: 600; }
    .banniere-sous { font-size: 12px; opacity: 0.85; margin-bottom: 4px; }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }
    .stat-card {
        background: var(--gris-fond);
        border-radius: 14px;
        padding: 14px;
        text-align: center;
    }
    .stat-card.primaire { background: var(--vert-clair); }
    .stat-card .chiffre {
        font-size: 24px;
        font-weight: 600;
        color: var(--bleu-marine);
        line-height: 1;
    }
    .stat-card.primaire .chiffre { color: var(--vert-sante); }
    .stat-card .libelle {
        font-size: 11px;
        color: var(--gris-texte);
        margin-top: 4px;
    }
    .stat-card.primaire .libelle { color: var(--vert-sante); }

    .contact-card {
        background: white;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
        border: 0.5px solid rgba(0,0,0,0.06);
    }
    .contact-ligne {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--bleu-marine);
    }
    .contact-ligne + .contact-ligne { margin-top: 8px; }
    .contact-ligne i { font-size: 16px; color: var(--vert-sante); }
    .contact-ligne.vide { color: #93a1ac; font-style: italic; }
    .contact-ligne.vide i { color: #93a1ac; }

    .info-encadre {
        background: #f9f6ec;
        border: 0.5px solid #ecdfb0;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
        display: flex;
        gap: 12px;
    }
    .info-encadre i { font-size: 20px; color: #a5680a; flex-shrink: 0; }
    .info-encadre-titre {
        font-size: 13px;
        font-weight: 500;
        color: #6b4507;
        margin-bottom: 2px;
    }
    .info-encadre-texte {
        font-size: 12px;
        color: #85601a;
        line-height: 1.4;
    }

    .titre-section {
        font-size: 14px;
        font-weight: 600;
        color: var(--bleu-marine);
        margin-bottom: 10px;
    }

    .service-card {
        background: white;
        border-radius: 12px;
        padding: 12px 14px;
        border: 0.5px solid rgba(0,0,0,0.06);
        border-left: 3px solid var(--vert-sante);
        margin-bottom: 10px;
    }
    .service-card.complet { border-left-color: var(--rouge); }
    .service-card.tendu { border-left-color: var(--orange); }
    .service-titre-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .service-nom {
        font-size: 13px;
        font-weight: 500;
        color: var(--bleu-marine);
    }
    .service-stats {
        font-size: 12px;
        font-weight: 500;
        color: var(--vert-sante);
    }
    .service-card.complet .service-stats { color: var(--rouge); }
    .service-card.tendu .service-stats { color: #a5680a; }
    .barre-progress {
        height: 8px;
        background: var(--gris-clair);
        border-radius: 4px;
        overflow: hidden;
    }
    .barre-progress-fill { height: 100%; background: var(--vert-sante); }
    .service-card.complet .barre-progress-fill { background: var(--rouge); }
    .service-card.tendu .barre-progress-fill { background: var(--orange); }

    .specialites-groupe {
        background: white;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
        border: 0.5px solid rgba(0,0,0,0.06);
    }
    .specialites-groupe .pastilles { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .specialite-check {
        background: var(--vert-clair);
        color: var(--vert-sante);
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .fresh-info {
        margin-bottom: 16px;
        padding: 10px 14px;
        background: white;
        border-radius: 10px;
        font-size: 11px;
        color: var(--gris-texte);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .actions-bas {
        display: flex;
        gap: 10px;
    }
    .btn-action {
        flex: 1;
        padding: 14px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: inherit;
        text-decoration: none;
    }
    .btn-appel {
        background: white;
        color: var(--bleu-marine);
        border: 0.5px solid #d0dcda;
    }
    .btn-appel.disabled {
        background: var(--gris-fond);
        color: #93a1ac;
        cursor: not-allowed;
    }
    .btn-yaller {
        background: var(--vert-sante);
        color: white;
        flex: 1.4;
    }
    .btn-yaller:hover { background: #09796b; }
</style>
@endpush

@section('contenu')

<a href="/hopitaux" class="retour-btn">
    <i class="ti ti-arrow-left"></i> Retour à la liste
</a>

{{-- Bannière avec le nom --}}
<div class="banniere">
    @if($capteursEnLigne > 0)
        <div class="badge-online">
            <i class="ti ti-point-filled"></i> En ligne · {{ $capteursEnLigne }} capteur{{ $capteursEnLigne > 1 ? 's' : '' }}
        </div>
    @else
        <div class="badge-online" style="background: rgba(255,255,255,0.9); color: #a52a1a;">
            <i class="ti ti-point-filled"></i> Hors ligne
        </div>
    @endif
    <div>
        <div class="banniere-sous">{{ $hopital->type }}</div>
        <div class="banniere-titre">{{ $hopital->nom }}</div>
    </div>
</div>

{{-- Statistiques rapides --}}
<div class="stats-row">
    <div class="stat-card primaire">
        <div class="chiffre">{{ $stats['libres'] }}</div>
        <div class="libelle">lits libres</div>
    </div>
    <div class="stat-card">
        <div class="chiffre">{{ $stats['total'] }}</div>
        <div class="libelle">lits totaux</div>
    </div>
    <div class="stat-card">
        <div class="chiffre">{{ $hopital->specialites->count() }}</div>
        <div class="libelle">spécialités</div>
    </div>
</div>

{{-- Contact --}}
<div class="contact-card">
    <div class="contact-ligne">
        <i class="ti ti-map-pin"></i>
                {{ $hopital->adresse }}
        @if($hopital->quartier)
            , {{ $hopital->quartier }}
        @endif
        @if($hopital->secteur)
            , {{ $hopital->secteur }}
        @endif
    </div>
    @if($hopital->telephone)
        <div class="contact-ligne">
            <i class="ti ti-phone"></i>
            {{ $hopital->telephone }}
        </div>
    @else
        <div class="contact-ligne vide">
            <i class="ti ti-phone-off"></i>
            Téléphone non renseigné
        </div>
    @endif
</div>

{{-- Note pour les centres généralistes --}}
@if($hopital->specialites->count() === 0)
    <div class="info-encadre">
        <i class="ti ti-info-circle"></i>
        <div>
            <div class="info-encadre-titre">Centre de santé généraliste</div>
            <div class="info-encadre-texte">Prise en charge des soins de base. Pour les urgences spécialisées, un transfert peut être nécessaire.</div>
        </div>
    </div>
@endif

{{-- Disponibilité par service --}}
<div class="titre-section">
    @if($litsParService->count() > 1)
        Disponibilité par service
    @else
        État des lits
    @endif
</div>

@foreach($litsParService as $service => $lits)
    @php
        $libres = $lits->where('etat', 'libre')->count();
        $total = $lits->count();
        $ratio = $total > 0 ? $libres / $total : 0;
        $classe = $ratio === 0 ? 'complet' : ($ratio < 0.3 ? 'tendu' : '');
        $pourcent = $total > 0 ? round($ratio * 100) : 0;
        $libelleService = $service ?: 'Lits généraux';
    @endphp

    <div class="service-card {{ $classe }}">
        <div class="service-titre-row">
            <div class="service-nom">{{ $libelleService }}</div>
            <div class="service-stats">
                {{ $libres }} / {{ $total }} @if($libres === 0)· Complet @endif
            </div>
        </div>
        <div class="barre-progress">
            <div class="barre-progress-fill" style="width: {{ $pourcent }}%"></div>
        </div>
    </div>
@endforeach

{{-- Spécialités additionnelles --}}
@if($hopital->specialites->count() > 0)
    <div class="specialites-groupe" style="margin-top: 16px;">
        <div class="titre-section" style="margin-bottom: 0;">Spécialités disponibles</div>
        <div class="pastilles">
            @foreach($hopital->specialites as $spec)
                <span class="specialite-check">
                    <i class="ti ti-check"></i> {{ $spec->nom }}
                </span>
            @endforeach
        </div>
    </div>
@endif

{{-- Fresh info --}}
<div class="fresh-info">
    <i class="ti ti-refresh"></i>
    Données mises à jour à l'instant
</div>

{{-- Actions du bas --}}
<div class="actions-bas">
    @if($hopital->telephone)
        <a href="tel:{{ $hopital->telephone }}" class="btn-action btn-appel">
            <i class="ti ti-phone"></i> Appeler
        </a>
    @else
        <button class="btn-action btn-appel disabled" disabled>
            <i class="ti ti-phone-off"></i> Pas de numéro
        </button>
    @endif

    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $hopital->latitude }},{{ $hopital->longitude }}"
       target="_blank"
       class="btn-action btn-yaller">
        <i class="ti ti-navigation"></i> Y aller
    </a>
</div>

@endsection
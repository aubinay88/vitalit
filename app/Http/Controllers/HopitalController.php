<?php

namespace App\Http\Controllers;

use App\Models\Hopital;

class HopitalController extends Controller
{
    // Affiche la page principale avec la liste des hôpitaux
    public function index(\Illuminate\Http\Request $request)
    {
        $specialiteFiltree = $request->query('specialite');
        $filtreDispo = $request->query('dispo', 'tous');
        $recherche = $request->query('q');

        $query = Hopital::with(['lits', 'specialites']);

        if ($specialiteFiltree) {
            $query->whereHas('specialites', function ($q) use ($specialiteFiltree) {
                $q->where('nom', $specialiteFiltree);
            });
        }

        if ($recherche) {
            $query->where('nom', 'like', '%' . $recherche . '%');
        }

        $hopitaux = $query->get();

        foreach ($hopitaux as $hopital) {
            $hopital->lits_libres = $hopital->lits->where('etat', 'libre')->count();
            $hopital->lits_total = $hopital->lits->count();
        }

        if ($filtreDispo === 'libres') {
            $hopitaux = $hopitaux->filter(fn($h) => $h->lits_libres > 0)->values();
        }

        $toutesSpecialites = \App\Models\Specialite::select('nom')->distinct()->orderBy('nom')->pluck('nom');

        return view('hopitaux.index', [
            'hopitaux' => $hopitaux,
            'specialiteFiltree' => $specialiteFiltree,
            'filtreDispo' => $filtreDispo,
            'toutesSpecialites' => $toutesSpecialites,
            'recherche' => $recherche,
        ]);
    }

    // Affiche la page de détail d'un hôpital
        public function show(Hopital $hopital)
    {
        $hopital->load(['lits', 'specialites']);

        $litsParService = $hopital->lits->groupBy('service');

        $stats = [
            'total' => $hopital->lits->count(),
            'libres' => $hopital->lits->where('etat', 'libre')->count(),
            'occupes' => $hopital->lits->where('etat', 'occupe')->count(),
        ];

        // Calcul du statut de connexion : au moins un lit a envoyé un heartbeat récemment ?
        $seuilMinutes = 5; // On considère un capteur en ligne s'il a émis dans les 5 dernières minutes
        $capteursEnLigne = $hopital->lits->filter(function ($lit) use ($seuilMinutes) {
            return $lit->dernier_heartbeat &&
                \Carbon\Carbon::parse($lit->dernier_heartbeat)->diffInMinutes(now()) < $seuilMinutes;
        })->count();

        return view('hopitaux.show', [
            'hopital' => $hopital,
            'litsParService' => $litsParService,
            'stats' => $stats,
            'capteursEnLigne' => $capteursEnLigne,
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hopital;
use Illuminate\Http\JsonResponse;
use App\Models\Lit;
use Illuminate\Http\Request;

class LitController extends Controller
{
    // Renvoie la liste des lits d'un hôpital au format JSON
    public function index(Hopital $hopital): JsonResponse
    {
        $lits = $hopital->lits->map(function ($lit) {
            return [
                'id' => $lit->id,
                'numero' => $lit->numero,
                'service' => $lit->service,
                'etat' => $lit->etat,
                'derniere_maj' => $lit->derniere_maj,
            ];
        });

        return response()->json([
            'hopital' => [
                'id' => $hopital->id,
                'nom' => $hopital->nom,
            ],
            'nombre_lits' => $lits->count(),
            'lits' => $lits,
        ]);
    }

        // Met à jour l'état d'un lit (appelé par les ESP32)
    public function updateEtat(Request $request, Lit $lit): JsonResponse
    {
        // Valider les données envoyées
        $donnees = $request->validate([
            'etat' => 'required|in:libre,attente_confirmation,occupe,maintenance',
        ]);

        // Enregistrer le nouvel état et l'heure de mise à jour
        $lit->etat = $donnees['etat'];
        $lit->derniere_maj = now();
        $lit->save();

        // Renvoyer le lit mis à jour
        return response()->json([
            'success' => true,
            'lit' => [
                'id' => $lit->id,
                'numero' => $lit->numero,
                'etat' => $lit->etat,
                'derniere_maj' => $lit->derniere_maj,
            ],
        ]);
    }

    // L'ESP32 signale qu'il est vivant
    public function heartbeat(Request $request, Lit $lit): JsonResponse
    {
        $lit->dernier_heartbeat = now();
        $lit->save();

        return response()->json([
            'success' => true,
            'timestamp' => $lit->dernier_heartbeat,
        ]);
    }

    // Renvoie l'état résumé du réseau (pour rafraîchissement live)
    public function etatReseau(): JsonResponse
    {
        $hopitaux = Hopital::with('lits')->get()->map(function ($hopital) {
            return [
                'id' => $hopital->id,
                'lits_libres' => $hopital->lits->where('etat', 'libre')->count(),
                'lits_total' => $hopital->lits->count(),
            ];
        });

        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'hopitaux' => $hopitaux,
        ]);
    }
}
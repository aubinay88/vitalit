<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lit;
use Symfony\Component\HttpFoundation\Response;

class VerifierTokenLit
{
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer le token envoyé dans l'entête
        $tokenEnvoye = $request->header('X-Lit-Token');

        if (!$tokenEnvoye) {
            return response()->json([
                'error' => 'Token manquant',
                'message' => 'Cet endpoint nécessite un token dans l\'entête X-Lit-Token.',
            ], 401);
        }

         // Récupérer le lit visé par l'URL (déjà résolu par le route model binding)
        $lit = $request->route('lit');

        if (!$lit || !($lit instanceof Lit)) {
            return response()->json(['error' => 'Lit introuvable'], 404);
        }

        // Vérifier que le token correspond bien à ce lit
        if ($lit->token !== $tokenEnvoye) {
            return response()->json([
                'error' => 'Token invalide',
                'message' => 'Le token ne correspond pas à ce lit.',
            ], 403);
        }

        // Tout est bon, on laisse passer
        return $next($request);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hopital;
use App\Models\Lit;
use App\Models\Specialite;

class HopitalSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Hôpital 1 : un grand CHU ----------
        $chu = Hopital::create([
            'nom' => 'CHU Yalgado Ouédraogo',
            'type' => 'CHU',
            'adresse' => 'Avenue Oubritenga',
            'secteur' => 'Secteur 4',
            'quartier' => 'Koulouba',
            'ville' => 'Ouagadougou',
            'telephone' => '+226 25 30 66 44',
            'latitude' => 12.3686,
            'longitude' => -1.5275,
        ]);

        // Ses spécialités
        foreach (['Cardiologie', 'Maternité', 'Chirurgie', 'Pédiatrie', 'Réanimation'] as $nom) {
            Specialite::create(['hopital_id' => $chu->id, 'nom' => $nom]);
        }

        // Ses lits (15 lits répartis en 3 services)
        for ($i = 1; $i <= 5; $i++) {
            Lit::create(['hopital_id' => $chu->id, 'service' => 'Urgences', 'numero' => "U$i", 'etat' => 'libre']);
        }
        for ($i = 1; $i <= 5; $i++) {
            Lit::create(['hopital_id' => $chu->id, 'service' => 'Maternité', 'numero' => "M$i", 'etat' => 'occupe']);
        }
        for ($i = 1; $i <= 5; $i++) {
            Lit::create(['hopital_id' => $chu->id, 'service' => 'Cardiologie', 'numero' => "C$i", 'etat' => 'libre']);
        }

        // ---------- Hôpital 2 : un centre médical moyen ----------
        $cma = Hopital::create([
            'nom' => 'CMA de Pissy',
            'type' => 'CMA',
            'adresse' => 'Route de Bobo',
            'secteur' => 'Secteur 17',
            'quartier' => 'Pissy',
            'ville' => 'Ouagadougou',
            'telephone' => '+226 25 43 12 00',
            'latitude' => 12.3344,
            'longitude' => -1.5612,
        ]);

        foreach (['Maternité', 'Pédiatrie', 'Chirurgie'] as $nom) {
            Specialite::create(['hopital_id' => $cma->id, 'nom' => $nom]);
        }

        for ($i = 1; $i <= 8; $i++) {
            Lit::create(['hopital_id' => $cma->id, 'service' => 'Général', 'numero' => "G$i", 'etat' => $i <= 5 ? 'libre' : 'occupe']);
        }

        // ---------- Hôpital 3 : un petit centre de santé sans services différenciés ----------
        $csps = Hopital::create([
            'nom' => 'CSPS de Tanghin',
            'type' => 'CSPS',
            'adresse' => 'Quartier Tanghin',
            'secteur' => 'Secteur 23',
            'quartier' => 'Tanghin',
            'ville' => 'Ouagadougou',
            'telephone' => null,
            'latitude' => 12.4012,
            'longitude' => -1.5089,
        ]);

        // Pas de spécialités, juste des lits sans service précis (cas du petit centre rural)
        for ($i = 1; $i <= 6; $i++) {
            Lit::create(['hopital_id' => $csps->id, 'service' => null, 'numero' => "Lit $i", 'etat' => 'libre']);
        }
    }
}
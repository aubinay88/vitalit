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

        // On repart toujours d'une base propre : supprime les hôpitaux existants.
        // Grâce au onDelete('cascade') sur les clés étrangères, leurs lits et
        // spécialités sont automatiquement supprimés aussi.
        Hopital::query()->delete();
        
        $etablissements = [
            [
                'nom' => 'CHU Yalgado Ouédraogo',
                'type' => 'CHU',
                'adresse' => '03 BP 7022 Ouagadougou 03',
                'secteur' => null, 'quartier' => null,
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 31 16 55',
                'email' => 'chuyobf@gmail.com',
                'latitude' => 12.383703801296024, 'longitude' => -1.5064680577581824,
                'specialites' => ['Cardiologie', 'Maternité', 'Chirurgie', 'Pédiatrie', 'Réanimation'],
                'services' => ['Urgences' => 6, 'Maternité' => 6, 'Cardiologie' => 5, 'Chirurgie' => 5, 'Pédiatrie' => 5],
            ],
            [
                'nom' => 'CHU de Tingandogo',
                'type' => 'CHU',
                'adresse' => '7F76+2JP, Sandogo', 'secteur' => null, 'quartier' => 'Sandogo',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 49 09 00', 'email' => null,
                'latitude' => 12.262497224907786, 'longitude' => -1.5384144972210183,
                'specialites' => ['Cardiologie', 'Chirurgie', 'Réanimation', 'Maternité'],
                'services' => ['Urgences' => 5, 'Cardiologie' => 5, 'Chirurgie' => 5, 'Maternité' => 5],
            ],
            [
                'nom' => 'CHU de Bogodogo',
                'type' => 'CHU',
                'adresse' => 'Bogodogo', 'secteur' => 'Secteur 30', 'quartier' => 'Bogodogo',
                'ville' => 'Ouagadougou', 'telephone' => null, 'email' => null,
                'latitude' => 12.33687, 'longitude' => -1.49405,
                'specialites' => ['Chirurgie', 'Maternité', 'Pédiatrie'],
                'services' => ['Urgences' => 5, 'Maternité' => 5, 'Chirurgie' => 5, 'Pédiatrie' => 5],
            ],
            [
                'nom' => 'Hôpital Saint Camille',
                'type' => 'Hôpital confessionnel',
                'adresse' => '23 Ave Babanguida', 'secteur' => 'Secteur 23', 'quartier' => '1200 Logements',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 36 30 56',
                'email' => 'contact@saintcamillebf.net',
                'latitude' => 12.366493515270221, 'longitude' => -1.4952202340424359,
                'specialites' => ['Maternité', 'Chirurgie', 'Pédiatrie'],
                'services' => ['Urgences' => 5, 'Maternité' => 5, 'Chirurgie' => 5],
            ],
            [
                'nom' => 'Hôpital Paul VI',
                'type' => 'Hôpital',
                'adresse' => 'Tampouy', 'secteur' => null, 'quartier' => 'Tampouy',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 35 00 65', 'email' => null,
                'latitude' => 12.399827624922173, 'longitude' => -1.5577353424858535,
                'specialites' => ['Maternité', 'Chirurgie'],
                'services' => ['Maternité' => 6, 'Chirurgie' => 6],
            ],
            [
                'nom' => 'Hôpital Pédiatrique Charles de Gaulle',
                'type' => 'CHU',
                'adresse' => '979 Boulevard des Tensoba', 'secteur' => null, 'quartier' => 'Dassasgo',
                'ville' => 'Ouagadougou', 'telephone' => '+226 76 76 76 76', 'email' => null,
                'latitude' => 12.374212416684273, 'longitude' => -1.471552652306962,
                'specialites' => ['Pédiatrie', 'Réanimation'],
                'services' => ['Pédiatrie' => 10, 'Réanimation' => 8],
            ],
            [
                'nom' => 'Clinique Saint Jean',
                'type' => 'Clinique privée',
                'adresse' => 'Bilbalogho', 'secteur' => null, 'quartier' => 'Bilbalogho',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 33 56 22', 'email' => null,
                'latitude' => 12.360582055465114, 'longitude' => -1.5345028154157738,
                'specialites' => ['Maternité'],
                'services' => ['Maternité' => 8],
            ],
            [
                'nom' => 'Clinique Dr Ouédraogo Issa',
                'type' => 'Clinique privée',
                'adresse' => 'Zone I', 'secteur' => 'Zone I', 'quartier' => 'Zone I',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 37 23 85', 'email' => null,
                'latitude' => 12.358930093573687, 'longitude' => -1.4773549113092888,
                'specialites' => [],
                'services' => ['Général' => 6],
            ],
            [
                'nom' => 'Clinique La Grâce Marie',
                'type' => 'Clinique privée',
                'adresse' => 'Rue FADOUL, Zone Industrielle de Gounghin', 'secteur' => null, 'quartier' => 'Gounghin',
                'ville' => 'Ouagadougou', 'telephone' => '+226 70 24 52 99', 'email' => null,
                'latitude' => 12.364510637732616, 'longitude' => -1.5392181780642795,
                'specialites' => ['Maternité'],
                'services' => ['Maternité' => 8],
            ],
            [
                'nom' => 'Centre Médical Bethsaïda',
                'type' => 'Centre médical',
                'adresse' => 'Sandogo', 'secteur' => null, 'quartier' => 'Sandogo',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 37 67 14', 'email' => null,
                'latitude' => 12.297974084432115, 'longitude' => -1.533717956838411,
                'specialites' => [],
                'services' => ['Général' => 6],
            ],
            [
                'nom' => 'Centre médical protestant Schiphra',
                'type' => 'Centre médical',
                'adresse' => '9FRJ+8QQ, Tanghin', 'secteur' => null, 'quartier' => 'Tanghin',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 33 32 29', 'email' => null,
                'latitude' => 12.390875523122729, 'longitude' => -1.517955249600524,
                'specialites' => ['Maternité'],
                'services' => ['Maternité' => 10],
            ],
            [
                'nom' => 'Clinique Princesse Sarah',
                'type' => 'Clinique privée',
                'adresse' => '05 BP 6369 Ouaga 05', 'secteur' => null, 'quartier' => 'Ouaga 2000',
                'ville' => 'Ouagadougou', 'telephone' => '+226 61 07 20 20', 'email' => null,
                'latitude' => 12.314594227294457, 'longitude' => -1.5119646873388677,
                'specialites' => ['Chirurgie'],
                'services' => ['Chirurgie' => 8],
            ],
            [
                'nom' => 'Clinique El Fateh Suka',
                'type' => 'Clinique privée',
                'adresse' => 'Pissy', 'secteur' => null, 'quartier' => 'Pissy',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 43 06 00', 'email' => null,
                'latitude' => 12.337268192852967, 'longitude' => -1.559513164821095,
                'specialites' => [],
                'services' => ['Général' => 6],
            ],
            [
                'nom' => 'CMA Source de Vie',
                'type' => 'CMA',
                'adresse' => null, 'secteur' => null, 'quartier' => 'Pissy',
                'ville' => 'Ouagadougou', 'telephone' => '+226 25 41 44 52', 'email' => 'ons.sam@live.fr',
                'latitude' => 12.332681477633539, 'longitude' => -1.5612581846537692,
                'specialites' => ['Maternité', 'Chirurgie', 'Pédiatrie'],
                'services' => ['Maternité' => 4, 'Chirurgie' => 4, 'Pédiatrie' => 4],
            ],
            [
                'nom' => 'CSPS CANDAF',
                'type' => 'CSPS',
                'adresse' => null, 'secteur' => null, 'quartier' => 'Sanyiri',
                'ville' => 'Ouagadougou', 'telephone' => '+226 71 61 56 55', 'email' => null,
                'latitude' => 12.342190847117195, 'longitude' => -1.4709671238912856,
                'specialites' => [],
                'services' => ['Général' => 6],
            ],
            [
                'nom' => 'Centre Médical de Nagrin',
                'type' => 'Centre médical',
                'adresse' => null, 'secteur' => null, 'quartier' => 'Nagrin',
                'ville' => 'Ouagadougou', 'telephone' => null, 'email' => null,
                'latitude' => 12.287146282940006, 'longitude' => -1.5340209827395015,
                'specialites' => [],
                'services' => ['Général' => 5],
            ],
            [
                'nom' => 'Polyclinique Internationale de Ouagadougou',
                'type' => 'Clinique privée',
                'adresse' => 'Ouaga 2000', 'secteur' => null, 'quartier' => 'Ouaga 2000',
                'ville' => 'Ouagadougou', 'telephone' => '+226 72 69 69 11',
                'email' => 'secretariat@pcio-ouaga.com',
                'latitude' => 12.309801964628813, 'longitude' => -1.4939293133683778,
                'specialites' => ['Cardiologie', 'Maternité', 'Chirurgie', 'Pédiatrie'],
                'services' => ['Cardiologie' => 4, 'Maternité' => 4, 'Chirurgie' => 4, 'Pédiatrie' => 3],
            ],
            [
                'nom' => "CSPS Trame d'Accueil Ouaga 2000",
                'type' => 'CSPS',
                'adresse' => 'Ouaga 2000', 'secteur' => null, 'quartier' => 'Ouaga 2000',
                'ville' => 'Ouagadougou', 'telephone' => null, 'email' => null,
                'latitude' => 12.30776972518562, 'longitude' => -1.4883419903653212,
                'specialites' => [],
                'services' => ['Général' => 5],
            ],
            [
                'nom' => 'CSPS de Balkouy',
                'type' => 'CSPS',
                'adresse' => null, 'secteur' => null, 'quartier' => 'Balkouy',
                'ville' => 'Ouagadougou', 'telephone' => null, 'email' => null,
                'latitude' => 12.290324422638818, 'longitude' => -1.4551740121809773,
                'specialites' => [],
                'services' => ['Général' => 4],
            ],
        ];

        foreach ($etablissements as $data) {
            $hopital = Hopital::create([
                'nom' => $data['nom'],
                'type' => $data['type'],
                'adresse' => $data['adresse'],
                'secteur' => $data['secteur'],
                'quartier' => $data['quartier'],
                'ville' => $data['ville'],
                'telephone' => $data['telephone'],
                'email' => $data['email'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);

            foreach ($data['specialites'] as $nomSpecialite) {
                Specialite::create(['hopital_id' => $hopital->id, 'nom' => $nomSpecialite]);
            }

            $numero = 1;
            foreach ($data['services'] as $service => $nombreLits) {
                for ($i = 1; $i <= $nombreLits; $i++) {
                    // Environ 2 lits sur 3 sont libres, pour une démo réaliste et variée
                    $etat = ($i % 3 === 0) ? 'occupe' : 'libre';

                    Lit::create([
                        'hopital_id' => $hopital->id,
                        'service' => $service === 'Général' ? null : $service,
                        'numero' => 'L' . $numero,
                        'etat' => $etat,
                    ]);
                    $numero++;
                }
            }
        }
    }
}
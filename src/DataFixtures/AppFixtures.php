<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventPage;
use App\Entity\EventPart;
use App\Entity\Level;
use App\Entity\MessageEncouragement;
use App\Entity\Path;
use App\Entity\Tip;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventPartType;
use App\Enum\EventStatus;
use App\Enum\EventType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ------------------------------------------------------------------
        // 1. MESSAGES D'ENCOURAGEMENT (x10)
        // ------------------------------------------------------------------
        $messages = [
            "Chaque petit geste compte pour la planète !",
            "Bravo ! Tu viens de faire un pas de géant pour l'éco-transition.",
            "La Terre te remercie pour ton engagement !",
            "Incroyable ! Continue comme ça, tu gères.",
            "Éco-citoyen un jour, éco-citoyen toujours !",
            "Quelle motivation ! Continue comme ça.",
            "Garde le cap, l'impact positif est mesurable !",
            "Splendide effort ! La biodiversité compte sur toi.",
            "Tu réduis ton empreinte à vitesse grand V !",
            "Félicitations pour cette étape franchie avec succès."
        ];

        foreach ($messages as $msgContent) {
            $message = new MessageEncouragement();
            $message->setContent($msgContent);
            $manager->persist($message);
        }

        // ------------------------------------------------------------------
        // 2. ASTUCES (x3)
        // ------------------------------------------------------------------
        $tipAlim = new Tip();
        $tipAlim->setContent("Manger des fruits et légumes de saison permet de réduire l'impact écologique du transport et de profiter de meilleurs bienfaits nutritionnels.");
        $manager->persist($tipAlim);

        $tip2Tonnes = new Tip();
        $tip2Tonnes->setContent("L'objectif mondial est d'atteindre une empreinte de 2 tonnes de CO2 maximum, par personne et par an, d'ici 2050, pour limiter le réchauffement climatique.");
        $manager->persist($tip2Tonnes);

        $tipBio = new Tip();
        $tipBio->setContent("Protéger la biodiversité locale commence dans son assiette et son jardin : réduire les pesticides et préserver les espaces naturels sauvages.");
        $manager->persist($tipBio);

        // ------------------------------------------------------------------
        // 3. PARCOURS (x1)
        // ------------------------------------------------------------------
        $path = new Path();
        $path->setName("Éco-Pionnier : Les 4 Piliers");
        $path->setNbOfLevels(3);
        $path->setDescription("Un parcours généraliste structuré autour des 4 grands piliers de la transition écologique : le transport, l'alimentation, l'énergie et la consommation responsable.");
        $manager->persist($path);

        // ------------------------------------------------------------------
        // 4. NIVEAUX (x3)
        // ------------------------------------------------------------------
        $level1 = new Level();
        $level1->setName("Ma petite planète");
        $level1->setTip($tipAlim);
        $level1->setPath($path);
        $level1->setSequenceNumber(1);
        $level1->setMascot1("uploads/mascots/panda_roux_1.webp");
        $level1->setMascot2("uploads/mascots/panda_roux_2.webp");
        $manager->persist($level1);

        $level2 = new Level();
        $level2->setName("2Tonnes");
        $level2->setTip($tip2Tonnes);
        $level2->setPath($path);
        $level2->setSequenceNumber(2);
        $level2->setMascot1("uploads/mascots/manchot_1.webp");
        $level2->setMascot2("uploads/mascots/manchot_3.webp");
        $manager->persist($level2);

        $level3 = new Level();
        $level3->setName("WWF");
        $level3->setTip($tipBio);
        $level3->setPath($path);
        $level3->setSequenceNumber(3);
        $level3->setMascot1("uploads/mascots/manchot_2.webp");
        $level3->setMascot2("uploads/mascots/panda_roux_3.webp");
        $manager->persist($level3);

        // ------------------------------------------------------------------
        // 5. UTILISATEURS (x3)
        // ------------------------------------------------------------------
        $elia = new User();
        $elia->setUsername("Elia Chelet");
        $elia->setEmail("elia@mail.fr");
        $elia->setLogo("uploads/logos/elia.png");
        $elia->setPassword($this->passwordHasher->hashPassword($elia, "elia"));
        $elia->setPath($path);
        $manager->persist($elia);

        $emile = new User();
        $emile->setUsername("Emile Teneflen");
        $emile->setEmail("emile@mail.fr");
        $emile->setLogo("uploads/logos/emile.png");
        $emile->setPassword($this->passwordHasher->hashPassword($emile, "emile"));
        $emile->setPath($path);
        $manager->persist($emile);

        $coline = new User();
        $coline->setUsername("Coline Arisarj");
        $coline->setEmail("coline@mail.fr");
        $coline->setLogo("uploads/logos/coline.png");
        $coline->setPassword($this->passwordHasher->hashPassword($coline, "coline"));
        $coline->setPath($path);
        $manager->persist($coline);


        // ------------------------------------------------------------------
        // 6. ÉVÉNEMENTS (x30)
        // ------------------------------------------------------------------
        // Structure de chaque élément :
        // Type LEÇON : ['type' => 'lesson', 'data' => [ [Q1, Choices1, Right1, Expl1], [Q2, Choices2, Right2, Expl2] ]]
        // Type DÉFI  : ['type' => 'defi', 'co2' => X, 'data' => [impact, thématique, titre, desc, astuce_q, astuce_r]]

        $default_alt = "Eolienne dans un ciel nuageux.";

        $rawEventsData = [
            // ==================== NIVEAU 1 : MA PETITE PLANÈTE ====================
            1 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Nuage de CO2 libéré par le tuyau d'une usine.",
                    "Empreinte d'une paire de chaussure dans le sable."
                ],
                'data' => [
                    ['Quelle est l\'empreinte carbone moyenne d\'un français par an ?', ['2 tonnes', '5 tonnes', '9 tonnes', '15 tonnes'], '9 tonnes', "L'empreinte carbone mesure la quantité de gaz à effet de serre (GES) émis par nos activités sur une année.\n\n L'empreinte moyenne en France est de 9 tonnes de CO2 par an.\n\n Cette moyenne est calculée en prenant en compte notamment l'alimentation, les transport, le logement, les services publics et le numérique."],
                    ['Pour respecter l\'Accord de Paris, à combien doit-on réduire cette empreinte d\'ici 2050 ?', ['0 tonne', '2 tonnes', '5 tonnes', '7 tonnes'], '2 tonnes', "Afin de limiter la hausse du réchauffement climatique en dessous de 2 degrés, l'objectif des accords sur le climat est de converger vers 2 tonnes d'émission de CO2 maximum, par an, par personne.\n\n Rendez-vous au prochain défi pour calculer ton empreinte carbone et identifier les actions les plus efficaces pour la réduire."]
                ]
            ],
            2 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Légumes de toutes les couleurs regroupés sur un fond blanc.",
                    "Légumes de toutes les couleurs regroupés sur un fond blanc."
                ],
                'data' => [
                    ['Quel légume consommé en hiver en France a l\'empreinte carbone la plus élevée ?', ['Le poireau local', 'La tomate sous serre chauffée', 'La carotte de saison', 'Le chou-fleur'], 'La tomate sous serre chauffée', 'Une tomate produite en hiver sous serre chauffée peut émettre jusqu\'à 10 fois plus de CO2 qu\'une tomate produite en été en plein champ.'],
                    ['Pourquoi privilégier les circuits courts pour l\'alimentation ?', ['Pour payer plus cher', 'Pour réduire le transport et les emballages', 'Pour manger moins de vitamines', 'Uniquement pour le style'], 'Pour réduire le transport et les emballages', 'Les circuits courts limitent les intermédiaires logistiques, réduisant ainsi les émissions de transport routier et le suremballage protecteur.']
                ]
            ],
            3 => [
                'type' => 'defi',
                'co2' => 5.0,
                'picture_alt' => "Calculatrice posée à côté d'un carnet ouvert et d'un stylo dans l'herbe.",
                'data' => ['Fort', 'Sensibilisation', 'Calculer son empreinte carbone', "Rends-toi sur nosgestesclimat.fr ou 2tonnes.org et réponds au questionnaire pour mesurer ton empreinte carbone annuelle.\n\n Le calculateur carbone permet de comprendre quels sont nos usages qui contribuent le plus au changement climatique et de saisir les actions qui auraient le plus d'impact pour le réduire.", 'Pourquoi mesurer economise-t-il 5 kg de CO2 ?', "Le calcul en lui même n'économise rien mais les études (comme celles de l'ADEME) montrent que cette prise de conscience génère une baisse statistique d'environ 1 à 2 % des émissions annuelles d'un individu."]
            ],
            4 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['En France, quelle est la principale source de consommation d\'énergie dans un logement ?', ['Les appareils électroménagers', 'L\'éclairage', 'Le chauffage', 'L\'eau chaude sanitaire'], 'Le chauffage', 'Le chauffage représente en moyenne 60% de la consommation énergétique d\'un foyer français.'],
                    ['Quelle action simple permet de réduire instantanément sa facture de chauffage ?', ['Ouvrir les fenêtres toute la journée', 'Baisser le thermostat de 1°C', 'Laisser la lumière allumée', 'Chauffer les pièces vides à 23°C'], 'Baisser le thermostat de 1°C', 'Baisser le chauffage de seulement 1°C permet d\'économiser environ 7% d\'énergie sur l\'année.']
                ]
            ],
            5 => [
                'type' => 'defi',
                'co2' => 24.0,
                'picture_alt' => "Chargeur de téléphone débranché de son adaptateur sur un sol en bois.",
                'data' => ['Faible', 'Energie', 'Débrancher les chargeurs et les veilles', "Fais le tour de ton logement et débranche tous les chargeurs inutilisés ainsi que les appareils électroniques laissés en veille.\n\n Tu peux également utiliser des multiprises à interrupteur pour tout couper d'un seul geste le moment venu.", 'Quel est le vrai coût des appareils en veille ?', "Les veilles consomment inutilement entre 300 et 500 kWh par an dans un foyer français, ce qui pèse lourd sur la facture sans aucun bénéfice d'usage."]
            ],
            6 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Rayonnage dans un supermarché.",
                    "Rayonnage dans un supermarché."
                ],
                'data' => [
                    ['Qu\'est-ce que l\'éco-score d\'un produit de grande consommation ?', ['Un indicateur de prix', 'Une note sur l\'impact environnemental global', 'Un label de qualité gustative', 'Une mesure du taux de sucre'], 'Une note sur l\'impact environnemental global', 'L\'éco-score prend en compte tout le cycle de vie du produit (production, emballage, transport) pour évaluer son impact sur la planète.'],
                    ['Quel mode de livraison a le meilleur bilan écologique pour un colis ?', ['La livraison express à domicile', 'Le retrait en point relais (à pied)', 'La livraison par drone', 'Le drive voiture'], 'Le retrait en point relais (à pied)', 'Le point relais massifie les flux de livraison. Si vous allez le chercher à pied ou à vélo, vous supprimez l\'impact du dernier kilomètre.']
                ]
            ],
            7 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Poubelle bleue avec le symbole de tri inscrit dessus.",
                    "Poubelle bleue avec le symbole de tri inscrit dessus."
                ],
                'data' => [
                    ['Combien de fois peut-on recycler le verre à l\'infini ?', ['2 fois', '10 fois', 'À l\'infini', 'Ce n\'est pas recyclable'], 'À l\'infini', 'Le verre se recycle à 100% et à l\'infini sans perte de qualité, ce qui économise des matières premières et de l\'énergie de fusion.'],
                    ['Quel déchet met le plus de temps à se décomposer dans la nature ?', ['Un trognon de pomme', 'Un sac plastique', 'Une bouteille en verre', 'Un journal'], 'Une bouteille en verre', 'Il faut environ 4000 ans pour qu\'une bouteille en verre se décompose complètement à l\'état sauvage, contre 450 ans pour un sac plastique.']
                ]
            ],
            8 => [
                'type' => 'defi',
                'co2' => 25.0,
                'picture_alt' => "Quatre poubelles de couleur (jaune, bleue, rouge, vert) alignées sur un trottoir.",
                'data' => ['Moyen', 'Déchets', 'Trier rigoureusement ses déchets', "Installe des poubelles séparées chez toi et respecte les consignes de tri de ta commune pour le verre, le carton et les emballages.\n\n Si tu as un doute, tu peux vérifier les logos sur les emballages.", 'Pourquoi le tri est-il si important pour le climat ?', "Le recyclage évite l'incinération polluante et l'extraction de matières premières vierges, ce qui économise de grandes quantités d'énergie industrielle.\n\n De plus, trier correctement permet de réduire la quantité de déchets enfouis qui génèrent du méthane en se décomposant."]
            ],
            9 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Cuisine d'un appartement comportant des appareils électroménagers.",
                    "Cuisine d'un appartement comportant des appareils électroménagers."
                ],
                'data' => [
                    ['Quel appareil ménager consomme généralement le plus d\'eau chaude ?', ['Le lave-vaisselle', 'Le lave-linge', 'La douche / baignoire', 'La bouilloire'], 'La douche / baignoire', 'L\'eau chaude sanitaire des douches et des bains représente la majeure partie de l\'utilisation d\'eau chaude d\'une maison.'],
                    ['Quelle est la durée idéale d\'une éco-douche ?', ['5 minutes', '20 minutes', '45 minutes', 'Moins d\'une minute'], '5 minutes', 'Une douche de 5 minutes consomme environ 40 à 60 litres d\'eau, contre près de 150 litres pour un bain ou une douche prolongée.']
                ]
            ],
            10 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Compost contenant des fruits en décomposition.",
                    "Compost contenant des fruits en décomposition."
                ],
                'data' => [
                    ['Quel est l\'avantage principal du compostage des biodéchets ?', ['Ça prend de la place', 'Réduire le volume de la poubelle et créer du terreau', 'Attirer des animaux dangereux', 'Faire joli dans la cuisine'], 'Réduire le volume de la poubelle et créer du terreau', 'Le compostage permet d\'alléger nos poubelles d\'un tiers de leur poids et d\'éviter l\'incinération inutile d\'eau.'],
                    ['Que peut-on mettre en toute sécurité dans un compost classique ?', ['Des épluchures de légumes', 'Du plastique biodégradable', 'Des restes de viande grasse', 'Des piles usagées'], 'Des épluchures de légumes', 'Les matières végétales crues comme les épluchures, le marc de café et les cartons bruts non imprimés font le meilleur compost.']
                ]
            ],

            // ==================== NIVEAU 2 : 2TONNES ====================
            11 => [
                'type' => 'lesson',
                'picture_alts' => [
                    "Nuage de CO2 libéré par le tuyau d'une usine.",
                    "Empreinte d'une paire de chaussure dans le sable."
                ],
                'data' => [
                    ['Quelle est l\'empreinte carbone moyenne d\'un français par an ?', ['2 tonnes', '5 tonnes', '9 tonnes', '15 tonnes'], '9 tonnes', "L'empreinte carbone mesure la quantité de gaz à effet de serre (GES) émis par nos activités sur une année.\n\n L'empreinte moyenne en France est de 9 tonnes de CO2 par an.\n\n Cette moyenne est calculée en prenant en compte notamment l'alimentation, les transport, le logement, les services publics et le numérique."],
                    ['Pour respecter l\'Accord de Paris, à combien doit-on réduire cette empreinte d\'ici 2050 ?', ['0 tonne', '2 tonnes', '5 tonnes', '7 tonnes'], '2 tonnes', "Afin de limiter la hausse du réchauffement climatique en dessous de 2 degrés, l'objectif des accords sur le climat est de converger vers 2 tonnes d'émission de CO2 maximum, par an, par personne.\n\n Rendez-vous au prochain défi pour calculer ton empreinte carbone et identifier les actions les plus efficaces pour la réduire."]
                ]
            ],
            12 => [
                'type' => 'defi',
                'co2' => 14.0,
                'picture_alt' => "Belle assiette composée exclusivement de légumes, céréales et légumineuses.",
                'data' => ['Moyen', 'Alimentation', 'Un jour végétarien par semaine (pendant 1 mois)', "Pendant 4 semaines, remplace la viande et le poisson d'une journée entière par des protéines végétales savoureuses.\n\n Tu peux cuisiner par exemple des lentilles, des pois chiches ou des haricots associés à des céréales pour obtenir un repas complet et équilibré.", 'Quel est l\'impact de l\'élevage ?', "Un jour sans viande économise environ 3 à 4 kg de CO2.\n\n L'élevage bovin intensif est très émetteur de méthane et nécessite d'immenses surfaces agricoles, ce qui favorise malheureusement la déforestation."]
            ],
            13 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel secteur d\'activité génère le plus d\'émissions de gaz à effet de serre en France ?', ['Les transports', 'Le numérique', 'L\'agriculture', 'L\'industrie textile'], 'Les transports', 'Le secteur des transports est le premier émetteur en France, représentant environ 30% des émissions nationales, majoritairement dues aux voitures individuelles.'],
                    ['Dans les transports, quelle part de CO2 provient de la voiture individuelle ?', ['Moins de 10%', 'Environ 50%', 'Plus de 75%', 'Près de 95%'], 'Plus de 75%', 'Au sein des transports routiers, la voiture thermique des particuliers écrase totalement le bilan carbone par rapport aux camions ou bus.']
                ]
            ],
            14 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Qu\'est-ce que l\'énergie grise d\'un équipement numérique ou électronique ?', ['Une énergie provenant du charbon', 'L\'énergie cachée consommée lors de sa fabrication et de son transport', 'L\'énergie consommée quand l\'écran est éteint', 'Une électricité de mauvaise qualité'], 'L\'énergie cachée consommée lors de sa fabrication et de son transport', 'La fabrication d\'un smartphone ou d\'un ordinateur concentre près de 80% de son impact écologique total avant même que vous ne l\'allumiez.'],
                    ['Quelle démarche numérique a le meilleur impact sur la planète ?', ['Garder ses appareils le plus longtemps possible', 'Effacer ses emails tous les jours', 'Regarder des vidéos en basse définition', 'Acheter un modèle neuf chaque année'], 'Garder ses appareils le plus longtemps possible', 'Prolonger la durée de vie de ses écrans et ordinateurs de 2 à 4 ans divise par deux leur empreinte environnementale globale.']
                ]
            ],
            15 => [
                'type' => 'defi',
                'co2' => 80.0,
                'picture_alt' => "Flocage d'un vélo sur une route goudronnée.",
                'data' => ['Fort', 'Transport', 'Trajets courts (< 2 km) à pied ou à vélo', "Engage-toi à réaliser tous tes déplacements de moins de 2 kilomètres en mobilité douce plutôt qu'en voiture individuelle.\n\n Que ce soit pour aller à la boulangerie, emmener les enfants à l'école ou faire de petits achats, privilégie la marche ou le vélo.", 'Pourquoi les premiers kilomètres polluent-ils le plus ?', "Un moteur thermique consomme énormément de carburant et émet bien plus de gaz à effet de serre à froid, lors de ses tout premiers kilomètres.\n\n En supprimant ces micro-trajets polluants, tu réduis drastiquement ton empreinte carbone tout en prenant soin de ta santé physique."]
            ],
            16 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel type de chauffage résidentiel émet le plus de CO2 par kWh ?', ['La pompe à chaleur', 'Le chauffage au fioul', 'Le chauffage au bois certifié', 'Le radiateur électrique standard'], 'Le chauffage au fioul', 'Le fioul est un dérivé direct du pétrole. C\'est l\'une des énergies de chauffage les plus carbonées et polluantes du marché.'],
                    ['Quelle température est recommandée par l\'Ademe dans les pièces à vivre en hiver ?', ['17°C', '19°C', '22°C', '25°C'], '19°C', 'Une température de 19°C est idéale pour les pièces à vivre, tandis que 17°C suffisent largement dans les chambres pour bien dormir.']
                ]
            ],
            17 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quelle quantité d\'eau virtuelle faut-il pour fabriquer un seul jean neuf ?', ['10 litres', '500 litres', '2 000 litres', '7 000 à 10 000 litres'], '7 000 à 10 000 litres', 'De la culture du coton très intensive en eau jusqu\'aux teintures, un jean neuf cache un immense sac à dos écologique liquide.'],
                    ['Quelle est la meilleure alternative pour renouveler sa garde-robe de façon responsable ?', ['Acheter des vêtements en solde', 'Privilégier la seconde main et le troc', 'Commander sur des sites de fast-fashion', 'Acheter uniquement des vêtements synthétiques'], 'Privilégier la seconde main et le troc', 'La seconde main évite l\'extraction de nouvelles ressources et la dépense d\'énergie liée à la fabrication d\'un produit neuf.']
                ]
            ],
            18 => [
                'type' => 'defi',
                'co2' => 3.0,
                'picture_alt' => "Chemin de randonnée traversant une forêt naturelle verdoyante.",
                'data' => ['Faible', 'Biodiversité', 'Visiter une réserve ou un parc naturel', "Prends le temps d'aller te promener dans un espace naturel protégé, comme un Parc Naturel Régional ou un site géré par le Conservatoire d'Espaces Naturels (CEN).\n\n Renseigne-toi sur les sentiers balisés et observe la faune et la flore locales sans laisser de traces.", 'Quel est le lien avec le climat ?', "Soutenir et fréquenter ces espaces permet de valoriser et de financer la préservation de la biodiversité locale et des écosystèmes.\n\n De plus, ces zones sauvages agissent comme de véritables puits de carbone naturels qui s'avèrent indispensables pour réguler le climat mondial."]
            ],
            19 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel mode de chauffage de l\'eau chaude sanitaire est le plus écologique ?', ['Le chauffe-eau électrique à effet joule', 'Le chauffe-eau solaire thermique', 'Le cumulus au gaz classique', 'La chaudière à charbon'], 'Le chauffe-eau solaire thermique', 'Les panneaux solaires thermiques captent directement les rayons du soleil pour chauffer votre eau, utilisant une énergie gratuite et 100% renouvelable.'],
                    ['Quel geste simple évite de gaspiller de l\'eau chaude au robinet ?', ['Laisser couler l\'eau en continu', 'Placer des mousseurs/aérateurs sur les mitigeurs', 'Laver ses mains à l\'eau bouillante', 'Retirer les joints des robinets'], 'Placer des mousseurs/aérateurs sur les mitigeurs', 'Un mousseur injecte de l\'air dans l\'eau, réduisant le débit de sortie de 30% à 50% sans aucune perte de pression ou de confort pour l\'utilisateur.']
                ]
            ],
            20 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel est l\'impact environnemental majeur de la déforestation liée à l\'agriculture industrielle ?', ['Elle produit trop d\'oxygène', 'Elle libère le carbone stocké et détruit les puits de carbone', 'Elle refroidit la planète', 'Elle accélère la pluie'], 'Elle libère le carbone stocké et détruit les puits de carbone', 'Les arbres sont de fantastiques éponges à carbone. Les brûler ou les couper libère d\'énormes volumes de CO2 dans l\'atmosphère.'],
                    ['Quelle culture intensive mondiale cause le plus de déforestation en Amazonie ?', ['La pomme de terre', 'Le soja (principalement pour nourrir le bétail)', 'Le blé bio', 'Le lin'], 'Le soja (principalement pour nourrir le bétail)', 'La forêt amazonienne est massivement rasée pour cultiver du soja hautement protéiné exporté pour nourrir les animaux des élevages intensifs mondiaux.']
                ]
            ],

            // ==================== NIVEAU 3 : WWF ====================
            21 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quelle est la principale cause de l\'effondrement actuel de la biodiversité mondiale ?', ['Le changement climatique seul', 'La perte et la fragmentation des habitats naturels', 'L\'apparition de nouvelles maladies', 'L\'érosion naturelle'], 'La perte et la fragmentation des habitats naturels', 'L\'artificialisation des sols, l\'urbanisation et l\'agriculture intensive détruisent directement les lieux de vie des espèces sauvages.'],
                    ['Selon le WWF, de combien a chuté la population mondiale de vertébrés sauvages depuis 1970 ?', ['D\'environ 10%', 'D\'environ 30%', 'De près de 70%', 'Elle a augmenté'], 'De près de 70%', 'Le rapport Planète Vivante du WWF montre un déclin catastrophique moyen de 69% des populations de poissons, oiseaux, mammifères et amphibiens.']
                ]
            ],
            22 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Pourquoi les abeilles et autres insectes pollinisateurs sont-ils indispensables ?', ['Pour fabriquer uniquement du miel de luxe', 'Ils assurent la reproduction de 80% des plantes à fleurs et cultures', 'Ils n\'ont aucune utilité réelle', 'Pour faire fuir les moustiques'], 'Ils assurent la reproduction de 80% des plantes à fleurs et cultures', 'Sans les pollinisateurs, la majeure partie de notre alimentation mondiale (fruits, légumes, oléagineux) s\'effondrerait immédiatement.'],
                    ['Quelle action simple préserve les pollinisateurs dans un jardin ou un espace vert ?', ['Tondre la pelouse à ras tous les week-ends', 'Laisser une zone d\'herbes folles et fleurie (prairie)', 'Utiliser massivement du désherbant chimique', 'Planter des fleurs en plastique'], 'Laisser une zone d\'herbes folles et fleurie (prairie)', 'Une zone non tondue fournit des refuges indispensables et des ressources de nourriture (pollen/nectar) cruciales pour la faune locale.']
                ]
            ],
            23 => [
                'type' => 'defi',
                'co2' => 55.0,
                'picture_alt' => "Penderie contenant des vêtements, en noir et blanc.",
                'data' => ['Forte', 'Consommation', 'Boycotter la Fast-Fashion pendant 6 mois', "N'achète aucun vêtement neuf issu de l'industrie de la mode classique pendant les six prochains mois.\n\n En cas de besoin réel, tourne-toi vers des alternatives durables comme le don, la réparation de tes propres vêtements, le troc ou les friperies de seconde main.", 'L\'industrie textile pollue-t-elle tant que ça ?', "La mode émet plus de gaz à effet de serre que les vols internationaux et le trafic maritime réunis à cause d'une surproduction mondiale aberrante.\n\n Boycotter le neuf permet de freiner l'extraction de ressources, les teintures chimiques toxiques et les transports à répétition."]
            ],
            24 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel impact majeur a la surpêche sur les écosystèmes marins ?', ['Elle nettoie le fond de l\'eau', 'Elle perturbe toute la chaîne alimentaire marine et vide les océans', 'Elle permet aux poissons de nager plus vite', 'Elle n\'a aucun impact à long terme'], 'Elle perturbe toute la chaîne alimentaire marine et vide les océans', 'La surpêche capture les poissons plus vite qu\'ils ne se reproduisent, menaçant de disparition des prédateurs essentiels comme les requins ou les thons.'],
                    ['Quelle technique de pêche industrielle détruit le plus les fonds marins ?', ['La pêche à la ligne de traîne', 'Le chalutage de fond', 'La récolte manuelle', 'La pêche à la canne'], 'Le chalutage de fond', 'Le chalutage de fond consiste à racler de lourds filets sur le plancher océanique, dévastant les coraux et les habitats sur son passage.']
                ]
            ],
            25 => [
                'type' => 'defi',
                'co2' => 45.0,
                'picture_alt' => "Plan de travail rempli de fruits et légumes frais.",
                'data' => ['Moyen', 'Alimentation', 'Consommer local et de saison', "Achète uniquement des fruits et légumes de saison qui sont cultivés dans ta région pour privilégier au maximum les circuits courts.\n\n Rends-toi sur les marchés locaux ou utilise des abonnements à des paniers de producteurs pour faire tes provisions hebdomadaires.", 'Pourquoi fuir les légumes hors saison ?', "Cultiver une tomate sous serre chauffée en hiver en France produit environ 10 fois plus de gaz à effet de serre qu'une tomate de saison en plein champ."]
            ],
            26 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Qu\'est-ce qu\'une espèce invasive (EEE) ?', ['Une espèce locale très amicale', 'Une espèce introduite qui menace l\'équilibre de la biodiversité locale', 'Un animal qui migre normalement en hiver', 'Un dinosaure disparu'], 'Une espèce introduite qui menace l\'équilibre de la biodiversité locale', 'Les espèces exotiques envahissantes (comme le frelon asiatique) entrent en concurrence directe avec les espèces indigènes et déstabilisent les écosystèmes.'],
                    ['Comment limiter l\'introduction d\'espèces invasives chez soi ?', ['Planter des végétaux exotiques achetés en ligne', 'Privilégier les plantes locales et indigènes pour son jardin', 'Relâcher ses animaux de compagnie dans les bois', 'Ne rien planter du tout'], 'Privilégier les plantes locales et indigènes pour son jardin', 'Les variétés locales s\'intègrent parfaitement à la faune existante (oiseaux, insectes) sans risquer de coloniser et d\'étouffer les milieux naturels.']
                ]
            ],
            27 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel rôle crucial jouent les zones humides (marais, tourbières) pour la planète ?', ['Elles ne servent qu\'à attirer les moustiques', 'Ce sont de formidables filtres à eau et des puits de carbone massifs', 'Elles assèchent les sols de façon dangereuse', 'Elles produisent du pétrole'], 'Ce sont de formidables filtres à eau et des puits de carbone massifs', 'Les zones humides stockent deux fois plus de carbone que toutes les forêts du monde réunies et régulent naturellement les inondations.', 'Qu\'est-ce qui menace le plus les zones humides aujourd\'hui ?', 'L\'assèchement pour l\'extension agricole et l\'urbanisation a causé la perte de 85% des zones humides mondiales depuis l\'ère industrielle.'],
                    ['Qu\'est-ce qui menace le plus les zones humides aujourd\'hui ?', ['Les canards sauvages', 'Leur assèchement pour l\'extension agricole ou l\'urbanisation', 'La pluie naturelle', 'Le manque d\'entretien humain'], 'Leur assèchement pour l\'extension agricole ou l\'urbanisation', 'L\'assèchement artificiel détruit instantanément la capacité de ces sols précieux à filtrer l\'eau et à capturer le carbone.']
                ]
            ],
            28 => [
                'type' => 'defi',
                'co2' => 15.0,
                'picture_alt' => "Personne écrivant sur un tableau transparent.",
                'data' => ['Moyen', 'Sensibilisation', 'Participer à un atelier climat ou un MOOC', "Inscris-toi à un atelier collaboratif comme la Fresque du Climat ou l'atelier 2tonnes, ou suis un MOOC gratuit en ligne sur la transition écologique.\n\n Prends quelques heures pour te former et échanger avec d'autres citoyens engagés.", 'La connaissance a-t-elle un impact CO2 ?', "Oui, car comprendre les ordres de grandeur du climat permet de décupler l'efficacité de tes actions futures en te concentrant sur ce qui compte vraiment."]
            ],
            29 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Quel pourcentage de la surface de la Terre est couvert par les océans ?', ['30%', '50%', '71%', '95%'], '71%', 'Les océans couvrent plus de 70% de notre globe, d\'où le nom célèbre de Planète Bleue.'],
                    ['Quelle est la principale cause de l\'acidification actuelle des océans ?', ['Le rejet de déchets en plastique', 'L\'absorption massive du CO2 atmosphérique par l\'eau', 'La hausse du niveau de la mer', 'Les rejets industriels d\'acide'], 'L\'absorption massive du CO2 atmosphérique par l\'eau', 'L\'océan absorbe environ un quart du CO2 produit par l\'homme. Cela modifie sa chimie, nuisant gravement aux coraux et aux coquillages pour fabriquer leur coquille.']
                ]
            ],
            30 => [
                'type' => 'lesson',
                'picture_alts' => [
                    $default_alt,
                    $default_alt
                ],
                'data' => [
                    ['Qu\'appelle-t-on les services écosystémiques fournis par la nature ?', ['Des factures payées aux parcs naturels', 'Les bénéfices gratuits que l\'humanité tire des écosystèmes (eau potable, pollinisation, air pur)', 'Des applications mobiles pour les animaux', 'Des guides touristiques éco-responsables'], 'Les bénéfices gratuits que l\'humanité tire des écosystèmes (eau potable, pollinisation, air pur)', 'La nature nous fournit gratuitement des services indispensables à notre survie économique et physique, sans lesquels aucune société humaine ne pourrait tenir.'],
                    ['Quelle est la meilleure façon de remercier la nature au quotidien ?', ['Consommer toujours plus d\'énergie verte', 'Adopter la sobriété et réduire notre empreinte carbone globale', 'Ignorer les alertes scientifiques', 'Voyager aux quatre coins du monde en avion'], 'Adopter la sobriété et réduire notre empreinte carbone globale', 'Réduire la pression humaine globale donne du répit aux écosystèmes pour qu\'ils se régénèrent d\'eux-mêmes.']
                ]
            ]
        ];

        // ------------------------------------------------------------------
        // 7. PERSISTANCE DES ÉVÉNEMENTS DANS DOCTRINE
        // ------------------------------------------------------------------
        $eventsMap = [1 => [], 2 => []];
        $levelsList = [1 => $level1, 2 => $level2, 3 => $level3];
        $img_format = ".webp";

        foreach ($rawEventsData as $id => $info) {
            // Déterminer le niveau d'appartenance
            $lvlNum = 1;
            if ($id > 10 && $id <= 20) {
                $lvlNum = 2;
            }
            if ($id > 20) {
                $lvlNum = 3;
            }

            $levelEntity = $levelsList[$lvlNum];
            // Calcul du numéro de séquence local (de 1 à 10 par niveau)
            $sequenceInLevel = (($id - 1) % 10) + 1;

            $event = new Event();
            $event->setLevel($levelEntity);
            $event->setSequenceNumber($sequenceInLevel);

            if ($info['type'] === 'defi') {
                $event->setEventType(EventType::DEFI);
                $event->setCo2Impact($info['co2']);
                $manager->persist($event);

                // Page unique du défi
                $page = new EventPage();
                $page->setEvent($event);
                $page->setSequenceNumber(1);
                $manager->persist($page);

                $d = $info['data']; // impact, thématique, titre, desc, astuce_q, astuce_r

                // Création ordonnée des 8 parties requises
                $parts = [
                    1 => [EventPartType::PICTURE, "uploads/events/defi_" . $id . $img_format, null, null, null, null, null, $info['picture_alt']],
                    2 => [EventPartType::TAG, null, null, null, null, "Impact : " . $d[0], null, null],
                    3 => [EventPartType::TAG, null, null, null, null, "- " . $info['co2'] . " kg CO2", null, null],
                    4 => [EventPartType::TAG, null, null, null, null, $d[1], null, null],
                    5 => [EventPartType::LABEL, null, null, null, null, null, $d[2], null],
                    6 => [EventPartType::DESCRIPTION, null, null, null, $d[3], null, null, null],
                    7 => [EventPartType::SUBTITLE, null, null, null, null, null, $d[4], null],
                    8 => [EventPartType::SUBDESCRIPTION, null, null, null, $d[5], null, null, null]
                ];

                foreach ($parts as $seq => $pData) {
                    $part = new EventPart();
                    $part->setEventPage($page);
                    $part->setSequenceNumber($seq);
                    $part->setEventPartType($pData[0]);
                    $part->setPicturePath($pData[1]);
                    $part->setQuestion($pData[2]);
                    $part->setAnswers($pData[3]);
                    $part->setDescription($pData[4]);
                    $part->setTag($pData[5]);
                    $part->setLabel($pData[6]);
                    $part->setPictureAlt($pData[7]);
                    $manager->persist($part);
                }

            } else {
                // Type LEÇON
                $event->setEventType(EventType::LESSON);
                $event->setCo2Impact(null);
                $manager->persist($event);

                // Génération des 4 pages (2 blocs Question/Explication alternés)
                for ($p = 1; $p <= 4; $p++) {
                    $page = new EventPage();
                    $page->setEvent($event);
                    $page->setSequenceNumber($p);
                    $manager->persist($page);

                    // Sélection de la paire de données (bloc 1 pour pages 1/2, bloc 2 pour pages 3/4)
                    $dataBlock = ($p <= 2) ? $info['data'][0] : $info['data'][1];

                    if ($p === 1 || $p === 3) {
                        // Page Question : 4 parties
                        $p1 = new EventPart();
                        $p1->setEventPage($page);
                        $p1->setSequenceNumber(1);
                        $p1->setEventPartType(EventPartType::PICTURE);
                        $p1->setPicturePath("uploads/events/lesson_" . $id . "_p" . $p . $img_format);
                        $altIndex = ($p === 1) ? 0 : 1;
                        $p1->setPictureAlt($info['picture_alts'][$altIndex]);
                        $manager->persist($p1);

                        $p2 = new EventPart();
                        $p2->setEventPage($page);
                        $p2->setSequenceNumber(2);
                        $p2->setEventPartType(EventPartType::QUESTION);
                        $p2->setQuestion($dataBlock[0]);
                        $manager->persist($p2);

                        $p3 = new EventPart();
                        $p3->setEventPage($page);
                        $p3->setSequenceNumber(3);
                        $p3->setEventPartType(EventPartType::ANSWER);
                        $p3->setAnswers($dataBlock[1]);
                        $p3->setRightAnswer($dataBlock[2]);
                        $manager->persist($p3);
                    } else {
                        // Page Réponse/Explication : 1 partie
                        $p1 = new EventPart();
                        $p1->setEventPage($page);
                        $p1->setSequenceNumber(1);
                        $p1->setEventPartType(EventPartType::DESCRIPTION);
                        $p1->setDescription($dataBlock[3]);
                        $manager->persist($p1);
                    }
                }
            }
            // Enregistrement dans notre map pour l'historique
            $eventsMap[$lvlNum][$sequenceInLevel] = $event;
        }

        // ------------------------------------------------------------------
        // 8. PROGRESSION ET ÉTATS DU PROGRAMME (XUserLevelEvent)
        // ------------------------------------------------------------------

        // Initialisation des compteurs de CO2 pour les utilisateurs avancés
        $emileCo2Impact = 0.0;
        $colineCo2Impact = 0.0;

        // --- Elia Chelet : Niveau 1, Cours 1 (En cours) ---
        $progElia = new XUserLevelEvent();
        $progElia->setTargetUser($elia);
        $progElia->setLevel($level1);
        $progElia->setEvent($eventsMap[1][1]);
        $progElia->setEventStatus(EventStatus::ACTIVE); // Correspond au statut 'En cours'
        $manager->persist($progElia);
        $elia->setCo2Impact(0.0);

        // --- Emile Teneflen : Niveau 2, Cours 10 ---
        // Étape A : Niveau 1 entièrement validé (1 à 10)
        for ($i = 1; $i <= 10; $i++) {
            $event = $eventsMap[1][$i];
            $status = $this->getRandomStatusForPastEvent($event);

            $prog = new XUserLevelEvent();
            $prog->setTargetUser($emile);
            $prog->setLevel($level1);
            $prog->setEvent($event);
            $prog->setEventStatus($status);
            $manager->persist($prog);

            // Si le défi historique est accepté, on cumule son impact CO2
            if ($status === EventStatus::FINISHED && $event->getCo2Impact() !== null) {
                $emileCo2Impact += $event->getCo2Impact();
            }
        }
        // Étape B : Niveau 2 validé de l'événement 1 à 9
        for ($i = 1; $i <= 9; $i++) {
            $event = $eventsMap[2][$i];
            $status = $this->getRandomStatusForPastEvent($event);

            $prog = new XUserLevelEvent();
            $prog->setTargetUser($emile);
            $prog->setLevel($level2);
            $prog->setEvent($event);
            $prog->setEventStatus($status);
            $manager->persist($prog);

            if ($status === EventStatus::FINISHED && $event->getCo2Impact() !== null) {
                $emileCo2Impact += $event->getCo2Impact();
            }
        }
        // Étape C : Niveau 2, Événement 10 marqué actif (En cours)
        $progEmileCurrent = new XUserLevelEvent();
        $progEmileCurrent->setTargetUser($emile);
        $progEmileCurrent->setLevel($level2);
        $progEmileCurrent->setEvent($eventsMap[2][10]);
        $progEmileCurrent->setEventStatus(EventStatus::ACTIVE);
        $manager->persist($progEmileCurrent);

        // Mise à jour de l'impact CO2 total calculé pour Émile
        $emile->setCo2Impact($emileCo2Impact);

        // --- Coline Arisarj : Niveau 2, Cours 1 ---
        // Étape A : Niveau 1 validé de 1 à 10
        for ($i = 1; $i <= 10; $i++) {
            $event = $eventsMap[1][$i];
            $status = $this->getRandomStatusForPastEvent($event);

            $prog = new XUserLevelEvent();
            $prog->setTargetUser($coline);
            $prog->setLevel($level1);
            $prog->setEvent($event);
            $prog->setEventStatus($status);
            $manager->persist($prog);

            if ($status === EventStatus::FINISHED && $event->getCo2Impact() !== null) {
                $colineCo2Impact += $event->getCo2Impact();
            }
        }
        // Étape B : Niveau 2, Événement 1 marqué actif (En cours)
        $progColineCurrent = new XUserLevelEvent();
        $progColineCurrent->setTargetUser($coline);
        $progColineCurrent->setLevel($level2);
        $progColineCurrent->setEvent($eventsMap[2][1]);
        $progColineCurrent->setEventStatus(EventStatus::ACTIVE);
        $manager->persist($progColineCurrent);

        // Mise à jour de l'impact CO2 total calculé pour Coline
        $coline->setCo2Impact($colineCo2Impact);

        // Sauvegarde définitive globale
        $manager->flush();
    }

    /**
     * Détermine un statut réaliste pour les anciens événements de l'historique
     */
    private function getRandomStatusForPastEvent(Event $event): EventStatus
    {
        if ($event->getEventType() === EventType::LESSON) {
            return EventStatus::FINISHED;
        }

        // Répartition aléatoire pour les défis historiques :
        try {
            $dice = random_int(1, 10);
        } catch (RandomException) {
            $dice = 1;
        }

        if ($dice <= 4) {
            return EventStatus::FINISHED; // Défi accompli avec succès !
        } elseif ($dice <= 7) {
            return EventStatus::ACCEPTED; // Défi juste accepté (relevé) mais pas encore validé
        } else {
            return EventStatus::REFUSED;  // Défi refusé
        }
    }
}

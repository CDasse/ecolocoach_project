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
        // 1. MESSAGES D'ENCOURAGEMENT (10)
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
        // 2. ASTUCES (3)
        // ------------------------------------------------------------------
        $tipAlim = new Tip();
        $tipAlim->setContent("Manger des fruits et légumes de saison permet de réduire l'impact écologique du transport et de profiter de meilleurs bienfaits nutritionnels.");
        $manager->persist($tipAlim);

        $tip2Tonnes = new Tip();
        $tip2Tonnes->setContent("L'objectif mondial est d'atteindre une empreinte de 2 tonnes de CO2 maximum par personne et par an d'ici 2050 pour limiter le réchauffement climatique.");
        $manager->persist($tip2Tonnes);

        $tipBio = new Tip();
        $tipBio->setContent("Protéger la biodiversité locale commence dans son assiette et son jardin : réduire les pesticides et préserver les espaces naturels sauvages.");
        $manager->persist($tipBio);

        // ------------------------------------------------------------------
        // 3. PARCOURS (1)
        // ------------------------------------------------------------------
        $path = new Path();
        $path->setName("Éco-Pionnier : Les 4 Piliers");
        $path->setNbOfLevels(3);
        $path->setDescription("Un parcours généraliste structuré autour des 4 grands piliers de la transition écologique : le transport, l'alimentation, l'énergie et la consommation responsable.");
        $manager->persist($path);

        // ------------------------------------------------------------------
        // 4. NIVEAUX (3)
        // ------------------------------------------------------------------
        $level1 = new Level();
        $level1->setName("Ma petite planète");
        $level1->setTip($tipAlim);
        $level1->setPath($path);
        $level1->setSequenceNumber(1);
        $manager->persist($level1);

        $level2 = new Level();
        $level2->setName("2tonnes");
        $level2->setTip($tip2Tonnes);
        $level2->setPath($path);
        $level2->setSequenceNumber(2);
        $manager->persist($level2);

        $level3 = new Level();
        $level3->setName("WWF");
        $level3->setTip($tipBio);
        $level3->setPath($path);
        $level3->setSequenceNumber(3);
        $manager->persist($level3);

        // ------------------------------------------------------------------
        // 5. UTILISATEURS (3)
        // ------------------------------------------------------------------
        $elia = new User();
        $elia->setUsername("Elia Chelet");
        $elia->setEmail("elia@gmail.fr");
        $elia->setLogo("uploads/logos/elia.png");
        $elia->setPassword($this->passwordHasher->hashPassword($elia, "elia"));
        $elia->setPath($path);
        $manager->persist($elia);

        $emile = new User();
        $emile->setUsername("Emile Teneflen");
        $emile->setEmail("emile@gmail.fr");
        $emile->setLogo("uploads/logos/emile.png");
        $emile->setPassword($this->passwordHasher->hashPassword($emile, "emile"));
        $emile->setPath($path);
        $emile->setCo2Impact(95.2);
        $manager->persist($emile);

        $coline = new User();
        $coline->setUsername("Coline Arisarj");
        $coline->setEmail("coline@gmail.fr");
        $coline->setLogo("uploads/logos/coline.png");
        $coline->setPassword($this->passwordHasher->hashPassword($coline, "coline"));
        $coline->setPath($path);
        $coline->setCo2Impact(24.7);
        $manager->persist($coline);


        // ------------------------------------------------------------------
        // 6. ÉVÉNEMENTS (30)
        // ------------------------------------------------------------------
        // Structure de chaque élément :
        // Type LEÇON : ['type' => 'lesson', 'data' => [ [Q1, Choices1, Right1, Expl1], [Q2, Choices2, Right2, Expl2] ]]
        // Type DÉFI  : ['type' => 'defi', 'co2' => X, 'data' => [impact, thématique, titre, desc, astuce_q, astuce_r]]

        $rawEventsData = [
            // ==================== NIVEAU 1 : MA PETITE PLANÈTE ====================
            1 => [
                'type' => 'lesson',
                'data' => [
                    ['Quel type de transport émet le plus de CO2 par personne au kilomètre ?', ['L\'avion', 'Le train électrique', 'La voiture thermique seule', 'Le bus de ville'], 'L\'avion', 'L\'avion reste le moyen de transport le plus émetteur à cause de la combustion de kérosène en haute altitude.'],
                    ['Quelle alternative quotidienne est la plus efficace sur moins de 5km ?', ['Le vélo ou la marche', 'Le covoiturage', 'Le scooter thermique', 'La trottinette électrique'], 'Le vélo ou la marche', "Le vélo et la marche n\'émettent aucun gaz à effet de serre à l'usage et améliorent en plus votre santé physique !"]
                ]
            ],
            2 => [
                'type' => 'lesson',
                'data' => [
                    ['Quel légume consommé en hiver en France a l\'empreinte carbone la plus élevée ?', ['Le poireau local', 'La tomate sous serre chauffée', 'La carotte de saison', 'Le chou-fleur'], 'La tomate sous serre chauffée', 'Une tomate produite en hiver sous serre chauffée peut émettre jusqu\'à 10 fois plus de CO2 qu\'une tomate produite en été en plein champ.'],
                    ['Pourquoi privilégier les circuits courts pour l\'alimentation ?', ['Pour payer plus cher', 'Pour réduire le transport et les emballages', 'Pour manger moins de vitamines', 'Uniquement pour le style'], 'Pour réduire le transport et les emballages', 'Les circuits courts limitent les intermédiaires logistiques, réduisant ainsi les émissions de transport routier et le suremballage protecteur.']
                ]
            ],
            3 => [
        'type' => 'defi',
        'co2' => 4.5,
        'data' => ['Faible', 'Alimentation', 'Une journée 100% végétarienne', 'Aujourd\'hui, remplacez la viande et le poisson par des légumineuses (lentilles, pois chiches) et des légumes de saison.', 'Quel est l\'impact collectif de la viande ?', 'L\'élevage est responsable de près de 15% des émissions mondiales de gaz à effet de serre. Supprimer la viande un jour par semaine réduit drastiquement votre impact.']
    ],
            4 => [
        'type' => 'lesson',
        'data' => [
            ['En France, quelle est la principale source de consommation d\'énergie dans un logement ?', ['Les appareils électroménagers', 'L\'éclairage', 'Le chauffage', 'L\'eau chaude sanitaire'], 'Le chauffage', 'Le chauffage représente en moyenne 60% de la consommation énergétique d\'un foyer français.'],
            ['Quelle action simple permet de réduire instantanément sa facture de chauffage ?', ['Ouvrir les fenêtres toute la journée', 'Baisser le thermostat de 1°C', 'Laisser la lumière allumée', 'Chauffer les pièces vides à 23°C'], 'Baisser le thermostat de 1°C', 'Baisser le chauffage de seulement 1°C permet d\'économiser environ 7% d\'énergie sur l\'année.']
        ]
    ],
            5 => [
        'type' => 'defi',
        'co2' => 12.0,
        'data' => ['Moyen', 'Transport', 'Lâcher la voiture pour les trajets de moins de 3km', 'Réalisez tous vos petits déplacements de la journée à pied, en vélo ou en transports en commun.', 'Pourquoi cibler les petits trajets ?', 'En ville, 40% des trajets effectués en voiture font moins de 3 km. Ce sont pourtant les kilomètres les plus polluants car le moteur n\'a pas le temps de chauffer.']
    ],
            6 => [
        'type' => 'lesson',
        'data' => [
            ['Qu\'est-ce que l\'éco-score d\'un produit de grande consommation ?', ['Un indicateur de prix', 'Une note sur l\'impact environnemental global', 'Un label de qualité gustative', 'Une mesure du taux de sucre'], 'Une note sur l\'impact environnemental global', 'L\'éco-score prend en compte tout le cycle de vie du produit (production, emballage, transport) pour évaluer son impact sur la planète.'],
            ['Quel mode de livraison a le meilleur bilan écologique pour un colis ?', ['La livraison express à domicile', 'Le retrait en point relais (à pied)', 'La livraison par drone', 'Le drive voiture'], 'Le retrait en point relais (à pied)', 'Le point relais massifie les flux de livraison. Si vous allez le chercher à pied ou à vélo, vous supprimez l\'impact du dernier kilomètre.']
        ]
    ],
            7 => [
        'type' => 'lesson',
        'data' => [
            ['Combien de fois peut-on recycler le verre à l\'infini ?', ['2 fois', '10 fois', 'À l\'infini', 'Ce n\'est pas recyclable'], 'À l\'infini', 'Le verre se recycle à 100% et à l\'infini sans perte de qualité, ce qui économise des matières premières et de l\'énergie de fusion.'],
            ['Quel déchet met le plus de temps à se décomposer dans la nature ?', ['Un trognon de pomme', 'Un sac plastique', 'Une bouteille en verre', 'Un journal'], 'Une bouteille en verre', 'Il faut environ 4000 ans pour qu\'une bouteille en verre se décompose complètement à l\'état sauvage, contre 450 ans pour un sac plastique.']
        ]
    ],
            8 => [
        'type' => 'defi',
        'co2' => 8.2,
        'data' => ['Faible', 'Énergie', 'Chasse aux veilles électroniques', 'Faites le tour de chez vous ce soir et débranchez ou éteignez via multiprise tous les appareils en veille (TV, box internet, consoles, PC).', 'Quel est l\'impact invisible des veilles ?', 'Les appareils en veille représentent environ 10% de la facture d\'électricité d\'un foyer français sans apporter aucune valeur d\'usage.']
    ],
            9 => [
        'type' => 'lesson',
        'data' => [
            ['Quel appareil ménager consomme généralement le plus d\'eau chaude ?', ['Le lave-vaisselle', 'Le lave-linge', 'La douche / baignoire', 'La bouilloire'], 'La douche / baignoire', 'L\'eau chaude sanitaire des douches et des bains représente la majeure partie de l\'utilisation d\'eau chaude d\'une maison.'],
            ['Quelle est la durée idéale d\'une éco-douche ?', ['5 minutes', '20 minutes', '45 minutes', 'Moins d\'une minute'], '5 minutes', 'Une douche de 5 minutes consomme environ 40 à 60 litres d\'eau, contre près de 150 litres pour un bain ou une douche prolongée.']
        ]
    ],
            10 => [
        'type' => 'lesson',
        'data' => [
            ['Quel est l\'avantage principal du compostage des biodéchets ?', ['Ça prend de la place', 'Réduire le volume de la poubelle et créer du terreau', 'Attirer des animaux dangereux', 'Faire joli dans la cuisine'], 'Réduire le volume de la poubelle et créer du terreau', 'Le compostage permet d\'alléger nos poubelles d\'un tiers de leur poids et d\'éviter l\'incinération inutile d\'eau.'],
            ['Que peut-on mettre en toute sécurité dans un compost classique ?', ['Des épluchures de légumes', 'Du plastique biodégradable', 'Des restes de viande grasse', 'Des piles usagées'], 'Des épluchures de légumes', 'Les matières végétales crues comme les épluchures, le marc de café et les cartons bruts non imprimés font le meilleur compost.']
        ]
    ],

            // ==================== NIVEAU 2 : 2TONNES ====================
            11 => [
        'type' => 'lesson',
        'data' => [
            ['Quelle est l\'empreinte carbone moyenne actuelle d\'un citoyen français par an ?', ['2 tonnes', '5 tonnes', '9 tonnes', '25 tonnes'], '9 tonnes', 'L\'empreinte moyenne en France tourne autour de 9 tonnes d\'équivalent CO2 par an si l\'on inclut les produits importés.'],
            ['Pour respecter l\'Accord de Paris, à combien doit-on réduire cette empreinte d\'ici 2050 ?', ['À 5 tonnes', 'À 2 tonnes', 'À 0 tonne', 'À 7 tonnes'], 'À 2 tonnes', 'L\'objectif universel des accords sur le climat est de converger vers 2 tonnes maximum par personne pour stabiliser le réchauffement sous +1,5°C.']
        ]
    ],
            12 => [
        'type' => 'defi',
        'co2' => 35.0,
        'data' => ['Fort', 'Consommation', 'Semaine sans aucun achat de plastique', 'N\'achetez aucun aliment, boisson ou objet emballé dans du plastique à usage unique pendant 7 jours.', 'Pourquoi le plastique est-il un enjeu climatique ?', '99% du plastique mondial est fabriqué à partir de combustibles fossiles (pétrole). Sa production et son incinération libèrent d\'immenses quantités de carbone.']
            ],
            13 => [
                'type' => 'lesson',
                'data' => [
                    ['Quel secteur d\'activité génère le plus d\'émissions de gaz à effet de serre en France ?', ['Les transports', 'Le numérique', 'L\'agriculture', 'L\'industrie textile'], 'Les transports', 'Le secteur des transports est le premier émetteur en France, représentant environ 30% des émissions nationales, majoritairement dues aux voitures individuelles.'],
                    ['Dans les transports, quelle part de CO2 provient de la voiture individuelle ?', ['Moins de 10%', 'Environ 50%', 'Plus de 75%', 'Près de 95%'], 'Plus de 75%', 'Au sein des transports routiers, la voiture thermique des particuliers écrase totalement le bilan carbone par rapport aux camions ou bus.']
                ]
            ],
            14 => [
        'type' => 'lesson',
        'data' => [
            ['Qu\'est-ce que l\'énergie grise d\'un équipement numérique ou électronique ?', ['Une énergie provenant du charbon', 'L\'énergie cachée consommée lors de sa fabrication et de son transport', 'L\'énergie consommée quand l\'écran est éteint', 'Une électricité de mauvaise qualité'], 'L\'énergie cachée consommée lors de sa fabrication et de son transport', 'La fabrication d\'un smartphone ou d\'un ordinateur concentre près de 80% de son impact écologique total avant même que vous ne l\'allumiez.'],
            ['Quelle démarche numérique a le meilleur impact sur la planète ?', ['Garder ses appareils le plus longtemps possible', 'Effacer ses emails tous les jours', 'Regarder des vidéos en basse définition', 'Acheter un modèle neuf chaque année'], 'Garder ses appareils le plus longtemps possible', 'Prolonger la durée de vie de ses écrans et ordinateurs de 2 à 4 ans divise par deux leur empreinte environnementale globale.']
        ]
    ],
            15 => [
        'type' => 'defi',
        'co2' => 15.0,
        'data' => ['Moyen', 'Énergie', 'Laver son linge à 30°C maximum', 'Faites toutes vos machines de la semaine en mode Éco ou à 30°C grand maximum, et zappez totalement le sèche-linge.', 'Quelle est la consommation d\'une machine à laver ?', 'Près de 80% de l\'électricité consommée par un cycle de lavage sert uniquement à chauffer l\'eau. Laver à basse température préserve vos vêtements et l\'énergie.']
            ],
            16 => [
                'type' => 'lesson',
                'data' => [
                    ['Quel type de chauffage résidentiel émet le plus de CO2 par kWh ?', ['La pompe à chaleur', 'Le chauffage au fioul', 'Le chauffage au bois certifié', 'Le radiateur électrique standard'], 'Le chauffage au fioul', 'Le fioul est un dérivé direct du pétrole. C\'est l\'une des énergies de chauffage les plus carbonées et polluantes du marché.'],
                    ['Quelle température est recommandée par l\'Ademe dans les pièces à vivre en hiver ?', ['17°C', '19°C', '22°C', '25°C'], '19°C', 'Une température de 19°C est idéale pour les pièces à vivre, tandis que 17°C suffisent largement dans les chambres pour bien dormir.']
                ]
            ],
            17 => [
        'type' => 'lesson',
        'data' => [
            ['Quelle quantité d\'eau virtuelle faut-il pour fabriquer un seul jean neuf ?', ['10 litres', '500 litres', '2 000 litres', '7 000 à 10 000 litres'], '7 000 à 10 000 litres', 'De la culture du coton très intensive en eau jusqu\'aux teintures, un jean neuf cache un immense sac à dos écologique liquide.'],
            ['Quelle est la meilleure alternative pour renouveler sa garde-robe de façon responsable ?', ['Acheter des vêtements en solde', 'Privilégier la seconde main et le troc', 'Commander sur des sites de fast-fashion', 'Acheter uniquement des vêtements synthétiques'], 'Privilégier la seconde main et le troc', 'La seconde main évite l\'extraction de nouvelles ressources et la dépense d\'énergie liée à la fabrication d\'un produit neuf.']
        ]
    ],
            18 => [
        'type' => 'defi',
        'co2' => 20.5,
        'data' => ['Moyen', 'Transport', 'Pratiquer le covoiturage ou l\'éco-conduite', 'Pour vos déplacements obligatoires en voiture, embarquez un passager ou réduisez votre vitesse de 10km/h sur autoroute.', 'Quel gain avec l\'éco-conduite ?', 'Rouler à 110 km/h au lieu de 130 km/h réduit votre consommation de carburant de 20% tout en limitant le stress au volant.']
    ],
            19 => [
        'type' => 'lesson',
        'data' => [
            ['Quel mode de chauffage de l\'eau chaude sanitaire est le plus écologique ?', ['Le chauffe-eau électrique à effet joule', 'Le chauffe-eau solaire thermique', 'Le cumulus au gaz classique', 'La chaudière à charbon'], 'Le chauffe-eau solaire thermique', 'Les panneaux solaires thermiques captent directement les rayons du soleil pour chauffer votre eau, utilisant une énergie gratuite et 100% renouvelable.'],
            ['Quel geste simple évite de gaspiller de l\'eau chaude au robinet ?', ['Laisser couler l\'eau en continu', 'Placer des mousseurs/aérateurs sur les mitigeurs', 'Laver ses mains à l\'eau bouillante', 'Retirer les joints des robinets'], 'Placer des mousseurs/aérateurs sur les mitigeurs', 'Un mousseur injecte de l\'air dans l\'eau, réduisant le débit de sortie de 30% à 50% sans aucune perte de pression ou de confort pour l\'utilisateur.']
        ]
    ],
            20 => [
        'type' => 'lesson',
        'data' => [
            ['Quel est l\'impact environnemental majeur de la déforestation liée à l\'agriculture industrielle ?', ['Elle produit trop d\'oxygène', 'Elle libère le carbone stocké et détruit les puits de carbone', 'Elle refroidit la planète', 'Elle accélère la pluie'], 'Elle libère le carbone stocké et détruit les puits de carbone', 'Les arbres sont de fantastiques éponges à carbone. Les brûler ou les couper libère d\'énormes volumes de CO2 dans l\'atmosphère.'],
            ['Quelle culture intensive mondiale cause le plus de déforestation en Amazonie ?', ['La pomme de terre', 'Le soja (principalement pour nourrir le bétail)', 'Le blé bio', 'Le lin'], 'Le soja (principalement pour nourrir le bétail)', 'La forêt amazonienne est massivement rasée pour cultiver du soja hautement protéiné exporté pour nourrir les animaux des élevages intensifs mondiaux.']
        ]
    ],

            // ==================== NIVEAU 3 : WWF ====================
            21 => [
        'type' => 'lesson',
        'data' => [
            ['Quelle est la principale cause de l\'effondrement actuel de la biodiversité mondiale ?', ['Le changement climatique seul', 'La perte et la fragmentation des habitats naturels', 'L\'apparition de nouvelles maladies', 'L\'érosion naturelle'], 'La perte et la fragmentation des habitats naturels', 'L\'artificialisation des sols, l\'urbanisation et l\'agriculture intensive détruisent directement les lieux de vie des espèces sauvages.'],
            ['Selon le WWF, de combien a chuté la population mondiale de vertébrés sauvages depuis 1970 ?', ['D\'environ 10%', 'D\'environ 30%', 'De près de 70%', 'Elle a augmenté'], 'De près de 70%', 'Le rapport Planète Vivante du WWF montre un déclin catastrophique moyen de 69% des populations de poissons, oiseaux, mammifères et amphibiens.']
        ]
    ],
            22 => [
        'type' => 'lesson',
        'data' => [
            ['Pourquoi les abeilles et autres insectes pollinisateurs sont-ils indispensables ?', ['Pour fabriquer uniquement du miel de luxe', 'Ils assurent la reproduction de 80% des plantes à fleurs et cultures', 'Ils n\'ont aucune utilité réelle', 'Pour faire fuir les moustiques'], 'Ils assurent la reproduction de 80% des plantes à fleurs et cultures', 'Sans les pollinisateurs, la majeure partie de notre alimentation mondiale (fruits, légumes, oléagineux) s\'effondrerait immédiatement.'],
            ['Quelle action simple préserve les pollinisateurs dans un jardin ou un espace vert ?', ['Tondre la pelouse à ras tous les week-ends', 'Laisser une zone d\'herbes folles et fleurie (prairie)', 'Utiliser massivement du désherbant chimique', 'Planter des fleurs en plastique'], 'Laisser une zone d\'herbes folles et fleurie (prairie)', 'Une zone non tondue fournit des refuges indispensables et des ressources de nourriture (pollen/nectar) cruciales pour la faune locale.']
        ]
    ],
            23 => [
        'type' => 'defi',
        'co2' => 5.0,
        'data' => ['Faible', 'Consommation', 'Acheter un produit labellisé éco-responsable (FSC ou MSC)', 'Aujourd\'hui, achetez un produit en bois/papier labellisé FSC (gestion durable des forêts) ou du poisson labellisé MSC (pêche durable).', 'Que signifient ces labels ?', 'Ils garantissent le respect de critères environnementaux stricts pour ne pas surexploiter les forêts et les océans de notre globe.']
    ],
            24 => [
        'type' => 'lesson',
        'data' => [
            ['Quel impact majeur a la surpêche sur les écosystèmes marins ?', ['Elle nettoie le fond de l\'eau', 'Elle perturbe toute la chaîne alimentaire marine et vide les océans', 'Elle permet aux poissons de nager plus vite', 'Elle n\'a aucun impact à long terme'], 'Elle perturbe toute la chaîne alimentaire marine et vide les océans', 'La surpêche capture les poissons plus vite qu\'ils ne se reproduisent, menaçant de disparition des prédateurs essentiels comme les requins ou les thons.'],
            ['Quelle technique de pêche industrielle détruit le plus les fonds marins ?', ['La pêche à la ligne de traîne', 'Le chalutage de fond', 'La récolte manuelle', 'La pêche à la canne'], 'Le chalutage de fond', 'Le chalutage de fond consiste à racler de lourds filets sur le plancher océanique, dévastant les coraux et les habitats sur son passage.']
        ]
    ],
            25 => [
        'type' => 'defi',
        'co2' => 50.0,
        'data' => ['Fort', 'Alimentation', 'Zéro déchet alimentaire pendant une semaine', 'Planifiez vos repas à l\'avance, achetez les bonnes quantités et cuisinez absolument tous vos restes pour ne rien jeter.', 'Quel est le coût écologique du gaspillage ?', 'Si le gaspillage alimentaire mondial était un pays, il serait le troisième plus grand émetteur de gaz à effet de serre au monde derrière la Chine et les USA.']
    ],
            26 => [
        'type' => 'lesson',
        'data' => [
            ['Qu\'est-ce qu\'une espèce invasive (EEE) ?', ['Une espèce locale très amicale', 'Une espèce introduite qui menace l\'équilibre de la biodiversité locale', 'Un animal qui migre normalement en hiver', 'Un dinosaure disparu'], 'Une espèce introduite qui menace l\'équilibre de la biodiversité locale', 'Les espèces exotiques envahissantes (comme le frelon asiatique) entrent en concurrence directe avec les espèces indigènes et déstabilisent les écosystèmes.'],
            ['Comment limiter l\'introduction d\'espèces invasives chez soi ?', ['Planter des végétaux exotiques achetés en ligne', 'Privilégier les plantes locales et indigènes pour son jardin', 'Relâcher ses animaux de compagnie dans les bois', 'Ne rien planter du tout'], 'Privilégier les plantes locales et indigènes pour son jardin', 'Les variétés locales s\'intègrent parfaitement à la faune existante (oiseaux, insectes) sans risquer de coloniser et d\'étouffer les milieux naturels.']
        ]
    ],
            27 => [
        'type' => 'lesson',
        'data' => [
            ['Quel rôle crucial jouent les zones humides (marais, tourbières) pour la planète ?', ['Elles ne servent qu\'à attirer les moustiques', 'Ce sont de formidables filtres à eau et des puits de carbone massifs', 'Elles assèchent les sols de façon dangereuse', 'Elles produisent du pétrole'], 'Ce sont de formidables filtres à eau et des puits de carbone massifs', 'Les zones humides stockent deux fois plus de carbone que toutes les forêts du monde réunies et régulent naturellement les inondations.', 'Qu\'est-ce qui menace le plus les zones humides aujourd\'hui ?', 'L\'assèchement pour l\'extension agricole et l\'urbanisation a causé la perte de 85% des zones humides mondiales depuis l\'ère industrielle.'],
            ['Qu\'est-ce qui menace le plus les zones humides aujourd\'hui ?', ['Les canards sauvages', 'Leur assèchement pour l\'extension agricole ou l\'urbanisation', 'La pluie naturelle', 'Le manque d\'entretien humain'], 'Leur assèchement pour l\'extension agricole ou l\'urbanisation', 'L\'assèchement artificiel détruit instantanément la capacité de ces sols précieux à filtrer l\'eau et à capturer le carbone.']
        ]
    ],
            28 => [
        'type' => 'defi',
        'co2' => 15.2,
        'data' => ['Moyen', 'Consommation', 'Boycott des produits contenant de l\'huile de palme', 'Vérifiez les étiquettes de vos produits (gâteaux, cosmétiques) et évitez soigneusement l\'huile de palme non certifiée.', 'Pourquoi boycotter l\'huile de palme ?', 'Sa culture ultra-intensive est la première cause de déforestation en Asie du Sud-Est, détruisant l\'habitat d\'espèces menacées comme les orangs-outans.']
    ],
            29 => [
        'type' => 'lesson',
        'data' => [
            ['Quel pourcentage de la surface de la Terre est couvert par les océans ?', ['30%', '50%', '71%', '95%'], '71%', 'Les océans couvrent plus de 70% de notre globe, d\'où le nom célèbre de Planète Bleue.'],
            ['Quelle est la principale cause de l\'acidification actuelle des océans ?', ['Le rejet de déchets en plastique', 'L\'absorption massive du CO2 atmosphérique par l\'eau', 'La hausse du niveau de la mer', 'Les rejets industriels d\'acide'], 'L\'absorption massive du CO2 atmosphérique par l\'eau', 'L\'océan absorbe environ un quart du CO2 produit par l\'homme. Cela modifie sa chimie, nuisant gravement aux coraux et aux coquillages pour fabriquer leur coquille.']
                ]
            ],
            30 => [
        'type' => 'lesson',
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

        foreach ($rawEventsData as $id => $info) {
            // Déterminer le niveau d'appartenance
            $lvlNum = 1;
            if ($id > 10 && $id <= 20) { $lvlNum = 2; }
            if ($id > 20) { $lvlNum = 3; }

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
                    1 => [EventPartType::PICTURE, "uploads/events/defi_" . $id . ".png", null, null, null, null, null],
                    2 => [EventPartType::TAG, null, null, null, null, "Impact : " . $d[0], null],
                    3 => [EventPartType::TAG, null, null, null, null, $info['co2'] . " kg CO2", null],
                    4 => [EventPartType::TAG, null, null, null, null, $d[1], null],
                    5 => [EventPartType::LABEL, null, null, null, null, null, $d[2]],
                    6 => [EventPartType::DESCRIPTION, null, null, null, $d[3], null, null],
                    7 => [EventPartType::LABEL, null, null, null, null, null, $d[4]],
                    8 => [EventPartType::DESCRIPTION, null, null, null, $d[5], null, null]
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
                        $p1->setPicturePath("uploads/events/lesson_" . $id . "_p" . $p . ".png");
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
                        // Page Réponse/Explication : 2 parties
                        $p1 = new EventPart();
                        $p1->setEventPage($page);
                        $p1->setSequenceNumber(1);
                        $p1->setEventPartType(EventPartType::PICTURE);
                        // Même visuel que la question associée pour la continuité
                        $p1->setPicturePath("uploads/events/lesson_" . $id . "_p" . ($p - 1) . ".png");
                        $manager->persist($p1);

                        $p2 = new EventPart();
                        $p2->setEventPage($page);
                        $p2->setSequenceNumber(2);
                        $p2->setEventPartType(EventPartType::DESCRIPTION);
                        $p2->setDescription($dataBlock[3]);
                        $manager->persist($p2);
                    }
                }
            }
            // Enregistrement dans notre map pour l'historique
            $eventsMap[$lvlNum][$sequenceInLevel] = $event;
        }

        // ------------------------------------------------------------------
        // 8. PROGRESSION ET ÉTATS DU PROGRAMME (XUserLevelEvent)
        // ------------------------------------------------------------------

        // --- Elia Chelet : Niveau 1, Cours 1 (En cours) ---
        $progElia = new XUserLevelEvent();
        $progElia->setTargetUser($elia);
        $progElia->setLevel($level1);
        $progElia->setEvent($eventsMap[1][1]);
        $progElia->setEventStatus(EventStatus::ACTIVE); // Correspond au statut 'En cours'
        $manager->persist($progElia);

        // --- Emile Teneflen : Niveau 2, Cours 10 ---
        // Étape A : Niveau 1 entièrement validé (1 à 10)
        for ($i = 1; $i <= 10; $i++) {
            $prog = new XUserLevelEvent();
            $prog->setTargetUser($emile);
            $prog->setLevel($level1);
            $prog->setEvent($eventsMap[1][$i]);
            $prog->setEventStatus(EventStatus::FINISHED); // Correspond à 'Terminé'
            $manager->persist($prog);
        }
        // Étape B : Niveau 2 validé de l'événement 1 à 9
        for ($i = 1; $i <= 9; $i++) {
            $prog = new XUserLevelEvent();
            $prog->setTargetUser($emile);
            $prog->setLevel($level2);
            $prog->setEvent($eventsMap[2][$i]);
            $prog->setEventStatus(EventStatus::FINISHED);
            $manager->persist($prog);
        }
        // Étape C : Niveau 2, Événement 10 marqué actif (En cours)
        $progEmileCurrent = new XUserLevelEvent();
        $progEmileCurrent->setTargetUser($emile);
        $progEmileCurrent->setLevel($level2);
        $progEmileCurrent->setEvent($eventsMap[2][10]);
        $progEmileCurrent->setEventStatus(EventStatus::ACTIVE);
        $manager->persist($progEmileCurrent);

        // --- Coline Arisarj : Niveau 2, Cours 1 ---
        // Étape A : Niveau 1 validé de 1 à 10
        for ($i = 1; $i <= 10; $i++) {
            $prog = new XUserLevelEvent();
            $prog->setTargetUser($coline);
            $prog->setLevel($level1);
            $prog->setEvent($eventsMap[1][$i]);
            $prog->setEventStatus(EventStatus::FINISHED);
            $manager->persist($prog);
        }
        // Étape B : Niveau 2, Événement 1 marqué actif (En cours)
        $progColineCurrent = new XUserLevelEvent();
        $progColineCurrent->setTargetUser($coline);
        $progColineCurrent->setLevel($level2);
        $progColineCurrent->setEvent($eventsMap[2][1]);
        $progColineCurrent->setEventStatus(EventStatus::ACTIVE);
        $manager->persist($progColineCurrent);

        // Sauvegarde définitive globale
        $manager->flush();
    }
}

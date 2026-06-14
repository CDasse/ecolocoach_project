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
        $deuxTonnes = "2 tonnes";

        $lesson1 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Nuage de CO2 libéré par le tuyau d'une usine.",
                "Empreinte d'une paire de chaussure dans le sable."
            ],
            'data' => [
                ['Quelle est l\'empreinte carbone moyenne d\'un français par an ?', [$deuxTonnes, '5 tonnes', '9 tonnes', '15 tonnes'], '9 tonnes', "L'empreinte carbone mesure la quantité de gaz à effet de serre (GES) émis par nos activités sur une année.\n\n L'empreinte moyenne en France est de 9 tonnes de CO2 par an.\n\n Cette moyenne est calculée en prenant en compte notamment l'alimentation, les transports, le logement, les services publics et le numérique."],
                ['Pour respecter l\'Accord de Paris, à combien doit-on réduire cette empreinte d\'ici 2050 ?', ['0 tonne', $deuxTonnes, '5 tonnes', '7 tonnes'], $deuxTonnes, "Afin de limiter la hausse du réchauffement climatique en dessous de 2 degrés, l'objectif des accords sur le climat est de converger vers 2 tonnes d'émission de CO2 maximum, par an, par personne.\n\n Rendez-vous au prochain défi pour calculer ton empreinte carbone et identifier les actions les plus efficaces pour la réduire."]
            ]
        ];

        $lesson2 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Sticker représentant le logo de recyclage avec l'inscription 'Please recycle'",
                "Amas de cannettes en aluminium écrasées."
            ],
            'data' => [
                ['Quel matériau de notre quotidien se recycle à 100% et à l\'infini ?', ['Plastique', 'Verre', 'Carton', 'Textile'], 'Verre', "Le verre possède la formidable propriété de se recycler entièrement sans jamais perdre sa pureté ni sa solidité.\n\n Chaque bouteille triée redevient une bouteille neuve identique, économisant ainsi de l'énergie."],
                ['En combien de temps une canette recyclée revient-elle en magasin ?', ['2 mois', '6 mois', '1 an', '2 ans'], '2 mois', "Selon Citeo, une canette jetée dans le bac de tri est fondue, purifiée et retransformée en un temps record d'environ 60 jours.\n\n L'aluminium est une matière précieuse qui se recycle indéfiniment."]
            ]
        ];

        $lesson3 = [
            'type' => 'lesson',
            'picture_alts' => [
                'Pile de quatre jeans pliés.',
                'Étendoir de chaussettes multicolors et à motifs.'
            ],
            'data' => [
                ['Combien de litres d\'eau sont nécessaires pour fabriquer un jean ?', ['500', '2 000', '7 000', '20 000'], '7 000', "L'ADEME évalue à 7 000 litres l'eau requise pour concevoir un jean, de la culture du coton jusqu'à la teinture finale.\n\n Préférer des vêtements durables permet de préserver de précieuses réserves d'eau douce."],
                ['Quelle matière textile naturelle est majoritairement cultivée en France ?', ['Lin', 'Coton', 'Polyester', 'Soie'], 'Lin', "La France est le premier producteur mondial de lin, une plante très robuste qui grandit principalement grâce à l'eau de pluie et sans pesticides.\n\n Choisir des vêtements en lin est un excellent moyen de soutenir une industrie textile locale et très respectueuse de l'environnement."]
            ]
        ];

        $lesson4 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Une abeille butinant une jolie fleur sauvage jaune.",
                "Une haie laissant devinée derrière elle un petit coin de jardin herbeux."
            ],
            'data' => [
                ['Quelle part des cultures alimentaires mondiales dépend directement des pollinisateurs ?', ['25%', '50%', '75%', '95%'], '75%', "L'ONU estime que près de 75% des plantes cultivées pour notre alimentation ont besoin des insectes pour fructifier.\n\n En protégeant les abeilles, nous sécurisons l'accès à une nourriture saine et variée."],
                ['Quelle pratique est la plus efficace pour aider la biodiversité dans son jardin ?', ['La tonte', 'L\'engrais', 'Le gazon', 'La friche'], 'La friche', "Laisser un coin de jardin en friche permet aux plantes locales de pousser et offre un abri vital aux insectes.\n\n C'est l'éco-geste le plus simple, le plus économique et le plus reposant pour la nature."]
            ]
        ];

        $lesson5 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Coucher de soleil sur un champ.",
                "Néons lumineux sur un toit d'immeuble représentant l'électricité."
            ],
            'data' => [
                ['Quelle énergie renouvelable utilise directement la chaleur interne de la Terre ?', ['Éolien', 'Solaire', 'Géothermie', 'Hydraulique'], 'Géothermie', "La géothermie puise les calories naturellement présentes sous nos pieds pour chauffer des logements ou produire de l'électricité.\n\n C'est une énergie propre, locale et totalement indépendante de la météo."],
                ['Quelle source fournit la plus grande partie de l\'électricité renouvelable en France ?', ['Vent', 'Soleil', 'Eau', 'Bois'], 'Eau', "L'énergie hydraulique des barrages est la première source d'électricité verte du pays.\n\n Elle possède l'immense avantage d'être activable en quelques minutes pour répondre aux pics de consommation."]
            ]
        ];

        $lesson6 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Téléphone portable moderne tenu en main.",
                "Téléphone ancien rouge dont le combiné est détaché du récepteur."
            ],
            'data' => [
                ['D\'où provient la majeure partie de l\'impact écologique du numérique ?', ['E-mails', 'Streaming', 'Fabrication', 'SMS'], 'Fabrication', "Près de 80% de l'empreinte environnementale d'un smartphone provient de l'extraction des métaux rares nécessaires à sa construction.\n\n Prolonger la durée de vie de tes appareils est le meilleur moyen d'agir."],
                ['Quelle connexion consomme le moins d\'énergie sur mobile ?', ['Le Wi-Fi', 'La 3G', 'La 4G', 'La 5G'], 'Le Wi-Fi', "Selon l'ADEME, se connecter au réseau Wi-Fi consomme jusqu'à trois fois moins d'énergie que d'utiliser la 4G ou la 5G.\n\n Privilégier ce mode de connexion à la maison ou au travail permet de soulager considérablement les infrastructures de télécommunication."]
            ]
        ];

        $lesson7 = [
            'type' => 'lesson',
            'picture_alts' => [
                "Fumée blanche formant le mot CO2 dans un ciel bleu.",
                "Tourbière parcouru par un chemin sur pilotis en bois."
            ],
            'data' => [
                ['Quel écosystème terrestre stocke le plus de carbone par hectare au monde ?', ['Forêt', 'Tourbière', 'Prairie', 'Mangrove'], 'Tourbière', "Bien qu'elles ne couvrent que 3% des terres émergées, les tourbières mondiales stockent deux fois plus de carbone que toutes les forêts réunies.\n\n Ce sont de formidables alliées climatiques à préserver absolument."],
                ['Combien de tonnes de carbone peut stocker un seul hectare de tourbière saine ?', ['50 T', '150 T', '300 T', '600 T'], '600 T', "Un hectare de tourbière saine stocke en moyenne entre 500 et 700 tonnes de carbone accumulé patiemment sur des millénaires.\n\n Les restaurer permet de piéger durablement ce carbone dans le sol."]
            ]
        ];

        $rawEventsData = [
            // ==================== NIVEAU 1 : MA PETITE PLANÈTE ====================
            1 => $lesson1,
            2 => $lesson2,
            3 => [
                'type' => 'defi',
                'co2' => 5.0,
                'picture_alt' => "Calculatrice posée à côté d'un carnet ouvert et d'un stylo dans l'herbe.",
                'data' => ['Fort', 'Sensibilisation', 'Calculer son empreinte carbone', "Rends-toi sur nosgestesclimat.fr ou 2tonnes.org et réponds au questionnaire pour mesurer ton empreinte carbone annuelle.\n\n Le calculateur carbone permet de comprendre quels sont nos usages qui contribuent le plus au changement climatique et de saisir les actions qui auraient le plus d'impact pour le réduire.", 'Pourquoi mesurer economise-t-il 5 kg de CO2 ?', "Le calcul en lui même n'économise rien mais les études (comme celles de l'ADEME) montrent que cette prise de conscience génère une baisse statistique d'environ 1 à 2 % des émissions annuelles d'un individu."]
            ],
            4 => $lesson3,
            5 => [
                'type' => 'defi',
                'co2' => 24.0,
                'picture_alt' => "Chargeur de téléphone débranché de son adaptateur sur un sol en bois.",
                'data' => ['Faible', 'Energie', 'Débrancher les chargeurs et les veilles', "Fais le tour de ton logement et débranche tous les chargeurs inutilisés ainsi que les appareils électroniques laissés en veille.\n\n Tu peux également utiliser des multiprises à interrupteur pour tout couper d'un seul geste le moment venu.", 'Quel est le vrai coût des appareils en veille ?', "Les veilles consomment inutilement entre 300 et 500 kWh par an dans un foyer français, ce qui pèse lourd sur la facture sans aucun bénéfice d'usage."]
            ],
            6 => $lesson4,
            7 => $lesson5,
            8 => [
                'type' => 'defi',
                'co2' => 25.0,
                'picture_alt' => "Quatre poubelles de couleur (jaune, bleue, rouge, vert) alignées sur un trottoir.",
                'data' => ['Moyen', 'Déchets', 'Trier rigoureusement ses déchets', "Installe des poubelles séparées chez toi et respecte les consignes de tri de ta commune pour le verre, le carton et les emballages.\n\n Si tu as un doute, tu peux vérifier les logos sur les emballages.", 'Pourquoi le tri est-il si important pour le climat ?', "Le recyclage évite l'incinération polluante et l'extraction de matières premières vierges, ce qui économise de grandes quantités d'énergie industrielle.\n\n De plus, trier correctement permet de réduire la quantité de déchets enfouis qui génèrent du méthane en se décomposant."]
            ],
            9 => $lesson6,
            10 => $lesson7,

            // ==================== NIVEAU 2 : 2TONNES ====================
            11 => $lesson1,
            12 => [
                'type' => 'defi',
                'co2' => 14.0,
                'picture_alt' => "Belle assiette composée exclusivement de légumes, céréales et légumineuses.",
                'data' => ['Moyen', 'Alimentation', 'Un jour végétarien par semaine (pendant 1 mois)', "Pendant 4 semaines, remplace la viande et le poisson d'une journée entière par des protéines végétales savoureuses.\n\n Tu peux cuisiner par exemple des lentilles, des pois chiches ou des haricots associés à des céréales pour obtenir un repas complet et équilibré.", 'Quel est l\'impact de l\'élevage ?', "Un jour sans viande économise environ 3 à 4 kg de CO2.\n\n L'élevage bovin intensif est très émetteur de méthane et nécessite d'immenses surfaces agricoles, ce qui favorise malheureusement la déforestation."]
            ],
            13 => $lesson2,
            14 => $lesson3,
            15 => [
                'type' => 'defi',
                'co2' => 80.0,
                'picture_alt' => "Flocage d'un vélo sur une route goudronnée.",
                'data' => ['Fort', 'Transport', 'Trajets courts (< 2 km) à pied ou à vélo', "Engage-toi à réaliser tous tes déplacements de moins de 2 kilomètres en mobilité douce plutôt qu'en voiture individuelle.\n\n Que ce soit pour aller à la boulangerie, emmener les enfants à l'école ou faire de petits achats, privilégie la marche ou le vélo.", 'Pourquoi les premiers kilomètres polluent-ils le plus ?', "Un moteur thermique consomme énormément de carburant et émet bien plus de gaz à effet de serre à froid, lors de ses tout premiers kilomètres.\n\n En supprimant ces micro-trajets polluants, tu réduis drastiquement ton empreinte carbone tout en prenant soin de ta santé physique."]
            ],
            16 => $lesson4,
            17 => $lesson5,
            18 => [
                'type' => 'defi',
                'co2' => 3.0,
                'picture_alt' => "Chemin de randonnée traversant une forêt naturelle verdoyante.",
                'data' => ['Faible', 'Biodiversité', 'Visiter une réserve ou un parc naturel', "Prends le temps d'aller te promener dans un espace naturel protégé, comme un Parc Naturel Régional ou un site géré par le Conservatoire d'Espaces Naturels (CEN).\n\n Renseigne-toi sur les sentiers balisés et observe la faune et la flore locales sans laisser de traces.", 'Quel est le lien avec le climat ?', "Soutenir et fréquenter ces espaces permet de valoriser et de financer la préservation de la biodiversité locale et des écosystèmes.\n\n De plus, ces zones sauvages agissent comme de véritables puits de carbone naturels qui s'avèrent indispensables pour réguler le climat mondial."]
            ],
            19 => $lesson6,
            20 => $lesson7,

            // ==================== NIVEAU 3 : WWF ====================
            21 => $lesson1,
            22 => $lesson2,
            23 => [
                'type' => 'defi',
                'co2' => 55.0,
                'picture_alt' => "Penderie contenant des vêtements, en noir et blanc.",
                'data' => ['Forte', 'Consommation', 'Boycotter la Fast-Fashion pendant 6 mois', "N'achète aucun vêtement neuf issu de l'industrie de la mode classique pendant les six prochains mois.\n\n En cas de besoin réel, tourne-toi vers des alternatives durables comme le don, la réparation de tes propres vêtements, le troc ou les friperies de seconde main.", 'L\'industrie textile pollue-t-elle tant que ça ?', "La mode émet plus de gaz à effet de serre que les vols internationaux et le trafic maritime réunis à cause d'une surproduction mondiale aberrante.\n\n Boycotter le neuf permet de freiner l'extraction de ressources, les teintures chimiques toxiques et les transports à répétition."]
            ],
            24 => $lesson3,
            25 => [
                'type' => 'defi',
                'co2' => 45.0,
                'picture_alt' => "Plan de travail rempli de fruits et légumes frais.",
                'data' => ['Moyen', 'Alimentation', 'Consommer local et de saison', "Achète uniquement des fruits et légumes de saison qui sont cultivés dans ta région pour privilégier au maximum les circuits courts.\n\n Rends-toi sur les marchés locaux ou utilise des abonnements à des paniers de producteurs pour faire tes provisions hebdomadaires.", 'Pourquoi fuir les légumes hors saison ?', "Cultiver une tomate sous serre chauffée en hiver en France produit environ 10 fois plus de gaz à effet de serre qu'une tomate de saison en plein champ."]
            ],
            26 => $lesson4,
            27 => $lesson5,
            28 => [
                'type' => 'defi',
                'co2' => 15.0,
                'picture_alt' => "Personne écrivant sur un tableau transparent.",
                'data' => ['Moyen', 'Sensibilisation', 'Participer à un atelier climat ou un MOOC', "Inscris-toi à un atelier collaboratif comme la Fresque du Climat ou l'atelier 2tonnes, ou suis un MOOC gratuit en ligne sur la transition écologique.\n\n Prends quelques heures pour te former et échanger avec d'autres citoyens engagés.", 'La connaissance a-t-elle un impact CO2 ?', "Oui, car comprendre les ordres de grandeur du climat permet de décupler l'efficacité de tes actions futures en te concentrant sur ce qui compte vraiment."]
            ],
            29 => $lesson6,
            30 => $lesson7,
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

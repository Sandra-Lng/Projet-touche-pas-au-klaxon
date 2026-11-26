-- Jeu d'essai. Mot de passe de tous les comptes : "password"
USE touche_pas_au_klaxon;

INSERT INTO agence (id, nom) VALUES
 (1, 'Paris'),
 (2, 'Lyon'),
 (3, 'Marseille'),
 (4, 'Toulouse'),
 (5, 'Nice'),
 (6, 'Nantes'),
 (7, 'Strasbourg'),
 (8, 'Montpellier'),
 (9, 'Bordeaux'),
 (10, 'Lille'),
 (11, 'Rennes'),
 (12, 'Reims');

INSERT INTO utilisateur (id, nom, prenom, telephone, email, mot_de_passe, role) VALUES
 (1, 'Admin', 'Admin', '0600000001', 'admin@touchepasauklaxon.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
 (2, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (3, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (4, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (5, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (6, 'Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (7, 'Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (8, 'Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (9, 'Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (10, 'Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (11, 'Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (12, 'Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (13, 'Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (14, 'Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (15, 'Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (16, 'Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (17, 'Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (18, 'Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (19, 'Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (20, 'Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe'),
 (21, 'Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employe');

-- Dates relatives à l'exécution du script pour toujours avoir des trajets à venir
INSERT INTO trajet (agence_depart_id, agence_arrivee_id, date_depart, date_arrivee, places_total, places_dispo, auteur_id) VALUES
 (1, 2, NOW() + INTERVAL 26 HOUR,  NOW() + INTERVAL 30 HOUR, 4, 3, 2),
 (2, 1, NOW() + INTERVAL 50 HOUR,  NOW() + INTERVAL 54 HOUR, 3, 1, 3),
 (3, 4, NOW() + INTERVAL 30 HOUR,  NOW() + INTERVAL 34 HOUR, 4, 2, 4),
 (5, 3, NOW() + INTERVAL 75 HOUR,  NOW() + INTERVAL 77 HOUR, 3, 3, 5),
 (6, 1, NOW() + INTERVAL 100 HOUR, NOW() + INTERVAL 104 HOUR, 4, 4, 6),
 (1, 6, NOW() + INTERVAL 120 HOUR, NOW() + INTERVAL 124 HOUR, 4, 0, 2), -- complet : non affiché
 (4, 3, NOW() - INTERVAL 48 HOUR,  NOW() - INTERVAL 44 HOUR, 4, 2, 3), -- passé : non affiché
 (7, 1, NOW() + INTERVAL 150 HOUR, NOW() + INTERVAL 155 HOUR, 3, 2, 7),
 (2, 5, NOW() + INTERVAL 170 HOUR, NOW() + INTERVAL 176 HOUR, 4, 3, 4);

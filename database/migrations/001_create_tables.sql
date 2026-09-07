CREATE TABLE salles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    batiment VARCHAR(100) NOT NULL,
    capacite INT NOT NULL,
    type VARCHAR(30) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE TABLE reservations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    salle_id BIGINT UNSIGNED NOT NULL,

    responsable VARCHAR(120) NOT NULL,

    email VARCHAR(255) NOT NULL,

    motif VARCHAR(255) NOT NULL,

    date_debut DATETIME NOT NULL,

    date_fin DATETIME NOT NULL,

    statut VARCHAR(20) NOT NULL DEFAULT 'confirmée',

    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    CONSTRAINT fk_reservations_salle
        FOREIGN KEY (salle_id)
        REFERENCES salles(id)
);
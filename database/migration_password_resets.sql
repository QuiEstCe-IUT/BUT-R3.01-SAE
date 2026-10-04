--
-- Table pour stocker les tokens de réinitialisation de mot de passe
-- À exécuter sur la BD PostgreSQL (phppgadmin ou psql)
--

CREATE TABLE public.password_resets (
    token VARCHAR(64) PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);

-- Droits
ALTER TABLE public.password_resets OWNER TO mathiasm;
GRANT ALL ON TABLE public.password_resets TO mathiasm_bd_web_admin;

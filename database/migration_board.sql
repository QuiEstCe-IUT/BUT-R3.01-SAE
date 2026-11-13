--
-- Table pour stocker le plateau et les parties du jeu "Qui est-ce ?"
-- À exécuter sur la base de données PostgreSQL (phpPgAdmin ou psql)
--

CREATE TABLE IF NOT EXISTS public.board (
    gid SERIAL PRIMARY KEY,
    p1 INTEGER NOT NULL,
    p2 INTEGER,
    game_status VARCHAR(50) NOT NULL DEFAULT 'lobby',
    p_active SMALLINT DEFAULT 1,
    data TEXT,
    p_winner INTEGER,

    -- Clés étrangères liant aux comptes utilisateurs (table users)
    CONSTRAINT fk_board_p1 FOREIGN KEY (p1) REFERENCES public.users(user_id) ON DELETE CASCADE,
    CONSTRAINT fk_board_p2 FOREIGN KEY (p2) REFERENCES public.users(user_id) ON DELETE SET NULL,
    CONSTRAINT fk_board_p_winner FOREIGN KEY (p_winner) REFERENCES public.users(user_id) ON DELETE SET NULL,

    -- Contraintes de cohérence
    CONSTRAINT chk_board_p_active CHECK (p_active IS NULL OR p_active IN (1, 2)),
    CONSTRAINT chk_board_game_status CHECK (game_status IN ('lobby', 'in_progress', 'finished', 'cancelled'))
);

-- Propriétaire et droits d'accès pour AlwaysData
ALTER TABLE public.board OWNER TO mathiasm;
GRANT ALL ON TABLE public.board TO mathiasm_bd_web_admin;
GRANT ALL ON SEQUENCE public.board_gid_seq TO mathiasm_bd_web_admin;

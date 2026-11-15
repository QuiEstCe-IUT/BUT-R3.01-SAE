--
-- Script pour renommer la table 'games' (ou 'game') en 'board'
-- À exécuter sur la base de données PostgreSQL (phpPgAdmin ou psql)
--

-- 1. Renommer la table en 'board'
-- Décommente la ligne correspondant au nom que tu avais utilisé :
ALTER TABLE IF EXISTS public.games RENAME TO board;
ALTER TABLE IF EXISTS public.game RENAME TO board;

-- 2. Renommer la séquence liée à la clé primaire 'gid' (optionnel mais propre)
ALTER SEQUENCE IF EXISTS public.games_gid_seq RENAME TO board_gid_seq;
ALTER SEQUENCE IF EXISTS public.game_gid_seq RENAME TO board_gid_seq;

-- 3. Assurer les droits d'accès pour l'utilisateur de l'application web
ALTER TABLE public.board OWNER TO mathiasm;
GRANT ALL ON TABLE public.board TO mathiasm_bd_web_admin;
GRANT ALL ON SEQUENCE public.board_gid_seq TO mathiasm_bd_web_admin;

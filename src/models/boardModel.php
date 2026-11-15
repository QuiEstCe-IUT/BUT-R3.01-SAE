<?php

namespace src\models;

use core\Model;

/**
 * Modèle pour la gestion du plateau et des parties du jeu "Qui est-ce ?".
 */
class BoardModel extends Model
{
    public const STATUS_LOBBY = 'lobby';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Nom de la table en base de données.
     */
    protected static string $table = 'board';

    /**
     * Identifiant unique de la partie / du plateau.
     */
    private ?int $gid = null;

    /**
     * Clé étrangère de l'utilisateur Joueur 1 (créateur).
     */
    private ?int $p1 = null;

    /**
     * Clé étrangère de l'utilisateur Joueur 2 (adversaire).
     */
    private ?int $p2 = null;

    /**
     * Statut actuel de la partie ('lobby', 'in_progress', 'finished', etc.).
     */
    private string $gameStatus = self::STATUS_LOBBY;

    /**
     * Joueur actif devant réaliser une action (1 pour p1, 2 pour p2).
     */
    private ?int $pActive = 1;

    /**
     * Données textuelles (dernière question/réponse d'un joueur).
     */
    private ?string $data = null;

    /**
     * Identifiant du joueur vainqueur (user_id du compte de p1 ou p2).
     */
    private ?int $pWinner = null;

    /**
     * Constructeur de BoardModel.
     *
     * @param int|null $p1 Id du compte du Joueur 1
     * @param int|null $p2 Id du compte du Joueur 2
     * @param string $gameStatus Statut de la partie
     * @param int|null $pActive Joueur qui a la main (1 ou 2)
     * @param string|null $data Dernière question ou réponse
     * @param int|null $pWinner Id du compte du vainqueur
     * @param int|null $gid Id de la partie (null pour une nouvelle partie)
     */
    public function __construct(
        ?int $p1 = null,
        ?int $p2 = null,
        string $gameStatus = self::STATUS_LOBBY,
        ?int $pActive = 1,
        ?string $data = null,
        ?int $pWinner = null,
        ?int $gid = null
    ) {
        $this->gid = $gid;
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->gameStatus = $gameStatus;
        $this->pActive = $pActive;
        $this->data = $data;
        $this->pWinner = $pWinner;
    }

    // ==========================================
    // GETTERS & SETTERS
    // ==========================================

    /**
     * Retourne l'identifiant de la partie.
     * Note : Aucun setter car gid est auto-généré par la base de données.
     */
    public function getGid(): ?int
    {
        return $this->gid;
    }

    public function getP1(): ?int
    {
        return $this->p1;
    }

    public function setP1(int $p1): self
    {
        $this->p1 = $p1;
        return $this;
    }

    public function getP2(): ?int
    {
        return $this->p2;
    }

    public function setP2(?int $p2): self
    {
        $this->p2 = $p2;
        return $this;
    }

    public function getGameStatus(): string
    {
        return $this->gameStatus;
    }

    public function setGameStatus(string $gameStatus): self
    {
        $this->gameStatus = $gameStatus;
        return $this;
    }

    public function getPActive(): ?int
    {
        return $this->pActive;
    }

    public function setPActive(?int $pActive): self
    {
        if ($pActive !== null && !in_array($pActive, [1, 2], true)) {
            throw new \InvalidArgumentException('p_active doit valoir 1 ou 2.');
        }
        $this->pActive = $pActive;
        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getPWinner(): ?int
    {
        return $this->pWinner;
    }

    public function setPWinner(?int $pWinner): self
    {
        $this->pWinner = $pWinner;
        return $this;
    }

    // ==========================================
    // MÉTHODES DE PERSISTANCE (BDD)
    // ==========================================

    /**
     * Crée une nouvelle partie en base de données.
     *
     * @param int $p1 Identifiant de l'utilisateur qui crée la partie (Joueur 1)
     * @param int|null $p2 Identifiant du Joueur 2 (null par défaut)
     * @param string $gameStatus Statut initial ('lobby' par défaut)
     * @param int|null $pActive Joueur qui a la main (1 ou 2, 1 par défaut)
     * @param string|null $data Données textuelles initiales (null par défaut)
     * @param int|null $pWinner Id du vainqueur si déjà connu (null par défaut)
     * @return int|false L'identifiant (gid) de la partie créée, ou false en cas d'échec
     */
    public static function create(
        int $p1,
        ?int $p2 = null,
        string $gameStatus = self::STATUS_LOBBY,
        ?int $pActive = 1,
        ?string $data = null,
        ?int $pWinner = null
    ): int|false {
        $sql = "INSERT INTO " . self::$table . " (p1, p2, game_status, p_active, data, p_winner)
                VALUES (:p1, :p2, :game_status, :p_active, :data, :p_winner)
                RETURNING gid";

        $stmt = self::getPdo()->prepare($sql);
        $success = $stmt->execute([
            ':p1'          => $p1,
            ':p2'          => $p2,
            ':game_status' => $gameStatus,
            ':p_active'    => $pActive,
            ':data'        => $data,
            ':p_winner'    => $pWinner,
        ]);

        if ($success) {
            $insertedId = $stmt->fetchColumn();
            return $insertedId !== false ? (int) $insertedId : false;
        }

        return false;
    }

    /**
     * Crée une nouvelle partie en base de données (alias explicite pour BoardModel).
     *
     * @param int $p1 Identifiant de l'utilisateur créateur
     * @param int|null $p2 Identifiant de l'adversaire
     * @param string $gameStatus Statut de la partie
     * @param int|null $pActive Joueur actif
     * @param string|null $data Données textuelles
     * @param int|null $pWinner Vainqueur
     * @return int|false
     */
    public static function createBoard(
        int $p1,
        ?int $p2 = null,
        string $gameStatus = self::STATUS_LOBBY,
        ?int $pActive = 1,
        ?string $data = null,
        ?int $pWinner = null
    ): int|false {
        return self::create($p1, $p2, $gameStatus, $pActive, $data, $pWinner);
    }

    /**
     * Alias de create() pour compatibilité ascendante.
     *
     * @param int $p1 Identifiant de l'utilisateur créateur
     * @param int|null $p2 Identifiant de l'adversaire
     * @param string $gameStatus Statut de la partie
     * @param int|null $pActive Joueur actif
     * @param string|null $data Données textuelles
     * @param int|null $pWinner Vainqueur
     * @return int|false
     */
    public static function createGame(
        int $p1,
        ?int $p2 = null,
        string $gameStatus = self::STATUS_LOBBY,
        ?int $pActive = 1,
        ?string $data = null,
        ?int $pWinner = null
    ): int|false {
        return self::create($p1, $p2, $gameStatus, $pActive, $data, $pWinner);
    }

    /**
     * Enregistre l'instance courante en base de données.
     * Si la partie n'a pas encore de gid, elle est insérée. Sinon, elle est mise à jour.
     *
     * @return bool True en cas de succès, False sinon
     */
    public function save(): bool
    {
        if ($this->gid === null) {
            if ($this->p1 === null) {
                return false;
            }

            $gid = self::create(
                $this->p1,
                $this->p2,
                $this->gameStatus,
                $this->pActive,
                $this->data,
                $this->pWinner
            );

            if ($gid !== false) {
                $this->gid = $gid;
                return true;
            }

            return false;
        }

        return $this->update();
    }

    /**
     * Met à jour la partie courante en base de données avec les attributs de l'instance.
     *
     * @return bool True si la mise à jour a réussi
     */
    public function update(): bool
    {
        if ($this->gid === null) {
            return false;
        }

        $sql = "UPDATE " . self::$table . "
                SET p1 = :p1,
                    p2 = :p2,
                    game_status = :game_status,
                    p_active = :p_active,
                    data = :data,
                    p_winner = :p_winner
                WHERE gid = :gid";

        $stmt = self::getPdo()->prepare($sql);
        return $stmt->execute([
            ':p1'          => $this->p1,
            ':p2'          => $this->p2,
            ':game_status' => $this->gameStatus,
            ':p_active'    => $this->pActive,
            ':data'        => $this->data,
            ':p_winner'    => $this->pWinner,
            ':gid'         => $this->gid,
        ]);
    }

    /**
     * Recherche une partie par son gid et retourne une instance BoardModel.
     *
     * @param int $gid L'identifiant de la partie
     * @return BoardModel|null L'objet BoardModel correspondant ou null si introuvable
     */
    public static function findById(int $gid): ?self
    {
        $data = self::getBoardById($gid);
        if (!$data) {
            return null;
        }

        return self::hydrate($data);
    }

    /**
     * Récupère une partie par son gid sous forme de tableau associatif.
     *
     * @param int $gid L'identifiant de la partie
     * @return array<string, mixed>|false Tableau associatif de la ligne ou false
     */
    public static function getBoardById(int $gid): array|false
    {
        $sql = "SELECT gid, p1, p2, game_status, p_active, data, p_winner
                FROM " . self::$table . "
                WHERE gid = :gid";

        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':gid' => $gid]);
        return $stmt->fetch();
    }

    /**
     * Alias de getBoardById().
     *
     * @param int $gid L'identifiant de la partie
     * @return array<string, mixed>|false
     */
    public static function getGameById(int $gid): array|false
    {
        return self::getBoardById($gid);
    }

    /**
     * Récupère la liste des parties en attente dans le lobby (où p2 est vide).
     *
     * @return array<int, array<string, mixed>> Liste des salons disponibles
     */
    public static function getLobbyBoards(): array
    {
        $sql = "SELECT b.gid, b.p1, b.p2, b.game_status, b.p_active, b.data, u.login AS p1_login
                FROM " . self::$table . " b
                LEFT JOIN users u ON b.p1 = u.user_id
                WHERE b.game_status = :status AND b.p2 IS NULL
                ORDER BY b.gid DESC";

        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':status' => self::STATUS_LOBBY]);
        return $stmt->fetchAll();
    }

    /**
     * Alias de getLobbyBoards().
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getLobbyGames(): array
    {
        return self::getLobbyBoards();
    }

    /**
     * Permet à un utilisateur (Joueur 2) de rejoindre une partie en attente.
     * Passe automatiquement le statut à 'in_progress'.
     *
     * @param int $gid L'identifiant de la partie
     * @param int $p2 L'identifiant de l'utilisateur qui rejoint
     * @return bool True si la partie a été rejointe avec succès
     */
    public static function joinBoard(int $gid, int $p2): bool
    {
        $sql = "UPDATE " . self::$table . "
                SET p2 = :p2,
                    game_status = :in_progress,
                    p_active = 1
                WHERE gid = :gid AND p2 IS NULL AND game_status = :lobby";

        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([
            ':p2'          => $p2,
            ':in_progress' => self::STATUS_IN_PROGRESS,
            ':gid'         => $gid,
            ':lobby'       => self::STATUS_LOBBY,
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Alias de joinBoard().
     *
     * @param int $gid L'identifiant de la partie
     * @param int $p2 L'identifiant de l'utilisateur qui rejoint
     * @return bool
     */
    public static function joinGame(int $gid, int $p2): bool
    {
        return self::joinBoard($gid, $p2);
    }

    /**
     * Crée une instance de BoardModel à partir d'un tableau associatif de données SQL.
     *
     * @param array<string, mixed> $row Données issues de la BDD
     * @return self
     */
    public static function hydrate(array $row): self
    {
        return new self(
            isset($row['p1']) ? (int) $row['p1'] : null,
            isset($row['p2']) ? (int) $row['p2'] : null,
            (string) ($row['game_status'] ?? self::STATUS_LOBBY),
            isset($row['p_active']) ? (int) $row['p_active'] : null,
            isset($row['data']) ? (string) $row['data'] : null,
            isset($row['p_winner']) ? (int) $row['p_winner'] : null,
            isset($row['gid']) ? (int) $row['gid'] : null
        );
    }
}

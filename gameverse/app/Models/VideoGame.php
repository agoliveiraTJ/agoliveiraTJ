<?php

class VideoGame extends Model
{
    public function all(string $sort = 'nome', string $direction = 'asc'): array
    {
        $allowedSorts = [
            'id' => 'id',
            'nome' => 'nome',
            'fabricante' => 'fabricante',
            'ano_lancamento' => 'ano_lancamento',
            'midia' => 'midia',
        ];

        $column = $allowedSorts[$sort] ?? $allowedSorts['nome'];
        $direction = strtolower($direction) === 'desc' ? 'DESC' : 'ASC';
        $secondarySort = $column === 'id' ? '' : ', id ASC';

        $stmt = $this->db->query("SELECT * FROM video_games ORDER BY {$column} {$direction}{$secondarySort}");
        return $stmt->fetchAll();
    }

    public function latest(int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM video_games ORDER BY created_at DESC, id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM video_games')->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM video_games WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $videoGame = $stmt->fetch();

        return $videoGame ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO video_games (nome, fabricante, geracao, ano_lancamento, midia, descricao, imagem)
             VALUES (:nome, :fabricante, :geracao, :ano_lancamento, :midia, :descricao, :imagem)'
        );
        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE video_games
             SET nome = :nome, fabricante = :fabricante, geracao = :geracao, ano_lancamento = :ano_lancamento,
                 midia = :midia, descricao = :descricao, imagem = :imagem, updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM jogo_video_game WHERE video_game_id = :id');
        $stmt->execute(['id' => $id]);

        $stmt = $this->db->prepare('DELETE FROM video_games WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

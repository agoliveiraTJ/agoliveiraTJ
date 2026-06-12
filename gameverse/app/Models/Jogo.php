<?php

class Jogo extends Model
{
    public function all(string $sort = 'titulo', string $direction = 'asc'): array
    {
        $allowedSorts = [
            'titulo' => 'j.titulo',
            'genero' => 'j.genero',
            'ano_lancamento' => 'j.ano_lancamento',
            'plataformas' => 'plataformas',
        ];

        $column = $allowedSorts[$sort] ?? $allowedSorts['titulo'];
        $direction = strtolower($direction) === 'desc' ? 'DESC' : 'ASC';
        $secondarySort = $column === 'j.titulo' ? '' : ', j.titulo ASC';

        $stmt = $this->db->query(
            'SELECT j.*,
                    (
                        SELECT GROUP_CONCAT(v.nome ORDER BY v.nome SEPARATOR ", ")
                        FROM jogo_video_game jvg
                        INNER JOIN video_games v ON v.id = jvg.video_game_id
                        WHERE jvg.jogo_id = j.id
                    ) AS plataformas
             FROM jogos j
             ORDER BY ' . $column . ' ' . $direction . $secondarySort
        );

        return $stmt->fetchAll();
    }

    public function latest(int $limit = 4): array
    {
        $stmt = $this->db->prepare('SELECT * FROM jogos ORDER BY created_at DESC, id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)$this->db->query('SELECT COUNT(*) FROM jogos')->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM jogos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $jogo = $stmt->fetch();

        return $jogo ?: null;
    }

    public function findWithPlatforms(int $id): ?array
    {
        $jogo = $this->find($id);

        if (!$jogo) {
            return null;
        }

        $jogo['plataformas'] = $this->platforms($id);

        return $jogo;
    }

    public function byVideoGame(int $videoGameId): array
    {
        $stmt = $this->db->prepare(
            'SELECT j.*
             FROM jogos j
             INNER JOIN jogo_video_game jvg ON jvg.jogo_id = j.id
             WHERE jvg.video_game_id = :video_game_id
             ORDER BY j.titulo ASC'
        );
        $stmt->execute(['video_game_id' => $videoGameId]);

        return $stmt->fetchAll();
    }

    public function platforms(int $jogoId): array
    {
        $stmt = $this->db->prepare(
            'SELECT v.*
             FROM video_games v
             INNER JOIN jogo_video_game jvg ON jvg.video_game_id = v.id
             WHERE jvg.jogo_id = :jogo_id
             ORDER BY v.nome ASC'
        );
        $stmt->execute(['jogo_id' => $jogoId]);

        return $stmt->fetchAll();
    }

    public function platformIds(int $jogoId): array
    {
        $stmt = $this->db->prepare('SELECT video_game_id FROM jogo_video_game WHERE jogo_id = :jogo_id');
        $stmt->execute(['jogo_id' => $jogoId]);

        return array_column($stmt->fetchAll(), 'video_game_id');
    }

    public function create(array $data, array $platformIds): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO jogos (titulo, genero, desenvolvedora, publicadora, ano_lancamento, classificacao_indicativa, modo_jogo, descricao, capa)
             VALUES (:titulo, :genero, :desenvolvedora, :publicadora, :ano_lancamento, :classificacao_indicativa, :modo_jogo, :descricao, :capa)'
        );
        $stmt->execute($data);

        $id = (int)$this->db->lastInsertId();
        $this->syncPlatforms($id, $platformIds);

        return $id;
    }

    public function update(int $id, array $data, array $platformIds): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE jogos
             SET titulo = :titulo, genero = :genero, desenvolvedora = :desenvolvedora, publicadora = :publicadora,
                 ano_lancamento = :ano_lancamento, classificacao_indicativa = :classificacao_indicativa,
                 modo_jogo = :modo_jogo, descricao = :descricao, capa = :capa, updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $stmt->execute($data);
        $this->syncPlatforms($id, $platformIds);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM jogo_video_game WHERE jogo_id = :id');
        $stmt->execute(['id' => $id]);

        $stmt = $this->db->prepare('DELETE FROM jogos WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    private function syncPlatforms(int $jogoId, array $platformIds): void
    {
        $stmt = $this->db->prepare('DELETE FROM jogo_video_game WHERE jogo_id = :jogo_id');
        $stmt->execute(['jogo_id' => $jogoId]);

        $platformIds = array_unique(array_filter(array_map('intval', $platformIds)));

        if (!$platformIds) {
            return;
        }

        $stmt = $this->db->prepare(
            'INSERT INTO jogo_video_game (jogo_id, video_game_id) VALUES (:jogo_id, :video_game_id)'
        );

        foreach ($platformIds as $platformId) {
            $stmt->execute([
                'jogo_id' => $jogoId,
                'video_game_id' => $platformId,
            ]);
        }
    }
}

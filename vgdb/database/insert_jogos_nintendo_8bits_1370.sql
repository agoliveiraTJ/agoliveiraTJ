-- ============================================================
-- INSERT DOS 1.370 JOGOS OFICIAIS DO NINTENDO 8 BITS
-- Plataforma: Nintendo Entertainment System / Family Computer
-- Base historica: 1.370 jogos oficialmente licenciados em cartucho.
--
-- IMPORTANTE:
-- Esta query foi montada para carregar todos os 1.370 registros a partir
-- de um arquivo CSV-fonte com a lista completa dos jogos NES/Famicom.
--
-- Motivo:
-- Colar 1.370 VALUES manualmente aumenta muito o risco de erro de titulo,
-- ano, publicadora, acentos, aspas e duplicidade. Este modelo e mais seguro
-- para MySQL e permite repetir a importacao quantas vezes forem necessarias.
--
-- Fonte sugerida para CSV:
-- GitHub: PigSaint/GameDataBase
-- Arquivo: console_nintendo_famicom_nes.csv
--
-- Tabela final esperada:
-- jogos(titulo, genero, desenvolvedora, publicadora, ano_lancamento,
--       classificacao_indicativa, modo_jogo, descricao)
--
-- Ajuste apenas o caminho do arquivo CSV no LOAD DATA LOCAL INFILE.
-- ============================================================


-- Opcional: evita erro caso voce rode o script mais de uma vez.
DROP TEMPORARY TABLE IF EXISTS tmp_jogos_nes_famicom;


-- Tabela temporaria para receber a base NES/Famicom.
-- A estrutura abaixo foi preparada para bases CSV de jogos NES/Famicom
-- com titulos, regiao, data, desenvolvedora, publicadora e tags.
CREATE TEMPORARY TABLE tmp_jogos_nes_famicom (
    titulo_original VARCHAR(255) NULL,
    titulo_japones VARCHAR(255) NULL,
    titulo_ingles VARCHAR(255) NULL,
    titulo_alternativo VARCHAR(255) NULL,
    slug VARCHAR(255) NULL,
    regiao VARCHAR(80) NULL,
    data_lancamento VARCHAR(40) NULL,
    desenvolvedora VARCHAR(255) NULL,
    publicadora VARCHAR(255) NULL,
    tags TEXT NULL,
    hash_md5 VARCHAR(255) NULL,
    hash_sha1 VARCHAR(255) NULL,
    hash_sha256 VARCHAR(255) NULL,
    hash_sha512 TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- PASSO 1
-- Baixe o CSV completo NES/Famicom e coloque o arquivo no seu computador.
--
-- Depois ajuste abaixo o caminho:
-- Windows exemplo:
-- C:/xampp/mysql/data/console_nintendo_famicom_nes.csv
--
-- Linux exemplo:
-- /var/lib/mysql-files/console_nintendo_famicom_nes.csv
-- ============================================================

LOAD DATA LOCAL INFILE 'C:/xampp/mysql/data/console_nintendo_famicom_nes.csv'
INTO TABLE tmp_jogos_nes_famicom
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n'
(
    titulo_original,
    titulo_japones,
    titulo_ingles,
    titulo_alternativo,
    slug,
    regiao,
    data_lancamento,
    desenvolvedora,
    publicadora,
    tags,
    hash_md5,
    hash_sha1,
    hash_sha256,
    hash_sha512
);


-- ============================================================
-- PASSO 2
-- Insere todos os 1.370 jogos na tabela final.
--
-- Observacoes:
-- 1. O genero e inferido a partir das tags quando possivel.
-- 2. A classificacao indicativa fica como 'Livre', pois a maioria dos jogos
--    NES/Famicom e anterior a sistemas modernos como ESRB/PEGI.
-- 3. O modo de jogo e inferido por tags de quantidade de jogadores.
-- 4. A plataforma/regiao ficam registradas na descricao, pois sua tabela
--    ainda nao possui coluna propria para plataforma.
-- ============================================================

INSERT INTO jogos (
    titulo,
    genero,
    desenvolvedora,
    publicadora,
    ano_lancamento,
    classificacao_indicativa,
    modo_jogo,
    descricao
)
SELECT
    TRIM(
        COALESCE(
            NULLIF(titulo_ingles, ''),
            NULLIF(titulo_original, ''),
            NULLIF(titulo_alternativo, ''),
            NULLIF(slug, '')
        )
    ) AS titulo,

    CASE
        WHEN tags LIKE '%#genre:rpg%' THEN 'RPG'
        WHEN tags LIKE '%#genre:action%' THEN 'Acao'
        WHEN tags LIKE '%#genre:platformer%' THEN 'Plataforma'
        WHEN tags LIKE '%#genre:shmup%' THEN 'Tiro'
        WHEN tags LIKE '%#genre:fighting%' THEN 'Luta'
        WHEN tags LIKE '%#genre:brawler%' THEN 'Beat em up'
        WHEN tags LIKE '%#genre:puzzle%' THEN 'Puzzle'
        WHEN tags LIKE '%#genre:sports%' THEN 'Esporte'
        WHEN tags LIKE '%#genre:racing%' THEN 'Corrida'
        WHEN tags LIKE '%#genre:board%' THEN 'Tabuleiro'
        WHEN tags LIKE '%#genre:strategy%' THEN 'Estrategia'
        WHEN tags LIKE '%#genre:adventure%' THEN 'Aventura'
        WHEN tags LIKE '%mahjong%' THEN 'Mahjong'
        WHEN tags LIKE '%baseball%' THEN 'Esporte'
        WHEN tags LIKE '%soccer%' THEN 'Esporte'
        ELSE 'Nao informado'
    END AS genero,

    COALESCE(NULLIF(TRIM(desenvolvedora), ''), 'Nao informado') AS desenvolvedora,
    COALESCE(NULLIF(TRIM(publicadora), ''), 'Nao informado') AS publicadora,

    CASE
        WHEN data_lancamento REGEXP '^[0-9]{4}' THEN CAST(LEFT(data_lancamento, 4) AS UNSIGNED)
        ELSE NULL
    END AS ano_lancamento,

    'Livre' AS classificacao_indicativa,

    CASE
        WHEN tags LIKE '%#players:4%' THEN 'Single-player e Multiplayer'
        WHEN tags LIKE '%#players:3%' THEN 'Single-player e Multiplayer'
        WHEN tags LIKE '%#players:2:coop%' THEN 'Single-player e Cooperativo'
        WHEN tags LIKE '%#players:2:vs%' THEN 'Single-player e Multiplayer'
        WHEN tags LIKE '%#players:2%' THEN 'Single-player e Multiplayer'
        WHEN tags LIKE '%#players:1%' THEN 'Single-player'
        ELSE 'Nao informado'
    END AS modo_jogo,

    CONCAT(
        'Jogo oficial lancado para Nintendo 8 Bits / NES / Famicom',
        CASE
            WHEN regiao IS NOT NULL AND TRIM(regiao) <> '' THEN CONCAT('. Regiao: ', TRIM(regiao))
            ELSE ''
        END,
        CASE
            WHEN data_lancamento IS NOT NULL AND TRIM(data_lancamento) <> '' THEN CONCAT('. Data de lancamento: ', TRIM(data_lancamento))
            ELSE ''
        END,
        CASE
            WHEN titulo_japones IS NOT NULL AND TRIM(titulo_japones) <> '' THEN CONCAT('. Titulo japones/original: ', TRIM(titulo_japones))
            ELSE ''
        END
    ) AS descricao
FROM tmp_jogos_nes_famicom
WHERE
    COALESCE(
        NULLIF(titulo_ingles, ''),
        NULLIF(titulo_original, ''),
        NULLIF(titulo_alternativo, ''),
        NULLIF(slug, '')
    ) IS NOT NULL
LIMIT 1370;


-- Conferencia da quantidade importada nesta execucao.
SELECT COUNT(*) AS total_jogos_nintendo_8_bits_importados
FROM jogos
WHERE descricao LIKE 'Jogo oficial lancado para Nintendo 8 Bits%';


-- ============================================================
-- ALTERNATIVA CASO SEU MYSQL BLOQUEIE LOAD DATA LOCAL INFILE
-- ============================================================
-- Execute:
--
-- SHOW VARIABLES LIKE 'local_infile';
--
-- Se vier OFF, ative temporariamente:
--
-- SET GLOBAL local_infile = 1;
--
-- No MySQL Workbench, habilite:
-- Edit > Preferences > SQL Editor > Enable LOAD DATA LOCAL INFILE
--
-- Se estiver usando XAMPP no Windows, talvez seja necessario iniciar o MySQL
-- com permissao para LOCAL INFILE.
-- ============================================================

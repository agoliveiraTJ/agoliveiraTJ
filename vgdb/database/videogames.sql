CREATE DATABASE IF NOT EXISTS site_videogames
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE site_videogames;

CREATE TABLE IF NOT EXISTS video_games (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    fabricante VARCHAR(120) NOT NULL,
    geracao VARCHAR(60) NULL,
    ano_lancamento SMALLINT UNSIGNED NOT NULL,
    midia VARCHAR(120) NULL,
    descricao TEXT NULL,
    imagem VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_video_games_nome (nome),
    INDEX idx_video_games_fabricante (fabricante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jogos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(160) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    desenvolvedora VARCHAR(120) NULL,
    publicadora VARCHAR(120) NULL,
    ano_lancamento SMALLINT UNSIGNED NOT NULL,
    classificacao_indicativa VARCHAR(30) NULL,
    modo_jogo VARCHAR(120) NULL,
    descricao TEXT NULL,
    capa VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_jogos_titulo (titulo),
    INDEX idx_jogos_genero (genero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jogo_video_game (
    jogo_id INT UNSIGNED NOT NULL,
    video_game_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (jogo_id, video_game_id),
    INDEX idx_jogo_video_game_console (video_game_id),
    CONSTRAINT fk_jvg_jogo
        FOREIGN KEY (jogo_id) REFERENCES jogos (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_jvg_video_game
        FOREIGN KEY (video_game_id) REFERENCES video_games (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO video_games (nome, fabricante, geracao, ano_lancamento, midia, descricao)
VALUES
('PlayStation 5', 'Sony', '9a geracao', 2020, 'Blu-ray Ultra HD e Digital', 'Console da Sony com SSD rapido, DualSense e suporte a jogos em alta resolucao.'),
('Xbox Series X', 'Microsoft', '9a geracao', 2020, 'Blu-ray Ultra HD e Digital', 'Console da Microsoft com foco em desempenho, Game Pass e retrocompatibilidade.'),
('Nintendo Switch', 'Nintendo', '8a geracao', 2017, 'Cartucho e Digital', 'Console hibrido que pode ser usado na TV ou em modo portatil.');
('Magnavox Odyssey', 'Magnavox', '1a geracao', 1972, 'Cartoes de circuito e overlays', 'Primeiro console domestico comercial, com jogos simples exibidos na TV e uso de overlays plasticos.'),
('Atari Home Pong', 'Atari', '1a geracao', 1975, 'Console dedicado', 'Console domestico dedicado ao jogo Pong, um dos primeiros grandes sucessos comerciais dos videogames.'),
('Coleco Telstar', 'Coleco', '1a geracao', 1976, 'Console dedicado', 'Linha de consoles dedicados baseada em jogos estilo Pong.'),
('Nintendo Color TV-Game', 'Nintendo', '1a geracao', 1977, 'Console dedicado', 'Primeira linha de consoles domesticos da Nintendo, lancada no Japao com jogos integrados.'),
('Fairchild Channel F', 'Fairchild', '2a geracao', 1976, 'Cartucho', 'Um dos primeiros consoles com cartuchos programaveis, abrindo caminho para bibliotecas de jogos separadas do hardware.'),
('Atari 2600', 'Atari', '2a geracao', 1977, 'Cartucho', 'Console classico da Atari que popularizou o uso de cartuchos e marcou a industria no fim dos anos 1970 e inicio dos anos 1980.'),
('Bally Astrocade', 'Bally', '2a geracao', 1978, 'Cartucho', 'Console domestico com capacidades graficas avancadas para a epoca e foco em jogos de arcade.'),
('Magnavox Odyssey 2', 'Magnavox / Philips', '2a geracao', 1978, 'Cartucho', 'Sucessor do Odyssey, com teclado embutido e jogos em cartucho.'),
('Intellivision', 'Mattel', '2a geracao', 1979, 'Cartucho', 'Console da Mattel que competiu diretamente com o Atari 2600, oferecendo graficos mais detalhados.'),
('Atari 5200', 'Atari', '2a geracao', 1982, 'Cartucho', 'Console da Atari criado para suceder o Atari 2600, com hardware mais poderoso.'),
('ColecoVision', 'Coleco', '2a geracao', 1982, 'Cartucho', 'Console conhecido por boas conversoes de jogos de arcade, especialmente Donkey Kong.'),
('Vectrex', 'General Consumer Electronics', '2a geracao', 1982, 'Cartucho', 'Console unico com monitor vetorial proprio integrado ao aparelho.'),
('Sega SG-1000', 'Sega', '2a geracao', 1983, 'Cartucho', 'Primeiro console domestico da Sega, lancado no mesmo periodo do Famicom no Japao.'),
('Nintendo Entertainment System', 'Nintendo', '3a geracao', 1983, 'Cartucho', 'Conhecido como Famicom no Japao e NES no ocidente, ajudou a revitalizar o mercado de videogames.'),
('Sega Master System', 'Sega', '3a geracao', 1985, 'Cartucho e Card', 'Console de 8 bits da Sega, concorrente do NES e muito popular em alguns mercados, incluindo o Brasil.'),
('Atari 7800', 'Atari', '3a geracao', 1986, 'Cartucho', 'Console da Atari com retrocompatibilidade com jogos do Atari 2600.'),
('Amstrad GX4000', 'Amstrad', '3a geracao', 1990, 'Cartucho', 'Console europeu baseado na linha de computadores Amstrad CPC Plus.'),
('PC Engine', 'NEC / Hudson Soft', '4a geracao', 1987, 'HuCard', 'Console japones conhecido no ocidente como TurboGrafx-16, famoso por seu tamanho compacto e bom desempenho 2D.'),
('TurboGrafx-16', 'NEC', '4a geracao', 1989, 'HuCard', 'Versao ocidental do PC Engine, competiu com Mega Drive e Super Nintendo.'),
('Sega Mega Drive', 'Sega', '4a geracao', 1988, 'Cartucho', 'Console de 16 bits da Sega, conhecido como Genesis na America do Norte.'),
('Sega Genesis', 'Sega', '4a geracao', 1989, 'Cartucho', 'Nome norte-americano do Mega Drive, popularizado por jogos como Sonic the Hedgehog.'),
('Neo Geo AES', 'SNK', '4a geracao', 1990, 'Cartucho', 'Console domestico premium da SNK com hardware semelhante aos arcades Neo Geo.'),
('Super Nintendo Entertainment System', 'Nintendo', '4a geracao', 1990, 'Cartucho', 'Console de 16 bits da Nintendo, conhecido como Super Famicom no Japao.'),
('Philips CD-i', 'Philips', '4a geracao', 1991, 'CD-ROM', 'Sistema multimidia com jogos, videos e conteudo educacional em CD.'),
('Sega CD', 'Sega', '4a geracao', 1991, 'CD-ROM', 'Acessorio de CD para Mega Drive / Genesis, adicionando jogos com maior armazenamento e videos.'),
('TurboDuo', 'NEC', '4a geracao', 1991, 'HuCard e CD-ROM', 'Versao integrada do PC Engine com suporte a jogos em HuCard e CD-ROM.'),
('3DO Interactive Multiplayer', 'The 3DO Company', '4a geracao', 1993, 'CD-ROM', 'Plataforma de jogos em CD licenciada para fabricantes como Panasonic, Sanyo e GoldStar.'),
('Atari Jaguar', 'Atari', '4a geracao', 1993, 'Cartucho', 'Ultimo console domestico da Atari, divulgado como sistema de 64 bits.'),
('Sega Saturn', 'Sega', '5a geracao', 1994, 'CD-ROM', 'Console da Sega com foco em jogos 2D avancados e primeiros jogos 3D.'),
('PlayStation', 'Sony', '5a geracao', 1994, 'CD-ROM', 'Primeiro console da Sony, popularizou os jogos em CD e marcou a entrada da marca no mercado.'),
('Virtual Boy', 'Nintendo', '5a geracao', 1995, 'Cartucho', 'Console experimental da Nintendo com exibicao estereoscopica em vermelho e preto.'),
('Nintendo 64', 'Nintendo', '5a geracao', 1996, 'Cartucho', 'Console de 64 bits da Nintendo, conhecido por jogos 3D como Super Mario 64 e The Legend of Zelda: Ocarina of Time.'),
('Apple Pippin', 'Apple / Bandai', '5a geracao', 1996, 'CD-ROM', 'Plataforma multimidia baseada em tecnologia Apple, lancada com apoio da Bandai.'),
('Dreamcast', 'Sega', '6a geracao', 1998, 'GD-ROM', 'Ultimo console domestico da Sega, com modem integrado e recursos online avancados para a epoca.'),
('PlayStation 2', 'Sony', '6a geracao', 2000, 'DVD e CD-ROM', 'Console de grande sucesso da Sony, tambem usado como reprodutor de DVD.'),
('Nintendo GameCube', 'Nintendo', '6a geracao', 2001, 'MiniDVD', 'Console compacto da Nintendo com midia optica proprietaria em formato reduzido.'),
('Xbox', 'Microsoft', '6a geracao', 2001, 'DVD', 'Primeiro console da Microsoft, com disco rigido interno e servico Xbox Live posteriormente consolidado.'),
('Panasonic Q', 'Panasonic / Nintendo', '6a geracao', 2001, 'MiniDVD e DVD', 'Versao especial do GameCube lancada no Japao com reproducao de DVD.'),
('Xbox 360', 'Microsoft', '7a geracao', 2005, 'DVD e Digital', 'Console da Microsoft com forte integracao online, conquistas e Xbox Live.'),
('PlayStation 3', 'Sony', '7a geracao', 2006, 'Blu-ray e Digital', 'Console da Sony com leitor Blu-ray, PlayStation Network e modelos com retrocompatibilidade parcial.'),
('Nintendo Wii', 'Nintendo', '7a geracao', 2006, 'DVD proprietario e Digital', 'Console da Nintendo com controles por movimento e grande apelo casual.'),
('Zeebo', 'Tectoy / Qualcomm', '7a geracao', 2009, 'Digital', 'Console lancado em mercados emergentes, incluindo o Brasil, com distribuicao digital de jogos.'),
('Wii U', 'Nintendo', '8a geracao', 2012, 'Disco optico proprietario e Digital', 'Console da Nintendo com controle GamePad com tela integrada.'),
('Ouya', 'Ouya Inc.', '8a geracao', 2013, 'Digital', 'Microconsole baseado em Android, financiado por crowdfunding.'),
('PlayStation 4', 'Sony', '8a geracao', 2013, 'Blu-ray e Digital', 'Console da Sony com arquitetura x86, foco em jogos digitais, streaming e servicos online.'),
('Xbox One', 'Microsoft', '8a geracao', 2013, 'Blu-ray e Digital', 'Console da Microsoft com integracao multimidia, Kinect opcional e ecossistema Xbox Live.'),
('Nvidia Shield TV', 'Nvidia', '8a geracao', 2015, 'Digital', 'Dispositivo Android TV com foco em streaming de jogos, emulacao e entretenimento.'),
('Nintendo Switch', 'Nintendo', '8a geracao', 2017, 'Cartucho e Digital', 'Console hibrido que pode ser usado na TV ou em modo portatil.'),
('PlayStation 4 Pro', 'Sony', '8a geracao', 2016, 'Blu-ray e Digital', 'Versao aprimorada do PlayStation 4 com suporte a resolucao 4K dinamica e melhor desempenho.'),
('Xbox One X', 'Microsoft', '8a geracao', 2017, 'Blu-ray UHD e Digital', 'Versao mais potente do Xbox One, com foco em jogos em 4K.'),
('PlayStation 5', 'Sony', '9a geracao', 2020, 'Blu-ray Ultra HD e Digital', 'Console da Sony com SSD rapido, controle DualSense e suporte a jogos em alta resolucao.'),
('PlayStation 5 Digital Edition', 'Sony', '9a geracao', 2020, 'Digital', 'Versao do PlayStation 5 sem leitor de disco, voltada para jogos digitais.'),
('Xbox Series X', 'Microsoft', '9a geracao', 2020, 'Blu-ray Ultra HD e Digital', 'Console da Microsoft com foco em desempenho, Game Pass e retrocompatibilidade.'),
('Xbox Series S', 'Microsoft', '9a geracao', 2020, 'Digital', 'Versao compacta e digital da familia Xbox Series, com menor potencia grafica que o Series X.'),
('PlayStation 5 Pro', 'Sony', '9a geracao', 2024, 'Digital com leitor opcional', 'Versao aprimorada do PlayStation 5 com GPU superior, PSSR e melhorias de desempenho.'),
('Nintendo Switch 2', 'Nintendo', '9a geracao', 2025, 'Cartucho e Digital', 'Sucessor do Nintendo Switch, mantendo o conceito hibrido com hardware atualizado.'),
('Game & Watch', 'Nintendo', 'Portatil - 2a geracao', 1980, 'Jogos integrados', 'Linha de portateis dedicados da Nintendo com tela LCD e jogos individuais.'),
('Game Boy', 'Nintendo', 'Portatil - 4a geracao', 1989, 'Cartucho', 'Portatil da Nintendo com tela monocromatica e grande biblioteca de jogos.'),
('Atari Lynx', 'Atari', 'Portatil - 4a geracao', 1989, 'Cartucho', 'Console portatil colorido da Atari, tecnologicamente avancado para a epoca.'),
('TurboExpress', 'NEC', 'Portatil - 4a geracao', 1990, 'HuCard', 'Versao portatil do TurboGrafx-16 / PC Engine, compativel com os mesmos cartuchos HuCard.'),
('Game Gear', 'Sega', 'Portatil - 4a geracao', 1990, 'Cartucho', 'Portatil colorido da Sega, concorrente direto do Game Boy.'),
('Sega Nomad', 'Sega', 'Portatil - 4a geracao', 1995, 'Cartucho', 'Portatil compativel com cartuchos do Mega Drive / Genesis.'),
('Game Boy Color', 'Nintendo', 'Portatil - 5a geracao', 1998, 'Cartucho', 'Evolucao colorida do Game Boy, com retrocompatibilidade com jogos anteriores.'),
('Neo Geo Pocket', 'SNK', 'Portatil - 5a geracao', 1998, 'Cartucho', 'Portatil da SNK com foco em jogos de luta e arcade.'),
('Neo Geo Pocket Color', 'SNK', 'Portatil - 5a geracao', 1999, 'Cartucho', 'Versao colorida do Neo Geo Pocket, conhecida por boa qualidade de controles.'),
('WonderSwan', 'Bandai', 'Portatil - 5a geracao', 1999, 'Cartucho', 'Console portatil da Bandai lancado no Japao, criado com participacao de Gunpei Yokoi.'),
('WonderSwan Color', 'Bandai', 'Portatil - 6a geracao', 2000, 'Cartucho', 'Versao colorida do WonderSwan, com biblioteca popular no Japao.'),
('Game Boy Advance', 'Nintendo', 'Portatil - 6a geracao', 2001, 'Cartucho', 'Portatil de 32 bits da Nintendo, sucessor da linha Game Boy.'),
('N-Gage', 'Nokia', 'Portatil - 6a geracao', 2003, 'Cartucho MMC', 'Dispositivo hibrido de celular e console portatil desenvolvido pela Nokia.'),
('Nintendo DS', 'Nintendo', 'Portatil - 7a geracao', 2004, 'Cartucho e Digital', 'Portatil da Nintendo com duas telas, sendo uma sensivel ao toque.'),
('PlayStation Portable', 'Sony', 'Portatil - 7a geracao', 2004, 'UMD e Digital', 'Primeiro portatil da Sony, com graficos avancados, midia UMD e recursos multimidia.'),
('Nintendo DSi', 'Nintendo', 'Portatil - 7a geracao', 2008, 'Cartucho e Digital', 'Revisao do Nintendo DS com cameras, loja digital e melhorias de sistema.'),
('Nintendo 3DS', 'Nintendo', 'Portatil - 8a geracao', 2011, 'Cartucho e Digital', 'Portatil da Nintendo com efeito 3D sem oculos e retrocompatibilidade com Nintendo DS.'),
('PlayStation Vita', 'Sony', 'Portatil - 8a geracao', 2011, 'Cartucho proprietario e Digital', 'Portatil da Sony com tela OLED em modelos iniciais, touch traseiro e integracao com PlayStation Network.'),
('Nintendo 2DS', 'Nintendo', 'Portatil - 8a geracao', 2013, 'Cartucho e Digital', 'Versao economica do Nintendo 3DS sem efeito 3D e com design em formato slate.'),
('New Nintendo 3DS', 'Nintendo', 'Portatil - 8a geracao', 2014, 'Cartucho e Digital', 'Revisao aprimorada do Nintendo 3DS com processador melhor, botoes extras e suporte a alguns jogos exclusivos.'),
('Nintendo Switch Lite', 'Nintendo', 'Portatil - 8a geracao', 2019, 'Cartucho e Digital', 'Versao exclusivamente portatil do Nintendo Switch.'),
('Evercade', 'Blaze Entertainment', 'Portatil - 8a geracao', 2020, 'Cartucho e Digital', 'Portatil voltado a colecoes licenciadas de jogos retro em cartuchos.'),
('Analogue Pocket', 'Analogue', 'Portatil - 8a geracao', 2021, 'Cartucho', 'Portatil FPGA compativel com cartuchos de Game Boy, Game Boy Color, Game Boy Advance e outros via adaptadores.'),
('Playdate', 'Panic', 'Portatil - 8a geracao', 2022, 'Digital', 'Portatil indie com tela monocromatica e manivela lateral como metodo de controle.'),
('Steam Deck', 'Valve', 'Portatil PC - 9a geracao', 2022, 'Digital', 'PC portatil para jogos baseado em SteamOS, com foco na biblioteca Steam.'),
('Asus ROG Ally', 'Asus', 'Portatil PC - 9a geracao', 2023, 'Digital', 'PC portatil gamer com Windows, tela de alta taxa de atualizacao e hardware AMD Ryzen Z1.'),
('Lenovo Legion Go', 'Lenovo', 'Portatil PC - 9a geracao', 2023, 'Digital', 'PC portatil gamer com Windows, controles destacaveis e tela grande.'),
('MSI Claw', 'MSI', 'Portatil PC - 9a geracao', 2024, 'Digital', 'PC portatil gamer com Windows e processador Intel Core Ultra.');

INSERT INTO jogos (titulo, genero, desenvolvedora, publicadora, ano_lancamento, classificacao_indicativa, modo_jogo, descricao)
VALUES
('The Legend of Zelda: Tears of the Kingdom', 'Aventura', 'Nintendo EPD', 'Nintendo', 2023, '10', 'Single-player', 'Aventura em mundo aberto com exploracao, construcao e combate.'),
('Elden Ring', 'RPG de Acao', 'FromSoftware', 'Bandai Namco', 2022, '16', 'Single-player e Online', 'RPG de acao em mundo aberto com combates desafiadores.'),
('Forza Horizon 5', 'Corrida', 'Playground Games', 'Xbox Game Studios', 2021, 'Livre', 'Single-player e Multiplayer', 'Jogo de corrida em mundo aberto ambientado no Mexico.');

INSERT INTO jogo_video_game (jogo_id, video_game_id)
VALUES
(1, 3),
(2, 1),
(2, 2),
(3, 2);

############################################
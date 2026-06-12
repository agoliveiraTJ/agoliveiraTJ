# GameVerse

Projeto PHP MVC com MySQL para cadastro e consulta de Video Games e Jogos.

## Requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Apache com `mod_rewrite` ativo ou servidor embutido do PHP

## Instalacao rapida

1. Use a pasta local do projeto:

```text
C:\projetos\gameverse
```

2. No MySQL Workbench, phpMyAdmin ou terminal MySQL, execute:

```sql
SOURCE caminho/para/database/videogames.sql;
```

3. Confira os dados de conexao no arquivo:

```text
.env
```

4. Para iniciar o servidor local, execute:

```text
iniciar-servidor.bat
```

5. Acesse no navegador:

```text
http://127.0.0.1:8000/
```

## Rotas principais

- `/` - Home
- `/videogames` - Listagem publica de Video Games
- `/jogos` - Listagem publica de Jogos
- `/admin` - Painel administrativo
- `/admin/videogames` - CRUD de Video Games
- `/admin/jogos` - CRUD de Jogos

## Uploads

As imagens enviadas pelo admin ficam em:

```text
public/uploads/
```

Formatos aceitos: `jpg`, `jpeg`, `png`, `webp`.
Tamanho maximo: 2MB.

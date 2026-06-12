# Site sobre Video Games

Projeto PHP MVC com MySQL para cadastro de Video Games e Jogos.

## Requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Apache com `mod_rewrite` ativo, usando XAMPP, Laragon ou servidor PHP comum

## Instalação rápida

1. Copie o projeto para a pasta do servidor local.
   - XAMPP: `C:\xampp\htdocs\Site sobre Videogames`
   - Laragon: `C:\laragon\www\Site sobre Videogames`

2. No MySQL Workbench, phpMyAdmin ou terminal MySQL, execute:

```sql
SOURCE caminho/para/database/videogames.sql;
```

3. Confira os dados de conexão em:

```text
.env
```

4. Acesse no navegador:

```text
http://localhost/Site%20sobre%20Videogames/public/
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

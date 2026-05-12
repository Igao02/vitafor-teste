# RickVerse — Teste Técnico Vitafor

Aplicação web para explorar e salvar personagens do universo de Rick and Morty, desenvolvida em PHP puro com SQLite.

## Stack

- **Backend:** PHP 8.3 (sem framework)
- **Banco de dados:** SQLite via PDO
- **Frontend:** Bootstrap 5 + Vanilla JS (Fetch API)
- **API:** [Rick and Morty API](https://rickandmortyapi.com)

## Pré-requisitos

- PHP >= 8.0 com as extensões `pdo` e `pdo_sqlite` habilitadas

Para verificar:
```bash
php -m | grep -i sqlite
```

## Setup

```bash
git clone https://github.com/Igao02/vitafor-teste.git
cd vitafor-teste
php -S localhost:8000 public/index.php
```

Acesse [http://localhost:8000](http://localhost:8000). O banco de dados SQLite é criado automaticamente na primeira execução em `storage/database.sqlite`.

## Funcionalidades

- **Home** — lista personagens da API com busca em tempo real, filtro por status e paginação
- **Personagens** — lista personagens salvos localmente no banco de dados
- **Detalhes** — visualiza dados completos do personagem; usuários autenticados podem salvar, editar e excluir
- **Autenticação** — cadastro e login com validação e senhas criptografadas (bcrypt)
- **Responsivo** — layout adaptado para mobile, tablet e desktop

## Arquitetura

Organização em camadas inspirada em Clean Architecture:

```
src/
├── Domain/          # Entidades puras (User, Character)
├── Infrastructure/  # PDO SQLite, Repositories, API Client
├── Application/     # Services (AuthService, CharacterService)
└── Presentation/    # Router, Controllers
```

## Estrutura do projeto

```
vitafor-teste/
├── public/
│   ├── index.php        # Front controller
│   └── assets/          # CSS e JS
├── src/                 # Código fonte (camadas)
├── views/               # Templates PHP
├── storage/             # Banco SQLite (gitignored)
└── bootstrap.php        # Autoloader e inicialização
```

# RickVerse — Teste Técnico Vitafor

Aplicação web para explorar e salvar personagens do universo de Rick and Morty, desenvolvida em PHP puro com SQLite.

## Stack

- **Backend:** PHP 8.3 (sem framework)
- **Banco de dados:** SQLite via PDO
- **Frontend:** Bootstrap 5 + Vanilla JS (Fetch API)
- **API:** [Rick and Morty API](https://rickandmortyapi.com)

## Pré-requisitos

- PHP >= 8.0
- Extensões obrigatórias: `pdo`, `pdo_sqlite`, `curl`, `openssl`

Para verificar se estão ativas:
```bash
php -m | grep -iE "pdo|curl|openssl"
```

**Por que cada extensão é necessária:**
- `pdo` + `pdo_sqlite` — camada de acesso ao banco de dados SQLite
- `curl` — permite que o PHP faça requisições HTTP para a API do Rick and Morty
- `openssl` — permite que o cURL acesse URLs **HTTPS** (sem ela, requisições seguras falham)

Caso alguma não apareça, habilite-as no `php.ini` removendo o `;` das linhas abaixo:

```ini
extension=curl
extension=openssl
extension=pdo_sqlite
```

> Para encontrar o `php.ini` correto: `php --ini`

## Setup

```bash
git clone https://github.com/Igao02/vitafor-teste.git
cd vitafor-teste
php -S localhost:8000 public/index.php
```

Acesse [http://localhost:8000](http://localhost:8000).

- O banco de dados SQLite é criado automaticamente em `storage/database.sqlite` na primeira execução — certifique-se de que a pasta `storage/` tem permissão de escrita
- Nenhuma dependência externa para instalar (sem Composer, sem npm)

## Funcionalidades

- **Home** — lista personagens da API com busca em tempo real, filtro por status e paginação
- **Personagens** — lista personagens salvos pelo usuário logado
- **Detalhes** — visualiza dados completos; usuários autenticados podem salvar, editar e excluir (soft delete — o registro é mantido no banco com `active = 0`)
- **Sobre** — mini currículo do desenvolvedor
- **Autenticação** — cadastro e login com senhas criptografadas (bcrypt)
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
│   ├── index.php        # Front controller + servidor de arquivos estáticos
│   └── assets/          # CSS, JS e imagens
├── src/                 # Código fonte (camadas)
├── views/               # Templates PHP
├── storage/             # Banco SQLite (gitignored)
└── bootstrap.php        # Autoloader e inicialização
```

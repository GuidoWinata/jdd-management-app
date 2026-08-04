# Laravel Starter Kit

A modern Laravel starter kit with admin panel, built with Laravel 12, Bun for build tool, Tailwind CSS 4, and Preline UI components.

## Features

- 🚀 **Laravel 12** - Latest Laravel framework
- 🎨 **Tailwind CSS 4** - Utility-first CSS framework
- 🧩 **Preline UI** - Beautiful UI components
- 🌙 **Dark Mode** - Built-in dark mode support
- 👤 **User Management** - Complete CRUD for users
- 📱 **Responsive** - Mobile-first design
- ⚡ **Vite** - Lightning fast build tool
- 🧪 **Pest** - Modern PHP testing framework
- 🏗️ **Clean Architecture** - Usecase pattern for business logic
- 🔌 **API Ready** - Separate CMS and API controllers sharing the same Usecase layer

## Requirements

- PHP 8.2+
- Composer
- Bun
- SQLite / MySQL / PostgreSQL

## Installation

1. Clone the repository
```bash
git clone https://github.com/rahmatrdn/laravel-starter-kit.git
cd laravel-starter-kit
```

2. Run the setup command
```bash
composer setup
```

This will:
- Install PHP dependencies
- Create `.env` file from `.env.example`
- Generate application key
- Run database migrations
- Install NPM dependencies
- Build frontend assets

3. Start the development server
```bash
composer dev
```

This will start:
- Laravel development server
- Queue listener
- Laravel Pail (log viewer)
- Bun dev server

## Project Structure

```
app/
├── Entities/        # Data Transfer Objects
├── Http/
│   └── Controllers/ # HTTP Controllers
│       ├── Admin/   # CMS controllers returning views/redirects
│       └── Api/     # API controllers returning JSON
├── Models/          # Eloquent Models
├── Usecase/         # Business Logic Layer
└── Providers/       # Service Providers

routes/
├── web.php          # CMS routes
└── api.php          # Stateless API routes, create when API endpoints are added

resources/
└── views/
    └── _admin/      # Admin panel views
        ├── _layout/ # Layout components
        ├── users/   # User management views
        └── ...
```

## Architecture

Business logic lives in `app/Usecase`. Controllers stay thin and only adapt HTTP requests to Usecase calls.

- CMS controllers live in `app/Http/Controllers/Admin` and return Blade views or redirects.
- API controllers live in `app/Http/Controllers/Api` and return JSON responses.
- Both controller types may use the same Usecase. Do not duplicate business logic for API endpoints.
- API routes belong in `routes/api.php`; create and register it in `bootstrap/app.php` when the first API endpoint is added.
- API responses should return the Usecase response array as JSON: `response()->json($process, $process['code'] ?? 200)`.
- Use Sanctum middleware only for endpoints that require authenticated API consumers.

## Available Scripts

| Command | Description |
|---------|-------------|
| `composer setup` | Initial project setup |
| `composer dev` | Start development servers |
| `composer test` | Run tests |
| `bun run dev` | Start Bun dev server |
| `bun run build` | Build for production |

## Admin Panel

The admin panel is available at `/admin` route and includes:

- Dashboard with statistics
- User management (CRUD)
- Responsive sidebar navigation
- Dark mode toggle

## Tech Stack

| Category | Technology |
|----------|------------|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Tailwind CSS 4, Preline UI |
| Build Tool | Bun |
| Testing | Pest |
| Database | SQLite (default), MySQL, PostgreSQL |

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

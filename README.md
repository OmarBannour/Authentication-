# Authentication System

A secure and modern authentication system built with Laravel (Backend) and Angular (Frontend).

## Features

- **User Registration**
  - Email validation with MX record check
  - Strong password requirements
  - Password confirmation
  - Email notification on successful registration

- **User Login**
  - Rate limiting to prevent brute force attacks
  - Secure token-based authentication
  - Account blocking after multiple failed attempts
  - Remember me functionality

- **Security Features**
  - Password requirements:
    - Minimum 12 characters
    - Must contain uppercase letters
    - Must contain lowercase letters
    - Must contain numbers
    - Must contain special characters
    - Common passwords are blocked
  - Rate limiting on login attempts
  - Secure HTTP-only cookies
  - CSRF protection
  - Email domain validation

## Tech Stack

### Backend (Laravel)
- PHP 8.x
- Laravel 10.x
- Sanctum for API authentication
- Laravel Notifications for email
- Rate Limiter for security

### Frontend (Angular)
- Angular 17
- TypeScript
- RxJS for reactive programming
- Angular Router for navigation
- Angular Forms for form handling

## Project Structure

```
.
├── Backend/                 # Laravel backend
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       └── AuthController.php
│   │   ├── Models/
│   │   │   └── User.php
│   │   └── Notifications/
│   │       └── RegisterNotification.php
│   └── routes/
│       └── api.php
│
└── Frontend/               # Angular frontend
    ├── src/
    │   ├── app/
    │   │   ├── login/
    │   │   ├── register/
    │   │   └── app.component.*
    │   ├── Auth.service.ts
    │   └── main.ts
    └── package.json
```

## Getting Started

### Prerequisites
- PHP 8.x
- Composer
- Node.js 18.x
- Angular CLI
- MySQL/PostgreSQL

### Backend Setup
1. Navigate to the Backend directory:
   ```bash
   cd Backend
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env` and configure your database:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Start the server:
   ```bash
   php artisan serve
   ```

### Frontend Setup
1. Navigate to the Frontend directory:
   ```bash
   cd Frontend/Authentification
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Start the development server:
   ```bash
   ng serve
   ```

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user
- `GET /api/user` - Get authenticated user details

## Security Considerations

1. **Password Security**
   - Strong password requirements enforced
   - Passwords are hashed using bcrypt
   - Common passwords are blocked

2. **Rate Limiting**
   - Login attempts are rate-limited
   - IP-based blocking after multiple failed attempts

3. **Token Security**
   - HTTP-only cookies for token storage
   - Secure and SameSite cookie attributes
   - Token expiration

4. **Email Validation**
   - MX record validation
   - Email format validation
   - Unique email requirement

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details. 
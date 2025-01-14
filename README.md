        Symfony Project Setup Guide

------------------------------------------------

1. Installation of Symfony Application

  1.1 Create a new Symfony application:
  
    symfony new GExams --full --version=6.0
  
  1.2. Edit the .env file to configure database connection settings.
  
  1.3. Create the database:
  
    symfony console doctrine:database:create
  
  1.4. Install the HTTPS certificate:
  
    symfony server:ca:install
  
  1.5. Start the Symfony server:
  
    symfony server:start -d
  
  1.6. Access the application in the browser:
  
    https://127.0.0.1:8000
  
  1.7. Stop the server when needed:
  
    symfony server:stop

------------------------------------------------

2. Create Entities and Database Tables

  2.1. Create your entities and define relationships:
  
    symfony console make:entity
  
  2.2. Generate migration files:
  
    symfony console make:migration
  
  2.3. Apply migrations to update the database schema:
  
    symfony console doctrine:migrations:migrate

------------------------------------------------

3. Setup User Security

  3.1. Create the User entity with email-based authentication:
  
    symfony console make:user
  
      Enter yes for using email and password.
  
  3.2. Add additional fields to User (e.g., username):
  
    symfony console make:entity User
  
  3.3. Install and configure an authenticator:
  
    symfony console make:auth
  
      Choose 1 for creating a login form authenticator.
      1 AppAuthenticator SecurityController yes
  
  3.4. Create a registration system:
  
    symfony console make:registration
  
  3.5. Install the password reset bundle:
  
    composer require symfonycasts/reset-password-bundle
  
  3.6. Generate the reset-password system:
  
    symfony console make:reset-password

------------------------------------------------

4. Update Security Configuration

  4.1. In src/Security/AppAuthenticator.php, update the redirection after login:
  
    return new RedirectResponse($this->urlGenerator->generate('dashboard'));
  
  4.2. Modify config/packages/security.yaml to define roles:
  
    - { path: ^/admin, roles: ROLE_USER }

------------------------------------------------

5. Install and Configure Fixtures

  5.1. Install Foundry and Doctrine fixtures:
  
    composer require zenstruck/foundry --dev
    composer require orm-fixtures --dev
  
  5.2. Create factories for all entities:
  
    symfony console make:factory
  
  5.3. Update AppFixtures.php to use the factories. Example for Etudiant:
  
    EtudiantFactory::createMany(10);
  
  5.4. Modify default values in each entity’s factory to match their structure. Example:
  
    return [
        'nom' => self::faker()->lastName(),
        'prenom' => self::faker()->firstName(),
        'filiere' => FiliereFactory::randomOrCreate(),
        'cin' => self::faker()->regexify('[A-Z]{2}[0-9]{8}'),
    ];
  
  5.5. Load the fixtures:
  
    symfony console doctrine:fixtures:load

------------------------------------------------

6. Install the Admin Dashboard

  6.1. Install EasyAdminBundle:
  
    composer require admin
  
  6.2. Create a dashboard:
  
    symfony console make:admin:dashboard
  
  6.3. Add CRUD controllers for all entities:
  
    symfony console make:admin:crud
  
  6.4. Update the DashboardController:
  
    Add entities to configureMenuItems:
    
      yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
      yield MenuItem::linkToCrud('Filiere', 'fas fa-list', Filiere::class);
      yield MenuItem::linkToCrud('Etudiant', 'fas fa-list', Etudiant::class);
  
    Add user menu configuration:
  
      public function configureUserMenu(UserInterface $user): UserMenu
      {
          return parent::configureUserMenu($user)
              ->setName($user->getUserIdentifier())
              ->setGravatarEmail($user->getEmail())
              ->displayUserAvatar(true);
      }

------------------------------------------------

7. Install Frontend Tools

  7.1. Install Webpack Encore:
  
    composer require symfony/webpack-encore-bundle
  
  7.2. Install Node.js, Yarn, and dependencies:
  
    yarn install
    yarn add jquery
    yarn add sass-loader sass --dev
    yarn add bootstrap
    yarn add @fortawesome/fontawesome-free
  
  7.3. Update app.js to include these:
  
    import $ from 'jquery';
    import '@fortawesome/fontawesome-free/js/all';
    
  7.4. Convert app.css to app.scss and update imports:
  
    @import 'custom';
    @import '~bootstrap/scss/bootstrap';

------------------------------------------------

8. Setup Language Switching

  8.1. Configure translations (messages.en.yaml, messages.fr.yaml, etc.).
  
  8.2. Implement a ChangeLangueController and templates for language selection.
  
  8.3. Rebuild assets:
  
    yarn run build

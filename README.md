# Deployment statuses

A tiny application that helps you monitor the deployments of your repositories.

## Setup
This application uses the github API get information about repositories and deployments. [Register a new application at GitHub](https://github.com/settings/applications/new) to let users authorize the application with their data.
The callback url must end in `/auth/github/callback`. Example; When hosting the application at https://deployment-app.org, the callback url would be `https://deployment-app.org/auth/github/callback`.
When your oAuth app has been registered with GitHub, keep track of the `client id` and `client secret`. You will need these during the configuration of the application.

### Installation steps
- Clone the project
- Do a `composer install`
- Duplicate the `.env.example` file to `.env` and adjust the config values.
- Run `php artisan migrate` to create the initial tables.

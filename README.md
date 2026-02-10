# WordPress Development - Stephen King Books Plugin

## Instructions to Create .env File

To create the `.env` file, copy the `.env.example` file and fill in the required values:

```bash
cp .env.example .env
```

## Running the Project

To start the project, use the following command:

```bash
docker-compose up
```

## WP CLI Commands to Install Required Plugins

You can install the required plugins using WP CLI with the following commands:

```bash
wp plugin install stephen-king-books --activate
wp plugin install reviews --activate
wp plugin install blockart-blocks --activate
wp plugin install loco-translate --activate
wp plugin install query-monitor --activate
wp plugin install everest-forms --activate
wp plugin install mailhog --activate
```

### Zakra Theme Installation

Additionally, install the Zakra theme:

```bash
wp theme install zakra --activate
```

## Links to Localhost Services
- **WordPress:** [http://localhost:8000](http://localhost:8000)
- **phpMyAdmin:** [http://localhost:8080](http://localhost:8080)
- **MailHog:** [http://localhost:8025](http://localhost:8025)

## WP CLI Usage Instructions

This project utilizes WP CLI for managing WordPress installations. Ensure that WP CLI is installed and available in your Docker container.

To use WP CLI, you can run commands like:

```bash
docker exec -it <container_name> wp <command>
```

Replace `<container_name>` with the name of your WordPress container, and `<command>` with the WP CLI command you wish to execute.

## Demo Admin Credentials

For demo purposes, use the following credentials:
- **Username:** demo
- **Password:** demo123

## Custom Theme and Plugins Included

This project includes a custom theme and several plugins specifically tailored for a WordPress development environment focused on Stephen King books.
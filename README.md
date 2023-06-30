# WP Blueprint Mailer Plugin

This plugin provides an easy-to-use settings page where you can configure your SMTP host, authentication, port, username, password, and security type. It also allows you to send test emails from your WordPress dashboard to ensure your SMTP settings are correctly configured.

## Features

- **Easy SMTP settings configuration:** Simply enter your SMTP host, authentication, port, username, password, and security type in the 'Mailer Settings
- **Test Email functionality:**: Verify your SMTP settings by sending a test email straight from your WordPress dashboard.

## Requirements

- **PHP:** This plugin requires PHP 7.4 or higher.
- **WordPress:** A WordPress installation of 5.6 or higher is required.
- **.env file:** Your WordPress installation must be configured to read SMTP settings from a .env file.
- **Composer:** The plugin is installable via Composer from Packagist, but can also be manually downloaded and installed.

## Installation

To install this plugin using Composer, simply run the following command in your terminal:

```sh
composer require wp-blueprint/plugin-mailer
```

After the plugin has been downloaded by Composer, you need to activate it. You can do this by going to the Plugins page in your WordPress admin dashboard, locating the plugin, and clicking "Activate".

## Usage

1. After activating the plugin, navigate to the 'WPBlueprint Plugins' menu and select 'Mailer'.
2. Enter your SMTP details and save the settings.
3. You can send a test email from the 'Mailer' page to ensure that your SMTP settings are correctly configured.

## Backlog

Here are some features and improvements planned for future releases:

- **User Interface:** Improve the user interface for better usability.
- **Localization:** Provide translations for the admin interface to support various languages.
- **Integration:** Consider integration with popular forms plugins to make your plugin more versatile.
- **Multiple Configuration Features:** Allow the creation of multiple "SMTP profiles", each with their own host, port, username, password, and other settings.
- **Secure Credential Storage:** Improve the security of SMTP credential storage, possibly integrating with secure WordPress options or other secure methods for storing sensitive data.

## Development

[![Code Quality - WPCS](https://github.com/WP-Blueprint/wp-blueprint-plugin-mailer/actions/workflows/lint-wpcs.yml/badge.svg)](https://github.com/WP-Blueprint/wp-blueprint-plugin-mailer/actions/workflows/lint-wpcs.yml) [![Code Quality - PHP](https://github.com/WP-Blueprint/wp-blueprint-plugin-mailer/actions/workflows/lint-php.yml/badge.svg)](https://github.com/WP-Blueprint/wp-blueprint-plugin-mailer/actions/workflows/lint-php.yml)

Use the following scripts to aid in development:

- `composer run lint:wpcs`: WPCS Lint
- `composer run lint:wpcs:fix`: WPCS Fix
- `composer run lint:php`: PHP Lint

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests to help improve this plugin.

Please follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) and ensure that your changes are well-documented. Use the provided npm scripts for linting your PHP code before submitting.

## License

This plugin is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0).

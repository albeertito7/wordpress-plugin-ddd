## Project Structure

    ├── src/                            <- Source code for use in this project.
    ├── tests/
    │
    ├── .gitignore
    │
    ├── composer.json
    ├── composer.lock
    │
    ├── phpunit.xml
    │
    ├── index.php
    ├── index.html
    │
    ├── CHANGELOG.md
    ├── README.md                       <- The top-level README for developers using this project.
    │
    ├── uninstall.php
    └── entities.php                    <- The plugin main entrance file.

## Best Practices

This project applies when possible the best practices you may find at the WordPress docs, to help organize the code,
so it works well alongside WordPress core and other WordPress plugins.

You may check at the link below all the criteria taken into account.

https://developer.wordpress.org/plugins/plugin-basics/best-practices/

## Composer

This project is built upon `composer` package manager, thus,
enabling `PHP Namespaces` as the way of encapsulating items so that same names can be reused without name conflicts.

## Getting Started

Just run `composer install` or `make`

## Build for Production

You may use `composer build` or `make build` as convenience. This will generate the `vendor` folder you should include to your production environment.

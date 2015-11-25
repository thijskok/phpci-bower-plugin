# Bower plugin for [PHPCI](https://www.phptesting.org)

A plugin for PHPCI to download and install Bower packages required by your application.

### Install the Plugin

1. Navigate to your PHPCI root directory and run `composer require thijskok/phpci-bower-plugin`
2. If you are using the PHPCI daemon, restart it
3. Update your `phpci.yml` in the project you want to deploy with

### Prerequisites

1. [Bower](https://www.bower.io) needs to be installed.

### Plugin Options
- **force** _[boolean, optional]_ - Force latest version on conflict
- **production** _[boolean, optional]_ - Do not install project devDependencies

### PHPCI Config

```yml
ThijsKok\PHPCI\Plugin\Bower:
    force: false
    production: true
```

example:

```yml
setup:
    ThijsKok\PHPCI\Plugin\Bower:
        production: false
```

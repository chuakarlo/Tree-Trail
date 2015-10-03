Tree-Trail
==========

## Development setup

1. Download and install the following software:
    
    - [XAMPP](https://www.apachefriends.org/download.html)
    - [NodeJS](http://nodejs.org/download/)
    - [Git](https://msysgit.github.io/)
    - [Composer](https://getcomposer.org/doc/00-intro.md#using-the-installer)

2. On the top right of this page, click on "Fork". This makes a "photocopy" of the code in this repo into your account. If a modal window appears with a selection of accounts and organizations, choose your account.

3. Go to `http://github.com/[YOUR_GITHUB_USERNAME]/Tree-Trail`. On the bottom of the sidebar on the right, copy the URL. *This is your fork's Git url.*

4. Open `cmd` and `cd` to your XAMPP's `htdocs` directory and clone your fork.
   
    ```shell
    # Usually C:\XAMPP\htdocs. Change the drive if necessary.
    cd [PATH_TO_HTDOCS]
    git clone [YOUR_FORK_URL]
    ```

   It will ask for your Github username and password. The password won't appear when you type, so just type properly.
   
5. Open your XAMPP's control panel and stop Apache. Then go to your XAMPP directory and look for `httpd.conf`. Open this file, look for "`DocumentRoot`" and add `/Tree-Trail/php`.

    ```shell
    # Before
    DocumentRoot "C:\XAMPP\htdocs"

    # After
    DocumentRoot "C:\XAMPP\htdocs\Tree-Trail\php"
    ```

    Afterwards, restart Apache via the XAMPP control panel.

6. [Add the following environment variables](https://www.microsoft.com/resources/documentation/windows/xp/all/proddocs/en-us/sysdm_advancd_environmnt_addchange_variable.mspx?mfr=true) and values to your system. 

    - `OPENSHIFT_MYSQL_DB_HOST` : `localhost`
    - `OPENSHIFT_MYSQL_DB_PORT` : `3306`
    - `OPENSHIFT_MYSQL_DB_USERNAME` : username you use in phpmyadmin
    - `OPENSHIFT_MYSQL_DB_PASSWORD` : password you use in phpmyadmin
    - `OPENSHIFT_MYSQL_DB_NAME` : name of the Tree Trail DB
    - `OPENSHIFT_SECRET_TOKEN` : a random 32-character hex string (0-9, A-F)

7. To install client-side libraries, in the `cmd`, run the following:

    ```
    cd C:\XAMPP\htdocs\Tree-Trail\php\static
    npm install
    ```

8. To install server-side libraries, in the `cmd`, run the following:

    ```
    cd C:\XAMPP\htdocs\Tree-Trail\php\application\helpers
    composer update
    composer install
    ```

9. Start Apache and visit `http://localhost/init_db`. This page should contain instructions on setting up your db. If you receive a `A Database Error Occured. Unable to select the specified database: OPENSHIFT_MYSQL_DB_NAME`, create a blank database with the same name as `OPENSHIFT_MYSQL_DB_NAME`

## Contributing code

### Get a copy of the code

Steps 2-4 should provide you a copy of the code in your Github as well as on your local machine.

### Getting further updates

Once you have a local copy already via step 2-4, you do not need to clone anymore. All you need to do is grab updates from the main repo.

To add a reference to the original repository, do:

```shell
git remote add upstream https://github.com/fskreuz/Tree-Trail.git
```

To grab updates from the original repository, do:

```shell

# Grabs code from the originalrepository
git fetch upstream

# Merges the updated code onto your branch
git rebase upstream/development

```

### Committing changes

Once you have made your changes in your local machine, your code will need to be placed in the "staging area". In order to do that, for each file do:

```shell
git add path/to/file/you/want/added
```

The staging area is where you finalize what you want to put into history. To finally put into history, do:

```shell
git commit -m "MESSAGE HERE"
```

Replace `MESSAGE HERE` with a meaningful message describing your changes.

### Sending your changes

The following code will push your changes to your fork of the repo:

```shell
git push origin
```

Afterwards, you can create a pull request on Github, comparing the development branch of the original repo with the development branch of your repo.
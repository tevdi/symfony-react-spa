Symfony 3 Isomorphic SPA With React
===================================

This sandbox is a short version of the [Example of integration with React and Webpack (Webpack Encore) for universal (isomorphic) React rendering, using Limenius/ReactBundle and Limenius/LiformBundle](https://github.com/Limenius/symfony-react-sandbox) provided by the guys of Limenius. The purpose of this minified sandbox is to be compared with [another sandbox I made using Drupal 8](https://github.com/tevdi/drupal8-react-spa) as backend part instead of Symfony, with the same final result in both cases.

It's based in the Limenius' sandbox, so for more information related to the project, read the link above or visit the
writing I did in Medium.

How to run it
=============

First is required to create a database for the project (by default is named 'symfony-react-spa').
    
    git clone https://github.com/tevdi/symfony-react-spa.git
    
Configure the database in `app/config/parameters.yml` setting the database name, user and password.
    
    cd symfony-react-spa
    composer install
    
Create the schema for the database and load the fixtures:

    bin/console doctrine:schema:create
    bin/console hautelook:fixtures:load

Setting up the React app.

    cd spa
    npm install

Building the server-side and client-side react Webpack bundle:
    
    npm run webpack-serverside
    npm run webpack-dev
    
And then, run the Symfony server in the root of the project's directory in another terminal:

    bin/console server:start
    
After this, visit [http://127.0.0.1:8000](http://127.0.0.1:8000).

I recommend to populate the database at least with 3 elements to check how are working the two navbars. In Drupal 8 version,
this data is already populated with 3 players.

Credits
=======

This project couldn't been done without the work of the Limenius team.
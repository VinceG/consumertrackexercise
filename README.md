Consumer Track Exercise
=====================

## Exercises

- Write a RESTful web service called bank-rate to retrieve bank rates for different states/cities. Clients are authorized to access the service by passing api key provided offline in the header (-H "Authorization: asd123sdsa3123s1") The service will support both GET and POST. Bank rates are stored in a table called bank_rate in db.

###### Desired Features:

- retrieve rates for one or multiple cities.
- ability to limit 100 GET/POST requests per minute per user

(Please provide db schema for bank_rate table.)

- Write a RESTful web service called rates to allow user to perform add/update/delete operations on a list of rates supported by the application.

## Requirements

- [Composer](http://getcomposer.org/download/)

## Installation

1. Clone/Extract folder into your localhost folder
2. Via command cd into the directory where composer.json is located
3. Create a local database to use with this application
4. Create a folder `runtime` under protected and chmod 0777
5. Copy contents of protected/config/params-local.dist.php into protected/config/params-local.php
6. Change the DB settings in the protected/config/params-local.php file to match the ones on your local machine you created earlier
7. Run `sudo php composer.phar install` (Press 'Y' twice when prompted and wait until the installation finishes)

## Usage

```
- Get rates by state(s)
-- domain.com/site/bystate?key=DEV&state=CA
-- domain.com/site/bystate?key=DEV&state[]=AL&state[]=CA...
- Get rates by city/cities
-- domain.com/site/bycity?key=DEV&city=belk
-- domain.com/site/bycity?key=DEV&city[]=belk&city[]=arvin...
- Add new Rate
-- domain.com/rate/add?key=DEV&rate=10&city=Test
- Update Rate
-- domain.com/rate/update?key=DEV&rate=20&city=Test
- Delete Rate
-- domain.com/rate/delete?key=DEV&city=Test
```



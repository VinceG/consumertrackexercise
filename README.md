Consumer Track Exercise
=====================

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




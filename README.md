# fulll_hiring
Technical tests for hiring at Fulll

## Algo
The FizzBuzz exercice is within the class within `Algo\FizzBuzz.php`. 
Its Unit tests are within the file `tests\Unit\Algo\FizzBuzzTest.php`

## Backend Intermediate

### Step 1

You will find the features and the contexts files within the folder `tests\Features` and `tests\Context`

### Step 2

I used the Symfony 5.4 Framework to develop the application.

I created 2 services to manage the fleet and the localization : 
* `src/App/Service/FleetManager.php`
* `src/App/Service/ParkingManager.php`

I also used the `friends-of-behat/symfony-extension` to inject these services in the context files. 

Behat will use its own database defined in the `.env.test` file. Before testing each feature, the database is droped.

The database is managed with the Doctrine ORM. I added 4 entities in `src/Domain/Entity`. The database is defined in the `.env` file.

I did not use custom repositories because I did not need custom query to answer the achieve these objective. As a result, the folder `src\Infra` is empty.

I developed some fixtures. You can find then in `src/Domain/DataFixtures`. Basically, it will add 2 users(1 with a fleet), 2 locations, 2 vehicles (1 with a location and registered in a fleet). 

I created 3 Symfony commands to achieve the goals of this technical test.
* `src/App/Command/CreateFleetCommand.php`
* `src/App/Command/RegisterVehicleCommand.php`
* `src/App/Command/LocalizeVehicleCommand.php`

The verb 'localize' was a little bit amlbiguous for me, so I developed one action to set a vehicle's location and another one to get its location.

Here are the actions availbale to launch with the symfony console.

```
php bin/console fleet:create <userId> # returns fleetId on the standard output
php bin/console fleet:register-vehicle <fleetId> <vehiclePlateNumber> # register a vehicle in a fleet
php bin/console fleet:localize-vehicle <fleetId> <vehiclePlateNumber> <lat> <lng> # set vehicle's location
php bin/console fleet:localize-vehicle <fleetId> <vehiclePlateNumber # returns the vehicle's location on the standard output
```

I also created a shell script that launches the symfony commands.
```
./fleet create <userId> # returns fleetId on the standard output
./fleet register-vehicle <fleetId> <vehiclePlateNumber> # register a vehicle in a fleet
./fleet localize-vehicle <fleetId> <vehiclePlateNumber> <lat> <lng> # set vehicle's location
./fleet localize-vehicle <fleetId> <vehiclePlateNumber # returns the vehicle's location on the standard output
````

### Step 3

I added PHPCodeSniffer to make sure my code is compatible with the PSR-2 standard and PHPStan to ensure my code quality. 
I also added PHPUnit to add some Unit Tests. 

In a CI/CD process, I will add these programs, to be sure that the online repository contains tested code, that meets the standards. 

I will also run Behat to be sure that the project provides the features needed.

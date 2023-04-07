## About the project

The following project is a fleet-management system (Bus-booking system). To run the project 
- run composer i
- import dump of the database provided (fleetmanagement.sql)
- create a .env with your database configs
- run the project with your favourite method (xampp for windows or just php artisan serve)

A postman collection is provided with a list of apis as well as a list of example returns for several scenarios just change the variable in the connection to your domain.

The data inserted in the database is as follows:

cities :cairo,giza,AlFayyum,Alminya,Asyut,
we have 2 buses with take 2 paths starting from cairo:
bus1: cairo->AlFayyum->Alminya->Asyut.
bus2: cairo-> Asyut.(direct)

The list api returns an array of the possible buses given a from and to and returns the name of the available seat of that bus and the path that the bus takes to reach the desitination.

The create api take in a customer,from,to,bus and an optional seat. If the path provided exists and the user choose a bus that exists on the path a booking is created
with the seat the user specified(if available) or with the first available seat.
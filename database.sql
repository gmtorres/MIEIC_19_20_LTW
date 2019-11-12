DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Rent;
DROP TABLE IF EXISTS Comment;


CREATE TABLE User(
    userID integer PRIMARY KEY,
    userName text NOT NULL,
    email text NOT NULL,
    passHash text NOT NULL,
    age date NOT NULL,
    phoneNumber text NOT NULL CHECK(length(phoneNumber) = 9)
);


CREATE TABLE Place(
    placeID integer PRIMARY KEY,
    title text NOT NULL,
    placeDescription text NOT NULL,
    placeAddress text NOT NULL,
    area real NOT NULL CHECK(area > 0),
    maxGuests INTEGER NOT NULL,

    placeOwner integer NOT NULL REFERENCES User(userID)

    /*
        piscina
        wifi
        utilities
        empregado limpeza
        numero de quartos
        preço
        etc....
    */



);


CREATE TABLE Rent(
    rentID integer PRIMARY KEY,
    place integer REFERENCES Place(placeID),
    tourist integer REFERENCES User(userID),
    price integer NOT NULL CHECK(price > 0),
    maxCapacity integer NOT NULL CHECK(maxCapacity > 0),
    startDate date NOT NULL,
    endDate date NOT NULL 
);


CREATE TABLE Comment(
    commentID integer PRIMARY KEY,
    placeID integer NOT NULL REFERENCES Place(placeID),
    writer integer NOT NULL REFERENCES User(userID),
    classification integer NOT NULL CHECK (classification >= 1 AND classification <= 5),
    title text NOT NULL,
    comment text NOT NULL
);

INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Joao" , "joao@gmail.com","dsdfaasf235",30,912345678); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Ricardo" , "ricardo@gmail.com","fhds03ndsklaq1",45,914994618); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Fernando" , "fernando@gmail.com","f5as12g35",19,924324346); /*tourist*/

INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,placeOwner) VALUES ("Nice house" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",4,1);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,placeOwner) VALUES ("Cozy house" , "Nice rustic house with a beautiful village nearby and a river great for taking a bath as well for long walks . " , "Rua de Vila Nova", "Bragança",8,2);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,placeOwner) VALUES ("Great Appartment" , "Amazing apartment, many rooms, very big and with a fantastic view to the beach and great acesses" , "Avenida da Praia", "Espinho",6,1); 
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,placeOwner) VALUES ("Nice house2" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",6,1);


INSERT INTO Rent(place,tourist,price,maxCapacity,startDate,endDate) VALUES (1,2,1000,3,'12-10-2019','20-10-2019');

INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,2,4,"My stay","could improve");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,3,5,"Great!","Very Good");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (2,2,5,"Terrible place!","so much to improve ");
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Rent;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS My_Date;
DROP TABLE IF EXISTS Available_Dates;


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
    swimmingPool INTEGER DEFAULT 0,
    wiFi INTEGER DEFAULT 0,
    houseMaid INTEGER DEFAULT 0,
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


INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Joao", "joao@gmail.com", "dsdfaasf235",30,912345678); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Ricardo", "ricardo@gmail.com", "fhds03ndsklaq1",45,914994618); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Fernando", "fernando@gmail.com", "f5as12g35",19,924324346); /*tourist*/

INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,placeOwner) VALUES ("Nice house" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",4, 1, 1, 1, 1);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,placeOwner) VALUES ("Cozy house" , "Nice rustic house with a beautiful village nearby and a river great for taking a bath as well for long walks . " , "Rua de Vila Nova", "Bragança",8, 1, 1, 0, 2);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,placeOwner) VALUES ("Great Appartment" , "Amazing apartment, many rooms, very big and with a fantastic view to the beach and great acesses" , "Avenida da Praia", "Espinho",6, 0, 1, 1, 1); 
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,placeOwner) VALUES ("Nice house2" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",6, 0, 0, 0, 1);

INSERT INTO Rent(place,tourist,price,maxCapacity,startDate,endDate) VALUES (1,2,1000,3,'12-10-2019','20-10-2019');

INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,2,4,"My stay","could improve");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,3,5,"Great!","Very Good");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (2,2,5,"Terrible place!","so much to improve ");



Create TABLE Available_Dates(
    Available_DatesId integer PRIMARY KEY,
    PlaceId integer NOT NULL REFERENCES Place(placeId),
    startDate Date,
    endDate Date,
    price INTEGER
);

INSERT INTO Available_Dates (PlaceId,startDate,endDate,price) VALUES (1,date('2019-02-10') , date('2019-02-18') , 20);
INSERT INTO Available_Dates (PlaceId,startDate,endDate,price) VALUES (1,date('2019-02-18') , date('2019-02-20') , 51);
INSERT INTO Available_Dates (PlaceId,startDate,endDate,price) Values (1,date('2019-02-20') , date('2019-02-27') , 13);


/*Calcular o preço total
*/
/*
Select sum(TPrice) from (
Select min(T1,T2,T3)* price as TPrice from (
    Select * , julianDay(endDate)-julianDay(date('2019-02-17')) as T1 , julianDay(date('2019-02-19'))-julianDay(startDate) as T2 , julianDay(endDate)-julianDay(startDate) as T3
        from available_dates 
        where endDate > date('2019-02-17') and startDate < date('2019-02-19')
        )
    );
*/

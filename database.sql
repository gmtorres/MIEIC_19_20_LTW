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
    swimmingPool INTEGER DEFAULT 0,
    wiFi INTEGER DEFAULT 0,
    houseMaid INTEGER DEFAULT 0,
    numberOfBedrooms INTEGER,
    placeOwner integer NOT NULL REFERENCES User
);


CREATE TABLE Rent(
    rentID integer PRIMARY KEY,
    place integer NOT NULL REFERENCES Place,
    tourist integer REFERENCES User,
    price integer NOT NULL CHECK(price > 0),
    payed integer,
    accepted integer,
    startDate date NOT NULL,
    endDate date NOT NULL,
    CHECK(endDate >= startDate)
);


CREATE TABLE ExtraAmenities(
    amenitiesDescription TEXT NOT NULL,
    placeID integer NOT NULL REFERENCES Place
);


CREATE TABLE ExtraRestrictions(
    restrictionDescription TEXT NOT NULL,
    placeID integer NOT NULL REFERENCES Place
);


CREATE TABLE Comment(
    commentID integer PRIMARY KEY,
    placeID integer NOT NULL REFERENCES Place,
    writer integer NOT NULL REFERENCES User,
    classification integer NOT NULL CHECK (classification >= 1 AND classification <= 5),
    title text NOT NULL,
    comment text NOT NULL
);


CREATE TABLE DateAvailable(
    placeID integer NOT NULL REFERENCES Place,
    startDate date NOT NULL,
    endDate date NOT NULL,
    price integer NOT NULL CHECK(price > 0),
    CHECK(endDate >= startDate)
);


INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Joao", "joao@gmail.com", "dsdfaasf235", 30, 912345678); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Ricardo", "ricardo@gmail.com", "fhds03ndsklaq1",45,914994618); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Fernando", "fernando@gmail.com", "f5as12g35",19,924324346); /*tourist*/

INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Nice house" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",4, 1, 1, 1, 2, 1);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Cozy house" , "Nice rustic house with a beautiful village nearby and a river great for taking a bath as well for long walks . " , "Rua de Vila Nova", "Bragança",8, 1, 1, 0, 1, 2);
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Great Appartment" , "Amazing apartment, many rooms, very big and with a fantastic view to the beach and great acesses" , "Avenida da Praia", "Espinho",6, 0, 1, 1, 2, 1); 
INSERT INTO Place(title,placeDescription,placeAddress,area,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Nice house2" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",6, 0, 0, 0, 3, 1);

INSERT INTO DateAvailable(placeID, startDate, endDate, price) VALUES (1, '12-11-2019','20-12-2019', 50);

INSERT INTO Rent(place,tourist,price,startDate,endDate) VALUES (1,2,1000,'12-10-2019','20-10-2019');

INSERT INTO ExtraRestrictions(restrictionDescription, placeID) VALUES ("No pets allowed", 1);

INSERT INTO ExtraAmenities(amenitiesDescription, placeID) VALUES ("Has elevator", 2);

INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,2,4,"My stay","could improve");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,3,5,"Great!","Very Good");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (2,2,5,"Terrible place!","so much to improve ");
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Rent;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Available_Dates;
DROP TABLE IF EXISTS ExtraAmenities;
DROP TABLE IF EXISTS ExtraRestrictions;
DROP TABLE IF EXISTS PlaceImage;
DROP TABLE IF EXISTS RentMessage;

CREATE TABLE User(
    userID integer PRIMARY KEY,
    userName text NOT NULL,
    email text NOT NULL,
    passHash text NOT NULL,
    age date NOT NULL,
    phoneNumber text NOT NULL CHECK(length(phoneNumber) = 9),
    profilePicture TEXT DEFAULT "default"
);


CREATE TABLE Place(
    placeID integer PRIMARY KEY,
    title text NOT NULL,
    placeDescription text NOT NULL,
    placeAddress text NOT NULL,
    city text NOT NULL,
    maxGuests INTEGER NOT NULL,
    swimmingPool INTEGER DEFAULT 0,
    wiFi INTEGER DEFAULT 0,
    houseMaid INTEGER DEFAULT 0,
    numberOfBedrooms INTEGER,
    placeOwner integer NOT NULL REFERENCES User
);

CREATE TABLE PlaceImage(
    placeImageID integer PRIMARY KEY,
    placeID integer NOT NULL REFERENCES Place,
    imagePath text NOT NULL,
    imageDescription text NOT NULL
);


CREATE TABLE Rent(
    rentID integer PRIMARY KEY,
    place integer NOT NULL REFERENCES Place,
    tourist integer REFERENCES User,
    price integer NOT NULL CHECK(price > 0),
    payed integer DEFAULT 1,
    accepted integer DEFAULT 0,
    startDate date NOT NULL,
    endDate date NOT NULL
);

CREATE TABLE RentMessage(
    rentMessageID integer PRIMARY KEY,
    rentID integer NOT NULL REFERENCES Rent,
    userID integer NOT NULL REFERENCES User,
    comment text NOT NULL,
    commentDate Date NOT NULL
);


CREATE TABLE ExtraAmenities(
    amenitiesID integer PRIMARY KEY,
    amenitiesDescription TEXT NOT NULL,
    placeID integer NOT NULL REFERENCES Place
);


CREATE TABLE ExtraRestrictions(
    restrictionID integer PRIMARY KEY,
    restrictionDescription TEXT NOT NULL,
    placeID integer NOT NULL REFERENCES Place
);


CREATE TABLE Comment(
    commentID integer PRIMARY KEY,
    placeID integer NOT NULL REFERENCES Place,
    writer integer NOT NULL REFERENCES User,
    classification integer NOT NULL CHECK (classification >= 1 AND classification <= 5),
    title text NOT NULL,
    comment text NOT NULL,
    commentDate Date DEFAULT CURRENT_DATE
);


CREATE TABLE Available_Dates(
    Available_DatesID integer PRIMARY KEY,
    placeID integer NOT NULL REFERENCES Place,
    startDate date NOT NULL,
    endDate date NOT NULL,
    price integer NOT NULL CHECK(price > 0),
    CHECK(endDate >= startDate)
);


INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Gustavo", "torresgustam@gmail.com", "$2y$10$sy6xWzj7p3gVAcVNNxRanO53lS8Bsr7E192cu9CdzLbp7Hjlcdvpi", 20, 912345678); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Francisco", "francisco@gmail.com", "$2y$10$OH2eysuAXm.dIOmOHXa7g.momeoahr.iJQJRxMte/JNnOYAOulEl6",41,914994618); /*owner*/
INSERT INTO User(userName,email,passHash,age,phoneNumber) VALUES ("Rita", "rita@live.pt", "$2y$10$R2usXTENzn2sfEVsvI5qNeFjsgJBnLeznb2/ZbFOCk3Enztolo6OK",29,962774421); /*tourist*/

INSERT INTO Place(title,placeDescription,placeAddress,city,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Nice house" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",4, 1, 1, 1, 2, 1);
INSERT INTO Place(title,placeDescription,placeAddress,city,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Cozy house" , "Nice rustic house with a beautiful village nearby and a river great for taking a bath as well for long walks . " , "Rua de Vila Nova", "Bragança",8, 1, 1, 0, 1, 2);
INSERT INTO Place(title,placeDescription,placeAddress,city,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Great Appartment" , "Amazing apartment, many rooms, very big and with a fantastic view to the beach and great acesses" , "Avenida da Praia", "Espinho",6, 0, 1, 1, 2, 1); 
INSERT INTO Place(title,placeDescription,placeAddress,city,maxGuests,swimmingPool,wiFi,houseMaid,numberOfBedrooms,placeOwner) VALUES ("Nice house2" , "Very good house, with a nice view of the beach and good acess to everywhere, transportation near and supermarket 5minutes away by foot. Good neighbourhood and nice people. " , "Rua dfs", "Porto",6, 0, 0, 0, 3, 1);

INSERT INTO Available_Dates(placeID, startDate, endDate, price) VALUES (1, '2019-11-22','2019-11-25', 13);
INSERT INTO Available_Dates(placeID, startDate, endDate, price) VALUES (1, '2019-11-25','2019-11-28', 22);
INSERT INTO Available_Dates(placeID, startDate, endDate, price) VALUES (1, '2019-11-28','2019-11-29', 5);

INSERT INTO Rent(place,tourist,price,startDate,endDate) VALUES (1,2,1000,'2019-12-04','2019-12-13');

INSERT INTO ExtraRestrictions(restrictionDescription, placeID) VALUES ("No pets allowed", 1);

INSERT INTO ExtraAmenities(amenitiesDescription, placeID) VALUES ("Has elevator", 2);

INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,2,4,"My stay","could improve");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (1,3,5,"Great!","Very Good");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (3,3,5,"Great!","Very Good");
INSERT INTO Comment(placeID,writer,classification,title,comment) VALUES (2,3,5,"Terrible place!","so much to improve ");

INSERT INTO RentMessage(rentID,userId,comment,commentDate) VALUES (1, 1, "Vamos a isso", Date('now'));



/*Select *, 
max(0,julianday(min(endDate,'2019-11-30')) - julianday(max(startDate,'2019-11-25'))) * price 
from Available_Dates 
where placeId = 1 and endDate > '2019-11-25' and startDate < '2019-11-30';*/
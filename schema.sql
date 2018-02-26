DROP TABLE users;
CREATE TABLE users(
  id int primary key AUTO_INCREMENT NOT NULL,
  username varchar(20) NOT NULL,
  title char(10),
  first varchar(20) NOT NULL, 
  last varchar(20) NOT NULL,
  gender char(10),
  email varchar(50),
  handicap tinyint(3),
  ip varchar(25),
  currentPlayer Boolean,
  _password varchar(25),
  salt time
  );


INSERT INTO users VALUES(1, 'aliceW', 'miss', 'Alice', 'Walsh', 'female', 'a.walsh@warwick.ac.uk', 0, '7sjbf83w', 1, 'password', '828:20:54');
INSERT INTO users VALUES(null, 'King', 'miss', 'Rachael', 'King', 'female', 'k.walsh@warwick.ac.uk', 0, 'sdfdf', 1, 'password', '828:21:54');

  
DROP TABLE teams;
CREATE TABLE teams(
  id int(20)  primary key auto_increment NOT NULL, 
  teamName varchar(25), 
  playerIDs int(20),
  captainID int(20),
  level varchar(20),
  colours varchar(50),
  FOREIGN KEY (playerIDs) references users(id),
  FOREIGN KEY (captainID) references users(id));

DROP TABLE leagues;
CREATE TABLE leagues(
id int(20) primary key auto_increment NOT NULL ,
teamIDs int(20),
FOREIGN KEY (teamIDs) references teams(id)
);

DROP TABLE matches;
CREATE TABLE matches(
  id int(20) NOT NULL auto_increment primary key,
  firstTeamID int(20),
  secondTeamID int(20),
  firstTeamColours varchar(20),
  secondTeamColours varchar(20),
  pitch varchar(50),
  dateAndTime dateTime,
  resultID int(20),
  FOREIGN KEY (firstTeamID) references teams(id),
  FOREIGN KEY (secondTeamID) references teams(id)
  );

DROP TABLE tournaments;
CREATE TABLE tournaments(
  id int(20) NOT NULL auto_increment primary key,
  tournamentName varchar(50),
  startDate date,
  endDate date,
  location varchar(50),
  teamIDs int(20),
  leagues int(20),
  matches int(20),
  FOREIGN KEY (teamIDs) references teams(id),
  FOREIGN KEY (leagues) references leagues(id),
  FOREIGN KEY (matches) references matches(id)
  );

DROP TABLE results;
CREATE TABLE results(
  id int(20)  NOT NULL auto_increment primary key,
  firstTeamID int(20),
  secondTeamID int(20),
  firstTeamResult decimal(4,1),
  secondTeamResult decimal(4,1),
  FOREIGN KEY (firstTeamID) references teams(id),
  FOREIGN KEY (secondTeamID) references teams(id)
);

DROP TABLE tokens;
CREATE TABLE tokens(
id int(24) NOT NULL auto_increment primary key,
userID integer(24),
token varchar(64),
ip varchar(24),
generated dateTime,
validUntil dateTime,
FOREIGN KEY (userID) references users(id)
);

INSERT INTO tokens VALUES(1, 1, '1A', 'IP123', '1997-11-01 12:30:00', '2001-03-08 01:20:00');

DROP TABLE messages;
CREATE TABLE messages(
id int(24),
senderID int(24),
receiptID int(24),
subject varchar(255),
message varchar(1024),
uploadID int(25),
time_stamp timestamp,
ip varchar(24),
FOREIGN KEY (senderID) references users(id)
);
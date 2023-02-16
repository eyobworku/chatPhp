CREATE DATABASE if not exists read_group;
use read_group;

CREATE Table users(
id int PRIMARY key AUTO_INCREMENT,
user VARCHAR(50)
);

CREATE Table exists messages(
id int PRIMARY key AUTO_INCREMENT,
FromUser int,
ToUser int,
message VARCHAR(1000),
FOREIGN key(FromUser) REFERENCES users(id),
FOREIGN key(ToUser) REFERENCES users(id)
);

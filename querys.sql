create database twitter_clone CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use twitter_clone;

create table usuarios(
    id int not null primary key AUTO_INCREMENT,
    nome varchar(100) not null,
    email varchar(150) not null,
    senha varchar(32) not null
)

-- TWEET

create table tweets(
	id int not null primary key AUTO_INCREMENT,
    id_usuario int not null,
    tweet varchar(140) not null,
    data datetime default current_timestamp

);
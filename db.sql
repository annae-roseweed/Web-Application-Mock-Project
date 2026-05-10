CREATE DATABASE IF NOT EXISTS socialnet;
USE socialnet;

CREATE TABLE IF NOT EXISTS Account (
    id INT NOT NULL AUTO_INCREMENT,
    username TEXT NOT NULL,
    fullname TEXT NOT NULL,
    password TEXT NOT NULL,
    description TEXT NULL,
    PRIMARY KEY (id)
);

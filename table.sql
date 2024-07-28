create table users(
    username varchar(50) primary key,
    password varchar(100),
    name varchar(50),
    address varchar(50),
    heigth Double,
    weigth Double,
    phone_number varchar(11),
    date_of_birth DATE,
    job varchar(50),
    gender boolean,
    way2intro varchar(50)
);
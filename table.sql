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

create table session(
    id varchar(50) primary key,
    username varchar(50),
    date Date,
    total_time int,
    num_session int,
    time_sauna int,
    time_jacuzzi int,
    time_hydrotherapy int,
    time_massage int,
    FOREIGN KEY (username) REFERENCES users(username)
);

create table exersise(
    id varchar(50) primary key,
    title varchar(50),
    num_sets int,
    description varchar(100)
);

create table program(
    id varchar(50) primary key,
    title varchar(50),
    num_session int
);

create table program_user(
    username varchar(50),
    program_id varchar(50),
    start_time Date,
    practice_time Time,
    diagnosis varchar(200),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (program_id) REFERENCES program(id),
    UNIQUE key(username,program_id)
);

create table exersise_program(
    exersise_id varchar(50),
    program_id varchar(50),
    FOREIGN KEY (exersise_id) REFERENCES exersise(id),
    FOREIGN KEY (program_id) REFERENCES program(id)
);
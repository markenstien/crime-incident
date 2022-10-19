drop table if exists stations;
create table stations(
    id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    reference varchar(50) unique,
    name varchar(100),
    description text,
    hotline text,
    address text,
    lat varchar(100),
    lng varchar(100),
    chief varchar(50),
    is_active boolean DEFAULT true,

    created_at timestamp DEFAULT now(),
    created_by int(10)
);
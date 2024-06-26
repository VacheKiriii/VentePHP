drop database if exists audiconcess;

create database audiconcess;

use audiconcess;

drop table if exists products;
create table
    products (
        id integer not null,
        label varchar(256) not null,
        price float not null,
        inBasket integer,
        picture varchar(256),
        constraint pk_products primary key (id)
    );

insert into
    products (id, label, price, inBasket, picture)
values
    (
        1,
        "Audi S3",
        65000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\S3.png"
    ),
    (
        2,
        "Audi RS3",
        100000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\RS3.png"
    ),
    (
        3,
        "Audi RS6",
        150000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\RS6.png"
    ),
    (
        4,
        "Audi RS7",
        145000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\RS7.png"
    ),
    (
        5,
        "Audi R8 GT",
        200000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\R8.png"
    ),
    (
        6,
        "Audi RSQ8",
        130000,
        0,
        "C:\Users\Mathys\Desktop\dev\SiteDeVente\img\RSQ8.png"
    );

    select
        *
    from
        products;
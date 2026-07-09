create database findumois;
use findumois;

/*crée une table */

create table salaire(
    /*initier les variable
    id unique (primary key) qui s'incremente automatiquement*/
    id int auto_increment primary key,
    /* not null= obligatoire*/
    libelle varchar(255) not null,
    montant float not null,
);

create table depense(
    /*initier les variable
    id unique (primary key) qui s'incremente automatiquement*/
    id int auto_increment primary key,
    /* not null= obligatoire*/
    libelle varchar(255) not null,
    categorie varchar(255) not null,
    montant float not null,
);

create table epargne(
    /*initier les variable
    id unique (primary key) qui s'incremente automatiquement*/
    id int auto_increment primary key,
    /* not null= obligatoire*/
    periode date not null unique,
    reste float not null,
);
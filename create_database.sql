drop table if exists users;
create table users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    password VARCHAR(50),
    email VARCHAR(50)
);

drop table if exists products;
create table products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR(50),
    price DECIMAL(13,2),
    inventory INT,
    image VARCHAR(100)
);

drop table if exists orders;
create table orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    total DECIMAL(13,2),
    date DATE,
    FOREIGN KEY(userID) REFERENCES users(userID)
);

drop table if exists order_details;
create table order_details (
    contentID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    quantity INT,
    price DECIMAL(13,2),
    ship_date DATE,
    FOREIGN KEY(productID) REFERENCES products(productID)
);

insert into users (userID, firstName, lastName, password, email)
values (1, 'Bobby', 'Singer', 'singerauto', 'singerauto@gmail.com');

insert into products(productID, productName, price, inventory, image)
values (1, 'iPhone 8', '129.99', '38', 'images/iphone8');
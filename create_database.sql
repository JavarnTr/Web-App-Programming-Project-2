drop table if exists orders;
drop table if exists users;
drop table if exists order_details;
drop table if exists products;

create table users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(50),
    registration_date DATE
);

create table products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR(50),
    price DECIMAL(13,2),
    description VARCHAR(200),
    inventory INT,
    image VARCHAR(100)
);

create table orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    total DECIMAL(13,2),
    date DATE,
    FOREIGN KEY(userID) REFERENCES users(userID)
);

create table order_details (
    contentID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    quantity INT,
    price DECIMAL(13,2),
    FOREIGN KEY(productID) REFERENCES products(productID)
);

insert into products(productID, productName, price, description, inventory, image)
values (1, 'iPhone 8', '129.99', 'Reliable phone', '38', 'images/iphone8');
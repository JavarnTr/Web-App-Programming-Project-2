drop table if exists order_details;
drop table if exists products;
drop table if exists orders;
drop table if exists posts;
drop table if exists threads;
drop table if exists users;
drop table if exists categories;

create table users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(50),
    registration_date DATE,  
    admin BOOLEAN DEFAULT FALSE
);

create table categories (
    categoryID INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(50),
    description VARCHAR(200)
);

create table products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR(50),
    price DECIMAL(13,2),
    description VARCHAR(200),
    inventory INT,
    image VARCHAR(100),
    categoryID INT,
    FOREIGN KEY(categoryID) REFERENCES categories(categoryID)
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
    orderID INT,
    quantity INT,
    price DECIMAL(13,2),
    FOREIGN KEY(productID) REFERENCES products(productID),
    FOREIGN KEY(orderID) REFERENCES orders(orderID)
);

create table threads (
    threadID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    subject VARCHAR(50),
    FOREIGN KEY(userID) REFERENCES users(userID)
);

create table posts (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    threadID INT,
    userID INT,
    message VARCHAR(200),
    posted_on DATETIME,
    FOREIGN KEY(userID) REFERENCES users(userID),
    FOREIGN KEY(threadID) REFERENCES threads(threadID)
);

insert into categories(categoryID, categoryName, description)
values (1, 'Other', 'Other devices'),
    (2, 'iPhone', 'Apple devices'),
    (3, 'Samsung', 'Samsung devices'),
    (4, 'Google', 'Google devices');

insert into products(productID, productName, price, description, inventory, image, categoryID)
values (1, 'iPhone 8', '129.99', 'Reliable phone', '38', 'images/iphone8', 1),
        (2, 'Samsung S9', '430.99', 'Reliable phone', '38', 'images/samsungs9', 1),
        (3, 'Google Pixel 2', '129.99', 'Reliable phone', '38', 'images/googlepixel2', 1),
        (4, 'iPhone X', '129.99', 'Reliable phone', '38', 'images/iphonex', 1);

insert into users(userID, firstName, lastName, email, password, registration_date, admin)
values (1, 'John', 'Doe', 'johndoe@gmail.com', SHA1('password'), '2018-01-01', TRUE),
    (2, 'Jane', 'Doe', 'janedoe@gmail.com', SHA1('password'), '2018-01-01', FALSE),
    (3, 'Barry', 'Allen', 'Allen@gmail.com', SHA1('password'), '2018-01-01', FALSE),
    (4, 'Oliver', 'Queen', 'Oliver@gmail.com', SHA1('password'), '2018-01-01', FALSE),
    (5, 'Bruce', 'Wayne', 'Wayne@gmail.com', SHA1('password'), '2018-01-01', FALSE),
    (6, 'Clark', 'Kent', 'Kent@gmail.com', SHA1('password'), '2018-01-01', FALSE),
    (7, 'Tony', 'Stark', 'Stark@gmail.com', SHA1('password'), '2018-01-01', FALSE);


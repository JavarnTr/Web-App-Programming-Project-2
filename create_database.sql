drop table if exists products;
drop table if exists orders;
drop table if exists users;
drop table if exists order_details;


create table users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(50),
    languageID INT,
    registration_date DATE,
    FOREIGN KEY(languageID) REFERENCES languages(languageID)
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
    orderID INT,
    quantity INT,
    price DECIMAL(13,2),
    FOREIGN KEY(productID) REFERENCES products(productID),
    FOREIGN KEY(orderID) REFERENCES orders(orderID)
);

create table posts (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    threadID INT,
    userID INT,
    message VARCHAR(200),
    datePosted DATE,
    FOREIGN KEY(userID) REFERENCES users(userID),
    FOREIGN KEY(threadID) REFERENCES threads(threadID)
);

create table threads (
    threadID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    languageID INT,
    subject VARCHAR(50),
    FOREIGN KEY(userID) REFERENCES users(userID),
    FOREIGN KEY(languageID) REFERENCES languages(languageID)
);

create table languages (
    languageID INT AUTO_INCREMENT PRIMARY KEY,
    language VARCHAR(50),
    lang_eng VARCHAR(50)
);

create table words (
    wordID INT AUTO_INCREMENT PRIMARY KEY,
    languageID INT,
    title VARCHAR(50),
    intro VARCHAR(60),
    home VARCHAR(60),
    forum_home VARCHAR(40),
    language VARCHAR(50),
    register VARCHAR(50),
    login VARCHAR(50),
    logout VARCHAR(50),
    new_thread VARCHAR(50),
    subject VARCHAR(50),
    body VARCHAR(50),
    submit VARCHAR(50),
    posted_on VARCHAR(50),
    posted_by VARCHAR(50),
    replies VARCHAR(50),
    latest_reply VARCHAR(50),
    post_a_reply VARCHAR(50),
    FOREIGN KEY(languageID) REFERENCES languages(languageID)
);


insert into products(productID, productName, price, description, inventory, image)
values (1, 'iPhone 8', '129.99', 'Reliable phone', '38', 'images/iphone8');

insert into users(userID, firstName, lastName, email, password, registration_date)
values (1, 'John', 'Doe', 'johndoe@gmail.com', 'password', '2018-01-01');
## Script SQL

produits, utilisateurs, commandes, paniers et catégories

```SQL

--|| Tables ||--

CREATE TABLE Products (
    id_product SERIAL PRIMARY KEY,
    titre VARCHAR(50) NOT NULL,
    price NUMERIC(10, 2) NOT NULL,
    comment VARCHAR(400) 
);

CREATE TABLE Users (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE, 
    email VARCHAR(75) NOT NULL UNIQUE,  
    pwd VARCHAR(255) NOT NULL
);


CREATE TABLE Categories (
    id_category SERIAL PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL UNIQUE
);


ALTER TABLE Products
ADD COLUMN category_id INT,
ADD CONSTRAINT fk_category
FOREIGN KEY (category_id)
REFERENCES Categories(id_category);


CREATE TABLE Orders (
    id_order SERIAL PRIMARY KEY,
    id_user INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    total_price NUMERIC(10, 2),
    CONSTRAINT fk_user
        FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
);


CREATE TABLE Order_Items (
    id_order_item SERIAL PRIMARY KEY,
    id_order INT NOT NULL,
    id_product INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price NUMERIC(10, 2) NOT NULL,
    CONSTRAINT fk_order
        FOREIGN KEY (id_order)
        REFERENCES Orders(id_order),
    CONSTRAINT fk_product
        FOREIGN KEY (id_product)
        REFERENCES Products(id_product)
);

CREATE TABLE Carts (
    id_cart SERIAL PRIMARY KEY,
    id_user INT NOT NULL UNIQUE,
    CONSTRAINT fk_user_cart
        FOREIGN KEY (id_user)
        REFERENCES Users(id_user)
);

CREATE TABLE Cart_Items (
    id_cart_item SERIAL PRIMARY KEY,
    id_cart INT NOT NULL,
    id_product INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    UNIQUE (id_cart, id_product),
    CONSTRAINT fk_cart
        FOREIGN KEY (id_cart)
        REFERENCES Carts(id_cart),
    CONSTRAINT fk_product_cart
        FOREIGN KEY (id_product)
        REFERENCES Products(id_product)
);

-- ||Données ||--

INSERT INTO Categories (category_name) VALUES
('Électronique'),
('Vêtements'),
('Livres'),
('Maison & Jardin');

INSERT INTO Products (titre, price, comment, category_id) VALUES
('Écouteurs sans fil Pro', 129.99, 'Suppression active du bruit, autonomie de 24 heures.', 1);

INSERT INTO Products (titre, price, comment, category_id) VALUES
('T-shirt Coton Bio', 35.00, '100% coton biologique, coupe moderne et confortable.', 2);

INSERT INTO Products (titre, price, comment, category_id) VALUES
('Le Guide du SQL (édition 2025)', 24.50, 'Un guide complet pour maîtriser les requêtes SQL.', 3);

INSERT INTO Products (titre, price, comment, category_id) VALUES
('Lampe de bureau LED', 45.99, 'Intensité réglable, bras flexible et lumière chaude.', 4);

INSERT INTO Products (titre, price, comment, category_id) VALUES
('Smartphone Ultra X', 899.00, 'Écran OLED 6.7 pouces, triple appareil photo 50MP.', 1);

```
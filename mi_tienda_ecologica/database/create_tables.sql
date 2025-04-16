CREATE DATABASE IF NOT EXISTS tienda_ecologica;
USE tienda_ecologica;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  direccion VARCHAR(255),
  telefono VARCHAR(20),
  rol ENUM('cliente','admin') DEFAULT 'cliente'
);

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  descripcion TEXT,
  precio DECIMAL(10,2),
  categoria VARCHAR(100),
  imagen VARCHAR(255),
  stock INT DEFAULT 0
);

-- Tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  fecha DATETIME,
  total DECIMAL(10,2),
  estado VARCHAR(50) DEFAULT 'pendiente',
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla de detalles del pedido
CREATE TABLE IF NOT EXISTS pedido_detalles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT,
  producto_id INT,
  cantidad INT,
  precio_unitario DECIMAL(10,2),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id)
);

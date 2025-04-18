-- Crear base de datos
CREATE DATABASE IF NOT EXISTS tienda_ecologica DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda_ecologica;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  direccion VARCHAR(255),
  telefono VARCHAR(20),
  rol ENUM('cliente','admin') DEFAULT 'cliente',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de tokens para recuperación/reset
CREATE TABLE IF NOT EXISTS tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  token VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  expires_at DATETIME NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  categoria VARCHAR(100),
  imagen VARCHAR(255),
  stock INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10,2) NOT NULL,
  estado VARCHAR(50) DEFAULT 'pendiente',
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de detalles del pedido
CREATE TABLE IF NOT EXISTS pedido_detalles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Tabla de mensajes de contacto
CREATE TABLE IF NOT EXISTS mensajes_contacto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  mensaje TEXT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserción de frutas ecológicas
INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Manzana Fuji Ecológica', 'Manzanas Fuji cultivadas sin pesticidas, de sabor dulce y textura crujiente. Ricas en antioxidantes y perfectas para consumir frescas o en postres.', 1.50, 'Fruta', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Autumn_glory_apple_cultivar.jpg/960px-Autumn_glory_apple_cultivar.jpg?20201213191505', 120),
('Plátano Canario Bio', 'Plátanos de Canarias ecológicos, madurados al sol, con alto contenido en potasio y fibra. Ideales para meriendas y batidos.', 1.20, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/58.jpg', 150),
('Pera Conferencia Orgánica', 'Peras Conferencia de cultivo ecológico, jugosas y dulces, con piel fina y carne blanca. Excelentes para postres y ensaladas.', 1.80, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/60.jpg', 100),
('Naranja Valencia Bio', 'Naranjas Valencia ecológicas, de pulpa jugosa y sabor equilibrado. Ricas en vitamina C, perfectas para zumos y consumo directo.', 1.10, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/63.jpg', 200),
('Fresa Ecológica de Huelva', 'Fresas cultivadas en Huelva sin químicos, de aroma intenso y sabor dulce. Fuente de vitamina C y antioxidantes.', 2.50, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/64.jpg', 80),
('Kiwi Verde Orgánico', 'Kiwis verdes ecológicos, con alto contenido en vitamina C y fibra. Sabor ácido-dulce y textura suave.', 2.00, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/66.jpg', 90),
('Melocotón Amarillo Bio', 'Melocotones amarillos de cultivo ecológico, jugosos y aromáticos. Ricos en vitaminas A y C.', 2.20, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/67.jpg', 70),
('Uva Roja Sin Semilla Ecológica', 'Uvas rojas sin semilla, cultivadas ecológicamente. Dulces y crujientes, ideales para snacks y ensaladas.', 2.80, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/68.jpg', 110),
('Cereza Orgánica del Valle del Jerte', 'Cerezas del Valle del Jerte, recolectadas a mano y sin pesticidas. Sabor intenso y textura firme.', 3.00, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/69.jpg', 60),
('Mango Ecológico de Málaga', 'Mangos cultivados en Málaga de forma ecológica, con pulpa dulce y jugosa. Ricos en vitamina A y antioxidantes.', 2.50, 'Fruta', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/70.jpg', 75);

-- Inserción de verduras ecológicas
INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Zanahoria Ecológica', 'Zanahorias cultivadas sin químicos, ricas en betacarotenos y perfectas para crudos, sopas y guisos.', 0.90, 'Verdura', 'https://soycomocomo.es/media/2019/03/zanahorias.jpg', 180),
('Brócoli Orgánico', 'Brócoli fresco y ecológico, rico en fibra, hierro y vitamina C. Ideal para hervidos y platos al vapor.', 1.80, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/03.jpg', 120),
('Berenjena Bio', 'Berenjenas sin pesticidas de piel brillante y carne firme. Perfectas para asados, cremas y guarniciones.', 1.60, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/06.jpg', 90),
('Pimiento Rojo Ecológico', 'Pimientos rojos carnosos cultivados de forma natural. Muy ricos en vitamina C y antioxidantes.', 1.90, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/07.jpg', 130),
('Calabacín Orgánico', 'Calabacines tiernos y de textura suave. Fuente de agua y minerales. Perfectos para todo tipo de cocción.', 1.40, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/08.jpg', 140),
('Espinaca Ecológica', 'Espinacas frescas de hoja verde intensa, sin fertilizantes artificiales. Altamente nutritivas.', 1.30, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/10.jpg', 110),
('Lechuga Batavia Bio', 'Lechuga Batavia ecológica, crujiente y fresca. Ideal para ensaladas y acompañamientos.', 1.10, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/11.jpg', 100),
('Coliflor Orgánica', 'Coliflor de cultivo ecológico, de sabor suave y textura compacta. Ideal para hornear o gratinar.', 1.70, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/12.jpg', 85),
('Apio Verde Bio', 'Apio verde fresco, crujiente y sin pesticidas. Excelente para sopas, jugos y platos depurativos.', 1.20, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/13.jpg', 95),
('Remolacha Ecológica', 'Remolachas rojas dulces, de cultivo natural. Ricas en hierro, perfectas para jugos y ensaladas.', 1.50, 'Verdura', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/14.jpg', 70);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Perejil Ecológico', 'Perejil fresco de cultivo ecológico, rico en vitamina C. Ideal para dar frescura a sopas, carnes y guisos.', 0.80, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/24.jpg', 100),
('Albahaca Bio', 'Albahaca cultivada sin pesticidas, muy aromática y perfecta para pestos, ensaladas y pizzas.', 1.20, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/25.jpg', 90),
('Cilantro Orgánico', 'Cilantro fresco, usado en cocina latinoamericana y asiática. Alto contenido en antioxidantes.', 0.90, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/26.jpg', 80),
('Romero Ecológico', 'Romero silvestre, seco y fresco, ideal para asados, infusiones y marinados. Cultivado sin químicos.', 1.00, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/27.jpg', 85),
('Tomillo Bio', 'Tomillo seco y fresco de origen ecológico. Muy aromático, perfecto para guisos y platos de caza.', 1.10, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/28.jpg', 75),
('Orégano Ecológico', 'Orégano de montaña seco, muy intenso, sin aditivos. Ideal para pizzas, pastas y carnes.', 1.00, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/29.jpg', 70),
('Menta Fresca Bio', 'Menta cultivada orgánicamente, de aroma intenso. Ideal para tés, postres y cócteles.', 0.95, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/30.jpg', 65),
('Laurel Orgánico', 'Hojas de laurel secas de alta calidad. Muy aromáticas para guisos, lentejas y caldos.', 0.90, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/31.jpg', 100),
('Cebollino Ecológico', 'Cebollino fresco y picante, sin fertilizantes. Perfecto para decorar platos y añadir sabor.', 1.05, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/32.jpg', 90),
('Eneldo Bio', 'Eneldo fresco de aroma anisado, excelente para pescados, salsas y ensaladas.', 1.10, 'Hierbas Aromáticas', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/33.jpg', 60);



INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Patata Agria', 'Patatas ecológicas ideales para freír y cocer. Cultivadas sin pesticidas, de carne firme y sabor suave.', 1.50, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/49.jpg', 200),
('Patata Roja', 'Variedad de patata con piel rojiza, excelente para hervir y ensaladas. Rica en potasio.', 1.60, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/51.jpg', 150),
('Boniato Ecológico', 'Boniatos dulces de carne anaranjada, muy nutritivos. Perfectos para hornear o hacer puré.', 2.10, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/59.jpg', 120),
('Yuca Bio', 'Raíz tropical rica en almidón, sin pesticidas. Se consume cocida, frita o en puré.', 2.30, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/60.jpg', 90),
('Ñame Orgánico', 'Ñame de textura suave, ideal para platos africanos y caribeños. Muy saciante y sin gluten.', 2.50, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/61.jpg', 80),
('Zanahoria Morada', 'Zanahorias moradas con alto contenido en antocianinas. Sabor intenso, dulce y crujiente.', 1.80, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/62.jpg', 100),
('Jengibre Fresco', 'Raíz fresca de jengibre ecológico, perfecta para infusiones, cocina asiática y zumos.', 3.10, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/63.jpg', 60),
('Cúrcuma Fresca', 'Cúrcuma ecológica en raíz, con propiedades antiinflamatorias. Ideal para currys y batidos.', 3.40, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/64.jpg', 70),
('Chirivía Bio', 'Chirivía blanca dulce, alternativa a la zanahoria. Ideal para caldos y asados.', 1.90, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/65.jpg', 75),
('Remolacha Ecológica', 'Remolacha morada de cultivo ecológico, rica en hierro y antioxidantes. Perfecta para ensaladas.', 1.70, 'Tubérculo', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/66.jpg', 85);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Mango Ecológico', 'Mangos jugosos y aromáticos, ricos en vitamina A y C. Cultivados sin químicos.', 2.80, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/107.jpg', 90),
('Piña Ecológica', 'Piñas maduras de cultivo ecológico, sabor dulce y ácido. Excelente fuente de bromelina.', 2.50, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/108.jpg', 80),
('Papaya Bio', 'Papayas grandes y dulces con enzimas digestivas naturales. Textura suave, ideal para el desayuno.', 2.90, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/109.jpg', 70),
('Maracuyá (Fruta de la Pasión)', 'Fruta tropical con pulpa aromática, ideal para postres y zumos. Rica en antioxidantes.', 3.40, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/110.jpg', 60),
('Guayaba Bio', 'Guayabas rosadas y fragantes, altas en vitamina C. De pulpa firme y sabor tropical.', 2.70, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/111.jpg', 75),
('Litchi', 'Pequeñas frutas redondas con pulpa blanca dulce. Exóticas y refrescantes.', 3.20, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/112.jpg', 85),
('Pitahaya (Fruta del Dragón)', 'Fruta visualmente impactante, sabor suave y textura jugosa. Rica en fibra.', 3.80, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/113.jpg', 65),
('Granada Bio', 'Fruta de semillas brillantes con alto contenido antioxidante. Ideal en ensaladas o jugos.', 2.60, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/114.jpg', 70),
('Carambola (Fruta Estrella)', 'Fruta tropical con forma de estrella, sabor entre dulce y ácido. Muy decorativa.', 2.90, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/115.jpg', 50),
('Tamarindo', 'Vaina marrón con pulpa agridulce. Usada en salsas, bebidas y dulces naturales.', 3.10, 'Fruta Exótica', 'https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/116.jpg', 60);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Lentejas Pardinas Ecológicas', 'Lentejas pequeñas, suaves al cocer, ideales para guisos y potajes. Ricas en hierro.', 1.90, 'Legumbre', 'https://cdn0.ecologiaverde.com/es/posts/8/4/8/lentejas_propiedades_y_beneficios_248_600.jpg', 120),
('Garbanzos Bio', 'Garbanzos de grano mediano, ideales para hummus, cocido o ensaladas. Muy nutritivos.', 2.20, 'Legumbre', 'https://www.comedera.com/wp-content/uploads/2023/01/Garbanzos-cocidos-shutterstock_1445374936.jpg', 130),
('Alubias Blancas', 'Judías blancas ecológicas. Textura suave, perfectas para fabadas o estofados.', 2.00, 'Legumbre', 'https://www.hogarmania.com/archivos/202212/alubias-848x477x80xX.jpg', 100),
('Judión de La Granja', 'Judiones grandes, cremosos y de sabor intenso. Cultivo tradicional sin químicos.', 2.80, 'Legumbre', 'https://www.recetasderechupete.com/wp-content/uploads/2015/01/Judiones_de_la_granja_receta.jpg', 90),
('Soja Verde (Mung)', 'Legumbre rica en proteínas, perfecta para germinados o sopas asiáticas.', 2.40, 'Legumbre', 'https://frutaselhortelano.com/wp-content/uploads/2021/11/soja-verde-mung.jpg', 85),
('Alubias Negras', 'Judías negras con gran valor nutricional. Muy usadas en cocina mexicana y caribeña.', 2.10, 'Legumbre', 'https://www.pequerecetas.com/wp-content/uploads/2021/10/alubias-negras.jpg', 95),
('Lentejas Rojas', 'Lentejas sin piel, se cocinan rápidamente. Suaves y perfectas para sopas.', 2.00, 'Legumbre', 'https://cdn.shopify.com/s/files/1/0607/3548/2273/products/lenteja_roja_partida_organica_grande.jpg', 110),
('Azuki Ecológica', 'Legumbre japonesa dulce, ideal para postres o guisos saludables. Alta en fibra.', 3.10, 'Legumbre', 'https://static.wixstatic.com/media/2d3a0b_2df2759a46594eacafc7c1f016a87446~mv2.jpg', 70),
('Guisantes Secos Bio', 'Guisantes secos pelados para purés o cremas. Excelente fuente de proteína vegetal.', 1.95, 'Legumbre', 'https://comefruta.es/wp-content/uploads/2014/02/guisantes.jpg', 115),
('Lentejas Beluga', 'Lentejas negras pequeñas, textura firme y sabor suave. Conocidas como "el caviar vegetal".', 2.75, 'Legumbre', 'https://biogra.eco/wp-content/uploads/2021/11/Lenteja-beluga-eco-500g.png', 80);

INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Pan Integral de Centeno', 'Pan elaborado con harina de centeno integral ecológica. Rico en fibra, ideal para desayunos saludables.', 2.80, 'Panadería', 'https://www.recetasgratis.net/files/article/pan-de-centeno-ecologico.jpg', 60),
('Pan Multicereal', 'Mezcla de harinas integrales y semillas: lino, girasol, sésamo. Crujiente y saciante.', 3.00, 'Panadería', 'https://cdn1.recetasgratis.net/es/posts/3/1/5/pan_multicereal_casero_71513_600.jpg', 50),
('Barra de Pan Rústico Bio', 'Barra tradicional de corteza crujiente y miga esponjosa, cocida en horno de piedra.', 1.90, 'Panadería', 'https://images.hola.com/imagenes/cocina/recetas/20200826174286/pan-casero-rustico-receta/0-857-138/pan-rustico-adobe-m.jpg', 70),
('Mollete Integral', 'Mollete andaluz de masa suave, ideal para tostadas con aceite de oliva. Hecho con trigo eco.', 2.10, 'Panadería', 'https://cdn.cuponatic.com/images/deals/275476/0ee1bbebd789fd810b94a78b28bbdfde.jpg', 80),
('Pan de Espelta', 'Pan elaborado con espelta integral ecológica. Alternativa nutritiva al trigo convencional.', 3.20, 'Panadería', 'https://www.lavanguardia.com/files/article_main_microformat/uploads/2022/03/02/621f6e55ecb6a.jpeg', 65),
('Pan de Semillas sin Gluten', 'Pan sin gluten con semillas de chía, girasol y calabaza. Rico en omega-3.', 4.00, 'Panadería', 'https://staticcookist.akamaized.net/wp-content/uploads/sites/22/2022/08/Pan-de-semillas-y-nueces.jpg', 45),
('Pan de Avena', 'Pan suave y esponjoso con avena orgánica, ideal para acompañar platos o sándwiches.', 2.60, 'Panadería', 'https://www.gastrolabweb.com/u/fotografias/m/2023/4/10/f1280x720-60140_222332_5050.jpg', 55),
('Panecillos Integrales', 'Panecillos pequeños de harina integral para meriendas o desayunos ecológicos.', 2.30, 'Panadería', 'https://www.recetasgratis.net/files/article/panecillos-integrales-receta.jpg', 90),
('Pan de Higo y Nueces', 'Pan semidulce artesanal con trozos de higos y nueces ecológicas. Ideal con quesos.', 3.80, 'Panadería', 'https://www.recetin.com/files/2020/10/pan-higos-nueces.jpg', 40),
('Pan de Molde Bio', 'Clásico pan de molde orgánico, sin azúcares añadidos. Perfecto para tostadas y sandwiches.', 2.95, 'Panadería', 'https://www.cuerpomente.com/medio/2022/10/20/pan-de-molde-integral_2d16d17d_221020152223_800x800.jpg', 70);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Chips de Kale', 'Crujientes chips de col rizada deshidratada con sal marina. Snack bajo en calorías y lleno de antioxidantes.', 2.75, 'Snacks', 'https://www.loveandlemons.com/wp-content/uploads/2023/01/kale-chips.jpg', 70),
('Mix de Frutos Secos Bio', 'Mezcla de nueces, almendras, anacardos y pasas sin azúcares añadidos. Fuente natural de energía.', 3.50, 'Snacks', 'https://www.65ymas.com/uploads/s1/68/90/49/bigstock-healthy-nuts-mix-background-n-450065248.jpeg', 100),
('Barrita de Avena y Arándanos', 'Barrita energética artesanal con avena integral, miel y arándanos deshidratados.', 1.90, 'Snacks', 'https://cdn1.recetasgratis.net/es/posts/1/2/2/barritas_de_avena_y_arandanos_70221_600.jpg', 85),
('Chips de Batata al Horno', 'Chips finas de batata con aceite de oliva ecológico. Alternativa crujiente y saludable.', 2.40, 'Snacks', 'https://recetinas.com/wp-content/uploads/2021/02/chips-de-batata.jpg', 75),
('Galletas de Almendra Bio', 'Galletas veganas sin gluten elaboradas con almendra molida y sirope de agave.', 3.10, 'Snacks', 'https://nutricionsinmas.com/wp-content/uploads/2022/10/galletas-almendra-veganas.jpg', 90),
('Tortitas de Arroz Integral', 'Tortitas ligeras hechas 100% con arroz integral ecológico. Perfectas como base de snack.', 1.60, 'Snacks', 'https://www.nuevatribuna.es/media/nuevatribuna/images/2022/04/06/2022040611512612506.jpg', 110),
('Mix Frutas Deshidratadas', 'Troceado de mango, piña, manzana y plátano. Sin azúcares añadidos, ideal para picar.', 3.70, 'Snacks', 'https://5aldia.org/wp-content/uploads/2020/08/frutas-deshidratadas-1.jpg', 65),
('Bolitas Energéticas de Cacao', 'Pequeñas bolitas crudas con dátiles, cacao puro y semillas. Snack saciante sin procesar.', 2.90, 'Snacks', 'https://recetasveganas.net/wp-content/uploads/2020/06/bolas-energeticas-vegano-cacao.jpg', 60),
('Granola Casera Eco', 'Granola de avena, coco, canela y semillas. Crujiente, sin azúcares refinados.', 4.20, 'Snacks', 'https://i.blogs.es/1efdd1/granola-casera-receta/1366_2000.jpg', 70),
('Barritas de Semillas y Miel', 'Barritas crocantes con sésamo, chía y miel ecológica. Ricas en omega 3 y fibra.', 2.30, 'Snacks', 'https://static01.nyt.com/images/2022/08/15/dining/15asap-recipe/15asap-recipe-threeByTwoMediumAt2X.jpg', 55);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Zumo de Naranja Natural', 'Zumo exprimido de naranjas valencianas sin aditivos ni conservantes. Alto contenido en vitamina C.', 2.50, 'Bebidas', 'https://static.elcorreo.com/www/multimedia/202305/11/media/cortadas/zumo-naranja-3-RMlWfKNx04o8uQmeOit5Em1-1200x840@El%20Correo.jpg', 80),
('Leche de Almendras Bio', 'Leche vegetal sin azúcares añadidos ni conservantes. Apta para veganos y personas con intolerancia a la lactosa.', 2.90, 'Bebidas', 'https://nutricionsinmas.com/wp-content/uploads/2022/10/leche-almendras.jpg', 100),
('Infusión de Menta Ecológica', 'Mezcla natural de hojas de menta orgánicas. Refrescante y digestiva.', 1.70, 'Bebidas', 'https://cdn.shopify.com/s/files/1/0247/3181/4585/articles/menta_infusiones.jpg?v=1679996247', 90),
('Té Verde Matcha en Polvo', 'Matcha japonés de alta calidad. Ideal para preparar bebidas energizantes o recetas saludables.', 4.60, 'Bebidas', 'https://www.totallyveganbuzz.com/wp-content/uploads/2021/07/matcha-tea.jpg', 60),
('Zumo de Granada', 'Zumo 100% de granada ecológica, antioxidante y revitalizante. Ideal en ayunas.', 3.40, 'Bebidas', 'https://www.elperiodicodearagon.com/binrepository/960x640/0c0/0d0/none/12605/JZVH/zumo-de-granada-2_11223827_20221101102240.jpg', 70),
('Kombucha de Frutos Rojos', 'Bebida fermentada con probióticos naturales. Mejora la digestión y fortalece el sistema inmune.', 3.90, 'Bebidas', 'https://images.hola.com/imagenes/cocina/noticiaslibros/20220721214117/como-hacer-kombucha-casera/1-110-395/kombucha-m.jpg', 50),
('Leche de Avena sin Azúcar', 'Alternativa vegetal suave y cremosa. Ideal para cafés, batidos o repostería.', 2.40, 'Bebidas', 'https://s1.abcstatics.com/media/bienestar/2021/06/14/leche-de-avena-kA1H--1200x630@abc.jpg', 85),
('Agua de Coco Natural', 'Bebida isotónica ecológica, ideal para rehidratación tras ejercicio físico. 100% coco.', 2.80, 'Bebidas', 'https://recetinas.com/wp-content/uploads/2020/03/agua-de-coco.jpg', 65),
('Té Chai con Especias', 'Mezcla de té negro ecológico con canela, jengibre, clavo y cardamomo. Aroma intenso y reconfortante.', 3.20, 'Bebidas', 'https://www.gastrolabweb.com/u/fotografias/m/2023/2/28/f960x540-29684_90042_5050.jpg', 70),
('Smoothie Verde Detox', 'Smoothie embotellado de espinacas, manzana, pepino y limón. Refrescante y depurativo.', 4.00, 'Bebidas', 'https://img.freepik.com/fotos-premium/smoothie-verde-espinaca-kiwi-manzana-pepino-sano_128263-3728.jpg', 45);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Aceite de Oliva Virgen Extra', 'Aceite prensado en frío de oliva ecológica. Ideal para aliños, guisos y cocina mediterránea.', 6.90, 'Otros', 'https://cdn.hsnstore.com/blog/wp-content/uploads/2020/10/aceite-de-oliva-virgen-extra-beneficios.jpg', 90),
('Semillas de Chía', 'Ricas en omega-3, fibra y proteínas vegetales. Perfectas para yogures, batidos y repostería.', 3.10, 'Otros', 'https://biotrendies.com/wp-content/uploads/2016/04/semillas-chia.jpg', 70),
('Harina Integral de Espelta', 'Harina ecológica de espelta molida a piedra. Ideal para panes, pizzas y repostería saludable.', 2.80, 'Otros', 'https://canalcocina.es/medias/images/0000102677HarinaEspelta_620.jpg', 65),
('Copos de Avena Bio', 'Avena integral ecológica rica en fibra y sin azúcares añadidos. Ideal para desayunos y barritas.', 2.60, 'Otros', 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/oats-product-label-design-template-548ac9e8f002f88a6e055fc6bb8d6d4f_screen.jpg', 85),
('Vinagre de Manzana Ecológico', 'Fermentado naturalmente. Excelente para ensaladas, adobos y salud digestiva.', 3.20, 'Otros', 'https://cdn.shopify.com/s/files/1/0282/1444/8311/products/ACV500ml.jpg?v=1667301287', 50),
('Panela Orgánica Molida', 'Endulzante natural sin refinar, obtenido del jugo de caña de azúcar. Sustituto saludable del azúcar.', 2.50, 'Otros', 'https://www.ecocash.com.co/wp-content/uploads/2020/04/panela-organica-en-polvo-ecologica.jpg', 60),
('Quinoa Tricolor Bio', 'Fuente completa de proteínas vegetales, perfecta para ensaladas, bowls o guarniciones.', 4.10, 'Otros', 'https://nutricionsinmas.com/wp-content/uploads/2022/11/quinoa.jpg', 75),
('Lentejas Rojas Ecológicas', 'Legumbre rica en hierro y fácil de digerir. Cocción rápida y sin piel.', 2.20, 'Otros', 'https://www.ecorganicweb.com/images/stories/virtuemart/product/LENTEJA-ROJA.jpg', 90),
('Cúrcuma en Polvo Bio', 'Condimento natural con propiedades antiinflamatorias. Usado en currys, caldos y batidos.', 1.80, 'Otros', 'https://cdn.shopify.com/s/files/1/0274/2393/3943/products/curcuma-bio_1200x.jpg?v=1628794297', 70),
('Cacao Puro en Polvo', 'Cacao 100% sin azúcar añadido. Ideal para repostería, smoothies o preparar chocolate caliente.', 3.90, 'Otros', 'https://delibutus.com/wp-content/uploads/2019/10/CACAO-PURO-EN-POLVO.jpg', 85);


-- Puedes continuar duplicando este formato para llegar a 100 productos.

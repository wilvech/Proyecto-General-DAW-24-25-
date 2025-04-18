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
('Plátano Canario Bio', 'Plátanos de Canarias ecológicos, madurados al sol, con alto contenido en potasio y fibra. Ideales para meriendas y batidos.', 1.20, 'Fruta', 'https://www.ecorigen.es/685-large_default/platano-de-canarias.jpg', 150),
('Pera Conferencia Orgánica', 'Peras Conferencia de cultivo ecológico, jugosas y dulces, con piel fina y carne blanca. Excelentes para postres y ensaladas.', 1.80, 'Fruta', 'https://media.gualgarden.com/product/pera-conference-c-42-italia-800x800.jpg?width=1200', 100),
('Naranja Valencia Bio', 'Naranjas Valencia ecológicas, de pulpa jugosa y sabor equilibrado. Ricas en vitamina C, perfectas para zumos y consumo directo.', 1.10, 'Fruta', 'https://www.naranjastradicionales.es/813-large_default/20-kg-de-naranjas-de-mesa-lane-late.jpg', 200),
('Fresa Ecológica de Huelva', 'Fresas cultivadas en Huelva sin químicos, de aroma intenso y sabor dulce. Fuente de vitamina C y antioxidantes.', 2.50, 'Fruta', 'https://www.ecorigen.es/762-thickbox_default/freson.jpg', 80),
('Kiwi Verde Orgánico', 'Kiwis verdes ecológicos, con alto contenido en vitamina C y fibra. Sabor ácido-dulce y textura suave.', 2.00, 'Fruta', 'https://disfrutaverdura.com/3686-product_thumbnails/kiwi-verde-ecologico-800g.jpg', 90),
('Melocotón Amarillo Bio', 'Melocotones amarillos de cultivo ecológico, jugosos y aromáticos. Ricos en vitaminas A y C.', 2.20, 'Fruta', 'https://media.floresfrescasonline.com/product/melocotonero-de-calanda-800x800_Z7lCEkM.jpg?width=1200', 70),
('Uva Roja Sin Semilla Ecológica', 'Uvas rojas sin semilla, cultivadas ecológicamente. Dulces y crujientes, ideales para snacks y ensaladas.', 2.80, 'Fruta', 'https://media.gualgarden.com/product/parra-sin-pepita-roja-vitis-vinifera-46-c-19-800x800.jpg?width=1200', 110),
('Cereza Orgánica del Valle del Jerte', 'Cerezas del Valle del Jerte, recolectadas a mano y sin pesticidas. Sabor intenso y textura firme.', 3.00, 'Fruta', 'https://media.floresfrescasonline.com/product/cerezos-picota-800x800.jpg?width=1200', 60),
('Mango Ecológico de Málaga', 'Mangos cultivados en Málaga de forma ecológica, con pulpa dulce y jugosa. Ricos en vitamina A y antioxidantes.', 2.50, 'Fruta', 'https://media.floresfrescasonline.com/product/mangifera-indica-mango-800x800_AXOEaAt.jpg?width=1200', 75);

-- Inserción de verduras ecológicas
INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Zanahoria Ecológica', 'Zanahorias cultivadas sin químicos, ricas en betacarotenos y perfectas para crudos, sopas y guisos.', 0.90, 'Verdura', 'https://www.ecorigen.es/669-thickbox_default/zanahoria.jpg', 180),
('Brócoli Orgánico', 'Brócoli fresco y ecológico, rico en fibra, hierro y vitamina C. Ideal para hervidos y platos al vapor.', 1.80, 'Verdura', 'https://biogo.es/cdn/shop/products/87243.jpg?v=1659994575', 120),
('Berenjena Bio', 'Berenjenas sin pesticidas de piel brillante y carne firme. Perfectas para asados, cremas y guarniciones.', 1.60, 'Verdura', 'https://www.terrasdemiranda.es/742-large_default/berenjena.jpg', 90),
('Pimiento Rojo Ecológico', 'Pimientos rojos carnosos cultivados de forma natural. Muy ricos en vitamina C y antioxidantes.', 1.90, 'Verdura', 'https://somosfruta.es/274-large_default/pimiento-rojo.jpg', 130),
('Calabacín Orgánico', 'Calabacines tiernos y de textura suave. Fuente de agua y minerales. Perfectos para todo tipo de cocción.', 1.40, 'Verdura', 'https://somosfruta.es/283-large_default/calabacin.jpg', 140),
('Espinaca Ecológica', 'Espinacas frescas de hoja verde intensa, sin fertilizantes artificiales. Altamente nutritivas.', 1.30, 'Verdura', 'https://img.joomcdn.net/a35b7369a3b7b1b716af4f8479039396b6a44868_1024_1024.jpeg', 110),
('Lechuga Batavia Bio', 'Lechuga Batavia ecológica, crujiente y fresca. Ideal para ensaladas y acompañamientos.', 1.10, 'Verdura', 'https://shop.nortene.es/media/catalog/product/cache/f1d8896918e1fa1369f04c5295aeb544/7/2/72020068_1.jpg', 100),
('Coliflor Orgánica', 'Coliflor de cultivo ecológico, de sabor suave y textura compacta. Ideal para hornear o gratinar.', 1.70, 'Verdura', 'https://media.floresfrescasonline.com/product/plantel-coliflor-800x800.jpeg?width=1200', 85),
('Apio Verde Bio', 'Apio verde fresco, crujiente y sin pesticidas. Excelente para sopas, jugos y platos depurativos.', 1.20, 'Verdura', 'https://juangomezseleccion.com/988-large_default/manojo-entero-de-apio-.jpg', 95),
('Remolacha Ecológica', 'Remolachas rojas dulces, de cultivo natural. Ricas en hierro, perfectas para jugos y ensaladas.', 1.50, 'Verdura', 'https://i.etsystatic.com/34277826/r/il/72813a/3861654515/il_1140xN.3861654515_8ei5.jpg', 70);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Perejil Ecológico', 'Perejil fresco de cultivo ecológico, rico en vitamina C. Ideal para dar frescura a sopas, carnes y guisos.', 0.80, 'https://img.joomcdn.net/950b354ff1db9b093d787f920360da8ef4f81f27_original.jpeg', 100),
('Albahaca Bio', 'Albahaca cultivada sin pesticidas, muy aromática y perfecta para pestos, ensaladas y pizzas.', 1.20, 'Hierbas Aromáticas', 'https://the-growers.com/wp-content/uploads/2019/04/Basil-Leaves-Closeup.jpg', 90),
('Cilantro Orgánico', 'Cilantro fresco, usado en cocina latinoamericana y asiática. Alto contenido en antioxidantes.', 0.90, 'Hierbas Aromáticas', 'https://freshleafuae.com/wp-content/uploads/2024/10/Coriander-leaves-loose-uae-freshleaf-dubai-uae-img01.jpg', 80),
('Romero Ecológico', 'Romero silvestre, seco y fresco, ideal para asados, infusiones y marinados. Cultivado sin químicos.', 1.00, 'Hierbas Aromáticas', 'https://nutritionfacts.org/app/uploads/2019/03/Rosemary.jpg', 85),
('Tomillo Bio', 'Tomillo seco y fresco de origen ecológico. Muy aromático, perfecto para guisos y platos de caza.', 1.10, 'Hierbas Aromáticas', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Starr-080812-9700-Thymus_vulgaris-leaves-Makawao-Maui_%2824807095872%29.jpg/800px-Starr-080812-9700-Thymus_vulgaris-leaves-Makawao-Maui_%2824807095872%29.jpg', 75),
('Orégano Ecológico', 'Orégano de montaña seco, muy intenso, sin aditivos. Ideal para pizzas, pastas y carnes.', 1.00, 'Hierbas Aromáticas', 'https://media.catereasy.es/product/oregano-en-hojas-800x800.jpeg?width=1200', 70),
('Menta Fresca Bio', 'Menta cultivada orgánicamente, de aroma intenso. Ideal para tés, postres y cócteles.', 0.95, 'Hierbas Aromáticas', 'https://i.etsystatic.com/22157575/r/il/373145/2942432642/il_1140xN.2942432642_ruk3.jpg', 65),
('Laurel Orgánico', 'Hojas de laurel secas de alta calidad. Muy aromáticas para guisos, lentejas y caldos.', 0.90, 'Hierbas Aromáticas', 'https://media.floresfrescasonline.com/product/ramo-de-laurel-800x800.jpg?width=1200', 100),
('Cebollino Ecológico', 'Cebollino fresco y picante, sin fertilizantes. Perfecto para decorar platos y añadir sabor.', 1.05, 'Hierbas Aromáticas', 'https://www.gastronomiavasca.net/uploads/image/file/3340/w700_cebollino.jpg', 90),
('Eneldo Bio', 'Eneldo fresco de aroma anisado, excelente para pescados, salsas y ensaladas.', 1.10, 'Hierbas Aromáticas', 'https://imag.bonviveur.com/hojas-de-enebro-sobre-una-mesa-de-cocina.jpg', 60);



INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Patata Agria', 'Patatas ecológicas ideales para freír y cocer. Cultivadas sin pesticidas, de carne firme y sabor suave.', 1.50, 'Tubérculo', 'https://patatasfritasjalys.es/wp-content/uploads/comprar-patata-agria-online-patatas-fritas-jalys-1.jpg', 200),
('Patata Roja', 'Variedad de patata con piel rojiza, excelente para hervir y ensaladas. Rica en potasio.', 1.60, 'Tubérculo', 'https://www.calfruitos.com/fotos/pr_1217_20170919154315.png', 150),
('Boniato Ecológico', 'Boniatos dulces de carne anaranjada, muy nutritivos. Perfectos para hornear o hacer puré.', 2.10, 'Tubérculo', 'https://i.blogs.es/4e7768/boniato-1/1366_2000.jpg', 120),
('Yuca Bio', 'Raíz tropical rica en almidón, sin pesticidas. Se consume cocida, frita o en puré.', 2.30, 'Tubérculo', 'https://imag.bonviveur.com/varios-ejemplares-de-yuca-o-mandioca-enteros-y-sin-pelar.jpg', 90),
('Ñame Orgánico', 'Ñame de textura suave, ideal para platos africanos y caribeños. Muy saciante y sin gluten.', 2.50, 'Tubérculo', 'https://nectarfruit.es/wp-content/uploads/2023/01/name.jpg', 80),
('Zanahoria Morada', 'Zanahorias moradas con alto contenido en antocianinas. Sabor intenso, dulce y crujiente.', 1.80, 'Tubérculo', 'https://vilaaurora.es/images/productos/zanahoria-morada.jpg?1613056368', 100),
('Jengibre Fresco', 'Raíz fresca de jengibre ecológico, perfecta para infusiones, cocina asiática y zumos.', 3.10, 'Tubérculo', 'https://solnatural.bio/views/img/recipesphotos/80.jpg', 60),
('Cúrcuma Fresca', 'Cúrcuma ecológica en raíz, con propiedades antiinflamatorias. Ideal para currys y batidos.', 3.40, 'Tubérculo', 'https://www.plameca.com//uploads/2016/01/curcuma_blog1-1024x683.jpg', 70),
('Chirivía Bio', 'Chirivía blanca dulce, alternativa a la zanahoria. Ideal para caldos y asados.', 1.90, 'Tubérculo', 'https://blogs.oximesa.es/wp-content/uploads/2020/01/Conoces-la-chiriv%C3%ADa-o-pastinaca.jpg', 75),
('Remolacha Ecológica', 'Remolacha morada de cultivo ecológico, rica en hierro y antioxidantes. Perfecta para ensaladas.', 1.70, 'Tubérculo', 'https://fruteriadevalencia.com/wp-content/uploads/2015/01/FRESCA-buena.jpg', 85);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Mango Ecológico', 'Mangos jugosos y aromáticos, ricos en vitamina A y C. Cultivados sin químicos.', 2.80, 'Fruta Exótica', 'https://exoticfruitbox.com/wp-content/uploads/2015/10/mango.jpg', 90),
('Piña Ecológica', 'Piñas maduras de cultivo ecológico, sabor dulce y ácido. Excelente fuente de bromelina.', 2.50, 'Fruta Exótica', 'https://static.libertyprim.com/files/familles/ananas-large.jpg?1569271716', 80),
('Papaya Bio', 'Papayas grandes y dulces con enzimas digestivas naturales. Textura suave, ideal para el desayuno.', 2.90, 'Fruta Exótica', 'https://saludvivatiendagranel.es/wp-content/uploads/2020/08/Papaya-trozos.jpg', 70),
('Maracuyá (Fruta de la Pasión)', 'Fruta tropical con pulpa aromática, ideal para postres y zumos. Rica en antioxidantes.', 3.40, 'Fruta Exótica', 'https://okdiario.com/metabolic/wp-content/uploads/2024/04/maracuya2.jpg', 60),
('Guayaba Bio', 'Guayabas rosadas y fragantes, altas en vitamina C. De pulpa firme y sabor tropical.', 2.70, 'Fruta Exótica', 'https://nectarfruit.es/wp-content/uploads/2020/06/shutterstock_1278486652.jpg', 75),
('Litchi', 'Pequeñas frutas redondas con pulpa blanca dulce. Exóticas y refrescantes.', 3.20, 'Fruta Exótica', 'https://elnougarden.com/cdn/shop/files/litchi2.jpg?v=1739791369', 85),
('Pitahaya (Fruta del Dragón)', 'Fruta visualmente impactante, sabor suave y textura jugosa. Rica en fibra.', 3.80, 'Fruta Exótica', 'https://fruiver.com/wp-content/uploads/2021/10/D_NQ_NP_751283-MPE40869476028_022020-O.jpg', 65),
('Granada Bio', 'Fruta de semillas brillantes con alto contenido antioxidante. Ideal en ensaladas o jugos.', 2.60, 'Fruta Exótica', 'https://exoticfruitbox.com/wp-content/uploads/2015/10/granada.jpg', 70),
('Carambola (Fruta Estrella)', 'Fruta tropical con forma de estrella, sabor entre dulce y ácido. Muy decorativa.', 2.90, 'Fruta Exótica', 'https://cdn.myshoptet.com/usr/www.ostrovchuti.cz/user/shop/big/534-1_bio-carambola.jpg?661fbbd9', 50),
('Tamarindo', 'Vaina marrón con pulpa agridulce. Usada en salsas, bebidas y dulces naturales.', 3.10, 'Fruta Exótica', 'https://www.publico.es/ahorro-consumo-responsable/wp-content/uploads/2021/04/tamarind.jpg', 60);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Lentejas Pardinas Ecológicas', 'Lentejas pequeñas, suaves al cocer, ideales para guisos y potajes. Ricas en hierro.', 1.90, 'Legumbre', 'https://i.blogs.es/5d207c/pardinas3/1366_2000.jpg', 120),
('Garbanzos Bio', 'Garbanzos de grano mediano, ideales para hummus, cocido o ensaladas. Muy nutritivos.', 2.20, 'Legumbre', 'https://migranitodeavena.com/wp-content/uploads/2023/10/0125-GARBANZO_PEDROSILLANO_BIO-1.jpg', 130),
('Alubias Blancas', 'Judías blancas ecológicas. Textura suave, perfectas para fabadas o estofados.', 2.00, 'Legumbre', 'https://www.carniceriademadrid.es/wp-content/uploads/2023/03/alubias_blancas.jpg', 100),
('Judión de La Granja', 'Judiones grandes, cremosos y de sabor intenso. Cultivo tradicional sin químicos.', 2.80, 'Legumbre', 'https://www.aperitivoslareal.com/wp-content/uploads/2019/12/739-Judi%C3%B3n-de-la-granja-1200x799.jpg', 90),
('Soja Verde (Mung)', 'Legumbre rica en proteínas, perfecta para germinados o sopas asiáticas.', 2.40, 'Legumbre', 'https://www.elmaragato.com/media/zoo/images/26-soja_ef0ed9f688584929f248872b7bf21fc5.jpg', 85),
('Alubias Negras', 'Judías negras con gran valor nutricional. Muy usadas en cocina mexicana y caribeña.', 2.10, 'Legumbre', 'https://casaterra.es/wp-content/uploads/2020/03/Tolosana-Negra.jpg', 95),
('Lentejas Rojas', 'Lentejas sin piel, se cocinan rápidamente. Suaves y perfectas para sopas.', 2.00, 'Legumbre', 'https://images.ecestaticos.com/T6fyNWdevEqmLHltgE1d5-0eH0Y=/0x123:2096x1302/1200x900/filters:fill(white):format(jpg)/f.elconfidencial.com%2Foriginal%2F99c%2Faea%2Fd85%2F99caead85629c89ff139b501f83dc115.jpg', 110),
('Azuki Ecológica', 'Legumbre japonesa dulce, ideal para postres o guisos saludables. Alta en fibra.', 3.10, 'Legumbre', 'https://bongranel.es/wp-content/uploads/2021/03/azuki.jpg', 70),
('Guisantes Secos Bio', 'Guisantes secos pelados para purés o cremas. Excelente fuente de proteína vegetal.', 1.95, 'Legumbre', 'https://www.frutaspablosonline.es/wp-content/uploads/2020/04/1318-1927-Guisantes-Pelados-Frescos-Bandeja-de-400gr-300x300.jpg', 115),
('Lentejas Beluga', 'Lentejas negras pequeñas, textura firme y sabor suave. Conocidas como "el caviar vegetal".', 2.75, 'Legumbre', 'https://www.raonsdepes.es/productos/imagenes/img_1560_e6898058c91ae031f9d773441cd2d5f9_20.jpg', 80);

INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Pan Integral de Centeno', 'Pan elaborado con harina de centeno integral ecológica. Rico en fibra, ideal para desayunos saludables.', 2.80, 'Panadería', 'https://cdn0.uncomo.com/es/posts/0/2/0/como_hacer_pan_de_centeno_26020_orig.jpg', 60),
('Pan Multicereal', 'Mezcla de harinas integrales y semillas: lino, girasol, sésamo. Crujiente y saciante.', 3.00, 'Panadería', 'https://www.tisanajaen.es/sites/default/files/styles/recetas_slideshow/public/imagenes_recetas/pan_multicereal.jpg?itok=vpF_bA_L', 50),
('Barra de Pan Rústico Bio', 'Barra tradicional de corteza crujiente y miga esponjosa, cocida en horno de piedra.', 1.90, 'Panadería', 'https://media.scoolinary.app/recipes/images/2023/10/4-3.jpg', 70),
('Mollete Integral', 'Mollete andaluz de masa suave, ideal para tostadas con aceite de oliva. Hecho con trigo eco.', 2.10, 'Panadería', 'https://biopan.info/wp-content/uploads/molletes-espelta-con-harina-integral-2-scaled.jpg', 80),
('Pan de Espelta', 'Pan elaborado con espelta integral ecológica. Alternativa nutritiva al trigo convencional.', 3.20, 'Panadería', 'https://panaderiasimon.es/wp-content/uploads/2023/01/PANADERIA_SIMON__0007_Pan-espelta-integral-2.jpg', 65),
('Pan de Semillas sin Gluten', 'Pan sin gluten con semillas de chía, girasol y calabaza. Rico en omega-3.', 4.00, 'Panadería', 'https://lolialliati.com/wp-content/uploads/2022/03/Portada-Blog-1200x1200-3.jpg', 45),
('Pan de Avena', 'Pan suave y esponjoso con avena orgánica, ideal para acompañar platos o sándwiches.', 2.60, 'Panadería', 'https://www.nutricienta.com/imagenes/alimentos/alimento-nutricienta-pan-de-avena.jpg', 55),
('Panecillos Integrales', 'Panecillos pequeños de harina integral para meriendas o desayunos ecológicos.', 2.30, 'Panadería', 'https://cdn-consum.aktiosdigitalservices.com/tol/consum/media/product/img/300x300/7444099_001.jpg?t=20240620091501', 90),
('Pan de Higo y Nueces', 'Pan semidulce artesanal con trozos de higos y nueces ecológicas. Ideal con quesos.', 3.80, 'Panadería', 'https://preview.redd.it/vgcn2awdz8d71.jpg?width=640&crop=smart&auto=webp&s=4a6c6b19a9709b00ad3c92011602554946a1478f', 40),
('Pan de Molde Bio', 'Clásico pan de molde orgánico, sin azúcares añadidos. Perfecto para tostadas y sandwiches.', 2.95, 'Panadería', 'https://d22fxaf9t8d39k.cloudfront.net/fc052c83ce0d8c860a6c13402b1a635278ac7e33a90393548f880578a8c2cd76245686.jpg', 70);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Chips de Kale', 'Crujientes chips de col rizada deshidratada con sal marina. Snack bajo en calorías y lleno de antioxidantes.', 2.75, 'Snacks', 'https://www.natursnacks.es/cdn/shop/products/ChipsdeKaleVeggie.png?v=1619522819', 70),
('Mix de Frutos Secos Bio', 'Mezcla de nueces, almendras, anacardos y pasas sin azúcares añadidos. Fuente natural de energía.', 3.50, 'Snacks', 'https://comedelahuerta.com/wp-content/uploads/2019/10/MIX-FRUTOS-SECOS-ECOLOGICO-COMEDELAHUERTA-1.jpg', 100),
('Barrita de Avena y Arándanos', 'Barrita energética artesanal con avena integral, miel y arándanos deshidratados.', 1.90, 'Snacks', 'https://mejorconsalud.as.com/wp-content/uploads/2021/03/barra-arandanos-nueces.jpg', 85),
('Chips de Batata al Horno', 'Chips finas de batata con aceite de oliva ecológico. Alternativa crujiente y saludable.', 2.40, 'Snacks', 'https://dietamediterranea.com/wp-content/uploads/2023/01/sweet-potato-1804451-2000x1333.jpg', 75),
('Galletas de Almendra Bio', 'Galletas veganas sin gluten elaboradas con almendra molida y sirope de agave.', 3.10, 'Snacks', 'https://d3gr7hv60ouvr1.cloudfront.net/CACHE/images/products/7487a5f8c75942448654dcda2bc70d43/f0cc6e2772a079ac42288a20b809606f.jpg', 90),
('Tortitas de Arroz Integral', 'Tortitas ligeras hechas 100% con arroz integral ecológico. Perfectas como base de snack.', 1.60, 'Snacks', 'https://img-global.cpcdn.com/recipes/ae9ffc70eaa7bde1/1200x630cq70/photo.jpg', 110),
('Mix Frutas Deshidratadas', 'Troceado de mango, piña, manzana y plátano. Sin azúcares añadidos, ideal para picar.', 3.70, 'Snacks', 'https://roserclapes.com/467-large_default/mezcla-de-frutas-deshidratadas-sin-azucares-anadidos.jpg', 65),
('Bolitas Energéticas de Cacao', 'Pequeñas bolitas crudas con dátiles, cacao puro y semillas. Snack saciante sin procesar.', 2.90, 'Snacks', 'https://d36fw6y2wq3bat.cloudfront.net/recipes/bolitas-energeticas-de-avellana-y-cacao/900/bolitas-energeticas-de-avellana-y-cacao.jpg', 60),
('Granola Casera Eco', 'Granola de avena, coco, canela y semillas. Crujiente, sin azúcares refinados.', 4.20, 'Snacks', 'https://s1.elespanol.com/2015/01/19/cocinillas/cocinillas_4509699_116050074_1024x576.jpg', 70),
('Barritas de Semillas y Miel', 'Barritas crocantes con sésamo, chía y miel ecológica. Ricas en omega 3 y fibra.', 2.30, 'Snacks', 'https://www.ingredissimo.es/wp-content/uploads/2023/08/Barrita-de-cereales-con-miel-y-frutas-header.jpg', 55);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Zumo de Naranja Natural', 'Zumo exprimido de naranjas valencianas sin aditivos ni conservantes. Alto contenido en vitamina C.', 2.50, 'Bebidas', 'https://www.zuvamesa.com/imagenes/cuanto-azucar-tiene-un-zumo-de-naranja-natural.jpg', 80),
('Leche de Almendras Bio', 'Leche vegetal sin azúcares añadidos ni conservantes. Apta para veganos y personas con intolerancia a la lactosa.', 2.90, 'Bebidas', 'https://images.cookforyourlife.org/wp-content/uploads/2018/08/shutterstock_227713507-min-1.jpg', 100),
('Infusión de Menta Ecológica', 'Mezcla natural de hojas de menta orgánicas. Refrescante y digestiva.', 1.70, 'Bebidas', 'https://mejorconsalud.as.com/wp-content/uploads/2015/09/Infusion-de-menta.jpg', 90),
('Té Verde Matcha en Polvo', 'Matcha japonés de alta calidad. Ideal para preparar bebidas energizantes o recetas saludables.', 4.60, 'Bebidas', 'https://i0.wp.com/biorganic.es/wp-content/uploads/2023/02/te-verde-matcha.jpg?fit=700%2C800&ssl=1', 60),
('Zumo de Granada', 'Zumo 100% de granada ecológica, antioxidante y revitalizante. Ideal en ayunas.', 3.40, 'Bebidas', 'https://imag.bonviveur.com/zumo-de-granada.jpg', 70),
('Kombucha de Frutos Rojos', 'Bebida fermentada con probióticos naturales. Mejora la digestión y fortalece el sistema inmune.', 3.90, 'Bebidas', 'https://www.biosano.es/cdnassets/products/large/komvida-frutos-rojos-berryvida-750.png', 50),
('Leche de Avena sin Azúcar', 'Alternativa vegetal suave y cremosa. Ideal para cafés, batidos o repostería.', 2.40, 'Bebidas', 'https://us-central1-yema-cdn.cloudfunctions.net/cdn/api/v1/yema-plm/images/view/productImage/18985-bebida-de-avena-y-linaza-sin-azucar-natures-heart-1_cee3b509-acce-41bd-a86b-e17919d924c0=fjpg-q80-tcrop-w688', 85),
('Agua de Coco Natural', 'Bebida isotónica ecológica, ideal para rehidratación tras ejercicio físico. 100% coco.', 2.80, 'Bebidas', 'https://www.finedininglovers.com/es/sites/g/files/xknfdk1706/files/2022-07/agua-de-coco%C2%A9iStock.jpg', 65),
('Té Chai con Especias', 'Mezcla de té negro ecológico con canela, jengibre, clavo y cardamomo. Aroma intenso y reconfortante.', 3.20, 'Bebidas', 'https://puntodete.com/img/cms/blog/T%C3%89-VERDE-SHANGHAI-CHAI.jpg', 70),
('Smoothie Verde Detox', 'Smoothie embotellado de espinacas, manzana, pepino y limón. Refrescante y depurativo.', 4.00, 'Bebidas', 'https://www.iberochef.com/blog/wp-content/uploads/2019/05/zumo-manzana-espinaca.jpg', 45);


INSERT INTO productos (nombre, descripcion, precio, categoria, imagen, stock) VALUES
('Aceite de Oliva Virgen Extra', 'Aceite prensado en frío de oliva ecológica. Ideal para aliños, guisos y cocina mediterránea.', 6.90, 'Otros', 'https://www.molinoalfonso.com/wp-content/uploads/2021/06/aceite-oliva-virgen-extra-aragon.jpg', 90),
('Semillas de Chía', 'Ricas en omega-3, fibra y proteínas vegetales. Perfectas para yogures, batidos y repostería.', 3.10, 'Otros', 'https://soycomocomo.es/media/2018/03/chia.jpg', 70),
('Harina Integral de Espelta', 'Harina ecológica de espelta molida a piedra. Ideal para panes, pizzas y repostería saludable.', 2.80, 'Otros', 'https://www.elgraneldecorredera.com/wp-content/uploads/2017/02/HARINA-DE-ESPELTA-2.jpg', 65),
('Copos de Avena Bio', 'Avena integral ecológica rica en fibra y sin azúcares añadidos. Ideal para desayunos y barritas.', 2.60, 'Otros', 'https://www.elgraneldecorredera.com/wp-content/uploads/2018/11/copos-de-avena-grueso-e1592336830992.jpg', 85),
('Vinagre de Manzana Ecológico', 'Fermentado naturalmente. Excelente para ensaladas, adobos y salud digestiva.', 3.20, 'Otros', 'https://www.biofood.es/wp-content/uploads/2019/05/Vinagre-de-manzana-ecologico.png', 50),
('Panela Orgánica Molida', 'Endulzante natural sin refinar, obtenido del jugo de caña de azúcar. Sustituto saludable del azúcar.', 2.50, 'Otros', 'https://tienda.oxfamintermon.org/img/cms/CAES.jpg', 60),
('Quinoa Tricolor Bio', 'Fuente completa de proteínas vegetales, perfecta para ensaladas, bowls o guarniciones.', 4.10, 'Otros', 'https://media.v2.siweb.es/uploaded_thumb_big/51e048e94254e9de2aa2f22267d24018/503_quinoa_tricolor.jpg', 75),
('Lentejas Rojas Ecológicas', 'Legumbre rica en hierro y fácil de digerir. Cocción rápida y sin piel.', 2.20, 'Otros', 'https://tierragranel.es/wp-content/uploads/2024/03/LENTEJA-ROJA-PELADA-ECO-BL-1KG.jpg', 90),
('Cúrcuma en Polvo Bio', 'Condimento natural con propiedades antiinflamatorias. Usado en currys, caldos y batidos.', 1.80, 'Otros', 'https://regionalco.es/wp-content/uploads/2017/04/Curcuma-molida.jpg', 70),
('Cacao Puro en Polvo', 'Cacao 100% sin azúcar añadido. Ideal para repostería, smoothies o preparar chocolate caliente.', 3.90, 'Otros', 'https://www.slowshopgranel.es/wp-content/uploads/2020/02/cacao-en-polvo-natural.jpeg', 85);


-- Puedes continuar duplicando este formato para llegar a 100 productos.

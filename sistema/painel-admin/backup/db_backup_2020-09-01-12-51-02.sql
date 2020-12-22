DROP TABLE IF EXISTS alertas;

CREATE TABLE `alertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_alerta` varchar(20) NOT NULL,
  `titulo_mensagem` varchar(100) NOT NULL,
  `mensagem` varchar(1000) NOT NULL,
  `link` varchar(100) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `data` date NOT NULL,
  `ativo` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO alertas VALUES("1","Promoção Imperdível","Combo de 8 Camisetas","Combo com 8 camisetas de 260 reais por apenas 160 reais.","http://google.com","cat-2.jpg","2020-09-02","Sim");
INSERT INTO alertas VALUES("3","fdsafdsfa","fdfadf","dfasfdsafsad","http://google.com","sem-foto.jpg","2020-09-01","Não");


DROP TABLE IF EXISTS carac;

CREATE TABLE `carac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO carac VALUES("1","Tamanho");
INSERT INTO carac VALUES("2","Cor");
INSERT INTO carac VALUES("3","Numeração");
INSERT INTO carac VALUES("4","Voltagem");


DROP TABLE IF EXISTS carac_itens;

CREATE TABLE `carac_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_carac_prod` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor_item` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

INSERT INTO carac_itens VALUES("1","11","Azul","#80acf2");
INSERT INTO carac_itens VALUES("2","3","Azul","#80acf2");
INSERT INTO carac_itens VALUES("3","3","Vermelho","#cf4023");
INSERT INTO carac_itens VALUES("4","10","P",NULL);
INSERT INTO carac_itens VALUES("5","10","M",NULL);
INSERT INTO carac_itens VALUES("6","10","G",NULL);
INSERT INTO carac_itens VALUES("7","10","GG",NULL);
INSERT INTO carac_itens VALUES("8","3","Amarelo",NULL);
INSERT INTO carac_itens VALUES("9","3","Verde",NULL);
INSERT INTO carac_itens VALUES("12","11","Vermelho",NULL);
INSERT INTO carac_itens VALUES("13","15","30 e 31",NULL);
INSERT INTO carac_itens VALUES("14","15","32 e 33",NULL);
INSERT INTO carac_itens VALUES("15","16","Marron",NULL);
INSERT INTO carac_itens VALUES("16","16","Preto",NULL);
INSERT INTO carac_itens VALUES("17","17","34/35",NULL);
INSERT INTO carac_itens VALUES("18","17","36/37",NULL);
INSERT INTO carac_itens VALUES("19","18","Azul",NULL);


DROP TABLE IF EXISTS carac_prod;

CREATE TABLE `carac_prod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_carac` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO carac_prod VALUES("3","2","1");
INSERT INTO carac_prod VALUES("10","1","1");
INSERT INTO carac_prod VALUES("11","2","3");
INSERT INTO carac_prod VALUES("12","3","3");
INSERT INTO carac_prod VALUES("13","1","3");
INSERT INTO carac_prod VALUES("14","4","3");
INSERT INTO carac_prod VALUES("15","3","1");
INSERT INTO carac_prod VALUES("16","2","23");
INSERT INTO carac_prod VALUES("17","3","23");
INSERT INTO carac_prod VALUES("18","2","31");


DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `nome_url` varchar(50) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO categorias VALUES("1","Moda Masculina","moda-masculina","cat-3.jpg");
INSERT INTO categorias VALUES("2","Moda Feminina","moda-feminina","cat-2.jpg");
INSERT INTO categorias VALUES("3","Relógios","relogios","cat-5.jpg");
INSERT INTO categorias VALUES("4","Calçados","calcados","cat-6.jpg");
INSERT INTO categorias VALUES("5","Jóias e Semi-Jóias","joias-e-semi-joias","cat-7.jpg");


DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `rua` varchar(80) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(5) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `cartoes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO clientes VALUES("1","Alice Santos","000.000.000-40","alice@hotmail.com",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO clientes VALUES("2","Cliente Teste","000.000.000-10","cliente@hotmail.com",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO clientes VALUES("3","Matheus Silva","184.854.545-44","mateus@hotmail.com",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);


DROP TABLE IF EXISTS combos;

CREATE TABLE `combos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `nome_url` varchar(50) NOT NULL,
  `descricao` varchar(1000) NOT NULL,
  `descricao_longa` text NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `tipo_envio` int(1) NOT NULL,
  `palavras` varchar(250) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `peso` double(8,2) NOT NULL,
  `largura` double(8,2) NOT NULL,
  `altura` double(8,2) NOT NULL,
  `comprimento` double(8,2) NOT NULL,
  `valor_frete` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO combos VALUES("1","Camisa e Bermuda","camisa-e-bermuda","fdsfd","fsdfdsf","139.99","cat-1.jpg","1","fdsaf","Sim","1.00","1.00","1.00","1.00","0.00");
INSERT INTO combos VALUES("3","Conjunto Completo","conjunto-completo","fsdfds","fsdf","199.00","cat-3.jpg","1","afdsaf","Sim","1.00","1.00","1.00","1.00","0.00");


DROP TABLE IF EXISTS emails;

CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO emails VALUES("1","José Silva","josesilva@hotmail.com","Sim");
INSERT INTO emails VALUES("2","João Silva","joaosilva@hotmail.com","Sim");
INSERT INTO emails VALUES("3","Alice Santos","alice@hotmail.com","Sim");
INSERT INTO emails VALUES("4","Cliente Teste","cliente@hotmail.com","Sim");
INSERT INTO emails VALUES("5","Matheus Silva","mateus@hotmail.com","Sim");


DROP TABLE IF EXISTS imagens;

CREATE TABLE `imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

INSERT INTO imagens VALUES("11","1","cat-4.jpg");
INSERT INTO imagens VALUES("13","3","cat-2.jpg");
INSERT INTO imagens VALUES("14","3","cat-4.jpg");
INSERT INTO imagens VALUES("15","3","cat-7.jpg");
INSERT INTO imagens VALUES("16","1","cat-6.jpg");
INSERT INTO imagens VALUES("19","31","cat-4.jpg");


DROP TABLE IF EXISTS prod_combos;

CREATE TABLE `prod_combos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `id_combo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

INSERT INTO prod_combos VALUES("3","28","1");
INSERT INTO prod_combos VALUES("4","31","3");
INSERT INTO prod_combos VALUES("6","31","1");
INSERT INTO prod_combos VALUES("9","24","1");
INSERT INTO prod_combos VALUES("10","25","1");
INSERT INTO prod_combos VALUES("13","30","1");
INSERT INTO prod_combos VALUES("14","23","1");
INSERT INTO prod_combos VALUES("15","30","3");
INSERT INTO prod_combos VALUES("16","29","3");


DROP TABLE IF EXISTS produtos;

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` int(11) NOT NULL,
  `sub_categoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_url` varchar(100) NOT NULL,
  `descricao` varchar(1000) NOT NULL,
  `descricao_longa` text NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `estoque` int(11) NOT NULL,
  `tipo_envio` int(11) NOT NULL,
  `palavras` varchar(250) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `peso` double(8,2) DEFAULT NULL,
  `largura` double(8,2) DEFAULT NULL,
  `altura` double(8,2) DEFAULT NULL,
  `comprimento` double(8,2) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `valor_frete` decimal(8,2) DEFAULT NULL,
  `promocao` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

INSERT INTO produtos VALUES("1","4","2","Sapato Social","sapato-social","aaaaaaaaaaaafdsfdfsdf","aaaaaaaaaaaaaaaaaaaaaaaaaaaaaafdsfdsfdffdsf","189.99","cat-6.jpg","12","2","tenis masculino, tenis esportivo, tenis barato, comprar tenis, tenis lançamento","Não","0.20","0.20","0.50","0.80",NULL,"20.00","Não");
INSERT INTO produtos VALUES("3","2","3","Vestido","vestido","adaf","dfafdsf","250.00","cat-2.jpg","1","1","vestido feminino, vestidos","Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("4","2","6","Olympikus","olympikus","Tênis Olympikus Selene Preto\n\n","Tênis Olympikus Selene, feito em jacquard multicolor, com estampa floral exclusiva e detalhes em lycra. A palmilha Feetpad traz ainda mais conforto. Solado em Evasense texturizado completa o visual do tênis, garantindo leveza e segurança.\n\n\n","129.99","Tenis fem rosa.jpg","20","1",NULL,"Sim","0.00","34.00","0.00","39.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("5","2","6","Olympikus","olympikus","Tênis Olympikus Selene Azul","Tênis Olympikus Selene, feito em jacquard multicolor, com estampa floral exclusiva e detalhes em lycra. A palmilha Feetpad traz ainda mais conforto. Solado em Evasense texturizado completa o visual do tênis, garantindo leveza e segurança.\n\n\n","129.99","Tenis fem azul.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","39.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("6","2","6","Jogging","jogging","Tênis Jogging Via Marte Branco","Modelo conta com fecho em cadarço permitindo um melhor ajuste aos pés, interior revestido em material têxtil e palmilha em PU macio para um caminhar confortável.\n\n\n","99.99","Branco.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","39.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("7","2","6","Jogging","jogging","Tênis Jogging Via Marte Preto","Modelo conta com fecho em cadarço permitindo um melhor ajuste aos pés, interior revestido em material têxtil e palmilha em PU macio para um caminhar confortável.\n\n\n","99.99","Preto.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","39.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("8","2","3","Vestido com Capuz","vestido-com-capuz","Vestido com Capuz Preto","Vestido básico com capuz. Confeccionado em malha moletinho leve de algodão com toque macio. Com decote em V e mangas longas, de modelagem soltinha e comprimento curto.\n\n\n","89.90","Vestido Preto .jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("10","2","3","Vestidos","vestidos","Vestido Preto Transpassado com Alça Dupla","Vestido em helanca. Modelo com alças, decote transpassado, busto duplo, recorte na cintura, saia assimétrica com transpasse frontal. Comprimento: Curto.\n\n\n","34.99","Vst preto.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("12","2","7","Camisa Social","camisa-social","Camisa com Babado na Gola Azul","Camisa jeans. Decote com babado, fechamento com botões. Pences no busto e mangas longas com punho. Comprimento tradicional.\n\n\n","129.90","Blusa fem azul.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("15","2","7","Camisa Polo","camisa-polo","Polo Azul Royal Feminina","Polo Feminina em modelo Tradicional. Confeccionado em Meia Malha\n\n\n","39.90","Blusa azul.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("18","2","8","Calças","calcas","Calça Jeans Sawary Skinny 360° com Cinta e Puídos","Calça em jeans com elastano. Modelo 360º skinny. Cintura com cós e passantes, bolsos frontais falsos e traseiros funcionais, fechamento em botão e zíper, puídos nas pernas, cinta interna contornando a cintura. Cintura alta.\n\n\n","189.99","Calça fem.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("20","2","9","Calção Preto","calcao-preto","Short Boxer Preta com Elástico Esportivo","Short, em helanca. Modelo boxer, com elástico na cintura, faixa esportiva nas laterais e cordão decorativo. Cintura: Média.\n\n\n","39.99","Short Preto.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("22","2","9","Short Jeans","short-jeans","Short Azul","Short em jeans de algodão com puídos de efeito destroyed e barra desfiada. Possui comprimento curto e cintura média e tem cós com passantes, bolsos na frente e na parte de trás e fechamento por botão fixo de metal e zíper.\n\n\n","99.90","Short Jeans.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("23","4","10","Dariely","dariely","Bota Montaria Feminina Bottero Couro Preto","Modelo básico que finaliza inúmeros looks com muita elegância. Conta com detalhes metalizados na lateral, fecho em zíper garante a praticidade no calce. Salto grosso complementa o estilo.\n\n\n","149.99","Bota Feminina.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("24","4","10","Polo State","polo-state","Coturno Masculino Polo State Bronxy Marrom Brown","O Coturno Bronxy foi desenvolvido para você ter mais estilo, com um design diferenciado e excelente acabamento, para maior durabilidade. Botas são calçados que nunca saem de moda, além de trazerem mais estilo ao visual, elas são bastante confortáveis principalmente naqueles dias de frio. Além de modernas e elegantes, elas deixam seus pés aquecidos e seu visual ainda mais sofisticado. Um produto que combina com diversas ocasiões e estilo de roupas diferentes. Confeccionado em material alternativo. Fechamento em cadarço e zíper na lateral facilitando na hora de calçar esse incrível produto, sem contar com os detalhes em costuras. Um charme de Coturno\n\n\n","79.90","Bota Masculina.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("25","1","11","Wee Malwee","wee-malwee","Camiseta Azul Marinho Peixe-Espada","Camiseta confeccionada em meia malha. Modelagem tradicional. Possui estampa ilustrativa de peixe-espada. Detalhe de etiqueta decorativa da marca. Aposte em calça jeans skinny e tênis slip on, para um visual despojado e moderno!\n\n\n","47.94","Camisa azul.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");
INSERT INTO produtos VALUES("30","1","12","Bermudas","bermudas","Bermuda com Cordel e Detalhe Destroyed Jeans","Bermuda em jeans de algodão. Modelo com cordel removível e bolsos frontais e traseiros funcionais. Detalhes destroyed.\n\n\n","139.99","Jeans.jpg","20","1",NULL,"Sim","0.00","0.00","0.00","0.00",NULL,"0.00","Não");


DROP TABLE IF EXISTS promocao_banner;

CREATE TABLE `promocao_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO promocao_banner VALUES("1","Promoção 6 Camisetas","http://google.com","banner-promo-2.jpg","Sim");
INSERT INTO promocao_banner VALUES("3","Segunda Promoção","http://google.com","banner-promo.jpg","Sim");
INSERT INTO promocao_banner VALUES("4","Terceira Promoção","http://google.com","banner-1.jpg","Não");


DROP TABLE IF EXISTS promocoes;

CREATE TABLE `promocoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_final` date NOT NULL,
  `ativo` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO promocoes VALUES("2","31","30.00","2020-08-30","2020-09-01","Sim");
INSERT INTO promocoes VALUES("3","30","20.00","2020-08-31","2020-08-31","Sim");
INSERT INTO promocoes VALUES("4","29","35.00","2020-08-24","2020-09-02","Não");
INSERT INTO promocoes VALUES("5","28","50.00","2020-08-31","2020-09-08","Sim");


DROP TABLE IF EXISTS sub_categorias;

CREATE TABLE `sub_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `nome_url` varchar(50) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO sub_categorias VALUES("1","Tênis Masculinos","tenis-masculinos","Prdt Tenis Masc preto.jpg","4");
INSERT INTO sub_categorias VALUES("2","Sapato Social","sapato-social","Sapato Social.jpg","4");
INSERT INTO sub_categorias VALUES("3","Vestidos","vestidos","cat-2.jpg","2");
INSERT INTO sub_categorias VALUES("6","Tênis Femininos","tenis-femininos","Prdt Tenis Feminino Rosa.jpg","2");
INSERT INTO sub_categorias VALUES("7","Blusas","blusas","Sub Social Feminina .jpg","2");
INSERT INTO sub_categorias VALUES("8","Calças ","calcas","Prdt Jogger Feminina.jpg","2");
INSERT INTO sub_categorias VALUES("9","Shorts","shorts","Calção.jpg","2");
INSERT INTO sub_categorias VALUES("10","Botas","botas","sem-foto.jpg","4");
INSERT INTO sub_categorias VALUES("11","Camisetas","camisetas","Sub Camisas.jpg","1");
INSERT INTO sub_categorias VALUES("12","Bermudas","bermudas","Prdt Bermuda masc Cinza.jpg","1");


DROP TABLE IF EXISTS tipo_envios;

CREATE TABLE `tipo_envios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tipo_envios VALUES("1","Correios");
INSERT INTO tipo_envios VALUES("2","Valor Fixo");
INSERT INTO tipo_envios VALUES("3","Sem Frete");
INSERT INTO tipo_envios VALUES("4","Digital");


DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(35) NOT NULL,
  `senha_crip` varchar(150) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO usuarios VALUES("1","Administrador","000.000.000-00","lojaportalhugo@gmail.com","123","202cb962ac59075b964b07152d234b70","Admin");
INSERT INTO usuarios VALUES("5","Alice Santos","000.000.000-40","alice@hotmail.com","123","202cb962ac59075b964b07152d234b70","Cliente");
INSERT INTO usuarios VALUES("6","Cliente Teste","000.000.000-10","cliente@hotmail.com","123","202cb962ac59075b964b07152d234b70","Cliente");
INSERT INTO usuarios VALUES("7","Matheus Silva","184.854.545-44","mateus@hotmail.com","123","202cb962ac59075b964b07152d234b70","Cliente");



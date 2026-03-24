-- Timeless Collectibles PostgreSQL Schema

-- Create tables

CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  email VARCHAR(300) UNIQUE NOT NULL,
  password VARCHAR(300) NOT NULL,
  address VARCHAR(300),
  country VARCHAR(300),
  reset_token_hash VARCHAR(64) UNIQUE,
  reset_token_expires_at TIMESTAMP,
  "2FA_Pin" VARCHAR(6),
  "2FA_Expire" TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id VARCHAR(36) PRIMARY KEY,
  prodname VARCHAR(500) NOT NULL,
  prodcategory VARCHAR(500) NOT NULL,
  description VARCHAR(500),
  image VARCHAR(500),
  price INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cart_items (
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
  product_id VARCHAR(36) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_orders (
  orderid SERIAL PRIMARY KEY,
  userid INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  productid VARCHAR(36) NOT NULL REFERENCES products(id),
  quantity INTEGER NOT NULL,
  pending BOOLEAN DEFAULT FALSE,
  delivering BOOLEAN DEFAULT FALSE,
  delivered BOOLEAN DEFAULT FALSE
);

-- Create indexes

CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_reset_token ON users(reset_token_hash);
CREATE INDEX IF NOT EXISTS idx_cart_items_user_id ON cart_items(user_id);
CREATE INDEX IF NOT EXISTS idx_cart_items_product_id ON cart_items(product_id);
CREATE INDEX IF NOT EXISTS idx_products_category ON products(prodcategory);
CREATE INDEX IF NOT EXISTS idx_user_orders_user_id ON user_orders(userid);
CREATE INDEX IF NOT EXISTS idx_user_orders_product_id ON user_orders(productid);

INSERT INTO products (id, prodname, prodcategory, description, image, price) VALUES
('01942256-8446-46c3-8f13-f72dc91d7c1e', 'Pokemon Evolution 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- A total of 15 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonEvolution1Pack.png', 194),
('0915fcd8-31a5-4e06-9ab2-966784cea94f', 'Big Daddy Bioshock', '2', E'- 10 inches tall and 5 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed 2k Merchandise ✓', 'uploads/BigDaddyBioshock.png', 7000),
('097c1871-05ef-4bf9-a161-92f1feea72e5', 'Keroppi Plushie', '1', E'- Approximately 400 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 5 and up<br />\r\n- Officially licensed Sanrio Merchandise ✓', 'uploads/KeroppiPlushie.png', 400),
('1344bc19-c566-4c95-b88d-7c3d570d14ae', 'Jujutsu Kaisen Gojo Pop Vinyl', '2', E'- 3.75 inches tall and 2.5 inches wide<br />\r\n- Made from vinyl<br />\r\n- Officially licensed by Funko Inc ✓', 'uploads/JujutsuKaisenGojoPopVinyl.png', 9000),
('1384734f-54ce-494f-9409-d4f03520ba58', 'Flesh and Blood Booster 3 Packs', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 10 Cards in each pack, total of 30 cards<br />\r\n- Officially Licensed By Legend Story Studios ✓', 'uploads/FleshandBloodBooster3Packs.png', 399),
('160dab4f-b225-4eca-9013-52ac351969f9', 'Pokemon Evolutions 36 Packs', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 15 Cards in each pack, total of 540 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonEvolutions36Packs.png', 7000),
('1b55fa41-79a7-4989-8ab6-d6cbf04e5abd', 'Pikachu Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up.<br />\r\n- Officially licensed Pokémon Merchandise ✓<br />\r\n', 'uploads/PikachuPlushie.jpg', 200),
('216d2ae3-d767-4245-8f28-ab266c7acb2d', 'Chainsaw Man Denji ', '2', E'- 6 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed MAPPA Merchandise ✓', 'uploads/ChainsawManDenji.png', 12000),
('2845573e-67d7-4306-a6b4-05fe0369fba5', 'Jinx The Loose Cannon', '2', E'- 6 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Riot Games Merchandise ✓', 'uploads/JinxTheLooseCannon.png', 12000),
('387ee229-b4d8-4582-ac7b-f4c6f60d758a', 'Jhin The Virtuoso', '2', E'- 6 inches tall and 4 inches wide<br />\n- Crafted from high-quality PVC for durability and fine detail<br />\n- Officially licensed Riot Games Merchandise ✓', 'uploads/JhinTheVirtuoso.png', 12200),
('40628456-7d38-421e-b5b9-d6b756029cc7', 'Ashe The Frost Archer', '2', E'- 6 inches tall and 4 inches wide<br />\n- Crafted from high-quality PVC for durability and fine detail<br />\n- Officially licensed Riot Games Merchandise ✓', 'uploads/AsheTheFrostArcher.jpg', 12000),
('484de00e-8972-443a-acf5-a8a1610278b4', 'Gengar Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Pokémon Merchandise ✓', 'uploads/GengarPlushie.png', 250),
('4a733e93-21c8-4e7a-b5b0-8002c026a8c2', 'KDA Ahri The Nine Tailed Fox', '2', E'- 7 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Riot Games Merchandise ✓', 'uploads/KDAAhriTheNineTailedFox.png', 14000),
('4d255279-0193-4cfd-aca2-b9dcbb6d8d84', 'Zed Master Of Shadows', '2', E'- 6 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Riot Games Merchandise ✓', 'uploads/ZedMasterOfShadows.png', 12000),
('504c2aa1-04f9-44b6-af8d-885b5dd977ee', 'Luigi Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Super Mario Brothers Merchandise ✓', 'uploads/LuigiPlushie.jpg', 200),
('507078b4-4e6c-4d74-bdab-2e42b9c97700', 'Princess Peach Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Super Mario Brothers Merchandise ✓', 'uploads/PrincessPeachPlushie.jpg', 400),
('55341daf-214b-4ab7-8b5b-8e71b4445996', 'Melody Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Sanrio Merchandise ✓', 'uploads/MelodyPlushie.png', 100),
('6032d1a9-590f-4f38-9e29-cd16dc719cba', 'Yu Gi Oh Dark Wing Blast 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\n- Made from Quality cardstock.<br />\n- Total of 20 Cards<br />\n- Officially Licensed By Konami ✓', 'uploads/YuGiOhDarkWingBlast1Pack.png', 280),
('6db0ca81-cc1d-46c7-90dd-632c75015214', 'Flesh And Blood Monarch Blitz 10 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 10 Cards in each pack, total of 100 cards<br />\r\n- Officially Licensed By Legend Story Studios ✓', 'uploads/FleshAndBloodMonarchBlitz10Pack.png', 5500),
('78368051-99a0-4f92-9fea-02e0d67470c1', 'Pokemon S&V Obsidian Flames 36 Packs', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 15 Cards in each pack, total of 540 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonS&VObsidianFlames36Packs.png', 7000),
('7bce793b-a117-4010-8653-39a70e3c7778', 'Flesh and Blood Uprising 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- Total of 10 Cards<br />\r\n- Officially Licensed By Legend Story Studios ✓', 'uploads/FleshandBloodUprising1Pack.png', 2500),
('7cdcd286-0328-4345-a93d-afe6f4c01914', 'Yu Gi Oh Amazing Defenders 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- Total of 20 Cards<br />\r\n- Officially Licensed By Konami ✓', 'uploads/YuGiOhAmazingDefenders1Pack.png', 280),
('83e6db54-753b-4f0d-8501-2f35f20633e2', 'Bulbasaur Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Pokémon Merchandise ✓', 'uploads/BulbasaurPlushie.jpg', 340),
('880b57bf-32f0-4445-995e-22b2d84fe076', 'Flesh and Blood Heavy Hitters 10 Packs', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 10 Cards in each pack, total of 100 cards<br />\r\n- Officially Licensed By Legend Story Studios ✓', 'uploads/FleshandBloodHeavyHitters10Packs.png', 5000),
('91218370-9dcf-4499-9847-67b1158f179f', 'Kuromi Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Sanrio Merchandise ✓', 'uploads/KuromiPlushie.jpg', 400),
('96a5c1ae-aa4e-41b4-90c7-e0608b260910', 'Quagsire Plushie', '1', E'- Approximately 14 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 6 and up<br />\r\n- Officially licensed Pokémon Merchandise ✓', 'uploads/QuagsirePlushie.png', 500),
('a1e27b23-b285-43b3-824b-a034ef9c527d', 'Hello Kitty Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Sanrio Merchandise ✓', 'uploads/HelloKittyPlushie.png', 240),
('a9c3ba60-2e6f-4fc9-b0d4-b92329cc4fb9', 'Pokemon S&V Obsidian Flames 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- A total of 15 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonS&VObsidianFlames1Pack.png', 194),
('ac2741d7-23eb-40fd-af28-f1b67b50b30a', 'Zerg Hydralisk Starcraft', '2', E'- 6 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Blizzard Merchandise ✓', 'uploads/ZergHydraliskStarcraft.jpg', 5600),
('b4967faf-2db5-4352-bf4f-febd705c4026', 'Mario Plushie', '1', E'- Approximately 8 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Super Mario Brothers Merchandise ✓', 'uploads/MarioPlushie.jpg', 200),
('c3d361aa-551c-49d1-9ed0-c480087ebd9e', 'Diablo Inarius', '2', E'- 7 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Blizzard Merchandise ✓', 'uploads/DiabloInarius.png', 13000),
('cdeb83e4-ab70-48ab-bfaa-a324822ad923', 'Pokemon Brilliant Stars 1 Pack', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- A total of 15 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonBrilliantStars1Pack.png', 194),
('df12c88d-b4c2-495d-aad9-87b5e9b1ae74', 'Pokemon S&S Brilliant Stars', '3', E'- 2.5 x 3.6 Inches<br />\r\n- Made from Quality cardstock.<br />\r\n- 15 Cards in each pack, total of 540 cards<br />\r\n- Officially Licensed By Pokémon ✓', 'uploads/PokemonS&SBrilliantStars.png', 7000),
('ed63e905-67df-4eb7-acbc-d057f1c31f63', 'Yoshi Plushie', '1', E'- Approximately 15 inches tall<br />\r\n- Constructed from soft, durable polyester fabric with plush filling for a huggable feel<br />\r\n- Suitable for children ages 3 and up<br />\r\n- Officially licensed Super Mario Brothers Merchandise ✓', 'uploads/YoshiPlushie.png', 700),
('f7814dd1-c457-401d-b743-651d4091875c', 'Diablo Lilith', '2', E'- 7 inches tall and 4 inches wide<br />\r\n- Crafted from high-quality PVC for durability and fine detail<br />\r\n- Officially licensed Blizzard Merchandise ✓', 'uploads/DiabloLilith.png', 16000),
('fa8bd0f0-6268-47da-a31f-985ea85c761f', 'Jujutsu Kaisen Sukuna Pop Vinyl', '2', E'- 3.75 inches tall and 2.5 inches wide<br />\r\n- Made from vinyl<br />\r\n- Officially licensed by Funko Inc ✓', 'uploads/JujutsuKaisenSukunaPopVinyl.png', 8000)
ON CONFLICT (id) DO NOTHING;

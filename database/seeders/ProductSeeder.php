<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'Engraving' => [
                [
                    'name' => 'Engraved Walnut Nameplate', 'price' => 65.00, 'sale_price' => null,
                    'description' => 'A hand-engraved walnut nameplate for a desk, door, or gift, clean lettering cut deep into solid hardwood.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '8in x 3in'],
                ],
                [
                    'name' => 'Custom Engraved Cutting Board', 'price' => 85.00, 'sale_price' => 75.00,
                    'description' => 'A food-safe maple cutting board engraved with a name, date, or design, a lasting piece for the kitchen or a wedding gift.',
                    'specs' => ['Material' => 'Maple Wood', 'Finish' => 'Food-Safe Mineral Oil', 'Dimensions' => '12in x 8in'],
                ],
            ],
            'CNC Creations' => [
                [
                    'name' => 'Alabama Frame', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/alabama-frame.jpg',
                    'description' => 'Show your Crimson Tide pride with the Alabama Frame. Crafted from premium wood, this frame features detailed engravings of Alabama’s iconic spirit, making it a perfect addition to your home, office, or fan collection.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '16in x 16in'],
                ],
                [
                    'name' => 'Custom Firefighter maltese cross', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/custom-firefighter-maltese-cross.jpg',
                    'description' => 'Celebrate your connection to Richardson with the Richardson Frame. Crafted from premium wood, this frame features intricate detailing, making it a beautiful addition to any home, office, or collection.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Satin Sealant', 'Dimensions' => '18in x 18in'],
                ],
                [
                    'name' => 'Steelers Frame', 'price' => 130.00, 'sale_price' => null, 'image' => '/images/catalog/steelers-frame.jpg',
                    'description' => 'Show your team pride with this layered CNC-cut team frame, built to hang and last.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '14in x 14in'],
                ],
                [
                    'name' => 'Kansas City Chiefs Rounded', 'price' => 35.00, 'sale_price' => null, 'image' => '/images/catalog/kansas-city-chiefs-rounded.jpg',
                    'description' => 'A compact rounded team-pride piece, perfect for a shelf, office desk, or man cave wall.',
                    'specs' => ['Material' => 'Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '6in diameter'],
                    'variations' => [
                        ['attribute_name' => 'Color', 'attribute_value' => 'Natural Wood', 'price_adjustment' => 0],
                        ['attribute_name' => 'Color', 'attribute_value' => 'Red & Gold', 'price_adjustment' => 10],
                    ],
                ],
                [
                    'name' => 'Pink Floyd', 'price' => 85.00, 'sale_price' => null, 'image' => '/images/catalog/pink-floyd.jpg',
                    'description' => 'A favorite album cover reimagined as layered wood wall art — a striking piece for any music lover.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '12in x 12in'],
                ],
                ...array_map(fn (array $item) => $item + [
                    'description' => 'A handcrafted CNC wooden creation made with precision cutting and a durable finish.',
                    'specs' => ['Material' => 'Baltic Birch Plywood', 'Finish' => 'Matte Sealant', 'Dimensions' => '18in x 18in'],
                ], [
                    ['name' => 'Broncos Country Frame', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/broncos-country-frame.jpg'],
                    ['name' => 'Champions Frame', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/champions-frame.jpg'],
                    ['name' => 'Custom Animal Wooden Frame', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/custom-animal-wooden-frame.jpg'],
                    ['name' => 'Custom Sign', 'price' => 100.00, 'sale_price' => null, 'image' => '/images/catalog/custom-sign.jpg'],
                    ['name' => 'Elkhorn Frame', 'price' => 300.00, 'sale_price' => null, 'image' => '/images/catalog/elkhorn-frame.jpg'],
                    ['name' => 'Led zeppelin Ramble On Cover', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/led-zeppelin-ramble-on-cover.jpg'],
                    ['name' => 'Omaha Beef CNC Creations', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/omaha-beef-cnc-creations.jpg'],
                    ['name' => 'Omaha Fire Frame', 'price' => 200.00, 'sale_price' => null, 'image' => '/images/catalog/omaha-fire-frame.jpg'],
                    ['name' => 'Raiders', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/raiders.jpg'],
                    ['name' => 'SF CNC Creations', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/sf-cnc-creations.jpg'],
                ]),
            ],
            'Shadow Boxes' => [
                [
                    'name' => 'Memorial Shadow Box', 'price' => 180.00, 'sale_price' => null,
                    'description' => 'A deep-set display case for medals, photos, and keepsakes — built to preserve and honor a lifetime of memories.',
                    'specs' => ['Material' => 'Solid Oak', 'Finish' => 'Glass Front, Sealed', 'Dimensions' => '20in x 16in x 3in'],
                ],
                [
                    'name' => 'Military Service Shadow Box', 'price' => 220.00, 'sale_price' => 199.00,
                    'description' => 'A custom-built display for service medals, patches, and photographs, finished to honor years of service.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Glass Front, Sealed', 'Dimensions' => '24in x 18in x 3in'],
                ],
            ],
            'Jewelry Boxes' => [
                [
                    'name' => 'Classic Wooden Jewelry Box', 'price' => 120.00, 'sale_price' => null, 'image' => '/images/catalog/classic-wooden-jewelry-box.jpeg',
                    'description' => 'A multi-compartment jewelry box crafted from premium wood with a soft interior lining to protect your collection.',
                    'specs' => ['Material' => 'Solid Cherry Wood', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '10in x 7in x 4in'],
                ],
                [
                    'name' => 'Elegant Mirror Jewelry Box', 'price' => 160.00, 'sale_price' => 145.00, 'image' => '/images/catalog/elegant-mirror-jewelry-box.jpeg',
                    'description' => 'A jewelry box with a built-in mirrored lid, felt-lined trays, and a timeless design that suits any bedroom decor.',
                    'specs' => ['Material' => 'Solid Maple', 'Finish' => 'Satin Lacquer', 'Dimensions' => '11in x 8in x 5in'],
                ],
                [
                    'name' => 'Personalized Jewelry Box', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/personalized-jewelry-box.jpeg',
                    'description' => 'A custom-engraved jewelry box made to order — a name, date, or short message engraved on the lid.',
                    'specs' => ['Material' => 'Solid Walnut', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '9in x 6in x 4in'],
                    'variations' => [
                        ['attribute_name' => 'Size', 'attribute_value' => 'Small', 'price_adjustment' => 0],
                        ['attribute_name' => 'Size', 'attribute_value' => 'Large', 'price_adjustment' => 40],
                    ],
                ],
                [
                    'name' => 'Custom Jewelry Box', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/custom-jewelry-box.jpeg',
                    'description' => 'A custom jewelry box designed to protect and present treasured pieces with a handcrafted finish.',
                    'specs' => ['Material' => 'Solid Hardwood', 'Finish' => 'Hand-Rubbed Oil', 'Dimensions' => '10in x 7in x 4in'],
                ],
                [
                    'name' => 'examples of urn or keepsake', 'price' => 180.00, 'sale_price' => null, 'image' => '/images/catalog/examples-of-urn-or-keepsake.jpeg',
                    'description' => 'A meaningful handcrafted keepsake design made for memories, mementos, and treasured belongings.',
                    'specs' => ['Material' => 'Solid Hardwood', 'Finish' => 'Natural Wood Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Jewelery Box', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/jewelery-box.jpeg',
                    'description' => 'An elegant wooden jewelry box with a timeless handcrafted look and practical storage compartments.',
                    'specs' => ['Material' => 'Solid Hardwood', 'Finish' => 'Satin Finish', 'Dimensions' => 'Custom'],
                ],
            ],
            '3D CNC Models' => [
                [
                    'name' => 'Abstract 3D CNC Model', 'price' => 250.00, 'sale_price' => null,
                    'description' => 'Unleash creativity with the Abstract 3D CNC Model. Featuring bold and unconventional patterns, it’s perfect for unique decor, artistic panels, or furniture accents.',
                    'image' => '/images/catalog/abstract-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'Hardwood', 'Finish' => 'Hand-Finished', 'Dimensions' => '24in x 24in'],
                ],
                [
                    'name' => 'ashholes o.g 3d butcher block', 'price' => 250.00, 'sale_price' => null,
                    'description' => 'Create stunning borders and accents with the Ornamental Frame 3D CNC Model. Perfect for mirrors, picture frames, and architectural details.',
                    'image' => '/images/catalog/ashholes-og-3d-butcher-block.jpeg',
                    'specs' => ['Material' => 'Solid Hardwood', 'Finish' => 'Clear Protective Finish', 'Dimensions' => '24in x 18in'],
                ],
                [
                    'name' => 'Classic Scroll 3D CNC Model', 'price' => 270.00, 'sale_price' => null,
                    'description' => 'Elevate your designs with the timeless elegance of the Classic Scroll 3D CNC Model. Perfect for furniture accents, architectural trim, or decorative panels.',
                    'image' => '/images/catalog/classic-scroll-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '24in x 24in'],
                ],
                [
                    'name' => 'Croc 3D Model', 'price' => 300.00, 'sale_price' => null,
                    'description' => 'A dramatic crocodile relief carved into a solid wood panel for distinctive wall and display art.',
                    'image' => '/images/catalog/croc-3d-model.jpeg',
                    'specs' => ['Material' => 'Solid Hardwood', 'Finish' => 'Satin Wood Finish', 'Dimensions' => '36in x 12in'],
                ],
                [
                    'name' => 'Crocodile Relief 3D CNC Model', 'price' => 300.00, 'sale_price' => null,
                    'description' => 'A highly detailed carved crocodile relief, precision-cut and finished to highlight the natural wood grain.',
                    'image' => '/images/catalog/crocodile-relief-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'Walnut Hardwood', 'Finish' => 'Gloss Protective Finish', 'Dimensions' => '36in x 14in'],
                ],
                [
                    'name' => 'Crocodile Wall Art 3D CNC Model', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'A statement-scale crocodile wall artwork designed for collectors, businesses, and bold interiors.',
                    'image' => '/images/catalog/crocodile-wall-art-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'Walnut Hardwood', 'Finish' => 'Hand-Polished', 'Dimensions' => '48in x 16in'],
                ],
                [
                    'name' => 'Decorative 3D CNC Model Each', 'price' => 300.00, 'sale_price' => null,
                    'description' => 'A custom decorative 3D relief made to bring depth, character, and handcrafted warmth to a room.',
                    'image' => '/images/catalog/decorative-3d-cnc-model-each.jpeg',
                    'specs' => ['Material' => 'Hardwood', 'Finish' => 'Natural Oil Finish', 'Dimensions' => '24in x 18in'],
                ],
                [
                    'name' => 'Decorative Floral 3D CNC Model', 'price' => 300.00, 'sale_price' => 270.00,
                    'description' => 'A botanical relief design with deep dimensional carving, ideal as a statement wall piece.',
                    'image' => '/images/catalog/decorative-floral-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '26in x 26in'],
                ],
                [
                    'name' => 'Geometric 3D CNC Model', 'price' => 250.00, 'sale_price' => null,
                    'description' => 'A layered geometric relief carving with crisp dimensional lines, suited to modern interiors.',
                    'image' => '/images/catalog/geometric-3d-cnc-model.jpeg',
                    'specs' => ['Material' => 'MDF / Hardwood', 'Finish' => 'Ready to Paint or Stain', 'Dimensions' => '20in x 20in'],
                ],
            ],
            'Custom Murals' => [
                [
                    'name' => 'Family Tree Wall Mural', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'A large-format layered wood mural personalized with family names carved into the branches.',
                    'specs' => ['Material' => 'Plywood Panels', 'Finish' => 'Matte Sealant', 'Dimensions' => '48in x 36in'],
                ],
                [
                    'name' => 'Landscape Wood Mural', 'price' => 400.00, 'sale_price' => 360.00,
                    'description' => 'A multi-panel layered landscape scene, hand-finished to add depth and warmth to any large wall.',
                    'specs' => ['Material' => 'Plywood Panels', 'Finish' => 'Matte Sealant', 'Dimensions' => '60in x 30in'],
                ],
            ],
            'Custom Board Games' => [
                [
                    'name' => 'Build-Your-Own Game Kit', 'price' => 220.00, 'sale_price' => null, 'image' => '/images/catalog/build-your-own-game-kit.jpg',
                    'description' => 'A fully custom wooden board game built to your own rules and layout — a one-of-a-kind piece for family game night.',
                    'specs' => ['Material' => 'Hardwood Board & Pieces', 'Finish' => 'Satin Lacquer', 'Dimensions' => '20in x 20in'],
                ],
                [
                    'name' => 'Custom Game Pieces Set', 'price' => 150.00, 'sale_price' => null, 'image' => '/images/catalog/custom-game-pieces-set.jpg',
                    'description' => 'A hand-turned set of wooden game pieces, custom-shaped and finished to match your favorite game.',
                    'specs' => ['Material' => 'Hardwood', 'Finish' => 'Satin Lacquer', 'Dimensions' => 'Set of 32 pieces'],
                ],
                [
                    'name' => 'Personalized Game Board', 'price' => 220.00, 'sale_price' => 195.00, 'image' => '/images/catalog/personalized-game-board.jpg',
                    'description' => 'A classic game board engraved with a family name and date, built to become a keepsake as much as a game.',
                    'specs' => ['Material' => 'Solid Maple', 'Finish' => 'Satin Lacquer', 'Dimensions' => '18in x 18in'],
                ],
            ],
            'Custom Signs' => [
                [
                    'name' => 'BMW M Logo Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'image' => 'https://i.etsystatic.com/65284121/r/il/636ec9/7984663665/il_794xN.7984663665_6u8g.jpg',
                    'description' => 'Bring performance-inspired style to your space with this handcrafted BMW M-inspired wall art. Premium wood and high-gloss epoxy resin create a bold modern design for a garage, office, or man cave.',
                    'specs' => ['Material' => 'Premium Wood & Epoxy Resin', 'Finish' => 'High-Gloss Resin', 'Dimensions' => '24in x 11in x 1in'],
                ],
                [
                    'name' => 'Bentley Inspired Resin Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'Add a touch of luxury with handcrafted Bentley-inspired resin wall art. Premium epoxy resin, metallic detailing, and a natural wood border make every piece unique.',
                    'specs' => ['Material' => 'Wood & Epoxy Resin', 'Finish' => 'Metallic Gloss', 'Dimensions' => '24in x 12in x 1.25in'],
                ],
                [
                    'name' => 'Rolex Inspired Wall Art', 'price' => 400.00, 'sale_price' => null,
                    'description' => 'A handcrafted luxury resin wall piece inspired by classic watch design, made for offices, garages, man caves, and watch lovers.',
                    'specs' => ['Material' => 'Wood & Epoxy Resin', 'Finish' => 'High-Gloss Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Custom AMG Affalterbach Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'A handmade round wooden AMG-inspired sign with premium layered detailing, designed for luxury garages, offices, and automotive collections.',
                    'specs' => ['Material' => 'Wood & Epoxy Resin', 'Finish' => 'Gloss Protective Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Lamborghini Shield Wall Art', 'price' => 400.00, 'sale_price' => null,
                    'image' => 'https://i.etsystatic.com/65284121/r/il/2692d9/8222862663/il_794xN.8222862663_lnpq.jpg',
                    'description' => 'Showcase automotive passion with this bold Lamborghini-inspired shield wall art. A premium textured finish, metallic accents, and layered construction create a standout display.',
                    'specs' => ['Material' => '3D Printed Composite & Wood', 'Finish' => 'Textured Gloss Finish', 'Dimensions' => '22in x 24in x 1.25in'],
                ],
                [
                    'name' => 'Handmade Motorcycle Shield Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'Layered wood and epoxy biker wall art made for garages, workshops, and motorcycle enthusiasts who want a distinctive handmade display.',
                    'specs' => ['Material' => 'Layered Wood & Epoxy Resin', 'Finish' => 'Protective Gloss Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Personalized Aston Martin Inspired Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'Personalized Aston Martin-inspired resin wall art with custom name options, made as a premium automotive decoration or racing garage gift.',
                    'specs' => ['Material' => 'Wood & Epoxy Resin', 'Finish' => 'High-Gloss Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Nürburgring F1 Resin Wall Art', 'price' => 350.00, 'sale_price' => null,
                    'description' => 'Handmade wood and resin motorsport track sign inspired by Nürburgring and Formula 1, perfect for a garage, office, or racing collection.',
                    'specs' => ['Material' => 'Wood & Epoxy Resin', 'Finish' => 'Gloss Protective Finish', 'Dimensions' => 'Custom'],
                ],
                [
                    'name' => 'Bunny Ear Napkin Rings Set of 6', 'price' => 45.00, 'sale_price' => null,
                    'description' => 'A set of six modern bunny ear napkin rings designed for Easter tables, seasonal entertaining, and minimalist place settings.',
                    'specs' => ['Material' => 'Handcrafted Wood', 'Finish' => 'Smooth Protective Finish', 'Dimensions' => 'Set of 6'],
                ],
            ],
        ];

        // Keep the category records available, but mirror the live store where these
        // categories currently have no published products.
        foreach (['Engraving', 'Shadow Boxes', 'Custom Murals'] as $emptyCategory) {
            $catalog[$emptyCategory] = [];
        }

        // Product copy synced from the client's live product pages.
        $liveDescriptions = [
            'alabama-frame' => 'Show your Crimson Tide pride with the Alabama Frame. Crafted from premium wood, this frame features detailed engravings of Alabama’s iconic spirit, making it a perfect addition to your home, office, or fan collection.',
            'broncos-country-frame' => 'Show your Broncos pride with the Broncos Country Frame. Crafted from premium wood, this frame features intricate detailing of the iconic Broncos logo, making it a must-have for any fan’s home, office, or fan cave.',
            'champions-frame' => 'Celebrate victory with the Champions Frame! Crafted from premium wood, this beautifully designed frame highlights your winning spirit with intricate detailing, making it a perfect addition to any home, office, or trophy display.',
            'custom-animal-wooden-frame' => 'Showcase your love for wildlife with this custom animal wooden frame. Made from premium wood, this frame is intricately designed to highlight your favorite animal in a beautiful, timeless way. Perfect for any nature enthusiast.',
            'custom-firefighter-maltese-cross' => 'Celebrate your connection to Richardson with the Richardson Frame. Crafted from premium wood, this frame features intricate detailing, making it a beautiful addition to any home, office, or collection.',
            'custom-sign' => 'Create your perfect custom sign with our expertly crafted designs. Made from premium materials, each sign is tailored to your specifications, combining durability with a personal touch to elevate your home, business, or event decor.',
            'elkhorn-frame' => 'Celebrate your connection to Elkhorn with this beautifully crafted Elkhorn Frame. Made from premium wood, it features intricate detailing that adds a timeless and personal touch to any home or office decor.',
            'kansas-city-chiefs-rounded' => 'Showcase your Kansas City Chiefs pride with the Kansas City Chiefs Rounded frame. Expertly crafted from premium wood, this frame features a sleek, rounded design with precise detailing of the iconic Chiefs logo—perfect for any fan’s home, office, or collection.',
            'led-zeppelin-ramble-on-cover' => 'Showcase your Ramdlc pride with the Ramdlc On Frame. Expertly crafted from premium wood, this frame features intricate detailing that highlights the Ramdlc logo, making it a standout addition to any fan’s home, office, or collection.',
            'omaha-beef-cnc-creations' => 'Show your Omaha Beef pride with the Omaha Beef CNC Creation. Expertly crafted from high-quality wood, this frame features a detailed engraving of the Omaha Beef logo, making it a perfect display piece for any fan’s home, office, or collection.',
            'omaha-fire-frame' => 'Ignite your passion for Omaha Fire with the Omaha Fire Frame. Expertly crafted from premium wood, this frame features intricate detailing of the Omaha Fire logo, making it a striking addition to your home, office, or fan collection.',
            'pink-floyd' => 'Celebrate the legendary Pink Floyd with this stunning frame. Crafted from premium wood, this frame features intricate detailing that highlights the iconic Pink Floyd logo, making it a must-have for any fan’s collection.',
            'raiders' => 'Show your Raiders pride with this CNC wooden frame. Crafted from premium wood, it features detailed engraving of the iconic logo, perfect for displaying in your home, office, or fan cave. A timeless keepsake for any true fan.',
            'sf-cnc-creations' => 'Show off your San Francisco pride with the SF CNC Creation. Expertly crafted from premium wood, this frame features a detailed, precise engraving of the iconic SF logo, making it a perfect addition to any fan’s home, office, or collection.',
            'steelers-frame' => 'Show your Steelers pride with the Steelers Frame. Expertly crafted from premium wood, this frame features detailed engravings of the iconic Steelers logo, making it the perfect addition to any fan’s home, office, or collection.',
            'abstract-3d-cnc-model' => 'Unleash creativity with the Abstract 3D CNC Model. Featuring bold and unconventional patterns, it’s perfect for unique decor, artistic panels, or furniture accents.',
            'ashholes-o-g-3d-butcher-block' => 'Create stunning borders and accents with the Ornamental Frame 3D CNC Model. Perfect for mirrors, picture frames, and architectural details.',
            'classic-scroll-3d-cnc-model' => 'Elevate your designs with the timeless elegance of the Classic Scroll 3D CNC Model. Perfect for furniture accents, architectural trim, or decorative panels.',
            'croc-3d-model' => 'Bring wildlife to life with the Animal-Themed 3D CNC Model. Featuring detailed animal designs, it’s perfect for sculptures, decorative panels, or custom art projects.',
            'crocodile-relief-3d-cnc-model' => 'Bring the crocodile to life with the Crocodile Relief 3D CNC Model. Perfect for sculptures, plaques, or nature-themed art projects.',
            'crocodile-wall-art-3d-cnc-model' => 'Showcase the fierce beauty of nature with the Crocodile Wall Art 3D CNC Model. Featuring intricate details, it’s perfect for creating standout decor or custom projects.',
            'decorative-3d-cnc-model-each' => 'Add elegance to your projects with the Decorative Corner 3D CNC Model. Perfect for enhancing furniture, cabinetry, or architectural details.',
            'decorative-floral-3d-cnc-model' => 'Enhance your projects with this Decorative Floral 3D CNC Model. Featuring intricate floral patterns, it’s perfect for furniture, wall panels, or custom decor.',
            'geometric-3d-cnc-model' => 'Add a modern touch to your designs with the Geometric 3D CNC Model. Featuring bold, precise patterns, it’s ideal for architectural details, furniture, or statement pieces.',
            'classic-wooden-jewelry-box' => 'Store your treasures in timeless elegance with the Classic Wooden Jewelry Box. Made from premium wood, it features multiple compartments and a smooth finish for organized and stylish storage.',
            'custom-jewelry-box' => 'Take your jewelry on the go with the Travel Jewelry Box. Compact, lightweight, and stylish, it features secure compartments to protect your accessories wherever you are.',
            'elegant-mirror-jewelry-box' => 'Add a touch of glamour with the Elegant Mirror Jewelry Box. Featuring a sleek mirrored exterior and spacious compartments, it’s a stunning way to keep your jewelry safe and organized.',
            'examples-of-urn-or-keepsake' => 'Store your treasures in the soft elegance of the Luxurious Velvet Jewelry Box. This plush design features compartments for all your favorite pieces, keeping them secure and beautifully displayed.',
            'jewelery-box' => 'Store your treasures in style with this beautifully crafted Jewelry Box. Made from premium materials, it features an elegant design with compartments to keep your jewelry organized and protected.',
            'personalized-jewelry-box' => 'Create a meaningful keepsake with the Personalized Jewelry Box. Crafted with care and customizable with names or initials, it’s the perfect way to store and cherish your jewelry.',
            'build-your-own-game-kit' => 'Unleash your imagination with the Build-Your-Own Game Kit. Includes everything you need to design, create, and play your very own board game.',
            'custom-game-pieces-set' => 'Enhance your board game with a Custom Game Pieces Set. Tailored to your design, these pieces add a personal and creative touch to your gaming experience.',
            'personalized-game-board' => 'Bring your creativity to life with a Personalized Game Board. Fully customizable, it’s perfect for creating unique board games tailored to your family, friends, or special events.',
        ];

        foreach ($catalog as $categoryName => $products) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'description' => 'Handcrafted '.$categoryName.' made with precision, care, and a premium finish.',
                    'is_active' => true,
                ],
            );

            foreach ($products as $index => $data) {
                $slug = Str::slug($data['name']);
                $description = $liveDescriptions[$slug] ?? $data['description'];

                $stockQuantity = 12;
                $product = Product::updateOrCreate(['slug' => $slug], [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'slug' => $slug,
                    'short_description' => Str::substr($description, 0, 255),
                    'description' => $description,
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'],
                    'sku' => 'JDM-'.Str::upper(Str::substr(md5($slug), 0, 8)),
                    'total_stock_quantity' => $stockQuantity,
                    'available_stock_quantity' => $stockQuantity,
                    'is_active' => true,
                    'is_featured' => $index === 0,
                ]);

                $product->images()->updateOrCreate(['sort_order' => 0], [
                    'path' => $data['image'] ?? 'https://placehold.co/600x600?text='.urlencode($data['name']),
                    'alt_text' => $data['name'],
                ]);

                $sortOrder = 0;
                foreach ($data['specs'] as $key => $value) {
                    $product->specifications()->updateOrCreate(['spec_key' => $key], [
                        'spec_key' => $key,
                        'spec_value' => $value,
                        'sort_order' => $sortOrder++,
                    ]);
                }

                if (! empty($data['variations'])) {
                    foreach ($data['variations'] as $variation) {
                        $product->variations()->updateOrCreate([
                            'attribute_name' => $variation['attribute_name'],
                            'attribute_value' => $variation['attribute_value'],
                        ], $variation + [
                            'sku' => $product->sku.'-'.Str::slug($variation['attribute_value']),
                            'stock_quantity' => 12,
                        ]);
                    }
                }
            }
        }
        $this->syncVerifiedWebsiteProducts();
    }

    private function syncVerifiedWebsiteProducts(): void
    {
        $items = json_decode(file_get_contents(__DIR__.'/data/jdm-products.json'), true, 512, JSON_THROW_ON_ERROR);
        foreach ($items as $item) {
            $name = html_entity_decode(trim($item['name']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $product = Product::where('slug', Str::slug($name))->firstOrFail();
            $categoryData = $item['categories'][0];
            $category = Category::updateOrCreate(['slug' => $categoryData['slug']], [
                'name' => html_entity_decode($categoryData['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'is_active' => true,
            ]);
            $plainText = static function (string $html): string {
                $html = preg_replace('/<\/(p|li|h[1-6])>|<br\s*\/?\s*>/i', "\n", $html);
                return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            };
            $divisor = 10 ** $item['prices']['currency_minor_unit'];
            $product->update([
                'name' => $name,
                'category_id' => $category->id,
                'short_description' => Str::substr($plainText($item['short_description']), 0, 255),
                'description' => $plainText($item['description']),
                'price' => (float) $item['prices']['regular_price'] / $divisor,
                'sale_price' => $item['on_sale'] ? (float) $item['prices']['sale_price'] / $divisor : null,
            ]);
            foreach ($item['images'] as $order => $image) {
                $localPath = '/images/catalog/source-'.$item['id'].'-'.$order.'.jpg';
                $product->images()->updateOrCreate(['sort_order' => $order], [
                    'path' => is_file(public_path($localPath)) ? $localPath : $image['src'],
                    'alt_text' => $image['alt'] ?: $name,
                ]);
            }
        }
    }
}

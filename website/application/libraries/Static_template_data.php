<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Static_template_data
 * Provides 100% static template data for Template 1 (Fashion) cloned from ecommerce-single/website
 * with zero database queries required.
 */
class Static_template_data {

    public static function get_all() {
        static $data = null;
        if ($data === null) {
            $data = array (
  'settings' => 
  array (
    'site_name' => 'Codeulas',
    'site_email' => 'contact@modave-shop.com',
    'site_phone' => '+1 (800) 555-0199',
    'site_address' => '123 Commerce Way, Suite 500, New York, NY 10001',
    'currency_code' => 'INR',
    'currency_symbol' => '₹',
    'shipping_flat_rate' => '50.00',
    'free_shipping_min' => '150.00',
    'tax_rate_percent' => '10',
    'enable_stripe' => '1',
    'enable_razorpay' => '1',
    'enable_payu' => '1',
    'enable_cod' => '1',
    'shipping_express_rate' => '25.00',
    'shipping_free_threshold' => '150.00',
    'tax_rate' => '10',
    'admin_email' => 'contact@modave-shop.com',
    'support_phone' => '+1 (800) 555-0199',
    'timezone' => 'America/New_York',
    'store_address' => '123 Commerce Way, Suite 500, New York, NY 10001',
    'currency' => 'INR',
    'default_payment_gateway' => 'razorpay',
    'active_online_gateway' => 'razorpay',
    'tax_enabled' => '1',
    'tax_inclusive' => '1',
    'shipping_charges' => '[{"name":"Courier Charges","value":50}]',
    'shipping_dispatch_note' => 'Dispatched within 24-48 hours with courier tracking.',
  ),
  'banners' => 
  array (
    0 => 
    array (
      'id' => 1,
      'title' => 'Glamour & GraceNew Season Styles',
      'subtitle' => 'SUMMER COLLECTION 2026',
      'button_text' => 'Explore Collection',
      'button_link' => 'shop',
      'image' => 'slider/slider_1788717707_838.jpg',
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-07 13:04:48',
    ),
    1 => 
    array (
      'id' => 2,
      'title' => 'Next-Gen Audio &Smart Tech Essentials',
      'subtitle' => 'PREMIUM SOUND, ZERO NOISE',
      'button_text' => 'Shop Electronics',
      'button_link' => 'shop?category=consumer-electronics',
      'image' => 'slider/slider_1788717733_750.jpg',
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-07 13:04:48',
    ),
    2 => 
    array (
      'id' => 3,
      'title' => 'Step Into Comfort
Performance Footwear',
      'subtitle' => 'RUNNING & CASUAL SNEAKERS',
      'button_text' => 'Discover Footwear',
      'button_link' => 'shop?category=sneakers-shoes',
      'image' => 'slider/slider-sneaker-1.jpg',
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-07 13:04:48',
    ),
  ),
  'all_categories' => 
  array (
    0 => 
    array (
      'id' => 91,
      'parent_id' => 32,
      'name' => '100% Organic Cotton Onesies',
      'slug' => 'cotton-baby-onesies',
      'description' => 'Hypoallergenic nickel-free snap baby bodysuits.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    1 => 
    array (
      'id' => 120,
      'parent_id' => 119,
      'name' => 'Artisanal Teas & Specialty Coffee',
      'slug' => 'artisanal-teas-coffee',
      'description' => 'Whole-bean single origin roasts and loose leaf green teas.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    2 => 
    array (
      'id' => 105,
      'parent_id' => 104,
      'name' => 'Automatic Mechanical Watches',
      'slug' => 'automatic-mechanical-watches',
      'description' => 'Exhibition caseback self-winding sapphire crystal watches.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    3 => 
    array (
      'id' => 32,
      'parent_id' => 7,
      'name' => 'Baby Clothing & Rompers',
      'slug' => 'baby-clothing',
      'description' => 'Organic cotton onesies, soft knit sets and sleeper outfits.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    4 => 
    array (
      'id' => 124,
      'parent_id' => 123,
      'name' => 'California Raw Almonds & Walnuts',
      'slug' => 'raw-almonds-walnuts',
      'description' => 'Non-GMO unpasteurized organic California nuts.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    5 => 
    array (
      'id' => 34,
      'parent_id' => 9,
      'name' => 'Camping & Hiking Gear',
      'slug' => 'camping-gear',
      'description' => 'Waterproof dome tents, lightweight sleeping bags and trekking poles.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    6 => 
    array (
      'id' => 127,
      'parent_id' => 126,
      'name' => 'Canine Dog Care & Nutrition',
      'slug' => 'dog-care-nutrition',
      'description' => 'Premium grain-free dog kibble, dental chews and beds.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    7 => 
    array (
      'id' => 15,
      'parent_id' => 2,
      'name' => 'Casual Shirts & Polos',
      'slug' => 'mens-shirts',
      'description' => 'Slim-fit cotton shirts, casual linen button-ups and classic polos.',
      'image' => 'products/mens/men-11.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    8 => 
    array (
      'id' => 134,
      'parent_id' => 133,
      'name' => 'Consoles & VR Systems',
      'slug' => 'consoles-vr-systems',
      'description' => 'Immersive spatial VR headsets and 4K console gaming.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    9 => 
    array (
      'id' => 111,
      'parent_id' => 110,
      'name' => 'Crime & Psychological Thrillers',
      'slug' => 'crime-psychological-thrillers',
      'description' => 'Page-turning suspense, murder mysteries and detective fiction.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    10 => 
    array (
      'id' => 101,
      'parent_id' => 100,
      'name' => 'Diamond Engagement Rings',
      'slug' => 'diamond-engagement-rings',
      'description' => 'Certified brilliant-cut solitaire and halo diamond rings.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    11 => 
    array (
      'id' => 11,
      'parent_id' => 1,
      'name' => 'Dresses & Frocks',
      'slug' => 'womens-dresses',
      'description' => 'Designer evening gowns, party wear, maxi and summer dresses.',
      'image' => 'products/womens/women-10.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    12 => 
    array (
      'id' => 138,
      'parent_id' => 137,
      'name' => 'Ergonomic Reclining Gaming Chairs',
      'slug' => 'reclining-gaming-chairs',
      'description' => 'Lumbar support cushions, 4D armrests and steel frames.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    13 => 
    array (
      'id' => 36,
      'parent_id' => 11,
      'name' => 'Evening Gowns & Cocktail Dresses',
      'slug' => 'evening-gowns',
      'description' => 'Luxurious velvet and satin formal evening dresses.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    14 => 
    array (
      'id' => 26,
      'parent_id' => 5,
      'name' => 'Facial Care & Serums',
      'slug' => 'face-care-serums',
      'description' => 'Hydrating hyaluronic serums, vitamin C brightening and moistures.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    15 => 
    array (
      'id' => 110,
      'parent_id' => 10,
      'name' => 'Fiction & Literature',
      'slug' => 'fiction-literature',
      'description' => 'Bestselling crime thrillers, sci-fi and historical novels.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    16 => 
    array (
      'id' => 100,
      'parent_id' => 8,
      'name' => 'Fine Jewelry & Gems',
      'slug' => 'fine-jewelry',
      'description' => 'Diamond rings, solid 18K gold and sterling silver masterworks.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    17 => 
    array (
      'id' => 60,
      'parent_id' => 19,
      'name' => 'Flagship 5G Smartphones',
      'slug' => 'flagship-5g-smartphones',
      'description' => 'OLED display, pro triple cameras and high-speed 5G.',
      'image' => 'products/electronic/electronic-10.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 1,
    ),
    18 => 
    array (
      'id' => 57,
      'parent_id' => 18,
      'name' => 'Fleece Zip & Pullover Hoodies',
      'slug' => 'fleece-hoodies',
      'description' => 'Cozy brushed fleece hooded sweatshirts with kangaroo pockets.',
      'image' => 'products/mens/men-15.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    19 => 
    array (
      'id' => 128,
      'parent_id' => 127,
      'name' => 'Grain-Free High-Protein Dog Food',
      'slug' => 'grain-free-dog-food',
      'description' => 'Real salmon and turkey formula enriched with probiotics.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    20 => 
    array (
      'id' => 74,
      'parent_id' => 25,
      'name' => 'Handcrafted Oxford Brogues',
      'slug' => 'handcrafted-oxford-brogues',
      'description' => 'Goodyear welted calfskin leather cap-toe dress shoes.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    21 => 
    array (
      'id' => 117,
      'parent_id' => 116,
      'name' => 'Hardcover Dot Grid Journals',
      'slug' => 'hardcover-dot-journals',
      'description' => '160 GSM bleed-proof bamboo paper notebook planners.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    22 => 
    array (
      'id' => 65,
      'parent_id' => 21,
      'name' => 'High-Performance Gaming Laptops',
      'slug' => 'gaming-laptops',
      'description' => 'RTX graphics, 165Hz displays and RGB backlit keyboards.',
      'image' => 'products/electronic/electronic-12.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    23 => 
    array (
      'id' => 98,
      'parent_id' => 35,
      'name' => 'High-Waist Compression Leggings',
      'slug' => 'compression-yoga-leggings',
      'description' => 'Squat-proof seamless four-way stretch athletic tights.',
      'image' => 'products/activewear/activewear-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    24 => 
    array (
      'id' => 43,
      'parent_id' => 13,
      'name' => 'High-Waist Flare Jeans',
      'slug' => 'high-waist-flare-jeans',
      'description' => 'Flattering retro flare and bell-bottom denim jeans.',
      'image' => 'products/womens/grid-3.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    25 => 
    array (
      'id' => 76,
      'parent_id' => 26,
      'name' => 'Hyaluronic Hydrating Serums',
      'slug' => 'hyaluronic-hydrating-serums',
      'description' => 'Multi-molecular weight hyaluronic acid for deep hydration.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    26 => 
    array (
      'id' => 114,
      'parent_id' => 113,
      'name' => 'Investing & Wealth Building',
      'slug' => 'investing-wealth-building',
      'description' => 'Stock market, financial freedom and real estate masteries.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    27 => 
    array (
      'id' => 108,
      'parent_id' => 107,
      'name' => 'Leather Crossbody Bags',
      'slug' => 'leather-crossbody-bags',
      'description' => 'Structured compact bags with adjustable chain straps.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    28 => 
    array (
      'id' => 29,
      'parent_id' => 6,
      'name' => 'Living Room Furniture',
      'slug' => 'living-room-furniture',
      'description' => 'Scandinavian sectionals, armchairs, coffee tables and TV consoles.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    29 => 
    array (
      'id' => 79,
      'parent_id' => 27,
      'name' => 'Long-Lasting Matte Lipsticks',
      'slug' => 'matte-lipsticks',
      'description' => 'Smudge-proof rich pigmented velvety liquid lipsticks.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    30 => 
    array (
      'id' => 72,
      'parent_id' => 24,
      'name' => 'Low-Top Leather Court Shoes',
      'slug' => 'low-top-court-shoes',
      'description' => 'Clean minimalist white leather sneakers with rubber cupsole.',
      'image' => 'products/sneaker/color-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    31 => 
    array (
      'id' => 93,
      'parent_id' => 33,
      'name' => 'Montessori Wooden Shape Sorters',
      'slug' => 'montessori-wooden-toys',
      'description' => 'Non-toxic water-based painted cognitive learning blocks.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    32 => 
    array (
      'id' => 131,
      'parent_id' => 130,
      'name' => 'Multi-Level Sisal Cat Trees',
      'slug' => 'sisal-cat-trees',
      'description' => 'Sturdy climbing towers with hammocks and scratching posts.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    33 => 
    array (
      'id' => 89,
      'parent_id' => 31,
      'name' => 'Nordic Pendant Hanging Lights',
      'slug' => 'nordic-pendant-lights',
      'description' => 'Modern industrial matte metal shades for dining and kitchens.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    34 => 
    array (
      'id' => 121,
      'parent_id' => 120,
      'name' => 'Organic Ceremonial Matcha & Green Tea',
      'slug' => 'matcha-green-tea',
      'description' => 'Stone-ground first-harvest Japanese ceremonial grade matcha.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    35 => 
    array (
      'id' => 52,
      'parent_id' => 16,
      'name' => 'Oversized Streetwear Tees',
      'slug' => 'streetwear-graphic-tees',
      'description' => 'Boxy drop-shoulder tees with bold streetwear artwork.',
      'image' => 'products/mens/men-14.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    36 => 
    array (
      'id' => 46,
      'parent_id' => 14,
      'name' => 'Oversized Wool Blazers',
      'slug' => 'oversized-wool-blazers',
      'description' => 'Structured tailored blazers for timeless elegance.',
      'image' => 'products/womens/grid-4.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    37 => 
    array (
      'id' => 49,
      'parent_id' => 15,
      'name' => 'Oxford Cotton Button-Downs',
      'slug' => 'oxford-cotton-shirts',
      'description' => 'Crisp breathable cotton shirts for smart-casual wear.',
      'image' => 'products/mens/men-11.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    38 => 
    array (
      'id' => 70,
      'parent_id' => 23,
      'name' => 'Road & Marathon Running Shoes',
      'slug' => 'marathon-road-running',
      'description' => 'Ultra-cushioned carbon plate marathon racing shoes.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    39 => 
    array (
      'id' => 23,
      'parent_id' => 4,
      'name' => 'Running & Athletic Shoes',
      'slug' => 'running-shoes',
      'description' => 'Performance cushion running shoes and training sneakers.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    40 => 
    array (
      'id' => 84,
      'parent_id' => 29,
      'name' => 'Sectional L-Shaped Sofas',
      'slug' => 'sectional-l-shaped-sofas',
      'description' => 'Deep seated modular couches with high-density foam cushions.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    41 => 
    array (
      'id' => 40,
      'parent_id' => 12,
      'name' => 'Silk & Satin Blouses',
      'slug' => 'silk-satin-blouses',
      'description' => 'Luxurious silk shirts and office work blouses.',
      'image' => 'products/womens/grid-2.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:37',
      'updated_at' => '2026-09-06 23:39:37',
      'product_count' => 0,
    ),
    42 => 
    array (
      'id' => 54,
      'parent_id' => 17,
      'name' => 'Slim Tapered Stretch Jeans',
      'slug' => 'slim-tapered-jeans',
      'description' => 'Comfort stretch denim jeans in clean indigo washes.',
      'image' => 'products/mens/men-13.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    43 => 
    array (
      'id' => 68,
      'parent_id' => 22,
      'name' => 'Smart Fitness Trackers & Watches',
      'slug' => 'smart-fitness-watches',
      'description' => 'Heart rate monitor, GPS tracking and AMOLED screens.',
      'image' => 'products/electronic/electronic-11.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    44 => 
    array (
      'id' => 19,
      'parent_id' => 3,
      'name' => 'Smartphones & Tablets',
      'slug' => 'smartphones-tablets',
      'description' => 'Next-gen flagship smartphones, Android tablets and iPads.',
      'image' => 'products/electronic/electronic-10.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    45 => 
    array (
      'id' => 135,
      'parent_id' => 134,
      'name' => 'Standalone Wireless VR Headsets',
      'slug' => 'wireless-vr-headsets',
      'description' => 'High-res lenses with 6DoF inside-out tracking controllers.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    46 => 
    array (
      'id' => 82,
      'parent_id' => 28,
      'name' => 'Sulfate-Free Keratin Shampoos',
      'slug' => 'keratin-shampoos',
      'description' => 'Strengthening organic botanical cleansers for color-treated hair.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    47 => 
    array (
      'id' => 38,
      'parent_id' => 20,
      'name' => 'True Wireless Earbuds',
      'slug' => 'wireless-earbuds',
      'description' => 'Compact Bluetooth earbuds with wireless charging cases.',
      'image' => 'products/electronic/electronic-11.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 1,
    ),
    48 => 
    array (
      'id' => 87,
      'parent_id' => 30,
      'name' => 'Upholstered Platform Beds',
      'slug' => 'platform-bed-frames',
      'description' => 'Minimalist winged headboard frames with wooden slat supports.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    49 => 
    array (
      'id' => 95,
      'parent_id' => 34,
      'name' => 'Waterproof 4-Person Camping Tents',
      'slug' => 'waterproof-camping-tents',
      'description' => 'Double-layer ripstop polyester dome tent with rainfly.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 0,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    50 => 
    array (
      'id' => 1,
      'parent_id' => 0,
      'name' => 'Womens Fashion',
      'slug' => 'womens-fashion',
      'description' => 'Trending womens dresses, tops, outerwear and designer collections.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
    ),
    51 => 
    array (
      'id' => 102,
      'parent_id' => 100,
      'name' => '18K Gold Necklaces & Pendants',
      'slug' => 'gold-necklaces-pendants',
      'description' => 'Delicate gold chain necklaces, medallions and charms.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    52 => 
    array (
      'id' => 35,
      'parent_id' => 9,
      'name' => 'Activewear & Fitness',
      'slug' => 'activewear-training',
      'description' => 'Compression tights, moisture-wicking tees and yoga gear.',
      'image' => 'products/activewear/activewear-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    53 => 
    array (
      'id' => 132,
      'parent_id' => 130,
      'name' => 'Automatic Laser & Feather Toys',
      'slug' => 'automatic-cat-toys',
      'description' => 'Rechargeable motion-activated interactive entertainment.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    54 => 
    array (
      'id' => 30,
      'parent_id' => 6,
      'name' => 'Bedroom & Bedding',
      'slug' => 'bedroom-furniture',
      'description' => 'Solid wood beds, orthopedic mattresses and Egyptian cotton sheets.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    55 => 
    array (
      'id' => 113,
      'parent_id' => 10,
      'name' => 'Business & Self-Help',
      'slug' => 'business-self-help',
      'description' => 'Personal finance, leadership, startups and mindfulness.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    56 => 
    array (
      'id' => 118,
      'parent_id' => 116,
      'name' => 'Calligraphy & Fountain Pens',
      'slug' => 'calligraphy-fountain-pens',
      'description' => 'Iridium nib pens with piston converters and archival ink.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    57 => 
    array (
      'id' => 37,
      'parent_id' => 11,
      'name' => 'Casual & Floral Summer Dresses',
      'slug' => 'casual-summer-dresses',
      'description' => 'Breezy linen sundresses, wrap dresses and floral prints.',
      'image' => 'products/womens/women-10.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    58 => 
    array (
      'id' => 24,
      'parent_id' => 4,
      'name' => 'Casual Street Sneakers',
      'slug' => 'casual-sneakers',
      'description' => 'Retro court shoes, low-top canvas sneakers and slip-ons.',
      'image' => 'products/sneaker/color-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    59 => 
    array (
      'id' => 125,
      'parent_id' => 123,
      'name' => 'Chia Seeds & Roasted Flax',
      'slug' => 'chia-roasted-flax',
      'description' => 'High fiber, omega-3 rich organic whole food seeds.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    60 => 
    array (
      'id' => 94,
      'parent_id' => 33,
      'name' => 'Creative Building Block Sets',
      'slug' => 'creative-building-blocks',
      'description' => 'Interlocking colorful architectural play bricks for kids.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    61 => 
    array (
      'id' => 90,
      'parent_id' => 31,
      'name' => 'Dimmable Standing Floor Lamps',
      'slug' => 'standing-floor-lamps',
      'description' => 'Touch-sensor arching floor lamps with warm amber glow.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    62 => 
    array (
      'id' => 130,
      'parent_id' => 126,
      'name' => 'Feline Cat Supplies & Scratchers',
      'slug' => 'cat-supplies-scratchers',
      'description' => 'Cat condos, natural litter and playful teaser toys.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    63 => 
    array (
      'id' => 137,
      'parent_id' => 133,
      'name' => 'Gaming Chairs & Battlestation Gear',
      'slug' => 'gaming-battlestation-gear',
      'description' => 'Ergonomic racing chairs, mousepads and controller docks.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    64 => 
    array (
      'id' => 41,
      'parent_id' => 12,
      'name' => 'Graphic & Printed Tees',
      'slug' => 'womens-graphic-tees',
      'description' => 'Fun, vintage and artistic graphic t-shirts.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    65 => 
    array (
      'id' => 115,
      'parent_id' => 113,
      'name' => 'Habits & Mental Models',
      'slug' => 'habits-mental-models',
      'description' => 'Proven frameworks for focus, willpower and continuous growth.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    66 => 
    array (
      'id' => 20,
      'parent_id' => 3,
      'name' => 'Headphones & Audio',
      'slug' => 'audio-headphones',
      'description' => 'Noise cancelling headphones, bluetooth speakers and wireless buds.',
      'image' => 'products/electronic/electronic-11.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    67 => 
    array (
      'id' => 53,
      'parent_id' => 16,
      'name' => 'Heavyweight Crewneck T-Shirts',
      'slug' => 'heavyweight-crewnecks',
      'description' => 'Thick 240 GSM organic cotton solid basic tees.',
      'image' => 'products/mens/men-15.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    68 => 
    array (
      'id' => 73,
      'parent_id' => 24,
      'name' => 'High-Top Retro Streetwear',
      'slug' => 'high-top-retro-sneakers',
      'description' => 'Padded ankle collar retro basketball silhouettes.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    69 => 
    array (
      'id' => 58,
      'parent_id' => 18,
      'name' => 'Leather Biker & Bomber Jackets',
      'slug' => 'leather-bomber-jackets',
      'description' => 'Genuine leather flight jackets and zip-front bombers.',
      'image' => 'products/mens/men-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    70 => 
    array (
      'id' => 47,
      'parent_id' => 14,
      'name' => 'Leather Moto Biker Jackets',
      'slug' => 'leather-moto-jackets',
      'description' => 'Classic faux and genuine leather motorcycle jackets.',
      'image' => 'products/womens/grid-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    71 => 
    array (
      'id' => 50,
      'parent_id' => 15,
      'name' => 'Linen Vacation Shirts',
      'slug' => 'linen-vacation-shirts',
      'description' => 'Lightweight breezy linen shirts in pastel tones.',
      'image' => 'products/mens/men-12.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    72 => 
    array (
      'id' => 80,
      'parent_id' => 27,
      'name' => 'Liquid Glow Foundations',
      'slug' => 'glow-foundations',
      'description' => 'Buildable medium-to-full coverage with dewy radiant finish.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    73 => 
    array (
      'id' => 104,
      'parent_id' => 8,
      'name' => 'Luxury Wristwatches',
      'slug' => 'luxury-watches',
      'description' => 'Swiss automatic chronographs and dress wrist timepieces.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    74 => 
    array (
      'id' => 27,
      'parent_id' => 5,
      'name' => 'Makeup & Cosmetics',
      'slug' => 'makeup-cosmetics',
      'description' => 'Liquid lipsticks, mineral foundations, eye shadow palettes and mascara.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    75 => 
    array (
      'id' => 2,
      'parent_id' => 0,
      'name' => 'Mens Collection',
      'slug' => 'mens-collection',
      'description' => 'Modern mens shirts, jackets, pants, suits and casual wear.',
      'image' => 'products/mens/men-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
    ),
    76 => 
    array (
      'id' => 106,
      'parent_id' => 104,
      'name' => 'Minimalist Leather Dress Watches',
      'slug' => 'minimalist-dress-watches',
      'description' => 'Slim stainless steel cases with Italian genuine leather straps.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    77 => 
    array (
      'id' => 99,
      'parent_id' => 35,
      'name' => 'Moisture-Wicking Athletic Tops',
      'slug' => 'moisture-wicking-tops',
      'description' => 'Quick-dry workout performance t-shirts and racerback bras.',
      'image' => 'products/activewear/activewear-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    78 => 
    array (
      'id' => 136,
      'parent_id' => 134,
      'name' => 'Next-Gen Ultra HD Consoles',
      'slug' => 'next-gen-consoles',
      'description' => 'Ray-tracing enabled gaming systems with ultra-fast SSDs.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    79 => 
    array (
      'id' => 123,
      'parent_id' => 119,
      'name' => 'Nuts, Seeds & Dried Superfoods',
      'slug' => 'nuts-seeds-superfoods',
      'description' => 'Nutrient-rich raw nuts, organic seeds and cold snacks.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    80 => 
    array (
      'id' => 129,
      'parent_id' => 127,
      'name' => 'Orthopedic Memory Foam Dog Beds',
      'slug' => 'orthopedic-dog-beds',
      'description' => 'Waterproof removable cover joint-relief pet mattresses.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    81 => 
    array (
      'id' => 88,
      'parent_id' => 30,
      'name' => 'Orthopedic Memory Foam Mattresses',
      'slug' => 'orthopedic-mattresses',
      'description' => 'Zero motion transfer pressure-relieving cool gel foam.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    82 => 
    array (
      'id' => 39,
      'parent_id' => 20,
      'name' => 'Over-Ear ANC Headphones',
      'slug' => 'over-ear-headphones',
      'description' => 'Active noise cancelling studio quality headphones.',
      'image' => 'products/electronic/electronic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    83 => 
    array (
      'id' => 75,
      'parent_id' => 25,
      'name' => 'Penny & Tassel Loafers',
      'slug' => 'penny-tassel-loafers',
      'description' => 'Slip-on dress shoes with genuine leather outsoles.',
      'image' => 'products/sneaker/color-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    84 => 
    array (
      'id' => 44,
      'parent_id' => 13,
      'name' => 'Pleated Midi Skirts',
      'slug' => 'pleated-midi-skirts',
      'description' => 'Elegant high-waisted pleated and A-line midi skirts.',
      'image' => 'products/womens/grid-4.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    85 => 
    array (
      'id' => 83,
      'parent_id' => 28,
      'name' => 'Pure Moroccan Argan Hair Oils',
      'slug' => 'argan-hair-oils',
      'description' => 'Silky lightweight anti-frizz shine serum and split-end repair.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    86 => 
    array (
      'id' => 55,
      'parent_id' => 17,
      'name' => 'Relaxed Fit Cargo Pants',
      'slug' => 'mens-cargo-pants',
      'description' => 'Utility multi-pocket tactical cargo trousers.',
      'image' => 'products/mens/men-14.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    87 => 
    array (
      'id' => 112,
      'parent_id' => 110,
      'name' => 'Sci-Fi & Epic Fantasy',
      'slug' => 'scifi-epic-fantasy',
      'description' => 'Space operas, dystopian futures and magical world-building.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    88 => 
    array (
      'id' => 122,
      'parent_id' => 120,
      'name' => 'Single-Origin Arabica Coffee Beans',
      'slug' => 'single-origin-arabica',
      'description' => 'Medium dark roasted beans with chocolate notes.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    89 => 
    array (
      'id' => 69,
      'parent_id' => 22,
      'name' => 'Smart Security Cameras & Hubs',
      'slug' => 'smart-home-cameras',
      'description' => '1080p HD night vision, motion alerts and WiFi app control.',
      'image' => 'products/electronic/electronic-13.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    90 => 
    array (
      'id' => 109,
      'parent_id' => 107,
      'name' => 'Spacious Work Tote Bags',
      'slug' => 'spacious-work-totes',
      'description' => 'Laptop-friendly premium textured vegan leather totes.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    91 => 
    array (
      'id' => 16,
      'parent_id' => 2,
      'name' => 'T-Shirts & Graphic Tees',
      'slug' => 'mens-t-shirts',
      'description' => 'Oversized crewnecks, graphic printed t-shirts and gym tanks.',
      'image' => 'products/mens/men-12.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    92 => 
    array (
      'id' => 61,
      'parent_id' => 19,
      'name' => 'Tablets & Stylus Pens',
      'slug' => 'tablets-stylus',
      'description' => 'High-resolution creative tablets for artists and note-taking.',
      'image' => 'products/electronic/electronic-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    93 => 
    array (
      'id' => 66,
      'parent_id' => 21,
      'name' => 'Thin & Light Ultrabooks',
      'slug' => 'ultrabooks-laptops',
      'description' => 'All-day battery life, sleek aluminium chassis for work.',
      'image' => 'products/electronic/electronic-10.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    94 => 
    array (
      'id' => 92,
      'parent_id' => 32,
      'name' => 'Toddler Soft Knit Outfits',
      'slug' => 'toddler-knit-outfits',
      'description' => 'Breathable ribbed two-piece sets for active toddlers.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    95 => 
    array (
      'id' => 12,
      'parent_id' => 1,
      'name' => 'Tops, Tees & Blouses',
      'slug' => 'womens-tops',
      'description' => 'Casual tees, elegant silk blouses, button-downs and crop tops.',
      'image' => 'products/womens/grid-2.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    96 => 
    array (
      'id' => 33,
      'parent_id' => 7,
      'name' => 'Toys & Learning Games',
      'slug' => 'toys-games',
      'description' => 'Montessori wooden toys, puzzles, plush animals and board games.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    97 => 
    array (
      'id' => 71,
      'parent_id' => 23,
      'name' => 'Trail Running & Hiking Sneakers',
      'slug' => 'trail-running-sneakers',
      'description' => 'Lugged traction outsoles for rugged off-road paths.',
      'image' => 'products/sneaker/color-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    98 => 
    array (
      'id' => 96,
      'parent_id' => 34,
      'name' => 'Ultralight Down Sleeping Bags',
      'slug' => 'ultralight-sleeping-bags',
      'description' => 'Compact 800-fill duck down mummy sleeping bag.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    99 => 
    array (
      'id' => 85,
      'parent_id' => 29,
      'name' => 'Velvet Accent Armchairs',
      'slug' => 'velvet-accent-armchairs',
      'description' => 'Tufted mid-century lounge chairs with tapered gold metal legs.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    100 => 
    array (
      'id' => 77,
      'parent_id' => 26,
      'name' => 'Vitamin C Brightening Treatments',
      'slug' => 'vitamin-c-brightening',
      'description' => 'Stable 15% pure vitamin C serum for radiant, even skin.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    101 => 
    array (
      'id' => 139,
      'parent_id' => 137,
      'name' => 'Wireless RGB Pro Gamepads',
      'slug' => 'wireless-rgb-gamepads',
      'description' => 'Hall effect magnetic triggers and customizable paddle buttons.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 0,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
    102 => 
    array (
      'id' => 78,
      'parent_id' => 26,
      'name' => 'Anti-Aging Retinol Creams',
      'slug' => 'anti-aging-retinol',
      'description' => 'Gentle encapsulated retinol formula for firming fine lines.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    103 => 
    array (
      'id' => 63,
      'parent_id' => 20,
      'name' => 'Bluetooth Party Speakers',
      'slug' => 'bluetooth-party-speakers',
      'description' => 'Waterproof outdoor speakers with deep bass.',
      'image' => 'products/electronic/electronic-12.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    104 => 
    array (
      'id' => 97,
      'parent_id' => 34,
      'name' => 'Carbon Fiber Trekking Poles',
      'slug' => 'carbon-trekking-poles',
      'description' => 'Quick-lock shock-absorbing telescopic hiking sticks.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    105 => 
    array (
      'id' => 56,
      'parent_id' => 17,
      'name' => 'Classic Khaki Chinos',
      'slug' => 'classic-khaki-chinos',
      'description' => 'Wrinkle-resistant tailored slim-fit stretch chinos.',
      'image' => 'products/mens/men-11.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    106 => 
    array (
      'id' => 3,
      'parent_id' => 0,
      'name' => 'Consumer Electronics',
      'slug' => 'electronics',
      'description' => 'High-tech gadgets, audio equipment, smartphones, and accessories.',
      'image' => 'products/electronic/electronic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
    ),
    107 => 
    array (
      'id' => 42,
      'parent_id' => 12,
      'name' => 'Crop Tops & Halters',
      'slug' => 'crop-tops-halters',
      'description' => 'Trendy summer crop tops, camisoles and halter necklines.',
      'image' => 'products/womens/women-10.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    108 => 
    array (
      'id' => 17,
      'parent_id' => 2,
      'name' => 'Denim & Chinos',
      'slug' => 'mens-jeans',
      'description' => 'Stretch skinny jeans, relaxed fit denim and smart chinos.',
      'image' => 'products/mens/men-13.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    109 => 
    array (
      'id' => 107,
      'parent_id' => 8,
      'name' => 'Designer Handbags & Clutches',
      'slug' => 'designer-handbags',
      'description' => 'Luxury leather shoulder bags, crossbody and party clutches.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    110 => 
    array (
      'id' => 81,
      'parent_id' => 27,
      'name' => 'Eyeshadow Palettes & Eyeliners',
      'slug' => 'eyeshadow-palettes',
      'description' => 'Multi-finish shimmer and matte warm neutral palettes.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    111 => 
    array (
      'id' => 116,
      'parent_id' => 10,
      'name' => 'Fine Stationery & Planners',
      'slug' => 'stationery-planners',
      'description' => 'Fountain pen inks, dotted bullet journals and desk tools.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    112 => 
    array (
      'id' => 25,
      'parent_id' => 4,
      'name' => 'Formal Oxfords & Loafers',
      'slug' => 'formal-shoes',
      'description' => 'Leather dress shoes, penny loafers and monk strap footwear.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    113 => 
    array (
      'id' => 28,
      'parent_id' => 5,
      'name' => 'Hair Care & Oils',
      'slug' => 'hair-care',
      'description' => 'Sulfate-free shampoos, biotin hair masks and nourishing argan oils.',
      'image' => 'products/beauty-cosmetic/beauty10.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    114 => 
    array (
      'id' => 21,
      'parent_id' => 3,
      'name' => 'Laptops & Computers',
      'slug' => 'laptops-computers',
      'description' => 'Ultralight work laptops, gaming rigs, monitors and accessories.',
      'image' => 'products/electronic/electronic-12.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    115 => 
    array (
      'id' => 86,
      'parent_id' => 29,
      'name' => 'Marble & Wood Coffee Tables',
      'slug' => 'marble-coffee-tables',
      'description' => 'Tempered glass and solid oak round center tables.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    116 => 
    array (
      'id' => 67,
      'parent_id' => 21,
      'name' => 'Mechanical Keyboards & Mice',
      'slug' => 'pc-gaming-peripherals',
      'description' => 'Hot-swappable mechanical switches and precision optical mice.',
      'image' => 'products/electronic/electronic-14.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    117 => 
    array (
      'id' => 31,
      'parent_id' => 6,
      'name' => 'Modern Lighting & Lamps',
      'slug' => 'lighting-lamps',
      'description' => 'Minimalist pendant lights, warm ambient floor lamps and desk lights.',
      'image' => 'products/furniture/furniture1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    118 => 
    array (
      'id' => 13,
      'parent_id' => 1,
      'name' => 'Pants, Jeans & Skirts',
      'slug' => 'womens-bottomwear',
      'description' => 'High-waisted trousers, denim jeans, midi and pleated skirts.',
      'image' => 'products/womens/grid-3.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    119 => 
    array (
      'id' => 62,
      'parent_id' => 19,
      'name' => 'Phone Cases & Screen Protectors',
      'slug' => 'phone-cases-protectors',
      'description' => 'Shockproof armor cases and 9H tempered glass.',
      'image' => 'products/electronic/electronic-14.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    120 => 
    array (
      'id' => 59,
      'parent_id' => 18,
      'name' => 'Puffer Down Winter Jackets',
      'slug' => 'puffer-winter-jackets',
      'description' => 'Insulated quilted puffer parkas for cold weather.',
      'image' => 'products/mens/men-12.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    121 => 
    array (
      'id' => 51,
      'parent_id' => 15,
      'name' => 'Slim-Fit Pique Polos',
      'slug' => 'slim-fit-polos',
      'description' => 'Classic embroidered collar polos with athletic stretch.',
      'image' => 'products/mens/men-13.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 1,
    ),
    122 => 
    array (
      'id' => 45,
      'parent_id' => 13,
      'name' => 'Tailored Wide-Leg Trousers',
      'slug' => 'tailored-wide-leg-trousers',
      'description' => 'Chic relaxed trousers for modern professional style.',
      'image' => 'products/womens/grid-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    123 => 
    array (
      'id' => 103,
      'parent_id' => 100,
      'name' => 'Tennis & Beaded Bracelets',
      'slug' => 'tennis-bracelets',
      'description' => 'Sparkling cubic zirconia and natural gemstone wristbands.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    124 => 
    array (
      'id' => 48,
      'parent_id' => 14,
      'name' => 'Winter Trench Coats',
      'slug' => 'winter-trench-coats',
      'description' => 'Waterproof double-breasted long trench coats.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 0,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    125 => 
    array (
      'id' => 18,
      'parent_id' => 2,
      'name' => 'Jackets & Hoodies',
      'slug' => 'mens-jackets',
      'description' => 'Bomber jackets, fleece zip hoodies, windbreakers and coats.',
      'image' => 'products/mens/men-14.jpg',
      'is_featured' => 0,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    126 => 
    array (
      'id' => 14,
      'parent_id' => 1,
      'name' => 'Outerwear & Blazers',
      'slug' => 'womens-outerwear',
      'description' => 'Chic trench coats, leather jackets, cardigans and winter wear.',
      'image' => 'products/womens/grid-4.jpg',
      'is_featured' => 0,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    127 => 
    array (
      'id' => 22,
      'parent_id' => 3,
      'name' => 'Smart Home & Wearables',
      'slug' => 'wearable-tech',
      'description' => 'Fitness trackers, smart watches, smart plugs and security cams.',
      'image' => 'products/electronic/electronic-13.jpg',
      'is_featured' => 0,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    128 => 
    array (
      'id' => 4,
      'parent_id' => 0,
      'name' => 'Sneakers & Shoes',
      'slug' => 'sneakers-shoes',
      'description' => 'Athletic running shoes, street sneakers, and formal footwear.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 1,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    129 => 
    array (
      'id' => 64,
      'parent_id' => 20,
      'name' => 'Soundbars & Home Theaters',
      'slug' => 'soundbars-subwoofers',
      'description' => 'Dolby Atmos surround soundbars with wireless subwoofers.',
      'image' => 'products/electronic/electronic-13.jpg',
      'is_featured' => 0,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    130 => 
    array (
      'id' => 5,
      'parent_id' => 0,
      'name' => 'Beauty & Skincare',
      'slug' => 'beauty-skincare',
      'description' => 'Natural cosmetics, organic serums, perfumes and skin care items.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 1,
      'sort_order' => 5,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    131 => 
    array (
      'id' => 6,
      'parent_id' => 0,
      'name' => 'Home & Furniture',
      'slug' => 'furniture',
      'description' => 'Modern interior furniture, minimalist lighting and comfort chairs.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 1,
      'sort_order' => 6,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
    ),
    132 => 
    array (
      'id' => 7,
      'parent_id' => 0,
      'name' => 'Kids & Baby',
      'slug' => 'kids-baby',
      'description' => 'Clothing, toys, strollers and nursery essentials for babies and toddlers.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 7,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    133 => 
    array (
      'id' => 8,
      'parent_id' => 0,
      'name' => 'Jewelry & Accessories',
      'slug' => 'jewelry-accessories',
      'description' => 'Gold, silver, gemstone rings, necklaces, bracelets and luxury watches.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 1,
      'sort_order' => 8,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    134 => 
    array (
      'id' => 9,
      'parent_id' => 0,
      'name' => 'Sports & Outdoors',
      'slug' => 'sports-outdoors',
      'description' => 'Camping tents, hiking gear, athletic fitness apparel and gym accessories.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 1,
      'sort_order' => 9,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    135 => 
    array (
      'id' => 10,
      'parent_id' => 0,
      'name' => 'Books & Stationery',
      'slug' => 'books-stationery',
      'description' => 'Best-selling novels, academic textbooks, art supplies and fine notebooks.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 10,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    136 => 
    array (
      'id' => 119,
      'parent_id' => 0,
      'name' => 'Organic & Gourmet Pantry',
      'slug' => 'organic-gourmet',
      'description' => 'Farm-fresh organic superfoods, beverages and pantry staples.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 11,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    137 => 
    array (
      'id' => 126,
      'parent_id' => 0,
      'name' => 'Pet Supplies & Toys',
      'slug' => 'pet-supplies',
      'description' => 'Nutritious feeds, grooming tools and interactive toys for pets.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 1,
      'sort_order' => 12,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    138 => 
    array (
      'id' => 133,
      'parent_id' => 0,
      'name' => 'Gaming & Virtual Reality',
      'slug' => 'gaming-vr',
      'description' => 'Next-gen consoles, VR headsets, gaming chairs and peripherals.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 13,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
  ),
  'root_categories' => 
  array (
    0 => 
    array (
      'id' => 1,
      'parent_id' => 0,
      'name' => 'Womens Fashion',
      'slug' => 'womens-fashion',
      'description' => 'Trending womens dresses, tops, outerwear and designer collections.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
    ),
    1 => 
    array (
      'id' => 2,
      'parent_id' => 0,
      'name' => 'Mens Collection',
      'slug' => 'mens-collection',
      'description' => 'Modern mens shirts, jackets, pants, suits and casual wear.',
      'image' => 'products/mens/men-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
    ),
    2 => 
    array (
      'id' => 3,
      'parent_id' => 0,
      'name' => 'Consumer Electronics',
      'slug' => 'electronics',
      'description' => 'High-tech gadgets, audio equipment, smartphones, and accessories.',
      'image' => 'products/electronic/electronic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
    ),
    3 => 
    array (
      'id' => 4,
      'parent_id' => 0,
      'name' => 'Sneakers & Shoes',
      'slug' => 'sneakers-shoes',
      'description' => 'Athletic running shoes, street sneakers, and formal footwear.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 1,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    4 => 
    array (
      'id' => 5,
      'parent_id' => 0,
      'name' => 'Beauty & Skincare',
      'slug' => 'beauty-skincare',
      'description' => 'Natural cosmetics, organic serums, perfumes and skin care items.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 1,
      'sort_order' => 5,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    5 => 
    array (
      'id' => 6,
      'parent_id' => 0,
      'name' => 'Home & Furniture',
      'slug' => 'furniture',
      'description' => 'Modern interior furniture, minimalist lighting and comfort chairs.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 1,
      'sort_order' => 6,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
    ),
    6 => 
    array (
      'id' => 7,
      'parent_id' => 0,
      'name' => 'Kids & Baby',
      'slug' => 'kids-baby',
      'description' => 'Clothing, toys, strollers and nursery essentials for babies and toddlers.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 7,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    7 => 
    array (
      'id' => 8,
      'parent_id' => 0,
      'name' => 'Jewelry & Accessories',
      'slug' => 'jewelry-accessories',
      'description' => 'Gold, silver, gemstone rings, necklaces, bracelets and luxury watches.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 1,
      'sort_order' => 8,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    8 => 
    array (
      'id' => 9,
      'parent_id' => 0,
      'name' => 'Sports & Outdoors',
      'slug' => 'sports-outdoors',
      'description' => 'Camping tents, hiking gear, athletic fitness apparel and gym accessories.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 1,
      'sort_order' => 9,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    9 => 
    array (
      'id' => 10,
      'parent_id' => 0,
      'name' => 'Books & Stationery',
      'slug' => 'books-stationery',
      'description' => 'Best-selling novels, academic textbooks, art supplies and fine notebooks.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 10,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
    ),
    10 => 
    array (
      'id' => 119,
      'parent_id' => 0,
      'name' => 'Organic & Gourmet Pantry',
      'slug' => 'organic-gourmet',
      'description' => 'Farm-fresh organic superfoods, beverages and pantry staples.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 11,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    11 => 
    array (
      'id' => 126,
      'parent_id' => 0,
      'name' => 'Pet Supplies & Toys',
      'slug' => 'pet-supplies',
      'description' => 'Nutritious feeds, grooming tools and interactive toys for pets.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 1,
      'sort_order' => 12,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
    ),
    12 => 
    array (
      'id' => 133,
      'parent_id' => 0,
      'name' => 'Gaming & Virtual Reality',
      'slug' => 'gaming-vr',
      'description' => 'Next-gen consoles, VR headsets, gaming chairs and peripherals.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 13,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
    ),
  ),
  'category_tree' => 
  array (
    0 => 
    array (
      'id' => 1,
      'parent_id' => 0,
      'name' => 'Womens Fashion',
      'slug' => 'womens-fashion',
      'description' => 'Trending womens dresses, tops, outerwear and designer collections.',
      'image' => 'products/womens/women-1.jpg',
      'is_featured' => 1,
      'sort_order' => 1,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
      'children' => 
      array (
        0 => 
        array (
          'id' => 11,
          'parent_id' => 1,
          'name' => 'Dresses & Frocks',
          'slug' => 'womens-dresses',
          'description' => 'Designer evening gowns, party wear, maxi and summer dresses.',
          'image' => 'products/womens/women-10.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 36,
              'parent_id' => 11,
              'name' => 'Evening Gowns & Cocktail Dresses',
              'slug' => 'evening-gowns',
              'description' => 'Luxurious velvet and satin formal evening dresses.',
              'image' => 'products/womens/women-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:36:43',
              'updated_at' => '2026-09-06 23:36:43',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 37,
              'parent_id' => 11,
              'name' => 'Casual & Floral Summer Dresses',
              'slug' => 'casual-summer-dresses',
              'description' => 'Breezy linen sundresses, wrap dresses and floral prints.',
              'image' => 'products/womens/women-10.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:36:43',
              'updated_at' => '2026-09-06 23:36:43',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 12,
          'parent_id' => 1,
          'name' => 'Tops, Tees & Blouses',
          'slug' => 'womens-tops',
          'description' => 'Casual tees, elegant silk blouses, button-downs and crop tops.',
          'image' => 'products/womens/grid-2.jpg',
          'is_featured' => 0,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 40,
              'parent_id' => 12,
              'name' => 'Silk & Satin Blouses',
              'slug' => 'silk-satin-blouses',
              'description' => 'Luxurious silk shirts and office work blouses.',
              'image' => 'products/womens/grid-2.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:37',
              'updated_at' => '2026-09-06 23:39:37',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 41,
              'parent_id' => 12,
              'name' => 'Graphic & Printed Tees',
              'slug' => 'womens-graphic-tees',
              'description' => 'Fun, vintage and artistic graphic t-shirts.',
              'image' => 'products/womens/women-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 42,
              'parent_id' => 12,
              'name' => 'Crop Tops & Halters',
              'slug' => 'crop-tops-halters',
              'description' => 'Trendy summer crop tops, camisoles and halter necklines.',
              'image' => 'products/womens/women-10.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 13,
          'parent_id' => 1,
          'name' => 'Pants, Jeans & Skirts',
          'slug' => 'womens-bottomwear',
          'description' => 'High-waisted trousers, denim jeans, midi and pleated skirts.',
          'image' => 'products/womens/grid-3.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 43,
              'parent_id' => 13,
              'name' => 'High-Waist Flare Jeans',
              'slug' => 'high-waist-flare-jeans',
              'description' => 'Flattering retro flare and bell-bottom denim jeans.',
              'image' => 'products/womens/grid-3.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 44,
              'parent_id' => 13,
              'name' => 'Pleated Midi Skirts',
              'slug' => 'pleated-midi-skirts',
              'description' => 'Elegant high-waisted pleated and A-line midi skirts.',
              'image' => 'products/womens/grid-4.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 45,
              'parent_id' => 13,
              'name' => 'Tailored Wide-Leg Trousers',
              'slug' => 'tailored-wide-leg-trousers',
              'description' => 'Chic relaxed trousers for modern professional style.',
              'image' => 'products/womens/grid-1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        3 => 
        array (
          'id' => 14,
          'parent_id' => 1,
          'name' => 'Outerwear & Blazers',
          'slug' => 'womens-outerwear',
          'description' => 'Chic trench coats, leather jackets, cardigans and winter wear.',
          'image' => 'products/womens/grid-4.jpg',
          'is_featured' => 0,
          'sort_order' => 4,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 46,
              'parent_id' => 14,
              'name' => 'Oversized Wool Blazers',
              'slug' => 'oversized-wool-blazers',
              'description' => 'Structured tailored blazers for timeless elegance.',
              'image' => 'products/womens/grid-4.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 47,
              'parent_id' => 14,
              'name' => 'Leather Moto Biker Jackets',
              'slug' => 'leather-moto-jackets',
              'description' => 'Classic faux and genuine leather motorcycle jackets.',
              'image' => 'products/womens/grid-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 48,
              'parent_id' => 14,
              'name' => 'Winter Trench Coats',
              'slug' => 'winter-trench-coats',
              'description' => 'Waterproof double-breasted long trench coats.',
              'image' => 'products/womens/women-1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    1 => 
    array (
      'id' => 2,
      'parent_id' => 0,
      'name' => 'Mens Collection',
      'slug' => 'mens-collection',
      'description' => 'Modern mens shirts, jackets, pants, suits and casual wear.',
      'image' => 'products/mens/men-1.jpg',
      'is_featured' => 1,
      'sort_order' => 2,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 15,
          'parent_id' => 2,
          'name' => 'Casual Shirts & Polos',
          'slug' => 'mens-shirts',
          'description' => 'Slim-fit cotton shirts, casual linen button-ups and classic polos.',
          'image' => 'products/mens/men-11.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 49,
              'parent_id' => 15,
              'name' => 'Oxford Cotton Button-Downs',
              'slug' => 'oxford-cotton-shirts',
              'description' => 'Crisp breathable cotton shirts for smart-casual wear.',
              'image' => 'products/mens/men-11.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 50,
              'parent_id' => 15,
              'name' => 'Linen Vacation Shirts',
              'slug' => 'linen-vacation-shirts',
              'description' => 'Lightweight breezy linen shirts in pastel tones.',
              'image' => 'products/mens/men-12.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 51,
              'parent_id' => 15,
              'name' => 'Slim-Fit Pique Polos',
              'slug' => 'slim-fit-polos',
              'description' => 'Classic embroidered collar polos with athletic stretch.',
              'image' => 'products/mens/men-13.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 1,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 16,
          'parent_id' => 2,
          'name' => 'T-Shirts & Graphic Tees',
          'slug' => 'mens-t-shirts',
          'description' => 'Oversized crewnecks, graphic printed t-shirts and gym tanks.',
          'image' => 'products/mens/men-12.jpg',
          'is_featured' => 0,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 52,
              'parent_id' => 16,
              'name' => 'Oversized Streetwear Tees',
              'slug' => 'streetwear-graphic-tees',
              'description' => 'Boxy drop-shoulder tees with bold streetwear artwork.',
              'image' => 'products/mens/men-14.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 53,
              'parent_id' => 16,
              'name' => 'Heavyweight Crewneck T-Shirts',
              'slug' => 'heavyweight-crewnecks',
              'description' => 'Thick 240 GSM organic cotton solid basic tees.',
              'image' => 'products/mens/men-15.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 17,
          'parent_id' => 2,
          'name' => 'Denim & Chinos',
          'slug' => 'mens-jeans',
          'description' => 'Stretch skinny jeans, relaxed fit denim and smart chinos.',
          'image' => 'products/mens/men-13.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 54,
              'parent_id' => 17,
              'name' => 'Slim Tapered Stretch Jeans',
              'slug' => 'slim-tapered-jeans',
              'description' => 'Comfort stretch denim jeans in clean indigo washes.',
              'image' => 'products/mens/men-13.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 55,
              'parent_id' => 17,
              'name' => 'Relaxed Fit Cargo Pants',
              'slug' => 'mens-cargo-pants',
              'description' => 'Utility multi-pocket tactical cargo trousers.',
              'image' => 'products/mens/men-14.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 56,
              'parent_id' => 17,
              'name' => 'Classic Khaki Chinos',
              'slug' => 'classic-khaki-chinos',
              'description' => 'Wrinkle-resistant tailored slim-fit stretch chinos.',
              'image' => 'products/mens/men-11.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        3 => 
        array (
          'id' => 18,
          'parent_id' => 2,
          'name' => 'Jackets & Hoodies',
          'slug' => 'mens-jackets',
          'description' => 'Bomber jackets, fleece zip hoodies, windbreakers and coats.',
          'image' => 'products/mens/men-14.jpg',
          'is_featured' => 0,
          'sort_order' => 4,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 57,
              'parent_id' => 18,
              'name' => 'Fleece Zip & Pullover Hoodies',
              'slug' => 'fleece-hoodies',
              'description' => 'Cozy brushed fleece hooded sweatshirts with kangaroo pockets.',
              'image' => 'products/mens/men-15.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 58,
              'parent_id' => 18,
              'name' => 'Leather Biker & Bomber Jackets',
              'slug' => 'leather-bomber-jackets',
              'description' => 'Genuine leather flight jackets and zip-front bombers.',
              'image' => 'products/mens/men-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 59,
              'parent_id' => 18,
              'name' => 'Puffer Down Winter Jackets',
              'slug' => 'puffer-winter-jackets',
              'description' => 'Insulated quilted puffer parkas for cold weather.',
              'image' => 'products/mens/men-12.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    2 => 
    array (
      'id' => 3,
      'parent_id' => 0,
      'name' => 'Consumer Electronics',
      'slug' => 'electronics',
      'description' => 'High-tech gadgets, audio equipment, smartphones, and accessories.',
      'image' => 'products/electronic/electronic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 3,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
      'children' => 
      array (
        0 => 
        array (
          'id' => 19,
          'parent_id' => 3,
          'name' => 'Smartphones & Tablets',
          'slug' => 'smartphones-tablets',
          'description' => 'Next-gen flagship smartphones, Android tablets and iPads.',
          'image' => 'products/electronic/electronic-10.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 60,
              'parent_id' => 19,
              'name' => 'Flagship 5G Smartphones',
              'slug' => 'flagship-5g-smartphones',
              'description' => 'OLED display, pro triple cameras and high-speed 5G.',
              'image' => 'products/electronic/electronic-10.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 1,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 61,
              'parent_id' => 19,
              'name' => 'Tablets & Stylus Pens',
              'slug' => 'tablets-stylus',
              'description' => 'High-resolution creative tablets for artists and note-taking.',
              'image' => 'products/electronic/electronic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 62,
              'parent_id' => 19,
              'name' => 'Phone Cases & Screen Protectors',
              'slug' => 'phone-cases-protectors',
              'description' => 'Shockproof armor cases and 9H tempered glass.',
              'image' => 'products/electronic/electronic-14.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 20,
          'parent_id' => 3,
          'name' => 'Headphones & Audio',
          'slug' => 'audio-headphones',
          'description' => 'Noise cancelling headphones, bluetooth speakers and wireless buds.',
          'image' => 'products/electronic/electronic-11.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 38,
              'parent_id' => 20,
              'name' => 'True Wireless Earbuds',
              'slug' => 'wireless-earbuds',
              'description' => 'Compact Bluetooth earbuds with wireless charging cases.',
              'image' => 'products/electronic/electronic-11.jpg',
              'is_featured' => 1,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:36:43',
              'updated_at' => '2026-09-06 23:36:43',
              'product_count' => 1,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 39,
              'parent_id' => 20,
              'name' => 'Over-Ear ANC Headphones',
              'slug' => 'over-ear-headphones',
              'description' => 'Active noise cancelling studio quality headphones.',
              'image' => 'products/electronic/electronic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:36:43',
              'updated_at' => '2026-09-06 23:36:43',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 63,
              'parent_id' => 20,
              'name' => 'Bluetooth Party Speakers',
              'slug' => 'bluetooth-party-speakers',
              'description' => 'Waterproof outdoor speakers with deep bass.',
              'image' => 'products/electronic/electronic-12.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            3 => 
            array (
              'id' => 64,
              'parent_id' => 20,
              'name' => 'Soundbars & Home Theaters',
              'slug' => 'soundbars-subwoofers',
              'description' => 'Dolby Atmos surround soundbars with wireless subwoofers.',
              'image' => 'products/electronic/electronic-13.jpg',
              'is_featured' => 0,
              'sort_order' => 4,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 21,
          'parent_id' => 3,
          'name' => 'Laptops & Computers',
          'slug' => 'laptops-computers',
          'description' => 'Ultralight work laptops, gaming rigs, monitors and accessories.',
          'image' => 'products/electronic/electronic-12.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 65,
              'parent_id' => 21,
              'name' => 'High-Performance Gaming Laptops',
              'slug' => 'gaming-laptops',
              'description' => 'RTX graphics, 165Hz displays and RGB backlit keyboards.',
              'image' => 'products/electronic/electronic-12.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 66,
              'parent_id' => 21,
              'name' => 'Thin & Light Ultrabooks',
              'slug' => 'ultrabooks-laptops',
              'description' => 'All-day battery life, sleek aluminium chassis for work.',
              'image' => 'products/electronic/electronic-10.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 67,
              'parent_id' => 21,
              'name' => 'Mechanical Keyboards & Mice',
              'slug' => 'pc-gaming-peripherals',
              'description' => 'Hot-swappable mechanical switches and precision optical mice.',
              'image' => 'products/electronic/electronic-14.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        3 => 
        array (
          'id' => 22,
          'parent_id' => 3,
          'name' => 'Smart Home & Wearables',
          'slug' => 'wearable-tech',
          'description' => 'Fitness trackers, smart watches, smart plugs and security cams.',
          'image' => 'products/electronic/electronic-13.jpg',
          'is_featured' => 0,
          'sort_order' => 4,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 68,
              'parent_id' => 22,
              'name' => 'Smart Fitness Trackers & Watches',
              'slug' => 'smart-fitness-watches',
              'description' => 'Heart rate monitor, GPS tracking and AMOLED screens.',
              'image' => 'products/electronic/electronic-11.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 69,
              'parent_id' => 22,
              'name' => 'Smart Security Cameras & Hubs',
              'slug' => 'smart-home-cameras',
              'description' => '1080p HD night vision, motion alerts and WiFi app control.',
              'image' => 'products/electronic/electronic-13.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    3 => 
    array (
      'id' => 4,
      'parent_id' => 0,
      'name' => 'Sneakers & Shoes',
      'slug' => 'sneakers-shoes',
      'description' => 'Athletic running shoes, street sneakers, and formal footwear.',
      'image' => 'products/sneaker/sneaker-1.jpg',
      'is_featured' => 1,
      'sort_order' => 4,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
      'children' => 
      array (
        0 => 
        array (
          'id' => 23,
          'parent_id' => 4,
          'name' => 'Running & Athletic Shoes',
          'slug' => 'running-shoes',
          'description' => 'Performance cushion running shoes and training sneakers.',
          'image' => 'products/sneaker/sneaker-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 70,
              'parent_id' => 23,
              'name' => 'Road & Marathon Running Shoes',
              'slug' => 'marathon-road-running',
              'description' => 'Ultra-cushioned carbon plate marathon racing shoes.',
              'image' => 'products/sneaker/sneaker-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 71,
              'parent_id' => 23,
              'name' => 'Trail Running & Hiking Sneakers',
              'slug' => 'trail-running-sneakers',
              'description' => 'Lugged traction outsoles for rugged off-road paths.',
              'image' => 'products/sneaker/color-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 24,
          'parent_id' => 4,
          'name' => 'Casual Street Sneakers',
          'slug' => 'casual-sneakers',
          'description' => 'Retro court shoes, low-top canvas sneakers and slip-ons.',
          'image' => 'products/sneaker/color-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 72,
              'parent_id' => 24,
              'name' => 'Low-Top Leather Court Shoes',
              'slug' => 'low-top-court-shoes',
              'description' => 'Clean minimalist white leather sneakers with rubber cupsole.',
              'image' => 'products/sneaker/color-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 73,
              'parent_id' => 24,
              'name' => 'High-Top Retro Streetwear',
              'slug' => 'high-top-retro-sneakers',
              'description' => 'Padded ankle collar retro basketball silhouettes.',
              'image' => 'products/sneaker/sneaker-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 25,
          'parent_id' => 4,
          'name' => 'Formal Oxfords & Loafers',
          'slug' => 'formal-shoes',
          'description' => 'Leather dress shoes, penny loafers and monk strap footwear.',
          'image' => 'products/sneaker/sneaker-1.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 74,
              'parent_id' => 25,
              'name' => 'Handcrafted Oxford Brogues',
              'slug' => 'handcrafted-oxford-brogues',
              'description' => 'Goodyear welted calfskin leather cap-toe dress shoes.',
              'image' => 'products/sneaker/sneaker-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 75,
              'parent_id' => 25,
              'name' => 'Penny & Tassel Loafers',
              'slug' => 'penny-tassel-loafers',
              'description' => 'Slip-on dress shoes with genuine leather outsoles.',
              'image' => 'products/sneaker/color-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    4 => 
    array (
      'id' => 5,
      'parent_id' => 0,
      'name' => 'Beauty & Skincare',
      'slug' => 'beauty-skincare',
      'description' => 'Natural cosmetics, organic serums, perfumes and skin care items.',
      'image' => 'products/beauty-cosmetic/beauty-1.jpg',
      'is_featured' => 1,
      'sort_order' => 5,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
      'children' => 
      array (
        0 => 
        array (
          'id' => 26,
          'parent_id' => 5,
          'name' => 'Facial Care & Serums',
          'slug' => 'face-care-serums',
          'description' => 'Hydrating hyaluronic serums, vitamin C brightening and moistures.',
          'image' => 'products/beauty-cosmetic/beauty10.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 76,
              'parent_id' => 26,
              'name' => 'Hyaluronic Hydrating Serums',
              'slug' => 'hyaluronic-hydrating-serums',
              'description' => 'Multi-molecular weight hyaluronic acid for deep hydration.',
              'image' => 'products/beauty-cosmetic/beauty10.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 77,
              'parent_id' => 26,
              'name' => 'Vitamin C Brightening Treatments',
              'slug' => 'vitamin-c-brightening',
              'description' => 'Stable 15% pure vitamin C serum for radiant, even skin.',
              'image' => 'products/beauty-cosmetic/beauty-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 78,
              'parent_id' => 26,
              'name' => 'Anti-Aging Retinol Creams',
              'slug' => 'anti-aging-retinol',
              'description' => 'Gentle encapsulated retinol formula for firming fine lines.',
              'image' => 'products/beauty-cosmetic/beauty10.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 27,
          'parent_id' => 5,
          'name' => 'Makeup & Cosmetics',
          'slug' => 'makeup-cosmetics',
          'description' => 'Liquid lipsticks, mineral foundations, eye shadow palettes and mascara.',
          'image' => 'products/beauty-cosmetic/beauty-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 79,
              'parent_id' => 27,
              'name' => 'Long-Lasting Matte Lipsticks',
              'slug' => 'matte-lipsticks',
              'description' => 'Smudge-proof rich pigmented velvety liquid lipsticks.',
              'image' => 'products/beauty-cosmetic/beauty-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 80,
              'parent_id' => 27,
              'name' => 'Liquid Glow Foundations',
              'slug' => 'glow-foundations',
              'description' => 'Buildable medium-to-full coverage with dewy radiant finish.',
              'image' => 'products/beauty-cosmetic/beauty10.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 81,
              'parent_id' => 27,
              'name' => 'Eyeshadow Palettes & Eyeliners',
              'slug' => 'eyeshadow-palettes',
              'description' => 'Multi-finish shimmer and matte warm neutral palettes.',
              'image' => 'products/beauty-cosmetic/beauty-1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 28,
          'parent_id' => 5,
          'name' => 'Hair Care & Oils',
          'slug' => 'hair-care',
          'description' => 'Sulfate-free shampoos, biotin hair masks and nourishing argan oils.',
          'image' => 'products/beauty-cosmetic/beauty10.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 82,
              'parent_id' => 28,
              'name' => 'Sulfate-Free Keratin Shampoos',
              'slug' => 'keratin-shampoos',
              'description' => 'Strengthening organic botanical cleansers for color-treated hair.',
              'image' => 'products/beauty-cosmetic/beauty10.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 83,
              'parent_id' => 28,
              'name' => 'Pure Moroccan Argan Hair Oils',
              'slug' => 'argan-hair-oils',
              'description' => 'Silky lightweight anti-frizz shine serum and split-end repair.',
              'image' => 'products/beauty-cosmetic/beauty-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    5 => 
    array (
      'id' => 6,
      'parent_id' => 0,
      'name' => 'Home & Furniture',
      'slug' => 'furniture',
      'description' => 'Modern interior furniture, minimalist lighting and comfort chairs.',
      'image' => 'products/furniture/furniture-1.jpg',
      'is_featured' => 1,
      'sort_order' => 6,
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 12:38:10',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 29,
          'parent_id' => 6,
          'name' => 'Living Room Furniture',
          'slug' => 'living-room-furniture',
          'description' => 'Scandinavian sectionals, armchairs, coffee tables and TV consoles.',
          'image' => 'products/furniture/furniture1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 84,
              'parent_id' => 29,
              'name' => 'Sectional L-Shaped Sofas',
              'slug' => 'sectional-l-shaped-sofas',
              'description' => 'Deep seated modular couches with high-density foam cushions.',
              'image' => 'products/furniture/furniture1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 85,
              'parent_id' => 29,
              'name' => 'Velvet Accent Armchairs',
              'slug' => 'velvet-accent-armchairs',
              'description' => 'Tufted mid-century lounge chairs with tapered gold metal legs.',
              'image' => 'products/furniture/furniture-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 86,
              'parent_id' => 29,
              'name' => 'Marble & Wood Coffee Tables',
              'slug' => 'marble-coffee-tables',
              'description' => 'Tempered glass and solid oak round center tables.',
              'image' => 'products/furniture/furniture1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 30,
          'parent_id' => 6,
          'name' => 'Bedroom & Bedding',
          'slug' => 'bedroom-furniture',
          'description' => 'Solid wood beds, orthopedic mattresses and Egyptian cotton sheets.',
          'image' => 'products/furniture/furniture-1.jpg',
          'is_featured' => 0,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 87,
              'parent_id' => 30,
              'name' => 'Upholstered Platform Beds',
              'slug' => 'platform-bed-frames',
              'description' => 'Minimalist winged headboard frames with wooden slat supports.',
              'image' => 'products/furniture/furniture-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 88,
              'parent_id' => 30,
              'name' => 'Orthopedic Memory Foam Mattresses',
              'slug' => 'orthopedic-mattresses',
              'description' => 'Zero motion transfer pressure-relieving cool gel foam.',
              'image' => 'products/furniture/furniture1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 31,
          'parent_id' => 6,
          'name' => 'Modern Lighting & Lamps',
          'slug' => 'lighting-lamps',
          'description' => 'Minimalist pendant lights, warm ambient floor lamps and desk lights.',
          'image' => 'products/furniture/furniture1.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 89,
              'parent_id' => 31,
              'name' => 'Nordic Pendant Hanging Lights',
              'slug' => 'nordic-pendant-lights',
              'description' => 'Modern industrial matte metal shades for dining and kitchens.',
              'image' => 'products/furniture/furniture1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 90,
              'parent_id' => 31,
              'name' => 'Dimmable Standing Floor Lamps',
              'slug' => 'standing-floor-lamps',
              'description' => 'Touch-sensor arching floor lamps with warm amber glow.',
              'image' => 'products/furniture/furniture-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    6 => 
    array (
      'id' => 7,
      'parent_id' => 0,
      'name' => 'Kids & Baby',
      'slug' => 'kids-baby',
      'description' => 'Clothing, toys, strollers and nursery essentials for babies and toddlers.',
      'image' => 'products/baby/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 7,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 32,
          'parent_id' => 7,
          'name' => 'Baby Clothing & Rompers',
          'slug' => 'baby-clothing',
          'description' => 'Organic cotton onesies, soft knit sets and sleeper outfits.',
          'image' => 'products/baby/product-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 91,
              'parent_id' => 32,
              'name' => '100% Organic Cotton Onesies',
              'slug' => 'cotton-baby-onesies',
              'description' => 'Hypoallergenic nickel-free snap baby bodysuits.',
              'image' => 'products/baby/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 92,
              'parent_id' => 32,
              'name' => 'Toddler Soft Knit Outfits',
              'slug' => 'toddler-knit-outfits',
              'description' => 'Breathable ribbed two-piece sets for active toddlers.',
              'image' => 'products/baby/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 33,
          'parent_id' => 7,
          'name' => 'Toys & Learning Games',
          'slug' => 'toys-games',
          'description' => 'Montessori wooden toys, puzzles, plush animals and board games.',
          'image' => 'products/baby/product-1.jpg',
          'is_featured' => 0,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 93,
              'parent_id' => 33,
              'name' => 'Montessori Wooden Shape Sorters',
              'slug' => 'montessori-wooden-toys',
              'description' => 'Non-toxic water-based painted cognitive learning blocks.',
              'image' => 'products/baby/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 94,
              'parent_id' => 33,
              'name' => 'Creative Building Block Sets',
              'slug' => 'creative-building-blocks',
              'description' => 'Interlocking colorful architectural play bricks for kids.',
              'image' => 'products/baby/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    7 => 
    array (
      'id' => 8,
      'parent_id' => 0,
      'name' => 'Jewelry & Accessories',
      'slug' => 'jewelry-accessories',
      'description' => 'Gold, silver, gemstone rings, necklaces, bracelets and luxury watches.',
      'image' => 'products/jewelry/jewelry-1.jpg',
      'is_featured' => 1,
      'sort_order' => 8,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 100,
          'parent_id' => 8,
          'name' => 'Fine Jewelry & Gems',
          'slug' => 'fine-jewelry',
          'description' => 'Diamond rings, solid 18K gold and sterling silver masterworks.',
          'image' => 'products/jewelry/jewelry-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 101,
              'parent_id' => 100,
              'name' => 'Diamond Engagement Rings',
              'slug' => 'diamond-engagement-rings',
              'description' => 'Certified brilliant-cut solitaire and halo diamond rings.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 102,
              'parent_id' => 100,
              'name' => '18K Gold Necklaces & Pendants',
              'slug' => 'gold-necklaces-pendants',
              'description' => 'Delicate gold chain necklaces, medallions and charms.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 103,
              'parent_id' => 100,
              'name' => 'Tennis & Beaded Bracelets',
              'slug' => 'tennis-bracelets',
              'description' => 'Sparkling cubic zirconia and natural gemstone wristbands.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 104,
          'parent_id' => 8,
          'name' => 'Luxury Wristwatches',
          'slug' => 'luxury-watches',
          'description' => 'Swiss automatic chronographs and dress wrist timepieces.',
          'image' => 'products/jewelry/jewelry-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 105,
              'parent_id' => 104,
              'name' => 'Automatic Mechanical Watches',
              'slug' => 'automatic-mechanical-watches',
              'description' => 'Exhibition caseback self-winding sapphire crystal watches.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 106,
              'parent_id' => 104,
              'name' => 'Minimalist Leather Dress Watches',
              'slug' => 'minimalist-dress-watches',
              'description' => 'Slim stainless steel cases with Italian genuine leather straps.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 107,
          'parent_id' => 8,
          'name' => 'Designer Handbags & Clutches',
          'slug' => 'designer-handbags',
          'description' => 'Luxury leather shoulder bags, crossbody and party clutches.',
          'image' => 'products/jewelry/jewelry-1.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 108,
              'parent_id' => 107,
              'name' => 'Leather Crossbody Bags',
              'slug' => 'leather-crossbody-bags',
              'description' => 'Structured compact bags with adjustable chain straps.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 109,
              'parent_id' => 107,
              'name' => 'Spacious Work Tote Bags',
              'slug' => 'spacious-work-totes',
              'description' => 'Laptop-friendly premium textured vegan leather totes.',
              'image' => 'products/jewelry/jewelry-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    8 => 
    array (
      'id' => 9,
      'parent_id' => 0,
      'name' => 'Sports & Outdoors',
      'slug' => 'sports-outdoors',
      'description' => 'Camping tents, hiking gear, athletic fitness apparel and gym accessories.',
      'image' => 'products/camping/camping-1.jpg',
      'is_featured' => 1,
      'sort_order' => 9,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 34,
          'parent_id' => 9,
          'name' => 'Camping & Hiking Gear',
          'slug' => 'camping-gear',
          'description' => 'Waterproof dome tents, lightweight sleeping bags and trekking poles.',
          'image' => 'products/camping/camping-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 95,
              'parent_id' => 34,
              'name' => 'Waterproof 4-Person Camping Tents',
              'slug' => 'waterproof-camping-tents',
              'description' => 'Double-layer ripstop polyester dome tent with rainfly.',
              'image' => 'products/camping/camping-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 96,
              'parent_id' => 34,
              'name' => 'Ultralight Down Sleeping Bags',
              'slug' => 'ultralight-sleeping-bags',
              'description' => 'Compact 800-fill duck down mummy sleeping bag.',
              'image' => 'products/camping/camping-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            2 => 
            array (
              'id' => 97,
              'parent_id' => 34,
              'name' => 'Carbon Fiber Trekking Poles',
              'slug' => 'carbon-trekking-poles',
              'description' => 'Quick-lock shock-absorbing telescopic hiking sticks.',
              'image' => 'products/camping/camping-1.jpg',
              'is_featured' => 0,
              'sort_order' => 3,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 35,
          'parent_id' => 9,
          'name' => 'Activewear & Fitness',
          'slug' => 'activewear-training',
          'description' => 'Compression tights, moisture-wicking tees and yoga gear.',
          'image' => 'products/activewear/activewear-1.jpg',
          'is_featured' => 0,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:36:43',
          'updated_at' => '2026-09-06 23:36:43',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 98,
              'parent_id' => 35,
              'name' => 'High-Waist Compression Leggings',
              'slug' => 'compression-yoga-leggings',
              'description' => 'Squat-proof seamless four-way stretch athletic tights.',
              'image' => 'products/activewear/activewear-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 99,
              'parent_id' => 35,
              'name' => 'Moisture-Wicking Athletic Tops',
              'slug' => 'moisture-wicking-tops',
              'description' => 'Quick-dry workout performance t-shirts and racerback bras.',
              'image' => 'products/activewear/activewear-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    9 => 
    array (
      'id' => 10,
      'parent_id' => 0,
      'name' => 'Books & Stationery',
      'slug' => 'books-stationery',
      'description' => 'Best-selling novels, academic textbooks, art supplies and fine notebooks.',
      'image' => 'products/bookstore/product-bookstore-1.jpg',
      'is_featured' => 0,
      'sort_order' => 10,
      'status' => 'active',
      'created_at' => '2026-09-06 23:36:43',
      'updated_at' => '2026-09-06 23:36:43',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 110,
          'parent_id' => 10,
          'name' => 'Fiction & Literature',
          'slug' => 'fiction-literature',
          'description' => 'Bestselling crime thrillers, sci-fi and historical novels.',
          'image' => 'products/bookstore/product-bookstore-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 111,
              'parent_id' => 110,
              'name' => 'Crime & Psychological Thrillers',
              'slug' => 'crime-psychological-thrillers',
              'description' => 'Page-turning suspense, murder mysteries and detective fiction.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 112,
              'parent_id' => 110,
              'name' => 'Sci-Fi & Epic Fantasy',
              'slug' => 'scifi-epic-fantasy',
              'description' => 'Space operas, dystopian futures and magical world-building.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 113,
          'parent_id' => 10,
          'name' => 'Business & Self-Help',
          'slug' => 'business-self-help',
          'description' => 'Personal finance, leadership, startups and mindfulness.',
          'image' => 'products/bookstore/product-bookstore-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 114,
              'parent_id' => 113,
              'name' => 'Investing & Wealth Building',
              'slug' => 'investing-wealth-building',
              'description' => 'Stock market, financial freedom and real estate masteries.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 115,
              'parent_id' => 113,
              'name' => 'Habits & Mental Models',
              'slug' => 'habits-mental-models',
              'description' => 'Proven frameworks for focus, willpower and continuous growth.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        2 => 
        array (
          'id' => 116,
          'parent_id' => 10,
          'name' => 'Fine Stationery & Planners',
          'slug' => 'stationery-planners',
          'description' => 'Fountain pen inks, dotted bullet journals and desk tools.',
          'image' => 'products/bookstore/product-bookstore-1.jpg',
          'is_featured' => 0,
          'sort_order' => 3,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 117,
              'parent_id' => 116,
              'name' => 'Hardcover Dot Grid Journals',
              'slug' => 'hardcover-dot-journals',
              'description' => '160 GSM bleed-proof bamboo paper notebook planners.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 118,
              'parent_id' => 116,
              'name' => 'Calligraphy & Fountain Pens',
              'slug' => 'calligraphy-fountain-pens',
              'description' => 'Iridium nib pens with piston converters and archival ink.',
              'image' => 'products/bookstore/product-bookstore-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    10 => 
    array (
      'id' => 119,
      'parent_id' => 0,
      'name' => 'Organic & Gourmet Pantry',
      'slug' => 'organic-gourmet',
      'description' => 'Farm-fresh organic superfoods, beverages and pantry staples.',
      'image' => 'products/organic/organic-1.jpg',
      'is_featured' => 1,
      'sort_order' => 11,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 120,
          'parent_id' => 119,
          'name' => 'Artisanal Teas & Specialty Coffee',
          'slug' => 'artisanal-teas-coffee',
          'description' => 'Whole-bean single origin roasts and loose leaf green teas.',
          'image' => 'products/organic/organic-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 121,
              'parent_id' => 120,
              'name' => 'Organic Ceremonial Matcha & Green Tea',
              'slug' => 'matcha-green-tea',
              'description' => 'Stone-ground first-harvest Japanese ceremonial grade matcha.',
              'image' => 'products/organic/organic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 122,
              'parent_id' => 120,
              'name' => 'Single-Origin Arabica Coffee Beans',
              'slug' => 'single-origin-arabica',
              'description' => 'Medium dark roasted beans with chocolate notes.',
              'image' => 'products/organic/organic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 123,
          'parent_id' => 119,
          'name' => 'Nuts, Seeds & Dried Superfoods',
          'slug' => 'nuts-seeds-superfoods',
          'description' => 'Nutrient-rich raw nuts, organic seeds and cold snacks.',
          'image' => 'products/organic/organic-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 124,
              'parent_id' => 123,
              'name' => 'California Raw Almonds & Walnuts',
              'slug' => 'raw-almonds-walnuts',
              'description' => 'Non-GMO unpasteurized organic California nuts.',
              'image' => 'products/organic/organic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 125,
              'parent_id' => 123,
              'name' => 'Chia Seeds & Roasted Flax',
              'slug' => 'chia-roasted-flax',
              'description' => 'High fiber, omega-3 rich organic whole food seeds.',
              'image' => 'products/organic/organic-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    11 => 
    array (
      'id' => 126,
      'parent_id' => 0,
      'name' => 'Pet Supplies & Toys',
      'slug' => 'pet-supplies',
      'description' => 'Nutritious feeds, grooming tools and interactive toys for pets.',
      'image' => 'products/pet-store/pet-store-1.jpg',
      'is_featured' => 1,
      'sort_order' => 12,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:38',
      'updated_at' => '2026-09-06 23:39:38',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 127,
          'parent_id' => 126,
          'name' => 'Canine Dog Care & Nutrition',
          'slug' => 'dog-care-nutrition',
          'description' => 'Premium grain-free dog kibble, dental chews and beds.',
          'image' => 'products/pet-store/pet-store-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 128,
              'parent_id' => 127,
              'name' => 'Grain-Free High-Protein Dog Food',
              'slug' => 'grain-free-dog-food',
              'description' => 'Real salmon and turkey formula enriched with probiotics.',
              'image' => 'products/pet-store/pet-store-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 129,
              'parent_id' => 127,
              'name' => 'Orthopedic Memory Foam Dog Beds',
              'slug' => 'orthopedic-dog-beds',
              'description' => 'Waterproof removable cover joint-relief pet mattresses.',
              'image' => 'products/pet-store/pet-store-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 130,
          'parent_id' => 126,
          'name' => 'Feline Cat Supplies & Scratchers',
          'slug' => 'cat-supplies-scratchers',
          'description' => 'Cat condos, natural litter and playful teaser toys.',
          'image' => 'products/pet-store/pet-store-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:38',
          'updated_at' => '2026-09-06 23:39:38',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 131,
              'parent_id' => 130,
              'name' => 'Multi-Level Sisal Cat Trees',
              'slug' => 'sisal-cat-trees',
              'description' => 'Sturdy climbing towers with hammocks and scratching posts.',
              'image' => 'products/pet-store/pet-store-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:38',
              'updated_at' => '2026-09-06 23:39:38',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 132,
              'parent_id' => 130,
              'name' => 'Automatic Laser & Feather Toys',
              'slug' => 'automatic-cat-toys',
              'description' => 'Rechargeable motion-activated interactive entertainment.',
              'image' => 'products/pet-store/pet-store-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:39',
              'updated_at' => '2026-09-06 23:39:39',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
    12 => 
    array (
      'id' => 133,
      'parent_id' => 0,
      'name' => 'Gaming & Virtual Reality',
      'slug' => 'gaming-vr',
      'description' => 'Next-gen consoles, VR headsets, gaming chairs and peripherals.',
      'image' => 'products/gaming/product-1.jpg',
      'is_featured' => 1,
      'sort_order' => 13,
      'status' => 'active',
      'created_at' => '2026-09-06 23:39:39',
      'updated_at' => '2026-09-06 23:39:39',
      'product_count' => 0,
      'children' => 
      array (
        0 => 
        array (
          'id' => 134,
          'parent_id' => 133,
          'name' => 'Consoles & VR Systems',
          'slug' => 'consoles-vr-systems',
          'description' => 'Immersive spatial VR headsets and 4K console gaming.',
          'image' => 'products/gaming/product-1.jpg',
          'is_featured' => 1,
          'sort_order' => 1,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:39',
          'updated_at' => '2026-09-06 23:39:39',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 135,
              'parent_id' => 134,
              'name' => 'Standalone Wireless VR Headsets',
              'slug' => 'wireless-vr-headsets',
              'description' => 'High-res lenses with 6DoF inside-out tracking controllers.',
              'image' => 'products/gaming/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:39',
              'updated_at' => '2026-09-06 23:39:39',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 136,
              'parent_id' => 134,
              'name' => 'Next-Gen Ultra HD Consoles',
              'slug' => 'next-gen-consoles',
              'description' => 'Ray-tracing enabled gaming systems with ultra-fast SSDs.',
              'image' => 'products/gaming/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:39',
              'updated_at' => '2026-09-06 23:39:39',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
        1 => 
        array (
          'id' => 137,
          'parent_id' => 133,
          'name' => 'Gaming Chairs & Battlestation Gear',
          'slug' => 'gaming-battlestation-gear',
          'description' => 'Ergonomic racing chairs, mousepads and controller docks.',
          'image' => 'products/gaming/product-1.jpg',
          'is_featured' => 1,
          'sort_order' => 2,
          'status' => 'active',
          'created_at' => '2026-09-06 23:39:39',
          'updated_at' => '2026-09-06 23:39:39',
          'product_count' => 0,
          'children' => 
          array (
            0 => 
            array (
              'id' => 138,
              'parent_id' => 137,
              'name' => 'Ergonomic Reclining Gaming Chairs',
              'slug' => 'reclining-gaming-chairs',
              'description' => 'Lumbar support cushions, 4D armrests and steel frames.',
              'image' => 'products/gaming/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 1,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:39',
              'updated_at' => '2026-09-06 23:39:39',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
            1 => 
            array (
              'id' => 139,
              'parent_id' => 137,
              'name' => 'Wireless RGB Pro Gamepads',
              'slug' => 'wireless-rgb-gamepads',
              'description' => 'Hall effect magnetic triggers and customizable paddle buttons.',
              'image' => 'products/gaming/product-1.jpg',
              'is_featured' => 0,
              'sort_order' => 2,
              'status' => 'active',
              'created_at' => '2026-09-06 23:39:39',
              'updated_at' => '2026-09-06 23:39:39',
              'product_count' => 0,
              'children' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'brands' => 
  array (
    0 => 
    array (
      'id' => 2,
      'name' => 'Apex Tech',
      'slug' => 'apex-tech',
      'logo' => 'brand/brand-02.svg',
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'product_count' => 3,
    ),
    1 => 
    array (
      'id' => 8,
      'name' => 'Apple',
      'slug' => 'apple',
      'logo' => 'brand/brand_1789987114_424.jpg',
      'status' => 'active',
      'created_at' => '2026-09-21 16:08:34',
      'product_count' => 1,
    ),
    2 => 
    array (
      'id' => 4,
      'name' => 'Glow Natural',
      'slug' => 'glow-natural',
      'logo' => 'brand/brand-04.svg',
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    3 => 
    array (
      'id' => 1,
      'name' => 'Modave Luxe',
      'slug' => 'modave-luxe',
      'logo' => 'brand/brand-01.svg',
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'product_count' => 2,
    ),
    4 => 
    array (
      'id' => 6,
      'name' => 'Oppo',
      'slug' => 'oppo',
      'logo' => 'brand/brand_1788720135_675.png',
      'status' => 'active',
      'created_at' => '2026-09-07 00:12:15',
      'product_count' => 1,
    ),
    5 => 
    array (
      'id' => 5,
      'name' => 'Stride Athletics',
      'slug' => 'stride-athletics',
      'logo' => 'brand/brand-05.svg',
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    6 => 
    array (
      'id' => 3,
      'name' => 'Urban Edge',
      'slug' => 'urban-edge',
      'logo' => 'brand/brand-03.svg',
      'status' => 'active',
      'created_at' => '2026-09-07 12:38:10',
      'product_count' => 1,
    ),
    7 => 
    array (
      'id' => 7,
      'name' => 'Vebnor',
      'slug' => 'vebnor',
      'logo' => 'brand/brand_1788722344_146.jpg',
      'status' => 'active',
      'created_at' => '2026-09-07 00:49:04',
      'product_count' => 1,
    ),
  ),
  'products' => 
  array (
    0 => 
    array (
      'id' => 1,
      'category_id' => 1,
      'brand_id' => 1,
      'product_type' => 'variable',
      'title' => 'V-neck Linen Blend Summer Dress',
      'slug' => 'v-neck-linen-blend-summer-dress',
      'sku' => 'MOD-W-001',
      'price' => '89.00',
      'sale_price' => '69.00',
      'tax_rate' => '5.00',
      'stock_quantity' => 45,
      'low_stock_threshold' => 10,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Lightweight, breathable linen blend dress tailored for warm weather elegance.',
      'description' => 'Designed with relaxed sophistication, this dress features an airy silhouette, a feminine V-neckline, and sustainable organic linen fabric. Machine washable with minimal shrinkage.',
      'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Spread"},{"key":"Color","value":"Grey"}]',
      'main_image' => 'products/womens/women-1.jpg',
      'gallery_images' => '["products/womens/women-2.jpg","products/womens/women-3.jpg"]',
      'is_featured' => 1,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.90',
      'reviews_count' => 18,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-12 20:11:25',
      'category_name' => 'Womens Fashion',
      'category_slug' => 'womens-fashion',
      'brand_name' => 'Modave Luxe',
      'brand_slug' => 'modave-luxe',
      'gallery_images_decoded' => 
      array (
        0 => 'products/womens/women-2.jpg',
        1 => 'products/womens/women-3.jpg',
      ),
      'highlights_decoded' => 
      array (
        0 => 
        array (
          'key' => 'Pack of',
          'value' => '1',
        ),
        1 => 
        array (
          'key' => 'Fabric',
          'value' => 'Cotton Blend',
        ),
        2 => 
        array (
          'key' => 'Sleeve',
          'value' => 'Full Sleeve',
        ),
        3 => 
        array (
          'key' => 'Pattern',
          'value' => 'Solid',
        ),
        4 => 
        array (
          'key' => 'Collar',
          'value' => 'Spread',
        ),
        5 => 
        array (
          'key' => 'Color',
          'value' => 'Grey',
        ),
      ),
      'variants' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 1,
          'title' => 'V-neck Linen Summer Dress - Beige / S',
          'sku' => 'MOD-W-001-BG-S',
          'price' => '89.00',
          'sale_price' => '79.00',
          'stock_quantity' => 15,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/womens/women-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:48',
          'updated_at' => '2026-09-07 13:04:48',
          'values' => 
          array (
            0 => 
            array (
              'id' => 1,
              'variant_id' => 1,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 2,
              'variant_id' => 1,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 1,
          'title' => 'V-neck Linen Summer Dress - Beige / M',
          'sku' => 'MOD-W-001-BG-M',
          'price' => '89.00',
          'sale_price' => '79.00',
          'stock_quantity' => 20,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/womens/women-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:48',
          'updated_at' => '2026-09-07 13:04:48',
          'values' => 
          array (
            0 => 
            array (
              'id' => 3,
              'variant_id' => 2,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 4,
              'variant_id' => 2,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        2 => 
        array (
          'id' => 3,
          'product_id' => 1,
          'title' => 'V-neck Linen Summer Dress - Beige / L',
          'sku' => 'MOD-W-001-BG-L',
          'price' => '89.00',
          'sale_price' => '79.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/womens/women-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:48',
          'updated_at' => '2026-09-07 13:04:48',
          'values' => 
          array (
            0 => 
            array (
              'id' => 5,
              'variant_id' => 3,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 6,
              'variant_id' => 3,
              'attribute_id' => 2,
              'attribute_value_id' => 9,
              'attribute_value' => 'L',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        3 => 
        array (
          'id' => 4,
          'product_id' => 1,
          'title' => 'V-neck Linen Summer Dress - Black / S',
          'sku' => 'MOD-W-001-BK-S',
          'price' => '89.00',
          'sale_price' => NULL,
          'stock_quantity' => 12,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/womens/women-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:48',
          'updated_at' => '2026-09-07 13:04:48',
          'values' => 
          array (
            0 => 
            array (
              'id' => 7,
              'variant_id' => 4,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 8,
              'variant_id' => 4,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        4 => 
        array (
          'id' => 5,
          'product_id' => 1,
          'title' => 'V-neck Linen Summer Dress - Black / M',
          'sku' => 'MOD-W-001-BK-M',
          'price' => '89.00',
          'sale_price' => NULL,
          'stock_quantity' => 18,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/womens/women-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:49',
          'updated_at' => '2026-09-07 13:04:49',
          'values' => 
          array (
            0 => 
            array (
              'id' => 9,
              'variant_id' => 5,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 10,
              'variant_id' => 5,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
      ),
      'color_swatches' => 
      array (
        0 => 
        array (
          'name' => 'Beige',
          'value' => 'Beige',
          'color_code' => '#f5f5dc',
          'image' => 'products/womens/women-1.jpg',
        ),
        1 => 
        array (
          'name' => 'Black',
          'value' => 'Black',
          'color_code' => '#000000',
          'image' => 'products/womens/women-1.jpg',
        ),
      ),
      'attributes' => 
      array (
        'color' => 
        array (
          'name' => 'Color',
          'slug' => 'color',
          'type' => 'color',
          'values' => 
          array (
            0 => 
            array (
              'id' => 1,
              'value' => 'Beige',
              'color_code' => '#f5f5dc',
            ),
            1 => 
            array (
              'id' => 2,
              'value' => 'Black',
              'color_code' => '#000000',
            ),
          ),
        ),
        'size' => 
        array (
          'name' => 'Size',
          'slug' => 'size',
          'type' => 'multiple_select',
          'values' => 
          array (
            0 => 
            array (
              'id' => 7,
              'value' => 'S',
              'color_code' => NULL,
            ),
            1 => 
            array (
              'id' => 8,
              'value' => 'M',
              'color_code' => NULL,
            ),
            2 => 
            array (
              'id' => 9,
              'value' => 'L',
              'color_code' => NULL,
            ),
          ),
        ),
      ),
      'specifications' => 
      array (
        0 => 
        array (
          'id' => 12,
          'product_id' => 1,
          'spec_name' => 'Pack of',
          'spec_value' => '1',
          'sort_order' => 1,
          'created_at' => '2026-09-12 20:11:25',
        ),
        1 => 
        array (
          'id' => 13,
          'product_id' => 1,
          'spec_name' => 'Style Code',
          'spec_value' => 'FR ST2',
          'sort_order' => 2,
          'created_at' => '2026-09-12 20:11:25',
        ),
        2 => 
        array (
          'id' => 14,
          'product_id' => 1,
          'spec_name' => 'Closure',
          'spec_value' => 'Button',
          'sort_order' => 3,
          'created_at' => '2026-09-12 20:11:25',
        ),
        3 => 
        array (
          'id' => 15,
          'product_id' => 1,
          'spec_name' => 'Fit',
          'spec_value' => 'Regular',
          'sort_order' => 4,
          'created_at' => '2026-09-12 20:11:25',
        ),
        4 => 
        array (
          'id' => 16,
          'product_id' => 1,
          'spec_name' => 'Fabric',
          'spec_value' => 'Cotton Blend',
          'sort_order' => 5,
          'created_at' => '2026-09-12 20:11:25',
        ),
        5 => 
        array (
          'id' => 17,
          'product_id' => 1,
          'spec_name' => 'Sleeve',
          'spec_value' => 'Full Sleeve',
          'sort_order' => 6,
          'created_at' => '2026-09-12 20:11:25',
        ),
        6 => 
        array (
          'id' => 18,
          'product_id' => 1,
          'spec_name' => 'Pattern',
          'spec_value' => 'Solid',
          'sort_order' => 7,
          'created_at' => '2026-09-12 20:11:25',
        ),
        7 => 
        array (
          'id' => 19,
          'product_id' => 1,
          'spec_name' => 'Reversible',
          'spec_value' => 'No',
          'sort_order' => 8,
          'created_at' => '2026-09-12 20:11:25',
        ),
        8 => 
        array (
          'id' => 20,
          'product_id' => 1,
          'spec_name' => 'Collar',
          'spec_value' => 'Spread',
          'sort_order' => 9,
          'created_at' => '2026-09-12 20:11:25',
        ),
        9 => 
        array (
          'id' => 21,
          'product_id' => 1,
          'spec_name' => 'Suitable For',
          'spec_value' => 'Western Wear',
          'sort_order' => 10,
          'created_at' => '2026-09-12 20:11:25',
        ),
        10 => 
        array (
          'id' => 22,
          'product_id' => 1,
          'spec_name' => 'Type',
          'spec_value' => 'Shirt Dress',
          'sort_order' => 11,
          'created_at' => '2026-09-12 20:11:25',
        ),
        11 => 
        array (
          'id' => 23,
          'product_id' => 1,
          'spec_name' => 'Occasion',
          'spec_value' => 'Casual',
          'sort_order' => 12,
          'created_at' => '2026-09-12 20:11:25',
        ),
        12 => 
        array (
          'id' => 24,
          'product_id' => 1,
          'spec_name' => 'Fabric Care',
          'spec_value' => 'Gentle Machine Wash',
          'sort_order' => 13,
          'created_at' => '2026-09-12 20:11:25',
        ),
        13 => 
        array (
          'id' => 25,
          'product_id' => 1,
          'spec_name' => 'Hemline',
          'spec_value' => 'Curved',
          'sort_order' => 14,
          'created_at' => '2026-09-12 20:11:25',
        ),
        14 => 
        array (
          'id' => 26,
          'product_id' => 1,
          'spec_name' => 'Country of Origin',
          'spec_value' => 'India',
          'sort_order' => 15,
          'created_at' => '2026-09-12 20:11:25',
        ),
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 1,
          'user_id' => 1,
          'order_number' => NULL,
          'customer_name' => 'John Doe',
          'customer_email' => 'john@example.com',
          'rating' => 5,
          'title' => NULL,
          'review' => 'Outstanding fabric quality, looks even better in person. Delivery was quick!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-07 12:38:10',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 2,
      'category_id' => 1,
      'brand_id' => 1,
      'product_type' => 'simple',
      'title' => 'Belted Relaxed Trench Coat',
      'slug' => 'belted-relaxed-trench-coat',
      'sku' => 'MOD-W-002',
      'price' => '175.00',
      'sale_price' => '149.00',
      'tax_rate' => '5.00',
      'stock_quantity' => 28,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Timeless water-resistant double-breasted trench coat with removable waist belt.',
      'description' => 'Classic British outerwear styling re-imagined. Features premium weatherproof cotton gabardine, tortoise shell buttons, storm flaps, and spacious slant pockets.',
      'highlights' => NULL,
      'main_image' => 'products/womens/women-4.jpg',
      'gallery_images' => '["products/womens/women-5.jpg","products/womens/women-6.jpg"]',
      'is_featured' => 1,
      'is_trending' => 1,
      'is_new' => 0,
      'is_cod_allowed' => 1,
      'rating' => '4.85',
      'reviews_count' => 24,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Womens Fashion',
      'category_slug' => 'womens-fashion',
      'brand_name' => 'Modave Luxe',
      'brand_slug' => 'modave-luxe',
      'gallery_images_decoded' => 
      array (
        0 => 'products/womens/women-5.jpg',
        1 => 'products/womens/women-6.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 2,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 2,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    2 => 
    array (
      'id' => 3,
      'category_id' => 1,
      'brand_id' => 3,
      'product_type' => 'simple',
      'title' => 'Oversized Silk Knit Cardigan',
      'slug' => 'oversized-silk-knit-cardigan',
      'sku' => 'MOD-W-003',
      'price' => '110.00',
      'sale_price' => NULL,
      'tax_rate' => '5.00',
      'stock_quantity' => 30,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Ultra-soft cozy drape cardigan made from fine spun silk-wool blend.',
      'description' => 'The perfect layering essential for any season. Dropped shoulders, ribbed cuffs, and an open front silhouette that complements both casual denim and evening wear.',
      'highlights' => NULL,
      'main_image' => 'products/womens/women-7.jpg',
      'gallery_images' => '["products/womens/women-8.jpg","products/womens/women-9.jpg"]',
      'is_featured' => 0,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.70',
      'reviews_count' => 9,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Womens Fashion',
      'category_slug' => 'womens-fashion',
      'brand_name' => 'Urban Edge',
      'brand_slug' => 'urban-edge',
      'gallery_images_decoded' => 
      array (
        0 => 'products/womens/women-8.jpg',
        1 => 'products/womens/women-9.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 3,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 3,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    3 => 
    array (
      'id' => 4,
      'category_id' => 3,
      'brand_id' => 2,
      'product_type' => 'variable',
      'title' => 'Noise-Cancelling Wireless Pro Headphones',
      'slug' => 'noise-cancelling-wireless-pro-headphones',
      'sku' => 'ELC-HP-004',
      'price' => '249.00',
      'sale_price' => '199.00',
      'tax_rate' => '8.00',
      'stock_quantity' => 60,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Studio-quality spatial audio, active hybrid ANC, and up to 40 hours of playtime.',
      'description' => 'Equipped with custom 40mm beryllium drivers, transparency pass-through mode, four noise-cancelling microphones, and ultra-plush memory foam earcups for prolonged listening comfort.',
      'highlights' => NULL,
      'main_image' => 'products/electronic/electronic-1.jpg',
      'gallery_images' => '["products/electronic/electronic-2.jpg","products/electronic/electronic-3.jpg"]',
      'is_featured' => 1,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.95',
      'reviews_count' => 42,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Consumer Electronics',
      'category_slug' => 'electronics',
      'brand_name' => 'Apex Tech',
      'brand_slug' => 'apex-tech',
      'gallery_images_decoded' => 
      array (
        0 => 'products/electronic/electronic-2.jpg',
        1 => 'products/electronic/electronic-3.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
        0 => 
        array (
          'id' => 6,
          'product_id' => 4,
          'title' => 'Wireless Pro Headphones - Midnight Black',
          'sku' => 'ELC-HP-004-BLK',
          'price' => '249.00',
          'sale_price' => '219.00',
          'stock_quantity' => 35,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/electronics/headphone-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:49',
          'updated_at' => '2026-09-07 13:04:49',
          'values' => 
          array (
            0 => 
            array (
              'id' => 11,
              'variant_id' => 6,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
          ),
        ),
        1 => 
        array (
          'id' => 7,
          'product_id' => 4,
          'title' => 'Wireless Pro Headphones - Alpine White',
          'sku' => 'ELC-HP-004-WHT',
          'price' => '249.00',
          'sale_price' => '219.00',
          'stock_quantity' => 25,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/electronics/headphone-1.jpg',
          'gallery_images' => NULL,
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 13:04:49',
          'updated_at' => '2026-09-07 13:04:49',
          'values' => 
          array (
            0 => 
            array (
              'id' => 12,
              'variant_id' => 7,
              'attribute_id' => 1,
              'attribute_value_id' => 3,
              'attribute_value' => 'White',
              'color_code' => '#ffffff',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
          ),
        ),
      ),
      'color_swatches' => 
      array (
        0 => 
        array (
          'name' => 'Black',
          'value' => 'Black',
          'color_code' => '#000000',
          'image' => 'products/electronics/headphone-1.jpg',
        ),
        1 => 
        array (
          'name' => 'White',
          'value' => 'White',
          'color_code' => '#ffffff',
          'image' => 'products/electronics/headphone-1.jpg',
        ),
      ),
      'attributes' => 
      array (
        'color' => 
        array (
          'name' => 'Color',
          'slug' => 'color',
          'type' => 'color',
          'values' => 
          array (
            0 => 
            array (
              'id' => 2,
              'value' => 'Black',
              'color_code' => '#000000',
            ),
            1 => 
            array (
              'id' => 3,
              'value' => 'White',
              'color_code' => '#ffffff',
            ),
          ),
        ),
      ),
      'specifications' => 
      array (
        0 => 
        array (
          'id' => 5,
          'product_id' => 4,
          'spec_name' => 'Driver Size',
          'spec_value' => '40mm Neodymium Titanium',
          'sort_order' => 1,
          'created_at' => '2026-09-07 13:04:49',
        ),
        1 => 
        array (
          'id' => 6,
          'product_id' => 4,
          'spec_name' => 'Active Noise Cancellation',
          'spec_value' => 'Hybrid ANC (up to 38dB noise reduction)',
          'sort_order' => 2,
          'created_at' => '2026-09-07 13:04:49',
        ),
        2 => 
        array (
          'id' => 7,
          'product_id' => 4,
          'spec_name' => 'Battery Life',
          'spec_value' => 'Up to 45 hours (ANC off), 35 hours (ANC on)',
          'sort_order' => 3,
          'created_at' => '2026-09-07 13:04:49',
        ),
        3 => 
        array (
          'id' => 8,
          'product_id' => 4,
          'spec_name' => 'Bluetooth Version',
          'spec_value' => 'v5.3 with multipoint pairing',
          'sort_order' => 4,
          'created_at' => '2026-09-07 13:04:49',
        ),
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 2,
          'product_id' => 4,
          'user_id' => 2,
          'order_number' => NULL,
          'customer_name' => 'Sarah Connor',
          'customer_email' => 'sarah@example.com',
          'rating' => 5,
          'title' => NULL,
          'review' => 'The soundstage and noise cancelling rival headphones twice the price. Highly recommend!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-07 12:38:10',
        ),
      ),
    ),
    4 => 
    array (
      'id' => 5,
      'category_id' => 3,
      'brand_id' => 2,
      'product_type' => 'simple',
      'title' => 'Ultra-Slim Mechanical Wireless Keyboard',
      'slug' => 'ultra-slim-mechanical-wireless-keyboard',
      'sku' => 'ELC-KB-005',
      'price' => '129.00',
      'sale_price' => '115.00',
      'tax_rate' => '5.00',
      'stock_quantity' => 50,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Compact 75% layout keyboard with hot-swappable switches and RGB backlighting.',
      'description' => 'Aircraft-grade anodized aluminum body, Bluetooth 5.2 multi-device pairing, low-profile mechanical switches, and long-lasting 4000mAh rechargeable battery.',
      'highlights' => NULL,
      'main_image' => 'products/electronic/electronic-4.jpg',
      'gallery_images' => '["products/electronic/electronic-5.jpg","products/electronic/electronic-6.jpg"]',
      'is_featured' => 1,
      'is_trending' => 0,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.80',
      'reviews_count' => 15,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Consumer Electronics',
      'category_slug' => 'electronics',
      'brand_name' => 'Apex Tech',
      'brand_slug' => 'apex-tech',
      'gallery_images_decoded' => 
      array (
        0 => 'products/electronic/electronic-5.jpg',
        1 => 'products/electronic/electronic-6.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 5,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 5,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    5 => 
    array (
      'id' => 6,
      'category_id' => 3,
      'brand_id' => 2,
      'product_type' => 'simple',
      'title' => 'Smart Ambient LED Studio Speaker',
      'slug' => 'smart-ambient-led-studio-speaker',
      'sku' => 'ELC-SP-006',
      'price' => '159.00',
      'sale_price' => NULL,
      'tax_rate' => '5.00',
      'stock_quantity' => 35,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => '360-degree immersive acoustic sound with reactive ambient lighting sync.',
      'description' => 'Featuring deep bass transducers, Wi-Fi multi-room streaming, voice assistant compatibility, and water-resistant casing for versatile indoor and patio performance.',
      'highlights' => NULL,
      'main_image' => 'products/electronic/electronic-7.jpg',
      'gallery_images' => '["products/electronic/electronic-8.jpg","products/electronic/electronic-9.jpg"]',
      'is_featured' => 0,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.60',
      'reviews_count' => 11,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Consumer Electronics',
      'category_slug' => 'electronics',
      'brand_name' => 'Apex Tech',
      'brand_slug' => 'apex-tech',
      'gallery_images_decoded' => 
      array (
        0 => 'products/electronic/electronic-8.jpg',
        1 => 'products/electronic/electronic-9.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 6,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 6,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    6 => 
    array (
      'id' => 7,
      'category_id' => 4,
      'brand_id' => 5,
      'product_type' => 'simple',
      'title' => 'CloudStep Ultra Running Shoes',
      'slug' => 'cloudstep-ultra-running-shoes',
      'sku' => 'SNK-RUN-007',
      'price' => '135.00',
      'sale_price' => '119.00',
      'tax_rate' => '5.00',
      'stock_quantity' => 75,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Engineered mesh running shoes with responsive nitrogen-infused foam cushioning.',
      'description' => 'Designed for marathon training and daily walking alike. Offers zero-drop heel support, breathable knit upper, high-traction rubber outsole, and reflective night-running details.',
      'highlights' => NULL,
      'main_image' => 'products/womens/women-10.jpg',
      'gallery_images' => '["products/womens/women-11.jpg"]',
      'is_featured' => 1,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.90',
      'reviews_count' => 31,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Sneakers & Shoes',
      'category_slug' => 'sneakers-shoes',
      'brand_name' => 'Stride Athletics',
      'brand_slug' => 'stride-athletics',
      'gallery_images_decoded' => 
      array (
        0 => 'products/womens/women-11.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
        0 => 
        array (
          'id' => 9,
          'product_id' => 7,
          'spec_name' => 'Upper Material',
          'spec_value' => 'Engineered Breathable Jacquard Mesh',
          'sort_order' => 1,
          'created_at' => '2026-09-07 13:04:49',
        ),
        1 => 
        array (
          'id' => 10,
          'product_id' => 7,
          'spec_name' => 'Midsole',
          'spec_value' => 'CloudFoam Nitrogen-Infused Cushioning',
          'sort_order' => 2,
          'created_at' => '2026-09-07 13:04:49',
        ),
        2 => 
        array (
          'id' => 11,
          'product_id' => 7,
          'spec_name' => 'Heel Drop',
          'spec_value' => '8mm',
          'sort_order' => 3,
          'created_at' => '2026-09-07 13:04:49',
        ),
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 7,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 7,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    7 => 
    array (
      'id' => 8,
      'category_id' => 5,
      'brand_id' => 4,
      'product_type' => 'simple',
      'title' => 'Botanical Radiance Hydrating Facial Serum',
      'slug' => 'botanical-radiance-hydrating-facial-serum',
      'sku' => 'BTY-SR-008',
      'price' => '48.00',
      'sale_price' => '39.00',
      'tax_rate' => '5.00',
      'stock_quantity' => 120,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Deeply nourishing serum with hyaluronic acid, vitamin C, and organic botanical extracts.',
      'description' => 'Restores skin elasticity, locks in 24-hour hydration, and brightens tone with clean, cruelty-free, and vegan certified ingredients.',
      'highlights' => NULL,
      'main_image' => 'products/womens/women-12.jpg',
      'gallery_images' => '["products/womens/women-13.jpg"]',
      'is_featured' => 1,
      'is_trending' => 1,
      'is_new' => 0,
      'is_cod_allowed' => 1,
      'rating' => '4.92',
      'reviews_count' => 53,
      'status' => 'published',
      'created_at' => '2026-09-07 12:38:10',
      'updated_at' => '2026-09-07 13:04:49',
      'category_name' => 'Beauty & Skincare',
      'category_slug' => 'beauty-skincare',
      'brand_name' => 'Glow Natural',
      'brand_slug' => 'glow-natural',
      'gallery_images_decoded' => 
      array (
        0 => 'products/womens/women-13.jpg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
      ),
      'color_swatches' => 
      array (
      ),
      'attributes' => 
      array (
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 8,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 8,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    8 => 
    array (
      'id' => 10,
      'category_id' => 38,
      'brand_id' => 6,
      'product_type' => 'variable',
      'title' => 'OPPO Enco Buds 2 with 28 hours Battery life & Deep Noise Cancellation Bluetooth Headset (Midnight, True Wireless)',
      'slug' => 'oppo-enco-buds-2-with-28-hours-battery-life-deep-noise-cancellation-bluetooth-headset-midnight-true-wireless',
      'sku' => 'OPPO-ENCO-BUDS',
      'price' => '3999.00',
      'sale_price' => '1299.00',
      'tax_rate' => '0.00',
      'stock_quantity' => 78,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'Elevate your audio experience with the OPPO Enco Buds 2, designed for deep bass and crystal-clear sound. Featuring powerful 10mm Large Titanized Drivers, these TWS earbuds deliver a rhythmic, high-fidelity acoustic performance. With AI Deep Noise Cancellation for calls, stay connected without background distractions. Enjoy up to 28 hours of total playback time and take advantage of fast charging???just 10 minutes of charge gives you 1 hour of music. Designed for active lifestyles, these earbuds are IPX4 water-resistant and offer an 80ms ultra-low latency game mode for a lag-free gaming experience. Simple touch controls and instant auto-pairing make them the perfect companion for your smartphone.',
      'description' => '',
      'highlights' => NULL,
      'main_image' => 'products/prod_1788721819_724.png',
      'gallery_images' => '["products\\/prod_gal_1788721819_0_860.jpeg","products\\/prod_gal_1788721819_1_302.jpeg","products\\/prod_gal_1788721819_2_755.jpeg","products\\/prod_gal_1788721819_3_674.jpeg","products\\/prod_gal_1788721819_4_924.jpeg","products\\/prod_gal_1788721819_5_468.jpeg","products\\/prod_gal_1788721819_6_765.jpeg","products\\/prod_gal_1788721819_7_481.jpeg"]',
      'is_featured' => 0,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '5.00',
      'reviews_count' => 0,
      'status' => 'published',
      'created_at' => '2026-09-07 00:40:19',
      'updated_at' => '2026-09-15 19:00:30',
      'category_name' => 'True Wireless Earbuds',
      'category_slug' => 'wireless-earbuds',
      'brand_name' => 'Oppo',
      'brand_slug' => 'oppo',
      'gallery_images_decoded' => 
      array (
        0 => 'products/prod_gal_1788721819_0_860.jpeg',
        1 => 'products/prod_gal_1788721819_1_302.jpeg',
        2 => 'products/prod_gal_1788721819_2_755.jpeg',
        3 => 'products/prod_gal_1788721819_3_674.jpeg',
        4 => 'products/prod_gal_1788721819_4_924.jpeg',
        5 => 'products/prod_gal_1788721819_5_468.jpeg',
        6 => 'products/prod_gal_1788721819_6_765.jpeg',
        7 => 'products/prod_gal_1788721819_7_481.jpeg',
      ),
      'highlights_decoded' => 
      array (
      ),
      'variants' => 
      array (
        0 => 
        array (
          'id' => 8,
          'product_id' => 10,
          'title' => 'OPPO Enco Buds 2 with 28 hours Battery life & Deep Noise Cancellation Bluetooth Headset (Midnight, True Wireless) - Black',
          'sku' => 'OPPO-ENCO-BUDS',
          'price' => '3999.00',
          'sale_price' => '1299.00',
          'stock_quantity' => 48,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1788721819_724.png',
          'gallery_images' => '["products\\/prod_gal_1788721819_0_860.jpeg","products\\/prod_gal_1788721819_1_302.jpeg","products\\/prod_gal_1788721819_2_755.jpeg","products\\/prod_gal_1788721819_3_674.jpeg","products\\/prod_gal_1788721819_4_924.jpeg","products\\/prod_gal_1788721819_5_468.jpeg","products\\/prod_gal_1788721819_6_765.jpeg","products\\/prod_gal_1788721819_7_481.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 00:40:19',
          'updated_at' => '2026-09-15 19:00:30',
          'values' => 
          array (
            0 => 
            array (
              'id' => 13,
              'variant_id' => 8,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
          ),
        ),
        1 => 
        array (
          'id' => 9,
          'product_id' => 10,
          'title' => 'OPPO Enco Buds 2 with 28 hours Battery life & Deep Noise Cancellation Bluetooth Headset (Midnight, True Wireless) - Black Aqua',
          'sku' => 'OPPO-ENCO-BUDS-BLA',
          'price' => '3999.00',
          'sale_price' => '1499.00',
          'stock_quantity' => 30,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1788721963_101.png',
          'gallery_images' => '["products\\/var_gal_1788721963_0_510.jpeg","products\\/var_gal_1788721963_1_171.jpeg","products\\/var_gal_1788721963_2_294.jpeg","products\\/var_gal_1788721963_3_817.jpeg","products\\/var_gal_1788721963_4_728.jpeg","products\\/var_gal_1788721963_5_533.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-07 00:42:43',
          'updated_at' => '2026-09-07 00:42:43',
          'values' => 
          array (
            0 => 
            array (
              'id' => 14,
              'variant_id' => 9,
              'attribute_id' => 1,
              'attribute_value_id' => 17,
              'attribute_value' => 'Midnight',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
          ),
        ),
      ),
      'color_swatches' => 
      array (
        0 => 
        array (
          'name' => 'Black',
          'value' => 'Black',
          'color_code' => '#000000',
          'image' => 'products/prod_1788721819_724.png',
        ),
        1 => 
        array (
          'name' => 'Midnight',
          'value' => 'Midnight',
          'color_code' => '#adfff1',
          'image' => 'products/var_1788721963_101.png',
        ),
      ),
      'attributes' => 
      array (
        'color' => 
        array (
          'name' => 'Color',
          'slug' => 'color',
          'type' => 'color',
          'values' => 
          array (
            0 => 
            array (
              'id' => 2,
              'value' => 'Black',
              'color_code' => '#000000',
            ),
            1 => 
            array (
              'id' => 17,
              'value' => 'Midnight',
              'color_code' => '#adfff1',
            ),
          ),
        ),
      ),
      'specifications' => 
      array (
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 10,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 10,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
    9 => 
    array (
      'id' => 11,
      'category_id' => 51,
      'brand_id' => 7,
      'product_type' => 'variable',
      'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt',
      'slug' => 'vebnor-men-regular-fit-solid-spread-collar-formal-shirt',
      'sku' => 'VEBNOR-COTTON',
      'price' => '999.00',
      'sale_price' => '351.00',
      'tax_rate' => '0.00',
      'stock_quantity' => 332,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'This formal shirts for men is one of the top selling product from premium quality shirt for men collection exclusively manufactured by VeBNoR brand. You can use this shirts for men on jeans as well as it is appropriate as formal office wear. Acurate stitching by skilled workers gives this formal shirt for men an authentic classic look. Use this mens shirt with full sleeves or roll up the sleeves.',
      'description' => '',
      'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
      'main_image' => 'products/prod_1788722531_690.jpeg',
      'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
      'is_featured' => 0,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '4.00',
      'reviews_count' => 1,
      'status' => 'published',
      'created_at' => '2026-09-07 00:52:11',
      'updated_at' => '2026-09-23 13:23:08',
      'category_name' => 'Slim-Fit Pique Polos',
      'category_slug' => 'slim-fit-polos',
      'brand_name' => 'Vebnor',
      'brand_slug' => 'vebnor',
      'gallery_images_decoded' => 
      array (
        0 => 'products/prod_gal_1788722531_0_228.jpeg',
        1 => 'products/prod_gal_1788722531_1_793.jpeg',
        2 => 'products/prod_gal_1788722531_2_451.jpeg',
        3 => 'products/prod_gal_1788722531_3_833.jpeg',
      ),
      'highlights_decoded' => 
      array (
        0 => 
        array (
          'key' => 'Pack of',
          'value' => '1',
        ),
        1 => 
        array (
          'key' => 'Fabric',
          'value' => 'Cotton Blend',
        ),
        2 => 
        array (
          'key' => 'Sleeve',
          'value' => 'Full Sleeve',
        ),
        3 => 
        array (
          'key' => 'Pattern',
          'value' => 'Solid',
        ),
        4 => 
        array (
          'key' => 'Collar',
          'value' => 'Button Down',
        ),
        5 => 
        array (
          'key' => 'Color',
          'value' => 'Badge',
        ),
      ),
      'variants' => 
      array (
        0 => 
        array (
          'id' => 10,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / XS',
          'sku' => 'VEBNOR-COTTON-XS',
          'price' => '999.00',
          'sale_price' => '345.00',
          'stock_quantity' => 6,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1788722531_690.jpeg',
          'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Western Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-07 00:52:11',
          'updated_at' => '2026-09-23 10:45:56',
          'values' => 
          array (
            0 => 
            array (
              'id' => 105,
              'variant_id' => 10,
              'attribute_id' => 1,
              'attribute_value_id' => 18,
              'attribute_value' => 'Aqua',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 106,
              'variant_id' => 10,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 107,
              'variant_id' => 10,
              'attribute_id' => 2,
              'attribute_value_id' => 6,
              'attribute_value' => 'XS',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        1 => 
        array (
          'id' => 11,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / S',
          'sku' => 'VEBNOR-COTTON-S',
          'price' => '999.00',
          'sale_price' => '348.00',
          'stock_quantity' => 7,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1788722531_690.jpeg',
          'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Western Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-07 00:52:11',
          'updated_at' => '2026-09-23 10:28:21',
          'values' => 
          array (
            0 => 
            array (
              'id' => 108,
              'variant_id' => 11,
              'attribute_id' => 1,
              'attribute_value_id' => 18,
              'attribute_value' => 'Aqua',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 109,
              'variant_id' => 11,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 110,
              'variant_id' => 11,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        2 => 
        array (
          'id' => 12,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / M',
          'sku' => 'VEBNOR-COTTON-M',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 6,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1788722531_690.jpeg',
          'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Western Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-07 00:52:11',
          'updated_at' => '2026-09-22 19:11:05',
          'values' => 
          array (
            0 => 
            array (
              'id' => 111,
              'variant_id' => 12,
              'attribute_id' => 1,
              'attribute_value_id' => 18,
              'attribute_value' => 'Aqua',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 112,
              'variant_id' => 12,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 113,
              'variant_id' => 12,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        3 => 
        array (
          'id' => 13,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / L',
          'sku' => 'VEBNOR-COTTON-L',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 30,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1788722531_690.jpeg',
          'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Western Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-07 00:52:11',
          'updated_at' => '2026-09-15 16:17:52',
          'values' => 
          array (
            0 => 
            array (
              'id' => 114,
              'variant_id' => 13,
              'attribute_id' => 1,
              'attribute_value_id' => 18,
              'attribute_value' => 'Aqua',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 115,
              'variant_id' => 13,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 116,
              'variant_id' => 13,
              'attribute_id' => 2,
              'attribute_value_id' => 9,
              'attribute_value' => 'L',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        4 => 
        array (
          'id' => 14,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / XL',
          'sku' => 'VEBNOR-COTTON-XL',
          'price' => '999.00',
          'sale_price' => '361.00',
          'stock_quantity' => 0,
          'max_purchase_quantity' => 5,
          'stock_status' => 'out_of_stock',
          'image' => 'products/prod_1788722531_690.jpeg',
          'gallery_images' => '["products\\/prod_gal_1788722531_0_228.jpeg","products\\/prod_gal_1788722531_1_793.jpeg","products\\/prod_gal_1788722531_2_451.jpeg","products\\/prod_gal_1788722531_3_833.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Western Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-07 00:52:11',
          'updated_at' => '2026-09-15 16:18:39',
          'values' => 
          array (
            0 => 
            array (
              'id' => 117,
              'variant_id' => 14,
              'attribute_id' => 1,
              'attribute_value_id' => 18,
              'attribute_value' => 'Aqua',
              'color_code' => '#adfff1',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 118,
              'variant_id' => 14,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 119,
              'variant_id' => 14,
              'attribute_id' => 2,
              'attribute_value_id' => 10,
              'attribute_value' => 'XL',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        5 => 
        array (
          'id' => 15,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Black / XS',
          'sku' => 'VEBNOR-COTTON-BLA-XS',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 0,
          'max_purchase_quantity' => 5,
          'stock_status' => 'out_of_stock',
          'image' => 'products/var_1789214033_965.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214033_0_159.jpeg","products\\/var_gal_1789214033_1_913.jpeg","products\\/var_gal_1789214033_2_183.jpeg","products\\/var_gal_1789214033_3_495.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Indian Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-12 17:23:53',
          'updated_at' => '2026-09-15 16:36:46',
          'values' => 
          array (
            0 => 
            array (
              'id' => 120,
              'variant_id' => 15,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 121,
              'variant_id' => 15,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 122,
              'variant_id' => 15,
              'attribute_id' => 2,
              'attribute_value_id' => 6,
              'attribute_value' => 'XS',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        6 => 
        array (
          'id' => 16,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Black / S',
          'sku' => 'VEBNOR-COTTON-BLA-S',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 4,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214033_965.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214033_0_159.jpeg","products\\/var_gal_1789214033_1_913.jpeg","products\\/var_gal_1789214033_2_183.jpeg","products\\/var_gal_1789214033_3_495.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Indian Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-12 17:23:53',
          'updated_at' => '2026-09-15 18:52:31',
          'values' => 
          array (
            0 => 
            array (
              'id' => 123,
              'variant_id' => 16,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 124,
              'variant_id' => 16,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 125,
              'variant_id' => 16,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        7 => 
        array (
          'id' => 17,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Black / M',
          'sku' => 'VEBNOR-COTTON-BLA-M',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 14,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214033_965.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214033_0_159.jpeg","products\\/var_gal_1789214033_1_913.jpeg","products\\/var_gal_1789214033_2_183.jpeg","products\\/var_gal_1789214033_3_495.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Indian Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-12 17:23:53',
          'updated_at' => '2026-09-23 11:53:44',
          'values' => 
          array (
            0 => 
            array (
              'id' => 126,
              'variant_id' => 17,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 127,
              'variant_id' => 17,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 128,
              'variant_id' => 17,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        8 => 
        array (
          'id' => 18,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Black / L',
          'sku' => 'VEBNOR-COTTON-BLA-L',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214033_965.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214033_0_159.jpeg","products\\/var_gal_1789214033_1_913.jpeg","products\\/var_gal_1789214033_2_183.jpeg","products\\/var_gal_1789214033_3_495.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Indian Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-12 17:23:53',
          'updated_at' => '2026-09-23 10:28:22',
          'values' => 
          array (
            0 => 
            array (
              'id' => 129,
              'variant_id' => 18,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 130,
              'variant_id' => 18,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 131,
              'variant_id' => 18,
              'attribute_id' => 2,
              'attribute_value_id' => 9,
              'attribute_value' => 'L',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        9 => 
        array (
          'id' => 19,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Black / XL',
          'sku' => 'VEBNOR-COTTON-BLA-XL',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 35,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214033_965.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214033_0_159.jpeg","products\\/var_gal_1789214033_1_913.jpeg","products\\/var_gal_1789214033_2_183.jpeg","products\\/var_gal_1789214033_3_495.jpeg"]',
          'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Button Down"},{"key":"Color","value":"Badge"}]',
          'specifications' => '[{"name":"Pack of","value":"1"},{"name":"Closure","value":"Button"},{"name":"Fit","value":"Regular"},{"name":"Fabric","value":"Cotton Blend"},{"name":"Sleeve","value":"Full Sleeve"},{"name":"Pattern","value":"Solid"},{"name":"Reversible","value":"No"},{"name":"Collar","value":"Button Down"},{"name":"Fabric Care","value":"Regular Machine Wash"},{"name":"Suitable For","value":"Indian Wear"},{"name":"Hem","value":"Curved"},{"name":"Other Details","value":"Formal shirts for men"},{"name":"Net Quantity","value":"1"},{"name":"Dyed Type","value":"Ombre Dip Dye"},{"name":"Ideal For","value":"Men"},{"name":"Shirt Length","value":"Hip Length"},{"name":"Occasion","value":"Formal"},{"name":"Ornamentation Type","value":"None"},{"name":"Print Type","value":"Solid"},{"name":"Sales Package","value":"1 Shirt"},{"name":"Sleeve Style","value":"Regular Sleeves"},{"name":"Surface Styling","value":"Pockets"},{"name":"Trend","value":"Utility Shirts, Solid, Contrast collar"}]',
          'created_at' => '2026-09-12 17:23:53',
          'updated_at' => '2026-09-15 16:36:46',
          'values' => 
          array (
            0 => 
            array (
              'id' => 132,
              'variant_id' => 19,
              'attribute_id' => 1,
              'attribute_value_id' => 2,
              'attribute_value' => 'Black',
              'color_code' => '#000000',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 133,
              'variant_id' => 19,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 134,
              'variant_id' => 19,
              'attribute_id' => 2,
              'attribute_value_id' => 10,
              'attribute_value' => 'XL',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        10 => 
        array (
          'id' => 20,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Olive Green / XS',
          'sku' => 'VEBNOR-COTTON-OLI-XS',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 0,
          'max_purchase_quantity' => 5,
          'stock_status' => 'out_of_stock',
          'image' => 'products/var_1789214086_762.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214086_0_134.jpeg","products\\/var_gal_1789214086_1_941.jpeg","products\\/var_gal_1789214086_2_730.jpeg","products\\/var_gal_1789214086_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:24:46',
          'updated_at' => '2026-09-12 17:24:46',
          'values' => 
          array (
            0 => 
            array (
              'id' => 60,
              'variant_id' => 20,
              'attribute_id' => 1,
              'attribute_value_id' => 5,
              'attribute_value' => 'Olive Green',
              'color_code' => '#556b2f',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 61,
              'variant_id' => 20,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 62,
              'variant_id' => 20,
              'attribute_id' => 2,
              'attribute_value_id' => 6,
              'attribute_value' => 'XS',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        11 => 
        array (
          'id' => 21,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Olive Green / S',
          'sku' => 'VEBNOR-COTTON-OLI-S',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 21,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214086_762.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214086_0_134.jpeg","products\\/var_gal_1789214086_1_941.jpeg","products\\/var_gal_1789214086_2_730.jpeg","products\\/var_gal_1789214086_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:24:46',
          'updated_at' => '2026-09-22 19:11:05',
          'values' => 
          array (
            0 => 
            array (
              'id' => 63,
              'variant_id' => 21,
              'attribute_id' => 1,
              'attribute_value_id' => 5,
              'attribute_value' => 'Olive Green',
              'color_code' => '#556b2f',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 64,
              'variant_id' => 21,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 65,
              'variant_id' => 21,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        12 => 
        array (
          'id' => 22,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Olive Green / M',
          'sku' => 'VEBNOR-COTTON-OLI-M',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 40,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214086_762.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214086_0_134.jpeg","products\\/var_gal_1789214086_1_941.jpeg","products\\/var_gal_1789214086_2_730.jpeg","products\\/var_gal_1789214086_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:24:46',
          'updated_at' => '2026-09-12 17:24:46',
          'values' => 
          array (
            0 => 
            array (
              'id' => 66,
              'variant_id' => 22,
              'attribute_id' => 1,
              'attribute_value_id' => 5,
              'attribute_value' => 'Olive Green',
              'color_code' => '#556b2f',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 67,
              'variant_id' => 22,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 68,
              'variant_id' => 22,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        13 => 
        array (
          'id' => 23,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Olive Green / L',
          'sku' => 'VEBNOR-COTTON-OLI-L',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 54,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214086_762.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214086_0_134.jpeg","products\\/var_gal_1789214086_1_941.jpeg","products\\/var_gal_1789214086_2_730.jpeg","products\\/var_gal_1789214086_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:24:46',
          'updated_at' => '2026-09-23 10:45:56',
          'values' => 
          array (
            0 => 
            array (
              'id' => 69,
              'variant_id' => 23,
              'attribute_id' => 1,
              'attribute_value_id' => 5,
              'attribute_value' => 'Olive Green',
              'color_code' => '#556b2f',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 70,
              'variant_id' => 23,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 71,
              'variant_id' => 23,
              'attribute_id' => 2,
              'attribute_value_id' => 9,
              'attribute_value' => 'L',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        14 => 
        array (
          'id' => 24,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Olive Green / XL',
          'sku' => 'VEBNOR-COTTON-OLI-XL',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214086_762.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214086_0_134.jpeg","products\\/var_gal_1789214086_1_941.jpeg","products\\/var_gal_1789214086_2_730.jpeg","products\\/var_gal_1789214086_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:24:46',
          'updated_at' => '2026-09-12 17:24:46',
          'values' => 
          array (
            0 => 
            array (
              'id' => 72,
              'variant_id' => 24,
              'attribute_id' => 1,
              'attribute_value_id' => 5,
              'attribute_value' => 'Olive Green',
              'color_code' => '#556b2f',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 73,
              'variant_id' => 24,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 74,
              'variant_id' => 24,
              'attribute_id' => 2,
              'attribute_value_id' => 10,
              'attribute_value' => 'XL',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        15 => 
        array (
          'id' => 25,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / XS',
          'sku' => 'VEBNOR-COTTON-BEI-XS',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214134_266.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214134_0_317.jpeg","products\\/var_gal_1789214134_1_735.jpeg","products\\/var_gal_1789214134_2_911.jpeg","products\\/var_gal_1789214134_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:25:34',
          'updated_at' => '2026-09-12 17:25:34',
          'values' => 
          array (
            0 => 
            array (
              'id' => 75,
              'variant_id' => 25,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 76,
              'variant_id' => 25,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 77,
              'variant_id' => 25,
              'attribute_id' => 2,
              'attribute_value_id' => 6,
              'attribute_value' => 'XS',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        16 => 
        array (
          'id' => 26,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / S',
          'sku' => 'VEBNOR-COTTON-BEI-S',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 24,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214134_266.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214134_0_317.jpeg","products\\/var_gal_1789214134_1_735.jpeg","products\\/var_gal_1789214134_2_911.jpeg","products\\/var_gal_1789214134_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:25:34',
          'updated_at' => '2026-09-23 10:45:56',
          'values' => 
          array (
            0 => 
            array (
              'id' => 78,
              'variant_id' => 26,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 79,
              'variant_id' => 26,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 80,
              'variant_id' => 26,
              'attribute_id' => 2,
              'attribute_value_id' => 7,
              'attribute_value' => 'S',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        17 => 
        array (
          'id' => 27,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / M',
          'sku' => 'VEBNOR-COTTON-BEI-M',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 21,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214134_266.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214134_0_317.jpeg","products\\/var_gal_1789214134_1_735.jpeg","products\\/var_gal_1789214134_2_911.jpeg","products\\/var_gal_1789214134_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:25:34',
          'updated_at' => '2026-09-23 10:28:22',
          'values' => 
          array (
            0 => 
            array (
              'id' => 81,
              'variant_id' => 27,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 82,
              'variant_id' => 27,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 83,
              'variant_id' => 27,
              'attribute_id' => 2,
              'attribute_value_id' => 8,
              'attribute_value' => 'M',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        18 => 
        array (
          'id' => 28,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / L',
          'sku' => 'VEBNOR-COTTON-BEI-L',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 30,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214134_266.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214134_0_317.jpeg","products\\/var_gal_1789214134_1_735.jpeg","products\\/var_gal_1789214134_2_911.jpeg","products\\/var_gal_1789214134_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:25:34',
          'updated_at' => '2026-09-12 17:25:34',
          'values' => 
          array (
            0 => 
            array (
              'id' => 84,
              'variant_id' => 28,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 85,
              'variant_id' => 28,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 86,
              'variant_id' => 28,
              'attribute_id' => 2,
              'attribute_value_id' => 9,
              'attribute_value' => 'L',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        19 => 
        array (
          'id' => 29,
          'product_id' => 11,
          'title' => 'VeBNoR Men Regular Fit Solid Spread Collar Formal Shirt - Beige / XL',
          'sku' => 'VEBNOR-COTTON-BEI-XL',
          'price' => '999.00',
          'sale_price' => '351.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789214134_266.jpeg',
          'gallery_images' => '["products\\/var_gal_1789214134_0_317.jpeg","products\\/var_gal_1789214134_1_735.jpeg","products\\/var_gal_1789214134_2_911.jpeg","products\\/var_gal_1789214134_3_730.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-12 17:25:34',
          'updated_at' => '2026-09-12 17:25:34',
          'values' => 
          array (
            0 => 
            array (
              'id' => 87,
              'variant_id' => 29,
              'attribute_id' => 1,
              'attribute_value_id' => 1,
              'attribute_value' => 'Beige',
              'color_code' => '#f5f5dc',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 88,
              'variant_id' => 29,
              'attribute_id' => 4,
              'attribute_value_id' => 15,
              'attribute_value' => 'Cotton',
              'color_code' => NULL,
              'attribute_name' => 'Material',
              'attribute_slug' => 'material',
              'attribute_type' => 'select',
            ),
            2 => 
            array (
              'id' => 89,
              'variant_id' => 29,
              'attribute_id' => 2,
              'attribute_value_id' => 10,
              'attribute_value' => 'XL',
              'color_code' => NULL,
              'attribute_name' => 'Size',
              'attribute_slug' => 'size',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
      ),
      'color_swatches' => 
      array (
        0 => 
        array (
          'name' => 'Aqua',
          'value' => 'Aqua',
          'color_code' => '#adfff1',
          'image' => 'products/prod_1788722531_690.jpeg',
        ),
        1 => 
        array (
          'name' => 'Black',
          'value' => 'Black',
          'color_code' => '#000000',
          'image' => 'products/var_1789214033_965.jpeg',
        ),
        2 => 
        array (
          'name' => 'Olive Green',
          'value' => 'Olive Green',
          'color_code' => '#556b2f',
          'image' => 'products/var_1789214086_762.jpeg',
        ),
        3 => 
        array (
          'name' => 'Beige',
          'value' => 'Beige',
          'color_code' => '#f5f5dc',
          'image' => 'products/var_1789214134_266.jpeg',
        ),
      ),
      'attributes' => 
      array (
        'color' => 
        array (
          'name' => 'Color',
          'slug' => 'color',
          'type' => 'color',
          'values' => 
          array (
            0 => 
            array (
              'id' => 18,
              'value' => 'Aqua',
              'color_code' => '#adfff1',
            ),
            1 => 
            array (
              'id' => 2,
              'value' => 'Black',
              'color_code' => '#000000',
            ),
            2 => 
            array (
              'id' => 5,
              'value' => 'Olive Green',
              'color_code' => '#556b2f',
            ),
            3 => 
            array (
              'id' => 1,
              'value' => 'Beige',
              'color_code' => '#f5f5dc',
            ),
          ),
        ),
        'material' => 
        array (
          'name' => 'Material',
          'slug' => 'material',
          'type' => 'select',
          'values' => 
          array (
            0 => 
            array (
              'id' => 15,
              'value' => 'Cotton',
              'color_code' => NULL,
            ),
          ),
        ),
        'size' => 
        array (
          'name' => 'Size',
          'slug' => 'size',
          'type' => 'multiple_select',
          'values' => 
          array (
            0 => 
            array (
              'id' => 6,
              'value' => 'XS',
              'color_code' => NULL,
            ),
            1 => 
            array (
              'id' => 7,
              'value' => 'S',
              'color_code' => NULL,
            ),
            2 => 
            array (
              'id' => 8,
              'value' => 'M',
              'color_code' => NULL,
            ),
            3 => 
            array (
              'id' => 9,
              'value' => 'L',
              'color_code' => NULL,
            ),
            4 => 
            array (
              'id' => 10,
              'value' => 'XL',
              'color_code' => NULL,
            ),
          ),
        ),
      ),
      'specifications' => 
      array (
        0 => 
        array (
          'id' => 84,
          'product_id' => 11,
          'spec_name' => 'Pack of',
          'spec_value' => '1',
          'sort_order' => 0,
          'created_at' => '2026-09-16 12:48:24',
        ),
        1 => 
        array (
          'id' => 85,
          'product_id' => 11,
          'spec_name' => 'Closure',
          'spec_value' => 'Button',
          'sort_order' => 1,
          'created_at' => '2026-09-16 12:48:24',
        ),
        2 => 
        array (
          'id' => 86,
          'product_id' => 11,
          'spec_name' => 'Fit',
          'spec_value' => 'Regular',
          'sort_order' => 2,
          'created_at' => '2026-09-16 12:48:24',
        ),
        3 => 
        array (
          'id' => 87,
          'product_id' => 11,
          'spec_name' => 'Fabric',
          'spec_value' => 'Cotton Blend',
          'sort_order' => 3,
          'created_at' => '2026-09-16 12:48:24',
        ),
        4 => 
        array (
          'id' => 88,
          'product_id' => 11,
          'spec_name' => 'Sleeve',
          'spec_value' => 'Full Sleeve',
          'sort_order' => 4,
          'created_at' => '2026-09-16 12:48:24',
        ),
        5 => 
        array (
          'id' => 89,
          'product_id' => 11,
          'spec_name' => 'Pattern',
          'spec_value' => 'Solid',
          'sort_order' => 5,
          'created_at' => '2026-09-16 12:48:24',
        ),
        6 => 
        array (
          'id' => 90,
          'product_id' => 11,
          'spec_name' => 'Reversible',
          'spec_value' => 'No',
          'sort_order' => 6,
          'created_at' => '2026-09-16 12:48:24',
        ),
        7 => 
        array (
          'id' => 91,
          'product_id' => 11,
          'spec_name' => 'Collar',
          'spec_value' => 'Button Down',
          'sort_order' => 7,
          'created_at' => '2026-09-16 12:48:24',
        ),
        8 => 
        array (
          'id' => 92,
          'product_id' => 11,
          'spec_name' => 'Fabric Care',
          'spec_value' => 'Regular Machine Wash',
          'sort_order' => 8,
          'created_at' => '2026-09-16 12:48:24',
        ),
        9 => 
        array (
          'id' => 93,
          'product_id' => 11,
          'spec_name' => 'Suitable For',
          'spec_value' => 'Western Wear',
          'sort_order' => 9,
          'created_at' => '2026-09-16 12:48:24',
        ),
        10 => 
        array (
          'id' => 94,
          'product_id' => 11,
          'spec_name' => 'Hem',
          'spec_value' => 'Curved',
          'sort_order' => 10,
          'created_at' => '2026-09-16 12:48:24',
        ),
        11 => 
        array (
          'id' => 95,
          'product_id' => 11,
          'spec_name' => 'Other Details',
          'spec_value' => 'Formal shirts for men',
          'sort_order' => 11,
          'created_at' => '2026-09-16 12:48:24',
        ),
        12 => 
        array (
          'id' => 96,
          'product_id' => 11,
          'spec_name' => 'Net Quantity',
          'spec_value' => '1',
          'sort_order' => 12,
          'created_at' => '2026-09-16 12:48:24',
        ),
        13 => 
        array (
          'id' => 97,
          'product_id' => 11,
          'spec_name' => 'Dyed Type',
          'spec_value' => 'Ombre Dip Dye',
          'sort_order' => 13,
          'created_at' => '2026-09-16 12:48:24',
        ),
        14 => 
        array (
          'id' => 98,
          'product_id' => 11,
          'spec_name' => 'Ideal For',
          'spec_value' => 'Men',
          'sort_order' => 14,
          'created_at' => '2026-09-16 12:48:24',
        ),
        15 => 
        array (
          'id' => 99,
          'product_id' => 11,
          'spec_name' => 'Shirt Length',
          'spec_value' => 'Hip Length',
          'sort_order' => 15,
          'created_at' => '2026-09-16 12:48:24',
        ),
        16 => 
        array (
          'id' => 100,
          'product_id' => 11,
          'spec_name' => 'Occasion',
          'spec_value' => 'Formal',
          'sort_order' => 16,
          'created_at' => '2026-09-16 12:48:24',
        ),
        17 => 
        array (
          'id' => 101,
          'product_id' => 11,
          'spec_name' => 'Ornamentation Type',
          'spec_value' => 'None',
          'sort_order' => 17,
          'created_at' => '2026-09-16 12:48:24',
        ),
        18 => 
        array (
          'id' => 102,
          'product_id' => 11,
          'spec_name' => 'Print Type',
          'spec_value' => 'Solid',
          'sort_order' => 18,
          'created_at' => '2026-09-16 12:48:24',
        ),
        19 => 
        array (
          'id' => 103,
          'product_id' => 11,
          'spec_name' => 'Sales Package',
          'spec_value' => '1 Shirt',
          'sort_order' => 19,
          'created_at' => '2026-09-16 12:48:24',
        ),
        20 => 
        array (
          'id' => 104,
          'product_id' => 11,
          'spec_name' => 'Sleeve Style',
          'spec_value' => 'Regular Sleeves',
          'sort_order' => 20,
          'created_at' => '2026-09-16 12:48:24',
        ),
        21 => 
        array (
          'id' => 105,
          'product_id' => 11,
          'spec_name' => 'Surface Styling',
          'spec_value' => 'Pockets',
          'sort_order' => 21,
          'created_at' => '2026-09-16 12:48:24',
        ),
        22 => 
        array (
          'id' => 106,
          'product_id' => 11,
          'spec_name' => 'Trend',
          'spec_value' => 'Utility Shirts, Solid, Contrast collar',
          'sort_order' => 22,
          'created_at' => '2026-09-16 12:48:24',
        ),
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 3,
          'product_id' => 11,
          'user_id' => 3,
          'order_number' => 'ORD-20260922-FFF5',
          'customer_name' => 'Kaustav Chowdhury',
          'customer_email' => 'kaustav@gmail.com',
          'rating' => 4,
          'title' => '',
          'review' => 'Product delivered in great condition.',
          'images' => '["reviews\\/rev_1790150062_6ab385aebc1b2.jpeg","reviews\\/rev_1790150062_6ab385aebca2a.jpeg","reviews\\/rev_1790150062_6ab385aebcea0.jpeg","reviews\\/rev_1790150062_6ab385aebd334.jpeg"]',
          'status' => 'approved',
          'created_at' => '2026-09-23 09:54:22',
        ),
      ),
    ),
    10 => 
    array (
      'id' => 13,
      'category_id' => 60,
      'brand_id' => 8,
      'product_type' => 'variable',
      'title' => 'Apple iPhone Duo',
      'slug' => 'apple-iphone-duo',
      'sku' => 'APPLE-IPHONE',
      'price' => '299900.00',
      'sale_price' => NULL,
      'tax_rate' => '0.00',
      'stock_quantity' => 104,
      'low_stock_threshold' => 5,
      'max_purchase_quantity' => 5,
      'stock_status' => 'in_stock',
      'short_description' => 'iPhone Duo offers the most immersive viewing experience of any iPhone. The aspect ratio of the 19.26 cm (7.6″) Super Retina XDR display4 is consistent across the inner and outer display. The inner display is made of 10 ultra-thin layers with a custom nano‑texture finish that reduces glare. And the under‑display FaceTime camera is hidden until you need it.',
      'description' => '',
      'highlights' => '[{"key":"Chip Set","value":"A20 Pro chip, 6 Core Processor | Hexa Core"},{"key":"Rear Camera","value":"48MP + 48MP"},{"key":"Front Camera","value":"12MP"},{"key":"Screen","value":"7.6 inch"}]',
      'main_image' => 'products/prod_1789653846_488.jpeg',
      'gallery_images' => '["products\\/prod_gal_1789653846_0_306.jpeg","products\\/prod_gal_1789653846_1_858.jpeg","products\\/prod_gal_1789653846_2_800.jpeg","products\\/prod_gal_1789653846_3_445.jpeg","products\\/prod_gal_1789653847_4_678.jpeg","products\\/prod_gal_1789653847_5_782.jpeg","products\\/prod_gal_1789653847_6_736.jpeg","products\\/prod_gal_1789653847_7_117.jpeg","products\\/prod_gal_1789653847_8_226.jpeg"]',
      'is_featured' => 0,
      'is_trending' => 1,
      'is_new' => 1,
      'is_cod_allowed' => 1,
      'rating' => '5.00',
      'reviews_count' => 0,
      'status' => 'published',
      'created_at' => '2026-09-17 19:34:07',
      'updated_at' => '2026-09-21 16:08:53',
      'category_name' => 'Flagship 5G Smartphones',
      'category_slug' => 'flagship-5g-smartphones',
      'brand_name' => 'Apple',
      'brand_slug' => 'apple',
      'gallery_images_decoded' => 
      array (
        0 => 'products/prod_gal_1789653846_0_306.jpeg',
        1 => 'products/prod_gal_1789653846_1_858.jpeg',
        2 => 'products/prod_gal_1789653846_2_800.jpeg',
        3 => 'products/prod_gal_1789653846_3_445.jpeg',
        4 => 'products/prod_gal_1789653847_4_678.jpeg',
        5 => 'products/prod_gal_1789653847_5_782.jpeg',
        6 => 'products/prod_gal_1789653847_6_736.jpeg',
        7 => 'products/prod_gal_1789653847_7_117.jpeg',
        8 => 'products/prod_gal_1789653847_8_226.jpeg',
      ),
      'highlights_decoded' => 
      array (
        0 => 
        array (
          'key' => 'Chip Set',
          'value' => 'A20 Pro chip, 6 Core Processor | Hexa Core',
        ),
        1 => 
        array (
          'key' => 'Rear Camera',
          'value' => '48MP + 48MP',
        ),
        2 => 
        array (
          'key' => 'Front Camera',
          'value' => '12MP',
        ),
        3 => 
        array (
          'key' => 'Screen',
          'value' => '7.6 inch',
        ),
      ),
      'variants' => 
      array (
        0 => 
        array (
          'id' => 32,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Star White / 256GB',
          'sku' => 'APPLE-IPHONE-256GB',
          'price' => '299900.00',
          'sale_price' => '299900.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1789653846_488.jpeg',
          'gallery_images' => '["products\\/prod_gal_1789653846_0_306.jpeg","products\\/prod_gal_1789653846_1_858.jpeg","products\\/prod_gal_1789653846_2_800.jpeg","products\\/prod_gal_1789653846_3_445.jpeg","products\\/prod_gal_1789653847_4_678.jpeg","products\\/prod_gal_1789653847_5_782.jpeg","products\\/prod_gal_1789653847_6_736.jpeg","products\\/prod_gal_1789653847_7_117.jpeg","products\\/prod_gal_1789653847_8_226.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-17 19:34:07',
          'updated_at' => '2026-09-17 19:34:07',
          'values' => 
          array (
            0 => 
            array (
              'id' => 139,
              'variant_id' => 32,
              'attribute_id' => 1,
              'attribute_value_id' => 20,
              'attribute_value' => 'Star White',
              'color_code' => '#f5f9ff',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 140,
              'variant_id' => 32,
              'attribute_id' => 3,
              'attribute_value_id' => 13,
              'attribute_value' => '256GB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        1 => 
        array (
          'id' => 33,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Star White / 512GB',
          'sku' => 'APPLE-IPHONE-512GB',
          'price' => '299900.00',
          'sale_price' => '324900.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1789653846_488.jpeg',
          'gallery_images' => '["products\\/prod_gal_1789653846_0_306.jpeg","products\\/prod_gal_1789653846_1_858.jpeg","products\\/prod_gal_1789653846_2_800.jpeg","products\\/prod_gal_1789653846_3_445.jpeg","products\\/prod_gal_1789653847_4_678.jpeg","products\\/prod_gal_1789653847_5_782.jpeg","products\\/prod_gal_1789653847_6_736.jpeg","products\\/prod_gal_1789653847_7_117.jpeg","products\\/prod_gal_1789653847_8_226.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-17 19:34:07',
          'updated_at' => '2026-09-17 19:34:07',
          'values' => 
          array (
            0 => 
            array (
              'id' => 141,
              'variant_id' => 33,
              'attribute_id' => 1,
              'attribute_value_id' => 20,
              'attribute_value' => 'Star White',
              'color_code' => '#f5f9ff',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 142,
              'variant_id' => 33,
              'attribute_id' => 3,
              'attribute_value_id' => 21,
              'attribute_value' => '512GB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        2 => 
        array (
          'id' => 34,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Star White / 1TB',
          'sku' => 'APPLE-IPHONE-1TB',
          'price' => '299900.00',
          'sale_price' => '374900.00',
          'stock_quantity' => 10,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/prod_1789653846_488.jpeg',
          'gallery_images' => '["products\\/prod_gal_1789653846_0_306.jpeg","products\\/prod_gal_1789653846_1_858.jpeg","products\\/prod_gal_1789653846_2_800.jpeg","products\\/prod_gal_1789653846_3_445.jpeg","products\\/prod_gal_1789653847_4_678.jpeg","products\\/prod_gal_1789653847_5_782.jpeg","products\\/prod_gal_1789653847_6_736.jpeg","products\\/prod_gal_1789653847_7_117.jpeg","products\\/prod_gal_1789653847_8_226.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-17 19:34:07',
          'updated_at' => '2026-09-17 19:34:07',
          'values' => 
          array (
            0 => 
            array (
              'id' => 143,
              'variant_id' => 34,
              'attribute_id' => 1,
              'attribute_value_id' => 20,
              'attribute_value' => 'Star White',
              'color_code' => '#f5f9ff',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 144,
              'variant_id' => 34,
              'attribute_id' => 3,
              'attribute_value_id' => 22,
              'attribute_value' => '1TB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        3 => 
        array (
          'id' => 35,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Star White / 2TB',
          'sku' => 'APPLE-IPHONE-2TB',
          'price' => '299900.00',
          'sale_price' => '449900.00',
          'stock_quantity' => 0,
          'max_purchase_quantity' => 5,
          'stock_status' => 'out_of_stock',
          'image' => 'products/prod_1789653846_488.jpeg',
          'gallery_images' => '["products\\/prod_gal_1789653846_0_306.jpeg","products\\/prod_gal_1789653846_1_858.jpeg","products\\/prod_gal_1789653846_2_800.jpeg","products\\/prod_gal_1789653846_3_445.jpeg","products\\/prod_gal_1789653847_4_678.jpeg","products\\/prod_gal_1789653847_5_782.jpeg","products\\/prod_gal_1789653847_6_736.jpeg","products\\/prod_gal_1789653847_7_117.jpeg","products\\/prod_gal_1789653847_8_226.jpeg"]',
          'highlights' => NULL,
          'specifications' => NULL,
          'created_at' => '2026-09-17 19:34:07',
          'updated_at' => '2026-09-17 19:34:07',
          'values' => 
          array (
            0 => 
            array (
              'id' => 145,
              'variant_id' => 35,
              'attribute_id' => 1,
              'attribute_value_id' => 20,
              'attribute_value' => 'Star White',
              'color_code' => '#f5f9ff',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 146,
              'variant_id' => 35,
              'attribute_id' => 3,
              'attribute_value_id' => 23,
              'attribute_value' => '2TB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        4 => 
        array (
          'id' => 36,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Night Sky / 256GB',
          'sku' => 'APPLE-IPHONE-NIG-256GB',
          'price' => '299900.00',
          'sale_price' => '299900.00',
          'stock_quantity' => 15,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789985084_209.jpeg',
          'gallery_images' => '["products\\/var_gal_1789985084_0_245.jpeg","products\\/var_gal_1789985084_1_309.jpeg","products\\/var_gal_1789985084_2_148.jpeg","products\\/var_gal_1789985084_3_258.jpeg","products\\/var_gal_1789985084_4_404.jpeg"]',
          'highlights' => '[{"key":"Chip Set","value":"A20 Pro chip, 6 Core Processor | Hexa Core"},{"key":"Rear Camera","value":"48MP + 48MP"},{"key":"Front Camera","value":"12MP"},{"key":"Screen","value":"7.6 inch"}]',
          'specifications' => '[{"name":"Battery Type","value":"Lithium Ion"},{"name":"Dual Battery","value":"Dual Battery No"},{"name":"Height","value":"117.7 mm (11.77 cm)"},{"name":"Weight","value":"254 g"},{"name":"Display Size","value":"19.3 cm (7.6 inch)"},{"name":"Resolution","value":"1878 x 2670 pixels"},{"name":"GPU","value":"7-core GPU with Neural Accelerators"},{"name":"HD Game Support","value":"Yes"},{"name":"Operating System","value":"iOS 27"},{"name":"Processor Type","value":"A20 Pro chip, 6 Core Processor"},{"name":"Processor Core","value":"Hexa Core"},{"name":"Primary Camera Available","value":"Yes"},{"name":"Primary Camera","value":"48MP + 48MP"},{"name":"Secondary Camera Available","value":"Yes"},{"name":"Optical Zoom","value":"Yes"},{"name":"Secondary Camera","value":"12MP Front Camera"},{"name":"Secondary Camera Features","value":"12MP Center Stage front camera, Ultra-stabilised video, Dual Capture, Centre Stage for photos and video calls, Under-display FaceTime camera"},{"name":"Supported Languages","value":"English (Australia, UK, US), Chinese (Simplified, Traditional, Traditional - Hong Kong), French (Canada, France), German, Italian, Japanese, Korean, Spanish (Latin America, Spain), Arabic, Bulgarian, Catalan, Croatian, Czech, Danish, Dutch, Finnish, Greek, Hebrew, Hindi, Hungarian, Indonesian, Kazakh, Malay, Norwegian, Polish, Portuguese (Brazil, Portugal), Romanian, Russian, Slovak, Swedish, Thai, Turkish, Ukrainian, Vietnamese"},{"name":"Browser","value":"Safari"},{"name":"Important Apps","value":"Apple Store, App Store, Books, Calculator, Calendar, Camera, Clips, Clock, Compass, Contacts, FaceTime, Files, Find My, Fitness, Freeform, GarageBand, Health, Home, iMovie, iTunes Store, Keynote, Magnifier, Mail, Maps, Measure, Messages, Music, News, Notes, Numbers, Pages, Passwords, Phone, Photos, Podcasts, Reminders, Safari, Settings, Shortcuts, Stocks, Tips, Translate, TV, Voice Memos, Wallet, Watch, Weather"}]',
          'created_at' => '2026-09-21 15:34:44',
          'updated_at' => '2026-09-21 15:34:44',
          'values' => 
          array (
            0 => 
            array (
              'id' => 147,
              'variant_id' => 36,
              'attribute_id' => 1,
              'attribute_value_id' => 19,
              'attribute_value' => 'Night Sky',
              'color_code' => '#494a4b',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 148,
              'variant_id' => 36,
              'attribute_id' => 3,
              'attribute_value_id' => 13,
              'attribute_value' => '256GB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        5 => 
        array (
          'id' => 37,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Night Sky / 512GB',
          'sku' => 'APPLE-IPHONE-NIG-512GB',
          'price' => '299900.00',
          'sale_price' => '324900.00',
          'stock_quantity' => 20,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789985084_209.jpeg',
          'gallery_images' => '["products\\/var_gal_1789985084_0_245.jpeg","products\\/var_gal_1789985084_1_309.jpeg","products\\/var_gal_1789985084_2_148.jpeg","products\\/var_gal_1789985084_3_258.jpeg","products\\/var_gal_1789985084_4_404.jpeg"]',
          'highlights' => '[{"key":"Chip Set","value":"A20 Pro chip, 6 Core Processor | Hexa Core"},{"key":"Rear Camera","value":"48MP + 48MP"},{"key":"Front Camera","value":"12MP"},{"key":"Screen","value":"7.6 inch"}]',
          'specifications' => '[{"name":"Battery Type","value":"Lithium Ion"},{"name":"Dual Battery","value":"Dual Battery No"},{"name":"Height","value":"117.7 mm (11.77 cm)"},{"name":"Weight","value":"254 g"},{"name":"Display Size","value":"19.3 cm (7.6 inch)"},{"name":"Resolution","value":"1878 x 2670 pixels"},{"name":"GPU","value":"7-core GPU with Neural Accelerators"},{"name":"HD Game Support","value":"Yes"},{"name":"Operating System","value":"iOS 27"},{"name":"Processor Type","value":"A20 Pro chip, 6 Core Processor"},{"name":"Processor Core","value":"Hexa Core"},{"name":"Primary Camera Available","value":"Yes"},{"name":"Primary Camera","value":"48MP + 48MP"},{"name":"Secondary Camera Available","value":"Yes"},{"name":"Optical Zoom","value":"Yes"},{"name":"Secondary Camera","value":"12MP Front Camera"},{"name":"Secondary Camera Features","value":"12MP Center Stage front camera, Ultra-stabilised video, Dual Capture, Centre Stage for photos and video calls, Under-display FaceTime camera"},{"name":"Supported Languages","value":"English (Australia, UK, US), Chinese (Simplified, Traditional, Traditional - Hong Kong), French (Canada, France), German, Italian, Japanese, Korean, Spanish (Latin America, Spain), Arabic, Bulgarian, Catalan, Croatian, Czech, Danish, Dutch, Finnish, Greek, Hebrew, Hindi, Hungarian, Indonesian, Kazakh, Malay, Norwegian, Polish, Portuguese (Brazil, Portugal), Romanian, Russian, Slovak, Swedish, Thai, Turkish, Ukrainian, Vietnamese"},{"name":"Browser","value":"Safari"},{"name":"Important Apps","value":"Apple Store, App Store, Books, Calculator, Calendar, Camera, Clips, Clock, Compass, Contacts, FaceTime, Files, Find My, Fitness, Freeform, GarageBand, Health, Home, iMovie, iTunes Store, Keynote, Magnifier, Mail, Maps, Measure, Messages, Music, News, Notes, Numbers, Pages, Passwords, Phone, Photos, Podcasts, Reminders, Safari, Settings, Shortcuts, Stocks, Tips, Translate, TV, Voice Memos, Wallet, Watch, Weather"}]',
          'created_at' => '2026-09-21 15:34:44',
          'updated_at' => '2026-09-21 15:34:44',
          'values' => 
          array (
            0 => 
            array (
              'id' => 149,
              'variant_id' => 37,
              'attribute_id' => 1,
              'attribute_value_id' => 19,
              'attribute_value' => 'Night Sky',
              'color_code' => '#494a4b',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 150,
              'variant_id' => 37,
              'attribute_id' => 3,
              'attribute_value_id' => 21,
              'attribute_value' => '512GB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        6 => 
        array (
          'id' => 38,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Night Sky / 1TB',
          'sku' => 'APPLE-IPHONE-NIG-1TB',
          'price' => '299900.00',
          'sale_price' => '374900.00',
          'stock_quantity' => 25,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789985084_209.jpeg',
          'gallery_images' => '["products\\/var_gal_1789985084_0_245.jpeg","products\\/var_gal_1789985084_1_309.jpeg","products\\/var_gal_1789985084_2_148.jpeg","products\\/var_gal_1789985084_3_258.jpeg","products\\/var_gal_1789985084_4_404.jpeg"]',
          'highlights' => '[{"key":"Chip Set","value":"A20 Pro chip, 6 Core Processor | Hexa Core"},{"key":"Rear Camera","value":"48MP + 48MP"},{"key":"Front Camera","value":"12MP"},{"key":"Screen","value":"7.6 inch"}]',
          'specifications' => '[{"name":"Battery Type","value":"Lithium Ion"},{"name":"Dual Battery","value":"Dual Battery No"},{"name":"Height","value":"117.7 mm (11.77 cm)"},{"name":"Weight","value":"254 g"},{"name":"Display Size","value":"19.3 cm (7.6 inch)"},{"name":"Resolution","value":"1878 x 2670 pixels"},{"name":"GPU","value":"7-core GPU with Neural Accelerators"},{"name":"HD Game Support","value":"Yes"},{"name":"Operating System","value":"iOS 27"},{"name":"Processor Type","value":"A20 Pro chip, 6 Core Processor"},{"name":"Processor Core","value":"Hexa Core"},{"name":"Primary Camera Available","value":"Yes"},{"name":"Primary Camera","value":"48MP + 48MP"},{"name":"Secondary Camera Available","value":"Yes"},{"name":"Optical Zoom","value":"Yes"},{"name":"Secondary Camera","value":"12MP Front Camera"},{"name":"Secondary Camera Features","value":"12MP Center Stage front camera, Ultra-stabilised video, Dual Capture, Centre Stage for photos and video calls, Under-display FaceTime camera"},{"name":"Supported Languages","value":"English (Australia, UK, US), Chinese (Simplified, Traditional, Traditional - Hong Kong), French (Canada, France), German, Italian, Japanese, Korean, Spanish (Latin America, Spain), Arabic, Bulgarian, Catalan, Croatian, Czech, Danish, Dutch, Finnish, Greek, Hebrew, Hindi, Hungarian, Indonesian, Kazakh, Malay, Norwegian, Polish, Portuguese (Brazil, Portugal), Romanian, Russian, Slovak, Swedish, Thai, Turkish, Ukrainian, Vietnamese"},{"name":"Browser","value":"Safari"},{"name":"Important Apps","value":"Apple Store, App Store, Books, Calculator, Calendar, Camera, Clips, Clock, Compass, Contacts, FaceTime, Files, Find My, Fitness, Freeform, GarageBand, Health, Home, iMovie, iTunes Store, Keynote, Magnifier, Mail, Maps, Measure, Messages, Music, News, Notes, Numbers, Pages, Passwords, Phone, Photos, Podcasts, Reminders, Safari, Settings, Shortcuts, Stocks, Tips, Translate, TV, Voice Memos, Wallet, Watch, Weather"}]',
          'created_at' => '2026-09-21 15:34:44',
          'updated_at' => '2026-09-21 15:34:44',
          'values' => 
          array (
            0 => 
            array (
              'id' => 151,
              'variant_id' => 38,
              'attribute_id' => 1,
              'attribute_value_id' => 19,
              'attribute_value' => 'Night Sky',
              'color_code' => '#494a4b',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 152,
              'variant_id' => 38,
              'attribute_id' => 3,
              'attribute_value_id' => 22,
              'attribute_value' => '1TB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
        7 => 
        array (
          'id' => 39,
          'product_id' => 13,
          'title' => 'Apple iPhone Duo - Night Sky / 2TB',
          'sku' => 'APPLE-IPHONE-NIG-2TB',
          'price' => '299900.00',
          'sale_price' => '449900.00',
          'stock_quantity' => 14,
          'max_purchase_quantity' => 5,
          'stock_status' => 'in_stock',
          'image' => 'products/var_1789985084_209.jpeg',
          'gallery_images' => '["products\\/var_gal_1789985084_0_245.jpeg","products\\/var_gal_1789985084_1_309.jpeg","products\\/var_gal_1789985084_2_148.jpeg","products\\/var_gal_1789985084_3_258.jpeg","products\\/var_gal_1789985084_4_404.jpeg"]',
          'highlights' => '[{"key":"Chip Set","value":"A20 Pro chip, 6 Core Processor | Hexa Core"},{"key":"Rear Camera","value":"48MP + 48MP"},{"key":"Front Camera","value":"12MP"},{"key":"Screen","value":"7.6 inch"}]',
          'specifications' => '[{"name":"Battery Type","value":"Lithium Ion"},{"name":"Dual Battery","value":"Dual Battery No"},{"name":"Height","value":"117.7 mm (11.77 cm)"},{"name":"Weight","value":"254 g"},{"name":"Display Size","value":"19.3 cm (7.6 inch)"},{"name":"Resolution","value":"1878 x 2670 pixels"},{"name":"GPU","value":"7-core GPU with Neural Accelerators"},{"name":"HD Game Support","value":"Yes"},{"name":"Operating System","value":"iOS 27"},{"name":"Processor Type","value":"A20 Pro chip, 6 Core Processor"},{"name":"Processor Core","value":"Hexa Core"},{"name":"Primary Camera Available","value":"Yes"},{"name":"Primary Camera","value":"48MP + 48MP"},{"name":"Secondary Camera Available","value":"Yes"},{"name":"Optical Zoom","value":"Yes"},{"name":"Secondary Camera","value":"12MP Front Camera"},{"name":"Secondary Camera Features","value":"12MP Center Stage front camera, Ultra-stabilised video, Dual Capture, Centre Stage for photos and video calls, Under-display FaceTime camera"},{"name":"Supported Languages","value":"English (Australia, UK, US), Chinese (Simplified, Traditional, Traditional - Hong Kong), French (Canada, France), German, Italian, Japanese, Korean, Spanish (Latin America, Spain), Arabic, Bulgarian, Catalan, Croatian, Czech, Danish, Dutch, Finnish, Greek, Hebrew, Hindi, Hungarian, Indonesian, Kazakh, Malay, Norwegian, Polish, Portuguese (Brazil, Portugal), Romanian, Russian, Slovak, Swedish, Thai, Turkish, Ukrainian, Vietnamese"},{"name":"Browser","value":"Safari"},{"name":"Important Apps","value":"Apple Store, App Store, Books, Calculator, Calendar, Camera, Clips, Clock, Compass, Contacts, FaceTime, Files, Find My, Fitness, Freeform, GarageBand, Health, Home, iMovie, iTunes Store, Keynote, Magnifier, Mail, Maps, Measure, Messages, Music, News, Notes, Numbers, Pages, Passwords, Phone, Photos, Podcasts, Reminders, Safari, Settings, Shortcuts, Stocks, Tips, Translate, TV, Voice Memos, Wallet, Watch, Weather"}]',
          'created_at' => '2026-09-21 15:34:44',
          'updated_at' => '2026-09-21 15:34:44',
          'values' => 
          array (
            0 => 
            array (
              'id' => 153,
              'variant_id' => 39,
              'attribute_id' => 1,
              'attribute_value_id' => 19,
              'attribute_value' => 'Night Sky',
              'color_code' => '#494a4b',
              'attribute_name' => 'Color',
              'attribute_slug' => 'color',
              'attribute_type' => 'color',
            ),
            1 => 
            array (
              'id' => 154,
              'variant_id' => 39,
              'attribute_id' => 3,
              'attribute_value_id' => 23,
              'attribute_value' => '2TB',
              'color_code' => NULL,
              'attribute_name' => 'Storage',
              'attribute_slug' => 'storage',
              'attribute_type' => 'multiple_select',
            ),
          ),
        ),
      ),
      'color_swatches' => 
      array (
        0 => 
        array (
          'name' => 'Star White',
          'value' => 'Star White',
          'color_code' => '#f5f9ff',
          'image' => 'products/prod_1789653846_488.jpeg',
        ),
        1 => 
        array (
          'name' => 'Night Sky',
          'value' => 'Night Sky',
          'color_code' => '#494a4b',
          'image' => 'products/var_1789985084_209.jpeg',
        ),
      ),
      'attributes' => 
      array (
        'color' => 
        array (
          'name' => 'Color',
          'slug' => 'color',
          'type' => 'color',
          'values' => 
          array (
            0 => 
            array (
              'id' => 20,
              'value' => 'Star White',
              'color_code' => '#f5f9ff',
            ),
            1 => 
            array (
              'id' => 19,
              'value' => 'Night Sky',
              'color_code' => '#494a4b',
            ),
          ),
        ),
        'storage' => 
        array (
          'name' => 'Storage',
          'slug' => 'storage',
          'type' => 'multiple_select',
          'values' => 
          array (
            0 => 
            array (
              'id' => 13,
              'value' => '256GB',
              'color_code' => NULL,
            ),
            1 => 
            array (
              'id' => 21,
              'value' => '512GB',
              'color_code' => NULL,
            ),
            2 => 
            array (
              'id' => 22,
              'value' => '1TB',
              'color_code' => NULL,
            ),
            3 => 
            array (
              'id' => 23,
              'value' => '2TB',
              'color_code' => NULL,
            ),
          ),
        ),
      ),
      'specifications' => 
      array (
        0 => 
        array (
          'id' => 115,
          'product_id' => 13,
          'spec_name' => 'Battery Type',
          'spec_value' => 'Lithium Ion',
          'sort_order' => 0,
          'created_at' => '2026-09-21 16:08:53',
        ),
        1 => 
        array (
          'id' => 116,
          'product_id' => 13,
          'spec_name' => 'Dual Battery',
          'spec_value' => 'Dual Battery No',
          'sort_order' => 1,
          'created_at' => '2026-09-21 16:08:53',
        ),
        2 => 
        array (
          'id' => 117,
          'product_id' => 13,
          'spec_name' => 'Height',
          'spec_value' => '117.7 mm (11.77 cm)',
          'sort_order' => 2,
          'created_at' => '2026-09-21 16:08:53',
        ),
        3 => 
        array (
          'id' => 118,
          'product_id' => 13,
          'spec_name' => 'Weight',
          'spec_value' => '254 g',
          'sort_order' => 3,
          'created_at' => '2026-09-21 16:08:53',
        ),
        4 => 
        array (
          'id' => 119,
          'product_id' => 13,
          'spec_name' => 'Display Size',
          'spec_value' => '19.3 cm (7.6 inch)',
          'sort_order' => 4,
          'created_at' => '2026-09-21 16:08:53',
        ),
        5 => 
        array (
          'id' => 120,
          'product_id' => 13,
          'spec_name' => 'Resolution',
          'spec_value' => '1878 x 2670 pixels',
          'sort_order' => 5,
          'created_at' => '2026-09-21 16:08:53',
        ),
        6 => 
        array (
          'id' => 121,
          'product_id' => 13,
          'spec_name' => 'GPU',
          'spec_value' => '7-core GPU with Neural Accelerators',
          'sort_order' => 6,
          'created_at' => '2026-09-21 16:08:53',
        ),
        7 => 
        array (
          'id' => 122,
          'product_id' => 13,
          'spec_name' => 'HD Game Support',
          'spec_value' => 'Yes',
          'sort_order' => 7,
          'created_at' => '2026-09-21 16:08:53',
        ),
      ),
      'reviews' => 
      array (
        0 => 
        array (
          'id' => 1,
          'product_id' => 13,
          'user_id' => 1,
          'customer_name' => 'Sophia Reynolds',
          'customer_email' => 'sophia@example.com',
          'rating' => 5,
          'title' => 'Exceptional fabric quality and perfect fit!',
          'review' => 'Ordered this last week and I am genuinely impressed with the stitching, breathable fabric, and rich color. Fits true to size!',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-14 14:20:00',
        ),
        1 => 
        array (
          'id' => 2,
          'product_id' => 13,
          'user_id' => 2,
          'customer_name' => 'Aarav Mehta',
          'customer_email' => 'aarav@example.com',
          'rating' => 5,
          'title' => 'Value for money & fast delivery',
          'review' => 'Looks exactly like the photos. Very comfortable for all-day wear and the packaging was premium.',
          'images' => NULL,
          'status' => 'approved',
          'created_at' => '2026-09-16 10:15:00',
        ),
      ),
    ),
  ),
  'common_product' => 
  array (
    'id' => 1,
    'category_id' => 1,
    'brand_id' => 1,
    'product_type' => 'variable',
    'title' => 'V-neck Linen Blend Summer Dress',
    'slug' => 'v-neck-linen-blend-summer-dress',
    'sku' => 'MOD-W-001',
    'price' => '89.00',
    'sale_price' => '69.00',
    'tax_rate' => '5.00',
    'stock_quantity' => 45,
    'low_stock_threshold' => 10,
    'max_purchase_quantity' => 5,
    'stock_status' => 'in_stock',
    'short_description' => 'Lightweight, breathable linen blend dress tailored for warm weather elegance.',
    'description' => 'Designed with relaxed sophistication, this dress features an airy silhouette, a feminine V-neckline, and sustainable organic linen fabric. Machine washable with minimal shrinkage.',
    'highlights' => '[{"key":"Pack of","value":"1"},{"key":"Fabric","value":"Cotton Blend"},{"key":"Sleeve","value":"Full Sleeve"},{"key":"Pattern","value":"Solid"},{"key":"Collar","value":"Spread"},{"key":"Color","value":"Grey"}]',
    'main_image' => 'products/womens/women-1.jpg',
    'gallery_images' => '["products/womens/women-2.jpg","products/womens/women-3.jpg"]',
    'is_featured' => 1,
    'is_trending' => 1,
    'is_new' => 1,
    'is_cod_allowed' => 1,
    'rating' => '4.90',
    'reviews_count' => 18,
    'status' => 'published',
    'created_at' => '2026-09-07 12:38:10',
    'updated_at' => '2026-09-12 20:11:25',
    'category_name' => 'Womens Fashion',
    'category_slug' => 'womens-fashion',
    'brand_name' => 'Modave Luxe',
    'brand_slug' => 'modave-luxe',
    'gallery_images_decoded' => 
    array (
      0 => 'products/womens/women-2.jpg',
      1 => 'products/womens/women-3.jpg',
    ),
    'highlights_decoded' => 
    array (
      0 => 
      array (
        'key' => 'Pack of',
        'value' => '1',
      ),
      1 => 
      array (
        'key' => 'Fabric',
        'value' => 'Cotton Blend',
      ),
      2 => 
      array (
        'key' => 'Sleeve',
        'value' => 'Full Sleeve',
      ),
      3 => 
      array (
        'key' => 'Pattern',
        'value' => 'Solid',
      ),
      4 => 
      array (
        'key' => 'Collar',
        'value' => 'Spread',
      ),
      5 => 
      array (
        'key' => 'Color',
        'value' => 'Grey',
      ),
    ),
    'variants' => 
    array (
      0 => 
      array (
        'id' => 1,
        'product_id' => 1,
        'title' => 'V-neck Linen Summer Dress - Beige / S',
        'sku' => 'MOD-W-001-BG-S',
        'price' => '89.00',
        'sale_price' => '79.00',
        'stock_quantity' => 15,
        'max_purchase_quantity' => 5,
        'stock_status' => 'in_stock',
        'image' => 'products/womens/women-1.jpg',
        'gallery_images' => NULL,
        'highlights' => NULL,
        'specifications' => NULL,
        'created_at' => '2026-09-07 13:04:48',
        'updated_at' => '2026-09-07 13:04:48',
        'values' => 
        array (
          0 => 
          array (
            'id' => 1,
            'variant_id' => 1,
            'attribute_id' => 1,
            'attribute_value_id' => 1,
            'attribute_value' => 'Beige',
            'color_code' => '#f5f5dc',
            'attribute_name' => 'Color',
            'attribute_slug' => 'color',
            'attribute_type' => 'color',
          ),
          1 => 
          array (
            'id' => 2,
            'variant_id' => 1,
            'attribute_id' => 2,
            'attribute_value_id' => 7,
            'attribute_value' => 'S',
            'color_code' => NULL,
            'attribute_name' => 'Size',
            'attribute_slug' => 'size',
            'attribute_type' => 'multiple_select',
          ),
        ),
      ),
      1 => 
      array (
        'id' => 2,
        'product_id' => 1,
        'title' => 'V-neck Linen Summer Dress - Beige / M',
        'sku' => 'MOD-W-001-BG-M',
        'price' => '89.00',
        'sale_price' => '79.00',
        'stock_quantity' => 20,
        'max_purchase_quantity' => 5,
        'stock_status' => 'in_stock',
        'image' => 'products/womens/women-1.jpg',
        'gallery_images' => NULL,
        'highlights' => NULL,
        'specifications' => NULL,
        'created_at' => '2026-09-07 13:04:48',
        'updated_at' => '2026-09-07 13:04:48',
        'values' => 
        array (
          0 => 
          array (
            'id' => 3,
            'variant_id' => 2,
            'attribute_id' => 1,
            'attribute_value_id' => 1,
            'attribute_value' => 'Beige',
            'color_code' => '#f5f5dc',
            'attribute_name' => 'Color',
            'attribute_slug' => 'color',
            'attribute_type' => 'color',
          ),
          1 => 
          array (
            'id' => 4,
            'variant_id' => 2,
            'attribute_id' => 2,
            'attribute_value_id' => 8,
            'attribute_value' => 'M',
            'color_code' => NULL,
            'attribute_name' => 'Size',
            'attribute_slug' => 'size',
            'attribute_type' => 'multiple_select',
          ),
        ),
      ),
      2 => 
      array (
        'id' => 3,
        'product_id' => 1,
        'title' => 'V-neck Linen Summer Dress - Beige / L',
        'sku' => 'MOD-W-001-BG-L',
        'price' => '89.00',
        'sale_price' => '79.00',
        'stock_quantity' => 10,
        'max_purchase_quantity' => 5,
        'stock_status' => 'in_stock',
        'image' => 'products/womens/women-1.jpg',
        'gallery_images' => NULL,
        'highlights' => NULL,
        'specifications' => NULL,
        'created_at' => '2026-09-07 13:04:48',
        'updated_at' => '2026-09-07 13:04:48',
        'values' => 
        array (
          0 => 
          array (
            'id' => 5,
            'variant_id' => 3,
            'attribute_id' => 1,
            'attribute_value_id' => 1,
            'attribute_value' => 'Beige',
            'color_code' => '#f5f5dc',
            'attribute_name' => 'Color',
            'attribute_slug' => 'color',
            'attribute_type' => 'color',
          ),
          1 => 
          array (
            'id' => 6,
            'variant_id' => 3,
            'attribute_id' => 2,
            'attribute_value_id' => 9,
            'attribute_value' => 'L',
            'color_code' => NULL,
            'attribute_name' => 'Size',
            'attribute_slug' => 'size',
            'attribute_type' => 'multiple_select',
          ),
        ),
      ),
      3 => 
      array (
        'id' => 4,
        'product_id' => 1,
        'title' => 'V-neck Linen Summer Dress - Black / S',
        'sku' => 'MOD-W-001-BK-S',
        'price' => '89.00',
        'sale_price' => NULL,
        'stock_quantity' => 12,
        'max_purchase_quantity' => 5,
        'stock_status' => 'in_stock',
        'image' => 'products/womens/women-1.jpg',
        'gallery_images' => NULL,
        'highlights' => NULL,
        'specifications' => NULL,
        'created_at' => '2026-09-07 13:04:48',
        'updated_at' => '2026-09-07 13:04:48',
        'values' => 
        array (
          0 => 
          array (
            'id' => 7,
            'variant_id' => 4,
            'attribute_id' => 1,
            'attribute_value_id' => 2,
            'attribute_value' => 'Black',
            'color_code' => '#000000',
            'attribute_name' => 'Color',
            'attribute_slug' => 'color',
            'attribute_type' => 'color',
          ),
          1 => 
          array (
            'id' => 8,
            'variant_id' => 4,
            'attribute_id' => 2,
            'attribute_value_id' => 7,
            'attribute_value' => 'S',
            'color_code' => NULL,
            'attribute_name' => 'Size',
            'attribute_slug' => 'size',
            'attribute_type' => 'multiple_select',
          ),
        ),
      ),
      4 => 
      array (
        'id' => 5,
        'product_id' => 1,
        'title' => 'V-neck Linen Summer Dress - Black / M',
        'sku' => 'MOD-W-001-BK-M',
        'price' => '89.00',
        'sale_price' => NULL,
        'stock_quantity' => 18,
        'max_purchase_quantity' => 5,
        'stock_status' => 'in_stock',
        'image' => 'products/womens/women-1.jpg',
        'gallery_images' => NULL,
        'highlights' => NULL,
        'specifications' => NULL,
        'created_at' => '2026-09-07 13:04:49',
        'updated_at' => '2026-09-07 13:04:49',
        'values' => 
        array (
          0 => 
          array (
            'id' => 9,
            'variant_id' => 5,
            'attribute_id' => 1,
            'attribute_value_id' => 2,
            'attribute_value' => 'Black',
            'color_code' => '#000000',
            'attribute_name' => 'Color',
            'attribute_slug' => 'color',
            'attribute_type' => 'color',
          ),
          1 => 
          array (
            'id' => 10,
            'variant_id' => 5,
            'attribute_id' => 2,
            'attribute_value_id' => 8,
            'attribute_value' => 'M',
            'color_code' => NULL,
            'attribute_name' => 'Size',
            'attribute_slug' => 'size',
            'attribute_type' => 'multiple_select',
          ),
        ),
      ),
    ),
    'color_swatches' => 
    array (
      0 => 
      array (
        'name' => 'Beige',
        'value' => 'Beige',
        'color_code' => '#f5f5dc',
        'image' => 'products/womens/women-1.jpg',
      ),
      1 => 
      array (
        'name' => 'Black',
        'value' => 'Black',
        'color_code' => '#000000',
        'image' => 'products/womens/women-1.jpg',
      ),
    ),
    'attributes' => 
    array (
      'color' => 
      array (
        'name' => 'Color',
        'slug' => 'color',
        'type' => 'color',
        'values' => 
        array (
          0 => 
          array (
            'id' => 1,
            'value' => 'Beige',
            'color_code' => '#f5f5dc',
          ),
          1 => 
          array (
            'id' => 2,
            'value' => 'Black',
            'color_code' => '#000000',
          ),
        ),
      ),
      'size' => 
      array (
        'name' => 'Size',
        'slug' => 'size',
        'type' => 'multiple_select',
        'values' => 
        array (
          0 => 
          array (
            'id' => 7,
            'value' => 'S',
            'color_code' => NULL,
          ),
          1 => 
          array (
            'id' => 8,
            'value' => 'M',
            'color_code' => NULL,
          ),
          2 => 
          array (
            'id' => 9,
            'value' => 'L',
            'color_code' => NULL,
          ),
        ),
      ),
    ),
    'specifications' => 
    array (
      0 => 
      array (
        'id' => 12,
        'product_id' => 1,
        'spec_name' => 'Pack of',
        'spec_value' => '1',
        'sort_order' => 1,
        'created_at' => '2026-09-12 20:11:25',
      ),
      1 => 
      array (
        'id' => 13,
        'product_id' => 1,
        'spec_name' => 'Style Code',
        'spec_value' => 'FR ST2',
        'sort_order' => 2,
        'created_at' => '2026-09-12 20:11:25',
      ),
      2 => 
      array (
        'id' => 14,
        'product_id' => 1,
        'spec_name' => 'Closure',
        'spec_value' => 'Button',
        'sort_order' => 3,
        'created_at' => '2026-09-12 20:11:25',
      ),
      3 => 
      array (
        'id' => 15,
        'product_id' => 1,
        'spec_name' => 'Fit',
        'spec_value' => 'Regular',
        'sort_order' => 4,
        'created_at' => '2026-09-12 20:11:25',
      ),
      4 => 
      array (
        'id' => 16,
        'product_id' => 1,
        'spec_name' => 'Fabric',
        'spec_value' => 'Cotton Blend',
        'sort_order' => 5,
        'created_at' => '2026-09-12 20:11:25',
      ),
      5 => 
      array (
        'id' => 17,
        'product_id' => 1,
        'spec_name' => 'Sleeve',
        'spec_value' => 'Full Sleeve',
        'sort_order' => 6,
        'created_at' => '2026-09-12 20:11:25',
      ),
      6 => 
      array (
        'id' => 18,
        'product_id' => 1,
        'spec_name' => 'Pattern',
        'spec_value' => 'Solid',
        'sort_order' => 7,
        'created_at' => '2026-09-12 20:11:25',
      ),
      7 => 
      array (
        'id' => 19,
        'product_id' => 1,
        'spec_name' => 'Reversible',
        'spec_value' => 'No',
        'sort_order' => 8,
        'created_at' => '2026-09-12 20:11:25',
      ),
      8 => 
      array (
        'id' => 20,
        'product_id' => 1,
        'spec_name' => 'Collar',
        'spec_value' => 'Spread',
        'sort_order' => 9,
        'created_at' => '2026-09-12 20:11:25',
      ),
      9 => 
      array (
        'id' => 21,
        'product_id' => 1,
        'spec_name' => 'Suitable For',
        'spec_value' => 'Western Wear',
        'sort_order' => 10,
        'created_at' => '2026-09-12 20:11:25',
      ),
      10 => 
      array (
        'id' => 22,
        'product_id' => 1,
        'spec_name' => 'Type',
        'spec_value' => 'Shirt Dress',
        'sort_order' => 11,
        'created_at' => '2026-09-12 20:11:25',
      ),
      11 => 
      array (
        'id' => 23,
        'product_id' => 1,
        'spec_name' => 'Occasion',
        'spec_value' => 'Casual',
        'sort_order' => 12,
        'created_at' => '2026-09-12 20:11:25',
      ),
      12 => 
      array (
        'id' => 24,
        'product_id' => 1,
        'spec_name' => 'Fabric Care',
        'spec_value' => 'Gentle Machine Wash',
        'sort_order' => 13,
        'created_at' => '2026-09-12 20:11:25',
      ),
      13 => 
      array (
        'id' => 25,
        'product_id' => 1,
        'spec_name' => 'Hemline',
        'spec_value' => 'Curved',
        'sort_order' => 14,
        'created_at' => '2026-09-12 20:11:25',
      ),
      14 => 
      array (
        'id' => 26,
        'product_id' => 1,
        'spec_name' => 'Country of Origin',
        'spec_value' => 'India',
        'sort_order' => 15,
        'created_at' => '2026-09-12 20:11:25',
      ),
    ),
    'reviews' => 
    array (
      0 => 
      array (
        'id' => 1,
        'product_id' => 1,
        'user_id' => 1,
        'order_number' => NULL,
        'customer_name' => 'John Doe',
        'customer_email' => 'john@example.com',
        'rating' => 5,
        'title' => NULL,
        'review' => 'Outstanding fabric quality, looks even better in person. Delivery was quick!',
        'images' => NULL,
        'status' => 'approved',
        'created_at' => '2026-09-07 12:38:10',
      ),
    ),
  ),
  'filter_sizes' => 
  array (
    0 => 
    array (
      'id' => 1,
      'value' => 'S',
      'product_count' => 8,
    ),
    1 => 
    array (
      'id' => 2,
      'value' => 'M',
      'product_count' => 11,
    ),
    2 => 
    array (
      'id' => 3,
      'value' => 'L',
      'product_count' => 10,
    ),
    3 => 
    array (
      'id' => 4,
      'value' => 'XL',
      'product_count' => 7,
    ),
    4 => 
    array (
      'id' => 5,
      'value' => 'XXL',
      'product_count' => 4,
    ),
  ),
  'filter_colors' => 
  array (
    0 => 
    array (
      'id' => 10,
      'value' => 'Black',
      'color_code' => '#111111',
      'product_count' => 7,
    ),
    1 => 
    array (
      'id' => 11,
      'value' => 'White',
      'color_code' => '#ffffff',
      'product_count' => 6,
    ),
    2 => 
    array (
      'id' => 12,
      'value' => 'Navy Blue',
      'color_code' => '#1e3a8a',
      'product_count' => 5,
    ),
    3 => 
    array (
      'id' => 13,
      'value' => 'Olive Green',
      'color_code' => '#3f6212',
      'product_count' => 4,
    ),
    4 => 
    array (
      'id' => 14,
      'value' => 'Beige',
      'color_code' => '#d6d3d1',
      'product_count' => 5,
    ),
    5 => 
    array (
      'id' => 15,
      'value' => 'Crimson Red',
      'color_code' => '#b91c1c',
      'product_count' => 3,
    ),
  ),
  'user' => 
  array (
    'id' => 1,
    'first_name' => 'Alex',
    'last_name' => 'Morgan',
    'email' => 'alex.morgan@example.com',
    'phone' => '+91 98765 43210',
    'avatar' => '',
    'status' => 'active',
    'created_at' => '2026-09-01 10:00:00',
  ),
  'addresses' => 
  array (
    0 => 
    array (
      'id' => 1,
      'user_id' => 1,
      'type' => 'shipping',
      'first_name' => 'Alex',
      'last_name' => 'Morgan',
      'company' => 'HOME',
      'address_1' => 'Flat 402, Emerald Heights, Park Street',
      'address_2' => 'Near Metro Station',
      'landmark' => 'Opposite Central Plaza',
      'city' => 'Kolkata',
      'state' => 'West Bengal',
      'postcode' => '700016',
      'country' => 'India',
      'phone' => '9876543210',
      'alternate_phone' => '9123456780',
      'is_default' => 1,
    ),
    1 => 
    array (
      'id' => 2,
      'user_id' => 1,
      'type' => 'shipping',
      'first_name' => 'Alex',
      'last_name' => 'Morgan',
      'company' => 'WORK',
      'address_1' => 'Suite 8B, Technopolis IT Park, Sector V',
      'address_2' => 'Salt Lake City',
      'landmark' => 'Near Webel More',
      'city' => 'Kolkata',
      'state' => 'West Bengal',
      'postcode' => '700091',
      'country' => 'India',
      'phone' => '9876543210',
      'alternate_phone' => '',
      'is_default' => 0,
    ),
  ),
  'cart_items' => 
  array (
    1 => 
    array (
      'cart_key' => '1',
      'id' => 1,
      'product_id' => 1,
      'variant_id' => NULL,
      'title' => 'V-neck Linen Blend Summer Dress',
      'slug' => 'v-neck-linen-blend-summer-dress',
      'sku' => 'MOD-W-001',
      'image' => 'products/womens/women-1.jpg',
      'price' => 69.0,
      'regular_price' => 89.0,
      'unit_base_price' => 69.0,
      'unit_tax_amount' => 0.0,
      'tax_rate' => 0.0,
      'quantity' => 1,
      'stock_quantity' => 25,
      'max_qty' => 10,
      'variant_name' => 'Color: Black | Size: M',
      'color' => 'Black',
      'size' => 'M',
      'is_cod_allowed' => 1,
      'total' => 69.0,
      'mrp_total' => 89.0,
    ),
    2 => 
    array (
      'cart_key' => '2',
      'id' => 2,
      'product_id' => 2,
      'variant_id' => NULL,
      'title' => 'Belted Relaxed Trench Coat',
      'slug' => 'belted-relaxed-trench-coat',
      'sku' => 'MOD-W-002',
      'image' => 'products/womens/women-4.jpg',
      'price' => 149.0,
      'regular_price' => 175.0,
      'unit_base_price' => 149.0,
      'unit_tax_amount' => 0.0,
      'tax_rate' => 0.0,
      'quantity' => 1,
      'stock_quantity' => 18,
      'max_qty' => 10,
      'variant_name' => 'Color: White | Size: L',
      'color' => 'White',
      'size' => 'L',
      'is_cod_allowed' => 1,
      'total' => 149.0,
      'mrp_total' => 175.0,
    ),
  ),
  'cart_summary' => 
  array (
    'item_count' => 2,
    'mrp_total' => 264.0,
    'mrp_discount' => 46.0,
    'subtotal' => 218.0,
    'base_subtotal' => 218.0,
    'tax' => 0.0,
    'tax_inclusive' => true,
    'discount' => 0.0,
    'coupon_code' => '',
    'shipping' => 0.0,
    'shipping_method' => 'standard',
    'shipping_breakdown' => 
    array (
      0 => 
      array (
        'name' => 'Standard Delivery',
        'value' => 0,
      ),
    ),
    'free_shipping_min' => 499.0,
    'amount_to_free_ship' => 0.0,
    'free_ship_percent' => 100,
    'total' => 218.0,
    'total_savings' => 46.0,
  ),
  'common_order' => 
  array (
    'id' => 101,
    'order_number' => 'ORD-2026-88412',
    'user_id' => 1,
    'customer_name' => 'Alex Morgan',
    'customer_email' => 'alex.morgan@example.com',
    'customer_phone' => '9876543210',
    'address_type' => 'HOME',
    'shipping_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
    'billing_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
    'subtotal' => 218.0,
    'discount_amount' => 46.0,
    'shipping_fee' => 0.0,
    'shipping_amount' => 0.0,
    'tax_amount' => 0.0,
    'total_amount' => 218.0,
    'currency' => 'INR',
    'payment_method' => 'razorpay',
    'payment_status' => 'paid',
    'order_status' => 'delivered',
    'courier_name' => 'BlueDart Express',
    'tracking_number' => 'BD884920192IN',
    'tracking_url' => 'https://www.bluedart.com/tracking',
    'shipped_at' => '2026-09-15 11:30:00',
    'delivered_at' => '2026-09-18 16:45:00',
    'created_at' => '2026-09-14 09:15:00',
    'updated_at' => '2026-09-18 16:45:00',
    'items' => 
    array (
      0 => 
      array (
        'id' => 501,
        'order_id' => 101,
        'product_id' => 1,
        'product_title' => 'V-neck Linen Blend Summer Dress',
        'product_slug' => 'v-neck-linen-blend-summer-dress',
        'product_image' => 'products/womens/women-1.jpg',
        'sku' => 'MOD-W-001',
        'variant_title' => 'Color: Black | Size: M',
        'price' => 69.0,
        'regular_price' => 89.0,
        'quantity' => 1,
        'total' => 69.0,
        'item_status' => 'delivered',
        'courier_name' => 'BlueDart Express',
        'tracking_number' => 'BD884920192IN',
        'tracking_url' => 'https://www.bluedart.com/tracking',
        'shipped_at' => '2026-09-15 11:30:00',
        'delivered_at' => '2026-09-18 16:45:00',
      ),
      1 => 
      array (
        'id' => 502,
        'order_id' => 101,
        'product_id' => 2,
        'product_title' => 'Belted Relaxed Trench Coat',
        'product_slug' => 'belted-relaxed-trench-coat',
        'product_image' => 'products/womens/women-4.jpg',
        'sku' => 'MOD-W-002',
        'variant_title' => 'Color: White | Size: L',
        'price' => 149.0,
        'regular_price' => 175.0,
        'quantity' => 1,
        'total' => 149.0,
        'item_status' => 'delivered',
        'courier_name' => 'BlueDart Express',
        'tracking_number' => 'BD884920192IN',
        'tracking_url' => 'https://www.bluedart.com/tracking',
        'shipped_at' => '2026-09-15 11:30:00',
        'delivered_at' => '2026-09-18 16:45:00',
      ),
    ),
  ),
  'orders' => 
  array (
    0 => 
    array (
      'id' => 101,
      'order_number' => 'ORD-2026-88412',
      'user_id' => 1,
      'customer_name' => 'Alex Morgan',
      'customer_email' => 'alex.morgan@example.com',
      'customer_phone' => '9876543210',
      'address_type' => 'HOME',
      'shipping_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
      'billing_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
      'subtotal' => 218.0,
      'discount_amount' => 46.0,
      'shipping_fee' => 0.0,
      'shipping_amount' => 0.0,
      'tax_amount' => 0.0,
      'total_amount' => 218.0,
      'currency' => 'INR',
      'payment_method' => 'razorpay',
      'payment_status' => 'paid',
      'order_status' => 'delivered',
      'courier_name' => 'BlueDart Express',
      'tracking_number' => 'BD884920192IN',
      'tracking_url' => 'https://www.bluedart.com/tracking',
      'shipped_at' => '2026-09-15 11:30:00',
      'delivered_at' => '2026-09-18 16:45:00',
      'created_at' => '2026-09-14 09:15:00',
      'updated_at' => '2026-09-18 16:45:00',
      'items' => 
      array (
        0 => 
        array (
          'id' => 501,
          'order_id' => 101,
          'product_id' => 1,
          'product_title' => 'V-neck Linen Blend Summer Dress',
          'product_slug' => 'v-neck-linen-blend-summer-dress',
          'product_image' => 'products/womens/women-1.jpg',
          'sku' => 'MOD-W-001',
          'variant_title' => 'Color: Black | Size: M',
          'price' => 69.0,
          'regular_price' => 89.0,
          'quantity' => 1,
          'total' => 69.0,
          'item_status' => 'delivered',
          'courier_name' => 'BlueDart Express',
          'tracking_number' => 'BD884920192IN',
          'tracking_url' => 'https://www.bluedart.com/tracking',
          'shipped_at' => '2026-09-15 11:30:00',
          'delivered_at' => '2026-09-18 16:45:00',
        ),
        1 => 
        array (
          'id' => 502,
          'order_id' => 101,
          'product_id' => 2,
          'product_title' => 'Belted Relaxed Trench Coat',
          'product_slug' => 'belted-relaxed-trench-coat',
          'product_image' => 'products/womens/women-4.jpg',
          'sku' => 'MOD-W-002',
          'variant_title' => 'Color: White | Size: L',
          'price' => 149.0,
          'regular_price' => 175.0,
          'quantity' => 1,
          'total' => 149.0,
          'item_status' => 'delivered',
          'courier_name' => 'BlueDart Express',
          'tracking_number' => 'BD884920192IN',
          'tracking_url' => 'https://www.bluedart.com/tracking',
          'shipped_at' => '2026-09-15 11:30:00',
          'delivered_at' => '2026-09-18 16:45:00',
        ),
      ),
    ),
    1 => 
    array (
      'id' => 102,
      'order_number' => 'ORD-2026-77319',
      'user_id' => 1,
      'customer_name' => 'Alex Morgan',
      'customer_email' => 'alex.morgan@example.com',
      'customer_phone' => '9876543210',
      'address_type' => 'HOME',
      'shipping_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
      'billing_address' => 'Alex Morgan (HOME)
Flat 402, Emerald Heights, Park Street
Kolkata, West Bengal 700016
India
Phone: 9876543210',
      'subtotal' => 218.0,
      'discount_amount' => 46.0,
      'shipping_fee' => 0.0,
      'shipping_amount' => 0.0,
      'tax_amount' => 0.0,
      'total_amount' => 218.0,
      'currency' => 'INR',
      'payment_method' => 'razorpay',
      'payment_status' => 'paid',
      'order_status' => 'shipped',
      'courier_name' => 'BlueDart Express',
      'tracking_number' => 'BD884920192IN',
      'tracking_url' => 'https://www.bluedart.com/tracking',
      'shipped_at' => '2026-09-15 11:30:00',
      'delivered_at' => '2026-09-18 16:45:00',
      'created_at' => '2026-09-20 14:10:00',
      'updated_at' => '2026-09-21 10:00:00',
      'items' => 
      array (
        0 => 
        array (
          'id' => 501,
          'order_id' => 101,
          'product_id' => 1,
          'product_title' => 'V-neck Linen Blend Summer Dress',
          'product_slug' => 'v-neck-linen-blend-summer-dress',
          'product_image' => 'products/womens/women-1.jpg',
          'sku' => 'MOD-W-001',
          'variant_title' => 'Color: Black | Size: M',
          'price' => 69.0,
          'regular_price' => 89.0,
          'quantity' => 1,
          'total' => 69.0,
          'item_status' => 'delivered',
          'courier_name' => 'BlueDart Express',
          'tracking_number' => 'BD884920192IN',
          'tracking_url' => 'https://www.bluedart.com/tracking',
          'shipped_at' => '2026-09-15 11:30:00',
          'delivered_at' => '2026-09-18 16:45:00',
        ),
        1 => 
        array (
          'id' => 502,
          'order_id' => 101,
          'product_id' => 2,
          'product_title' => 'Belted Relaxed Trench Coat',
          'product_slug' => 'belted-relaxed-trench-coat',
          'product_image' => 'products/womens/women-4.jpg',
          'sku' => 'MOD-W-002',
          'variant_title' => 'Color: White | Size: L',
          'price' => 149.0,
          'regular_price' => 175.0,
          'quantity' => 1,
          'total' => 149.0,
          'item_status' => 'delivered',
          'courier_name' => 'BlueDart Express',
          'tracking_number' => 'BD884920192IN',
          'tracking_url' => 'https://www.bluedart.com/tracking',
          'shipped_at' => '2026-09-15 11:30:00',
          'delivered_at' => '2026-09-18 16:45:00',
        ),
      ),
    ),
  ),
  'notifications' => 
  array (
    0 => 
    array (
      'id' => 1,
      'user_id' => 1,
      'title' => 'Order Delivered Successfully',
      'message' => 'Your order #ORD-2026-88412 has been delivered. Thank you for shopping with us!',
      'type' => 'order',
      'is_read' => 1,
      'created_at' => '2026-09-18 16:45:00',
    ),
    1 => 
    array (
      'id' => 2,
      'user_id' => 1,
      'title' => 'Season Finale Sale is Live!',
      'message' => 'Enjoy up to 40% off on our new Autumn/Winter Fashion Collection.',
      'type' => 'promo',
      'is_read' => 0,
      'created_at' => '2026-09-20 09:00:00',
    ),
  ),
  'gateways' => 
  array (
    0 => 
    array (
      'gateway_code' => 'razorpay',
      'gateway_name' => 'Razorpay (UPI, Cards, NetBanking)',
      'is_active' => 1,
    ),
    1 => 
    array (
      'gateway_code' => 'stripe',
      'gateway_name' => 'Stripe (Credit / Debit Card)',
      'is_active' => 1,
    ),
    2 => 
    array (
      'gateway_code' => 'cod',
      'gateway_name' => 'Cash on Delivery (COD)',
      'is_active' => 1,
    ),
  ),
);
        }
        return $data;
    }

    public static function get($key, $default = null) {
        $all = self::get_all();
        return $all[$key] ?? $default;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create gallery directory if it doesn't exist
        if (!Storage::disk('public')->exists('gallery')) {
            Storage::disk('public')->makeDirectory('gallery');
        }

        // Define gallery images with categories and descriptions
        $galleryData = [
            // Elevator Cladding Projects
            [
                'title' => 'Modern Elevator Cladding - Haram Makkah',
                'description' => 'Stainless steel cladding for elevator cabins in the prestigious Haram Makkah project, showcasing our precision in religious site installations.',
                'image' => 'img15.jpg',
                'category' => 'elevator',
                'sort_order' => 1
            ],
            [
                'title' => 'Luxury Elevator Interior - Clock Tower Makkah',
                'description' => 'Premium stainless steel elevator cladding for the iconic Clock Tower Makkah, featuring intricate design elements.',
                'image' => 'img49.jpg',
                'category' => 'elevator',
                'sort_order' => 2
            ],
            [
                'title' => 'Commercial Building Elevator - Jeddah',
                'description' => 'Modern elevator cladding installation for commercial buildings in Jeddah, demonstrating our versatility in urban projects.',
                'image' => 'img52.jpg',
                'category' => 'elevator',
                'sort_order' => 3
            ],
            [
                'title' => 'Hospital Elevator Cladding - King Fahad Hospital',
                'description' => 'Medical-grade stainless steel cladding for hospital elevators, ensuring hygiene and durability in healthcare environments.',
                'image' => 'img53.jpg',
                'category' => 'elevator',
                'sort_order' => 4
            ],
            [
                'title' => 'University Campus Elevator - KAUST',
                'description' => 'Contemporary elevator cladding for King Abdullah University of Science and Technology, blending functionality with modern aesthetics.',
                'image' => 'img54.jpg',
                'category' => 'elevator',
                'sort_order' => 5
            ],

            // Escalator Cladding Projects
            [
                'title' => 'Shopping Mall Escalator - Star Avenue Jeddah',
                'description' => 'High-traffic escalator cladding for Star Avenue shopping mall, designed to withstand heavy daily usage.',
                'image' => 'img55.jpg',
                'category' => 'escalator',
                'sort_order' => 6
            ],
            [
                'title' => 'Airport Escalator Cladding - Tabuk Airport',
                'description' => 'Durable escalator cladding for Tabuk Airport, meeting international aviation standards and safety requirements.',
                'image' => 'img56.jpg',
                'category' => 'escalator',
                'sort_order' => 7
            ],
            [
                'title' => 'Metro Station Escalator - Riyadh Metro',
                'description' => 'Modern escalator cladding for Riyadh Metro stations, contributing to the city\'s public transportation infrastructure.',
                'image' => 'img57.jpg',
                'category' => 'escalator',
                'sort_order' => 8
            ],
            [
                'title' => 'Hospital Escalator - Saudi German Hospital',
                'description' => 'Medical facility escalator cladding ensuring smooth patient and visitor flow in healthcare environments.',
                'image' => 'img58.jpg',
                'category' => 'escalator',
                'sort_order' => 9
            ],

            // Steel Structures Projects
            [
                'title' => 'Industrial Steel Framework - KAUST',
                'description' => 'Heavy-duty steel structures for KAUST research facilities, engineered for maximum strength and durability.',
                'image' => 'img59.jpg',
                'category' => 'steel',
                'sort_order' => 10
            ],
            [
                'title' => 'Commercial Building Steel Work - Jabal Omar',
                'description' => 'Comprehensive steel fabrication for Jabal Omar commercial complex, including beams, columns, and support structures.',
                'image' => 'img60.jpg',
                'category' => 'steel',
                'sort_order' => 11
            ],
            [
                'title' => 'Warehouse Steel Structure - Alshaya Warehouse',
                'description' => 'Large-scale steel structure for Alshaya warehouse facility, designed for industrial storage and logistics operations.',
                'image' => 'img63.jpg',
                'category' => 'steel',
                'sort_order' => 12
            ],
            [
                'title' => 'Office Building Steel Framework - Riyadh',
                'description' => 'Modern office building steel framework in Riyadh, showcasing our expertise in commercial construction.',
                'image' => 'img64.jpg',
                'category' => 'steel',
                'sort_order' => 13
            ],
            [
                'title' => 'Shopping Mall Steel Structure - Panorama Mall',
                'description' => 'Complex steel structure for Panorama Mall, supporting multiple floors and heavy retail loads.',
                'image' => 'img65.jpg',
                'category' => 'steel',
                'sort_order' => 14
            ],

            // Water Tanks Projects
            [
                'title' => 'Industrial Water Tank - Tabuk',
                'description' => 'Large-capacity stainless steel water tank for industrial use in Tabuk, ensuring reliable water storage.',
                'image' => 'img67.jpg',
                'category' => 'water',
                'sort_order' => 15
            ],
            [
                'title' => 'Hospital Water Storage - King Saud University',
                'description' => 'Medical-grade water storage tank for King Saud University Hospital, meeting healthcare water quality standards.',
                'image' => 'img72.jpg',
                'category' => 'water',
                'sort_order' => 16
            ],
            [
                'title' => 'Commercial Water Tank - Jeddah',
                'description' => 'Custom-designed water tank for commercial building in Jeddah, optimized for space and efficiency.',
                'image' => 'img73.jpg',
                'category' => 'water',
                'sort_order' => 17
            ],
            [
                'title' => 'Industrial Water Storage - Power Plant',
                'description' => 'Heavy-duty water storage system for power plant operations, designed for continuous industrial use.',
                'image' => 'img74.jpg',
                'category' => 'water',
                'sort_order' => 18
            ],

            // Custom Fabrication Projects
            [
                'title' => 'Custom Handrails - Staircase Installation',
                'description' => 'Elegant stainless steel handrails for staircase installations, combining safety with aesthetic appeal.',
                'image' => 'img75.jpg',
                'category' => 'custom',
                'sort_order' => 19
            ],
            [
                'title' => 'Sliding Gates - Warehouse Security',
                'description' => 'Heavy-duty sliding gates for warehouse security, engineered for durability and smooth operation.',
                'image' => 'img76.jpg',
                'category' => 'custom',
                'sort_order' => 20
            ],
            [
                'title' => 'Cage Ladders - Industrial Access',
                'description' => 'Safety cage ladders for industrial facilities, providing secure access to elevated areas.',
                'image' => 'img77.jpg',
                'category' => 'custom',
                'sort_order' => 21
            ],
            [
                'title' => 'Sandwich Panel Doors - Commercial',
                'description' => 'Insulated sandwich panel doors for commercial buildings, offering energy efficiency and durability.',
                'image' => 'img80.jpg',
                'category' => 'custom',
                'sort_order' => 22
            ],
            [
                'title' => 'Custom Brackets - Elevator Shaft',
                'description' => 'Precision-engineered brackets for elevator shaft installations, ensuring structural integrity.',
                'image' => 'img81.jpg',
                'category' => 'custom',
                'sort_order' => 23
            ],

            // Industrial Projects
            [
                'title' => 'Power Plant Steel Work - Shoiba',
                'description' => 'Comprehensive steel fabrication for Shoiba Power Plant, supporting critical infrastructure development.',
                'image' => 'img82.jpg',
                'category' => 'industrial',
                'sort_order' => 24
            ],
            [
                'title' => 'Cement Factory Installation - Rabigh',
                'description' => 'Heavy industrial steel work for cement factory in Rabigh, designed for harsh industrial environments.',
                'image' => 'img83.jpg',
                'category' => 'industrial',
                'sort_order' => 25
            ],
            [
                'title' => 'Gold Mining Facility - Maaden',
                'description' => 'Specialized steel structures for Maaden gold mining facility, meeting stringent industrial safety standards.',
                'image' => 'img84.jpg',
                'category' => 'industrial',
                'sort_order' => 26
            ],
            [
                'title' => 'Port Infrastructure - Jeddah Islamic Port',
                'description' => 'Marine-grade steel structures for Jeddah Islamic Port, engineered for coastal environment durability.',
                'image' => 'img85.jpg',
                'category' => 'industrial',
                'sort_order' => 27
            ],
            [
                'title' => 'Oil Refinery Steel Work - Yanbu',
                'description' => 'High-specification steel fabrication for oil refinery operations, ensuring safety and reliability.',
                'image' => 'img88.jpg',
                'category' => 'industrial',
                'sort_order' => 28
            ],

            // Additional Premium Projects
            [
                'title' => 'Luxury Hotel Elevator - Hilton Madinah',
                'description' => 'Premium elevator cladding for Hilton Hotel Madinah, reflecting luxury hospitality standards.',
                'image' => 'img89.jpg',
                'category' => 'elevator',
                'sort_order' => 29
            ],
            [
                'title' => 'Shopping Complex Escalator - Lulu Harmain',
                'description' => 'High-end escalator cladding for Lulu Harmain shopping complex, enhancing customer experience.',
                'image' => 'img90.jpg',
                'category' => 'escalator',
                'sort_order' => 30
            ],
            [
                'title' => 'University Steel Structure - King Saud University',
                'description' => 'Academic building steel framework for King Saud University, supporting educational infrastructure.',
                'image' => 'img91.jpg',
                'category' => 'steel',
                'sort_order' => 31
            ],
            [
                'title' => 'Hospital Water System - Imam University',
                'description' => 'Complete water storage system for Imam University Hospital, ensuring reliable medical facility operations.',
                'image' => 'img92.jpg',
                'category' => 'water',
                'sort_order' => 32
            ],
            [
                'title' => 'Custom Security Gates - KAEC',
                'description' => 'Advanced security gate systems for King Abdullah Economic City, providing enhanced protection.',
                'image' => 'img93.jpg',
                'category' => 'custom',
                'sort_order' => 33
            ],
            [
                'title' => 'Industrial Complex - KAFD Riyadh',
                'description' => 'Large-scale industrial steel work for King Abdullah Financial District, supporting financial infrastructure.',
                'image' => 'img94.jpg',
                'category' => 'industrial',
                'sort_order' => 34
            ],
            [
                'title' => 'Modern Elevator Design - Princess Wanood',
                'description' => 'Contemporary elevator cladding for Princess Wanood project, showcasing modern architectural integration.',
                'image' => 'img95.jpg',
                'category' => 'elevator',
                'sort_order' => 35
            ],
            [
                'title' => 'Mall Escalator System - Hayat Mall',
                'description' => 'Comprehensive escalator cladding system for Hayat Mall Riyadh, handling high customer traffic.',
                'image' => 'img98.jpg',
                'category' => 'escalator',
                'sort_order' => 36
            ],
            [
                'title' => 'Office Complex Steel Work - Undlas Mall',
                'description' => 'Modern office complex steel framework for Undlas Mall Jeddah, supporting commercial operations.',
                'image' => 'img99.jpg',
                'category' => 'steel',
                'sort_order' => 37
            ],
            [
                'title' => 'Industrial Water Treatment - Shuqaiq',
                'description' => 'Specialized water treatment facility steel work in Shuqaiq, supporting industrial water management.',
                'image' => 'img102.jpg',
                'category' => 'water',
                'sort_order' => 38
            ],

            // Additional Elevator Projects
            [
                'title' => 'High-Rise Elevator Cladding - Talal Tower',
                'description' => 'Premium elevator cladding for Talal Tower Makkah, featuring modern design elements for high-rise applications.',
                'image' => 'img103.jpg',
                'category' => 'elevator',
                'sort_order' => 39
            ],
            [
                'title' => 'Residential Elevator - Jeddah Park',
                'description' => 'Elegant residential elevator cladding for Jeddah Park development, combining functionality with aesthetic appeal.',
                'image' => 'img104.jpg',
                'category' => 'elevator',
                'sort_order' => 40
            ],
            [
                'title' => 'Office Building Elevator - Samba Tower',
                'description' => 'Professional elevator cladding for Samba Tower Jeddah, meeting corporate building standards.',
                'image' => 'img112.jpg',
                'category' => 'elevator',
                'sort_order' => 41
            ],
            [
                'title' => 'Shopping Center Elevator - Zahra Mall',
                'description' => 'Commercial elevator cladding for Zahra Mall Jeddah, designed for high-traffic retail environments.',
                'image' => 'img113.jpg',
                'category' => 'elevator',
                'sort_order' => 42
            ],
            [
                'title' => 'Cultural Center Elevator - Cultural Square',
                'description' => 'Artistic elevator cladding for Cultural Square Jeddah, reflecting cultural and architectural heritage.',
                'image' => 'img114.jpg',
                'category' => 'elevator',
                'sort_order' => 43
            ],

            // Additional Escalator Projects
            [
                'title' => 'Mall Escalator System - Al Rashid Mall',
                'description' => 'Comprehensive escalator cladding system for Al Rashid Mall Jizan, handling customer traffic efficiently.',
                'image' => 'img115.jpg',
                'category' => 'escalator',
                'sort_order' => 44
            ],
            [
                'title' => 'Airport Escalator - Jizan Airport',
                'description' => 'Durable escalator cladding for Jizan Airport, meeting international aviation infrastructure standards.',
                'image' => 'img116.jpg',
                'category' => 'escalator',
                'sort_order' => 45
            ],
            [
                'title' => 'Hospital Escalator - Asfan Medical Village',
                'description' => 'Medical facility escalator cladding for Asfan Medical Village Riyadh, ensuring smooth patient flow.',
                'image' => 'img118.jpg',
                'category' => 'escalator',
                'sort_order' => 46
            ],
            [
                'title' => 'Shopping Complex Escalator - Nabila Qutab',
                'description' => 'Modern escalator cladding for Nabila Qutab Jeddah, enhancing shopping experience with sleek design.',
                'image' => 'img122.jpg',
                'category' => 'escalator',
                'sort_order' => 47
            ],

            // Additional Steel Structure Projects
            [
                'title' => 'University Steel Framework - King Saud University',
                'description' => 'Academic building steel framework for King Saud University Riyadh, supporting educational infrastructure development.',
                'image' => 'img123.jpg',
                'category' => 'steel',
                'sort_order' => 48
            ],
            [
                'title' => 'Bank Building Steel Work - Sama Bank',
                'description' => 'Financial institution steel work for Sama Bank Abha, ensuring structural integrity for banking operations.',
                'image' => 'img124.jpg',
                'category' => 'steel',
                'sort_order' => 49
            ],
            [
                'title' => 'Research Center Steel Structure - KAUST',
                'description' => 'Advanced research facility steel structure for KAUST Thuwal, supporting cutting-edge scientific research.',
                'image' => 'img125.jpg',
                'category' => 'steel',
                'sort_order' => 50
            ],
            [
                'title' => 'Government Building Steel Work - Ministry of Hajj',
                'description' => 'Government facility steel work for Ministry of Hajj Makkah, supporting administrative operations.',
                'image' => 'img126.jpg',
                'category' => 'steel',
                'sort_order' => 51
            ],
            [
                'title' => 'Commercial Complex Steel - Al Mantazah',
                'description' => 'Commercial building steel work for Al Mantazah Jeddah, supporting business and retail operations.',
                'image' => 'img128.jpg',
                'category' => 'steel',
                'sort_order' => 52
            ],

            // Additional Water Tank Projects
            [
                'title' => 'Municipal Water Storage - Madinah',
                'description' => 'Large-scale municipal water storage tank for Madinah, supporting city water infrastructure.',
                'image' => 'img130.jpg',
                'category' => 'water',
                'sort_order' => 53
            ],
            [
                'title' => 'Industrial Water Tank - Arabian Cement',
                'description' => 'Heavy-duty water storage for Arabian Cement Factory Rabigh, supporting industrial operations.',
                'image' => 'img132.jpg',
                'category' => 'water',
                'sort_order' => 54
            ],
            [
                'title' => 'Hospital Water System - Hera General Hospital',
                'description' => 'Medical facility water storage system for Hera General Hospital Makkah, ensuring reliable healthcare operations.',
                'image' => 'img136.jpg',
                'category' => 'water',
                'sort_order' => 55
            ],
            [
                'title' => 'Commercial Water Storage - Fifa Mall',
                'description' => 'Shopping mall water storage system for Fifa Mall Jeddah, supporting commercial operations.',
                'image' => 'img137.jpg',
                'category' => 'water',
                'sort_order' => 56
            ],

            // Additional Custom Fabrication Projects
            [
                'title' => 'Custom Staircase Handrails - SWCC',
                'description' => 'Elegant stainless steel handrails for SWCC Shoiba facility, combining safety with modern design.',
                'image' => 'img138.jpg',
                'category' => 'custom',
                'sort_order' => 57
            ],
            [
                'title' => 'Security Gates - Formula 1 Jeddah',
                'description' => 'High-security gate systems for Formula 1 Jeddah circuit, providing enhanced protection for events.',
                'image' => 'img139.jpg',
                'category' => 'custom',
                'sort_order' => 58
            ],
            [
                'title' => 'Custom Ladders - Haram Car Parking',
                'description' => 'Specialized access ladders for Haram Car Parking Madinah, ensuring safe maintenance access.',
                'image' => 'img140.jpg',
                'category' => 'custom',
                'sort_order' => 59
            ],
            [
                'title' => 'Industrial Doors - KAAU Jeddah',
                'description' => 'Heavy-duty industrial doors for KAAU Jeddah, designed for educational facility requirements.',
                'image' => 'img141.jpg',
                'category' => 'custom',
                'sort_order' => 60
            ],
            [
                'title' => 'Custom Brackets - Murjan Tower',
                'description' => 'Precision-engineered brackets for Murjan Tower Makkah, ensuring structural support and stability.',
                'image' => 'img142.jpg',
                'category' => 'custom',
                'sort_order' => 61
            ],

            // Additional Industrial Projects
            [
                'title' => 'Power Plant Infrastructure - Shoiba',
                'description' => 'Comprehensive steel infrastructure for Shoiba Power Plant, supporting critical energy generation.',
                'image' => 'img143.jpg',
                'category' => 'industrial',
                'sort_order' => 62
            ],
            [
                'title' => 'Mining Facility Steel Work - Maaden',
                'description' => 'Specialized steel work for Maaden Gold Company, meeting mining industry safety standards.',
                'image' => 'img146.jpg',
                'category' => 'industrial',
                'sort_order' => 63
            ],
            [
                'title' => 'Cement Plant Installation - Arabian Cement',
                'description' => 'Heavy industrial installation for Arabian Cement Factory Rabigh, supporting manufacturing operations.',
                'image' => 'img147.jpg',
                'category' => 'industrial',
                'sort_order' => 64
            ],
            [
                'title' => 'Port Steel Structure - Jeddah Islamic Port',
                'description' => 'Marine infrastructure steel work for Jeddah Islamic Port, engineered for coastal durability.',
                'image' => 'img148.jpg',
                'category' => 'industrial',
                'sort_order' => 65
            ],
            [
                'title' => 'Industrial Complex - KAFD',
                'description' => 'Large-scale industrial steel work for King Abdullah Financial District Riyadh, supporting financial infrastructure.',
                'image' => 'img150.jpg',
                'category' => 'industrial',
                'sort_order' => 66
            ],

            // Premium Projects Showcase
            [
                'title' => 'Luxury Hotel Elevator - Habitat Hotel',
                'description' => 'Premium elevator cladding for Habitat Hotel and Furniture, reflecting luxury hospitality standards.',
                'image' => 'img152.jpg',
                'category' => 'elevator',
                'sort_order' => 67
            ],
            [
                'title' => 'Shopping Mall Escalator - Green Mall',
                'description' => 'Modern escalator cladding for Green Mall Dammam, enhancing customer shopping experience.',
                'image' => 'img153.jpg',
                'category' => 'escalator',
                'sort_order' => 68
            ],
            [
                'title' => 'Office Complex Steel - Hassan Mall',
                'description' => 'Commercial office complex steel work for Hassan Mall Madinah, supporting business operations.',
                'image' => 'img156.jpg',
                'category' => 'steel',
                'sort_order' => 69
            ],
            [
                'title' => 'Hospital Water System - DP World',
                'description' => 'Advanced water storage system for DP World facility, ensuring reliable logistics operations.',
                'image' => 'img157.jpg',
                'category' => 'water',
                'sort_order' => 70
            ],
            [
                'title' => 'Custom Security System - IBS',
                'description' => 'Advanced security gate systems for International Building System Co., providing enhanced protection.',
                'image' => 'img158.jpg',
                'category' => 'custom',
                'sort_order' => 71
            ],
            [
                'title' => 'Industrial Facility - El Seif Engineering',
                'description' => 'Comprehensive industrial steel work for El Seif Engineering Co., supporting construction operations.',
                'image' => 'img159.jpg',
                'category' => 'industrial',
                'sort_order' => 72
            ],

            // Additional Showcase Projects
            [
                'title' => 'Modern Elevator Design - Al Otair Tower',
                'description' => 'Contemporary elevator cladding for Al Otair Tower Makkah and Madinah, showcasing modern architectural integration.',
                'image' => 'img160.jpg',
                'category' => 'elevator',
                'sort_order' => 73
            ],
            [
                'title' => 'Mall Escalator System - Haram Gallery',
                'description' => 'Comprehensive escalator cladding system for Haram Gallery Riyadh, handling high customer traffic.',
                'image' => 'img161.jpg',
                'category' => 'escalator',
                'sort_order' => 74
            ],
            [
                'title' => 'University Steel Structure - Imam University',
                'description' => 'Academic building steel framework for Imam University Riyadh, supporting educational infrastructure.',
                'image' => 'img164.jpg',
                'category' => 'steel',
                'sort_order' => 75
            ],
            [
                'title' => 'Industrial Water Treatment - CEMCCO',
                'description' => 'Specialized water treatment facility for CEMCCO, supporting industrial water management systems.',
                'image' => 'img165.jpg',
                'category' => 'water',
                'sort_order' => 76
            ],
            [
                'title' => 'Custom Fabrication - Al Otair Trading',
                'description' => 'Specialized custom fabrication work for Al Otair Trading & Industrial Group, meeting diverse industrial needs.',
                'image' => 'img166.jpg',
                'category' => 'custom',
                'sort_order' => 77
            ],
            [
                'title' => 'Industrial Complex - Al Suwaidi',
                'description' => 'Large-scale industrial steel work for Al Suwaidi Industrial Co., supporting manufacturing operations.',
                'image' => 'img167.jpg',
                'category' => 'industrial',
                'sort_order' => 78
            ],

            // Final Showcase Projects
            [
                'title' => 'Premium Elevator - Jamjoom Pharmaceutical',
                'description' => 'High-specification elevator cladding for Jamjoom Pharmaceutical Co., meeting pharmaceutical industry standards.',
                'image' => 'img168.jpg',
                'category' => 'elevator',
                'sort_order' => 79
            ],
            [
                'title' => 'Shopping Center Escalator - Fakieh Poultry',
                'description' => 'Commercial escalator cladding for Fakieh Poultry Farms, supporting agricultural business operations.',
                'image' => 'img169.jpg',
                'category' => 'escalator',
                'sort_order' => 80
            ],
            [
                'title' => 'Office Building Steel - ALJC',
                'description' => 'Modern office building steel work for Abdul Lateef Jamil Co., supporting corporate operations.',
                'image' => 'img172.jpg',
                'category' => 'steel',
                'sort_order' => 81
            ],
            [
                'title' => 'Water Storage System - Midad Real Estate',
                'description' => 'Comprehensive water storage system for Midad Real Estate, supporting property development operations.',
                'image' => 'img173.jpg',
                'category' => 'water',
                'sort_order' => 82
            ],
            [
                'title' => 'Custom Industrial Work - Nesma Partners',
                'description' => 'Specialized custom fabrication for Nesma and Partners, meeting diverse construction project requirements.',
                'image' => 'img174.jpg',
                'category' => 'custom',
                'sort_order' => 83
            ],
            [
                'title' => 'Industrial Infrastructure - Saudi Binladen',
                'description' => 'Large-scale industrial infrastructure for Saudi Binladen Group, supporting major construction projects.',
                'image' => 'img177.jpg',
                'category' => 'industrial',
                'sort_order' => 84
            ]
        ];

        // Process each gallery item
        foreach ($galleryData as $item) {
            $sourcePath = public_path('assets/pdf-images/' . $item['image']);
            $destinationPath = 'gallery/' . $item['image'];

            // Check if source image exists
            if (File::exists($sourcePath)) {
                // Copy image to storage
                Storage::disk('public')->put($destinationPath, File::get($sourcePath));

                // Create gallery image record
                GalleryImage::create([
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'image_path' => $destinationPath,
                    'category' => $item['category'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true
                ]);

                $this->command->info("Added gallery image: {$item['title']}");
            } else {
                $this->command->warn("Source image not found: {$item['image']}");
            }
        }

        $this->command->info('Gallery seeder completed successfully!');
    }
}
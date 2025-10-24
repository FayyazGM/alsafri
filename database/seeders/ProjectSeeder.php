<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create projects directory if it doesn't exist
        if (!Storage::disk('public')->exists('projects')) {
            Storage::disk('public')->makeDirectory('projects');
        }

        if (!Storage::disk('public')->exists('projects/gallery')) {
            Storage::disk('public')->makeDirectory('projects/gallery');
        }

        // Define projects with real Alsafri project data
        $projectsData = [
            // Haram Makkah Projects
            [
                'title' => 'Haram Makkah Elevator & Escalator Cladding',
                'description' => 'Comprehensive elevator and escalator cladding project for the prestigious Haram Makkah, featuring premium stainless steel finishes and intricate design elements that reflect the spiritual significance of the location.',
                'additional_content' => 'This landmark project involved the complete cladding of multiple elevators and escalators within the Haram Makkah complex. Our team worked meticulously to ensure that all installations met the highest standards of quality and durability while maintaining the sacred atmosphere of the location.',
                'conclusion' => 'The Haram Makkah project stands as a testament to our expertise in handling sensitive and high-profile installations. The successful completion of this project has strengthened our reputation in the religious and cultural infrastructure sector.',
                'category' => 'Haram Makkah Projects',
                'featured_image' => 'img15.jpg',
                'secondary_image' => 'img49.jpg',
                'gallery_images' => ['img52.jpg', 'img53.jpg', 'img54.jpg'],
                'features' => [
                    'Premium stainless steel cladding',
                    'Custom design elements',
                    'Religious site compliance',
                    'High-traffic durability',
                    'Weather-resistant materials',
                    'Maintenance-friendly design'
                ],
                'progress_data' => [
                    ['label' => 'Design & Planning', 'percentage' => 100],
                    ['label' => 'Material Procurement', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Quality Testing', 'percentage' => 100]
                ],
                'client_name' => 'Haram Makkah Administration',
                'project_location' => 'Makkah, Saudi Arabia',
                'project_date' => '2023-06-15',
                'project_duration' => '8 months',
                'project_value' => 2500000.00,
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true
            ],

            // Major Shopping Malls
            [
                'title' => 'Star Avenue Shopping Mall Escalator System',
                'description' => 'Complete escalator cladding and elevator installation for Star Avenue Shopping Mall in Jeddah, designed to handle high customer traffic while maintaining aesthetic appeal and safety standards.',
                'additional_content' => 'This commercial project involved the installation and cladding of multiple escalators and elevators throughout the shopping mall. The design focused on creating a modern, welcoming environment for shoppers while ensuring maximum durability and safety.',
                'conclusion' => 'The Star Avenue project successfully enhanced the shopping experience for thousands of daily visitors, demonstrating our capability to deliver large-scale commercial installations on time and within budget.',
                'category' => 'Major Shopping Malls',
                'featured_image' => 'img55.jpg',
                'secondary_image' => 'img56.jpg',
                'gallery_images' => ['img57.jpg', 'img58.jpg', 'img59.jpg'],
                'features' => [
                    'High-traffic escalator cladding',
                    'Modern commercial design',
                    'Safety compliance',
                    'Easy maintenance access',
                    'Energy-efficient systems',
                    'Customer-friendly aesthetics'
                ],
                'progress_data' => [
                    ['label' => 'Site Survey', 'percentage' => 100],
                    ['label' => 'Design Approval', 'percentage' => 100],
                    ['label' => 'Manufacturing', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Testing & Commissioning', 'percentage' => 100]
                ],
                'client_name' => 'Star Avenue Mall Management',
                'project_location' => 'Jeddah, Saudi Arabia',
                'project_date' => '2023-03-20',
                'project_duration' => '6 months',
                'project_value' => 1800000.00,
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true
            ],

            // Universities & Hospitals
            [
                'title' => 'King Abdullah University Steel Framework',
                'description' => 'Comprehensive steel structure framework for King Abdullah University of Science and Technology (KAUST), supporting advanced research facilities and academic buildings with precision engineering.',
                'additional_content' => 'This educational infrastructure project involved the design and installation of complex steel frameworks for multiple buildings within the KAUST campus. The project required adherence to strict academic facility standards and long-term durability requirements.',
                'conclusion' => 'The KAUST project showcases our expertise in educational infrastructure development, contributing to Saudi Arabia\'s vision of becoming a global leader in science and technology education.',
                'category' => 'Universities & Hospitals',
                'featured_image' => 'img60.jpg',
                'secondary_image' => 'img63.jpg',
                'gallery_images' => ['img64.jpg', 'img65.jpg', 'img67.jpg'],
                'features' => [
                    'Advanced steel framework design',
                    'Research facility compliance',
                    'Long-term durability',
                    'Academic building standards',
                    'Precision engineering',
                    'Sustainable construction'
                ],
                'progress_data' => [
                    ['label' => 'Engineering Design', 'percentage' => 100],
                    ['label' => 'Material Selection', 'percentage' => 100],
                    ['label' => 'Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Quality Assurance', 'percentage' => 100]
                ],
                'client_name' => 'King Abdullah University (KAUST)',
                'project_location' => 'Thuwal, Saudi Arabia',
                'project_date' => '2022-11-10',
                'project_duration' => '12 months',
                'project_value' => 3200000.00,
                'sort_order' => 3,
                'is_featured' => true,
                'is_active' => true
            ],

            // Commercial Buildings
            [
                'title' => 'Jabal Omar Commercial Complex Steel Work',
                'description' => 'Extensive steel fabrication and installation for Jabal Omar Commercial Complex in Makkah, including structural elements, handrails, and custom architectural features.',
                'additional_content' => 'This large-scale commercial project involved multiple phases of steel work including structural frameworks, decorative elements, and safety installations. The project required coordination with multiple contractors and adherence to strict timeline requirements.',
                'conclusion' => 'The Jabal Omar project demonstrates our capability to handle complex commercial developments while maintaining the highest standards of quality and safety.',
                'category' => 'Commercial Buildings',
                'featured_image' => 'img72.jpg',
                'secondary_image' => 'img73.jpg',
                'gallery_images' => ['img74.jpg', 'img75.jpg', 'img76.jpg'],
                'features' => [
                    'Structural steel framework',
                    'Custom architectural elements',
                    'Safety handrails',
                    'Commercial building compliance',
                    'Multi-phase coordination',
                    'Timeline adherence'
                ],
                'progress_data' => [
                    ['label' => 'Project Planning', 'percentage' => 100],
                    ['label' => 'Steel Fabrication', 'percentage' => 100],
                    ['label' => 'Site Preparation', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Final Inspection', 'percentage' => 100]
                ],
                'client_name' => 'Jabal Omar Development Company',
                'project_location' => 'Makkah, Saudi Arabia',
                'project_date' => '2023-01-15',
                'project_duration' => '10 months',
                'project_value' => 2800000.00,
                'sort_order' => 4,
                'is_featured' => false,
                'is_active' => true
            ],

            // Industrial Projects
            [
                'title' => 'Shoiba Power Plant Steel Infrastructure',
                'description' => 'Heavy-duty steel infrastructure installation for Shoiba Power Plant, supporting critical energy generation equipment with industrial-grade materials and precision engineering.',
                'additional_content' => 'This industrial project involved the installation of specialized steel structures designed to support heavy power generation equipment. The project required adherence to strict industrial safety standards and environmental regulations.',
                'conclusion' => 'The Shoiba Power Plant project contributes to Saudi Arabia\'s energy infrastructure, supporting the country\'s vision for sustainable energy development.',
                'category' => 'Industrial Projects',
                'featured_image' => 'img77.jpg',
                'secondary_image' => 'img80.jpg',
                'gallery_images' => ['img81.jpg', 'img82.jpg', 'img83.jpg'],
                'features' => [
                    'Heavy-duty steel structures',
                    'Industrial safety compliance',
                    'Power plant specifications',
                    'Environmental regulations',
                    'Equipment support systems',
                    'Long-term reliability'
                ],
                'progress_data' => [
                    ['label' => 'Engineering Analysis', 'percentage' => 100],
                    ['label' => 'Material Procurement', 'percentage' => 100],
                    ['label' => 'Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Safety Testing', 'percentage' => 100]
                ],
                'client_name' => 'Saudi Electricity Company',
                'project_location' => 'Shoiba, Saudi Arabia',
                'project_date' => '2022-08-05',
                'project_duration' => '14 months',
                'project_value' => 4500000.00,
                'sort_order' => 5,
                'is_featured' => true,
                'is_active' => true
            ],

            // Power Plants
            [
                'title' => 'Maaden Gold Company Industrial Steel Work',
                'description' => 'Specialized steel fabrication for Maaden Gold Company mining facility, including structural supports, safety systems, and custom industrial components.',
                'additional_content' => 'This mining industry project required specialized steel work designed to withstand harsh industrial environments. The project involved custom fabrication of components specifically designed for mining operations.',
                'conclusion' => 'The Maaden Gold project showcases our expertise in industrial and mining sector applications, contributing to Saudi Arabia\'s mining industry development.',
                'category' => 'Power Plants',
                'featured_image' => 'img84.jpg',
                'secondary_image' => 'img85.jpg',
                'gallery_images' => ['img88.jpg', 'img89.jpg', 'img90.jpg'],
                'features' => [
                    'Mining industry specifications',
                    'Harsh environment resistance',
                    'Custom industrial components',
                    'Safety system integration',
                    'Heavy-duty construction',
                    'Mining operation compliance'
                ],
                'progress_data' => [
                    ['label' => 'Site Assessment', 'percentage' => 100],
                    ['label' => 'Custom Design', 'percentage' => 100],
                    ['label' => 'Specialized Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Operational Testing', 'percentage' => 100]
                ],
                'client_name' => 'Maaden Gold Company',
                'project_location' => 'Mining Region, Saudi Arabia',
                'project_date' => '2023-04-12',
                'project_duration' => '9 months',
                'project_value' => 2200000.00,
                'sort_order' => 6,
                'is_featured' => false,
                'is_active' => true
            ],

            // Additional Projects
            [
                'title' => 'Clock Tower Makkah Luxury Elevator Cladding',
                'description' => 'Premium elevator cladding installation for the iconic Clock Tower Makkah, featuring luxury finishes and intricate design elements that complement the architectural grandeur of the building.',
                'additional_content' => 'This prestigious project involved the cladding of elevators within the Clock Tower Makkah complex. The design focused on luxury aesthetics while maintaining functionality and durability in a high-traffic environment.',
                'conclusion' => 'The Clock Tower Makkah project represents our commitment to excellence in luxury hospitality and religious infrastructure development.',
                'category' => 'Haram Makkah Projects',
                'featured_image' => 'img91.jpg',
                'secondary_image' => 'img92.jpg',
                'gallery_images' => ['img93.jpg', 'img94.jpg', 'img95.jpg'],
                'features' => [
                    'Luxury finish materials',
                    'Architectural integration',
                    'High-traffic durability',
                    'Premium aesthetics',
                    'Religious site compliance',
                    'Maintenance accessibility'
                ],
                'progress_data' => [
                    ['label' => 'Design Consultation', 'percentage' => 100],
                    ['label' => 'Material Selection', 'percentage' => 100],
                    ['label' => 'Precision Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Final Inspection', 'percentage' => 100]
                ],
                'client_name' => 'Clock Tower Makkah Management',
                'project_location' => 'Makkah, Saudi Arabia',
                'project_date' => '2023-07-20',
                'project_duration' => '5 months',
                'project_value' => 1900000.00,
                'sort_order' => 7,
                'is_featured' => true,
                'is_active' => true
            ],

            [
                'title' => 'Panorama Mall Steel Structure & Escalators',
                'description' => 'Comprehensive steel structure and escalator installation for Panorama Mall Riyadh, including structural frameworks and modern escalator cladding systems.',
                'additional_content' => 'This shopping mall project involved both structural steel work and escalator installations. The project required coordination between structural and mechanical systems to ensure seamless integration.',
                'conclusion' => 'The Panorama Mall project successfully enhanced the shopping experience while providing robust structural support for the commercial facility.',
                'category' => 'Major Shopping Malls',
                'featured_image' => 'img98.jpg',
                'secondary_image' => 'img99.jpg',
                'gallery_images' => ['img102.jpg', 'img103.jpg', 'img104.jpg'],
                'features' => [
                    'Structural steel framework',
                    'Modern escalator systems',
                    'Shopping mall integration',
                    'Commercial durability',
                    'Customer experience focus',
                    'Multi-system coordination'
                ],
                'progress_data' => [
                    ['label' => 'Structural Design', 'percentage' => 100],
                    ['label' => 'Escalator Planning', 'percentage' => 100],
                    ['label' => 'Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'System Integration', 'percentage' => 100]
                ],
                'client_name' => 'Panorama Mall Management',
                'project_location' => 'Riyadh, Saudi Arabia',
                'project_date' => '2023-02-28',
                'project_duration' => '7 months',
                'project_value' => 2100000.00,
                'sort_order' => 8,
                'is_featured' => false,
                'is_active' => true
            ],

            [
                'title' => 'King Fahad Hospital Medical Facility Steel Work',
                'description' => 'Specialized steel fabrication for King Fahad Hospital, including structural elements, safety systems, and medical facility compliance installations.',
                'additional_content' => 'This healthcare project required adherence to strict medical facility standards and regulations. The steel work was designed to support medical equipment and ensure patient safety.',
                'conclusion' => 'The King Fahad Hospital project contributes to Saudi Arabia\'s healthcare infrastructure, supporting the delivery of quality medical services.',
                'category' => 'Universities & Hospitals',
                'featured_image' => 'img112.jpg',
                'secondary_image' => 'img113.jpg',
                'gallery_images' => ['img114.jpg', 'img115.jpg', 'img116.jpg'],
                'features' => [
                    'Medical facility compliance',
                    'Healthcare safety standards',
                    'Equipment support systems',
                    'Patient safety focus',
                    'Regulatory adherence',
                    'Long-term reliability'
                ],
                'progress_data' => [
                    ['label' => 'Medical Standards Review', 'percentage' => 100],
                    ['label' => 'Safety Design', 'percentage' => 100],
                    ['label' => 'Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Compliance Testing', 'percentage' => 100]
                ],
                'client_name' => 'King Fahad Hospital',
                'project_location' => 'Jeddah, Saudi Arabia',
                'project_date' => '2022-12-10',
                'project_duration' => '8 months',
                'project_value' => 1600000.00,
                'sort_order' => 9,
                'is_featured' => false,
                'is_active' => true
            ],

            [
                'title' => 'Arabian Cement Factory Industrial Installation',
                'description' => 'Heavy industrial steel installation for Arabian Cement Factory Rabigh, including structural supports, conveyor systems, and industrial safety components.',
                'additional_content' => 'This industrial project involved the installation of specialized steel structures designed for cement manufacturing operations. The project required materials and designs capable of withstanding harsh industrial environments.',
                'conclusion' => 'The Arabian Cement Factory project demonstrates our expertise in heavy industrial applications, supporting Saudi Arabia\'s manufacturing sector.',
                'category' => 'Industrial Projects',
                'featured_image' => 'img118.jpg',
                'secondary_image' => 'img122.jpg',
                'gallery_images' => ['img123.jpg', 'img124.jpg', 'img125.jpg'],
                'features' => [
                    'Heavy industrial specifications',
                    'Cement industry compliance',
                    'Harsh environment resistance',
                    'Conveyor system support',
                    'Industrial safety systems',
                    'Manufacturing optimization'
                ],
                'progress_data' => [
                    ['label' => 'Industrial Analysis', 'percentage' => 100],
                    ['label' => 'Heavy-duty Design', 'percentage' => 100],
                    ['label' => 'Industrial Fabrication', 'percentage' => 100],
                    ['label' => 'Installation', 'percentage' => 100],
                    ['label' => 'Industrial Testing', 'percentage' => 100]
                ],
                'client_name' => 'Arabian Cement Company',
                'project_location' => 'Rabigh, Saudi Arabia',
                'project_date' => '2023-05-18',
                'project_duration' => '11 months',
                'project_value' => 3800000.00,
                'sort_order' => 10,
                'is_featured' => true,
                'is_active' => true
            ]
        ];

        // Process each project
        foreach ($projectsData as $projectData) {
            // Handle featured image
            $featuredImagePath = $this->copyImage($projectData['featured_image'], 'projects');
            
            // Handle secondary image
            $secondaryImagePath = null;
            if (isset($projectData['secondary_image'])) {
                $secondaryImagePath = $this->copyImage($projectData['secondary_image'], 'projects');
            }

            // Handle gallery images
            $galleryImages = [];
            if (isset($projectData['gallery_images'])) {
                foreach ($projectData['gallery_images'] as $galleryImage) {
                    $path = $this->copyImage($galleryImage, 'projects/gallery');
                    $galleryImages[] = [
                        'url' => $path,
                        'alt' => $projectData['title']
                    ];
                }
            }

            // Create project record
            Project::create([
                'title' => $projectData['title'],
                'slug' => \Illuminate\Support\Str::slug($projectData['title']),
                'description' => $projectData['description'],
                'additional_content' => $projectData['additional_content'] ?? null,
                'conclusion' => $projectData['conclusion'] ?? null,
                'category' => $projectData['category'],
                'featured_image_path' => $featuredImagePath,
                'secondary_image_path' => $secondaryImagePath,
                'gallery_images' => $galleryImages,
                'features' => $projectData['features'] ?? [],
                'progress_data' => $projectData['progress_data'] ?? [],
                'client_name' => $projectData['client_name'] ?? null,
                'project_location' => $projectData['project_location'] ?? null,
                'project_date' => $projectData['project_date'] ?? null,
                'project_duration' => $projectData['project_duration'] ?? null,
                'project_value' => $projectData['project_value'] ?? null,
                'sort_order' => $projectData['sort_order'] ?? 0,
                'is_featured' => $projectData['is_featured'] ?? false,
                'is_active' => $projectData['is_active'] ?? true
            ]);

            $this->command->info("Added project: {$projectData['title']}");
        }

        $this->command->info('Project seeder completed successfully!');
    }

    /**
     * Copy image from pdf-images to storage
     */
    private function copyImage($imageName, $destinationFolder)
    {
        $sourcePath = public_path('assets/pdf-images/' . $imageName);
        $destinationPath = $destinationFolder . '/' . $imageName;

        if (File::exists($sourcePath)) {
            Storage::disk('public')->put($destinationPath, File::get($sourcePath));
            return $destinationPath;
        }

        $this->command->warn("Source image not found: {$imageName}");
        return null;
    }
}
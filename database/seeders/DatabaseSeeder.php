<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\HomeSection;
use App\Models\Language;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesPermissionsSeeder::class);
        $superAdminRole = \App\Models\Role::query()->where('slug', 'super-admin')->firstOrFail();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@nofouth.local'],
            [
                'name' => 'Administrator',
                'job_title' => 'System Administrator',
                'is_active' => true,
                'password' => Hash::make('admin12345'),
            ]
        );
        $admin->roles()->syncWithoutDetaching([$superAdminRole->id]);

        Language::query()->updateOrCreate(
            ['code' => 'ar'],
            ['name' => 'Arabic', 'native_name' => 'العربية', 'direction' => 'rtl', 'is_active' => true, 'is_default' => true, 'sort_order' => 1]
        );

        Language::query()->updateOrCreate(
            ['code' => 'en'],
            ['name' => 'English', 'native_name' => 'English', 'direction' => 'ltr', 'is_active' => true, 'is_default' => false, 'sort_order' => 2]
        );

        $products = [
            [
                'name' => 'FLOW ARAIB 714',
                'slug' => 'flow-araib-714',
                'sku' => '714',
                'category' => 'CPVC',
                'tagline' => 'لاصق CPVC شديد السماكة',
                'short_description' => 'لاصق عالي الأداء للأنابيب الكبيرة والضغط العالي مع قوة ربط ثابتة.',
                'description' => 'تم تطوير FLOW ARAIB 714 لتطبيقات CPVC الحرجة في خطوط المياه الساخنة والباردة، ويمنح زمن تشغيل مناسبًا وقوة لحام كيميائي عالية في المشاريع الصناعية والتجارية.',
                'viscosity' => 'Heavy Bodied',
                'standard' => 'ASTM F493',
                'max_diameter' => '12 بوصة',
                'operating_temperature' => '93°م',
                'color' => 'برتقالي',
                'badge' => 'الأكثر طلبًا',
                'accent_color' => 'red',
                'image_url' => 'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/714',
                'msds_url' => 'https://example.com/msds/714',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'FLOW ARAIB 500',
                'slug' => 'flow-araib-500',
                'sku' => '500',
                'category' => 'PVC',
                'tagline' => 'لاصق PVC متوسط السماكة',
                'short_description' => 'مناسب للتطبيقات السكنية والتجارية الخفيفة والمتوسطة.',
                'description' => 'يوفر FLOW ARAIB 500 ختمًا موثوقًا لشبكات PVC مع سهولة تطبيق وسرعة تماسك، ما يجعله خيارًا عمليًا للمشاريع اليومية.',
                'viscosity' => 'Medium Bodied',
                'standard' => 'ASTM D2564',
                'max_diameter' => '6 بوصة',
                'operating_temperature' => '60°م',
                'color' => 'أزرق',
                'badge' => 'الأكثر استخدامًا',
                'accent_color' => 'blue',
                'image_url' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/500',
                'msds_url' => 'https://example.com/msds/500',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'FLOW ARAIB P-70',
                'slug' => 'flow-araib-p70',
                'sku' => 'P70',
                'category' => 'Primer',
                'tagline' => 'برايمر سريع المفعول',
                'short_description' => 'محلول تنظيف وتحضير لتحسين اختراق اللاصق وجودة الربط.',
                'description' => 'يساعد FLOW ARAIB P-70 على تجهيز السطح قبل عملية اللصق، ويعزز ثبات الوصلة خصوصًا في أنظمة الأنابيب التي تحتاج جودة عالية في التحضير.',
                'viscosity' => 'Primer',
                'standard' => 'Quality Certified',
                'max_diameter' => 'حسب التطبيق',
                'operating_temperature' => 'متعدد الاستخدام',
                'color' => 'شفاف',
                'badge' => 'تحضير أساسي',
                'accent_color' => 'yellow',
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/p70',
                'msds_url' => 'https://example.com/msds/p70',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'FLOW ARAIB 300',
                'slug' => 'flow-araib-300',
                'sku' => '300',
                'category' => 'PVC',
                'tagline' => 'لاصق PVC خفيف السماكة',
                'short_description' => 'اقتصادي وسريع الجفاف لتطبيقات الصرف والضغط المنخفض.',
                'description' => 'تم تصميم FLOW ARAIB 300 للأعمال الداخلية السريعة، ويمنح سرعة تنفيذ جيدة في المشاريع التي تتطلب تطبيقًا خفيفًا وفعالًا.',
                'viscosity' => 'Light Bodied',
                'standard' => 'ASTM D2564',
                'max_diameter' => '4 بوصة',
                'operating_temperature' => '50°م',
                'color' => 'شفاف مائل للأزرق',
                'badge' => 'سريع الجفاف',
                'accent_color' => 'teal',
                'image_url' => 'https://images.unsplash.com/photo-1513828583688-c52646db42da?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/300',
                'msds_url' => 'https://example.com/msds/300',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product);
        }

        $hero = HomeSection::query()->create([
            'key' => 'hero',
            'title' => 'حلول CPVC الرائدة. قوة شركة نفوذ المستقبل',
            'subtitle' => 'نحوّل الموقع الثابت إلى منصة أعمال ديناميكية تعرض المنتجات والمقالات وآراء العملاء وتستقبل الطلبات من قاعدة بيانات MySQL.',
            'variant' => 'hero',
            'anchor' => 'hero',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $hero->items()->create([
            'title' => 'ابدأ طلبك الآن',
            'subtitle' => 'قوة ترابط تتحمل الحرارة والضغط',
            'description' => 'موقع عربي ديناميكي لإدارة المحتوى والمنتجات والمقالات من لوحة تحكم واحدة.',
            'button_text' => 'طلب تسعيرة',
            'button_url' => '/quote-request',
            'image_url' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1400&q=80',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'شركة نفوذ المستقبل',
                'site_tagline' => 'حلول لواصق CPVC و PVC الصناعية',
                'logo_url' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?auto=format&fit=crop&w=300&q=80',
                'contact_email' => 'info@araib.com',
                'contact_phone' => '+966 577252986',
                'contact_address' => 'الرياض - المملكة العربية السعودية',
                'map_embed_url' => 'https://www.google.com/maps?q=Riyadh&output=embed',
                'whatsapp_number' => '+966577252986',
                'vision' => 'أن نكون الخيار الأول في حلول اللواصق الصناعية وإدارة المحتوى الفني للقطاع.',
                'mission' => 'تقديم منتجات موثوقة ومنصة رقمية ديناميكية تساعد العملاء على الوصول السريع للمنتجات والمعلومات وطلبات التسعير.',
                'about_text' => 'نحن شركة متخصصة في حلول اللواصق الصناعية، وتم تحويل هذا الموقع إلى منصة Laravel ديناميكية قابلة للإدارة الكاملة من لوحة التحكم.',
                'footer_text' => 'جميع الحقوق محفوظة - شركة نفوذ المستقبل',
                'default_article_image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'default_meta_title' => 'شركة نفوذ المستقبل',
                'default_meta_description' => 'موقع ديناميكي لمنتجات اللواصق الصناعية والمقالات وطلبات التسعير.',
                'default_meta_keywords' => 'CPVC, PVC, لواصق صناعية, مقالات فنية, طلب تسعيرة',
            ]
        );

        $featureSection = HomeSection::query()->create([
            'key' => 'why-714',
            'title' => 'لماذا FLOW 714 هو خيارك الأفضل؟',
            'subtitle' => 'هذا القسم قابل لزيادة عدد الكروت من لوحة الإدارة.',
            'variant' => 'cards',
            'anchor' => 'features',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $featureSection->items()->createMany([
            [
                'title' => 'قوة لا تضاهى',
                'description' => 'تركيبة Heavy Bodied تضمن ترابطًا فوريًا وموثوقًا لأنابيب CPVC حتى الأقطار الكبيرة.',
                'icon' => '⚡',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'تحمل درجات الحرارة',
                'description' => 'مناسب لخطوط المياه الساخنة والأنظمة الصناعية التي تتطلب أداءً مستقرًا عند الحرارة العالية.',
                'icon' => '🔥',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'معتمد وموثوق',
                'description' => 'مصمم وفق معايير جودة عالية لدعم الاعتمادية والسلامة في مشاريع البنية التحتية.',
                'icon' => '👍',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ]);

        $statsSection = HomeSection::query()->create([
            'key' => 'stats',
            'title' => 'شركة نفوذ المستقبل في أرقام',
            'subtitle' => 'قسم إحصائيات ديناميكي يمكن تعديله أو زيادته.',
            'variant' => 'stats',
            'anchor' => 'stats',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $statsSection->items()->createMany([
            ['title' => '45+', 'metric' => '45+', 'metric_label' => 'عامًا من الخبرة', 'sort_order' => 1, 'is_active' => true],
            ['title' => '3M+', 'metric' => '3M+', 'metric_label' => 'وصلة آمنة', 'sort_order' => 2, 'is_active' => true],
            ['title' => '180°F', 'metric' => '180°F', 'metric_label' => 'تحمل حراري', 'sort_order' => 3, 'is_active' => true],
            ['title' => 'NSF', 'metric' => 'NSF', 'metric_label' => 'شهادة جودة', 'sort_order' => 4, 'is_active' => true],
        ]);

        $valueSection = HomeSection::query()->create([
            'key' => 'vision',
            'title' => 'الرؤية والرسالة',
            'subtitle' => 'يمكنك إنشاء أي عدد من الأقسام المشابهة من لوحة التحكم.',
            'variant' => 'cards',
            'anchor' => 'vision',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $valueSection->items()->createMany([
            [
                'title' => 'الرؤية الاستراتيجية',
                'description' => 'أن نكون المرجع الأول في حلول الترابط الحراري في المنطقة.',
                'icon' => '🎯',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'الرسالة التنفيذية',
                'description' => 'تزويد السوق بمنتجات تفوق معايير الجودة مع سرعة استجابة ودعم فني.',
                'icon' => '⚙️',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'الالتزام البيئي',
                'description' => 'تطوير تركيبات أكثر أمانًا للعاملين وأقل أثرًا على البيئة.',
                'icon' => '🌱',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ]);

        $aboutHeroSection = HomeSection::query()->create([
            'page' => 'about',
            'key' => 'about-hero',
            'title' => 'رسالتنا ورؤيتنا',
            'subtitle' => 'نقدم حلولاً صناعية موثوقة مدعومة بخبرة فنية ومحتوى ديناميكي يمكن تحديثه بالكامل من لوحة التحكم.',
            'variant' => 'hero',
            'anchor' => 'about-hero',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $aboutHeroSection->items()->create([
            'title' => 'من نحن',
            'subtitle' => 'قصة الشركة وخبرتها',
            'description' => 'تأسست الشركة بهدف توفير حلول لاصقة عالية الجودة لقطاعات البناء والبنية التحتية والتطبيقات الصناعية، مع التزام واضح بالجودة والاعتمادية والدعم الفني.',
            'button_text' => 'تواصل معنا',
            'button_url' => '/contact',
            'image_url' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1400&q=80',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $aboutCertificatesSection = HomeSection::query()->create([
            'page' => 'about',
            'key' => 'about-certificates',
            'title' => 'شهادات الجودة والامتثال',
            'subtitle' => 'منتجاتنا معتمدة وفق معايير الجودة والاعتمادية لدعم المشاريع الصناعية والتجارية.',
            'variant' => 'cards',
            'anchor' => 'certificates',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $aboutCertificatesSection->items()->createMany([
            ['title' => 'ISO 9001', 'subtitle' => 'نظام إدارة الجودة', 'description' => 'اعتماد يدعم استمرارية التحسين وجودة العمليات والإنتاج.', 'icon' => '🏅', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'NSF', 'subtitle' => 'مطابقة تقنية', 'description' => 'شهادة موثوقة للتطبيقات التي تتطلب معايير أداء وسلامة عالية.', 'icon' => '✅', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'SASO', 'subtitle' => 'اعتماد سعودي', 'description' => 'التزام بالمواصفات المحلية ومتطلبات الامتثال في السوق السعودي.', 'icon' => '📘', 'sort_order' => 3, 'is_active' => true],
        ]);

        $aboutTeamSection = HomeSection::query()->create([
            'page' => 'about',
            'key' => 'about-team',
            'title' => 'فريق القيادة والخبرة',
            'subtitle' => 'يمكن تعديل أسماء الفريق ووظائفهم وصورهم من لوحة التحكم.',
            'variant' => 'cards',
            'anchor' => 'team',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $aboutTeamSection->items()->createMany([
            ['title' => 'أحمد الدبعي', 'subtitle' => 'المدير العام', 'description' => 'خبرة طويلة في تطوير الحلول الكيميائية وقيادة المبادرات الصناعية.', 'icon' => '👤', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'إدارة الجودة', 'subtitle' => 'المدير التقني', 'description' => 'متابعة المواصفات والاختبارات وضمان مطابقة المعايير الفنية.', 'icon' => '🧪', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'تطوير الأعمال', 'subtitle' => 'العلاقات والمبيعات', 'description' => 'ربط الاحتياج الفني بالسوق والمشاريع وتسريع الاستجابة للعملاء.', 'icon' => '🤝', 'sort_order' => 3, 'is_active' => true],
        ]);

        $aboutStatsSection = HomeSection::query()->create([
            'page' => 'about',
            'key' => 'about-stats',
            'title' => 'إنجازات تتحدث عن نفسها',
            'subtitle' => 'قسم إحصائي متحرك يظهر على صفحة من نحن بشكل ديناميكي.',
            'variant' => 'stats',
            'anchor' => 'about-stats',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $aboutStatsSection->items()->createMany([
            ['title' => '45+', 'metric' => '45+', 'metric_label' => 'عامًا من الخبرة', 'sort_order' => 1, 'is_active' => true],
            ['title' => '850+', 'metric' => '850+', 'metric_label' => 'مشروعًا منجزًا', 'sort_order' => 2, 'is_active' => true],
            ['title' => '98.5%', 'metric' => '98.5%', 'metric_label' => 'رضا العملاء', 'sort_order' => 3, 'is_active' => true],
            ['title' => '11000+', 'metric' => '11000+', 'metric_label' => 'وصلة آمنة', 'sort_order' => 4, 'is_active' => true],
        ]);

        foreach ([
            [
                'title' => 'دليل اختيار لاصق CPVC المناسب للمشاريع الحرارية',
                'slug' => 'cpvc-adhesive-selection-guide',
                'excerpt' => 'مقال يشرح كيف تختار التركيبة المناسبة حسب الحرارة والضغط والقطر.',
                'body' => 'هذا المقال يشرح معايير اختيار لاصق CPVC المناسب، مثل درجة الحرارة، نوع الأنابيب، القطر، وظروف التشغيل في الموقع. ويمكن استخدام هذا المحتوى كقاعدة لمكتبة مقالات ديناميكية قابلة للنشر من لوحة التحكم.',
                'cover_image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/cpvc-guide.pdf',
                'meta_title' => 'دليل اختيار لاصق CPVC المناسب',
                'meta_description' => 'شرح معايير اختيار لاصق CPVC حسب نوع المشروع والضغط والحرارة.',
                'meta_keywords' => 'لاصق CPVC, دليل CPVC, مقالات فنية',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'sort_order' => 1,
            ],
            [
                'title' => 'أفضل ممارسات تجهيز الأنابيب قبل اللصق',
                'slug' => 'pipe-surface-preparation-best-practices',
                'excerpt' => 'خطوات عملية لتجهيز السطح وضمان قوة الترابط ورفع كفاءة التركيب.',
                'body' => 'يوضح هذا المقال أهمية التنظيف والتحضير واستخدام البرايمر المناسب قبل اللصق. كما يعرض أخطاء شائعة تؤثر على قوة الربط النهائي في مشاريع CPVC وPVC.',
                'cover_image' => 'https://images.unsplash.com/photo-1581092918484-8313c7f0f0df?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/preparation.pdf',
                'meta_title' => 'أفضل ممارسات تجهيز الأنابيب قبل اللصق',
                'meta_description' => 'خطوات عملية لتجهيز السطح وضمان قوة الترابط.',
                'meta_keywords' => 'تجهيز الأنابيب, برايمر, لاصق',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'sort_order' => 2,
            ],
            [
                'title' => 'مقارنة بين FLOW 714 و FLOW 500 حسب الاستخدام',
                'slug' => 'flow-714-vs-flow-500',
                'excerpt' => 'مقارنة مبسطة بين المنتجين الأشهر حسب نوع المشروع والضغط الحراري.',
                'body' => 'يستعرض المقال الفرق بين FLOW 714 وFLOW 500 من حيث اللزوجة، التطبيقات، زمن التشغيل، ومدى الملاءمة للمشاريع السكنية والتجارية والصناعية.',
                'cover_image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/comparison.pdf',
                'meta_title' => 'مقارنة بين FLOW 714 و FLOW 500',
                'meta_description' => 'مقارنة مبسطة بين المنتجين حسب نوع المشروع والاستخدام.',
                'meta_keywords' => 'FLOW 714, FLOW 500, مقارنة منتجات',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'sort_order' => 3,
            ],
        ] as $article) {
            Article::query()->create($article);
        }

        foreach ([
            [
                'client_name' => 'م. خالد الفيصل',
                'client_title' => 'الرئيس التنفيذي',
                'company_name' => 'شركة البناء المتقدمة',
                'quote' => 'اعتمادنا على FLOW 714 في مشروعنا الأخير أثبت كفاءة عالية في تحمل الضغوط التشغيلية، وكانت جودة الترابط ممتازة.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'فريق الصيانة',
                'client_title' => 'إدارة التشغيل',
                'company_name' => 'مصنع السخانات المركزية',
                'quote' => 'سهولة التطبيق وسرعة التماسك في FLOW 500 ساعدتنا على تقليل وقت التركيب ورفع كفاءة التنفيذ.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'م. سارة العلي',
                'client_title' => 'مقاول مشاريع',
                'company_name' => 'قطاع البنية التحتية',
                'quote' => 'التعامل كان مهنيًا ومنتج P-70 قدم فارقًا واضحًا في تجهيز الأنابيب قبل اللصق.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ] as $testimonial) {
            Testimonial::query()->create($testimonial);
        }

        $quote = QuoteRequest::query()->create([
            'company_name' => 'شركة الدبعي التجارية',
            'contact_person' => 'أحمد الدبعي',
            'email' => 'sales@example.com',
            'phone' => '0555555555',
            'notes' => 'نحتاج عرض سعر لمشروع توريد في الرياض.',
            'status' => 'new',
        ]);

        $quote->items()->createMany([
            [
                'product_id' => Product::query()->where('sku', '714')->value('id'),
                'product_name' => 'FLOW ARAIB 714',
                'quantity' => 120,
                'unit' => 'جالون',
            ],
            [
                'product_id' => Product::query()->where('sku', 'P70')->value('id'),
                'product_name' => 'FLOW ARAIB P-70',
                'quantity' => 40,
                'unit' => 'كرتون',
            ],
        ]);

        ContactMessage::query()->create([
            'name' => 'مؤسسة الخليج للمقاولات',
            'email' => 'info@gulf-contracting.test',
            'subject' => 'استفسار فني',
            'message' => 'هل المنتج 714 مناسب لخطوط المياه الساخنة في المشاريع التجارية؟',
            'status' => 'new',
        ]);
        SiteSetting::query()->whereKey(1)->update([
            'site_name_translations' => ['ar' => 'شركة نفوذ المستقبل', 'en' => 'Nofouth Future Company'],
            'site_tagline_translations' => ['ar' => 'حلول لواصق CPVC و PVC الصناعية', 'en' => 'Industrial CPVC and PVC adhesive solutions'],
            'contact_address_translations' => ['ar' => 'الرياض - المملكة العربية السعودية', 'en' => 'Riyadh - Saudi Arabia'],
            'vision_translations' => ['ar' => 'أن نكون الخيار الأول في حلول اللواصق الصناعية وإدارة المحتوى الفني للقطاع.', 'en' => 'To become the first choice in industrial adhesive solutions and technical content management.'],
            'mission_translations' => ['ar' => 'تقديم منتجات موثوقة ومنصة رقمية ديناميكية تساعد العملاء على الوصول السريع للمعلومات وطلبات التسعير.', 'en' => 'To provide reliable products and a dynamic digital platform that helps clients access information and quote requests quickly.'],
            'about_text_translations' => ['ar' => 'نحن شركة متخصصة في حلول اللواصق الصناعية وتم تحويل هذا الموقع إلى منصة Laravel ديناميكية كاملة.', 'en' => 'We are a company specialized in industrial adhesive solutions, and this website has been transformed into a fully dynamic Laravel platform.'],
            'footer_text_translations' => ['ar' => 'جميع الحقوق محفوظة - شركة نفوذ المستقبل', 'en' => 'All rights reserved - Nofouth Future Company'],
            'default_meta_title_translations' => ['ar' => 'شركة نفوذ المستقبل', 'en' => 'Nofouth Future Company'],
            'default_meta_description_translations' => ['ar' => 'موقع ديناميكي لمنتجات اللواصق الصناعية والمقالات وطلبات التسعير.', 'en' => 'A dynamic website for industrial adhesives, articles, and quote requests.'],
            'default_meta_keywords_translations' => ['ar' => 'CPVC, PVC, لواصق صناعية, مقالات فنية, طلب تسعيرة', 'en' => 'CPVC, PVC, industrial adhesives, technical articles, quote request'],
        ]);

        HomeSection::query()->where('key', 'hero')->update([
            'title_translations' => ['ar' => 'حلول CPVC الرائدة. قوة شركة نفوذ المستقبل', 'en' => 'Leading CPVC Solutions. Powered by Nofouth Future'],
            'subtitle_translations' => ['ar' => 'نحوّل الموقع الثابت إلى منصة أعمال ديناميكية تعرض المنتجات والمقالات وآراء العملاء وطلبات التسعير.', 'en' => 'We turn a static website into a dynamic business platform for products, articles, testimonials, and quote requests.'],
        ]);

        HomeSection::query()->where('page', 'about')->where('key', 'about-hero')->update([
            'title_translations' => ['ar' => 'رسالتنا ورؤيتنا', 'en' => 'Our Mission and Vision'],
            'subtitle_translations' => ['ar' => 'نقدم حلولاً صناعية موثوقة مدعومة بخبرة فنية ومحتوى ديناميكي.', 'en' => 'We provide trusted industrial solutions backed by technical expertise and dynamic content.'],
        ]);

        Product::query()->where('sku', '714')->update([
            'name_translations' => ['ar' => 'فلو عرايب 714', 'en' => 'FLOW ARAIB 714'],
            'category_translations' => ['ar' => 'سي بي في سي', 'en' => 'CPVC'],
            'tagline_translations' => ['ar' => 'لاصق CPVC شديد السماكة', 'en' => 'Heavy bodied CPVC cement'],
        ]);

        Product::query()->where('sku', '500')->update([
            'name_translations' => ['ar' => 'فلو عرايب 500', 'en' => 'FLOW ARAIB 500'],
            'category_translations' => ['ar' => 'بي في سي', 'en' => 'PVC'],
            'tagline_translations' => ['ar' => 'لاصق PVC متوسط السماكة', 'en' => 'Medium bodied PVC cement'],
        ]);
        Article::query()->where('slug', 'cpvc-adhesive-selection-guide')->update([
            'title_translations' => ['ar' => 'دليل اختيار لاصق CPVC المناسب للمشاريع الحرارية', 'en' => 'Guide to Choosing the Right CPVC Cement for Hot Water Projects'],
            'excerpt_translations' => ['ar' => 'مقال يشرح كيف تختار التركيبة المناسبة حسب الحرارة والضغط والقطر.', 'en' => 'An article explaining how to choose the right formula based on temperature, pressure, and diameter.'],
        ]);

        Article::query()->where('slug', 'pipe-surface-preparation-best-practices')->update([
            'title_translations' => ['ar' => 'أفضل ممارسات تجهيز الأنابيب قبل اللصق', 'en' => 'Best Practices for Pipe Surface Preparation Before Bonding'],
            'excerpt_translations' => ['ar' => 'خطوات عملية لتجهيز السطح وضمان قوة الترابط ورفع كفاءة التركيب.', 'en' => 'Practical steps for preparing the surface and ensuring stronger bonding performance.'],
        ]);

        Testimonial::query()->where('sort_order', 1)->update([
            'quote_translations' => ['ar' => 'اعتمادنا على FLOW 714 في مشروعنا الأخير أثبت كفاءة عالية في تحمل الضغوط التشغيلية، وكانت جودة الترابط ممتازة.', 'en' => 'Using FLOW 714 in our recent project proved highly reliable under operating pressure, with excellent bonding quality.'],
        ]);

        Testimonial::query()->where('sort_order', 2)->update([
            'quote_translations' => ['ar' => 'سهولة التطبيق وسرعة التماسك في FLOW 500 ساعدتنا على تقليل وقت التركيب ورفع كفاءة التنفيذ.', 'en' => 'The easy application and quick setting time of FLOW 500 helped us reduce installation time and improve execution efficiency.'],
        ]);
    }
}

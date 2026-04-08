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
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
            ]
        );

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
                'name' => 'Plumbing Installation',
                'slug' => 'plumbing-installation',
                'sku' => 'PLUMB-01',
                'category' => 'Plumbing',
                'tagline' => 'خدمات تركيب سباكة احترافية للمشاريع السكنية والتجارية',
                'short_description' => 'تنفيذ وتمديد شبكات المياه والصرف الصحي باحترافية واعتمادية عالية.',
                'description' => 'نقدّم خدمات تركيب السباكة للمنازل والمنشآت التجارية، بما يشمل التأسيس والتركيب والاختبار والتشغيل، مع جودة تنفيذ عالية والتزام بالسلامة في جميع مراحل العمل.',
                'viscosity' => 'On-site installation',
                'standard' => 'Residential & Commercial',
                'max_diameter' => 'Full network coverage',
                'operating_temperature' => 'Scheduled response',
                'color' => 'Blue',
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
                'name' => 'Electrical Installation',
                'slug' => 'electrical-installation',
                'sku' => 'ELEC-01',
                'category' => 'Electrical',
                'tagline' => 'تنفيذ الأعمال الكهربائية بأعلى معايير السلامة',
                'short_description' => 'تمديدات كهربائية، لوحات توزيع، إنارة، ومخارج للمباني الجديدة وأعمال التطوير.',
                'description' => 'نوفر خدمات التركيب الكهربائي للمنازل والمنشآت التجارية، مع تنفيذ التمديدات وتركيب اللوحات والمخارج والإنارة وفق معايير مهنية تضمن السلامة والكفاءة التشغيلية.',
                'viscosity' => 'Installation & upgrades',
                'standard' => 'Safety-focused execution',
                'max_diameter' => 'Homes & businesses',
                'operating_temperature' => 'Flexible scheduling',
                'color' => 'Deep Blue',
                'badge' => 'خدمة شائعة',
                'accent_color' => 'blue',
                'image_url' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/500',
                'msds_url' => 'https://example.com/msds/500',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Fault Detection & Repair',
                'slug' => 'fault-detection-repair',
                'sku' => 'MAINT-01',
                'category' => 'Maintenance',
                'tagline' => 'كشف الأعطال الفنية وإصلاحها بسرعة ودقة',
                'short_description' => 'تشخيص مشاكل السباكة والكهرباء وتنفيذ الإصلاح المناسب في الوقت المناسب.',
                'description' => 'يتولى فريقنا كشف الأعطال المفاجئة والتسربات والمشكلات الكهربائية بدقة، ثم تنفيذ الإصلاحات اللازمة بسرعة واحترافية للحفاظ على سلامة الموقع واستمرارية التشغيل.',
                'viscosity' => 'Inspection & repair',
                'standard' => 'Fast technical support',
                'max_diameter' => 'Emergency & scheduled visits',
                'operating_temperature' => 'Rapid response',
                'color' => 'Light Blue',
                'badge' => 'استجابة سريعة',
                'accent_color' => 'yellow',
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80',
                'tds_url' => 'https://example.com/tds/p70',
                'msds_url' => 'https://example.com/msds/p70',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'General Maintenance Contracts',
                'slug' => 'general-maintenance-contracts',
                'sku' => 'SERV-02',
                'category' => 'Maintenance',
                'tagline' => 'عقود صيانة دورية للمباني والمرافق',
                'short_description' => 'زيارات دورية وأعمال وقائية وتصحيحية للحفاظ على كفاءة التشغيل وتقليل الأعطال.',
                'description' => 'نوفّر عقود صيانة مرنة تشمل الفحص الوقائي والمتابعة الدورية ومعالجة المشكلات الفنية في أنظمة السباكة والكهرباء والخدمات العامة للمباني والمنشآت.',
                'viscosity' => 'Preventive maintenance',
                'standard' => 'Scheduled service plans',
                'max_diameter' => 'Residential & commercial sites',
                'operating_temperature' => 'Monthly or custom visits',
                'color' => 'Soft Blue',
                'badge' => 'دعم مستمر',
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
            'title' => 'خدمات سباكة وكهرباء وصيانة باحترافية عالية',
            'subtitle' => 'شركة نفوذ المستقبل تقدم حلولاً فنية موثوقة للمنازل والمنشآت التجارية مع سرعة استجابة وجودة تنفيذ وخبرة ميدانية.',
            'variant' => 'hero',
            'anchor' => 'hero',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $hero->items()->create([
            'title' => 'ابدأ طلبك الآن',
            'subtitle' => 'حلول فنية سريعة وآمنة للمشاريع السكنية والتجارية',
            'description' => 'خدمات متكاملة في السباكة والأعمال الكهربائية والصيانة العامة بإشراف فريق فني محترف.',
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
                'site_tagline' => 'خدمات السباكة والكهرباء والصيانة الفنية',
                'logo_url' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?auto=format&fit=crop&w=300&q=80',
                'contact_email' => 'info@nofouthfuture.com',
                'contact_phone' => '+966 577252986',
                'contact_address' => 'الرياض - المملكة العربية السعودية',
                'map_embed_url' => 'https://www.google.com/maps?q=Riyadh&output=embed',
                'whatsapp_number' => '+966577252986',
                'vision' => 'أن نكون الخيار الأول في خدمات السباكة والكهرباء والصيانة الفنية للمشاريع السكنية والتجارية.',
                'mission' => 'تقديم خدمات فنية موثوقة وسريعة تركز على السلامة والجودة والالتزام، مع تجربة تواصل واضحة واحترافية لعملائنا.',
                'about_text' => 'شركة نفوذ المستقبل متخصصة في خدمات السباكة والأعمال الكهربائية والصيانة العامة، ونوفر حلولاً عملية تناسب احتياجات المنازل والمنشآت التجارية.',
                'footer_text' => 'جميع الحقوق محفوظة - شركة نفوذ المستقبل',
                'default_article_image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'default_meta_title' => 'شركة نفوذ المستقبل',
                'default_meta_description' => 'شركة نفوذ المستقبل لخدمات السباكة والكهرباء والصيانة الفنية للمنازل والمنشآت التجارية.',
                'default_meta_keywords' => 'سباكة, كهرباء, صيانة, خدمات فنية, كشف أعطال, طلب تسعيرة',
            ]
        );

        $featureSection = HomeSection::query()->create([
            'key' => 'why-us',
            'title' => 'لماذا شركة نفوذ المستقبل؟',
            'subtitle' => 'نقدّم خدمات فنية تعتمد على الخبرة والسرعة والالتزام بمعايير السلامة والجودة.',
            'variant' => 'cards',
            'anchor' => 'features',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $featureSection->items()->createMany([
            [
                'title' => 'تنفيذ احترافي',
                'description' => 'ننفذ الأعمال الميدانية بدقة عالية مع متابعة فنية تضمن جودة النتيجة من أول زيارة.',
                'icon' => '⚡',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'استجابة سريعة',
                'description' => 'نستجيب للأعطال والطلبات الطارئة بسرعة، مع تنظيم مواعيد مرن يناسب العملاء والمشاريع.',
                'icon' => '🔥',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'خبرة موثوقة',
                'description' => 'نعتمد على كوادر فنية خبيرة في أعمال السباكة والكهرباء والصيانة للمباني السكنية والتجارية.',
                'icon' => '👍',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ]);

        $statsSection = HomeSection::query()->create([
            'key' => 'stats',
            'title' => 'شركة نفوذ المستقبل في أرقام',
            'subtitle' => 'مؤشرات تعكس خبرتنا الميدانية وثقة عملائنا وجودة تنفيذنا.',
            'variant' => 'stats',
            'anchor' => 'stats',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $statsSection->items()->createMany([
            ['title' => '15+', 'metric' => '15+', 'metric_label' => 'عامًا من الخبرة', 'sort_order' => 1, 'is_active' => true],
            ['title' => '850+', 'metric' => '850+', 'metric_label' => 'مشروعًا منجزًا', 'sort_order' => 2, 'is_active' => true],
            ['title' => '24/7', 'metric' => '24/7', 'metric_label' => 'دعم واستجابة', 'sort_order' => 3, 'is_active' => true],
            ['title' => '98%', 'metric' => '98%', 'metric_label' => 'رضا العملاء', 'sort_order' => 4, 'is_active' => true],
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
                'description' => 'أن نكون الخيار الأول للخدمات الفنية المتكاملة في السباكة والكهرباء والصيانة.',
                'icon' => '🎯',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'الرسالة التنفيذية',
                'description' => 'تقديم خدمات موثوقة وسريعة تساعد العملاء على معالجة الأعطال وتنفيذ الأعمال بكفاءة وأمان.',
                'icon' => '⚙️',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'الالتزام البيئي',
                'description' => 'الالتزام بأساليب عمل آمنة ومنظمة تقلل المخاطر وتحافظ على سلامة الموقع والمستفيدين.',
                'icon' => '🌱',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ]);

        $aboutHeroSection = HomeSection::query()->create([
            'page' => 'about',
            'key' => 'about-hero',
            'title' => 'رسالتنا ورؤيتنا',
            'subtitle' => 'نقدّم خدمات فنية موثوقة في السباكة والكهرباء والصيانة العامة بخبرة عملية وفريق مؤهل.',
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
                'title' => 'متى تحتاج إلى فني سباكة محترف؟',
                'slug' => 'professional-plumbing-service-guide',
                'excerpt' => 'دليل عملي يساعدك على معرفة الحالات التي تتطلب تدخلاً فنيًا سريعًا في أعمال السباكة.',
                'body' => 'يشرح هذا المقال أبرز العلامات التي تشير إلى الحاجة لفني سباكة محترف، مثل التسربات المتكررة وضعف ضغط المياه وانسداد الصرف ومشكلات التمديدات الداخلية، مع نصائح تساعد على تقليل الأعطال قبل تفاقمها.',
                'cover_image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/cpvc-guide.pdf',
                'meta_title' => 'متى تحتاج إلى فني سباكة محترف؟',
                'meta_description' => 'إرشادات تساعدك على معرفة الوقت المناسب لطلب خدمة سباكة احترافية.',
                'meta_keywords' => 'سباكة, كشف تسربات, صيانة سباكة, خدمات فنية',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'sort_order' => 1,
            ],
            [
                'title' => 'أساسيات السلامة في الأعمال الكهربائية المنزلية',
                'slug' => 'electrical-safety-best-practices',
                'excerpt' => 'خطوات مهمة لرفع مستوى الأمان أثناء تنفيذ أو صيانة الأعمال الكهربائية في المنزل أو المنشأة.',
                'body' => 'يعرض هذا المقال أهم ممارسات السلامة في الأعمال الكهربائية، مثل فحص الأحمال، والتأكد من العزل، والالتزام بالمقاسات الصحيحة، والاستعانة بفني مؤهل عند ظهور الأعطال أو الحاجة إلى تعديلات على الشبكة.',
                'cover_image' => 'https://images.unsplash.com/photo-1581092918484-8313c7f0f0df?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/preparation.pdf',
                'meta_title' => 'أساسيات السلامة في الأعمال الكهربائية المنزلية',
                'meta_description' => 'تعرف على أهم إرشادات السلامة عند تنفيذ أو صيانة الأعمال الكهربائية.',
                'meta_keywords' => 'كهرباء, سلامة كهربائية, صيانة كهربائية, فني كهرباء',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'sort_order' => 2,
            ],
            [
                'title' => 'كيف تختار عقد الصيانة المناسب لمنشأتك؟',
                'slug' => 'how-to-choose-maintenance-contract',
                'excerpt' => 'مقارنة عملية بين أنواع عقود الصيانة وما يناسب المباني السكنية والتجارية.',
                'body' => 'يستعرض هذا المقال الفروقات بين عقود الصيانة الدورية والوقائية والتصحيحية، وكيف يساعد اختيار الخطة المناسبة في تقليل الأعطال ورفع كفاءة التشغيل وتحسين سرعة الاستجابة للمشكلات الفنية.',
                'cover_image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1200&q=80',
                'download_url' => 'https://example.com/articles/comparison.pdf',
                'meta_title' => 'كيف تختار عقد الصيانة المناسب لمنشأتك؟',
                'meta_description' => 'دليل مبسط لاختيار عقد الصيانة الأنسب حسب طبيعة المبنى واحتياجات التشغيل.',
                'meta_keywords' => 'عقد صيانة, صيانة دورية, صيانة وقائية, خدمات فنية',
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
                'quote' => 'الفريق كان منظمًا وسريع الاستجابة، وتم تنفيذ أعمال السباكة في المشروع بجودة عالية ومتابعة احترافية.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'فريق الصيانة',
                'client_title' => 'إدارة التشغيل',
                'company_name' => 'مصنع السخانات المركزية',
                'quote' => 'خدمة الصيانة الكهربائية كانت دقيقة واحترافية، وتمت معالجة الأعطال بسرعة مع التزام واضح بالسلامة.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'م. سارة العلي',
                'client_title' => 'مقاول مشاريع',
                'company_name' => 'قطاع البنية التحتية',
                'quote' => 'وجدنا من شركة نفوذ المستقبل التزامًا ممتازًا في أعمال الصيانة الدورية، مع تقارير واضحة وسرعة في التنفيذ.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ] as $testimonial) {
            Testimonial::query()->create($testimonial);
        }

        $quote = QuoteRequest::query()->create([
            'company_name' => 'شركة الدبعي للتطوير',
            'contact_person' => 'أحمد الدبعي',
            'email' => 'sales@example.com',
            'phone' => '0555555555',
            'notes' => 'نحتاج عرض سعر لخدمات سباكة وكهرباء وصيانة لمبنى تجاري في الرياض.',
            'status' => 'new',
        ]);

        $quote->items()->createMany([
            [
                'product_id' => Product::query()->where('sku', 'PLUMB-01')->value('id'),
                'product_name' => 'Plumbing Installation',
                'quantity' => 120,
                'unit' => 'وحدة',
            ],
            [
                'product_id' => Product::query()->where('sku', 'MAINT-01')->value('id'),
                'product_name' => 'Fault Detection & Repair',
                'quantity' => 40,
                'unit' => 'زيارة',
            ],
        ]);

        ContactMessage::query()->create([
            'name' => 'مؤسسة الخليج للمقاولات',
            'email' => 'info@gulf-contracting.test',
            'subject' => 'استفسار فني',
            'message' => 'هل يمكنكم إرسال عرض لخدمات كشف الأعطال والصيانة الكهربائية لمبنى تجاري؟',
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

<?php

use App\SubTopic;
use App\Thematic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThematicSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $finanzas =Thematic::create([
            'name' => 'Finanzas y contabilidad',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Contabilidad y tesorería',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Criptomonedas y blockchain',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Finanzas',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Certificación financiera y preparación de examenes',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Modelos y análisis financieros',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Inversión y comercio',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Cumplimiento de normas',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Economía',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Herramientas de gestión monetaria',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Impuestos',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Finanzas y contabilidad, otros',
            'thematic_id' => $finanzas->id,
            'state' => 1
        ]);

        $programacion =Thematic::create([
            'name' => 'Programación',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Ciencias de la información',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Desarrollo sin código',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Desarrollo web',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Desarrollo móvil',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Lenguajes de programación',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Desarrollo de videojuegos',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño y desarrollo de bases de datos',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Testeo de software',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Ingeniería de software',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Herramientas de desarrollo',
            'thematic_id' => $programacion->id,
            'state' => 1
        ]);

        $negocios=Thematic::create([
            'name' => 'Negocios',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Emprendimiento',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Comunicación',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Gestión empresarial',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Ventas',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Estrategia de negocios',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Operaciones',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Gestión de proyectos',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho empresarial',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Comercio electrónico',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Analítica e inteligencia empresarial',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Recursos humanos',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Industria',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Medios de comunicación',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Bienes inmuebles',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Negocios, otros',
            'thematic_id' => $negocios->id,
            'state' => 1
        ]);


        $informatica=Thematic::create([
            'name' => 'Informática y software',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Certificaciones de TI',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Redes',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Seguridad Informática',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Hardware',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Sistemas Operativos',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Informática y software, otros',
            'thematic_id' => $informatica->id,
            'state' => 1
        ]);

        $oficina=Thematic::create([
            'name' => 'Productividad en la oficina',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Microsoft',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Apple',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Google',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'SAP',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Oracle',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Otros',
            'thematic_id' => $oficina->id,
            'state' => 1
        ]);

        $desarrollo=Thematic::create([
            'name' => 'Desarrollo personal',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Transformación personal',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Productividad personal',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Liderazgo',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Desarrollo profesional',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Paternidad y relaciones',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Felicidad',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Religión y espiritualidad',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Desarrollo de marca personal',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Creatividad',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Influencia',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Autoestima y confianza',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Gestión del estrés',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Memoria y técnicas de estudio',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Motivación',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Otros',
            'thematic_id' => $desarrollo->id,
            'state' => 1
        ]);

        $derecho=Thematic::create([
            'name' => 'Derecho',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Civil',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Familiar',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Penal',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Internacional',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Corporativo o Empresarial',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Mercantil',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Tributario',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Derecho Laboral',
            'thematic_id' => $derecho->id,
            'state' => 1
        ]);


        $diseno=Thematic::create([
            'name' => 'Diseño',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño web',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño gráfico e ilustración',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Herramientas de diseño',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño de experiencia de usuario',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño de juegos',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño web',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Design thinking',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño de moda',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño arquitectónico',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño de interiores',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño, otros',
            'thematic_id' => $diseno->id,
            'state' => 1
        ]);

        $marketing=Thematic::create([
            'name' => 'Marketing y e-commerce',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Marketing digital',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Optimización de motores de búsqueda',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Marketing de redes sociales',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Creación de marca',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Fundamentos de marketing',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Automatización y análisis de marketing',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Relaciones públicas',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Publicidad',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Marketing con video y móviles',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Marketing de contenidos',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Estrategia de posicionamiento',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Marketing de afiliados',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Marketing de producto',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Marketing, otros',
            'thematic_id' => $marketing->id,
            'state' => 1
        ]);


        $estilos=Thematic::create([
            'name' => 'Estilo de vida',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Prácticas esotéricas',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Artes y manualidades',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Comida y bebida',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Belleza y maquillaje',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Viajes',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Juegos',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Bricolaje',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Cuidado y entrenamiento de mascotas',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Estilo de vida, otros',
            'thematic_id' => $estilos->id,
            'state' => 1
        ]);

        $foto=Thematic::create([
            'name' => 'Fotografía y video',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Fotografía digital',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Fotografía',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Retratos fotográficos',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Herramientas de fotografía',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Fotografía comercial',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diseño de video',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Fotografía y video, otros',
            'thematic_id' => $foto->id,
            'state' => 1
        ]);

        $salud=Thematic::create([
            'name' => 'Salud y fitness',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Fitness',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Salud general',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Deportes',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Nutrición',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Yoga',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Salud mental',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Dietética',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Defensa personal',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Seguridad y primeros auxilios',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Baile',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Meditación',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Salud y fitness, otros',
            'thematic_id' => $salud->id,
            'state' => 1
        ]);

        $medicina=Thematic::create([
            'name' => 'Medicina',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Acupunturistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Alergólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Algólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Anatomopatólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Anestesiólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Angiólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Audiólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Cardiólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Cirujanos Estéticos y Cosméticos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Cirujanos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        SubTopic::create([
            'name' => 'Dentistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Dermatólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Diabetólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Endocrinólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Fisioterapeutas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Gastroenterólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Geriatras',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Ginecólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Homeópatas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Infectólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Inmunólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Internistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Médicos Generales',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Naturistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Nefrólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Neonatólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Neumólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Neurocirujanos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Neurólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Nutricionistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Nutriólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Oftalmólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Optometristas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Ortopedistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Otorrinolaringólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Pediatras',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Podiatras',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Podólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Proctólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Psicoanalistas',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Psicólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Psiquiatras',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Quiroprácticos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Radiólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Reumatólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Sexólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Traumatólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Urólogos',
            'thematic_id' => $medicina->id,
            'state' => 1
        ]);


        $musica=Thematic::create([
            'name' => 'Música',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Instrumentos',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Producción musical',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Fundamentos sobre música',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Vocal',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Técnicas musicales',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Software de música',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Música, otros',
            'thematic_id' => $musica->id,
            'state' => 1
        ]);

        $ensenanza=Thematic::create([
            'name' => 'Enseñanzas y disciplinas académicas',
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Ingeniería',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Humanidades',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Matemáticas',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Educación en línea',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Ciencia',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Idioma',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Formación de profesorado',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Preparación para exámenes oficiales',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);
        SubTopic::create([
            'name' => 'Enseñanzas y disciplinas académicas, otros',
            'thematic_id' => $ensenanza->id,
            'state' => 1
        ]);

        DB::table('interests')->insert([
            'name'  => 'Finanzas y contabilidad',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Programación',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Negocios',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Informática y software',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Productividad en la oficina',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Desarrollo personal',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Derecho',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Diseño',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Marketing y e-commerce',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Estilo de vida',
            'state' => 1,
        ]);
        DB::table('interests')->insert([
            'name'  => 'Fotografía y video',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Salud y fitness',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Medicina',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Música',
            'state' => 1,
        ]);

        DB::table('interests')->insert([
            'name'  => 'Enseñanzas y disciplinas académicas',
            'state' => 1,
        ]);
    }
}

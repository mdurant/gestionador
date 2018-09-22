<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initalization extends Migration
{
  public function up()
  {
    Schema::create('clients', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('last_name');
      $table->string('email')->unique();
      $table->string('rut')->unique();
      $table->string('company');
      $table->string('giro');
      $table->string('phone');
      $table->string('website');
      $table->string('commercial_contact');
      $table->string('phone_commercial_contact');
      $table->string('email_commercial_contact');
      $table->string('address_office');
      $table->integer('comuna_id')->unique();
      $table->boolean('status')->default(false);
      $table->timestamps();
    });

    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->decimal('price', 10, 2);
      $table->text('description');
      $table->enum('choices', array('service', 'article', 'material'));
      $table->string('barcode')->unique();
      $table->integer('measured_unit_id');
      $table->integer('category_id');
      $table->boolean('status')->default(false);
      $table->timestamps();
    });

    Schema::create('sales_invoices', function (Blueprint $table) {
      $table->increments('id');
      $table->string('contador')->unique();
      $table->string('folio');
      $table->dateTime('invoice_date');
      $table->integer('quota_id')->default(1);
      $table->text('comment');
      $table->decimal('iva', 10, 2);
      $table->decimal('subTotal', 10, 2);
      $table->decimal('total', 10, 2);
      $table->timestamps();
    });

    Schema::create('detail_sales_invoice', function (Blueprint $table) {
      $table->decimal('quantity', 10, 2);
      $table->string('description');
      $table->integer('store_id');
      $table->integer('discount');
      $table->decimal('unitPrice', 10, 2);
      $table->decimal('total', 10, 2);
      $table->timestamps();
    });

    Schema::create('comunas', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('provincia_id');
      $table->timestamps();
    });

    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });

    Schema::create('stores', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });

    Schema::create('quotas', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->timestamps();
    });

    Schema::create('measured_units', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('code');
      $table->timestamps();
    });

        // Foreign keys
    Schema::table('sales_invoices', function ($table) {
      $table->integer('client_id')->unsigned();
      $table->foreign('client_id')->references('id')->on('clients');
    });

    Schema::table('detail_sales_invoice', function ($table) {
      $table->integer('invoice_id')->unsigned();
      $table->integer('product_id')->unsigned();

      $table->foreign('invoice_id')->references('id')->on('sales_invoices');
      $table->foreign('product_id')->references('id')->on('products');
    });

        // Default data
    DB::table('clients')->insert([
      [
        'name' => 'Constructura Altura S.A.', 'last_name' => 'Constructora Altura', 'email' => 'correo@altura.cl', 'rut' => '1-9',
        'company' => 'Altura Construcciones', 'giro' => 'Constructora', 'phone' => '12121212', 'website' => 'www.altura.cl', 'commercial_contact' => 'Nombre Agente Comercial', 'phone_commercial_contact' => '2322323', 'email_commercial_contact' => 'comercial@altura.cl', 'address_office' => 'Av. Los Calamares 107', 'comuna_id' => 108
      ]

    ]);

    DB::table('products')->insert([
      [
        'name' => 'Martillo Eléctrico Genérico', 'price' => 50000, 'description' => 'Martillo Eléctrico', 'choices' => 'article', 'barcode' => '780541450', 'measured_unit_id' => 1, 'category_id' => 1
      ],

      [
        'name' => 'ABRAZADERA INOX 32 MM', 'price' => 4500, 'description' => 'ABRAZADERA INOX 32 MM', 'choices' => 'article', 'barcode' => '780231450', 'measured_unit_id' => 1, 'category_id' => 1
      ],
      [
        'name' => 'ABRAZADERA INOX DN 40	', 'price' => 4580, 'description' => 'ABRAZADERA INOX DN 40', 'choices' => 'article', 'barcode' => '781131450', 'measured_unit_id' => 1, 'category_id' => 1
      ],
      [
        'name' => 'ACIDO GEL DECAPANTE 2 LT. THYTAN TS K 2000', 'price' => 43000, 'description' => 'ACIDO GEL DECAPANTE 2 LT. THYTAN TS K 2000', 'choices' => 'article', 'barcode' => '781551450', 'measured_unit_id' => 1, 'category_id' => 1
      ],
      [
        'name' => 'SERVICIO DE PERFORACIONES PARA GALVANIZADO ', 'price ' => 43000, 'description ' => 'SERVICIO DE PERFORACIONES PARA GALVANIZADO ', 'choices ' => 'service', 'barcode ' => '7815111450 ', 'measured_unit_id ' => 1, 'category_id ' => 1
      ],
      [
        'name' => 'SERVICIO DE TRASLADO AEROPUERTO', 'price ' => 17000, 'description ' => 'SERVICIO DE TRASLADO AEROPUERTO', 'choices ' => 'service ', 'barcode ' => '7811111450', 'measured_unit_id ' => 1, 'category_id ' => 1
      ]

    ]);

    DB::table('categories')->insert([
      ['name' => 'Eléctrico'],
      ['name' => 'Frenos'],
      ['name' => 'Rodamientos'],
      ['name' => 'Aire Acondicionado'],
      ['name' => 'Vehículos Menores'],
      ['name' => 'Motos'],

    ]);

    DB::table('stores')->insert([
      ['name' => 'Bodega Central'],
      ['name' => 'Bodega Mermas'],
      ['name' => 'Bodega Servicios'],
      ['name' => 'Bodega Interna'],
      ['name' => 'Bodega Transitoria'],

    ]);

    DB::table('quotas')->insert([
      ['name' => '0 Días'],
      ['name' => '30 Días'],
      ['name' => '60 Días'],
      ['name' => '90 Días'],
      ['name' => '120 Días'],
      ['name' => '180 Días'],
    ]);

    DB::table('measured_units')->insert([
      ['name' => 'Cada Uno', 'code' => 'UN'],
      ['name' => 'Litros', 'code' => 'LT'],
      ['name' => 'Kilos', 'code' => 'KG'],
      ['name' => 'Cada Uno', 'code' => 'UN'],
    ]);

    DB::table('comunas')->insert([
      ['name' => 'Puerto Octay', 'provincia_id' => '1'],
      ['name' => 'Río Negro', 'provincia_id' => '1'],
      ['name' => 'Puerto Octay', 'provincia_id' => '1'],
      ['name' => 'Río Negro', 'provincia_id' => '1'],
      ['name' => 'San Juan de la Costa', 'provincia_id' => '1'],
      ['name' => 'San Pablo', 'provincia_id' => '1'],
      ['name' => 'Calbuco', 'provincia_id' => '2'],
      ['name' => 'Cochamó', 'provincia_id' => '2'],
      ['name' => 'Fresia', 'provincia_id' => '2'],
      ['name' => 'Frutillar', 'provincia_id' => '2'],
      ['name' => 'Llanquihue', 'provincia_id' => '2'],
      ['name' => 'Los Muermos', 'provincia_id' => '2'],
      ['name' => 'Maullín', 'provincia_id' => '2'],
      ['name' => 'Puerto Montt', 'provincia_id' => '2'],
      ['name' => 'Puerto Varas', 'provincia_id' => '2'],
      ['name' => 'Castro', 'provincia_id' => '3'],
      ['name' => 'Chonchi', 'provincia_id' => '3'],
      ['name' => 'Curaco de Vélez', 'provincia_id' => '3'],
      ['name' => 'Dalcahue', 'provincia_id' => '3'],
      ['name' => 'Puqueldón', 'provincia_id' => '3'],
      ['name' => 'Queilén', 'provincia_id' => '3'],
      ['name' => 'Quemchi', 'provincia_id' => '3'],
      ['name' => 'Quellón', 'provincia_id' => '3'],
      ['name' => 'Quinchao', 'provincia_id' => '3'],
      ['name' => 'Chaitén', 'provincia_id' => '4'],
      ['name' => 'Futaleufú', 'provincia_id' => '4'],
      ['name' => 'Hualaihué', 'provincia_id' => '4'],
      ['name' => 'Palena', 'provincia_id' => '4'],
      ['name' => 'Camarones', 'provincia_id' => '6'],
      ['name' => 'Putre', 'provincia_id' => '7'],
      ['name' => 'General Lagos', 'provincia_id' => '7'],
      ['name' => 'Iquique', 'provincia_id' => '8'],
      ['name' => 'Pozo Almonte', 'provincia_id' => '9'],
      ['name' => 'Camiña', 'provincia_id' => '9'],
      ['name' => 'Colchane', 'provincia_id' => '9'],
      ['name' => 'Huara', 'provincia_id' => '9'],
      ['name' => 'Pica', 'provincia_id' => '9'],
      ['name' => 'Tocopilla', 'provincia_id' => '10'],
      ['name' => 'María Elena', 'provincia_id' => '10'],
      ['name' => 'Calama', 'provincia_id' => '11'],
      ['name' => 'Ollagüe', 'provincia_id' => '11'],
      ['name' => 'San Pedro de Atacama', 'provincia_id' => '11'],
      ['name' => 'Mejillones', 'provincia_id' => '12'],
      ['name' => 'Sierra Gorda', 'provincia_id' => '12'],
      ['name' => 'Taltal', 'provincia_id' => '12'],
      ['name' => 'Chañaral', 'provincia_id' => '13'],
      ['name' => 'Diego de Almagro', 'provincia_id' => '13'],
      ['name' => 'Copiapó', 'provincia_id' => '14'],
      ['name' => 'Caldera', 'provincia_id' => '14'],
      ['name' => 'Tierra Amarilla', 'provincia_id' => '14'],
      ['name' => 'Vallenar', 'provincia_id' => '15'],
      ['name' => 'Freirina', 'provincia_id' => '15'],
      ['name' => 'Huasco', 'provincia_id' => '15'],
      ['name' => 'La Serena', 'provincia_id' => '16'],
      ['name' => 'Coquimbo', 'provincia_id' => '16'],
      ['name' => 'La Higuera', 'provincia_id' => '16'],
      ['name' => 'Paiguano', 'provincia_id' => '16'],
      ['name' => 'Vicuña', 'provincia_id' => '16'],
      ['name' => 'Ovalle', 'provincia_id' => '17'],
      ['name' => 'Combarbalá', 'provincia_id' => '17'],
      ['name' => 'Monte Patria', 'provincia_id' => '17'],
      ['name' => 'Punitaqui', 'provincia_id' => '17'],
      ['name' => 'Río Hurtado', 'provincia_id' => '17'],
      ['name' => 'Illapel', 'provincia_id' => '18'],
      ['name' => 'Canela', 'provincia_id' => '18'],
      ['name' => 'Los Vilos', 'provincia_id' => '18'],
      ['name' => 'Salamanca', 'provincia_id' => '18'],
      ['name' => 'La Ligua', 'provincia_id' => '19'],
      ['name' => 'Cabildo', 'provincia_id' => '19'],
      ['name' => 'Papudo', 'provincia_id' => '19'],
      ['name' => 'Petorca', 'provincia_id' => '19'],
      ['name' => 'Zapallar', 'provincia_id' => '19'],
      ['name' => 'Los Andes', 'provincia_id' => '20'],
      ['name' => 'Calle Larga', 'provincia_id' => '20'],
      ['name' => 'Rinconada', 'provincia_id' => '20'],
      ['name' => 'San Esteban', 'provincia_id' => '20'],
      ['name' => 'San Felipe', 'provincia_id' => '21'],
      ['name' => 'Catemu', 'provincia_id' => '21'],
      ['name' => 'Llaillay', 'provincia_id' => '21'],
      ['name' => 'Panquehue', 'provincia_id' => '21'],
      ['name' => 'Putaendo', 'provincia_id' => '21'],
      ['name' => 'Santa María', 'provincia_id' => '21'],
      ['name' => 'Quillota', 'provincia_id' => '22'],
      ['name' => 'Calera', 'provincia_id' => '22'],
      ['name' => 'Hijuelas', 'provincia_id' => '22'],
      ['name' => 'La Cruz', 'provincia_id' => '22'],
      ['name' => 'Limache', 'provincia_id' => '26'],
      ['name' => 'Nogales', 'provincia_id' => '22'],
      ['name' => 'Olmué', 'provincia_id' => '26'],
      ['name' => 'Valparaíso', 'provincia_id' => '23'],
      ['name' => 'Casablanca', 'provincia_id' => '23'],
      ['name' => 'Concón', 'provincia_id' => '23'],
      ['name' => 'Juan Fernández', 'provincia_id' => '23'],
      ['name' => 'Puchuncaví', 'provincia_id' => '23'],
      ['name' => 'Quilpué', 'provincia_id' => '26'],
      ['name' => 'Quintero', 'provincia_id' => '23'],
      ['name' => 'Villa Alemana', 'provincia_id' => '26'],
      ['name' => 'Viña del Mar', 'provincia_id' => '23'],
      ['name' => 'San Antonio', 'provincia_id' => '24'],
      ['name' => 'Cartagena', 'provincia_id' => '24'],
      ['name' => 'El Quisco', 'provincia_id' => '24'],
      ['name' => 'El Tabo', 'provincia_id' => '24'],
      ['name' => 'Santo Domingo', 'provincia_id' => '24'],
      ['name' => 'Isla de Pascua', 'provincia_id' => '25'],
      ['name' => 'Colina', 'provincia_id' => '27'],
      ['name' => 'Lampa', 'provincia_id' => '27'],
      ['name' => 'Tiltil', 'provincia_id' => '27'],
      ['name' => 'Santiago', 'provincia_id' => '28'],
      ['name' => 'Cerrillos', 'provincia_id' => '28'],
      ['name' => 'Cerro Navia', 'provincia_id' => '28'],
      ['name' => 'Conchalí', 'provincia_id' => '28'],
      ['name' => 'El Bosque', 'provincia_id' => '28'],
      ['name' => 'Estación Central', 'provincia_id' => '28'],
      ['name' => 'Huechuraba', 'provincia_id' => '28'],
      ['name' => 'Independencia', 'provincia_id' => '28'],
      ['name' => 'La Cisterna', 'provincia_id' => '28'],
      ['name' => 'La FlorIDnamea', 'provincia_id' => '28'],
      ['name' => 'La Granja', 'provincia_id' => '28'],
      ['name' => 'La Pintana', 'provincia_id' => '28'],
      ['name' => 'La Reina', 'provincia_id' => '28'],
      ['name' => 'Las Condes', 'provincia_id' => '28'],
      ['name' => 'Lo Barnechea', 'provincia_id' => '28'],
      ['name' => 'Lo Espejo', 'provincia_id' => '28'],
      ['name' => 'Lo Prado', 'provincia_id' => '28'],
      ['name' => 'Macul', 'provincia_id' => '28'],
      ['name' => 'Maipú', 'provincia_id' => '28'],
      ['name' => 'Ñuñoa', 'provincia_id' => '28'],
      ['name' => 'Pedro Aguirre Cerda', 'provincia_id' => '28'],
      ['name' => 'Peñalolén', 'provincia_id' => '28'],
      ['name' => 'ProvIDnameencia', 'provincia_id' => '28'],
      ['name' => 'Pudahuel', 'provincia_id' => '28'],
      ['name' => 'Quilicura', 'provincia_id' => '28'],
      ['name' => 'Quinta Normal', 'provincia_id' => '28'],
      ['name' => 'Recoleta', 'provincia_id' => '28'],
      ['name' => 'Renca', 'provincia_id' => '28'],
      ['name' => 'San Joaquín', 'provincia_id' => '28'],
      ['name' => 'San Miguel', 'provincia_id' => '28'],
      ['name' => 'San Ramón', 'provincia_id' => '28'],
      ['name' => 'Vitacura', 'provincia_id' => '28'],
      ['name' => 'Puente Alto', 'provincia_id' => '29'],
      ['name' => 'Pirque', 'provincia_id' => '29'],
      ['name' => 'San José de Maipú', 'provincia_id' => '29'],
      ['name' => 'San Bernardo', 'provincia_id' => '30'],
      ['name' => 'Calera de Tango', 'provincia_id' => '30'],
      ['name' => 'Paine', 'provincia_id' => '30'],
      ['name' => 'Melipilla', 'provincia_id' => '31'],
      ['name' => 'Curacaví', 'provincia_id' => '31'],
      ['name' => 'María Pinto', 'provincia_id' => '31'],
      ['name' => 'San Pedro', 'provincia_id' => '31'],
      ['name' => 'Talagante', 'provincia_id' => '32'],
      ['name' => 'El Monte', 'provincia_id' => '32'],
      ['name' => 'Isla de Maipo', 'provincia_id' => '32'],
      ['name' => 'Padre Hurtado', 'provincia_id' => '32'],
      ['name' => 'Peñaflor', 'provincia_id' => '32'],
      ['name' => 'Rancagua', 'provincia_id' => '33'],
      ['name' => 'Codegua', 'provincia_id' => '33'],
      ['name' => 'Coinco', 'provincia_id' => '33'],
      ['name' => 'Coltauco', 'provincia_id' => '33'],
      ['name' => 'Doñihue', 'provincia_id' => '33'],
      ['name' => 'Graneros', 'provincia_id' => '33'],
      ['name' => 'Las Cabras', 'provincia_id' => '33'],
      ['name' => 'Machalí', 'provincia_id' => '33'],
      ['name' => 'Malloa', 'provincia_id' => '33'],
      ['name' => 'Mostazal', 'provincia_id' => '33'],
      ['name' => 'Olivar', 'provincia_id' => '33'],
      ['name' => 'Peumo', 'provincia_id' => '33'],
      ['name' => 'PichIDnameegua', 'provincia_id' => '33'],
      ['name' => 'Quinta de Tilcoco', 'provincia_id' => '33'],
      ['name' => 'Rengo', 'provincia_id' => '33'],
      ['name' => 'Requínoa', 'provincia_id' => '33'],
      ['name' => 'San Vicente', 'provincia_id' => '33'],
      ['name' => 'San Fernando', 'provincia_id' => '34'],
      ['name' => 'Chépica', 'provincia_id' => '34'],
      ['name' => 'Chimbarongo', 'provincia_id' => '34'],
      ['name' => 'Lolol', 'provincia_id' => '34'],
      ['name' => 'Nancagua', 'provincia_id' => '34'],
      ['name' => 'Palmilla', 'provincia_id' => '34'],
      ['name' => 'Peralillo', 'provincia_id' => '34'],
      ['name' => 'Placilla', 'provincia_id' => '34'],
      ['name' => 'Pumanque', 'provincia_id' => '34'],
      ['name' => 'Santa Cruz', 'provincia_id' => '34'],
      ['name' => 'Pichilemu', 'provincia_id' => '35'],
      ['name' => 'La Estrella', 'provincia_id' => '35'],
      ['name' => 'Litueche', 'provincia_id' => '35'],
      ['name' => 'Marchihue', 'provincia_id' => '35'],
      ['name' => 'NavIDnamead', 'provincia_id' => '35'],
      ['name' => 'Paredones', 'provincia_id' => '35'],
      ['name' => 'Curicó', 'provincia_id' => '36'],
      ['name' => 'Hualañé', 'provincia_id' => '36'],
      ['name' => 'Licantén', 'provincia_id' => '36'],
      ['name' => 'Molina', 'provincia_id' => '36'],
      ['name' => 'Rauco', 'provincia_id' => '36'],
      ['name' => 'Romeral', 'provincia_id' => '36'],
      ['name' => 'Sagrada Familia', 'provincia_id' => '36'],
      ['name' => 'Teno', 'provincia_id' => '36'],
      ['name' => 'Vichuquén', 'provincia_id' => '36'],
      ['name' => 'Talca', 'provincia_id' => '37'],
      ['name' => 'Constitución', 'provincia_id' => '37'],
      ['name' => 'Curepto', 'provincia_id' => '37'],
      ['name' => 'Empedrado', 'provincia_id' => '37'],
      ['name' => 'Maule', 'provincia_id' => '37'],
      ['name' => 'Pelarco', 'provincia_id' => '37'],
      ['name' => 'Pencahue', 'provincia_id' => '37'],
      ['name' => 'Río Claro', 'provincia_id' => '37'],
      ['name' => 'San Clemente', 'provincia_id' => '37'],
      ['name' => 'San Rafael', 'provincia_id' => '37'],
      ['name' => 'Linares', 'provincia_id' => '38'],
      ['name' => 'Colbún', 'provincia_id' => '38'],
      ['name' => 'Longaví', 'provincia_id' => '38'],
      ['name' => 'Parral', 'provincia_id' => '38'],
      ['name' => 'Retiro', 'provincia_id' => '38'],
      ['name' => 'San Javier', 'provincia_id' => '38'],
      ['name' => 'Villa Alegre', 'provincia_id' => '38'],
      ['name' => 'Yerbas Buenas', 'provincia_id' => '38'],
      ['name' => 'Cauquenes', 'provincia_id' => '39'],
      ['name' => 'Chanco', 'provincia_id' => '39'],
      ['name' => 'Pelluhue', 'provincia_id' => '39'],
      ['name' => 'Chillán', 'provincia_id' => '40'],
      ['name' => 'Bulnes', 'provincia_id' => '40'],
      ['name' => 'Cobquecura', 'provincia_id' => '40'],
      ['name' => 'Coelemu', 'provincia_id' => '40'],
      ['name' => 'Coihueco', 'provincia_id' => '40'],
      ['name' => 'Chillán Viejo', 'provincia_id' => '40'],
      ['name' => 'El Carmen', 'provincia_id' => '40'],
      ['name' => 'Ninhue', 'provincia_id' => '40'],
      ['name' => 'Ñiquén', 'provincia_id' => '40'],
      ['name' => 'Pemuco', 'provincia_id' => '40'],
      ['name' => 'Pinto', 'provincia_id' => '40'],
      ['name' => 'Portezuelo', 'provincia_id' => '40'],
      ['name' => 'Quillón', 'provincia_id' => '40'],
      ['name' => 'Quirihue', 'provincia_id' => '40'],
      ['name' => 'Ránquil', 'provincia_id' => '40'],
      ['name' => 'San Carlos', 'provincia_id' => '40'],
      ['name' => 'San Fabián', 'provincia_id' => '40'],
      ['name' => 'San Ignacio', 'provincia_id' => '40'],
      ['name' => 'San Nicolás', 'provincia_id' => '40'],
      ['name' => 'Treguaco', 'provincia_id' => '40'],
      ['name' => 'Yungay', 'provincia_id' => '40'],
      ['name' => 'Los Angeles', 'provincia_id' => '41'],
      ['name' => 'Cabrero', 'provincia_id' => '41'],
      ['name' => 'Laja', 'provincia_id' => '41'],
      ['name' => 'Mulchén', 'provincia_id' => '41'],
      ['name' => 'Nacimiento', 'provincia_id' => '41'],
      ['name' => 'Negrete', 'provincia_id' => '41'],
      ['name' => 'Quilaco', 'provincia_id' => '41'],
      ['name' => 'Quilleco', 'provincia_id' => '41'],
      ['name' => 'San Rosendo', 'provincia_id' => '41'],
      ['name' => 'Santa Bárbara', 'provincia_id' => '41'],
      ['name' => 'Tucapel', 'provincia_id' => '41'],
      ['name' => 'Yumbel', 'provincia_id' => '41'],
      ['name' => 'Concepción', 'provincia_id' => '42'],
      ['name' => 'Coronel', 'provincia_id' => '42'],
      ['name' => 'Chiguayante', 'provincia_id' => '42'],
      ['name' => 'FlorIDnamea', 'provincia_id' => '42'],
      ['name' => 'Hualqui', 'provincia_id' => '42'],
      ['name' => 'Lota', 'provincia_id' => '42'],
      ['name' => 'Penco', 'provincia_id' => '42'],
      ['name' => 'San Pedro de la Paz', 'provincia_id' => '42'],
      ['name' => 'Santa Juana', 'provincia_id' => '42'],
      ['name' => 'Talcahuano', 'provincia_id' => '42'],
      ['name' => 'Tomé', 'provincia_id' => '42'],
      ['name' => 'Hualpén', 'provincia_id' => '42'],
      ['name' => 'Lebu', 'provincia_id' => '43'],
      ['name' => 'Cañete', 'provincia_id' => '43'],
      ['name' => 'Contulmo', 'provincia_id' => '43'],
      ['name' => 'Curanilahue', 'provincia_id' => '43'],
      ['name' => 'Los Alamos', 'provincia_id' => '43'],
      ['name' => 'Tirúa', 'provincia_id' => '43'],
      ['name' => 'Collipulli', 'provincia_id' => '44'],
      ['name' => 'Curacautín', 'provincia_id' => '44'],
      ['name' => 'Ercilla', 'provincia_id' => '44'],
      ['name' => 'Lonquimay', 'provincia_id' => '44'],
      ['name' => 'Los Sauces', 'provincia_id' => '44'],
      ['name' => 'Lumaco', 'provincia_id' => '44'],
      ['name' => 'Purén', 'provincia_id' => '44'],
      ['name' => 'Renaico', 'provincia_id' => '44'],
      ['name' => 'Traiguén', 'provincia_id' => '44'],
      ['name' => 'Victoria', 'provincia_id' => '44'],
      ['name' => 'Temuco', 'provincia_id' => '45'],
      ['name' => 'Carahue', 'provincia_id' => '45'],
      ['name' => 'Cunco', 'provincia_id' => '45'],
      ['name' => 'Curarrehue', 'provincia_id' => '45'],
      ['name' => 'Freire', 'provincia_id' => '45'],
      ['name' => 'Galvarino', 'provincia_id' => '45'],
      ['name' => 'Gorbea', 'provincia_id' => '45'],
      ['name' => 'Lautaro', 'provincia_id' => '45'],
      ['name' => 'Loncoche', 'provincia_id' => '45'],
      ['name' => 'Melipeuco', 'provincia_id' => '45'],
      ['name' => 'Nueva Imperial', 'provincia_id' => '45'],
      ['name' => 'Padre Las Casas', 'provincia_id' => '45'],
      ['name' => 'Perquenco', 'provincia_id' => '45'],
      ['name' => 'Pitrufquén', 'provincia_id' => '45'],
      ['name' => 'Pucón', 'provincia_id' => '45'],
      ['name' => 'Saavedra', 'provincia_id' => '45'],
      ['name' => 'Teodoro SchmIDnamet', 'provincia_id' => '45'],
      ['name' => 'Toltén', 'provincia_id' => '45'],
      ['name' => 'Vilcún', 'provincia_id' => '45'],
      ['name' => 'Villarrica', 'provincia_id' => '45'],
      ['name' => 'Cholchol', 'provincia_id' => '45'],
      ['name' => 'Valdivia', 'provincia_id' => '46'],
      ['name' => 'Corral', 'provincia_id' => '46'],
      ['name' => 'Lanco', 'provincia_id' => '46'],
      ['name' => 'Los Lagos', 'provincia_id' => '46'],
      ['name' => 'Máfil', 'provincia_id' => '46'],
      ['name' => 'Mariquina', 'provincia_id' => '46'],
      ['name' => 'Paillaco', 'provincia_id' => '46'],
      ['name' => 'Panguipulli', 'provincia_id' => '46'],
      ['name' => 'La Unión', 'provincia_id' => '47'],
      ['name' => 'Futrono', 'provincia_id' => '47'],
      ['name' => 'Lago Ranco', 'provincia_id' => '47'],
      ['name' => 'Río Bueno', 'provincia_id' => '47'],
      ['name' => 'Coihaique', 'provincia_id' => '48'],
      ['name' => 'Lago Verde', 'provincia_id' => '48'],
      ['name' => 'Cisnes', 'provincia_id' => '49'],
      ['name' => 'Guaitecas', 'provincia_id' => '49'],
      ['name' => 'Chile Chico', 'provincia_id' => '50'],
      ['name' => 'Río Ibáñez', 'provincia_id' => '50'],
      ['name' => 'Cochrane', 'provincia_id' => '51'],
      ['name' => 'O\'Higgins', 'provincia_id' => '51'],
      ['name' => 'Tortel', 'provincia_id' => '51'],
      ['name' => 'Natales', 'provincia_id' => '52'],
      ['name' => 'San Gregorio', 'provincia_id' => '52'],
      ['name' => 'Punta Arenas', 'provincia_id' => '53'],
      ['name' => 'Laguna Blanca', 'provincia_id' => '53'],
      ['name' => 'Río Verde', 'provincia_id' => '53'],
      ['name' => 'San Gregorio', 'provincia_id' => '53'],
      ['name' => 'Porvenir', 'provincia_id' => '53'],
      ['name' => 'Primavera', 'provincia_id' => '54'],
      ['name' => 'Timaukel', 'provincia_id' => '54'],
      ['name' => 'Cabo de Hornos', 'provincia_id' => '55'],
      ['name' => 'jose', 'provincia_id' => '2'],
      ['name' => 'sfdgfdgdf', 'provincia_id' => '1'],
      ['name' => 'sggffd', 'provincia_id' => '1'],
      ['name' => 'sgfgsd', 'provincia_id' => '1'],
      ['name' => 'dfasdfd', 'provincia_id' => '1'],
      ['name' => 'dghgd', 'provincia_id' => '1'],
      ['name' => 'Yo', 'provincia_id' => '10'],
      ['name' => 'fdasfdsf', 'provincia_id' => '1'],
      ['name' => 'sdf', 'provincia_id' => '7'],
      ['name' => 'fdsfdd', 'provincia_id' => '16'],
      ['name' => 'sdfggds', 'provincia_id' => '21'],
      ['name' => 'fadsdfas', 'provincia_id' => '1'],
      ['name' => 'gsfggf', 'provincia_id' => '6'],
      ['name' => 'Osorno', 'provincia_id' => '1']

    ]);
  }

  public function down()
  {
    Schema::drop('clients');
    Schema::drop('products');
    Schema::drop('sales_invoices');
    Schema::drop('detail_sales_invoice');
    Schema::drop('comuna');

  }
}

<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Carteira::class, function (Faker\Generator $faker) {
    $user_ids = DB::table('users')->select('id')->get();
    $user_id = $faker->randomElement($user_ids)->id;

    return [
        'nome' => $faker->randomElement(array('Ações','Renda Fixa','Day Trade','Opções')),
        'user_id' => $user_id,
    ];
});

$factory->define(App\Ativo::class, function (Faker\Generator $faker) {
//    DB::table('ativos')->truncate();
//    $carteira_ids = DB::table('carteiras')->select('id')->get();
//    $carteira_id = $faker->randomElement($carteira_ids)->id;
    $codigo_array = array('WINQ16');
//    $codigo_array = array('ABEV3','BBAS3','BBDC3','BBDC4','BBSE3','BRAP4','BRFS3','BRKM5',
//                        'BRML3','BVMF3','CCRO3','CESP6','CIEL3','CMIG4','CPFE3','CPLE6','CSAN3');
    return [
//        'carteira_id' => $carteira_id,
        'codigo' => $faker->randomElement($codigo_array),
        'descricao' => $faker->sentence(2,false),
    ];
});

$factory->define(App\Trade::class, function (Faker\Generator $faker) {
    $user_ids = DB::table('users')->select('id')->get();
    $user_id = $faker->randomElement($user_ids)->id;
    $ativo_ids = DB::table('ativos')->select('id')->get();
    $ativo_id = $faker->randomElement($ativo_ids)->id;
    $tipo = $faker->randomElement(array('buy','sell'));
    $preco_entrada = $faker->numberBetween(50000,57000);
    $preco_saida = $faker->optional(0.7)->numberBetween(50000,57000);
    $resultado = '';
    $lucro_prejuizo = '';
    if ( ! is_null($preco_saida)){
        $resultado = $preco_entrada - $preco_saida;
        if ($tipo=='buy')
            $resultado = $preco_saida - $preco_entrada;
        $lucro_prejuizo = $resultado*0.2;
    }

    return [
        'user_id' => $user_id,
        'ativo_id' => $ativo_id,
        'data' => $faker->date(),
        'tipo' => $tipo,
        'preco_entrada' => $preco_entrada,
        'preco_saida' => $preco_saida,
        'volume' => $faker->numberBetween(1,20),
        'resultado' => $resultado,
        'lucro_prejuizo' => $lucro_prejuizo,
    ];
});
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $users = factory(App\User::class,3)->create();
//        $carteiras = factory(App\Carteira::class,6)->create();
        $ativos = factory(App\Ativo::class,1)->create();
        $trades = factory(App\Trade::class,5)->create();
        $tradeEntradas = factory(App\TradeEntrada::class,20)->create();
        $tradeSaidas = factory(App\TradeSaida::class,20)->create();
    }
}

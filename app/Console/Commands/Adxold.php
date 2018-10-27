<?php

namespace App\Console\Commands;

class Adxold extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adx:old {how}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $command = $this->argument('how');
        if($command === "manual"){
            //$date_start = "2017-10-01";
            //$date_end = "2017-10-15";

            //handel get data from adx-old
            echo "Input Date Start type (Y-m-d): ";
            $handle_1 = fopen("php://stdin", "r");
            $date_start = trim(fgets($handle_1));

            echo "Input Date End type (Y-m-d): ";
            $handle_2 = fopen("php://stdin", "r");
            $date_end = trim(fgets($handle_2));
            echo "\n";

        }else if($command === "daily"){
            $date_start = date('Y-m-d', strtotime('-1 days'));
            $date_end = date('Y-m-d', strtotime('-1 days'));
        }else if($command === "update"){
            $date_start = date('Y-m-d', strtotime('-2 days'));
            $date_end = date('Y-m-d', strtotime('-2 days'));
        }
        /**
         * Handel API
         */
    }
}

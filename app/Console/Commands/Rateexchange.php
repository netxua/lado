<?php

namespace App\Console\Commands;

class Rateexchange extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Rateexchange:data';

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
     * @return mixed. please contact to Administrator
     */
    public function handle(){
           //input Mont, year
        $this->calenderKPI(10, 2017);
    }
        /**
         * Handel API
         */
        /**
     * @param $date_start
     * @param $date_end
     * @function addreport
     * @created 2017/11/28
     * @by nguyenvo
     * @description add data from dsp.urekamedia.com gồm 3 phần: contract, campaign, report 
     */

    //Calender KPI
     protected function createRateexchange($month, $year){
        
            $usermodel=$this->getModel("Users");
            $getItemUserMedia =$usermodel::whereIn('role_id',getRole(1))->get(['id']);
           
            $datereport = $year."-".$month."-01";
            $lastday = date('t',strtotime($datereport));
            $datetoreport= $year."-".$month."-".$lastday;
            if(count($getItemUserMedia)>0){
                    foreach($getItemUserMedia as $listUserData){
                              $usermedia=$listUserData["id"];
                              $reportCommission = $this->getModel("Report");
                              $reportData =  $reportCommission::selectRaw('sum(daily_revenue_lineitem) as revenuesum, sum(actual_cost_private) as costsum')
                                                                       ->where(array('user_media_id'=>$usermedia))
                                                                       ->where( 'day','>=',$datereport)
                                                                       ->where('day','<=',$datetoreport)
                                                                       ->groupBy('user_media_id')
                                                                       ->get()->toArray();
                               
                             $kpi=0;
                              if(!empty($reportData)){
                                $kpi=(($reportData[0]["revenuesum"]-$reportData[0]["costsum"])/$reportData[0]["revenuesum"])*100;
                              }
                              $kpimodel=$this->getModel("Kpi");
                              $kpimodel->user_created_id =1;
                              $kpimodel->user_id = $usermedia;
                              $kpimodel->month =   $month;
                              $kpimodel->year =$year;
                              $kpimodel->target =  mediaKPI();
                              $kpimodel->complete =$kpi;
                              $kpimodeldata=$this->getModel("Kpi");
                              $getItemKPI =$kpimodeldata::where(array('user_id' =>$usermedia,   'month'=>(int)$month,  'year'=>(int)$year))->get(['id'])->first();
                              if(count($getItemKPI )<=0){
                                        $kpimodel->saveNoUser();
                             }else{
                                       $result=$kpimodeldata::where(array('id' =>   $getItemKPI["id"]))->update(['complete'=>$kpi]);
                             }
                    }
            }
     }
}

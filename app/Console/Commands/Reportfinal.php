<?php

namespace App\Console\Commands;

class Reportfinal extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reportfinal:data';

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
        //$this->updatePayment();
        $this->updateCampaign(12, 2017);
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
     * @description add data from
     */

    //Calender KPI
     public function updateCampaign($month, $year){
            
            $datereport = $year."-".$month."-01";
			
            $lastday = date('t',strtotime($datereport));
            $datetoreport= $year."-".$month."-".$lastday;
		
            $campaignmodel=$this->getModelFinal("Campaign");
			
            $getItemCampaign =$campaignmodel::selectRaw('campaign.campaign_id as id, campaign.campaign_type as campaign_type, campaign.name as name, usale.email as emailsales, usale.name as namesales,  umedia.email as emailmedia, umedia.name as namemedia, campaign.user_media_id as user_media_id, campaign.user_sales_id as user_sales_id')
                                        ->leftJoin('users as usale', 'usale.id', '=', 'campaign.user_sales_id')
                                        ->leftJoin('users as umedia', 'umedia.id', '=', 'campaign.user_media_id')
                                        ->where(function($getItemUserMedia)  use ($datereport, $datetoreport){ 
                                        return $getItemUserMedia->where([['campaign.end_date','>=',$datereport],['campaign.end_date','<=',$datetoreport]])
                                        ->orWhere([['campaign.start_date','>=',$datereport],['campaign.start_date','<=',$datetoreport]])->orWhere([['campaign.start_date','<=',$datereport],['campaign.end_date','>=',$datereport]]);
                                        })->get();
			
            if(count($getItemCampaign)>0){
                    foreach($getItemCampaign as $listData){
                              $campaignID=$listData["id"];
                              $campaignName=$listData["name"];
                              $user_media_id=$listData["user_media_id"];
                              $user_sales_id=$listData["user_sales_id"];
                              $email_media=$listData["emailmedia"];
                              $email_sale=$listData["emailsales"];
                              $campaign_type=$listData["campaign_type"];
                              
                              $Report_finance = $this->getModelFinal("Report_finance");
                             $getItemCampaign =$Report_finance::where(array('campaign_id' => $campaignID, 'year' => $year, 'month' => $month,))->get(['id'])->first();
							  
                             if(!empty($getItemCampaign)){
                                $result=$Report_finance::where(array('id' =>$getItemCampaign["id"]))->update(['campaign_id'=>$campaignID,'campaign_name'=>$campaignName]);
                             }else{
								$campaignModel=$this->getModelFinal("Report_finance");
								$campaignModel->campaign_id = $campaignID;
								$campaignModel->campaign_name =   $campaignName;
								$campaignModel->goal_type =   $campaign_type;
								$campaignModel->year =$year;
								$campaignModel->month =$month;
								$campaignModel->email_media =  $email_media;
								$campaignModel->email_sale =  $email_sale;
								$campaignModel->user_sales_id =  $user_sales_id;
								$campaignModel->user_media_id =  $user_media_id;
								$campaignModel->saveNoUser();
                             }
                             
                             $campaignList = $this->getModelFinal("Campaign");
                             $campaignData =  $campaignList::selectRaw('sum(report.actual_cost_private_en) as actualcost, sum(report.actual_cost_private) as actualcostvn,  report.goal_type as goal_type,  report.unit_price as unit_price,  sum(report.imps_private) as imps_private,  sum(report.clicks_private) as clicks_private,   sum(report.daily_revenue_lineitem) as daily_revenue, report.line_item_id as line_item_id')
                                                                                      ->leftJoin('report', 'report.campaign_id', '=', 'campaign.campaign_id')
                                                                                      ->where('campaign.campaign_id','=',$campaignID)
                                                                                      ->where( 'campaign.start_date','<=',$datereport)
                                                                                      ->where('campaign.end_date','>=',$datetoreport)
                                                                                     ->whereBetween('report.day', [$datereport, $datetoreport])
                                                                                      ->groupBy('campaign.campaign_id')
                                                                                      ->get()->toArray();
                             $kpi=0;
							
                              if(!empty($campaignData)){
                                $kpi=0;
                                if($campaignData[0]["daily_revenue"]>0){
                                    $kpi=(int)((($campaignData[0]["daily_revenue"]-$campaignData[0]["actualcost"])/$campaignData[0]["daily_revenue"])*100);
									 
                                }
                                $financemodel=$this->getModelFinal("report_finance");
                                $result=$financemodel::where(array('campaign_id' =>$campaignID,'month' =>$month,'year' =>$year))->update(['unit_price'=>$campaignData[0]["unit_price"], 'goal_type'=>$campaignData[0]["goal_type"], 'actual_cost_private'=>$campaignData[0]["actualcost"], 'actual_cost_private_vi'=>$campaignData[0]["actualcostvn"], 'imps_private'=>$campaignData[0]["imps_private"], 'clicks_private'=>$campaignData[0]["clicks_private"],  'daily_revenue_lineitem'=>$campaignData[0]["daily_revenue"],  'actual_sold_value_vnd'=>$campaignData[0]["daily_revenue"], 'line_item_id'=>$campaignData[0]["line_item_id"], 'gp'=>$kpi]);
								var_dump($result);
                              }
                              
                    }
            }
			die();
     }
	 //Calender KPI
     protected function updateContract(){
            $streakmodel=$this->getModelFinal("Streak_log_data_parent");
            $streakmodelList =$streakmodel::where('status','=',0)->limit(1000)->get()->toArray();
            if(count($streakmodelList)>0){
                    foreach($streakmodelList as $listData){
                            $month=0;
                            $year=0;
                            if($listData["date"]!=""){
                                            $date=explode("-",$listData["date"]);
                                            $month=$date[1];
                                            $year=$date[0];
                            }
                            $campaignName=$listData["name"];
                            $Contact = $this->getModelFinal("Contract");
                            $getItemCampaign =$Contact::where(array( 'id' => $listData["streakID"]))->get(['id'])->first();
                             if(count($getItemCampaign)>0){
                                        $result=$Contact::where(array('id' =>$getItemCampaign["id"]))->update(['name'=>$campaignName,'start_date'=>$listData["start_date"],'end_date'=>$listData["end_date"]]);
										$streakmodel=$this->getModelFinal("Streak_log_data_parent");
                                        $streakmodel::where(array('id'=>$listData["id"]))->update(['status'=>1]);
                             }else{
							     $Report_finance = $this->getModelFinal("Contract");
								 $Report_finance->id=$listData["streakID"];
								 $Report_finance->name =$campaignName;
								 $Report_finance->campaigns_type =$listData["type"];
								 $Report_finance->unit_price =$listData["actual_unit_cost_cpc_cpm_cpa_usd"];
								 $Report_finance->goal_type =$listData["channel"];
								 $user_sales_id=0; 
								 $user_media_id=0;
								 if(!empty($listData["sale"])){
										$usermodel=$this->getModel("Users");
										$getItemUserSale =$usermodel::where('email', '=', $listData["sale"])->first();
										if(!empty($getItemUserSale)){
											$user_sales_id=$getItemUserSale["id"];
										}
								 }
								 
								 if(!empty($listData["assigned_to"])){
										  $usermodel=$this->getModel("Users");
										  $getItemUserMedia =$usermodel::where( 'email','=',$listData["assigned_to"])->first();
										  if(!empty($getItemUserMedia)){
												$user_media_id=$getItemUserMedia["id"];
										 }
								}
								 $Report_finance->id_sale =$user_sales_id;
								 $Report_finance->assignedto_id =$user_media_id;
								 $Report_finance->email_sale =$listData["sale"];
								 $Report_finance->assignedto =$listData["assigned_to"];
								 
								 $Report_finance->lobby =$listData["lobby"];
								 $Report_finance->entertaiment =$listData["entertainment"];
								 $Report_finance->saveNoUser();
								 $streakmodel=$this->getModelFinal("streak_log_data_parent");
								 $result=$streakmodel::where(array('id'=>$listData["id"]))->update(['status'=>1]);
                             }

                    }
            }
     }

     //Calender KPI
     protected function updatePayment(){
            $payentmodel=$this->getModelFinal("Tb_collected");
            $streakPaymentList =$payentmodel::get()->toArray();
          
            if(count($streakPaymentList)>0){
                    foreach($streakPaymentList as $listData){
                      
                                $streakID=$listData["streakID"];
                                $time1=(int)$listData["collected_1"];
                                $time2=(int)$listData["collected_2"];
                                $time3=(int)$listData["collected_3"];
                                $time4=(int)$listData["collected_4"];
                                 $vat=$listData["vat"];
                                $total_rev=$listData["total_rev"];
                                $remain=$listData["remain"];
                              
                                if($time1>0){
                                        $collected_date1=$listData["collected_date1"];
                                        if($collected_date1!=""){
                                                $datelist=explode("-",$collected_date1);
                                                if(count($datelist)>=3){
                                                        $year=$datelist[2];
                                                        if(strlen($datelist[2])<=2){
                                                                $year="20".$datelist[2];
                                                        }

                                                        $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                                }else{
                                                        $datelist=explode("/",$collected_date1);
                                                        if(count($datelist)>=3){
                                                                $year=$datelist[2];
                                                                if(strlen($datelist[2])<=2){
                                                                        $year="20".$datelist[2];
                                                                }
                                                                $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                                        }else{
                                                                $datetime=date("Y-m-d");
                                                        }

                                                }
                                        }else{
                                                $datetime=date("Y-m-d");
                                        }
                                        
                                        
                                        $contract_payment = $this->getModelFinal("Contract_payment");
                                        $contract_payment->contract=$listData["streakID"];
                                        $contract_payment->money_tranfer =$time1;
                                        $contract_payment->money_paid =$time1;
                                        $contract_payment->invoice_date =$datetime;
                                        $contract_payment->payment_date_calender =$datetime;
                                        $contract_payment->payment_date =$datetime;
                                        $contract_payment->payment_number_tearm =0;
                                        $contract_payment->based_on_invoice =0;
                                        $contract_payment->not_payment_yet =1;
                                        $contract_payment->vat =$vat;
                                        $contract_payment->remain =$remain;
                                        $contract_payment->total_rev =$total_rev;
                                        $contract_payment->invoice_number=$listData["streakID"]."-1";
                                        $contract_payment->saveNoUser();
                                }   
                      
                                if($time2>0){
                                        $collected_date2=$listData["collected_date2"];
                                        $datelist=explode("-",$collected_date2);
                                        if(count($datelist)>=3){
                                                $year=$datelist[2];
                                                if(strlen($datelist[2])<=2){
                                                        $year="20".$datelist[2];
                                                }

                                                $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                        }else{
                                                $datelist=explode("/",$collected_date2);
                                                if(count($datelist)>=3){
                                                        $year=$datelist[2];
                                                        if(strlen($datelist[2])<=2){
                                                                $year="20".$datelist[2];
                                                        }
                                                        $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                                }else{
                                                        $datetime=date("Y-m-d");
                                                }

                                        }
                                        $contract_payment = $this->getModelFinal("Contract_payment");
                                        $contract_payment->contract=$listData["streakID"];
                                        $contract_payment->money_tranfer =$time1;
                                        $contract_payment->money_paid =$time1;
                                        $contract_payment->invoice_date =$datetime;
                                        $contract_payment->payment_date_calender =$datetime;
                                        $contract_payment->payment_date =$datetime;
                                        $contract_payment->payment_number_tearm =0;
                                        $contract_payment->based_on_invoice =0;
                                        $contract_payment->not_payment_yet =1;
                                        $contract_payment->vat =$vat;
                                        $contract_payment->remain =$remain;
                                        $contract_payment->total_rev =$total_rev;
                                        $contract_payment->invoice_number=$listData["streakID"]."-2";
                                        $contract_payment->saveNoUser();
                                }
                                if($time3>0){
                                        $collected_date3=$listData["collected_date3"];
                                        $datelist=explode("-",$collected_date3);
                                        if(count($datelist)>=3){
                                                $year=$datelist[2];
                                                if(strlen($datelist[2])<=2){
                                                        $year="20".$datelist[2];
                                                }

                                                $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                        }else{
                                                $datelist=explode("/",$collected_date3);
                                                if(count($datelist)>=3){
                                                        $year=$datelist[2];
                                                        if(strlen($datelist[2])<=2){
                                                                $year="20".$datelist[2];
                                                        }
                                                        $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                                }else{
                                                        $datetime=date("Y-m-d");
                                                }

                                        }
                                        $contract_payment = $this->getModelFinal("Contract_payment");
                                        $contract_payment->contract=$listData["streakID"];
                                        $contract_payment->money_tranfer =$time1;
                                        $contract_payment->money_paid =$time1;
                                        $contract_payment->invoice_date =$datetime;
                                        $contract_payment->payment_date_calender =$datetime;
                                        $contract_payment->payment_date =$datetime;
                                        $contract_payment->payment_number_tearm =0;
                                        $contract_payment->based_on_invoice =0;
                                        $contract_payment->not_payment_yet =1;
                                        $contract_payment->vat =$vat;
                                        $contract_payment->remain =$remain;
                                        $contract_payment->total_rev =$total_rev;
                                        $contract_payment->invoice_number=$listData["streakID"]."-3";
                                        $contract_payment->saveNoUser();
                                }
                                if($time4>0){
                                        $collected_date4=$listData["collected_date4"];
                                        $datelist=explode("-",$collected_date4);
                                        if(count($datelist)>=3){
                                                $year=$datelist[2];
                                                if(strlen($datelist[2])<=2){
                                                        $year="20".$datelist[2];
                                                }

                                                $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                        }else{
                                                $datelist=explode("/",$collected_date4);
                                                if(count($datelist)>=3){
                                                        $year=$datelist[2];
                                                        if(strlen($datelist[2])<=2){
                                                                $year="20".$datelist[2];
                                                        }
                                                        $datetime=$year."-".$datelist[1]."-".$datelist[0];
                                                }else{
                                                        $datetime=date("Y-m-d");
                                                }

                                        }
                                        $contract_payment = $this->getModelFinal("Contract_payment");
                                        $contract_payment->contract=$listData["streakID"];
                                        $contract_payment->money_tranfer =$time1;
                                        $contract_payment->money_paid =$time1;
                                        $contract_payment->invoice_date =$datetime;
                                        $contract_payment->payment_date_calender =$datetime;
                                        $contract_payment->payment_date =$datetime;
                                        $contract_payment->payment_number_tearm =0;
                                        $contract_payment->based_on_invoice =0;
                                        $contract_payment->not_payment_yet =1;
                                        $contract_payment->vat =$vat;
                                        $contract_payment->remain =$remain;
                                        $contract_payment->total_rev =$total_rev;
                                        $contract_payment->invoice_number=$listData["streakID"]."-4";
                                        $contract_payment->saveNoUser();
                                }
                               $result=$payentmodel::where(array('id'=>$listData["id"]))->update(['status'=>1]);

                    }
            }
     }
	//
}

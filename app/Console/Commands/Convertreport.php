<?php

namespace App\Console\Commands;

class Convertreport extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Convertreport:data';

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
         //$this->updateContract();
		 
          $this->updatePayment();
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
    protected function updateContract(){
			die("Test test");
            $streakmodel=$this->getModelFinal("Streak_log_data_parent");
            $streakmodelList =$streakmodel::get()->toArray();
          
		  
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
                                        $result=$Contact::where(array('id' =>   $getItemCampaign["id"]))->update(['campaign_name'=>$campaignName]);
		$streakmodel=$this->getModelFinal("Streak_log_data_parent");
                                        $streakmodel::where(array('id'=>$listData["id"]))->update(['status'=>1]);
                             }else{

                                        $Report_finance->id=$listData["streakID"];
                                         $Report_finance->name =$listData["name"];
                                         $Report_finance->campaign_type =$listData["type"];
                                         $Report_finance->unit_price =$listData["actual_unit_cost_cpc_cpm_cpa_usd"];
                                         $Report_finance->goal_type =$listData["channel"];
                                         $Report_finance->imps_private =0;
                                         $Report_finance->clicks_private =0;
                                         $Report_finance->convers_private =0;
                                         $Report_finance->actual_cost_private =$listData["actual_cost_usd"];
                                         $Report_finance->actual_cost_private_vi =$listData["actual_cost_vnd"];
                                         $Report_finance->views_private =0;
                                         $Report_finance->engagements_private =0;
                                         $Report_finance->reachs_private =0;
                                        $Report_finance->line_item_id =0;
                                         $Report_finance->daily_revenue_lineitem =$listData["actual_sold_value_vnd"];
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
                                         $Report_finance->user_sales_id =$user_sales_id;
                                         $Report_finance->user_media_id =$user_media_id;
                                         $Report_finance->email_sale =$listData["sale"];
                                         $Report_finance->email_media =$listData["assigned_to"];
                                         
                                         $Report_finance->month =$month;
                                         $Report_finance->year =$year;
                                         $Report_finance->gp =$listData["actual_gp"];
                                         $Report_finance->actual_sold_value_vnd =$listData["actual_sold_value_vnd"];
                                         $Report_finance->lobby =$listData["lobby"];
                                         $Report_finance->entertainment =$listData["entertainment"];
                                         $Report_finance->invoice_value =$listData["invoice_value"];
                                         $Report_finance->invoice_vnd =$listData["invoice_vnd"];
                                         $Report_finance->id_join =$listData["id_join"];
                                         $Report_finance->saveNoUser();
                                         $streakmodel=$this->getModelFinal("streak_log_data_parent");
                                         $result=$streakmodel::where(array('id'=>$listData["id"]))->update(['status'=>1]);
                             }

                    }
            }
     }
    //Calender KPI
    //Calender KPI
     protected function updatePayment(){
            $payentmodel=$this->getModelFinal("Tb_collected");
            $streakPaymentList =$payentmodel::get()->toArray();
            if(count($streakPaymentList)>0){
                    foreach($streakPaymentList as $listData){
							$month=0;
							$year=0;
							$streakID=$listData["streakID"];
							$time1=$listData["collected_1"];
							$time2=$listData["collected_2"];
							$time3=$listData["collected_3"];
							$time4=$listData["collected_4"];
							if((int)$time1>0){
								$collected_date1=$listData["collected_date1"];
								$datelist=explode("-",$collected_date1);
								if(count($datelist)>0){
									$year=$datelist[2];
									if(strlen($datelist[2])<=2){
										$year="20".$datelist[2];
									}
										
									$datetime=$year."-".$datelist[1]."-".$datelist[0];
								}else{
									$datelist=explode("/",$collected_date1);
									if(count($datelist)>0){
										$year=$datelist[2];
										if(strlen($datelist[2])<=2){
											$year="20".$datelist[2];
										}
										$datetime=$year."-".$datelist[1]."-".$datelist[0];
									}else{
										$datetime=date("Y-m-d");
									}
									
								}
								$vat=$listData["vat"];
								$total_rev=$listData["total_rev"];
								$remain=$listData["remain"];
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
								$contract_payment->remode =1;
								$contract_payment->vat =$vat;
								$contract_payment->remain =$remain;
								$contract_payment->total_rev =$total_rev;
								$contract_payment->invoice_number=$listData["streakID"]."-1";
								$contract_payment->saveNoUser();
							}
							if((int)$time2>0){
								$collected_date2=$listData["collected_date2"];
								$datelist=explode("-",$collected_date2);
								if(count($datelist)>0){
									$year=$datelist[2];
									if(strlen($datelist[2])<=2){
										$year="20".$datelist[2];
									}
										
									$datetime=$year."-".$datelist[1]."-".$datelist[0];
								}else{
									$datelist=explode("/",$collected_date2);
									if(count($datelist)>0){
										$year=$datelist[2];
										if(strlen($datelist[2])<=2){
											$year="20".$datelist[2];
										}
										$datetime=$year."-".$datelist[1]."-".$datelist[0];
									}else{
										$datetime=date("Y-m-d");
									}
									
								}
								$vat=$listData["vat"];
								$total_rev=$listData["total_rev"];
								$remain=$listData["remain"];
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
								$contract_payment->remode =1;
								$contract_payment->vat =$vat;
								$contract_payment->remain =$remain;
								$contract_payment->total_rev =$total_rev;
								$contract_payment->invoice_number=$listData["streakID"]."-2";
								$contract_payment->saveNoUser();
							}
							if((int)$time3>0){
								$collected_date3=$listData["collected_date3"];
								$datelist=explode("-",$collected_date3);
								if(count($datelist)>0){
									$year=$datelist[2];
									if(strlen($datelist[2])<=2){
										$year="20".$datelist[2];
									}
										
									$datetime=$year."-".$datelist[1]."-".$datelist[0];
								}else{
									$datelist=explode("/",$collected_date3);
									if(count($datelist)>0){
										$year=$datelist[2];
										if(strlen($datelist[2])<=2){
											$year="20".$datelist[2];
										}
										$datetime=$year."-".$datelist[1]."-".$datelist[0];
									}else{
										$datetime=date("Y-m-d");
									}
									
								}
								$vat=$listData["vat"];
								$total_rev=$listData["total_rev"];
								$remain=$listData["remain"];
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
								$contract_payment->remode =1;
								$contract_payment->vat =$vat;
								$contract_payment->remain =$remain;
								$contract_payment->total_rev =$total_rev;
								$contract_payment->invoice_number=$listData["streakID"]."-3";
								$contract_payment->saveNoUser();
							}
							if((int)$time4>0){
								$collected_date4=$listData["collected_date4"];
								$datelist=explode("-",$collected_date4);
								if(count($datelist)>0){
									$year=$datelist[2];
									if(strlen($datelist[2])<=2){
										$year="20".$datelist[2];
									}
										
									$datetime=$year."-".$datelist[1]."-".$datelist[0];
								}else{
									$datelist=explode("/",$collected_date4);
									if(count($datelist)>0){
										$year=$datelist[2];
										if(strlen($datelist[2])<=2){
											$year="20".$datelist[2];
										}
										$datetime=$year."-".$datelist[1]."-".$datelist[0];
									}else{
										$datetime=date("Y-m-d");
									}
									
								}
								$vat=$listData["vat"];
								$total_rev=$listData["total_rev"];
								$remain=$listData["remain"];
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
								$contract_payment->remode =1;
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
      //Calender KPI
	protected function updateEmail(){
            $streakmodel=$this->getModelFinal("Report_finance");
            $streakmodelList =$streakmodel::get()->toArray();
          
            if(count($streakmodelList)>0){
                    foreach($streakmodelList as $listData){
                                $emailsales=str_replace(array('<','>'),array('',''),$listData["email_sale"]);
                                $emailmedia=str_replace(array('<','>'),array('',''),$listData["email_media"]); 
                                $sales= explode(" ", $emailsales);
                                $media= explode(" ", $emailmedia);
                                if(count($sales)>0){
                                        for($i=0;$i<count($sales);$i++){
                                                    if($this->valid_email($sales[$i])){
                                                        $emailsale=$sales[$i];
                                                    }
                                        }
                                }
                                
                                if(count($media)>0){
                                        for($i=0;$i<count($media);$i++){
                                                    if($this->valid_email($media[$i])){
                                                        $emailmedia=$media[$i];
                                                        echo $emailmedia;
                                                    }
                                        }
                                }
                                $user_sales_id=0;
                                $user_media_id=0;
                                $usermodel=$this->getModel("Users");
                                if(!empty($listData["sale"])){
                                       $getItemUserSale =$usermodel::where('email', '=', $emailsale)->first();
                                       if(!empty($getItemUserSale)){
                                           $user_sales_id=$getItemUserSale["id"];
                                       }
                                }
                                if(!empty($listData["assigned_to"])){
                                         $getItemUserMedia =$usermodel::where( 'email','=',$emailmedia)->first();
                                         if(!empty($getItemUserMedia)){
                                               $user_media_id=$getItemUserMedia["id"];
                                        }
                               }
                              $Report_finance = $this->getModelFinal("Report_finance");
                              $Report_finance::where(array('id' =>   $listData["id"]))->update(['email_sale'=>$emailsale, 'email_media'=>$emailmedia, 'user_sales_id'=>$user_sales_id, 'user_media_id'=>$user_media_id]);
							
                    }
            }
     }
	protected function valid_email($email) {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

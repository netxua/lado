<?php

namespace App\Console\Commands;

class Crawl extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:data {how}';

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
        $command = $this->argument('how');
        if($command === "manual"){
		  for($i=1;$i<=31;$i++){
			  $date_start = '2017-12-'.$i;
			  $date_end ='2017-12-'.$i;
			  $this->addreport($date_start, $date_end);
		  }
		  //$date_start = date('Y-m-d', strtotime('-1 days'));
		  //$date_end = date('Y-m-d', strtotime('-1 days'));
		  //$this->addreport($date_start, $date_end);
        }else if($command === "daily"){
            $date_start = date('Y-m-d', strtotime('-1 days'));
            $date_end = date('Y-m-d', strtotime('-1 days'));
        }else if($command === "update"){
            $date_start = date('Y-m-d', strtotime('-2 days'));
            $date_end = date('Y-m-d', strtotime('-2 days'));
        }
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
    protected function addreport($date_start,$date_end){
            /**
             * @var \Backend\Models\Contract
             */
          // $contract::addReport($date_start, $date_end);
             $datafetch=file_get_contents("http://dsp.urekamedia.com/apistreak?start=".$date_start."&end=".$date_end);
            $datajson=json_decode($datafetch)->data;

            for($i=0;$i<count($datajson);$i++){
                                  $listcontract=$datajson[$i];
                                  $streak_id= $listcontract->streak_id;
                                  $name= $listcontract->name;
                                  $email_sale= $listcontract->email_sale;
                                  $status= $listcontract->status;
                                  $created_date= $listcontract->created_date;
                                  $note= $listcontract->note;
                                  $total_price= $listcontract->total_price;
                                  $cost_plan= $listcontract->cost_plan;
                                  $gp_plan= $listcontract->gp_plan;
                                  $model_io= $listcontract->model_io;
                                  $assignedto= $listcontract->assignedto;
                                  $campaigns_type= $listcontract->campaigns_type;
                                  $start_date= $listcontract->start_date;
                                  $end_date= $listcontract->end_date;
                                  $currency= $listcontract->currency;
                                  $updated_date= $listcontract->updated_date;
                                  $campaigns_id= $listcontract->campaigns_id;
                                  $product_category_id= $listcontract->product_category_id;
                                  $lobby= $listcontract->lobby;
                                  $entertaiment= $listcontract->entertaiment;
                                  $source_io= $listcontract->source_io;
                                  $contactsave = $this->getModel("Contract");
                                  $contactsave->id =$streak_id;
                                  $contactsave->name = $name;
                                  $contactsave->email_sale = $email_sale;
                                  $contactsave->status =   $status;
                                  $contactsave->created_date =$created_date;
                                  $contactsave->note = $note;
                                  $contactsave->total_price = $total_price;
                                  $contactsave->cost_plan =   $cost_plan;
                                  $contactsave->gp_plan =   $gp_plan;
                                  $contactsave->model_io =$model_io;
                                  $contactsave->assignedto = $assignedto;
                                  $contactsave->campaigns_type = $campaigns_type;
                                  $contactsave->start_date =   $start_date;
                                  $contactsave->end_date =$end_date;
                                  $contactsave->currency = $currency;
                                  $contactsave->updated_date = $updated_date;
                                  $contactsave->campaigns_id =   $campaigns_id;
                                  $contactsave->product_category_id =$product_category_id;
                                  $contactsave->lobby = $lobby;
                                  $contactsave->entertaiment = $entertaiment; 
                                  $contactsave->source_io =   $source_io;
                                  $contactsave->user_created_id =  1;
                                  $contractmodel=$this->getModel("Contract");
                                  $getItemContract =$contractmodel::where(array(
                                        'id' => $contactsave->id,
                                    ))->get(['id'])->first();
                                $usermodel=$this->getModel("Users");
                                   $getItemUserSale =$usermodel::where(array(
                                        'email' => $email_sale,
                                    ))->get(['id'])->first();
                                   $getItemUserMedia =$usermodel::where(array(
                                        'email' => $assignedto,
                                    ))->get(['id'])->first();
                                   $user_sales_id=0;
                                   if($getItemUserSale["id"]){
                                        $user_sales_id=$getItemUserSale["id"];
                                   }
                                  
                                  $user_media_id=0;
                                  if($getItemUserMedia["id"]){
                                        $user_media_id=$getItemUserMedia["id"];
                                   }
                                  $contactsave->id_sale =   $user_media_id;
                                  $contactsave->assignedto_id =  $user_sales_id;
                                  
                                  if(empty($getItemContract )){
										$contactsave->saveNoUser();
								   }else{
									   $contractmodel::where(array('id'=>$streak_id))->update(['id_sale'=>$user_sales_id, 'assignedto_id'=>$user_media_id] );
								   }
                                  $listcampaign= $listcontract->campaign;
                                  if(count($listcampaign)>0){
                                            for($j=0;$j<count($listcampaign);$j++){
                                                    $campaignid =$listcampaign[$j]->id;
                                                    $campaign_type  =$listcampaign[$j]->campaign_type;
                                                    $user_id =$listcampaign[$j]->user_id;
                                                    $name =$listcampaign[$j]->name ;
                                                    $start_date =$listcampaign[$j]->start_date;
                                                    $end_date =$listcampaign[$j]->end_date;
                                                    $created_date =$listcampaign[$j]->created_date ;
                                                    $lifetime_budget =$listcampaign[$j]->lifetime_budget ;
                                                    $state =$listcampaign[$j]->state;
                                                    $campaignsave = $this->getModel("Campaign");
                                                    $campaignsave->campaign_id =$campaignid;
                                                    $campaignsave->campaign_type = $campaign_type;
                                                    $campaignsave->user_id = $user_id;
                                                    $campaignsave->name  =     $name ;
                                                    $campaignsave->start_date =$start_date;
                                                    $campaignsave->end_date = $end_date;
                                                    $campaignsave->created_date = $created_date;
                                                    $campaignsave->lifetime_budget  =     $lifetime_budget ;
                                                    $campaignsave->state  =     $state ;
                                                    $campaignsave->contract_id  =     $streak_id ;
                                                    $campaignsave->user_sales_id  =     $user_sales_id ;
                                                    $campaignsave->user_media_id  =     $user_media_id ;
                                                    $Campaignmodel=$this->getModel("Campaign");
                                                    $getItemCompaign=$Campaignmodel::where(array(
                                                         'campaign_id' =>   $campaignsave->campaign_id,
                                                         'campaign_type' =>   $campaignsave->campaign_type,
                                                    ))->get(['campaign_id'])->first();
                                                   if(count($getItemCompaign )<=0){
                                                           $campaignsave->saveNoUser();
                                                   }  else{
                                                        echo $user_media_id."-".$user_sales_id."<br/>";
                                                       $Campaignmodel::where(array(
                                                                     'campaign_id' =>   $campaignsave->campaign_id,
                                                                    'campaign_type' =>   $campaignsave->campaign_type,
                                                            ))->update(['start_date'=>$start_date, 'end_date'=>$end_date, 'name'=>$name, 'user_sales_id'=>$user_sales_id, 'user_media_id'=>$user_media_id] );
                                                            //  $campaignsave->updateNoUser();
                                                   }
                                                     $ListReport=$listcampaign[$j]->report;
                                                     if(count( $ListReport)>0){
                                                                for($k=0;$k<count($ListReport);$k++){
                                                                                $datareport=$ListReport[$k];
                                                                                $unit_price=$datareport->unit_price;
                                                                                $goal_type=$datareport->goal_type;
                                                                                $day=$datareport->day;
                                                                                $imps_private=$datareport->imps_private;
                                                                                $clicks_private=$datareport->clicks_private;
                                                                                $convers_private=$datareport->convers_private;
                                                                                $actual_cost_private=($datareport->actual_cost_private)*22500;
                                                                                $actual_cost_private_en=$datareport->actual_cost_private;
                                                                                $views_private=$datareport->views_private;
                                                                                $engagements_private=$datareport->engagements_private;
                                                                                $reachs_private=$datareport->reachs_private;
                                                                                $line_item_id=$datareport->line_item_id;
																				$daily_revenue_lineitem=0;
																				if(!empty($datareport->daily_revenue_lineitem)){
																					$daily_revenue_lineitem=$datareport->daily_revenue_lineitem;
																				}
                                                                                $reportsave = $this->getModel("Report");
                                                                                $reportsave->unit_price =$unit_price;
                                                                                $reportsave->goal_type = $goal_type;
                                                                                $reportsave->day = $day;
                                                                                $reportsave->imps_private  =     $imps_private ;
                                                                                $reportsave->clicks_private =$clicks_private;
                                                                                $reportsave->convers_private = $convers_private;
                                                                                $reportsave->actual_cost_private = $actual_cost_private;
																				$reportsave->actual_cost_private_en = $actual_cost_private_en;
                                                                                $reportsave->views_private  =     $views_private ;
                                                                                $reportsave->engagements_private  =     $engagements_private ;
                                                                                $reportsave->reachs_private = $reachs_private;
                                                                                $reportsave->line_item_id  =     $line_item_id ;
                                                                                $reportsave->daily_revenue_lineitem = $daily_revenue_lineitem ;
                                                                                $reportsave->campaign_id  =     $campaignid  ;
                                                                                $reportsave->user_sales_id  =     $user_sales_id ;
                                                                                $reportsave->user_media_id  =     $user_media_id ;
                                                                                $modelreport=$this->getModel("Report");
                                                                                $getItemCompaign=$modelreport::where(array(
                                                                                       'campaign_id' =>   $campaignid,
                                                                                       'date_update' =>   $reportsave->date_update,
                                                                                      'day' =>   $reportsave->day,
                                                                                  ))->get(['campaign_id','date_update'])->first();
                                                                                 if(count($getItemCompaign )<=0){
                                                                                       $reportsave->saveNoUser();
                                                                                 }else{
                                                                                     $reportsave=$modelreport::where(array(
                                                                                               'campaign_id' =>   $campaignid,
                                                                                               'date_update' =>   $reportsave->date_update,
                                                                                              'day' =>   $reportsave->day,
                                                                                       ))->get(['campaign_id','date_update'])->first();
                                                                                     $reportsave->updateNoUser();
                                                                                 }
                                                                }
                                                     }
                                            }
                                  }
            }
           
    }
   
}

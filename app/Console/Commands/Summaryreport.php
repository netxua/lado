<?php

namespace App\Console\Commands;

class Summaryreport extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Summaryreport:data';

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
		  //$month=date("m");
		//  $year=date("Y");
			$month="01";
			$year="2018";
		 
         // $this->updateSummaryGoogle($month,$year);
		// $this->updateSummaryReportFacebook($month,$year);
			//$this->updateSummaryReportDSP($month,$year);
		 //$this->striptags();
		  // $this->updateReport($month,$year);
		   //$this->updateReportFinance($month,$year);
		   //$this->updateSummaryDSP($month,$year);
		  // $this->updatereportDSPtoReport($month,$year);
		   
		  //$this->addreportDSP('2018-01-01','2018-01-31');
		  $this->updateKPI($month,$year);
		  
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
	protected function addreportDSP($date_start,$date_end){
            /**
             * @var \Backend\Models\Contract
             */
          // $contract::addReport($date_start, $date_end);
             $datafetch=file_get_contents("http://dev-api.urekamedia.com/admin/apidsp/companyreport?key=ureka123456789&camp=&start_day=".$date_start."&end_day=".$date_end);
            $datajson=json_decode($datafetch)->data;
			
            for($i=0;$i<count($datajson);$i++){
				  $listcontract=$datajson[$i];
				  $date_request= $listcontract->day;
				  $client_id= $listcontract->advertiser_id;
				  $client_name= $listcontract->advertiser_name;
				  $campaign_id= $listcontract->campaign_id;
				  $campaign_name= $listcontract->campaign_name;
				  $ad_group_id= $listcontract->line_item_id;
				  $ad_group_name= $listcontract->line_item_name;
				  $impression= $listcontract->imps;
				  $click= $listcontract->clicks;
				  $cost= $listcontract->cost;
				  $ctr= $listcontract->ctr;
				  $total_convs= $listcontract->total_convs;
				  $convs_rate= $listcontract->convs_rate;
				  $revenue= $listcontract->revenue;
				  
				  $dspreportsave = $this->getModel("Dsp_report");
				  $dspreportsave->date_request =$date_request;
				  $dspreportsave->client_id = $client_id;
				  $dspreportsave->client_name = $client_name;
				  $dspreportsave->campaign_id =   $campaign_id;
				  $dspreportsave->campaign_name =$campaign_name;
				  $dspreportsave->ad_group_id = $ad_group_id;
				  $dspreportsave->ad_group_name = $ad_group_name;
				  $dspreportsave->impression =   $impression;
				  $dspreportsave->click =   $click;
				  $dspreportsave->cost =$cost;
				  $dspreportsave->ctr = $ctr;
				  $dspreportsave->total_convs = $total_convs;
				  $dspreportsave->revenue =   $revenue;
				  $dspreportsave->saveNoUser();
		 }
    }
	//Update report dsp
	 protected function updateSummaryReportDSP($month, $year){
            $dspportmodel=$this->getModel("Dsp_report");
			$summaryreportmodel=$this->getModel("Summary_client_dsp");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
            $summarymodelList =$dspportmodel::selectRaw('client_id, client_name, campaign_id, campaign_name, ad_group_id, ad_group_name, sum(impression) as impression, sum(click) as click, sum(cost) as cost, date_update, date_request')->where([['date_request','>=',$datestart],['date_request','<=',$dateend]])->groupBy('campaign_id')->get()->toArray();
            if(count($summarymodelList)>0){
				foreach($summarymodelList as $listData){
				 echo $listData["campaign_id"]."<br/>";
				 $checkexitRow=$summaryreportmodel::where('campaign_id','=',$listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->get()->toArray();
				 if(!empty($checkexitRow) && count($checkexitRow)>0){
					 $arrayadd=array("client_id"=>$listData["client_id"], "client_name"=>$listData["client_name"], "campaign_id"=>$listData["campaign_id"], "campaign_id"=>$listData["campaign_id"], "campaign_name"=>$listData["campaign_name"], "ad_group_id"=>$listData["ad_group_id"], "ad_group_name"=>$listData["ad_group_name"], "impression"=>$listData["impression"], "click"=>$listData["click"], "cost"=>$listData["cost"], "date_request"=>$listData["date_request"], "month"=>$month, "year"=>$year);
					 $result=$summaryreportmodel::where('campaign_id','=',$listData["campaign_id"])->where("month","=",$month)->where("year","=",$year)->update($arrayadd);
				 }else{
					 $summarygooggleadd=$this->getModel("Summary_client_dsp");
					 $summarygooggleadd->client_id=$listData["client_id"];
					 $summarygooggleadd->client_name=$listData["client_name"];
					 $summarygooggleadd->campaign_id=$listData["campaign_id"];
					 $summarygooggleadd->campaign_name=$listData["campaign_name"];
					 $summarygooggleadd->ad_group_id=$listData["ad_group_id"];
					 $summarygooggleadd->ad_group_name=$listData["ad_group_name"];
					 $summarygooggleadd->impression=$listData["impression"];
					 $summarygooggleadd->click=$listData["click"];
					 $summarygooggleadd->cost=$listData["cost"];
					 $summarygooggleadd->date_request=$listData["date_request"];
					 $summarygooggleadd->month=$month;
					 $summarygooggleadd->year=$year;
					 
					 $summarygooggleadd->saveNoUser();
				 }
			   }
          }
     }
	
	//Update report google
    protected function updateSummaryGoogle($month, $year){
            $googlereportmodel=$this->getModel("Client_report");
			$summaryreportmodel=$this->getModel("Summary_client_report");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
            $summarymodelList =$googlereportmodel::selectRaw('client_id, client_name, campaign_id, campaign_name, ad_group_id, ad_group_name, sum(impression) as impression, sum(click) as click, sum(cost) as cost, date_update, date_request')->where([['date_request','>=',$datestart],['date_request','<=',$dateend]])->groupBy('campaign_id')->get()->toArray();
            if(count($summarymodelList)>0){
				foreach($summarymodelList as $listData){
				 echo $listData["campaign_id"]."<br/>";
				 $checkexitRow=$summaryreportmodel::where('campaign_id','=',$listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->get()->toArray();
				 if(!empty($checkexitRow) && count($checkexitRow)>0){
					 $arrayadd=array("client_id"=>$listData["client_id"], "client_name"=>$listData["client_name"], "campaign_id"=>$listData["campaign_id"], "campaign_id"=>$listData["campaign_id"], "campaign_name"=>$listData["campaign_name"], "ad_group_id"=>$listData["ad_group_id"], "ad_group_name"=>$listData["ad_group_name"], "impression"=>$listData["impression"], "click"=>$listData["click"], "cost"=>$listData["cost"], "date_request"=>$listData["date_request"], "month"=>$month, "year"=>$year);
					 $result=$summaryfacebookreportmodel::where('campaign_id','=',$listData["campaign_id"])->where("month","=",$month)->where("year","=",$year)->update($arrayadd);
				 }else{
					 $summarygooggleadd=$this->getModel("Summary_client_report");
					 $summarygooggleadd->client_id=$listData["client_id"];
					 $summarygooggleadd->client_name=$listData["client_name"];
					 $summarygooggleadd->campaign_id=$listData["campaign_id"];
					 $summarygooggleadd->campaign_name=$listData["campaign_name"];
					 $summarygooggleadd->ad_group_id=$listData["ad_group_id"];
					 $summarygooggleadd->ad_group_name=$listData["ad_group_name"];
					 $summarygooggleadd->impression=$listData["impression"];
					 $summarygooggleadd->click=$listData["click"];
					 $summarygooggleadd->cost=$listData["cost"];
					 $summarygooggleadd->date_request=$listData["date_request"];
					 $summarygooggleadd->month=$month;
					 $summarygooggleadd->year=$year;
					 
					 $summarygooggleadd->saveNoUser();
				 }
			   }
          }
     }
	//Calender KPI
     protected function updateSummaryReportFacebook($month, $year){
            $facebookreportmodel=$this->getModel("Facebook_report");
			$summaryfacebookreportmodel=$this->getModel("Summary_facebook_report");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
            $summarymodelList =$facebookreportmodel::selectRaw('objective, account_id, account_name, campaign_id, campaign_name, adset_id, adset_name, sum(impressions) as impressions, sum(clicks) as clicks, sum(cpc) as cpc, sum(cpm) as cpm, sum(ctr) as ctr, sum(spend) as spend, sum(reach) as reach, sum(post_engagement) as post_engagement, sum(video_10_sec_watched_actions) as video_10_sec_watched_actions, sum(video_30_sec_watched_actions) as video_30_sec_watched_actions, sum(total_convertion_value) as total_convertion_value, date_request, sum(video_p25_watched_actions) as video_p25_watched_actions, date_update, sum(video_p50_watched_actions) as video_p50_watched_actions, sum(video_p95_watched_actions) as video_p95_watched_actions, sum(video_p100_watched_actions) as video_p100_watched_actions, sum(video_avg_time_watched_actions) as video_avg_time_watched_actions, sum(video_avg_percent_watched_actions) as video_avg_percent_watched_actions, sum(video_p75_watched_actions) as video_p75_watched_actions, sum(page_like) as page_like, sum(mobile_app_install) as mobile_app_install, sum(app_install) as app_install, currency')->where([['date_request','>=',$datestart],['date_request','<=',$dateend]])->groupBy('campaign_id')->get()->toArray();
            if(count($summarymodelList)>0){
				foreach($summarymodelList as $listData){
				 echo $listData["campaign_id"]."<br/>";
				 $checkexitRow=$summaryfacebookreportmodel::where('campaign_id','=',$listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->get()->toArray();
				
				 if(!empty($checkexitRow) && count($checkexitRow)>0){
					 $arrayadd=array("objective"=>$listData["objective"], "account_id"=>$listData["account_id"], "account_name"=>$listData["account_name"], "campaign_id"=>$listData["campaign_id"], "campaign_name"=>$listData["campaign_name"], "adset_id"=>$listData["adset_id"], "adset_name"=>$listData["adset_name"], "impressions"=>$listData["impressions"], "clicks"=>$listData["clicks"], "cpc"=>$listData["cpc"], "cpm"=>$listData["cpm"], "ctr"=>$listData["ctr"], "spend"=>$listData["spend"], "reach"=>$listData["reach"], "post_engagement"=>$listData["post_engagement"], "video_10_sec_watched_actions"=>$listData["video_10_sec_watched_actions"], "video_30_sec_watched_actions"=>$listData["video_30_sec_watched_actions"], "total_convertion_value"=>$listData["total_convertion_value"], "date_request"=>$listData["date_request"], "video_p25_watched_actions"=>$listData["video_p25_watched_actions"], "date_update"=>$listData["date_update"], "video_p50_watched_actions"=>$listData["video_p50_watched_actions"], "video_p95_watched_actions"=>$listData["video_p95_watched_actions"], "video_p100_watched_actions"=>$listData["video_p100_watched_actions"], "video_avg_time_watched_actions"=>$listData["video_avg_time_watched_actions"], "video_avg_percent_watched_actions"=>$listData["video_avg_percent_watched_actions"], "video_p75_watched_actions"=>$listData["video_p75_watched_actions"], "page_like"=>$listData["page_like"], "mobile_app_install"=>$listData["mobile_app_install"], "app_install"=>$listData["app_install"], "currency"=>$listData["currency"]);
					 $result=$summaryfacebookreportmodel::where('campaign_id','=',$listData["campaign_id"])->where("month","=",$month)->where("year","=",$year)->update($arrayadd);
					  var_dump($result);
				 }else{
					 $summaryfacebookadd=$this->getModel("Summary_facebook_report");
					 $summaryfacebookadd->objective=$listData["objective"];
					 $summaryfacebookadd->account_id=$listData["account_id"];
					 $summaryfacebookadd->account_name=$listData["account_name"];
					 $summaryfacebookadd->campaign_id=$listData["campaign_id"];
					 $summaryfacebookadd->campaign_name=$listData["campaign_name"];
					 $summaryfacebookadd->adset_id=$listData["adset_id"];
					 $summaryfacebookadd->adset_name=$listData["adset_name"];
					 $summaryfacebookadd->impressions=$listData["impressions"];
					 $summaryfacebookadd->clicks=$listData["clicks"];
					 $summaryfacebookadd->cpc=$listData["cpc"];
					 $summaryfacebookadd->cpm=$listData["cpm"];
					 $summaryfacebookadd->ctr=$listData["ctr"];
					 $summaryfacebookadd->spend=$listData["spend"];
					 $summaryfacebookadd->reach=$listData["reach"];
					 $summaryfacebookadd->post_engagement=$listData["post_engagement"];
					 $summaryfacebookadd->video_10_sec_watched_actions=$listData["video_10_sec_watched_actions"];
					 $summaryfacebookadd->video_30_sec_watched_actions=$listData["video_30_sec_watched_actions"];
					 $summaryfacebookadd->total_convertion_value=$listData["total_convertion_value"];
					 $summaryfacebookadd->date_request=$listData["date_request"];
					 $summaryfacebookadd->video_p25_watched_actions=$listData["video_p25_watched_actions"];
					 $summaryfacebookadd->date_update=$listData["date_update"];
					 $summaryfacebookadd->video_p50_watched_actions=$listData["video_p50_watched_actions"];
					 $summaryfacebookadd->video_p95_watched_actions=$listData["video_p95_watched_actions"];
					 $summaryfacebookadd->video_p100_watched_actions=$listData["video_p100_watched_actions"];
					 $summaryfacebookadd->video_avg_time_watched_actions=$listData["video_avg_time_watched_actions"];
					 $summaryfacebookadd->video_avg_percent_watched_actions=$listData["video_avg_percent_watched_actions"];
					 $summaryfacebookadd->video_p75_watched_actions=$listData["video_p75_watched_actions"];
					 $summaryfacebookadd->page_like=$listData["page_like"];
					 $summaryfacebookadd->mobile_app_install=$listData["mobile_app_install"];
					 $summaryfacebookadd->app_install=$listData["app_install"];
					 $summaryfacebookadd->currency=$listData["currency"];
					 $summaryfacebookadd->month=$month;
					 $summaryfacebookadd->year=$year;
					 $summaryfacebookadd->saveNoUser();
				 }
			   }
          }
     }
	

	//Tách contract_id google và facebook
    protected function striptags(){
			$summaryfacebookreportmodel=$this->getModel("Summary_facebook_report");
			$summarygooglereportmodel=$this->getModel("Summary_client_report");
			$summarydspreportmodel=$this->getModel("Summary_client_dsp");
			$listsummaryfacebook=$summaryfacebookreportmodel::where('contract_id','<=',0)->get()->toArray();
			$listsummarygoogle=$summarygooglereportmodel::where('contract_id','<=',0)->get()->toArray();
			$listsummaryDSP=$summarydspreportmodel::where('contract_id','<=',0)->get()->toArray();
			if(count($listsummaryDSP)>0){
				foreach($listsummaryDSP as $listData){
						$contract_id=0;
						$campaign_name_list=explode("_",$listData["campaign_name"]);						
						if(count($campaign_name_list)<=1 || strpos($listData["campaign_name"],"_")===false){
							$campaign_name_list=explode(" ",$listData["campaign_name"]);
						}
						$client_name_list=explode("_",$listData["client_name"]);
						if(count($client_name_list)<=1 || strpos($listData["client_name"],"_")===false){
							$client_name_list=explode(" ",$listData["client_name"]);
						}

						if(count($campaign_name_list)>0){
							for($i=0;$i<count($campaign_name_list);$i++){
								if(strlen(trim($campaign_name_list[$i]))>=8 && is_numeric(trim($campaign_name_list[$i]))){
									$contract_id=(int)trim($campaign_name_list[$i]);
									break;
								}
							}
						}
						if($contract_id==0){
							if(count($client_name_list)>0){
								for($i=0;$i<count($client_name_list);$i++){
									if(strlen($client_name_list[$i])>=8 && is_numeric(trim($client_name_list[$i]))){
										$contract_id=(int)trim($client_name_list[$i]);
										break;
									}
								}
							}
						}
						$arrayadd=array("contract_id"=>$contract_id);
						$result=$summarydspreportmodel::where('id','=',$listData["id"])->update($arrayadd);
				}
			}
			
			if(count($listsummaryfacebook)>0){
				foreach($listsummaryfacebook as $listData){
						$contract_id=0;
						$campaign_name_list=explode("_",$listData["campaign_name"]);						
						if(count($campaign_name_list)<=1 || strpos($listData["campaign_name"],"_")===false){
							$campaign_name_list=explode(" ",$listData["campaign_name"]);
						}
						$client_name_list=explode("_",$listData["account_name"]);
						if(count($client_name_list)<=1 || strpos($listData["account_name"],"_")===false){
							$client_name_list=explode(" ",$listData["account_name"]);
						}

						if(count($campaign_name_list)>0){
							for($i=0;$i<count($campaign_name_list);$i++){
								if(strlen(trim($campaign_name_list[$i]))>=8 && is_numeric(trim($campaign_name_list[$i]))){
									$contract_id=(int)trim($campaign_name_list[$i]);
									break;
								}
							}
						}
						if($contract_id==0){
							if(count($client_name_list)>0){
								for($i=0;$i<count($client_name_list);$i++){
									if(strlen($client_name_list[$i])>=8 && is_numeric(trim($client_name_list[$i]))){
										$contract_id=(int)trim($client_name_list[$i]);
										break;
									}
								}
							}
						}
						$arrayadd=array("contract_id"=>$contract_id);
						$result=$summaryfacebookreportmodel::where('id','=',$listData["id"])->update($arrayadd);
				}
			}
			
			if(!empty($listsummarygoogle)){
				foreach($listsummarygoogle as $listData){
					$contract_id=0;
					$campaign_name_list=explode("_",$listData["campaign_name"]);
					if(count($campaign_name_list)<=1 || strpos($listData["campaign_name"],"_")===false){
						$campaign_name_list=explode(" ",$listData["campaign_name"]);
					}
					$client_name_list=explode("_",$listData["client_name"]);
					if(count($client_name_list)<=1 || strpos($listData["client_name"],"_")===false){
						$client_name_list=explode(" ",$listData["client_name"]);
					} 
					if(count($campaign_name_list)>0){
						for($i=0;$i<count($campaign_name_list);$i++){
							if(strlen($campaign_name_list[$i])>=8 && is_numeric($campaign_name_list[$i])){
								$contract_id=trim($campaign_name_list[$i]);
								break;
							}
						}
					}
					if($contract_id==0){
						if(count($client_name_list)>0){
							for($i=0;$i<count($client_name_list);$i++){
								if(strlen($client_name_list[$i])>=8 && is_numeric($client_name_list[$i])){
									$contract_id=trim($client_name_list[$i]);
									break;
								}
							}
						}
					}
					$arrayadd=array("contract_id"=>$contract_id);
					$result=$summarygooglereportmodel::where('id','=',$listData["id"])->update($arrayadd);
				}
			}

	}
	 
     //Add data to report for finance
	protected function updatereportDSPtoReport($month, $year){
			//DSP ads
			$rate_exchange=$this->getModel("Rate_exchange");
           	$listQuarter=getQuarterOfMonth($month);
		    $rate_exchangeConvert = $rate_exchange::where(array('quarter'=>$listQuarter, 'year'=>$year))->first();
		    $rateExchange=$rate_exchangeConvert["rate_exchange"];
			$dspreportmodel=$this->getModel("Summary_client_dsp");
            $dspListReport =$dspreportmodel::where('month','=',$month)->where('year','=',$year)->get()->toArray();
            if(count($dspListReport)>0){
				foreach($dspListReport as $listData){
					$reportmodel=$this->getModel("Contract_report");
					$checkexitRow=$reportmodel::where('campaign_id','=', $listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->first();
					//Detail contract
					$ContractRow=null;
					$entertaiment=0;
					$lodby=0;
					$lodbypecent=10;
					$entertaimentpecent=1;
					$campaign_id=$listData["campaign_id"];
					if($listData["contract_id"]>0){
							$contractmodel=$this->getModel("Contract");
							$ContractRow=$contractmodel::where('id','=', $listData["contract_id"])->first();	
							$lodbypecent=0;
							if($ContractRow['lodbyType']==1){
								if($ContractRow['total_price']>0){
									$lodbypecent=$ContractRow['lobby']/$ContractRow['total_price'];
								}else{
									$lodbypecent=10;
								}
							}else{
								if($ContractRow['lobby']>100){
									$lodbypecent=$ContractRow['lobby']/$ContractRow['total_price'];
								}else{
									$lodbypecent=$ContractRow['lobby'];
								}
							}
							//Entertainment
							$entertaimentpecent=0;
							if($ContractRow['lodbyType']==1){
								if($ContractRow['total_price']>0){
									$entertaimentpecent=$ContractRow['entertaiment']/$ContractRow['total_price'];
								}else{
									$entertaimentpecent=1;
								}
							}else{
								if($ContractRow['entertaiment']>100){
									$entertaimentpecent=$ContractRow['entertaiment']/$ContractRow['total_price'];
								}else{
									$entertaimentpecent=$ContractRow['entertaiment'];
								}
							}

					}
					//End contract
					$contract_id= $listData["contract_id"];
					$category_id=1;
					$keywordProduct=null;
					
		    		$rateExchange=$rate_exchangeConvert["rate_exchange"];
		    		$product_category=100;
					$product_category_other=$listData["campaign_name"];
					$fielddata="click";
					$unit="CPC";
					$actual_cost_usd=$listData["cost"]; 
					$actual_cost_vnd=$listData["cost"]*$rateExchange; 
					if(!empty($checkexitRow)){
						$price_unit=$checkexitRow["price_unit"]; 
						$kpi=$checkexitRow["kpi"]; 
					}else{
						if($listData["click"]>0){
							$price_unit=$actual_cost_vnd/$listData["click"]; 
							$kpi=$listData[$fielddata]; 
						}else{
							$price_unit=0;
							$kpi=0;
						}
					}
					$unit=$unit; 
					$actual_sold=$price_unit*$kpi;
					$entertaiment=$entertaimentpecent*$actual_sold/100;
					$lodby=$lodbypecent*$actual_sold/100;
					$gp=0; 
					if($ContractRow && $actual_sold>0){
						$gp=(int)(($actual_sold-$actual_cost_vnd-$entertaiment-$lodby)/$actual_sold);
					}
					$gp_cover=1;  
					$start_date=$ContractRow["start_date"];  
					$end_date=$ContractRow["end_date"]; 
					$month=$month; 
					$year=$year;  
					if(!empty($checkexitRow)){
					 	$reportcontract=$this->getModel("Contract_report");
						$arrayadd=array('contract_id'=>$contract_id, 'channel'=>'DSP', 'category_id'=>$category_id, 'product_category'=>$product_category, 'product_category_other'=>$product_category_other, 'actual_sold'=>$actual_sold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'kpi'=>$kpi, 'actual_cost'=>$actual_cost_vnd, 'actual_cost_usd'=>$actual_cost_usd, 'price_unit'=>$price_unit, 'unit'=>$unit, 'margin'=>0, 'gp'=>$gp, 'gp_cover'=>$gp_cover, 'start_date'=>$start_date, 'end_date'=>$end_date, 'month'=>$month, 'year'=>$year, 'campaign_id'=>$campaign_id);
						$result=$reportcontract::where('campaign_id','=',$campaign_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}else{
						 $reportcontract=$this->getModel("Contract_report");
						 $reportcontract->contract_id=$contract_id;
						 $reportcontract->category_id=$category_id;
						 $reportcontract->channel='DSP';
						 $reportcontract->product_category=$product_category;
						 $reportcontract->product_category_other=$product_category_other;
						 $reportcontract->actual_sold=$actual_sold;
						 $reportcontract->lodby=$lodby;
						 $reportcontract->entertaiment=$entertaiment;
						 $reportcontract->kpi=$kpi;
						 $reportcontract->actual_cost=$actual_cost_vnd;
						 $reportcontract->actual_cost_usd=$actual_cost_usd;
						 $reportcontract->price_unit=$price_unit;
						 $reportcontract->unit=$unit;
						 $reportcontract->margin=0;
						 $reportcontract->gp=$gp;
						 $reportcontract->gp_cover=$gp_cover;
						 $reportcontract->start_date=$start_date;
						 $reportcontract->end_date=$end_date;
						 $reportcontract->month=$month;
						 $reportcontract->year=$year;
						 $reportcontract->campaign_id=$campaign_id;
						 $reportcontract->saveNoUser();
				    }
				}
          	}
	
			
			
		}
     protected function updateReport($month, $year){
            $googlereportmodel=$this->getModel("Summary_client_report");
			$facebookreportmodel=$this->getModel("Summary_facebook_report");
			$dspreportmodel=$this->getModel("Summary_client_dsp");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
			$rate_exchange=$this->getModel("Rate_exchange");
           	$listQuarter=getQuarterOfMonth($month);
		    $rate_exchangeConvert = $rate_exchange::where(array('quarter'=>$listQuarter, 'year'=>$year))->first();
		    $rateExchange=$rate_exchangeConvert["rate_exchange"];
		    // Facebook add
            $facebookListReport =$facebookreportmodel::where('month','=',$month)->where('year','=',$year)->get()->toArray();
            if(count($facebookListReport)>0){
				foreach($facebookListReport as $listData){
					$reportmodel=$this->getModel("Contract_report");
					$checkexitRow=$reportmodel::where('campaign_id','=', $listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->first();

					//Detail contract
					$ContractRow=null;
					$entertaiment=0;
					$lodby=0;
					$lodbypecent=10;
					$entertaimentpecent=1;
					$campaign_id=$listData["campaign_id"];
					if($listData["contract_id"]>0){
							$contractmodel=$this->getModel("Contract");
							$ContractRow=$contractmodel::where('id','=', $listData["contract_id"])->first();	
							$lodbypecent=0;
							if($ContractRow['entertaiment']>0){
								if($ContractRow['lodbyType']==1){
									if($ContractRow['total_price']>0){
										$lodbypecent=($ContractRow['lobby']/$ContractRow['total_price'])*100;
									}else{
										$lodbypecent=10;
									}
								}else{
									if($ContractRow['lobby']>100){
										$lodbypecent=($ContractRow['lobby']/$ContractRow['total_price'])*100;
									}else{
										$lodbypecent=$ContractRow['lobby'];
									}
								}
							}
							
							//Entertainment
							$entertaimentpecent=0;
							if($ContractRow['entertaiment']>0){
								if($ContractRow['lodbyType']==1){
									if($ContractRow['total_price']>0){
										$entertaimentpecent=($ContractRow['entertaiment']/$ContractRow['total_price'])*100;
									}else{
										$entertaimentpecent=1;
									}
								}else{
									if($ContractRow['entertaiment']>100){
										$entertaimentpecent=($ContractRow['entertaiment']/$ContractRow['total_price'])*100;
									}else{
										$entertaimentpecent=$ContractRow['entertaiment'];
									}
									
								}
							}

					}
					//End contract
					$contract_id= $listData["contract_id"];
					$category_id=1;
					$keywordProduct=null;
					if($listData["objective"]!=""){
						$modelkeyword=$this->getModel("Keyword_model");
						$keywordProduct = $modelkeyword::where(array('keyword'=>$listData["objective"], 'category'=>"product"))->get()->first();
					}
		    		$rateExchange=$rate_exchangeConvert["rate_exchange"];
		    		$product_category=100;
					$product_category_other="Other";
					$fielddata="post_engagement";
					$unit="CPC";
		    		if(!empty($keywordProduct)){
		    			$product_category=$keywordProduct["id"];
						$product_category_other=$keywordProduct["name"];
						$fielddata=$keywordProduct["field"];
						$unit=$keywordProduct["unit"];
		    		} 
					$actual_cost_usd=$listData["spend"]; 
					$actual_cost=$listData["spend"]*$rateExchange; 
					if(!empty($checkexitRow)){
						$price_unit=$checkexitRow["price_unit"]; 
						$kpi=$checkexitRow["kpi"]; 
					}else{
						$price_unit=($listData["spend"]/$listData["clicks"])*$rateExchange; 
						$kpi=$listData["clicks"]; 
					}
					$unit=$unit; 
					$actual_sold=$price_unit*$kpi;
					$entertaiment=$entertaimentpecent*$actual_sold/100;
					$lodby=$lodbypecent*$actual_sold/100;
					
					$gp=0; 
					if($ContractRow && $actual_sold>0){
						$gp=(int)(($actual_sold-$actual_cost-$entertaiment-$lodby)/$actual_sold);
					}
					$gp_cover=1;  
					$start_date=$ContractRow["start_date"];  
					$end_date=$ContractRow["end_date"]; 
					$month=$month; 
					$year=$year;  
					if(!empty($checkexitRow)){
					 	$reportcontract=$this->getModel("Contract_report");
						$arrayadd=array('contract_id'=>$contract_id, 'channel'=>'Facebook', 'category_id'=>$category_id, 'product_category'=>$product_category, 'product_category_other'=>$product_category_other, 'actual_sold'=>$actual_sold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'kpi'=>$kpi, 'actual_cost'=>$actual_cost, 'actual_cost_usd'=>$actual_cost_usd, 'price_unit'=>$price_unit, 'unit'=>$unit, 'margin'=>0, 'gp'=>$gp, 'gp_cover'=>$gp_cover, 'start_date'=>$start_date, 'end_date'=>$end_date, 'month'=>$month, 'year'=>$year, 'campaign_id'=>$campaign_id);
						$result=$reportcontract::where('campaign_id','=',$campaign_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}else{
						 $reportcontract=$this->getModel("Contract_report");
						 $reportcontract->contract_id=$contract_id;
						 $reportcontract->category_id=$category_id;
						 $reportcontract->channel='Facebook';
						 $reportcontract->product_category=$product_category;
						 $reportcontract->product_category_other=$product_category_other;
						 $reportcontract->actual_sold=$actual_sold;
						 $reportcontract->lodby=$lodby;
						 $reportcontract->entertaiment=$entertaiment;
						 $reportcontract->kpi=$kpi;
						 $reportcontract->actual_cost=$actual_cost;
						 $reportcontract->actual_cost_usd=$actual_cost_usd;
						 $reportcontract->price_unit=$price_unit;
						 $reportcontract->unit=$unit;
						 $reportcontract->margin=0;
						 $reportcontract->gp=$gp;
						 $reportcontract->gp_cover=$gp_cover;
						 $reportcontract->start_date=$start_date;
						 $reportcontract->end_date=$end_date;
						 $reportcontract->month=$month;
						 $reportcontract->year=$year;
						 $reportcontract->campaign_id=$campaign_id;
						 $reportcontract->saveNoUser();
				    }
				}
          	}
    
			//GOogle ads
            $googleListReport =$googlereportmodel::where('month','=',$month)->where('year','=',$year)->get()->toArray();
            if(count($googleListReport)>0){
				foreach($googleListReport as $listData){
					$reportmodel=$this->getModel("Contract_report");
					$checkexitRow=$reportmodel::where('campaign_id','=', $listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->first();
					//Detail contract
					$ContractRow=null;
					$entertaiment=0;
					$lodby=0;
					$lodbypecent=10;
					$entertaimentpecent=1;
					$campaign_id=$listData["campaign_id"];
					if($listData["contract_id"]>0){
							$contractmodel=$this->getModel("Contract");
							$ContractRow=$contractmodel::where('id','=', $listData["contract_id"])->first();	
							$lodbypecent=0;
							if($ContractRow['lodbyType']==1){
								if($ContractRow['total_price']>0){
									$lodbypecent=$ContractRow['lobby']/$ContractRow['total_price'];
								}else{
									$lodbypecent=10;
								}
							}else{
								if($ContractRow['lobby']>100){
									$lodbypecent=$ContractRow['lobby']/$ContractRow['total_price'];
								}else{
									$lodbypecent=$ContractRow['lobby'];
								}
							}
							//Entertainment
							$entertaimentpecent=0;
							if($ContractRow['lodbyType']==1){
								if($ContractRow['total_price']>0){
									$entertaimentpecent=$ContractRow['entertaiment']/$ContractRow['total_price'];
								}else{
									$entertaimentpecent=1;
								}
							}else{
								if($ContractRow['entertaiment']>100){
									$entertaimentpecent=$ContractRow['entertaiment']/$ContractRow['total_price'];
								}else{
									$entertaimentpecent=$ContractRow['entertaiment'];
								}
							}

					}
					//End contract
					$contract_id= $listData["contract_id"];
					$category_id=1;
					$keywordProduct=null;
					
		    		$rateExchange=$rate_exchangeConvert["rate_exchange"];
		    		$product_category=100;
					$product_category_other=$listData["campaign_name"];
					$fielddata="click";
					$unit="CPC";
					$actual_cost_usd=$listData["cost"]; 
					$actual_cost_vnd=$listData["cost"]*$rateExchange; 
					if(!empty($checkexitRow)){
						$price_unit=$checkexitRow["price_unit"]; 
						$kpi=$checkexitRow["kpi"]; 
					}else{
						if($listData["click"]>0){
							$price_unit=$actual_cost_vnd/$listData["click"]; 
							$kpi=$listData[$fielddata]; 
						}else{
							$price_unit=0;
							$kpi=0;
						}
					}
					$unit=$unit; 
					$actual_sold=$price_unit*$kpi;
					$entertaiment=$entertaimentpecent*$actual_sold/100;
					$lodby=$lodbypecent*$actual_sold/100;
					$gp=0; 
					if($ContractRow && $actual_sold>0){
						$gp=(int)(($actual_sold-$actual_cost_vnd-$entertaiment-$lodby)/$actual_sold);
					}
					$gp_cover=1;  
					$start_date=$ContractRow["start_date"];  
					$end_date=$ContractRow["end_date"]; 
					$month=$month; 
					$year=$year;  
					if(!empty($checkexitRow)){
					 	$reportcontract=$this->getModel("Contract_report");
						$arrayadd=array('contract_id'=>$contract_id, 'channel'=>'Google', 'category_id'=>$category_id, 'product_category'=>$product_category, 'product_category_other'=>$product_category_other, 'actual_sold'=>$actual_sold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'kpi'=>$kpi, 'actual_cost'=>$actual_cost_vnd, 'actual_cost_usd'=>$actual_cost_usd, 'price_unit'=>$price_unit, 'unit'=>$unit, 'margin'=>0, 'gp'=>$gp, 'gp_cover'=>$gp_cover, 'start_date'=>$start_date, 'end_date'=>$end_date, 'month'=>$month, 'year'=>$year, 'campaign_id'=>$campaign_id);
						$result=$reportcontract::where('campaign_id','=',$campaign_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}else{
						 $reportcontract=$this->getModel("Contract_report");
						 $reportcontract->contract_id=$contract_id;
						 $reportcontract->category_id=$category_id;
						 $reportcontract->channel='Google';
						 $reportcontract->product_category=$product_category;
						 $reportcontract->product_category_other=$product_category_other;
						 $reportcontract->actual_sold=$actual_sold;
						 $reportcontract->lodby=$lodby;
						 $reportcontract->entertaiment=$entertaiment;
						 $reportcontract->kpi=$kpi;
						 $reportcontract->actual_cost=$actual_cost_vnd;
						 $reportcontract->actual_cost_usd=$actual_cost_usd;
						 $reportcontract->price_unit=$price_unit;
						 $reportcontract->unit=$unit;
						 $reportcontract->margin=0;
						 $reportcontract->gp=$gp;
						 $reportcontract->gp_cover=$gp_cover;
						 $reportcontract->start_date=$start_date;
						 $reportcontract->end_date=$end_date;
						 $reportcontract->month=$month;
						 $reportcontract->year=$year;
						 $reportcontract->campaign_id=$campaign_id;
						 $reportcontract->saveNoUser();
				    }
				}
          	}
			
	}
    // Create report
    protected function updateReportFinance($month, $year){
            $reportmodel=$this->getModel("Contract_report");
			$reportmodelmodelfinance=$this->getModelFinal("Contract_report_finance");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
           	$listQuarter=getQuarterOfMonth($month);
		    // Facebook add
		    $reportmodelListReport =$reportmodel::selectRaw('contract_id, category_id, channel, product_category, product_category_other, start_date, end_date, month, year, gp_cover, sum(actual_sold) as actual_sold, sum(lodby) as lodby, sum(entertaiment) as entertaiment, sum(kpi) as kpi, sum(actual_cost) as actual_cost, sum(actual_cost_usd) as actual_cost_usd, sum(price_unit) as price_unit, unit, price_unit, avg(gp) as gp')->where('month','=',$month)->where('year','=',$year)->groupBy('contract_id', 'channel', 'month', 'year')->get()->toArray();
            if(count($reportmodelListReport)>0){
				foreach($reportmodelListReport as $listData){
					$contract_id=$listData["contract_id"];
					$checkexitRow=$reportmodelmodelfinance::where('channel','=', $listData["channel"])->where('contract_id','=',$contract_id)->where('month','=',$month)->where('year','=',$year)->first();
					$category_id=$listData["category_id"];
					$channel=$listData["channel"];
					$product_category=$listData["product_category"];
					$product_category_other=$listData["product_category_other"];
					$actual_sold=$listData["actual_sold"];
					$lodby=$listData["lodby"];
					$entertaiment=$listData["entertaiment"];
					$kpi=$listData["kpi"];
					$actual_cost=$listData["actual_cost"];
					$actual_cost_usd=$listData["actual_cost_usd"];
					$price_unit=$listData["price_unit"];
					$unit=$listData["unit"];
					$gp=$listData["gp"];
					$gp_cover=$listData["gp_cover"];
					$start_date=$listData["start_date"];
					$end_date=$listData["end_date"];
					$month=$listData["month"];
					$year=$listData["year"]; 
					if(!empty($checkexitRow)){ 
						$arrayadd=array('contract_id'=>$contract_id, 'channel'=>$channel, 'category_id'=>$category_id, 'product_category'=>$product_category, 'product_category_other'=>$product_category_other, 'actual_sold'=>$actual_sold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'kpi'=>$kpi, 'actual_cost'=>$actual_cost, 'actual_cost_usd'=>$actual_cost_usd, 'price_unit'=>$price_unit, 'unit'=>$unit, 'margin'=>0, 'gp'=>$gp, 'gp_cover'=>$gp_cover, 'start_date'=>$start_date, 'end_date'=>$end_date, 'month'=>$month, 'year'=>$year);
						$result=$reportmodelmodelfinance::where('contract_id','=',$contract_id)->where('channel','=',$channel)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}else{
						 $reportcontract=$this->getModelFinal("Contract_report_finance");
						 $reportcontract->contract_id=$contract_id;
						 $reportcontract->category_id=$category_id;
						 $reportcontract->channel=$channel;
						 $reportcontract->product_category=$product_category;
						 $reportcontract->product_category_other=$product_category_other;
						 $reportcontract->actual_sold=$actual_sold;
						 $reportcontract->lodby=$lodby;
						 $reportcontract->entertaiment=$entertaiment;
						 $reportcontract->kpi=$kpi;
						 $reportcontract->actual_cost=$actual_cost;
						 $reportcontract->actual_cost_usd=$actual_cost_usd;
						 $reportcontract->price_unit=$price_unit;
						 $reportcontract->unit=$unit;
						 $reportcontract->margin=0;
						 $reportcontract->gp=$gp;
						 $reportcontract->gp_cover=$gp_cover;
						 $reportcontract->start_date=$start_date;
						 $reportcontract->end_date=$end_date;
						 $reportcontract->month=$month;
						 $reportcontract->year=$year;
						 $reportcontract->saveNoUser();
				    }
				}
          	}
    }
    // Create report
    protected function updateReportFinanceBK($month, $year){
            $reportmodel=$this->getModel("Contract_report");
			$reportmodelmodelfinance=$this->getModelFinal("Contract_report_finance");
			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
           	$listQuarter=getQuarterOfMonth($month);
		    // Facebook add
            $reportmodelListReport =$reportmodel::where('month','=',$month)->where('year','=',$year)->get()->toArray();
            if(count($reportmodelListReport)>0){
				foreach($reportmodelListReport as $listData){
					$checkexitRow=$reportmodelmodelfinance::where('campaign_id','=', $listData["campaign_id"])->where('month','=',$month)->where('year','=',$year)->first();
					$contract_id=$listData["contract_id"];
					$category_id=$listData["category_id"];
					$channel=$listData["channel"];
					$product_category=$listData["product_category"];
					$product_category_other=$listData["product_category_other"];
					$actual_sold=$listData["actual_sold"];
					$lodby=$listData["lodby"];
					$entertaiment=$listData["entertaiment"];
					$kpi=$listData["kpi"];
					$actual_cost=$listData["actual_cost"];
					$actual_cost_usd=$listData["actual_cost_usd"];
					$price_unit=$listData["price_unit"];
					$unit=$listData["unit"];
					$gp=$listData["gp"];
					$gp_cover=$listData["gp_cover"];
					$start_date=$listData["start_date"];
					$end_date=$listData["end_date"];
					$month=$listData["month"];
					$year=$listData["year"];
					$campaign_id=$listData["campaign_id"];
					if(!empty($checkexitRow)){
						$arrayadd=array('contract_id'=>$contract_id, 'channel'=>'Facebook', 'category_id'=>$category_id, 'product_category'=>$product_category, 'product_category_other'=>$product_category_other, 'actual_sold'=>$actual_sold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'kpi'=>$kpi, 'actual_cost'=>$actual_cost, 'actual_cost_usd'=>$actual_cost_usd, 'price_unit'=>$price_unit, 'unit'=>$unit, 'margin'=>0, 'gp'=>$gp, 'gp_cover'=>$gp_cover, 'start_date'=>$start_date, 'end_date'=>$end_date, 'month'=>$month, 'year'=>$year, 'campaign_id'=>$campaign_id);
						$result=$reportmodelmodelfinance::where('campaign_id','=',$campaign_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}else{
						 $reportcontract=$this->getModelFinal("Contract_report_finance");
						 $reportcontract->contract_id=$contract_id;
						 $reportcontract->category_id=$category_id;
						 $reportcontract->channel='Facebook';
						 $reportcontract->product_category=$product_category;
						 $reportcontract->product_category_other=$product_category_other;
						 $reportcontract->actual_sold=$actual_sold;
						 $reportcontract->lodby=$lodby;
						 $reportcontract->entertaiment=$entertaiment;
						 $reportcontract->kpi=$kpi;
						 $reportcontract->actual_cost=$actual_cost;
						 $reportcontract->actual_cost_usd=$actual_cost_usd;
						 $reportcontract->price_unit=$price_unit;
						 $reportcontract->unit=$unit;
						 $reportcontract->margin=0;
						 $reportcontract->gp=$gp;
						 $reportcontract->gp_cover=$gp_cover;
						 $reportcontract->start_date=$start_date;
						 $reportcontract->end_date=$end_date;
						 $reportcontract->month=$month;
						 $reportcontract->year=$year;
						 $reportcontract->campaign_id=$campaign_id;
						 $reportcontract->saveNoUser();
				    }
				}
          	}
    }
	// Create report
    protected function updateKPI($month, $year){
            $reportmodel=$this->getModel("Contract_report");
			$reportmodelsummaryfacebook=$this->getModel("Summary_facebook_report");
			$summarygooglereportmodel=$this->getModel("Summary_client_report");
			$summarydspreportmodel=$this->getModel("Summary_client_dsp");

			$datestart=date($year."-".$month."-01");
			$number=cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$dateend=date($year."-".$month."-".$number);
           	$listQuarter=getQuarterOfMonth($month);
			$rate_exchange=$this->getModel("Rate_exchange");
			$rate_exchangeConvert = $rate_exchange::where(array('quarter'=>$listQuarter, 'year'=>$year))->first();
		    $rateExchange=$rate_exchangeConvert["rate_exchange"];
			 $reportmodelListReport =$reportmodel::where('campaign_id','>',0)->where('month','=',$month)->where('year','=',$year)->get()->toArray();
			//Dsp_report
            if(count($reportmodelListReport)>0){
				foreach($reportmodelListReport as $listData){
					$contractmodel=$this->getModel("Contract");
					$ContractRow=$contractmodel::where('id','=', $listData["contract_id"])->first();	
					$lodbypecent=0;
					if($ContractRow['entertaiment']>0){
						if($ContractRow['lodbyType']==1){
							if($ContractRow['total_price']>0){
								$lodbypecent=($ContractRow['lobby']/$ContractRow['total_price'])*100;
							}else{
								$lodbypecent=10;
							}
						}else{
							if($ContractRow['lobby']>100){
								$lodbypecent=($ContractRow['lobby']/$ContractRow['total_price'])*100;
							}else{
								$lodbypecent=$ContractRow['lobby'];
							}
						}
					}
					//Entertainment
					$entertaimentpecent=0;
					if($ContractRow['entertaiment']>0){
						if($ContractRow['lodbyType']==1){
							if($ContractRow['total_price']>0){
								$entertaimentpecent=($ContractRow['entertaiment']/$ContractRow['total_price'])*100;
							}else{
								$entertaimentpecent=1;
							}
						}else{
							if($ContractRow['entertaiment']>100){
								$entertaimentpecent=($ContractRow['entertaiment']/$ContractRow['total_price'])*100;
							}else{
								$entertaimentpecent=$ContractRow['entertaiment'];
							}
						}
					}
					$contract_id=$listData["contract_id"];
					$campaign_id=$listData["campaign_id"];
					$kpi=$listData["kpi"];
					$unit=$listData["unit"];
					/* Facebook */
					$checkexitRow=$reportmodelsummaryfacebook::selectRaw('objective, sum(impressions) as impression, sum(clicks) as clicks, sum(reach) as reach, sum(post_engagement) as post_engagement, sum(video_10_sec_watched_actions) as video_10_sec_watched_actions, sum(page_like) as page_like, sum(mobile_app_install) as mobile_app_install, sum(app_install) as app_install, sum(spend) as spend')->where('contract_id','=', $contract_id)->where('campaign_id','=', $campaign_id)->where('month','=',$month)->where('year','=',$year)->groupBy('contract_id','campaign_id','month', 'year')->get()->first();
					if(!empty($checkexitRow)){
						$kpifinish=0;
						switch ($unit) {
							case "CPC":
								if($checkexitRow["objective"]=="POST_ENGAGEMENT"){
									$kpifinish=$checkexitRow["clicks"];
								}elseif($checkexitRow["objective"]=="REACH"){
									$kpifinish=$checkexitRow["reach"];
								}elseif($checkexitRow["objective"]=="LINK_CLICKS"){
									$kpifinish=$checkexitRow["clicks"];
								}else{
									$kpifinish=$checkexitRow["post_engagement"];
								}
								break;
							case "CPM":
								$kpifinish=$checkexitRow["impression"]/1000;
								break;
							case "CPA":
								$kpifinish=$checkexitRow["post_engagement"];
								break;
							case "CPI":
								$kpifinish=$checkexitRow["mobile_app_install"]+$checkexitRow["app_install"];
								break;
							case "CPER":
								$kpifinish=$checkexitRow["video_10_sec_watched_actions"];
								break;
							case "CPE":
								$kpifinish=$checkexitRow["video_10_sec_watched_actions"];
								break;
							case "Like":
								$kpifinish=$checkexitRow["page_like"];
								break;
							case 'default':
								$kpifinish=$checkexitRow["post_engagement"];
								break;
						}
						if($kpifinish<$kpi){
							$kpi=$kpifinish;
						}
						$gp=0; 
						$actualsold=0;
						$entertaiment=0;
						$lodby=0;
						$actual_cost_usd=$checkexitRow["spend"]; 
						$actual_cost_vnd=$actual_cost_usd*$rateExchange; 
						if($listData["gp_cover"]==1){
							$actualsold=$listData["price_unit"]*$kpi;
							if($actualsold>0){
								$entertaiment=$entertaimentpecent*$actualsold/100;
								$lodby=$lodbypecent*$actualsold/100;
								$gp=(int)(($actualsold-$actual_cost_vnd-$entertaiment-$lodby)/$actualsold);
							}
						}
						$arrayadd=array('kpi_system'=>$kpifinish, 'actual_sold'=>$actualsold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'actual_cost'=>$actual_cost_vnd, 'actual_cost_usd'=>$actual_cost_usd, 'gp'=>$gp);
						$result=$reportmodel::where('campaign_id','=',$campaign_id)->where('contract_id','=', $contract_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}
					/*End facebook*/
					/* Google report */
					$checkexitRowGoogle=$summarygooglereportmodel::selectRaw('sum(impression) as impression, sum(click) as clicks, sum(cost) as cost')->where('contract_id','=', $contract_id)->where('campaign_id','=', $campaign_id)->where('month','=',$month)->where('year','=',$year)->groupBy('contract_id','campaign_id','month', 'year')->get()->first();
					if(!empty($checkexitRowGoogle)){
						$kpifinish=0;
						switch ($unit) {
							case "CPC":
								$kpifinish=$checkexitRowGoogle["clicks"];
								break;
							case "CPM":
								$kpifinish=$checkexitRowGoogle["impression"]/1000;
								break;
							case 'default':
								$kpifinish=$checkexitRowGoogle["clicks"];
								break;
						}
						if($kpifinish<$kpi){
							$kpi=$kpifinish;
						}
						$gp=0; 
						$actualsold=0;
						$entertaiment=0;
						$lodby=0;
						$actual_cost_usd=$checkexitRowGoogle["cost"]; 
						$actual_cost_vnd=$actual_cost_usd*$rateExchange; 
						if($listData["gp_cover"]==1){
							$actualsold=$listData["price_unit"]*$kpi;
							if($actualsold>0){
								$entertaiment=$entertaimentpecent*$actualsold/100;
								$lodby=$lodbypecent*$actualsold/100;
								$gp=(int)(($actualsold-$actual_cost_vnd-$entertaiment-$lodby)/$actualsold);
							}
						}
						$arrayadd=array('kpi_system'=>$kpifinish, 'actual_sold'=>$actualsold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'actual_cost'=>$actual_cost_vnd, 'actual_cost_usd'=>$actual_cost_usd, 'gp'=>$gp);
						$result=$reportmodel::where('campaign_id','=',$campaign_id)->where('contract_id','=', $contract_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}
					/* End google */
					/* DSP report */
					$checkexitRowDSP=$summarydspreportmodel::selectRaw('sum(impression) as impression, sum(click) as clicks, sum(cost) as cost')->where('contract_id','=', $contract_id)->where('campaign_id','=', $campaign_id)->where('month','=',$month)->where('year','=',$year)->groupBy('contract_id','campaign_id','month', 'year')->get()->first();
					if(!empty($checkexitRowDSP)){
						$kpifinish=0;
						switch ($unit) {
							case "CPC":
								$kpifinish=$checkexitRowDSP["clicks"];
								break;
							case "CPM":
								$kpifinish=$checkexitRowDSP["impression"]/1000;
								break;
							case 'default':
								$kpifinish=$checkexitRowDSP["clicks"];
								break;
						}
						if($kpifinish<$kpi){
							$kpi=$kpifinish;
						}
						$gp=0; 
						$actualsold=0;
						$entertaiment=0;
						$lodby=0;
						$actual_cost_usd=$checkexitRowDSP["cost"]; 
						$actual_cost_vnd=$actual_cost_usd*$rateExchange; 
						if($listData["gp_cover"]==1){
							$actualsold=$listData["price_unit"]*$kpi;
							if($actualsold>0){
								$entertaiment=$entertaimentpecent*$actualsold/100;
								$lodby=$lodbypecent*$actualsold/100;
								$gp=(int)(($actualsold-$actual_cost_vnd-$entertaiment-$lodby)/$actualsold);
							}
						}
						$arrayadd=array('kpi_system'=>$kpifinish, 'actual_sold'=>$actualsold, 'lodby'=>$lodby, 'entertaiment'=>$entertaiment, 'actual_cost'=>$actual_cost_vnd, 'actual_cost_usd'=>$actual_cost_usd, 'gp'=>$gp);
						$result=$reportmodel::where('campaign_id','=',$campaign_id)->where('contract_id','=', $contract_id)->where('month','=',$month)->where('year','=',$year)->update($arrayadd);
					}
					/* End DSP report */
				}
          	}
			//End DSP
			
    }
    protected function valid_email($email) {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

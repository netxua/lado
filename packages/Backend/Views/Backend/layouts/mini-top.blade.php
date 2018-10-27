<div class="clearfix search-glose" >
    <div class="clearfix">
        <ul class="nav nav-inline coz-tab clearfix" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#search_glose_clients" role="tab" rel="nofollow">
                    Tìm khách hàng                            
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search_glose_garage" role="tab" rel="nofollow">
                    Tìm chành xe         
                </a>
            </li>

            <li class="nav-item has-extra-charges" >
                <a class="nav-link" data-toggle="tab" href="#search_glose_invoice" role="tab" rel="nofollow">
                    Tìm đơn hàng        
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content clearfix" >
        <div class="tab-pane fade in clearfix active" id="search_glose_clients" role="tabpanel">
            <div class="content-search-glose" >
                <div class="row" >
                    <div class="col-sm-6" >
                        <form method="get" role="form" data-form="_searchGloseClients"  >
                            <div class="row" >
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Từ ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchstart" class="form-control input-sm input-date" placeholder="Từ ngày" value="<?php echo date('Y-m-d',strtotime('-1 years')) ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Đến ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchend" class="form-control input-sm input-date" placeholder="Đến ngày" value="<?php echo date('Y-m-d') ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="clearfix" >
                                    <div class="input-group">
                                        <div class="row row-coz-search" >
                                            <div class="col-xs-12 col-coz-search" >
                                                <input type="text" name="_searchkeyword" class="form-control" placeholder="Bạn muốn tìm ?" value="" data-input="keyword" >
                                            </div>
                                        </div>
                                        <span class="input-group-btn">
                                            <button type="submit" name="seach" class="btn btn-flat btn-search-glose"  data-btn="_searchGloseClients" >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade in clearfix" id="search_glose_garage" role="tabpanel">
            <div class="content-search-glose" >
                <div class="row" >
                    <div class="col-sm-6" >
                        <form method="get" role="form" data-form="_searchGloseGarage"  >
                            <div class="row" >
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Từ ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchstart" class="form-control input-sm input-date" placeholder="Từ ngày" value="<?php echo date('Y-m-d',strtotime('-1 years')) ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Đến ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchend" class="form-control input-sm input-date" placeholder="Đến ngày" value="<?php echo date('Y-m-d') ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="clearfix" >
                                    <div class="input-group">
                                        <div class="row row-coz-search" >
                                            <div class="col-xs-12 col-coz-search" >
                                                <input type="text" name="_searchkeyword" class="form-control" placeholder="Bạn muốn tìm ?" value="" data-input="keyword" >
                                            </div>
                                        </div>
                                        <span class="input-group-btn">
                                            <button type="submit" name="seach" class="btn btn-flat btn-search-glose"  data-btn="_searchGloseGarage" >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade in clearfix" id="search_glose_invoice" role="tabpanel">
            <div class="content-search-glose" >
                <div class="row" >
                    <div class="col-sm-6" >
                        <form method="get" role="form" data-form="_searchGloseInvoice"  >
                            <div class="row" >
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Từ ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchstart" class="form-control input-sm input-date" placeholder="Từ ngày" value="<?php echo date('Y-m-d',strtotime('-1 years')) ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group" >
                                        <div class="row" >
                                            <div class="col-sm-12" >
                                                <label>
                                                    Đến ngày
                                                </label>
                                            </div>
                                            <div class="col-sm-12" >
                                                <input type="text" name="_searchend" class="form-control input-sm input-date" placeholder="Đến ngày" value="<?php echo date('Y-m-d') ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="clearfix" >
                                    <div class="input-group">
                                        <div class="row row-coz-search" >
                                            <div class="col-xs-12 col-coz-search" >
                                                <input type="text" name="_searchkeyword" class="form-control" placeholder="Bạn muốn tìm ?" value="" data-input="keyword" >
                                            </div>
                                        </div>
                                        <span class="input-group-btn">
                                            <button type="submit" name="seach" class="btn btn-flat btn-search-glose"  data-btn="_searchGloseInvoice" >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
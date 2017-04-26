
<script>
    function ClickBC1(url){
        $('#frm_bc1').attr('action',url);
        $('#frm_bc1').submit();
    }
    function ClickBC2(url){
        $('#frm_bc2').attr('action',url);
        $('#frm_bc2').submit();
    }
    function ClickBC3(url){
        $('#frm_bc3').attr('action',url);
        $('#frm_bc3').submit();
    }
    function ClickBC4(url){
        $('#frm_bc4').attr('action',url);
        $('#frm_bc4').submit();
    }

</script>

<!--Modal Thoại BC1-->
<div id="BC1-thoai-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        {!! Form::open(['url'=>'/reports/dich_vu_luu_tru/BC1','target'=>'_blank' , 'id' => 'frm_bc1', 'class'=>'form-horizontal form-validate']) !!}
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Báo cáo tổng hợp hồ sơ kê khai giá</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Từ ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngaytu" name="ngaytu" class="form-control" value="{{intval(date('Y')).'-01-01'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đến ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngayden" name="ngayden" class="form-control" value="{{intval(date('Y')).'-12-31'}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Loại hạng</b></label>
                        <div class="col-md-6 ">
                            <select id="loaihang" name="loaihang" class="form-control select2me">
                                <option value="all">--Tất cả--</option>
                                <option value="1">1 sao</option>
                                <option value="1.5">1.5 sao</option>
                                <option value="2">2 sao</option>
                                <option value="2.5">2.5 sao</option>
                                <option value="3">3 sao</option>
                                <option value="3.5">3.5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="4.5">4.5 sao</option>
                                <option value="5">5 sao</option>
                                <option value="K">Khác (Nhà nghỉ)</option>
                            </select>
                        </div>
                    </div>

                    @if(session('admin')->level == 'T')
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đơn vị chủ quản</b></label>
                        <div class="col-md-6 ">
                            <select class="form-control select2me" name="cqcq" id="cqcq">
                                <option value="all">--Tất cả--</option>
                                @foreach($model as $cqcq)
                                    <option value="{{$cqcq->maqhns}}">{{$cqcq->tendv}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-success" onclick="ClickBC1('/reports/dich_vu_luu_tru/BC1')">Đồng ý</button>
                <!--button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="ClickPL1Excel('/reports/tt55-2011-BTC/PL1Excel')">Xuất Excel</button-->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </form>
</div>
<!--Modal Thoại Bc2-->
<div id="BC2-thoai-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        {!! Form::open(['url'=>'/reports/dich_vu_luu_tru/BC2','target'=>'_blank' , 'id' => 'frm_bc2', 'class'=>'form-horizontal form-validate']) !!}
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Báo cáo chi tiết hồ sơ kê khai giá</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Từ ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngaytu" name="ngaytu" class="form-control" value="{{intval(date('Y')).'-01-01'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đến ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngayden" name="ngayden" class="form-control" value="{{intval(date('Y')).'-12-31'}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Loại hạng</b></label>
                        <div class="col-md-6 ">
                            <select id="loaihang" name="loaihang" class="form-control select2me">
                                <option value="all">--Tất cả--</option>
                                <option value="1">1 sao</option>
                                <option value="1.5">1.5 sao</option>
                                <option value="2">2 sao</option>
                                <option value="2.5">2.5 sao</option>
                                <option value="3">3 sao</option>
                                <option value="3.5">3.5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="4.5">4.5 sao</option>
                                <option value="5">5 sao</option>
                                <option value="K">Khác (Nhà nghỉ)</option>
                            </select>
                        </div>
                    </div>

                    @if(session('admin')->level == 'T')
                        <div class="form-group">
                            <label class="col-md-4 control-label"><b>Đơn vị</b></label>
                            <div class="col-md-6 ">
                                <select class="form-control" name="cqcq" id="cqcq">
                                    <option value="all">--Tất cả--</option>
                                    @foreach($model as $cqcq)
                                        <option value="{{$cqcq->maqhns}}">{{$cqcq->tendv}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-success" onclick="ClickBC2('/reports/dich_vu_luu_tru/BC2')">Đồng ý</button>
                <!--button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="ClickPL1Excel('/reports/tt55-2011-BTC/PL1Excel')">Xuất Excel</button-->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </form>
</div>
<!--Modal Thoại BC3-->
<div id="BC3-thoai-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        {!! Form::open(['url'=>'/reports/dich_vu_luu_tru/BC3','target'=>'_blank' , 'id' => 'frm_bc3', 'class'=>'form-horizontal form-validate']) !!}
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Báo cáo tổng hợp hồ sơ kê khai giá</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Từ ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngaytu" name="ngaytu" class="form-control" value="{{intval(date('Y')).'-01-01'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đến ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngayden" name="ngayden" class="form-control" value="{{intval(date('Y')).'-12-31'}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Loại hạng</b></label>
                        <div class="col-md-6 ">
                            <select id="loaihang" name="loaihang" class="form-control select2me">
                                <option value="all">--Tất cả--</option>
                                <option value="1">1 sao</option>
                                <option value="1.5">1.5 sao</option>
                                <option value="2">2 sao</option>
                                <option value="2.5">2.5 sao</option>
                                <option value="3">3 sao</option>
                                <option value="3.5">3.5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="4.5">4.5 sao</option>
                                <option value="5">5 sao</option>
                                <option value="K">Khác (Nhà nghỉ)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đơn vị</b></label>
                        <div class="col-md-6">
                            <select class="form-control select2me" name="masothue" id="masothue">
                                @foreach($model_donvi as $cqcq)
                                    <option value="{{$cqcq->masothue}}">{{$cqcq->tendn}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-success" onclick="ClickBC3('/reports/dich_vu_luu_tru/BC3')">Đồng ý</button>
                <!--button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="ClickPL1Excel('/reports/tt55-2011-BTC/PL1Excel')">Xuất Excel</button-->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </form>
</div>
<!--Modal Thoại Bc4-->
<div id="BC4-thoai-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        {!! Form::open(['url'=>'/reports/dich_vu_luu_tru/BC4','target'=>'_blank' , 'id' => 'frm_bc4', 'class'=>'form-horizontal form-validate']) !!}
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Báo cáo chi tiết hồ sơ kê khai giá</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Từ ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngaytu" name="ngaytu" class="form-control" value="{{intval(date('Y')).'-01-01'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đến ngày</b></label>
                        <div class="col-md-6 ">
                            <input type="date" id="ngayden" name="ngayden" class="form-control" value="{{intval(date('Y')).'-12-31'}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Loại hạng</b></label>
                        <div class="col-md-6 ">
                            <select id="loaihang" name="loaihang" class="form-control select2me">
                                <option value="all">--Tất cả--</option>
                                <option value="1">1 sao</option>
                                <option value="1.5">1.5 sao</option>
                                <option value="2">2 sao</option>
                                <option value="2.5">2.5 sao</option>
                                <option value="3">3 sao</option>
                                <option value="3.5">3.5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="4.5">4.5 sao</option>
                                <option value="5">5 sao</option>
                                <option value="K">Khác (Nhà nghỉ)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><b>Đơn vị</b></label>
                        <div class="col-md-6">
                            <select class="form-control select2me" name="masothue" id="masothue">
                                @foreach($model_donvi as $cqcq)
                                    <option value="{{$cqcq->masothue}}">{{$cqcq->tendn}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-success" onclick="ClickBC4('/reports/dich_vu_luu_tru/BC4')">Đồng ý</button>
                <!--button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="ClickPL1Excel('/reports/tt55-2011-BTC/PL1Excel')">Xuất Excel</button-->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </form>
</div>
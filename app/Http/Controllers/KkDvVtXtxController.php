<?php

namespace App\Http\Controllers;

use App\CbKkDvVtXtx;
use App\DmDvVtXtx;
use App\GeneralConfigs;
use App\KkDvVtXtxCt;
use App\KkDvVtXtxCtDf;
use App\PagDvVtXtx;
use App\PagDvVtXtx_Temp;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\KkDvVtXtx;
use App\DonViDvVt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KkDvVtXtxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::has('admin')) {
            //$datetime = Carbon::now()->toDateTimeString();
            if(session('admin')->level == 'T')
                $model = KkDvVtXtx::where('trangthai','<>','Chờ chuyển')
                    ->where('trangthai','<>','Bị trả lại')
                    ->orderBy('ngaynhap', 'esc')
                    ->get();
            else
                $model = KkDvVtXtx::where('masothue',session('admin')->mahuyen)
                    ->orderBy('ngaynhap', 'esc')
                    ->get();
            $per=array(
                'create'=>can('dvvtxtx','create'),
                'edit' =>can('dvvtxtx','edit'),
                'delete' =>can('dvvtxtx','delete'),
                'approve'=>can('dvvtxtx','approve')
            );
            return view('manage.dvvt.dvxtx.kkdv.index')
                ->with('model',$model)
                ->with('per',$per)
                ->with('url','/dich_vu_van_tai/dich_vu_xe_taxi/')
                ->with('pageTitle','Kê khai giá dịch vụ vận tải');
        }else
            return view('errors.notlogin');
    }

    public function getTenDV($atenDV, $array){
        foreach($atenDV as $tenDV){
            if($tenDV->masothue == $array->masothue)
                $array->tendonvi = $tenDV->tendonvi;
        }
    }

    public function indexXD($thang,$nam,$pl)
    {
        if (Session::has('admin')) {
            if($pl == 'cho_nhan')
                $model = KkDvVtXtx::where('trangthai','Chờ nhận')
                    ->whereMonth('ngaychuyen', $thang)
                    ->whereYear('ngaychuyen', $nam)
                    ->orderBy('ngaynhap', 'esc')
                    ->get();
            else
                $model = CbKkDvVtXtx::whereMonth('ngaychuyen', $thang)
                    ->whereYear('ngaychuyen', $nam)
                    //->groupBy('masothue')
                    ->orderBy('ngaynhap', 'esc')
                    ->get();

            $modeldv = DonViDvVt::all();
            foreach($model as $dv){
                $this->getTenDV($modeldv, $dv);
            }

            $per=array(
                'create'=>can('dvvtxtx','create'),
                'edit' =>can('dvvtxtx','edit'),
                'delete' =>can('dvvtxtx','delete'),
                'approve'=>can('dvvtxtx','approve')
            );

            return view('manage.dvvt.dvxk.xetduyet.index')
                ->with('model',$model)
                ->with('thang',$thang)
                ->with('nam',$nam)
                ->with('pl',$pl)
                ->with('per',$per)
                ->with('url','/dich_vu_van_tai/dich_vu_xe_taxi/')
                ->with('pageTitle','Xét duyệt kê khai giá dịch vụ vận tải');
        }else
            return view('errors.notlogin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::has('admin')) {
            $masothue=session('admin')->mahuyen;
            KkDvVtXtxCtDf::where('masothue', $masothue)->delete();
            PagDvVtXtx_Temp::where('masothue', $masothue)->delete();
            //$sql=" INSERT INTO thamdinhgia (masothue,diemdau,diemcuoi,madichvu,loaixe,tendichvu,qccl,dvt) SELECT masothue,diemdau,diemcuoi,madichvu,loaixe,tendichvu,qccl,dvt FROM dmDvVtXtx where masothue='". session('admin')->mahuyen."'";
            //DB::statement($sql);

            $modelCB=CbKkDvVtXtx::select('socv','ngaynhap','masokk')->where('masothue', $masothue)->first();
            $solk=null;
            $ngaylk=null;
            $masokk=null;

            if (isset($modelCB)) {
                //dd($modelCB);
                $solk = $modelCB->socv;
                $ngaylk = $modelCB->ngaynhap;
                $masokk = $modelCB->masokk;
            }
            $mdDV=DmDvVtXtx::where('masothue',$masothue)->get();
            foreach($mdDV as $dv){
                $mdkk = new KkDvVtXtxCtDf();
                $mdkk->masothue = $masothue;
                $mdkk->madichvu = $dv->madichvu;
                $mdkk->loaixe = $dv->loaixe;
                $mdkk->tendichvu = $dv->tendichvu;
                $mdkk->qccl = $dv->qccl;
                $mdkk->dvt = $dv->dvt;
                $mdCT = KkDvVtXtxCt::select('giakk')->where('masokk', $masokk)->where('madichvu', $dv->madichvu)->first();

                $mdkk->giakklk = count($mdCT)>0 ? $mdCT->giakk : 0;
                $mdkk->giakk =0;
                $mdkk->save();

                //Phương án giá
                $m_pag=new PagDvVtXtx_Temp();
                $m_pag->masothue = $masothue;
                $m_pag->madichvu = $dv->madichvu;
                $m_pag->save();
            }

            $model=KkDvVtXtxCtDf::where('masothue', session('admin')->mahuyen)->get();
            return view('manage.dvvt.dvxtx.kkdv.create')
                ->with('pageTitle','Kê khai mới giá dịch vụ vận tải')
                ->with('socvlk',$solk)
                ->with('ngaycvlk',$ngaylk)
                ->with('url','/dich_vu_van_tai/dich_vu_xe_taxi/')
                ->with('model',$model);
        }else
            return view('errors.notlogin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Session::has('admin')) {
            $makk=session('admin')->mahuyen . '.' . getdate()[0];
            $masothue=session('admin')->mahuyen;
            $insert = $request->all();
            //dd($insert['ngaynhaplk']);
            $model = new KkDvVtXtx();
            $model->masokk = $makk;
            $model->ngaynhap = $insert['ngaynhap'];
            $model->socv = $insert['socv'];
            $model->socvlk = $insert['socvlk'];
            $model->ngaynhaplk = $insert['ngaynhaplk']==''?null:$insert['ngaynhaplk'];
            $model->ngayhieuluc = $insert['ngayhieuluc'];
            $model->trangthai = 'Chờ chuyển';
            $model->masothue = $masothue;
            $model->uudai = $insert['uudai'];
            $model->ghichu = $insert['ghichu'];
            $model->save();
            //Chi tiết kê khai
            $m_kkdf=KkDvVtXtxCtDf::select('madichvu','loaixe','tendichvu','qccl','dvt','giakk','giakklk',DB::raw("'".$makk."' as masokk"))
                ->where('masothue', $masothue)
                ->get()->toarray();
            KkDvVtXtxCt::insert($m_kkdf);
            //Phương án giá
            $m_pag=PagDvVtXtx_Temp::select('masothue','masokk','madichvu','sanluong','cpnguyenlieutt','cpcongnhantt','cpkhauhaott','cpsanxuatdt','cpsanxuatc','cptaichinh','cpbanhang','cpquanly',DB::raw("'".$makk."' as masokk"))
                ->where('masothue', $masothue)
                ->get()->toarray();
            PagDvVtXtx::insert($m_pag);

            return redirect('/dich_vu_van_tai/dich_vu_xe_taxi/ke_khai');
        }else
            return view('errors.notlogin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Session::has('admin')) {
            $model = KkDvVtXtx::findOrFail($id);
            $modeldv=KkDvVtXtxCt::where('masokk',$model->masokk)->get();
            return view('manage.dvvt.dvxtx.kkdv.edit')
                ->with('model',$model)
                ->with('modeldv',$modeldv)
                ->with('url','/dich_vu_van_tai/dich_vu_xe_taxi/')
                ->with('pageTitle','Chỉnh sửa kê khai giá dịch vụ vận tải');
        }else
            return view('errors.notlogin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Session::has('admin')) {
            $update = $request->all();
            $model = KkDvVtXtx::findOrFail($id);
            $model->ngaynhap = $update['ngaynhap'];
            $model->socv = $update['socv'];
            $model->ngaynhaplk = $update['ngaynhaplk']==''?null:$update['ngaynhaplk'];
            $model->socvlk = $update['socvlk'];
            $model->ngayhieuluc = $update['ngayhieuluc'];
            $model->ghichu = $update['ghichu'];
            $model->uudai = $update['uudai'];
            $model->save();
            return redirect('/dich_vu_van_tai/dich_vu_xe_taxi/ke_khai');
        }else
            return view('errors.notlogin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Session::has('admin')) {
            $input = $request->all();
            $model = KkDvVtXtx::where('id',$input['iddel'])
                ->first();
            //dd($model);
            if($model->delete()) {
                KkDvVtXtxCt::where('masokk', $model->masokk)->delete();
                PagDvVtXtx::where('masokk', $model->masokk)->delete();
            }
            return redirect('/dich_vu_van_tai/dich_vu_xe_taxi/ke_khai');
        }else
            return view('errors.notlogin');
    }

    public function chuyen(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        if(isset($inputs['id'])){
            $model = KkDvVtXtx::findOrFail($inputs['id']);
            $model->trangthai = 'Chờ nhận';
            $model->ttnguoinop = $inputs['ttnguoinop'];
            $model->ngaychuyen = Carbon::now()->toDateTimeString();
            $model->save();
            $result['message'] = 'Chuyển thành công.';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function accept(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }

        $inputs = $request->all();

        if(isset($inputs['id'])){
            $id=$inputs['id'];
            $model = KkDvVtXtx::findOrFail($id);
            $model->trangthai = 'Duyệt';
            $model->ngaynhan = $inputs['ngaynhan'];
            $model->sohsnhan = $inputs['sohsnhan'];
            if($model->save()){
                $modelconfig = GeneralConfigs::first();
                $modelconfig->sodvvt = getGeneralConfigs()['sodvvt'] + 1;
                $modelconfig->save();
            }

            $result['message'] = 'Xét duyệt thành công.';
            $result['status'] = 'success';

            $modelkk = KkDvVtXtx::findOrFail($id);
            $modeldel = CbKkDvVtXtx::where('masothue',$modelkk->masothue)->delete();

            DB::statement("INSERT INTO cbkkDvVtXtx SELECT * FROM kkDvVtXtx WHERE id='".$id."'");
            DB::statement("Update cbkkDvVtXtx set trangthai='Đang công bố' WHERE id='".$id."'");
        }
        die(json_encode($result));
    }

    public function nhanhs(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $input = $request->all();
        $id=$input['id'];
        if (Session::has('admin')) {
            $model = KkDvVtXtx::findOrFail($id);
            $model->ngaynhan = $input['ngaynhan'];
            $model->sohsnhan = $input['sohsnhan'];
            $model->trangthai = 'Chờ duyệt';
            if($model->save()){
                $modelconfig = GeneralConfigs::first();
                $modelconfig->sodvvt = getGeneralConfigs()['sodvvt'] + 1;
                $modelconfig->save();
            }
            $result['message'] = 'Trả lại thành công.';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function tralai(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        if(isset($inputs['id'])){
            $model = KkDvVtXtx::findOrFail($inputs['id']);
            $model->trangthai = 'Bị trả lại';
            $model->lydo = $inputs['lydo'];
            /* có nên xóa thông tin người nôp khi trả lại ko ?????
            $model->nguoinop = $inputs['nguoinop'];
            $model->ngaychuyen = $inputs['ngaychuyen'];
            $model->sdtnn = $inputs['sdtnn'];
            $model->faxnn = $inputs['faxnn'];
            $model->emailnn = $inputs['emailnn'];
            */
            $model->save();
            $result['message'] = 'Trả lại thành công.';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function updategiadv(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        if(isset($inputs['id'])){
            $inputs['giakk'] = getDbl($inputs['giakk']);
            $inputs['giakklk'] = getDbl($inputs['giakklk']);

            $model = KkDvVtXtxCtDf::findOrFail($inputs['id']);
            $model->giakk = $inputs['giakk'];
            $model->giakklk = $inputs['giakklk'];
            $model->save();
            //Trả lại kết quả
            $result['message'] = '<tbody id="noidung">';
            $DMDV = KkDvVtXtxCtDf::where('masothue', session('admin')->mahuyen)->get();

            $i=1;
            foreach($DMDV as $dv) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center;">'.$i++.'</td>';
                $result['message'] .= '<td name = "loaixe">'.$dv->loaixe.'</td>';
                $result['message'] .= '<td name = "tendichvu">'.$dv->tendichvu.'</td>';
                $result['message'] .= '<td name = "giakklk">'.number_format($dv->giakklk).'</td>';
                $result['message'] .= '<td name = "giakk">'.number_format($dv->giakk).'</td>';
                $result['message'] .= '<td>'
                                .'<button type="button" data-target="#modal-create" '
                                .'data-toggle="modal" class="btn btn-default btn-xs mbs"'
                                .'onclick="editItem(this,'.$dv->id.')"><i'
                                .' class="fa fa-edit"></i>&nbsp;Kê khai giá'
                                .'</button>';
                $result['message'] .='</br>';
                $result['message'] .='<button type="button" data-target="#modal-pagia-create"
                                    data-toggle="modal" class="btn btn-default btn-xs mbs"
                                    onclick="getpag_temp(&apos;'.$dv->madichvu.'&apos;)"><i class="fa fa-edit"></i>&nbsp;Phương án giá';
                $result['message'] .='</button>';

                $result['message'] .= '</td >';
                $result['message'] .= '</tr >';
            }
            $result['message'] .= '</tbody>';
            $result['status'] = 'success';
        }

        die(json_encode($result));
    }

    public function updategiadvct(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        if(isset($inputs['id'])){
            $inputs['giakk'] = getDbl($inputs['giakk']);
            $inputs['giakklk'] = getDbl($inputs['giakklk']);

            $model = KkDvVtXtxCt::findOrFail($inputs['id']);
            $model->giakk = $inputs['giakk'];
            $model->giakklk = $inputs['giakklk'];
            $model->save();
            //Trả lại kết quả
            $result['message'] = '<tbody id="noidung">';
            $DMDV = KkDvVtXtxCt::where('masokk', $model->masokk)->get();

            $i=1;
            foreach($DMDV as $dv) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center;">'.$i++.'</td>';
                $result['message'] .= '<td name = "loaixe">'.$dv->loaixe.'</td>';
                $result['message'] .= '<td name = "tendichvu">'.$dv->tendichvu.'</td>';
                $result['message'] .= '<td name = "giakklk">'.number_format($dv->giakklk).'</td>';
                $result['message'] .= '<td name = "giakk">'.number_format($dv->giakk).'</td>';
                $result['message'] .= '<td>'
                    .'<button type="button" data-target="#modal-create" '
                    .'data-toggle="modal" class="btn btn-default btn-xs mbs"'
                    .'onclick="editItem(this,'.$dv->id.')"><i'
                    .' class="fa fa-edit"></i>&nbsp;Kê khai giá'
                    .'</button>';
                $result['message'] .='</br>';
                $result['message'] .='<button type="button" data-target="#modal-pagia-create"
                                        data-toggle="modal" class="btn btn-default btn-xs mbs"
                                        onclick="editpagia(&apos;'.$dv->madichvu.'&apos;,&apos;'.$dv->masokk.'&apos;)"><i class="fa fa-edit"></i>&nbsp;Phương án giá';
                $result['message'] .='</button>';
                $result['message'] .= '</td >';
                $result['message'] .= '</tr >';
            }
            $result['message'] .= '</tbody>';
            $result['status'] = 'success';
        }

        die(json_encode($result));
    }

    public function search($masothue,$nam){
        if (Session::has('admin')) {
            $m_dv=DonViDvVt::select('masothue','tendonvi')->get();
            $dmdv=array_column($m_dv->toArray(),'tendonvi','masothue');

            $model = KkDvVtXtx::where('trangthai','Duyệt')
                ->where('masothue', $masothue)
                ->whereYear('ngaychuyen', $nam)
                ->get();
            if($masothue!='all'){
                $model=$model->where('masothue',$masothue);
            }

            foreach($model as $ct){
                $ct->tendonvi=$dmdv[$ct->masothue];
            }
            //dd($model);
            return view('manage.dvvt.dvxtx.search.index')
                ->with('model',$model)
                ->with('nam',$nam)
                ->with('m_dv',$m_dv)
                ->with('masothue',$masothue)
                ->with('url','/dich_vu_van_tai/dich_vu_xe_taxi/')
                ->with('pageTitle','Tra cứu giá dịch vụ vận tải');
        }else
            return view('errors.notlogin');
    }

    public function getpag_temp(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        $model = PagDvVtXtx_Temp::where('masothue',session('admin')->mahuyen)->where('madichvu',$inputs['madichvu'])->first();

        $result['message'] = '<div class="form-horizontal" id="pag">';
        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="sanluong" class="col-md-6 control-label">Sản lượng tính giá</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="sanluong" name="sanluong" value="'.$model->sanluong.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="cpnguyenlieutt" class="col-md-6 control-label">Chi phí nguyên liệu trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpnguyenlieutt" name="cpnguyenlieutt" value="'.$model->cpnguyenlieutt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpcongnhantt" class="col-md-6 control-label">Chi phí nhân công trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpcongnhantt" name="cpcongnhantt" value="'.$model->cpcongnhantt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpkhauhaott" class="col-md-6 control-label">Chi phí khấu hao máy móc trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpkhauhaott" name="cpkhauhaott" value="'.$model->cpkhauhaott.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpsanxuatdt" class="col-md-6 control-label">Chi phí sản xuất, kinh doanh theo đặc thù</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpsanxuatdt" name="cpsanxuatdt" value="'.$model->cpsanxuatdt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="cpsanxuatc" class="col-md-6 control-label">Chi phí sản xuất chung</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpsanxuatc" name="cpsanxuatc" value="'.$model->cpsanxuatc.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cptaichinh" class="col-md-6 control-label">Chi phí tài chính</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cptaichinh" name="cptaichinh" value="'.$model->cptaichinh.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpbanhang" class="col-md-6 control-label">Chi phí bán hàng</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpbanhang" name="cpbanhang" value="'.$model->cpbanhang.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpquanly" class="col-md-6 control-label">Chi phí quản lý</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= ' <input type="text" id="cpquanly" name="cpquanly" value="'.$model->cpquanly.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '<input type="hidden" id="idpag" name="idpag" value="'.$model->id.'"/>';
        $result['message'] .= '</div>';

        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function updatepag_temp(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        $model = PagDvVtXtx_Temp::findOrFail($inputs['id']);
        $model->sanluong=getDbl($inputs['sanluong']);
        $model->cpnguyenlieutt=getDbl($inputs['cpnguyenlieutt']);
        $model->cpcongnhantt=getDbl($inputs['cpcongnhantt']);
        $model->cpkhauhaott=getDbl($inputs['cpkhauhaott']);
        $model->cpsanxuatdt=getDbl($inputs['cpsanxuatdt']);
        $model->cpsanxuatc=getDbl($inputs['cpsanxuatc']);
        $model->cptaichinh=getDbl($inputs['cptaichinh']);
        $model->cpbanhang=getDbl($inputs['cpbanhang']);
        $model->cpquanly=getDbl($inputs['cpquanly']);
        $model->save();

        $result['message']= 'Cập nhật thành công.';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function getpag(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        $model = PagDvVtXtx::where('masokk',$inputs['masokk'])->where('madichvu',$inputs['madichvu'])->first();

        $result['message'] = '<div class="form-horizontal" id="pag">';
        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="sanluong" class="col-md-6 control-label">Sản lượng tính giá</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="sanluong" name="sanluong" value="'.$model->sanluong.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="cpnguyenlieutt" class="col-md-6 control-label">Chi phí nguyên liệu trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpnguyenlieutt" name="cpnguyenlieutt" value="'.$model->cpnguyenlieutt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpcongnhantt" class="col-md-6 control-label">Chi phí nhân công trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpcongnhantt" name="cpcongnhantt" value="'.$model->cpcongnhantt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpkhauhaott" class="col-md-6 control-label">Chi phí khấu hao máy móc trực tiếp</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpkhauhaott" name="cpkhauhaott" value="'.$model->cpkhauhaott.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpsanxuatdt" class="col-md-6 control-label">Chi phí sản xuất, kinh doanh theo đặc thù</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpsanxuatdt" name="cpsanxuatdt" value="'.$model->cpsanxuatdt.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="form-group">';
        $result['message'] .= '<label for="cpsanxuatc" class="col-md-6 control-label">Chi phí sản xuất chung</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpsanxuatc" name="cpsanxuatc" value="'.$model->cpsanxuatc.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cptaichinh" class="col-md-6 control-label">Chi phí tài chính</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cptaichinh" name="cptaichinh" value="'.$model->cptaichinh.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpbanhang" class="col-md-6 control-label">Chi phí bán hàng</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= '<input type="text" id="cpbanhang" name="cpbanhang" value="'.$model->cpbanhang.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';

        $result['message'] .= '<label for="cpquanly" class="col-md-6 control-label">Chi phí quản lý</label>';
        $result['message'] .= '<div class="col-md-6">';
        $result['message'] .= ' <input type="text" id="cpquanly" name="cpquanly" value="'.$model->cpquanly.'" class="form-control" data-mask="fdecimal">';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '<input type="hidden" id="idpag" name="idpag" value="'.$model->id.'"/>';
        $result['message'] .= '</div>';

        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function updatepag(Request $request){
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if(!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        $inputs = $request->all();

        $model = PagDvVtXtx::findOrFail($inputs['id']);
        $model->sanluong=getDbl($inputs['sanluong']);
        $model->cpnguyenlieutt=getDbl($inputs['cpnguyenlieutt']);
        $model->cpcongnhantt=getDbl($inputs['cpcongnhantt']);
        $model->cpkhauhaott=getDbl($inputs['cpkhauhaott']);
        $model->cpsanxuatdt=getDbl($inputs['cpsanxuatdt']);
        $model->cpsanxuatc=getDbl($inputs['cpsanxuatc']);
        $model->cptaichinh=getDbl($inputs['cptaichinh']);
        $model->cpbanhang=getDbl($inputs['cpbanhang']);
        $model->cpquanly=getDbl($inputs['cpquanly']);
        $model->save();

        $result['message']= 'Cập nhật thành công.';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function printKK($masokk)
    {
        if (Session::has('admin')) {
            $modelkk = KkDvVtXtx::where('masokk', $masokk)
                ->first();
            $modeldonvi = DonViDvVt::where('masothue', $modelkk->masothue)
                ->first();
            $modeldm = DmDvVtXtx::where('masothue', $modelkk->masothue)->get();

            $modelgia = KkDvVtXtxCt::where('masokk', $masokk)->get();


            return view('reports.kkgdvvt.kkgdvxtx.printf')
                ->with('modeldonvi', $modeldonvi)
                ->with('modelkk', $modelkk)
                ->with('modelgia', $modelgia)
                ->with('modeldm', $modeldm)
                ->with('pageTitle', 'Kê khai giá dịch vụ vận tải');
        } else
            return view('errors.notlogin');
    }

    public function printPAG($masokk)
    {
        if (Session::has('admin')) {
            $modelkk = KkDvVtXtx::where('masokk', $masokk)
                ->first();
            $modeldonvi = DonViDvVt::where('masothue', $modelkk->masothue)
                ->first();
            $modeldm = DmDvVtXtx::where('masothue', $modelkk->masothue)->get();
            $modelgia = KkDvVtXtxCt::where('masokk', $masokk)->get();
            $modelpag = PagDvVtXtx::where('masokk', $masokk)->get();

            return view('reports.kkgdvvt.kkgdvxtx.printfPAG')
                ->with('modeldonvi', $modeldonvi)
                ->with('modelkk', $modelkk)
                ->with('modelgia', $modelgia)
                ->with('modeldm', $modeldm)
                ->with('modelpag', $modelpag)
                ->with('pageTitle', 'Kê khai giá dịch vụ vận tải');
        } else
            return view('errors.notlogin');
    }
}

<?php

namespace App\Http\Controllers;

use App\DmDvQl;
use App\DnDvLt;
use App\TtDn;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class DnDvLtController extends Controller
{
    public function index()
    {
        if (Session::has('admin')) {
            if(session('admin')->sadmin == 'ssa' || session('admin')->sadmin == 'satc') {
                if (session('admin')->sadmin == 'ssa') {
                    $model = DnDvLt::where('trangthai', 'Kích hoạt')
                        ->get();
                } else {
                    $model = DnDvLt:: where('trangthai', 'Kích hoạt')
                        ->where('cqcq', session('admin')->cqcq)
                        ->get();
                }
            }else{
                return view('errors.perm');
            }

            return view('system.dndvlt.index')
                ->with('model',$model)
                ->with('pageTitle','Danh sách doanh nghiệp cung cấp dịch vụ lưu trú');

        }else
            return view('errors.notlogin');
    }


    public function create()
    {
        if (Session::has('admin')) {
            if(session('admin')->sadmin == 'ssa' || session('admin')->sadmin == 'satc') {
                if(session('admin')->sadmin == 'ssa')
                    $modelpb = DmDvQl::where('plql', 'TC')
                        ->get();
                else
                    $modelpb = DmDvQl::where('plql', 'TC')
                        ->where('maqhns',session('admin')->cqcq)
                        ->get();
                //dd($modelpb);
                return view('system.dndvlt.create')
                    ->with('modelpb', $modelpb)
                    ->with('pageTitle', 'Thêm mới doanh nghiệp cung cấp dịch vụ lưu trú');
            }else{
                return view('errors.perm');
            }

        }else
            return view('errors.notlogin');
    }


    public function store(Request $request)
    {
        if (Session::has('admin')) {

            $insert = $request-> all();
            $model = new DnDvLt();
                $model->tendn = $insert['tendn'];
                $model->masothue = $insert['masothue'];
                $model->diachidn = $insert['diachidn'];
                $model->teldn = $insert['teldn'];
                $model->faxdn = $insert['faxdn'];
                $model->noidknopthue = $insert['noidknopthue'];
                $model->chucdanhky = $insert['chucdanhky'];
                $model->nguoiky = $insert['nguoiky'];
                $model->diadanh = $insert['diadanh'];
                $model->tailieu = $insert['tailieu'];
                $model->giayphepkd = $insert['giayphepkd'];
                $model->trangthai = 'Kích hoạt';
                //$model->email = $insert['email'];
                $model->cqcq = $insert['cqcq'];
                if ($model->save()) {
                    $modeluser = new Users();
                    $modeluser->name = $insert['tendn'];
                    $modeluser->phone = $insert['teldn'];
                    $modeluser->username = $insert['username'];
                    $modeluser->password = md5($insert['password']);
                    $modeluser->status = 'Kích hoạt';
                    $modeluser->level = 'DVLT';
                    $modeluser->mahuyen = $insert['masothue'];
                    $modeluser->cqcq = $insert['cqcq'];
                    $modeluser->save();
                }
                return redirect('dn_dichvu_luutru');

        }else
            return view('errors.notlogin');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if (Session::has('admin')) {
            if(session('admin')->sadmin == 'ssa' || session('admin')->sadmin == 'satc') {
                //Kiểm tra id có thuộc quyền quản lý hay k
                $model = DnDvLt::findOrFail($id);
                if(session('admin')->sadmin == 'ssa' || $model->cqcq == session('admin')->cqcq) {
                    $modelpb = DmDvQl::where('plql', 'TC')
                        ->get();
                    //dd($model);
                    return view('system.dndvlt.edit')
                        ->with('model', $model)
                        ->with('modelpb', $modelpb)
                        ->with('pageTitle', 'Chỉnh sửa thông tin doanh nghiệp');
                }else{
                    return view('errors.noperm');
                }
            }else{
                return view('errors.perm');
            }

        }else
            return view('errors.notlogin');
    }


    public function update(Request $request, $id)
    {
        if (Session::has('admin')) {

            $update = $request->all();

            $model = DnDvLt::findOrFail($id);
            if(session('admin')->sadmin == 'ssa' || $model->cqcq == session('admin')->cqcq) {
                $model->tendn = $update['tendn'];
                $model->diachidn = $update['diachidn'];
                $model->teldn = $update['teldn'];
                $model->faxdn = $update['faxdn'];
                $model->noidknopthue = $update['noidknopthue'];
                $model->chucdanhky = $update['chucdanhky'];
                $model->nguoiky = $update['nguoiky'];
                $model->diadanh = $update['diadanh'];
                $model->tailieu = $update['tailieu'];
                $model->giayphepkd = $update['giayphepkd'];
                $model->cqcq = $update['cqcq'];
                //$model->email = $update['email'];
                $model->save();

                return redirect('dn_dichvu_luutru');
            }else{
                return view('errors.noperm');
            }


        }else
            return view('errors.notlogin');
    }

    public function destroy(Request $request){

        if (Session::has('admin')) {
            $input = $request->all();
            $id = $input['iddelete'];

            $model = DnDvLt::findOrFail($id);
            $model->delete();
            return redirect('dn_dichvu_luutru');

        }else
            return view('errors.notlogin');
    }

    public function CheckMaSoThue($masothue){

        $doanhnghiep = DnDvLt::where('masothue',$masothue)->first();
        if(isset($doanhnghiep)){
            echo 'duplicate';
        }else {
            echo 'ok';
        }
    }

    public function CheckUser(Request $request){
        $input = $request->all();
        $users = Users::where('username',$input['user'])->first();
        if(isset($users)){
            echo 'duplicate';
        }else {
            echo 'ok';
        }
    }

    public function ttdn(){
        if (Session::has('admin')) {
            if(session('admin')->level == 'T' || session('admin')->level == 'H' || session('admin')->level == 'DVLT') {
                //Kiểm tra session level = T,H,DVLT mới cho truy cập vào
                if (session('admin')->level == 'T' || session('admin')->level == 'H') {
                    if (session('admin')->sadmin == 'ssa')
                        $model = DnDvLt::all();
                    else
                        $model = DnDvLt::where('cqcq', session('admin')->cqcq)
                            ->get();
                    return view('manage.dvlt.ttdn.ql.index')
                        ->with('model', $model)
                        ->with('pageTitle', 'Thông tin doanh nghiệp cung cấp dịch vụ lưu trú');


                } else {
                    $model = DnDvLt::where('masothue', session('admin')->mahuyen)
                        ->first();
                    $modeltttd = TtDn::where('masothue', session('admin')->mahuyen)
                        ->first();

                    return view('manage.dvlt.ttdn.index')
                        ->with('model', $model)
                        ->with('modeltttd', $modeltttd)
                        ->with('pageTitle', 'Danh sách doanh nghiệp cung cấp dịch vụ lưu trú');
                }
            }else{
                return view('errors.perm');
            }

        }else
            return view('errors.notlogin');
    }

    public function ttdnedit($id){
        if (Session::has('admin')) {
            if(session('admin')->level == 'T' || session('admin')->level == 'H' || session('admin')->level == 'DVLT') {
                //Kiểm tra thông tin có thuộc quyền quản lý hay k
                $model = DnDvLt::findOrFail($id);
                if(session('admin')->sadmin == 'ssa' || session('admin')->cqcq == $model->cqcq) {
                    $ttcqcq = DmDvQl::where('plql', 'TC')
                        ->get();

                    return view('manage.dvlt.ttdn.edit')
                        ->with('model', $model)
                        ->with('ttcqcq', $ttcqcq)
                        ->with('pageTitle', 'Thông tin doanh nghiệp cung cấp dịch vụ lưu trú chỉnh sửa');
                }else{
                    return view('errors.noperm');
                }
            }else {
                return view('errors.perm');
            }


        }else
            return view('errors.notlogin');
    }

    public function ttdnupdate(Request $request,$id){
        if (Session::has('admin')) {
            $update = $request->all();
            if(session('admin')->level == 'T' || session('admin')->level == 'H'){
                $model = DnDvLt::findOrFail($id);
                $model->diachidn = $update['diachidn'];
                $model->teldn = $update['teldn'];
                $model->faxdn = $update['diachidn'];
                $model->noidknopthue = $update['noidknopthue'];
                $model->giayphepkd = $update['giayphepkd'];
                $model->chucdanhky = $update['chucdanhky'];
                $model->nguoiky = $update['nguoiky'];
                $model->diadanh = $update['diadanh'];
                $model->cqcq = $update['cqcq'];
                $model->save();

                return redirect('ttdn_dich_vu_luu_tru');
            }else {
                $check = TtDn::where('masothue',session('admin')->mahuyen)
                    ->delete();
                $model = new TtDn();
                $model->diachi = $update['diachidn'];
                $model->tel = $update['teldn'];
                $model->fax = $update['faxdn'];
                $model->noidknopthue = $update['noidknopthue'];
                $model->chucdanhky = $update['chucdanhky'];
                $model->nguoiky = $update['nguoiky'];
                $model->diadanh = $update['diadanh'];
                $model->masothue = session('admin')->mahuyen;
                $model->tendn = session('admin')->name;
                $model->giayphepkd = $update['giayphepkd'];
                $model->tailieu = $update['tailieu'];
                $model->email = '';
                $model->setting = '';
                $model->dvxk = 0;
                $model->dvxb = 0;
                $model->dvxtx = 0;
                $model->dvk = 0;
                $model->pl = 'DVLT';
                $model->cqcq = $update['cqcq'];
                $model->save();
            }

            return redirect('ttdn_dich_vu_luu_tru');
        }else
            return view('errors.notlogin');
    }

    public function prints(){
        if (Session::has('admin')) {
            $model = DnDvLt::all();
            $dv = 'LƯU TRÚ';
            $pl = 'DVLT';
            return view('reports.dn.doanhnghiep')
                ->with('dv',$dv)
                ->with('pl',$pl)
                ->with('model',$model)
                ->with('pageTitle','Danh sách doanh nghiệp cung cấp dịch vụ lưu trú');
        }else
            return view('errors.notlogin');
    }
}

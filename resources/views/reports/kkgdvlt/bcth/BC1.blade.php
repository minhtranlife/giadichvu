<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$pageTitle}}</title>
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table, p {
            width: 98%;
            margin: auto;
        }

        table tr td:first-child {
            text-align: center;
        }

        td, th {
            padding: 10px;
        }
        p{
            padding: 5px;
        }
        span{
            text-transform: uppercase;
            font-weight: bold;

        }
    </style>
</head>
<body style="font:normal 14px Times, serif;">

<table width="96%" border="0" cellspacing="0" cellpadding="8" style="margin:0 auto 20px; text-align: center;">
    <tr>
        <td width="40%" style="text-transform: uppercase;">
            <b>{{(isset($modelcqcq)? $modelcqcq->tendv : '')}}</b><br>
            --------<br>
        </td>
        <td>
            <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b><br>
            <b><i><u>Độc lập - Tự do - Hạnh phúc</u></i></b><br>
        </td>
    </tr>
</table>

<p style="text-align: center; font-weight: bold; font-size: 16px;">BÁO CÁO THỐNG KÊ CÁC ĐƠN VỊ KÊ KHAI GIÁ</p>
<p style="text-align: center; font-weight: bold;">Từ ngày: {{getDayVn($input['ngaytu'])}} đến ngày {{getDayVn($input['ngayden'])}} </p>
<p style="text-align: center; font-weight: bold;">Loại hạng: {{$input['loaihang']=='all'?'Tất cả':$input['loaihang'].' sao'}}</p>

<table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
    <tr>
        <th>STT</th>
        <th>Tên cơ sở kinh doanh</th>
        <th>Loại hạng</th>
        <th>Địa chỉ</th>
        <th>Số điện thoại</th>
        <th>Số công văn</th>
        <th>Ngày kê khai</th>
        <th>Ngày thực hiện<br> mức giá kê khai</th>
        <th>Trạng thái hồ sơ</th>
    </tr>
    @foreach($m_cqcq as $cskd)
        <?php $model_kk=$model->where('cqcq',$cskd->maqhns) ?>
        @if(count($model_kk)>0)
            <tr>
                <th style="text-align: left" colspan="9">
                    {{$cskd->tendv.': '. count($model_kk).' hồ sơ.'}}
                </th>
            </tr>
            <?php $i=1;?>
            @foreach($model_kk as $key => $ttkk)
                <tr>
                    <th style="text-align: center">{{$i++}}</th>
                    <th style="text-align: left">{{$ttkk->tencskd}}</th>
                    <th style="text-align: center">{{$ttkk->loaihang}} sao</th>
                    <th style="text-align: left">{{$ttkk->diachikd}}</th>
                    <th style="text-align: center">{{$ttkk->telkd}}</th>
                    <th style="text-align: center">{{$ttkk->socv}}</th>
                    <th style="text-align: center">{{getDayVn($ttkk->ngaynhap)}}</th>
                    <th style="text-align: center">{{getDayVn($ttkk->ngayhieuluc)}}</th>
                    <th style="text-align: center">{{$ttkk->trangthai}}</th>
                </tr>
            @endforeach
        @endif
    @endforeach
    <tr>
        <th style="text-align: left" colspan="9">
            {{'Tổng cộng: '. count($model).' hồ sơ.'}}
        </th>
    </tr>
</table>
<table width="96%" border="0" cellspacing="0" cellpadding="8" style="margin:20px auto; text-align: center;">
    <tr>
        <td style="text-align: left;" width="30%">

        </td>
        <td style="text-align: center;text-transform: uppercase; " width="70%">
            <b></b><br>
        </td>
    </tr>

</table>
</body>
</html>
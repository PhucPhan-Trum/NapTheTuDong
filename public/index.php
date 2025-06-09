<?php

if (isset($_POST['submit'])) {
    if (!isset($_POST['telco']) || !isset($_POST['amount']) || !isset($_POST['serial']) || !isset($_POST['code'])) {
        $err = 'Bạn cần nhập đầy đủ thông tin';
    } else {

        $request_id = rand(100000000, 999999999);  //Mã đơn hàng của bạn
        $command = 'charging';  // Nap the
        $url = 'https://thesieure.com/chargingws/v2';
        $partner_id = '15569199337';
        $partner_key = '378492999ae7be538a6a2917cc30b0cd';

        $dataPost = array();
        $dataPost['request_id'] = $request_id;
        $dataPost['code'] = $_POST['code'];
        $dataPost['partner_id'] = $partner_id;
        $dataPost['serial'] = $_POST['serial'];
        $dataPost['telco'] = $_POST['telco'];
        $dataPost['command'] = $command;
        ksort($dataPost);
        $sign = $partner_key;
        foreach ($dataPost as $item) {
            $sign .= $item;
        }
        
        $mysign = md5($sign);

        $dataPost['amount'] = $_POST['amount'];
        $dataPost['sign'] = $mysign;

        $data = http_build_query($dataPost);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        curl_setopt($ch, CURLOPT_REFERER, $actual_link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);

        if ($obj->status == 99) {
            //Gửi thẻ thành công, đợi duyệt.
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        } elseif ($obj->status == 1) {
            //Thành công
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        } elseif ($obj->status == 2) {
            //Thành công nhưng sai mệnh giá
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        } elseif ($obj->status == 3) {
            //Thẻ lỗi
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        } elseif ($obj->status == 4) {
            //Bảo trì
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        } else {
            //Lỗi
            echo '<pre>';
            print_r($obj);
            echo '</pre>';
        }


    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>🧿 MUA KEY VIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #001f3f, #0074D9);
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            animation: pulseBG 10s infinite alternate;
        }
        @keyframes pulseBG {
            from { background-position: 0% 50%; }
            to   { background-position: 100% 50%; }
        }
        .card {
            background: rgba(0, 0, 0, 0.7);
            border: 2px solid #00f7ff;
            box-shadow: 0 0 20px #00f7ff;
        }
        label {
            color: #00ffcc;
            font-weight: bold;
        }
        .form-control {
            background: #111;
            color: #0ff;
            border: 1px solid #00ffcc;
        }
        .btn-success {
            background-color: #00ffcc;
            color: #000;
            font-weight: bold;
            box-shadow: 0 0 10px #00ffcc;
        }
        .modal-content {
            background: #000;
            color: #00ffcc;
            border: 2px solid #00ffcc;
            box-shadow: 0 0 30px #00ffcc;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center" style="margin-top: 50px;">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center text-info mb-4">💎 MENU MUA KEY VIP 💎</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Loại thẻ:</label>
                        <select class="form-control" name="telco" required>
                            <option value="">-- Chọn loại thẻ --</option>
                            <option value="VIETTEL">Viettel</option>
                            <option value="MOBIFONE">Mobifone</option>
                            <option value="VINAPHONE">Vinaphone</option>
                            <option value="ZING">Zing</option>
                            <option value="GARENA">Garena</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mệnh giá:</label>
                        <select class="form-control" name="amount" required>
                            <option value="">-- Chọn mệnh giá --</option>
                            <option value="10000">10.000</option>
                            <option value="20000">20.000</option>
                            <option value="50000">50.000</option>
                            <option value="100000">100.000</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Serial:</label>
                        <input type="text" class="form-control" name="serial" required>
                    </div>
                    <div class="form-group">
                        <label>Mã thẻ:</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success btn-block">🔐 MUA KEY NGAY</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL THÔNG BÁO VIP -->
<div class="modal fade" id="keyModal" tabindex="-1" role="dialog" aria-labelledby="keyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100" id="keyModalLabel">🎉 ĐÂY LÀ KEY CỦA BẠN 🎉</h5>
        <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="keyModalBody" style="font-size: 20px;">
        Đang xử lý...
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-success" data-dismiss="modal">OK VIP</button>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function showKeyModal(message) {
    document.getElementById("keyModalBody").innerHTML = message;
    $('#keyModal').modal('show');
}
</script>
</body>
</html>

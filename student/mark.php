<?php
    ob_start();

    session_start();
    
    require_once('../db/dbhelper.php');
    $path = '../';

    if (isset($_SESSION['user'])) {
        $svDiemTBHK = $svCitizen = $svMonitor = $svNCKH1 = $svNCKH2 = $svNCKH3 = $svOlympic1 = $svOlympic2 = $svOlympic3
            = $svOlympic4 = $svNoRegulation = $svOnTime = $svAbandon = $svUnTrueTime = $svNoFullStudy = $svNoCard
            = $svNoAtivities = $svNoPayFee = $svFullActive = $svAchievementCity = $svAchievementSchool = $svAdvise = $svIrresponsible
            = $svNoCultural = $svPositiveStudy = $svPositiveLove = $svWarn = $svNoProtect = $svBonus = $svIrresponsibleMonitor
            = $svRightRule  = $check = $sumOfOne = $sumOfTwo = $sumOfThree = $sumOfFour = $sumOfFive = $sum = 0;

        $maSv = $_SESSION['user']['maSv'];

        $maHK = $_SESSION['maHK']; 

        require_once $path.'get_point_to_brower.php';
        

        $sql = "SELECT students.*, role.name as role_name, class.class_name as class_name, course.name as course_name, department.name as department_name
                from students, class, course, department, role 
                where 
                students.maLop = class.maLop 
                and class.maKhoaHoc = course.maKhoaHoc 
                and class.maKhoa = department.maKhoa 
                and students.role_id = role.id
                and students.maSv = '$maSv'";

        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        
        $role_name = $row['role_name'];
        $arr_level_one = ['Lớp Trưởng', 'Phó Bí Thư Liên Chi', 'Bí Thư Chi Đoàn'];
        $arr_level_two = ['Lớp Phó', 'Phó Bí Thư Chi Đoàn', 'Hội Trưởng Hội SV'];
        // echo (in_array($role_name, $arr_level_one)) ? "checked" : "" ;

        
        // exit;

        $sqlHK = "select * from semester where maHK = '$maHK'";
        $hk = $connect->query($sqlHK);
        if ($hk->num_rows > 0) {
            $hkItem = $hk->fetch_assoc();
        }

        $sqlDiemSv = "select * from point_student where maSv = '$maSv' and maHk = '$maHK'";
        $diemSV = $connect->query($sqlDiemSv);

        if ($diemSV->num_rows > 0) {
            $diemSVItem = $diemSV->fetch_assoc();
            $check = 1;
            // Các đầu điểm của mục 1
            $svDiemTBHK = $diemSVItem['svDiemTBHK'];
            $svNCKH1 = $diemSVItem['svNCKH1'];
            $svNCKH2 = $diemSVItem['svNCKH2'];
            $svNCKH3 = $diemSVItem['svNCKH3'];
            $svOlympic1 = $diemSVItem['svOlympic1'];
            $svOlympic2 = $diemSVItem['svOlympic2'];
            $svOlympic3 = $diemSVItem['svOlympic3'];
            $svOlympic4 = $diemSVItem['svOlympic4'];
            $svNoRegulation = $diemSVItem['svNoRegulation'];
            $svOnTime = $diemSVItem['svOnTime'];
            $svAbandon = $diemSVItem['svAbandon'];
            $svUnTrueTime = $diemSVItem['svUnTrueTime'];
            $sumOfOne = $svDiemTBHK + $svNCKH1 + $svNCKH2 + $svNCKH3 + $svOlympic1 + $svOlympic2 + $svOlympic3 + $svOlympic4 + $svNoRegulation + $svOnTime + $svAbandon + $svUnTrueTime;
            if ($sumOfOne < 0) {
                $sumOfOne = 0;
            }

            // Các đầu điểm của mục 2
            $svRightRule = $diemSVItem['svRightRule'];
            $svCitizen = $diemSVItem['svCitizen'];
            $svNoFullStudy = $diemSVItem['svNoFullStudy'];
            $svNoCard = $diemSVItem['svNoCard'];
            $svNoAtivities = $diemSVItem['svNoAtivities'];
            $svNoPayFee = $diemSVItem['svNoPayFee'];
            $sumOfTwo = $svRightRule + $svCitizen + $svNoFullStudy + $svNoAtivities + $svNoPayFee + $svNoCard;
            if ($sumOfTwo < 0) {
                $sumOfTwo = 0;
            }

            // Các đầu điểm mục 3
            $svFullActive = $diemSVItem['svFullActive'];
            $svAchievementSchool = $diemSVItem['svAchievementSchool'];
            $svAchievementCity = $diemSVItem['svAchievementCity'];
            $svAdvise = $diemSVItem['svAdvise'];
            $svIrresponsible = $diemSVItem['svIrresponsible'];
            $svNoCultural = $diemSVItem['svNoCultural'];
            $sumOfThree = $svFullActive + $svAchievementCity + $svAchievementSchool + $svAdvise + $svIrresponsible + $svNoCultural;
            if ($sumOfThree < 0) {
                $sumOfThree = 0;
            }

            // Các đầu điểm mục 4
            $svPositiveStudy = $diemSVItem['svPositiveStudy'];
            $svPositiveLove = $diemSVItem['svPositiveLove'];
            $svWarn = $diemSVItem['svWarn'];
            $svNoProtect = $diemSVItem['svNoProtect'];
            $sumOfFour = $svPositiveLove + $svPositiveStudy + $svWarn + $svNoProtect;
            if ($sumOfFour < 0) {
                $sumOfFour = 0;
            }

            // Các đầu điểm mục 5
            $svMonitor = $diemSVItem['svMonitor'];
            $svBonus = $diemSVItem['svBonus'];
            $svIrresponsibleMonitor = $diemSVItem['svIrresponsibleMonitor'];
            $sumOfFive = $svMonitor + $svBonus + $svIrresponsibleMonitor;
            if ($sumOfFive < 0) {
                $sumOfFive = 0;
            }

            //Tổng 
            $sum = $sumOfOne + $sumOfTwo + $sumOfThree + $sumOfFour + $sumOfFive;
            if ($sum >= 100) {
                $sum = 100;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Mark</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/khoaCss.css">
    <link rel="stylesheet" href="../assets/css/mark.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>

<body> 
    <div class="main ">

        <?php
            require_once $path.'header.php';
        ?>

        <div class="main__body grid wide">
            <a href="./backHome.php" class="mark_back"><button type="submit"></i>Trang Chủ</button></a>

            <h4 class="main__body_heading"><?= $_SESSION['user']['name'] ?> - Chấm Điểm Rèn Luyện (Chức vụ: <?=$role_name?>)</h4>

            <a href="./upload_image_proof.php" class="btn btn-primary mb-3" target="_blank">Nhập/Xem Minh Chứng</a>
            <?php
                require_once $path.'table_display_point.php';
            ?>
            <div class="main__body_container">

                <div class="container__header">
                    <div class="container__header-title">
                        <span class="container__header-title-one">
                            <p class="" style="margin-bottom: 0px">BỘ GIÁO DỤC VÀ ĐÀO TẠO</p>
                            <p class="container__header-title-school">TRƯỜNG ĐẠI HỌC MỎ - ĐỊA CHẤT</p>
                        </span>
                        <span class="container__header-title-two">
                            <p class="container__header-title-school">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
                            <p style="font-weight: bold; "><u>Độc lập - Tự do - Hạnh phúc</u></p>
                        </span>
                    </div>
                    <div class="container__header-heading">
                        <h5 style="text-align: center">PHIẾU ĐÁNH GIÁ KẾT QUẢ RÈN LUYỆN CHO SINH VIÊN</h5>
                        <p style="text-align: center; font-style: italic;">(Ban hành kèm theo Quyết định số: 148 /QĐ-MĐC ngày 05 tháng 3 năm 2021)</p>
                    </div>
                    <div class="container__header-info">
                        <div class="row">
                            <div class="col-lg-6">Họ tên: <?= $row['name'] ?></div>
                            <div class="col-lg-6">Mã số SV: <?= $maSv ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">Lớp:<?= $row['class_name'] ?></div>
                            <div class="col-lg-2">Khoá: <?= $row['course_name'] ?></div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">Khoa: <?= $row['department_name'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Học kỳ: <?= $hkItem['semester'] ?></div>
                            <div class="col-lg-6">Năm học: <?= $hkItem['year'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="container__content">
                    <form action="" method="post">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 80%; padding: 0px; line-height: 83.5px">Nội dung đánh giá</th>
                                    <th>Điểm do sinh viên tự đánh giá</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold">I. <u>Đánh giá về ý thức và kết quả học tập</u></span> <span style="font-style: italic;">(Tính điểm thi lần 1. Tổng điểm: 0 - 30 điểm)</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">1. Phần cộng điểm</span> (tổng điểm có thể chấm quá 30 khi SV đạt giải NCKH, thi Olimpic cấp Bộ hoặc cấp Quốc gia)</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        a). Kết quả học tập:
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT ≥ 3,6: ..............................................................……….......(+20đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="hi" value="20" 
                                        <?php 
                                            echo ($point_average >= 3.6) ? "checked" :  "" 
                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT từ 3,2 đến 3,59: ............................................................(+18)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="ao" value="18" 
                                        <?php 
                                            echo ($point_average >= 3.2 && $point_average <= 3.59) ? "checked" :  "" 
                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT từ 2,5 đến 3,19: ...........................................................(+16đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="" value="16" 
                                        <?php 
                                        // echo ($svDiemTBHK == '16') ? "checked" :  "" 
                                            echo ($point_average >= 2.5 && $point_average <= 3.19) ? "checked" :  "" 

                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT từ 2,0 đến 2,49: ..........................................................(+12đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="" value="12" 
                                        <?php 
                                        // echo ($svDiemTBHK == '12') ? "checked" :  "" 
                                            echo ($point_average >= 2.0 && $point_average <= 2.49) ? "checked" :  "" 

                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT từ 1,5 đến 1,99: ..........................................................(+10đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="" value="10" 
                                        <?php 
                                            // echo ($svDiemTBHK == '10') ? "checked" :  "" 
                                            echo ($point_average >= 1.5 && $point_average <= 1.99) ? "checked" :  "" 
                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Điểm TBCHT từ 1,0 đến 1,49: ............................................................(+8đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svDiemTBHK" id="" value="8" 
                                        <?php 
                                            // echo ($svDiemTBHK == '8') ? "checked" :  "" 
                                            echo ($point_average >= 1.0 && $point_average <= 1.49) ? "checked" :  "" 

                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        b). Nghiên cứu khoa học, thi Olympic, Robocon và các cuộc thi khác:
                                        <span>(cộng điểm thưởng theo QĐ số 1171/QĐ-MĐC ngày 12/11/2020 về quản lý KHCN của trường Đại học Mỏ-Địa chất)*</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đạt giải NCKH cấp Bộ và giải tương đương tối đa………………..….(+8đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svNCKH1" id="" value="<?= $svNCKH1 ?>" min="0" max="8">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đạt giải NCKH cấp Trường, Tiểu ban chuyên môn tối đa: ………..... (+6đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svNCKH2" id="" value="<?= $svNCKH2 ?>"  min="0" max="6">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đạt giải NCKH khác tối đa: ……....……………..……………...…….(+6đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svNCKH3" id="" value="<?= $svNCKH3 ?>"  min="0" max="6">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đạt giải Olympic cấp Quốc gia tối đa: ………...…………………….(+10đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svOlympic1" id="" value="<?= $svOlympic1 ?>"  min="0" max="10">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Tham gia Olympic cấp Quốc gia tối đa: ………...…… ..……….…....(+6đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svOlympic2" id="" value="<?= $svOlympic2 ?>"  min="0" max="6">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đạt giải Olympic cấp Trường tối đa: …........................................................(+5đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svOlympic3" id="" value="<?= $svOlympic3 ?>"  min="0" max="5">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Tham gia Olympic cấp Trường tối đa: ………...………. …….............(+2đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svOlympic4" id="" value="<?= $svOlympic4 ?>"  min="0" max="2">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        c) Việc thực hiện nội quy học tập, quy chế thi, kiểm tra
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Không vi phạm quy chế thi, kiểm tra:………………….………….......(+3đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svNoRegulation" id="" value="3" <?php echo ($svNoRegulation == '3') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Đi học đầy đủ, đúng giờ: ………………….......................…………....(+2đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svOnTime" id="" value="2" <?php echo ($svOnTime == '2') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">2. Phần trừ điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        a). Đã đăng ký, nhưng bỏ không tham tham gia nghiên cứu khoa học, thi Olympic, Robocon và các cuộc thi khác tương đương: ........................ (-15đ)</td>
                                    </td>
                                    <td>
                                        <input type="number" name="svAbandon" id="" value="<?= $svAbandon ?>" min="-15" max="0" >
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        b). Không đi học, đi không đúng giờ: .………………...………......(-2đ/buổi)
                                    </td>
                                    <td>
                                        <select name="svUnTrueTime" id="svUnTrueTime">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svUnTrueTime == ($i * (-2))) {
                                                    echo '
                                                        <option selected value="' . ($i * (-2)) . '">' . ($i) . '</option>           
                                                    ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-2)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        <h5>Cộng mục I</h5>
                                    </td>
                                    <td>
                                        <input type="number" class="sum_one sum_item" value="0">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold">II.<u>Đánh giá về ý thức và kết quả chấp hành nội quy, quy chế của Trường</u></span> <span style="font-style: italic;">(Tổng điểm: 0 - 25 điểm)</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">1. Phần cộng điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">a). Chấp hành tốt nội quy, quy chế của Trường, không vi phạm kỷ luật….(+10đ)</td>
                                    <td>
                                        <input type="checkbox" name="svRightRule" id="" value="10" <?php echo ($svRightRule == '10') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        b). Kết quả học tập Tuần sinh hoạt công dân sinh viên
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        Điểm lần 1 ≥ 90:………………...........................................................(+15đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svCitizen" id="" value="15" 
                                        <?php 

                                        echo ($point_citizen >= 90) ? "checked" :  "" 
                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        Điểm lần 1 từ 65 đến 89 điểm:…...................................................(+10đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svCitizen" id="" value="10" 
                                        <?php 
                                            // echo ($svCitizen == '10') ? "checked" :  "" 
                                            echo ($point_citizen >= 65 && $point_citizen <= 89) ? "checked" :  "" 

                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        Điểm lần 1 từ 50 đến 65 điểm:….....................................................(+5đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svCitizen" id="" value="5" 
                                        <?php 
                                            // echo ($svCitizen == '5') ? "checked" :  "" 
                                            echo ($point_citizen >= 50 && $point_citizen <= 65) ? "checked" :  "" 

                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">2. Phần trừ điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">a). Không tham gia học tập đầy đủ, nghiêm túc nghị quyết, nội quy, quy chế, tuần sinh hoạt công dân sinh viên:..…....................................................(-10đ)</td>
                                    <td>
                                        <input type="checkbox" name="svNoFullStudy" id="" value="-10" <?php echo ($svNoFullStudy == '-10') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        b). Không đeo thẻ sinh viên trong khuôn viên Trường:..............…....(-5đ/lần)
                                    </td>
                                    <td>
                                        <select name="svNoCard" id="svNoCard">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svNoCard == ($i * (-5))) {
                                                    echo '
                                                            <option selected value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        c). Không tham gia các buổi sinh hoạt lớp, họp, hội nghị, giao ban, tập huấn và các hoạt động khác khi Nhà trường yêu cầu:..................................(-5đ/lần)
                                    </td>
                                    <td>
                                        <select name="svNoAtivities" id="svNoAtivities">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svNoAtivities == ($i * (-5))) {
                                                    echo '
                                                            <option selected value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        d). Đóng học phí không đúng quy định trong học kỳ:….........................(-10đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svNoPayFee" id="" value="-10" <?php echo ($svNoPayFee == '-10') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        <h5>Cộng mục II</h5>
                                    </td>
                                    <td>
                                        <input type="number" name="" id="" class="sum_two sum_item" value="">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold">III.<u> Đánh giá về ý thức và kết quả tham gia các hoạt động chính trị, xã hội, văn hoá, văn nghệ, thể thao, phòng chống các tệ nạn xã hội</u></span> <span style="font-style: italic;">(Tổng điểm: 0 - 20 điểm)</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">1. Phần cộng điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        a). Tham gia đầy đủ các hoạt động, sinh hoạt do Trường, Khoa, Lớp, Đoàn TN, Hội SV tổ chức:......................................................................…….(+13đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svFullActive" id="" value="13" <?php echo ($svFullActive == '13') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        b). Có thành tích hoạt động chính trị, xã hội, văn hoá, văn nghệ, thể thao, đoàn thể và đấu tranh phòng chống các tệ nạn xã hội được tuyên dương, khen thưởng (lấy mức khen thưởng cao nhất):
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Cấp Trường: ……………………….……………….……………...… (+3đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svAchievementSchool" id="" value="<?= $svAchievementSchool ?>" min="0" max="3">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Cấp tỉnh, thành phố trở lên:……...……...………………..................... (+5đ)
                                    </td>
                                    <td>
                                        <input type="number" name="svAchievementCity" id="" value="<?= $svAchievementCity ?>" min="0" max="5">
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        c). Tham gia các hoạt động tư vấn tuyển sinh (có xác nhận của phòng QHCC&DN):…………………………………………( +2đ/lần)
                                    </td>
                                    <td>
                                        <select name="svAdvise" id="svAdvise">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svAdvise == ($i * (2))) {
                                                    echo '
                                                        <option selected value="' . ($i * (2)) . '">' . ($i) . '</option>           
                                                    ';
                                                } else {
                                                    echo '
                                                        <option value="' . ($i * (2)) . '">' . ($i) . '</option>           
                                                    ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">2. Phần trừ điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">- Không tham gia hoạt động, sinh hoạt khi được phân công: ……….(-5đ/lần)</td>
                                    <td>
                                        <select name="svIrresponsible" id="svIrresponsible">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svIrresponsible == ($i * (-5))) {
                                                    echo '
                                                            <option selected value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Vi phạm Quy định về văn hoá học đường cho sinh viên:.................(-5đ/lần)
                                    </td>
                                    <td>
                                        <select name="svNoCultural" id="svNoCultural">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svNoCultural == ($i * (-5))) {
                                                    echo '
                                                            <option selected value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        <h5>Cộng mục III</h5>
                                    </td>
                                    <td>
                                        <input type="number" class="sum_three sum_item" value=0>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold">IV.<u> Đánh giá về phẩm chất công dân và quan hệ công đồng </u></span> <span style="font-style: italic;">(Tổng điểm: 0 - 15 điểm)</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">1. Phần cộng điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        a). Tích cực tham gia học tập, tìm hiểu và chấp hành tốt chủ trương của Đảng, chính sách, pháp luật của Nhà nước:….........................................(+10đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svPositiveStudy" id="" value="10" <?php echo ($svPositiveStudy == '10') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        b). Tích cực tham gia các hoạt động nhân đạo, từ thiện vì cộng đồng; phong trào thanh niên tình nguyện; phong trào giúp đỡ nhân dân và bạn bè khi gặp thiên tai, khó khăn, hoạn nạn:...................................................................(+5đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svPositiveLove" id="" value="5" <?php echo ($svPositiveLove == '5') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">2. Phần trừ điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">- Gây mất đoàn kết trong tập thể lớp:........................................................(-5đ)</td>
                                    <td>
                                        <input type="checkbox" name="svWarn" id="" value="-5" <?php echo ($svWarn == '-5') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Không đóng BHYT đúng hạn: .............................................................(-20đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svNoProtect" id="" value="-20" <?php echo ($svNoProtect == '-20') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        <h5>Cộng mục IV</h5>
                                    </td>
                                    <td>
                                        <input type="number" class="sum_four sum_item" value="0">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold">V.<u>Đánh giá về ý thức và kết quả tham gia phụ trách lớp, các đoàn thể tổ chức khác trong Trường</u></span> <span style="font-style: italic;">(Tổng điểm: 0 - 10 điểm)</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">1. Phần cộng điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">a). Là thành viên Ban cán sự lớp quản lý sinh viên, cán bộ Đoàn TN, Hội SV hoàn thành nhiệm vụ:</td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Lớp trưởng, Phó Bí thư Liên chi, Bí thư Chi đoàn:…..…….................(+7đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svMonitor" id="" value="7"
                                        <?php 
                                            // echo ($svMonitor == '7') ? "checked" :  "" ;
                                            echo (in_array($role_name, $arr_level_one)) ? "checked" : "" ;
                                            // if (in_array($row['role_name'], $arr_level_two))
                                            //     {
                                            //     echo "found";
                                            //     }
                                            // else
                                            //     {
                                            //     echo "not found";
                                            //     }
                                        ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        - Lớp phó, Phó Bí thư Chi đoàn, Hội trưởng Hội SV:........…………......(+5đ)
                                    </td>
                                    <td>
                                        <input type="radio" name="svMonitor" id="" value="5" readonly
                                        <?php
                                            // echo ($svMonitor == '5') ? "checked" :  "" ;
                                            echo (in_array($role_name, $arr_level_two)) ? "checked" : "" ;
                                        ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        b). Được các cấp khen thưởng: ....….................….................………......(+3đ)
                                    </td>
                                    <td>
                                        <input type="checkbox" name="svBonus" id="" value="3" <?php echo ($svBonus == '3') ? "checked" :  "" ?>>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <p><span style="font-weight: bold; font-style: italic;">2. Phần trừ điểm</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">- Là thành viên Ban cán sự lớp quản lý sinh viên, lớp học phần; cán bộ Đoàn TN, Hội SV thiếu trách nhiệm với tập thể lớp:...................................(-5đ/lần)</td>
                                    <td>
                                        <select name="svIrresponsibleMonitor" id="svIrresponsibleMonitor">
                                            <?php
                                            for ($i = 0; $i <= 5; $i++) {
                                                if ($svIrresponsibleMonitor == ($i * (-5))) {
                                                    echo '
                                                            <option selected value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                } else {
                                                    echo '
                                                            <option value="' . ($i * (-5)) . '">' . ($i) . '</option>           
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70%">
                                        <h5>Cộng mục V</h5>
                                    </td>
                                    <td>
                                        <input type="number" class="sum_five sum_item" value="0">
                                    </td>
                                </tr>

                                <tr class="sum_all">
                                    <td>
                                        <h5 style="color: red; width: 70px;">Tổng: </h5>
                                    </td>
                                    <td>
                                        <input type="number" class="sum_mark-student" value="0">
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-success btn_save">Lưu</button>

                    </form>
                    <?php
                    if (isset($_POST['svNCKH1'])) {
                        $svDiemTBHK = $_POST['svDiemTBHK'] ?? 0;

                        $svCitizen = $_POST['svCitizen'] ?? 0;

                        $svMonitor = $_POST['svMonitor'] ?? 0;

                        $svNCKH1 = $_POST['svNCKH1'] ?? 0;

                        $svNCKH2 = $_POST['svNCKH2'] ?? 0;

                        $svNCKH3 = $_POST['svNCKH3'] ?? 0;

                        $svOlympic1 = $_POST['svOlympic1'] ?? 0;

                        $svOlympic2 = $_POST['svOlympic2'] ?? 0;

                        $svOlympic3 = $_POST['svOlympic3'] ?? 0;

                        $svOlympic4 = $_POST['svOlympic4'] ?? 0;

                        $svNoRegulation = $_POST['svNoRegulation'] ?? 0;

                        $svOnTime = $_POST['svOnTime'] ?? 0;

                        $svAbandon = $_POST['svAbandon'] ?? 0;

                        $svUnTrueTime = $_POST['svUnTrueTime'] ?? 0;

                        $svNoFullStudy = $_POST['svNoFullStudy'] ?? 0;

                        $svNoCard = $_POST['svNoCard'] ?? 0;

                        $svNoAtivities = $_POST['svNoAtivities'] ?? 0;

                        $svNoPayFee = $_POST['svNoPayFee'] ?? 0;

                        $svFullActive = $_POST['svFullActive'] ?? 0;

                        $svAchievementCity = $_POST['svAchievementCity'] ?? 0;

                        $svAchievementSchool = $_POST['svAchievementSchool'] ?? 0;

                        $svAdvise = $_POST['svAdvise'] ?? 0;

                        $svIrresponsible = $_POST['svIrresponsible'] ?? 0;

                        $svNoCultural = $_POST['svNoCultural'] ?? 0;

                        $svPositiveStudy = $_POST['svPositiveStudy'] ?? 0;

                        $svPositiveLove = $_POST['svPositiveLove'] ?? 0;

                        $svWarn = $_POST['svWarn'] ?? 0;

                        $svNoProtect = $_POST['svNoProtect'] ?? 0;

                        $svBonus = $_POST['svBonus'] ?? 0;

                        $svIrresponsibleMonitor = $_POST['svIrresponsibleMonitor'] ?? 0;

                        $svRightRule = $_POST['svRightRule'] ?? 0;

                        $sumOfOne = $svDiemTBHK + $svNCKH1 + $svNCKH2 + $svNCKH3 + $svOlympic1 + $svOlympic2 + $svOlympic3 + $svOlympic4 + $svNoRegulation + $svOnTime + $svAbandon + $svUnTrueTime;
                        // if ($sumOfOne < 0) {
                        //     $sumOfOne = 0;
                        // }

                        $sumOfTwo = $svRightRule + $svCitizen + $svNoFullStudy + $svNoAtivities + $svNoPayFee + $svNoCard;
                        // if ($sumOfTwo < 0) {
                        //     $sumOfTwo = 0;
                        // }

                        $sumOfThree = $svFullActive + $svAchievementCity + $svAchievementSchool + $svAdvise + $svIrresponsible + $svNoCultural;
                        // if ($sumOfThree < 0) {
                        //     $sumOfThree = 0;
                        // }

                        $sumOfFour = $svPositiveLove + $svPositiveStudy + $svWarn + $svNoProtect;
                        // if ($sumOfFour < 0) {
                        //     $sumOfFour = 0;
                        // }

                        $sumOfFive = $svMonitor + $svBonus + $svIrresponsibleMonitor;
                        // if ($sumOfFive < 0) {
                        //     $sumOfFive = 0;
                        // }


                        $sumMarkSV = $sumOfOne + $sumOfTwo + $sumOfThree + $sumOfFour + $sumOfFive;
                        if ($sumMarkSV >= 100) {
                            $sumMarkSV = 100;
                        }

                        $sql = "select * from point_student where maSv = '$maSv' and maHK = '$maHK'";
                        $result = $connect->query($sql);
                        // update
                        if ($result->num_rows > 0) {
                            $sql = "update point_student set 
                                    svDiemTBHK = '$svDiemTBHK', 
                                    svNCKH1  = '$svNCKH1', 
                                    svNCKH2 = '$svNCKH2', 
                                    svNCKH3 = '$svNCKH3', 
                                    svOlympic1 = '$svOlympic1', 
                                    svOlympic2 = '$svOlympic2',
                                    svOlympic3 = '$svOlympic3', 
                                    svOlympic4 = '$svOlympic4', 
                                    svNoRegulation = '$svNoRegulation', 
                                    svOnTime = '$svOnTime', 
                                    svAbandon = '$svAbandon', 
                                    svUnTrueTime = '$svUnTrueTime',
                                    svRightRule = '$svRightRule', 
                                    svCitizen = '$svCitizen', 
                                    svNoFullStudy = '$svNoFullStudy', 
                                    svNoCard = '$svNoCard', 
                                    svNoAtivities = '$svNoAtivities', 
                                    svNoPayFee = '$svNoPayFee',
                                    svFullActive = '$svFullActive', 
                                    svAchievementSchool = '$svAchievementSchool', 
                                    svAchievementCity = '$svAchievementCity', 
                                    svAdvise = '$svAdvise', 
                                    svIrresponsible = '$svIrresponsible',
                                    svNoCultural = '$svNoCultural', 
                                    svPositiveStudy = '$svPositiveStudy', 
                                    svPositiveLove = '$svPositiveLove', 
                                    svWarn = '$svWarn', 
                                    svNoProtect = '$svNoProtect', 
                                    svMonitor = '$svMonitor',
                                    svBonus = '$svBonus', 
                                    svIrresponsibleMonitor = '$svIrresponsibleMonitor' 
                                    where maSv = '$maSv' and maHK = '$maHK'";

                            $updateDiem = "update point set point_student = '$sumMarkSV' where maSv = '$maSv' and maHK = '$maHK'";

                            if ($connect->query($sql) && $connect->query($updateDiem)) {
                                header('Location: ./afterMark.php');
                            } else {
                                echo $sql;
                            }

                        }
                        // insert
                        else {
                            $sql = "INSERT INTO `point_student` 
                                        (`maSv`, 
                                        `svDiemTBHK`, 
                                        `svCitizen`, 
                                        `svMonitor`, 
                                        `svNCKH1`, 
                                        `svNCKH2`, 
                                        `svNCKH3`, 
                                        `svOlympic1`, 
                                        `svOlympic2`, 
                                        `svOlympic3`, 
                                        `svOlympic4`, 
                                        `svNoRegulation`, 
                                        `svOnTime`, 
                                        `svAbandon`, 
                                        `svUnTrueTime`, 
                                        `svNoFullStudy`, 
                                        `svNoCard`, 
                                        `svNoAtivities`, 
                                        `svNoPayFee`, 
                                        `svFullActive`, 
                                        `svAchievementSchool`, 
                                        `svAchievementCity`, 
                                        `svAdvise`, 
                                        `svIrresponsible`, 
                                        `svNoCultural`, 
                                        `svPositiveStudy`, 
                                        `svPositiveLove`, 
                                        `svWarn`, 
                                        `svNoProtect`, 
                                        `svBonus`, 
                                        `svIrresponsibleMonitor`, 
                                        `maHK`, 
                                        `svRightRule`)
                                    VALUES 
                                        ('$maSv', 
                                        '$svDiemTBHK', 
                                        '$svCitizen', 
                                        '$svMonitor', 
                                        '$svNCKH1', 
                                        '$svNCKH2', 
                                        '$svNCKH3', 
                                        '$svOlympic1', 
                                        '$svOlympic2', 
                                        '$svOlympic3', 
                                        '$svOlympic4', 
                                        '$svNoRegulation', 
                                        '$svOnTime', 
                                        '$svAbandon', 
                                        '$svUnTrueTime', 
                                        '$svNoFullStudy', 
                                        '$svNoCard', 
                                        '$svNoAtivities', 
                                        '$svNoPayFee', 
                                        '$svFullActive', 
                                        '$svAchievementSchool', 
                                        '$svAchievementCity', 
                                        '$svAdvise', 
                                        '$svIrresponsible', 
                                        '$svNoCultural', 
                                        '$svPositiveStudy', 
                                        '$svPositiveLove', 
                                        '$svWarn', 
                                        '$svNoProtect', 
                                        '$svBonus', 
                                        '$svIrresponsibleMonitor', 
                                        '$maHK', 
                                        '$svRightRule')";

                            $insertDiem = "INSERT INTO point (maSv, maHK, point_student) values ('$maSv', '$maHK', '$sumMarkSV')";

                            if ($connect->query($sql) && $connect->query($insertDiem)) {
                                header('Location: ./afterMark.php');
                            } else {
                                echo $sql;
                            }

                        }
                    }
                    ?>
                </div>

            </div>
        </div>

    </div>
    <!-- <script src="../assets/js/mark.js"></script> -->
    <script src="../assets/js/st_mark.js"></script>

    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <?php
    ob_end_flush();
    ?>
</body>

</html>
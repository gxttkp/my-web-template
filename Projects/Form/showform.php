<?php
// ตรวจสอบว่ามีการส่งข้อมูล POST มาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับค่าที่ถูกส่งมาจากฟอร์ม

    //รับชื่อภาษาไทย
    $nounth = $_POST['nounth'];
    $nameth = $_POST['nameth'];
    $surnameth = $_POST['surnameth'];

    //รับชื่อภาษาอังกฤษ
    $nouneng = $_POST['nouneng'];
    $nameeng = $_POST['nameeng'];
    $surnameeng = $_POST['surnameeng'];

    //ข้อมูลส่วนตัว
    $gender = $_POST['gender'];
    $datebirth = $_POST['datebirth'];
    $age = $_POST['age'];
    $ptt = $_POST['ptt'];
    $locationbaid = $_POST['locationbaid'];
    $dateplus = $_POST['dateplus'];
    $ampul = $_POST['ampul'];
    $county = $_POST['county'];
    $nation = $_POST['nation'];
    $nationplus = $_POST['nationplus'];
    $religion = $_POST['religion'];

    //สถานภาพ
    $status = $_POST['status'];
    $numberson = $_POST['numberson'];

    //ความพิการ
    $disability = $_POST['disability'];
    $namedisability = $_POST['namedisability'];
    $specialneed = $_POST['specialneed'];

    //อาศัยอยู่กับ
    $live = $_POST['live'];

    //ที่อยู่ปัจจุบัน
    $numhome = $_POST['numhome'];
    $moban = $_POST['moban'];
    $soi = $_POST['soi'];
    $street = $_POST['street'];
    $tubbonhome = $_POST['tubbonhome'];
    $ampulhome = $_POST['ampulhome'];
    $countyhome = $_POST['countyhome'];
    $idhome = $_POST['idhome'];
    $telhome = $_POST['telhome'];
    $telyou = $_POST['telyou'];
    $email = $_POST['email'];

    //ที่อยู่จามทำเบียนบ้าน
    $numaddress = $_POST['numaddress'];
    $moaddress = $_POST['moaddress'];
    $soiaddress = $_POST['soiaddress'];
    $streetaddress = $_POST['streetaddress'];
    $tubbonaddress = $_POST['tobbonaddress'];
    $ampuladdress = $_POST['ampuladdress'];
    $countyaddress = $_POST['countyaddress'];
    $idaddress = $_POST['idaddress'];
    $teladdress = $_POST['teladdress'];
    $passidaddress = $_POST['passidaddress'];
    $work = $_POST['work'];
    $lowork = $_POST['lowork'];
    $moneywork = $_POST['moneywork'];

    //สถานที่ทำงาน
    $namework = $_POST['namework'];
    $numwork = $_POST['numwork'];
    $mowork = $_POST['mowork'];
    $soiwork = $_POST['soiwork'];
    $streetwork = $_POST['streetwork'];
    $tubbonwork = $_POST['tubbonwork'];
    $ampulwork = $_POST['ampulwork'];
    $countywork = $_POST['countywork'];
    $idwork = $_POST['idwork'];
    $telwork = $_POST['telwork'];
    $emailwork = $_POST['emailwork'];
    $linework = $_POST['linework'];
    $facebookwork = $_POST['facebookwork'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
        <h3>ข้อมูลนักศึกษา : </h3> <dd>
        
        <b>ชื่อ</b> <?php echo $nounth?>&nbsp;<?php echo $nameth?>&nbsp;<?php echo $surnameth?><br></br>
        <b>Name</b> <?php echo $nouneng?>&nbsp;<?php echo $nameeng?>&nbsp;<?php echo $surnameeng?><br></br>

        <b>เพศ</b> <?php echo $gender?> &nbsp;
        <b>วันเกิด</b> <?php echo $datebirth?> &nbsp;
        <b>อายุ</b> <?php echo $age?> <b>ปี</b> &nbsp;
        <b>เลขบัตรประจำตัวประชาชน</b> <?php echo $ptt?><br></br>

        <b>สถานที่ออกบัตร</b> <?php echo $locationbaid?> &nbsp;
        <b>วันหมดอายุ</b> <?php echo $dateplus?> &nbsp;
        <b>สถานที่เกิด อำเภอ</b> <?php echo $ampul?> &nbsp;
        <b>จังหวัด</b> <?php echo $county?><br></br>

        <b>เชื้อชาติ</b> <?php echo $nation?> &nbsp;
        <b>สัญชาติ</b> <?php echo $nationplus?> &nbsp;
        <b>ศาสนา</b> <?php echo $religion?> </dd> <br></br>
        
        <b>สถานภาพ : </b><br></br> <dd>
        
        <b>สถานะ </b> <?php echo $status?><br></br>
        <b>จำนวนบุตร </b> <?php echo $numberson?> <b>คน</b> </dd> <br></br>

        <b>ความพิการ : </b> <br></br> <dd>

        <b>ความพิการ </b> <?php echo $disability?>&nbsp;<?php echo $namedisability?>
        &nbsp; <b>ความต้องการพิเศษ คือ</b> <?php echo $specialneed?> <br></br>

        <b>ขณะศึกษาพักอยู่กับ :</b> <?php echo $live?><br></br> </dd><br></br>

        <b>ที่อยู่ปัจจุบัน </b>(ติดต่อได้สะดวก) <b>:</b> <br></br><dd>

        <b>เลขที่</b> <?php echo $numhome?>&nbsp;
        <b>หมู่</b> <?php echo $moban?>&nbsp;
        <b>ตรอก/ซอย</b>  <?php echo $soi?>&nbsp;
        <b>ถนน</b>  <?php echo $street?>&nbsp;
        <b>แขวง/ตำบล</b>   <?php echo $tubbonhome?><br></br>
 
        <b>เขต/อำเภอ</b>  <?php echo $ampulhome?>&nbsp;
        <b>จังหวัด</b>  <?php echo $countyhome?>&nbsp;
        <b>รหัสไปรษณีย์ </b> <?php echo $idhome?><br></br>

        <b>โทรศัพท์(บ้าน)</b> <?php echo $telhome?>&nbsp;
        <b>โทรศัพท์(ส่วนตัว)</b>  <?php echo $telyou?>&nbsp;
        <b>e-mail</b>  <?php echo $email?></dd><br></br>

        <b>ที่อยู่ตามทะเบียนบ้าน : </b> <dd><br>

        <b>เลขที่</b>  <?php echo $numaddress?>&nbsp;
        <b>หมูที่ </b> <?php echo $moaddress?>&nbsp;
        <b>ตรอก/ซอย </b> <?php echo $soiaddress?>&nbsp;
        <b>ถนน </b> <?php echo $streetaddress?><br></br>

        <b>แขวง/ตำบล </b> <?php echo $tubbonaddress?>&nbsp;
        <b>เขต/อำเภอ </b>  <?php echo $ampuladdress?>&nbsp;
        <b>จังหวัด </b> <?php echo $countyaddress?><br></br>

        <b>รหัสไปรษณีย์ </b>  <?php echo $idaddress?>&nbsp;
        <b>โทรศัพท์ </b> <?php echo $teladdress?>&nbsp;
        <b>เลขรหัสประจำบ้าน </b> <?php echo $passidaddress?><br></br>

        <b>ปัจจุบันนักศึกษา </b> <?php echo $work?>&nbsp; &nbsp; 
        <b>ตำแหน่ง </b> <?php echo $lowork?>&nbsp;
        <b>เงินเดือน </b> <?php echo $moneywork?><b>บาท/เดือน </b> </dd><br></br>

        <b> สถานที่ทำงาน : </b> <dd><br>

        <b>ชื่อสถานที่ทำงาน </b> <?php echo $namework?> &nbsp;
        <b>เลขที่ </b> <?php echo $numwork?>&nbsp;
        <b>หมูที่ </b>  <?php echo $mowork?>&nbsp;
        <b>ตรอก/ซอย </b>  <?php echo $soiwork?><br></br>

        <b>ถนน </b> <?php echo $streetwork?>&nbsp;
        <b>แขวง/ตำบล </b>  <?php echo $tubbonwork?>&nbsp;
        <b>เขต/อำเภอ </b>  <?php echo $ampulwork?><br></br>

        <b>จังหวัด </b> <?php echo $countywork?>&nbsp;
        <b>รหัสไปรษณีย์ </b> <?php echo $idwork?>&nbsp;
        <b>โทรศัพท์ </b>  <?php echo $telwork?><br></br>

        <b>e-mail </b> <?php echo $emailwork?> &nbsp;
        <b>line </b> <?php echo $linework?>&nbsp;
        <b>facebook </b> <?php echo $facebookwork?></dd><br></br>

</body>
</html>
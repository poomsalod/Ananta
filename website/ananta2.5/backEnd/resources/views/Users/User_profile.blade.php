@extends('Users.master_user')

@section('title')
Profile
@endsection

@section('style')
<link href="{{ asset('css/users/show_food_user.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/user_profile.css') }}" rel="stylesheet">
<link href="{{ asset('css/users/level_Bmi.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection



@section('content')

<div class="row">
    <div class="col-md-12 colblock">
        <div class="row">
            <div class="col-md-12 line3">
                <span class="haedline" style="font-size: 25;">โปรไฟล์</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 colblock">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <form action="{{ url( '/edti/profile/update/image' ) }}" method="POST" role="form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="{{Auth::user()->user_profile->user_id}}">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mt-3">

                                        <img src="{{ asset('/storage/images/user/'.Auth::user()->user_profile->image) }}" onClick="" id="profileDisplay">

                                        <div class="agga">
                                            <h4>{{ Auth::user()->user_profile->f_name." " }}{{ Auth::user()->user_profile->l_name }}</h4>
                                        </div>

                                        @error('img')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="custom-file mb-3">
                                            <input type="file" class="form-control custom-file-input editon" onChange="displayImage(this)" id="profileImage" name="img" value="">
                                            <label class="custom-file-label editon" for="profileImage">{{ Auth::user()->user_profile->image }}</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="ccs">
                                    <button type="button" class="btn btn-info editoff" onclick="clickedit()">แก้ไข</button>
                                    <button type="button" class="btn btn-info editon" onclick="clickeditoff()">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success editon">บันทึก</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="ggrrp">
                        <div class="card">
                            <!-- <div class="card-body"> -->
                                <div class="d-flex flex-column align-items-center text-center">
                                    <!-- <div class="mt-3"> -->
                                        <div class="chartBox">
                                            <!-- <div class="oopp"> -->
                                                <canvas id="myChart"></canvas>
                                                <input type="hidden" value="{{ number_format($data->bmi,1) }}" id="bmi">
                                            <!-- </div> -->
                                        </div>
                                    <!-- </div> -->
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="pfra">
                            <div class="row">
                                <div class="col-md-12 rpg">
                                    <span class="haedline" style="font-size: 25;">ข้อมูลส่วนตัว</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">ชื่อ</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ Auth::user()->user_profile->f_name." " }}{{ Auth::user()->user_profile->l_name }}
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">เพศ</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    @if( $data->gender == 1 )
                                    <option value="1">ชาย</option>
                                    @else
                                    <option value="2">หญิง</option>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">น้ำหนัก</h6>
                                </div>
                                <div class="col-sm-4 text-secondary">
                                    {{ $data->weight . ' kg' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">ส่วนสูง</h6>
                                </div>
                                <div class="col-sm-4 text-secondary">
                                    {{ $data->height . ' cm'}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">กิจกรรมที่ทำต่อสัปดาห์</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?php
                                    $atv = [1.2, 1.375, 1.55, 1.725, 1.9];
                                    $atvname = ['ไม่ออกกำลังกายหรือทำงานนั่งโต๊ะ', 'ออกกำลังกายเบาๆ(1-2 ครั้งต่อสัปดาห์ )', 'ออกกำลังกายปานกลาง(3-5 ครั้งต่อสัปดาห์)', 'ออกกำลังกายหนัก(6-7 ครั้งต่อสัปดาห์)', 'ออกกำลังกายหนักมาก(ทุกวัน วันละ 2 เวลา)'];
                                    for ($i = 0; $i < count($atv); $i++) {
                                        if ($data->activity == $atv[$i]) {
                                            echo "<option value=" . $atv[$i] . ">" . $atvname[$i] . "</option>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">วันเกิด</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ Auth::user()->user_profile->birthday }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12" style="text-align: right;">
                                    <a class="btn btn-info " href="{{ url('/edit/profile' ,Auth::user()->user_profile->user_id ) }}">แก้ไข</a>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="pfra">
                            <div class="row">
                                <div class="col-md-12 rpg">
                                    <span class="haedline" style="font-size: 25;">ข้อมูลโภชนาการ</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h6 class="mb-0">ค่า BMI</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            {{ number_format($data->bmi,1) . ' ' }} kg/m<sup>2</sup>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <?php
                                            if ($data->analyze_bmi > 4) {
                                                echo 'อ้วนระดับสอง';
                                            } elseif ($data->analyze_bmi > 3) {
                                                echo 'อ้วนระดับต้น';
                                            } elseif ($data->analyze_bmi > 2) {
                                                echo 'เสี่ยงจะเกินเกณฑ์';
                                            } elseif ($data->analyze_bmi > 1) {
                                                echo 'ระดับปกติ';
                                            } elseif ($data->analyze_bmi > 0) {
                                                echo 'น้อยกว่ามาตรฐาน';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h6 class="mb-0">ค่า BMR</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            {{ floor(Auth::user()->user_profile->nutrition->bmr) . ' kcal' }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h6 class="mb-0">ค่า TDEE</h6>
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            {{ floor($data->tdee) . ' kcal' }}
                                        </div>
                                        <div class="col-sm-4 text-secondary">
                                            <?php
                                            if ($data->analyze_bmi > 2) {
                                                $data2 = $data->tdee + 200;
                                                echo   '(' . $data2 . ' - 200)';
                                            } elseif ($data->analyze_bmi > 1) {
                                                // $data2 = $data->tdee;
                                                // echo   $data2;
                                                echo   "";
                                            } else {
                                                $data2 = $data->tdee - 200;
                                                echo   '(' . $data2 . ' + 200)';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>

<script>
    function triggerClick(e) {
        document.querySelector('#profileImage').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);

        }
    }

    $(document).ready(function() {
        bsCustomFileInput.init()
    })

    function clickedit() {
        document.querySelectorAll(".editon").forEach(a => a.style.display = "initial");
        document.querySelectorAll(".editoff").forEach(a => a.style.display = "none");
    }

    function clickeditoff() {
        document.querySelectorAll(".editon").forEach(a => a.style.display = "none");
        document.querySelectorAll(".editoff").forEach(a => a.style.display = "initial");
    }
</script>

<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script>
    const bmi = document.getElementById('bmi');
    const get_bmi = bmi.value;
    const data = {
        labels: ['น้อยกว่ามาตรฐาน', 'ระดับปกติ', 'เสี่ยงจะเกินเกณฑ์', 'อ้วนระดับต้น', 'อ้วนระดับสอง'],
        datasets: [{
            data: [18.5, 4.4, 2, 5, 5],
            backgroundColor: [
                // แดง ส้ม เขียว เหลือง ส้ม แดง แดง
                // 'rgba(255, 0, 0, 1)',
                'rgba(255, 178, 102, 1)',
                'rgba(0, 255, 0, 1)',
                'rgba(255, 255, 0, 1)',
                'rgba(255, 128, 0, 1)',
                'rgba(255, 0, 0, 1)',
                // 'rgba(255, 0, 0, 1)'

            ],
            needleValue: get_bmi,
            borderColor: 'White',
            borderWidth: 1,
            cutout: '90%',
            circumference: 180,
            rotation: 270,
            borderRadius: 5,
        }]
    };

    const gaugeNeedle = {
        id: 'gaugeNeedle',
        afterDatasetDraw(chart, args, options) {
            const {
                ctx,
                config,
                data,
                chartArea: {
                    top,
                    bottom,
                    left,
                    right,
                    width,
                    height
                }
            } = chart;
            ctx.save();

            console.log(ctx);
            console.log(data);
            const needleValue = data.datasets[0].needleValue;
            const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0);
            console.log(dataTotal);
            const angle = Math.PI + (1 / dataTotal * needleValue * Math.PI);
            // console.log(angle);
            const cx = width / 2;
            const cy = chart._metasets[0].data[0].y;

            ctx.translate(cx, cy);
            ctx.rotate(angle);
            ctx.beginPath();
            ctx.moveTo(0, -4);
            // ctx.lineTo(height - (ctx.canvas.offsetTop - 23), 0);
            ctx.lineTo(height - 75, 0);
            ctx.lineTo(0, 4);
            ctx.fillStyle = '#444';
            ctx.fill();
            ctx.restore();

            // ทำจุด
            // ctx.translate(-cx, -cy);
            ctx.beginPath();
            ctx.arc(cx, cy, 5, 0, 10);
            ctx.fill();
            ctx.restore();

            ctx.font = '18px Helvetica';
            ctx.fillStyle = '#444';
            ctx.fillText('BMI: ' + needleValue, cx, cy + 25);
            ctx.textAlign = 'center';
            ctx.restore();
        }
    };

    // config 
    const config = {
        type: 'doughnut',
        data,
        options: {
            plugins: {
                // legend: {
                //     display: false
                // },
                tooltip: {
                    yAlign: 'bottom',
                    // displayColors: false,
                    callbacks: {
                        label: function(tooltipItem, data, value) {
                            const tracker = tooltipItem.dataset.needleValue;
                            return `BMI = ${tracker} `;
                        }
                    }
                }
            }
        },
        plugins: [gaugeNeedle]
    };

    // render init block
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
@endsection
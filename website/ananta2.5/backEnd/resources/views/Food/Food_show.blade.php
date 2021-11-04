@extends('master')

@section('style')
<link href="{{ asset('css/food/food_show_style.css') }}" rel="stylesheet">
@endsection

@section('nav')

@endsection

@section('title')
แสดงเมนูอาหาร
@endsection

@section('content')


<div class="row">
    @if(\Session::has('success'))
    <div class="col-md-12">
        <div id="alert-success" class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div>
    </div>

    <script>
        $('#alert-success').delay(3000).fadeOut("slow");
        function clearLocalStore() {
            //addFood
            localStorage.removeItem('newFoodName');
            localStorage.removeItem('newFoodCate');
            localStorage.removeItem('newFoodAddess');
        }
        clearLocalStore();
    </script>
    @endif

    <div class="col-md-6 colborder">
        <div class="row">
            <div class="col-md-12 colblock">
                <div class="row">
                    <div class="col-md-9 col-sm-8 colhead1">
                        <span class="sphead" style="font-size: 150%;">ข้อมูลเมนู</span>
                    </div>
                    <div class="col-md-3 col-sm-4 colhead2">
                        <a href="{{ url('/food/show/edit' , $food->food_id) }}" class="btn btn-success" style="height: 100%; width: 100%;">แก้ไข</a>
                    </div>
                </div>

                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <img src="{{ asset('/storage/images/food/'.$food->image) }}" id="profileDisplay">
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>ชื่อ</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo">{{ $food->name }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>ประเภท</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo">{{ $food->cate_food->name }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>ที่มา</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo txt-over">{{ $food->addess }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 colborder">
        <div class="row">
            <div class="col-md-12 colblock">
                <div class="row">
                    <div class="col-md-9 col-sm-8 colhead1">
                        <span class="sphead" style="font-size: 150%;">ข้อมูลสารอาหารในเมนู</span>
                    </div>
                    <div class="col-md-3 col-sm-4 colhead2">

                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>แคลอรี่ (kcal)</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo fontcolorpower">{{ floor($food->calorie) }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>ไขมัน (g)</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo fontcolorpower">{{ floor($food->fat) }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>โปรตีน (g)</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo fontcolorpower">{{ floor($food->protein) }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>คาร์โบไฮเดรต (g)</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo fontcolorpower">{{ floor($food->carbohydrate) }}</label>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <span>ใยอาหาร (g)</span>
                    </div>
                </div>
                <div class="row rowFoodInfo">
                    <div class="col-md-12">
                        <label class="form-control lainfo fontcolorpower">{{ floor($food->fiber) }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    <div class="col-md-12 colborder">
        <div class="row">
            <div class="col-md-12 colblock">

                <div class="row">
                    <div class="col-md-9 col-sm-8 colhead1">
                        <span class="sphead" style="font-size: 150%;">รายการวัตถุดิบในเมนู</span>
                    </div>
                    <div class="col-md-3 col-sm-4 colhead2">
                        <a href="{{ url('/food/show/create/igd' , $food->food_id) }}" class="btn btn-success" style="height: 100%; width: 100%;">เพิ่มวัตถุดิบในเมนู</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <span>จำนวนวัตถุดิบที่ใช้: {{$count_iof}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table tbb">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">รูป</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">รายละเอียด</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">หน่วย</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($count_iof == 0)
                                    <tr>
                                        <td class="text-danger">**ไม่มีข้อมูล**</td>
                                    </tr>
                                    @endif

                                    @foreach($iof as $key => $value)
                                    <tr>
                                        <th scope="row">{{ ++$i }}</th>
                                        <td class="table_img"><img src="{{ asset('/storage/images/igd/'.$value->igd_info->image) }}" class="img_igd" alt="Image"></td>
                                        <td>{{ $value->igd_info->name }}</td>
                                        <td>{{ $value->description }}</td>
                                        @if($value->importance == 1)
                                        <td>{{ $value->value }}</td>
                                        <td>{{ $value->unit }}</td>
                                        @else
                                        <td>ไม่ระบุ</td>
                                        <td>ไม่ระบุ</td>
                                        @endif
                                        <td>
                                            <form action="{{ url('/food/show/igd/delete' , $value->igd_of_food_id) }}" method="post" class="delete_form" onSubmit="if(!confirm('คุณต้องการลบข้อมูลหรือไม่ ?')){return false;}" style="margin:  0%;">
                                                @csrf
                                                <a href="{{ url('/food/show/edit/igd/detail' , $value->igd_of_food_id) }}" class="btn btn-primary">แก้ไข</a>
                                                <button type="submit" class="btn btn-danger">ลบ</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        {!! $iof->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 colborder">
        <div class="row">
            <div class="col-md-12 colblock">
                <div class="row">
                    <div class="col-md-9 col-sm-8 colhead1">
                        @if($count_step == 1)
                        <span class="sphead" style="font-size: 150%;">วิธีทำ</span>
                        @else
                        <span class="sphead" style="font-size: 150%;">รายการวิธีทำ</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-4 colhead2">
                        @if($count_step == 0)
                        <a href="{{ url('/food/show/create/step' , $food->food_id) }}" class="btn btn-success" style="height: 100%; width: 100%;">เพิ่มวิธีทำในเมนู</a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <!-- <span>จำนวนวิธีทำ: {{$count_step}}</span> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    @if($count_step == 1)
                                    <th scope="col">รายละเอียด</th>

                                    <th scope="col"></th>
                                    @else
                                    <th scope="col">ลำดับที่</th>
                                    <th scope="col">รายละเอียด</th>

                                    <th scope="col"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>


                                @if($count_step > 1)
                                @foreach($step as $key => $value)
                                <tr>
                                    <th scope="row">{{ $value->order }}</th>
                                    <!-- <td>{{ $value->step }}</td> -->
                                    <td><textarea class="form-control" rows="6" cols="100" readonly style="resize: none;">{{ $value->step }}</textarea></td>
                                    <td>
                                        <form action="{{ url('/food/show/step/delete' , $value->step_of_food_id) }}" id="form2" method="post" onSubmit="if(!confirm('คุณต้องการลบข้อมูลหรือไม่ ?')){return false;}" style="margin:  0%;">
                                            @csrf
                                            <a href="{{ url('/food/show/edit/step' , $value->step_of_food_id) }}" class="btn btn-primary">แก้ไข</a>
                                            <button type="submit" for="form2" class="btn btn-danger">ลบ</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach


                                @elseif($count_step == 1)
                                @foreach($step as $key => $value)
                                <tr>
                                    <td><textarea class="form-control" rows="6" cols="100" readonly style="resize: none;">{{ $value->step }}</textarea></td>
                                    <td>
                                        <form action="{{ url('/food/show/step/delete' , $value->step_of_food_id) }}" id="form2" method="post" onSubmit="if(!confirm('คุณต้องการลบข้อมูลหรือไม่ ?')){return false;}" style="margin:  0%;">
                                            @csrf
                                            <a href="{{ url('/food/show/edit/step' , $value->step_of_food_id) }}" class="btn btn-primary">แก้ไข</a>
                                            <button type="submit" for="form2" class="btn btn-danger">ลบ</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td class="text-danger">**ไม่มีข้อมูล**</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
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
</script>
@endsection
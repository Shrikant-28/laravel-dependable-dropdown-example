@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="frmDesign">
                    @include('partials.alert')
                    <form class="register-form " method="post">
                        @csrf
                        <input type="hidden" name="checkRequest" value="">
                        <fieldset>
                            <legend>
                                Registration
                                <button class="btn btn-default btnClose float-right" type="button"><i class="fa fa-times"></i></button>
                            </legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name:<span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" maxlength="50" minlength="1" required>
                                        <span class="error errorFirstName"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name:<span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" maxlength="50" minlength="1" required>
                                        <span class="error errorLastName"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phonenumber">Contact Number:<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phonenumber" class="form-control" placeholder="Enter Contact Number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required>
                                <span class="error errorPhoneNumber"></span>
                            </div>

                            <div class="form-group">
                                <label for="email_address">Email ID:<span class="text-danger">*</span></label>
                                <input type="text" name="email_address" id="email_address" class="form-control" placeholder="Enter Email Address" maxlength="100"  required>
                                <span class="error errorEmailAddress"></span>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:<span class="text-danger">*</span></label>
                                <textarea name="address" id="address" cols="30" rows="3" class="form-control" placeholder="Enter Address"></textarea>
                                <span class="error errorAddress"></span>
                            </div>


                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country_id">Country:<span class="text-danger">*</span></label>
                                        <select name="country_id" id="country_id" class="selectpicker form-control" data-live-search="true">
                                            <option value="0">--Select--</option>
                                            @forelse ($countries as $country)
                                                <option value="{{ $country->id}}" data-country_id="{{ $country->id}}">{{ $country->name}}</option>
                                            @empty
                                            <option value="-1">No Record Found</option>
                                            @endforelse
                                        </select>
                                        <span class="error errorCountry"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state_id">State:<span class="text-danger">*</span></label>
                                        <select name="state_id" id="state_id" class="selectpicker form-control" data-live-search="true">

                                        </select>
                                        <span class="error errorState"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city_id">City:<span class="text-danger">*</span></label>
                                        <select name="city_id" id="city_id" class="selectpicker form-control" data-live-search="true">

                                        </select>
                                        <span class="error errorCity"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-3 captha-box">
                                <div id="captcha"></div>
                            </div>

                            <button class="btn btn-default mt-2 btn-sm" type="button" onclick="createCaptcha()">Not Readable? &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button>

                            <div class="form-group">
                                <label for="cpatchaTextBox">Captha<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Captcha" name="captcha_input" id="cpatchaTextBox" maxlength="8"/>
                                <span class="error errorCaptcha"></span>
                            </div>

                            <div class="border rounded p-4 bg-smoke">
                                <div class="form-group">
                                    <label for="username">Username:<span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" maxlength="100"  required>
                                    <span class="error errorUsername"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" maxlength="100"  required>
                                    <span class="error errorPassword"></span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" id="btnRegister">Register</button>
                                <button type="reset" class="btn btn-secondary ml-2" id="btnReset">Clear</button>
                            </div>

                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @section('jsExtend')
    <script src="{{asset('assets/bootstrap/js/custom.js')}}" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // bind state from country id
            function loadState(countryId){
                let str = '<option value="0">--Select--</option>';
                $("#state_id").html(str);
                $("#state_id").selectpicker('refresh');
                $.ajax({
                        type: "get",
                        url: "{{ route('fetchState') }}",
                        data: {id:countryId,  _token: '{{csrf_token()}}'} ,
                        dataType: "json",
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function (response) {

                            if(response){
                                $.each(response, function (indexInArray, valueOfElement) {
                                    str += `<option value='${valueOfElement.id}'> ${valueOfElement.name} </option>`;
                                });

                            }
                            $("#state_id").html(str);
                            $("#state_id").selectpicker('refresh');

                            // $("#city_id").selectpicker('refresh');

                        },
                        complete: function () {
                            $('#loader').addClass('hidden')
                        }
                    });
            }

            // bind city from state id
            function loadCity(stateId){
                let str = '<option value="0">--Select--</option>';
                $("#city_id").html(str);
                $("#city_id").selectpicker('refresh');
                $.ajax({
                        type: "get",
                        url: "{{ route('fetchCity') }}",
                        data: {id:stateId,  _token: '{{csrf_token()}}'} ,
                        dataType: "json",
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function (response) {
                            if(response){
                                $.each(response, function (indexInArray, valueOfElement) {
                                    str += `<option value='${valueOfElement.id}'> ${valueOfElement.name} </option>`;
                                });

                            }
                            $("#city_id").html(str);
                            $("#city_id").selectpicker('refresh');

                        },
                        complete: function () {
                            $('#loader').addClass('hidden')
                        }
                    });
            }



            $("#country_id").change(function() {
                loadState($(this).val())
                $("#city_id").html('<option value="0">--Select--</option>');
                $("#city_id").selectpicker('refresh');
            });

            $("#state_id").change(function() {
                loadCity($(this).val())
            });


            createCaptcha();

            function clearErrorText(className){
                $(".".className).text('');
            }

            function clearFormText(fieldName){
                $("input[name=`${fieldName}`]").val('');
            }


            function resetRegisterForm(){
                let clearFormField = [

                ];
                $("#first_name").val('');
                $("#last_name").val('');
                $("#phonenumber").val('');
                $("#email_address").val('');
                $("#address").val('');
                $("#username").val('');
                $("#password").val('');

                $('#country_id').selectpicker('val', '0');
                $('#state_id').selectpicker('val', '0');
                $('#city_id').selectpicker('val', '0');
                $("#cpatchaTextBox").val("");

                let clearFormErrorMessage = [
                    'errorFirstName','errorLastName','errorPhoneNumber','errorEmailAddress','errorAddress','errorCaptcha','errorUsername','errorPassword',
                    'errorCountry','errorState','errorCity'
                ];

                $.each(clearFormErrorMessage, function (indexInArray, valueOfElement) {
                    clearErrorText(valueOfElement);
                });

            }

            function validateRegisterForm(){
                $isValid = 1;

                let clearFormErrorMessage = [
                    'errorFirstName','errorLastName','errorPhoneNumber','errorEmailAddress','errorAddress','errorCaptcha',
                    'errorUsername','errorPassword','errorCountry','errorState','errorCity'
                ];

                $.each(clearFormErrorMessage, function (indexInArray, valueOfElement) {
                    clearErrorText(valueOfElement);
                });

                if($("#first_name").val().trim().length == 0){
                    $(".errorFirstName").text("Please Enter First Name");
                    $isValid = 0;
                }

                if($("#last_name").val().trim().length == 0){
                    $(".errorLastName").text("Please Enter Last Name");
                    $isValid = 0;
                }

                if($("#phonenumber").val().trim().length == 0){
                    $(".errorPhoneNumber").text("Please Enter Phone Number");
                    $isValid = 0;
                }

                var phonenumber = /^\d{10}$/;
                if($("#phonenumber").val().length > 0 && ($("#phonenumber").val().length != 10 || !($("#phonenumber").val().match(phonenumber)))){
                    $(".errorPhoneNumber").text("Phone Number must be 10-Digit");
                    $isValid = 0;
                }

                if($("#cpatchaTextBox").val().trim().length == 0){
                    $(".errorCaptcha").text("Please Enter above Text");
                    createCaptcha();
                    $isValid = 0;
                }

                if($("#email_address").val().trim().length == 0){
                    $(".errorEmailAddress").text("Please Enter Email Address");
                    $isValid = 0;
                }

                if($("#address").val().trim().length == 0){
                    $(".errorAddress").text("Please Enter Address");
                    $isValid = 0;
                }

                if( $("#country_id").val() == 0){
                    $(".errorCountry").text("Please Select Country");
                    $isValid = 0;
                }

                if( $("#state_id").val() == 0 || $("#state_id").val() == null){
                    $(".errorState").text("Please Select State");
                    $isValid = 0;
                }

                if( $("#city_id").val() == 0 || $("#city_id").val() == null){
                    $(".errorCity").text("Please Select City");
                    $isValid = 0;
                }

                if($("#username").val().trim().length == 0){
                    $(".errorUsername").text("Please Enter Username");
                    $isValid = 0;
                }

                if($("#password").val().trim().length == 0){
                    $(".errorPassword").text("Please Enter Password");
                    $isValid = 0;
                }

                return $isValid;
            }

            $('#btnRegister').click(function () {
                //$('input[name=captcha]').remove();

                if(validateRegisterForm() && validateCaptcha()){

                    $.ajax({
                        type: "post",
                        url: "{{ route('register') }}",
                        data: $(".register-form").serialize() ,
                        dataType: "json",
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function (response) {
                            createCaptcha();
                            $('#loader').addClass('hidden');
                            if(response.status){
                                resetRegisterForm();
                                swal("Congratulations!", "You have registered successfully!", "success");

                                location.reload();
                            }else{
                                $("#success-alert").fadeTo(2000, 700).slideUp(700, function() {
                                    $("#success-alert").slideUp(700);
                                });
                                $("#success-alert").addClass('alert-danger').removeClass('alert-success');
                                var str = `
                                <strong>Failed! </strong> ${response.error}
                                `;
                                $(".alert-string").html(str);
                            }
                        },
                        complete: function () {
                            $('#loader').addClass('hidden')
                        },
                    });
                }
            });
        })
    </script>
    @endsection
@endsection

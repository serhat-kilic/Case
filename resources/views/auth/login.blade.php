@extends('layouts.empty')

@section('content')
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal form-simple" id="form" novalidate>
                            {!! csrf_field() !!}
                            <fieldset
                                class="form-group position-relative has-icon-left mb-0 {{ $errors->has('email') ? ' is-invalid' : '' }}">
                                <input type="text" class="form-control" id="user-name" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="{{ __('E-posta') }}" required>
                                <div class="form-control-position">
                                    <i class="la la-user"></i>
                                </div>
                                <span class="help-block"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                @endif
                            </fieldset>
                            <fieldset
                                class="form-group position-relative has-icon-left {{ $errors->has('password') ? ' is-invalid' : '' }}">
                                <input type="password" class="form-control" id="user-password"
                                       placeholder="{{ __('Şifre') }}" required name="password">
                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>
                                <span class="help-block"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                                @endif
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-sm-6 col-12 text-center text-sm-left">
                                    <fieldset>
                                        <input type="checkbox" id="remember-me" name="remember" class="chk-remember">
                                        <label for="remember-me"> {{ __('Beni hatırla' )}}</label>
                                    </fieldset>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i>
                                {{ __('Giriş Yap') }}
                            </button>
                        </form>
                    </div>
                </div>
                <!--                <div class="card-footer">
                                    <div class="">
                                        <p class="float-xl-left text-center m-0"><a href="recover-password.html"
                                                                                    class="card-link">Recover
                                                password</a></p>
                                        <p class="float-xl-right text-center m-0">New to Moden Admin? <a
                                                    href="register-simple.html"
                                                    class="card-link">Sign Up</a></p>
                                    </div>
                                </div>-->
            </div>
        </div>
    </div>
@endsection
@push('script')

    <script>
        $(document).ready((function () {
            $('#form input, #form select').jqBootstrapValidation({
                preventSubmit: false,
                submitSuccess: function ($form, event) {
                    event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '/login',
                        dataType: "json",
                        data: $('#form').serialize(),
                        success: function (response) {
                            console.log(response);
                            if(response.status=='success'){
                                window.location.href="/";
                            }
                        },
                        error: function (jqXHR, exception) {
                            if(jqXHR.status==401){
                                alert('Hatalı kullanıcı adı veya şifre');

                            }
                        },
                    });
                }
            });

        }));
    </script>
@endpush

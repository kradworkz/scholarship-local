<!doctype html>
<html lang="en">

<head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Krad was here" name="description" />
    <meta content="KradWasHere" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

    <link rel="shortcut icon" href="assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>

    <body data-topbar="dark" data-layout="horizontal">
        <div> 

            <div class="account-pages my-5 pt-sm-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card overflow-hidden">
                                <div class="bg-soft-primary">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-4">
                                                <h5 class="text-primary">Lock screen</h5>
                                                <p>Please update your password.</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0"> 
                                   
                                    <div class="p-2 mt-3">
                                    <form class="form-horizontal" method="POST"> @csrf
                                        <input type="hidden" name="email" value="{{ $user->email }}"/>
                                        <div class="form-group">
                                            <label for="userpassword">New Password <b style="color: red; font-size: 12px;"></b></label>
                                            <input class="form-control"id="password" type="password" class="@error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password" placeholder="Enter password">
                                            <input class="form-control" did="password-confirm" type="password" name="password_confirmation" required
                   autocomplete="new-password" placeholder="Enter password" style="margin-top: 5px;">
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-12 text-right">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Unlock</button>
                                            </div>
                                        </div>

                                    </form>
                                    </div>
                
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <div>
                                    <p>©  DOST - IX. <i class="mdi mdi-heart text-danger"></i> 2021</p>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>


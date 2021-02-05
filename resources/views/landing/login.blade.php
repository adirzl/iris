@extends('layouts.app_landing')
@section('content')

    <!-- Large modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-body">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card mx-auto rounded-0 border-0"
                            style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                            <div class="card-body" style="padding: 40px;">
                                <form id="login-form" name="login-form" class="mb-0" action="{{ route('ceklogin') }}"
                                    method="post">
                                    <h3>Login to your Accounts</h3>

                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label for="login-form-username">Username:</label>
                                            <input type="text" id="login-form-username" name="login-form-username" value=""
                                                class="form-control not-dark" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <label for="login-form-password">Password:</label>
                                            <input type="password" id="login-form-password" name="login-form-password"
                                                value="" class="form-control not-dark" />
                                        </div>

                                        <div class="col-12 form-group">
                                            <button class="button button-3d button-black m-0" id="login-form-submit"
                                                name="login-form-submit" value="login">Login</button>
                                            <a href="#" class="float-right">Forgot Password?</a>
                                        </div>
                                    </div>
                                </form>

                                <div class="line line-sm"></div>

                                <div class="w-100 text-center">
                                    <h4 style="margin-bottom: 15px;">or Login with:</h4>
                                    <a href="#" class="button button-rounded si-facebook si-colored">Facebook</a>
                                    <span class="d-none d-md-inline-block">or</span>
                                    <a href="#" class="button button-rounded si-twitter si-colored">Twitter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

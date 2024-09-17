@section('title', 'Inicio de sesion')
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- INSERTAR CONTENIDO -->
    <div class="container" id="login-container">
        <div id="form-container">
            <div class="row">
                <div class="col-md-6 d-none d-md-block" style="padding: 0px !important;">
                    <img src="{{ asset('img/login-img.jpg') }}" alt="Imagen de doctora" class="img img-login">
                </div>
                <div class="col-md-6" id="form-content">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo de El Salvador" class="img logo-form">
                    <form action="{{ route('login') }}" method="POST" class="mt-3 needs-validation" novalidate>
                        @csrf
                        <!-- INICIO USUARIO INPUT -->
                        <div class="form-group text-start">
                            <x-input-label for="email" class="fw-bold label-login" :value="__('EMAIL')" />
                            <input type="email" class="form-control mt-2" id="email" name="email"
                                onkeyup="toLower(this)" :value="old('email')" required autofocus
                                autocomplete="username" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- FIN USUARIO INPUT -->

                        <!-- INICIO CONTRASEÑA INPUT -->
                        <div class="form-group text-start">
                            <x-input-label for="password" class="fw-bold label-login" :value="__('CONTRASEÑA')" />
                            <input type="password" class="form-control mt-2" id="password" name="password"
                                onkeyup="toLower(this)" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <!-- FIN CONTRASEÑA INPUT -->

                        <!-- INICIO CONTRASEÑA INPUT -->
                        <div class="form-group text-center">
                            <input type="submit" value="Iniciar Sesion" class="btn btn-login mb-3" name="btn_login">
                        </div>
                        <!-- FIN CONTRASEÑA INPUT -->

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>

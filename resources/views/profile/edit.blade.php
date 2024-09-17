@extends('layouts/dashboardTemplate')

@section('title', 'Administracion del perfil')

@section('content')


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="container mt-3 mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4 sm:p-8 bg-white shadow rounded">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 sm:p-8 bg-white shadow rounded">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

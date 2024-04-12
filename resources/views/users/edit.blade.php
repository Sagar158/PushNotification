@php
    $route = (!isset($user->id) ? route('users.store') : route('users.update',$user->id));
@endphp
<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Create / Update Users') }}"></x-page-heading>
        <x-back-button></x-back-button>

        <div class="container-fluid card mt-3">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="row card-body">

                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" autofocus autocomplete="off" placeholder="UserName" />
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" autofocus autocomplete="off" placeholder="Email" />
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <x-select-box id="user_type_id" name="user_type_id" :value="old('user_type_id', $user->user_type_id)" :values="\App\Helpers\Helper::fetchUserType()" autocomplete="off" placeholder="User Access Level" />
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <x-text-input id="password" type="password" name="password" :value="old('password')" autofocus autocomplete="off" placeholder="Password" />
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 mt-2">
                        <x-primary-button class="btn btn-primary">
                            {{ __('Save') }}
                        </x-primary-button>
                        <x-back-button></x-back-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function(){
                showUserType();
                $(document).on('change','select[name="user_type_id"]', function(){
                    showUserType();
                });
            });

            function showUserType()
            {
                var user_type_id = $('select[name="user_type_id"]').val();
                if(user_type_id == 2)
                {
                    $('.health-care-div').show('slow');
                }
                else
                {
                    $('.health-care-div').hide('slow');
                }
            }
        </script>
    @endpush
</x-app-layout>

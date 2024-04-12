@php
    $route = (!isset($faq->id) ? route('faq.store') : route('faq.update',$faq->id));
@endphp
<x-app-layout title="{{ $title }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="Create / Update FAQ's"></x-page-heading>
        <x-back-button></x-back-button>

        <div class="container-fluid card mt-3">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="row card-body">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <x-text-input id="question" type="text" name="question" :value="old('question', $faq->question)" required autofocus autocomplete="off" placeholder="FAQ Question" />
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <x-text-area id="description" type="text" name="description" :value="old('description', $faq->description)" autofocus autocomplete="off" placeholder="FAQ Description" />
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
            $(document).ready(function() {
                $('.tinymceExample').summernote({
                    height: 300
                });
            });
        </script>
    @endpush
</x-app-layout>

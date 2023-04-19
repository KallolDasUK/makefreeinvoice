@extends('landing.layouts.app')

@section('content')


    <div class="container"  style="margin-top: 120px">


        <section class="section ">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-12">
                        <p class="text-muted ">
                            <i class=" list-inline-item uil uil-user " aria-hidden="true" ></i>
                            {{ $post->author_name }}
                            <i class=" list-inline-item uil uil-calender " aria-hidden="true" ></i>
                            {{ $post->date }}
                        </p>
                        <div >
                            <img src="{{ asset('storage/'.$post->banner) }}" alt="" style="width: 100%" >
                        </div>
                        <h3 class="mt-2">{{ $post->title }}</h3>
                        {!! $post->content !!}
{{--                        {{ $post->content }}--}}
                    </div>

                </div><!--end row-->

            </div><!--end container-->
        </section>
    </div>


@endsection

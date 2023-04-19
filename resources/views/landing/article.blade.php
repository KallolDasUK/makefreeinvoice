@extends('landing.layouts.app')

@section('content')


    <div class="container"  style="margin-top: 120px;background: lightgrey">


        <section class="section ">

            <div class="container">

                <div class="row">

                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <div class="card blog border-0 rounded shadow " style="height: auto">
                                <div class="card-body content">

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <span class="badge bg-soft-primary">{{ optional($post->category)->category_name }}</span>

                                        <small class="text-muted">{{ $post->date }}</small>
                                    </div>
                                    <a href="{{ route('article_details',['slug'=>$post->slug]) }}">
                                        <img class="card-img-top " src="{{ asset('storage/'.$post->banner) }}" alt="" style="height: 200px">

                                    </a>
                                    <a href="" class="title text-dark h5">{{ $post->title }}</a>
                                    <p>{{ $post->short_summery }}</p>

                                    <div class="mt-3">
                                        <a href="{{ route('article_details',['slug'=>$post->slug]) }}" class="link">Read More <i class="uil uil-arrow-right align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->


                    @endforeach
                </div><!--end row-->

            </div><!--end container-->
        </section>
    </div>


@endsection

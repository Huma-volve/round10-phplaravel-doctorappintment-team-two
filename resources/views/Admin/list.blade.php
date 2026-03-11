@extends('layouts.dashboard')

@section('title')
FAQs Management
@stop

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm">


        <h5 class="text-center mb-4" style="font-size:30px; font-family: 'Poppins', sans-serif;">
            <i class="fa fa-question-circle"></i> FAQs
        </h5>

        <div class="card-body">

            <div class="accordion" id="faqAccordion">

                @forelse($faqs as $faq)

                <div class="card mb-2 border">

                    <div class="card-header p-2" id="heading{{ $faq->id }}">

                        <h6 class="mb-0 d-flex justify-content-between align-items-center">

                            <button class="btn btn-link text-left font-weight-bold"
                                data-toggle="collapse"
                                data-target="#collapse{{ $faq->id }}"
                                aria-expanded="false">

                                {{ $faq->question }}

                            </button>

                            <form action="{{ route('faqs.destroy',$faq->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this FAQ?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </form>

                        </h6>

                    </div>

                    <div id="collapse{{ $faq->id }}"
                        class="collapse"
                        data-parent="#faqAccordion">

                        <div class="card-body">

                            <p class="text-muted p-3">
                                {{ $faq->answer }}
                            </p>

                        </div>

                    </div>

                </div>

                @empty

                <div class="text-center text-muted p-4">
                    No FAQs Found
                </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection
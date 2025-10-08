<!-- Style 2 Modern -->
<li class="grid-item mb-40px">
    <div class="box-hover text-center">
        <figure class="mb-0 position-relative">
            @if($col != 12)
                @if($value->foto)
                    <div class="blog-image position-relative overflow-hidden">
                        <a href="{{ $news_url }}"><img src="{{ $value->get_foto_list() }}" alt="" /></a>
                    </div>
                @endif
            @endif

            <figcaption class="post-content-wrapper">
                <div class="position-relative bg-dark-gray post-content p-30px z-index-2">
                    <div class="hover-text">
                        @if(count($v_category))
                            <div class="blog-categories">
                                @foreach($v_category as $t)
                                    <?php
                                        $url = route('news.category', trim($t));
                                    ?>
                                    <a href="{{ $url }}" class="text-gradient-light-purple-light-orange fs-15 text-uppercase fw-600 mb-5px d-inline-block">{{ $t }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <a href="{{ $news_url }}" class="card-title mb-0 fs-19 lh-26 text-white d-inline-block">{{ $title }}</a>
                    <div class="box-overlay bg-dark-gray z-index-minus-1"></div>
                </div>
                <div class="fs-14 bg-white p-15px lh-initial">
                    @if($value->date)
                        <span class="d-inline-block fs-15 text-gradient-light-blue-light-turquoise mb-5px text-uppercase fw-600">
                            {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d") }}
                            <!-- Nuovo metodo per il print dei mesi in ita -->
                                <?php
                                $month = \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("m");
                                $month_view = config("cmsformula.months")[$month];
                                ?>
                         {{ $month_view }}
                            {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("y") }}
                            <!-- / Date -->
                        </span>

                    @endif

            </figcaption>
        </figure>
    </div>
</li>

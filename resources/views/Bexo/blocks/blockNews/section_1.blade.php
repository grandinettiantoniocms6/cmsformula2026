<!-- Style 1 Grid -->
<div class="col-xl-{{ $col }} col-md-{{ $col }}">
    <div class="blog-item wow fadeInUp" data-wow-delay=".1s">

        @if($col != 12)
            @if($value->foto)

                <div class="blog-thumb">
                    @if(isset($news_url))
                        <a href="{{ $news_url }}"><img src="{{ $value->get_foto_list() }}" alt="" /></a>
                    @endif

                    @if($value->date)
                            <div class="blog-date">

                            <!-- Nuovo metodo per il print dei mesi in ita -->
                                <strong>
                                    {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("y") }}
                                </strong>

                                <span>
                                   <?php
                                       $month = \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("m");
                                       $month_view = config("cmsformula.months")[$month];
                                   ?>

                                    {{ $month_view }}

                                </span>
                            <!-- / Date -->

                        </div>
                    @endif

                </div>

                @if(count($v_category))

                    <div class="blog-content">
                        <div class="blog-meta">
                            @foreach($v_category as $t)
                                    <?php
                                    $url = route('news.category', trim($t));
                                    ?>

                                <span class="categories"><a href="{{ $url }}">{{ $t }}</a></span>

                            @endforeach

                        </div>

                        @if(isset($news_url))

                            <h4 class="title">
                                <a href="{{ $news_url }}">{{ $title }}</a>
                            </h4>
                        @endif

                        @if(isset($news_url))
                            <a href="{{ $news_url }}" class="text-btn">
                                <span class="btn-text"><span>{{ $labelSite['read-news'] }}</span></span>
                                <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                            </a>
                        @endif
                    </div>


                @endif

            @endif
        @endif

    </div>
</div>

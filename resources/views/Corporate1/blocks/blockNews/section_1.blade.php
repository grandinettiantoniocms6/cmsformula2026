<!-- Style 1 Grid -->
<div class="col-md-6 col-lg-{{ $col }}">
    <div class="blog-item wow fadeInUp" data-wow-delay=".25s">

        @if($col != 12)
            @if($value->foto)
                <div class="blog-item-img">
                    @if(isset($news_url))
                        <a href="{{ $news_url }}" class="d-block"><img src="{{ $value->get_foto_list() }}" alt="" /></a>
                    @endif

                    @if($value->date)
                        <span class="blog-date">

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

                        </span>
                    @endif

                </div>

                @if(count($v_category))
                    <div class="blog-item-info">
                        <div class="blog-item-meta">
                            @foreach($v_category as $t)
                                    <?php
                                    $url = route('news.category', trim($t));
                                    ?>

                                <ul>
                                    <li><a href="{{ $url }}"><i class="far fa-folder"></i> {{ $t }}</a></li>
                                </ul>

                            @endforeach
                            @if(isset($news_url))

                                <h4 class="blog-title">
                                    <a href="{{ $news_url }}">{{ $title }}</a>
                                </h4>
                            @endif

                            @if(isset($abstract))
                               <p>{{ $abstract }}</p>
                            @endif

                            @if(isset($news_url))
                                <a href="{{ $news_url }}" class="theme-btn">{{ $labelSite['read-news'] }}<i class="fas fa-arrow-right"></i></a>
                            @endif



                        </div>
                    </div>
                @endif

            @endif
        @endif

    </div>
</div>

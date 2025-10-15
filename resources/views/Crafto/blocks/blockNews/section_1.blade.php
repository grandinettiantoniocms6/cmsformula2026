<!-- Style 1 Grid -->
<li class="grid-item" style="list-style: none!important;">
    <div class="card border-0 border-radius-4px box-shadow-extra-large box-shadow-extra-large-hover">
        @if($col != 12)
            @if($value->foto)
                <div class="blog-image">
                    @if(isset($news_url))
                        <a href="{{ $news_url }}" class="d-block"><img src="{{ $value->get_foto_list() }}" alt="" /></a>
                    @endif

                    @if(count($v_category))
                        <div class="blog-categories">
                            @foreach($v_category as $t)
                                    <?php
                                    $url = route('news.category', trim($t));
                                    ?>
                                <a href="{{ $url }}" class="categories-btn bg-white text-dark-gray text-dark-gray-hover text-uppercase alt-font fw-700">{{ $t }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @endif

        <div class="card-body p-12">
            @if(isset($news_url))
                <a href="{{ $news_url }}" class="card-title mb-15px fw-600 fs-17 lh-26 text-dark-gray text-dark-gray-hover d-inline-block">{{ $title }}</a>
            @endif
            @if(isset($abstract))
               <p>{{ $abstract }}</p>
            @endif
            <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-14 text-uppercase">
                <div class="me-auto">
                    @if(isset($value))
                        @if($value->date)
                            <span class="blog-date fw-500 d-inline-block">
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
                    @endif
                    <div class="d-inline-block author-name">
                        @if(isset($news_url))
                            <a href="{{ $news_url }}" class="text-dark-gray text-dark-gray-hover text-decoration-line-bottom fw-600">{{ $labelSite['read-news'] }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</li>

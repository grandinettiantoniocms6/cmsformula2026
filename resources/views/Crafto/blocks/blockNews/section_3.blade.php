<!-- Style solo data no IMG -->
<li class="grid-item">
    <div class="feature-box border-radius-10px feature-box-left-icon bg-white box-shadow-extra-large box-shadow-extra-large-hover p-11 last-paragraph-no-margin">
        <div class="feature-box-icon">

            @if($value->date)
                <a href="{{ $news_url }}">
                    <time class="text-center post-date border-radius-3px text-uppercase fw-800 d-inline-block" style="padding: 25px; background-color: {{ $contenitore->bgcolor }}; color: {{ $contenitore->date_color }};">
                        {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d") }}
                        <!-- Nuovo metodo per il print dei mesi in ita -->
                            <?php
                            $month = \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("m");
                            $month_view = config("cmsformula.months")[$month];
                            ?>

                        <span class="month d-block lh-24">{{ $month_view }}
                            {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("y") }}
                                        </span>
                        <!-- / Date -->
                    </time>
                </a>
            @endif

        </div>

        <div class="feature-box-content">
            <a href="{{ $news_url }}" class="card-title text-dark-gray text-dark-gray-hover mb-10px fs-18 lh-28 fw-600 d-block">{{ $title }}</a>
                <p>{{ $abstract }}</p><br>
            <a href="{{ $news_url }}" class="text-dark-gray text-dark-gray-hover text-decoration-line-bottom fw-600">{{ $labelSite['read-news'] }}</a>

        </div>


    </div>
</li>
<!-- end blog item -->

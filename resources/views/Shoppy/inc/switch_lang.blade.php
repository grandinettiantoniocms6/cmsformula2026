<?php
$adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("label", "name")->toArray();
?>
@if(count($adminLang) > 1)
    <div class="dropdown ml-5">
        <a href="javascript:void(0)"><img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}"> </a>
        <ul class="dropdown-box">
            @foreach ($adminLang as $lang => $language)
                @if ($lang != App::getLocale())
                    <li class="item-lang" ><a class="item-lang" href="{{ route('lang.switch', $lang) }}"><img width="24" height="16" src="{{ url("img/$lang.svg") }}"></a></li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

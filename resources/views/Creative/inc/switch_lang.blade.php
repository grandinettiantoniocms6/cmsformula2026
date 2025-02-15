<?php
$adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("label", "name")->toArray();
?>
@if(count($adminLang) > 1)
    <li class="dropdown-lang">
        <a href="javascript:void(0)"><img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}"> <i class="ml-1 fas fa-angle-down fa-indicator"></i></a>
        <div class="drop-down">
            <div class="px-2 px-lg-0">
                <ul>
                    @foreach ($adminLang as $lang => $language)
                        @if ($lang != App::getLocale())
                            <li class="item-lang" ><a class="item-lang" href="{{ route('lang.switch', $lang) }}"><img width="24" height="16" src="{{ url("img/$lang.svg") }}"></a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endif

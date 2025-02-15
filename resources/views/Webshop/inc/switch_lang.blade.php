<?php $adminLang = \App\Models\AdminLanguage::where("is_active", 1)->where("is_frontend", 1)
    ->orderBy("lft", "asc")
    ->get()->pluck("label", "name")->toArray();  ?>
@if(count($adminLang) > 1)
    <li class="nav-item nav-item-lang dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img width="24" height="16" src="{{ url("img/".\App::getLocale().".svg") }}" alt="{{ $lang }}"><span class="d-lg-none text-uppercase ms-3 me-auto">{{ $lang }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            @foreach ($adminLang as $lang => $language)
                @if ($lang != App::getLocale())
                    <a class="dropdown-item" title="{{ $lang }}" href="{{ route('lang.switch', $lang) }}"><img width="24" height="16" src="{{ url("img/$lang.svg") }}" alt="{{ $lang }}"></a>
                @endif
            @endforeach
        </div>
    </li>
@endif

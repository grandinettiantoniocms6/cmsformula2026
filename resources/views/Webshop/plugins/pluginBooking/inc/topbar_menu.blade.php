<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
<?php
$menu_topbar = \App\Models\Page::where("is_in_topbar", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
?>

@if($menu_topbar)
    <ul class="nav" id="navbar-user">
        @foreach($menu_topbar as $item)
            <?php
            $target = $item->is_in_blank == 1 ? "_blank" : "";
            if(\Session::has('user_id') && ($item->slug == env("SLUG_LOGIN") || ($item->slug == env("SLUG_REGISTER")))){
                continue;
            }
            $htmlLabel = $item->title;
            $htmlLabelText = $item->title;

            switch ($item->slug){
                case env("SLUG_LOGIN"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='bi bi-person-circle'></i>";
                    }
                    break;
                case env("SLUG_REGISTER"):
                    if($item->icon){
                        $htmlLabel = "<i class='$item->icon'></i>";
                    }else{
                        $htmlLabel = "<i class='bi bi-box-arrow-in-left'></i>";
                    }
                    break;
            }
            ?>

            @if($item->slug != env("SLUG_CART") && $item->slug != env("SLUG_COMPARE"))
                <li class="nav-item nav-item-more">
                    <a class="nav-link" href="/{{ $item->slug }}" target="{{ $target }}" title="{!! $htmlLabelText !!}">{!! $htmlLabel !!}</a>
                </li>
            @endif
        @endforeach
            @if(\Session::has('user_id'))
                <li class="nav-item nav-item-myarea" >
                    <?php
                    $user = \App\User::find(\Session::get('user_id'));
                    ?>
                    @if($user)
                        <a href="/myarea/dashboard" class="btn btn-primary" style="margin-bottom: 5px;" title="{{ @$labels['booking-area-riservata'] }}">{{ $user->name }}</a>
                    @else
                        <a href="/myarea/dashboard" class="btn btn-primary" style="margin-bottom: 5px;" title="{{ @$labels['booking-area-riservata'] }}">{{ @$labels['booking-area-riservata'] }}</a>
                    @endif
                </li>
            @endif
    </ul>
@endif


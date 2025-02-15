<div class="sidebar-box">
    <h6 class="font-small font-weight-normal uppercase">Tags</h6>
    <ul class="tags">
        <?php
        if($item->tags){
          $tags = json_decode($item->tags, true);
            if(key_exists(\App::getLocale(), $tags)){
                $item_tags = explode(",", $tags[\App::getLocale()]);
                if($item_tags){
                    foreach ($item_tags as $v){ ?>
                         <li><a href="/tags?s={{ $v }}">{{ $v }}</a></li>
                    <?php }
                }
             }
        }
        ?>
    </ul>
</div>

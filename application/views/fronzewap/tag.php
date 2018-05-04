
<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>

    <div class="ws_header">
        <i class="fa fa-home" onclick="window.location.href='{url index}'"></i>
        <div class="ws_h_title">{$setting['site_name']}</div>
        <i class="fa fa-search"  onclick="window.location.href='{url question/searchkey}'"></i>
    </div>
<!--最新标签-->
<div class="au_side_box">

    <div class="au_box_title ws_mynewquestion">

        <div>
            <i class="fa fa-tag lv"></i>网站标签

        </div>

    </div>
    <div class="au_side_box_content">
    <div class="" style="padding-top:10px;">
 <!--{loop $taglist $index $tag}-->
 <div class="ui-label" style="margin:10px;display:inline-block;">
{if $tag['pinyin']}
 <a target="_blank"  title="$tag['name']" href="{url question/search}?word=$tag['pinyin']">{$tag['name']}</a>
{else}
 <a target="_blank"  title="$tag['name']" href="{url question/search}?word=$tag['name']">{$tag['name']}</a>
{/if}

</div>

              <!--{/loop}-->



</div>
    </div>

  <div class="pages">
                        $departstr
                        </div>
    </div>


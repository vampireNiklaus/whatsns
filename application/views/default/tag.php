<!--{template header}-->

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/category.css" />
<div class="container collection index" style="padding-top:10px;">

<div class="row" style="padding-top:0px;margin-top:0px">
<div class="col-xs-24 main" style="padding-top:10px;">
  <div class="recommend-collection">
             网站标签
          </div>
    <div class="split-line"></div>
<div class="row" style="padding-top:10px;">
 <!--{loop $taglist $index $tag}-->
 <div class="col-sm-4" style="margin:10px">
{if $tag['pinyin']}
 <a target="_blank"  title="$tag['name']" href="{url tag-$tag['pinyin']}">{$tag['name']}</a>
{else}
 <a target="_blank"  title="$tag['name']" href="{url tag-$tag['name']}">{$tag['name']}</a>
{/if}

</div>

              <!--{/loop}-->



</div>
  <div class="pages">
                        $departstr
                        </div>
</div>


</div>

</div>
<!--{template footer}-->
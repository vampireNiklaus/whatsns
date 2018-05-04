<!--{template meta}-->
<body ontouchstart>
<section class="ui-container">

<div class="ws_header">
  <div class="ws_h_title">{$setting['site_name']}</div>
  <i class="fa fa-search" onclick="window.location.href='{url question/searchkey}'"></i>
</div>
  <!--{eval $headernavlist = $this->fromcache("headernavlist");}-->
<!--导航-->
<ul class="tab-head">
  <!--{loop $headernavlist $headernav}-->
                    <!--{if $headernav['type']==1 && $headernav['available']}-->
                   
                  
                      <li class="tab-head-item <!--{if strstr($headernav['url'],$regular)}--> current<!--{/if}-->"><a  href="{$headernav['format_url']}" title="{$headernav['title']}">{$headernav['name']}</a></li>
                    <!--{/if}-->
                    <!--{/loop}-->
                    

   
</ul>

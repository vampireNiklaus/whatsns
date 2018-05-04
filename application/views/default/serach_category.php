<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/search.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div> <div class="col-xs-16 col-xs-offset-8 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $catlist}-->
   <ul class="user-list">
       <!--{loop $catlist $cat}-->
 <li><a href="{url category/view/$cat['id']}" target="_blank" class="avatar-collection">
 <img src=" {$cat['image']}">
 </a> <div class="info"><a href="{url category/view/$cat['id']}" target="_blank" class="name">
        {$cat['name']}
      </a> <div class="meta"><span>
          收录了{$cat['questions']}个问题 · {$cat['followers']}人关注
        </span></div></div>
        {if $cat['follow']}
 <a class="btn btn-default following" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])"><i class="fa fa-check"></i><span>已关注</span></a>

{else}
 <a class="btn btn-success follow" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])">
 <i class="fa fa-plus"></i><span>关注</span>
 </a>

{/if}


        </li>
          <!--{/loop}-->

        </ul>
   <!--{else}-->
       <div id="no-result">
                <p>抱歉，未找到和您搜索相关的内容。</p>
                <strong>建议您：</strong>
                <ul class="nav">
                    <li><span>检查输入是否正确</span></li>
                    <li><span>简化查询词或尝试其他相关词</span></li>
                </ul>
            </div>
    <!--{/if}-->

<div class="pages">  {$departstr}</div>

         </div>
         </div>
         </div>
         </div>
         <script>
         $(".note-list em").addClass("search-result-highlight");
         </script>

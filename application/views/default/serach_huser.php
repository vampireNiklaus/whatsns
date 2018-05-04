<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/search.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div>
  <div class="col-xs-16 col-xs-offset-8 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $userlist}-->
   <ul class="user-list">
       <!--{loop $userlist $huser}-->
<li><a href="{url user/space/$huser['uid']}" target="_blank" class="avatar"><img src="{$huser['avatar']}"></a> <div class="info"><a href="{url user/space/$huser['uid']}" target="_blank" class="name">
      {$huser['username']}
      {if $huser['author_has_vertify']!=false}<i class="fa fa-vimeo {if $huser['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $huser['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
      </a> <div class="meta"><span>粉丝  {$huser['followers']}</span><span>文章  {$huser['articles']}</span><span>问题  {$huser['questions']}</span></div> <div class="meta"><span>
        回答了 {$huser['answers']} 问题，获得了{$huser['supports']} 个喜欢
        </span></div></div> <user-follow-button user-id="70473"></user-follow-button></li>
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

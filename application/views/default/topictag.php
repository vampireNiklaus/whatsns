<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/search.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div> <div class="col-xs-16 col-xs-offset-8 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $topiclist}-->
   <ul class="note-list">
      <!--{loop $topiclist $index $topic}-->
 <li><div class="content"><div class="author"><a href="{url user/space/$topic['authorid']}" target="_blank" class="avatar">
 <img src=" {$topic['avatar']}">
 </a> <div class="name"><a href="{url user/space/$topic['authorid']}">
 {$topic['author']}
 {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
 </a> <span class="time">
            {$topic['viewtime']}
          </span></div></div> <a href="{url topic/getone/$topic['id']}" target="_blank" class="title">
{$topic['title']}
          </a>
          <p class="abstract">

           {if $topic['price']!=0}
                         <div class="box_toukan ">


											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>



										</div>
                   {else}
                   {eval echo clearhtml($topic['describtion']);}

                    {/if}

          </p> <div class="meta"><a href="{url topic/getone/$topic['id']}" target="_blank"><i class="fa fa-eye"></i> {$topic['views']}
        </a> <a href="{url topic/getone/$topic['id']}#comments" target="_blank"><i class="fa fa-comment-o"></i>  {$topic['articles']}
        </a> <span><i class=" fa fa-heart-o"></i> {$topic['likes']}
        </span> <!----></div></div></li>
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

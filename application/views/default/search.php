<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/search.css" />
<div class="container search">
<div class="row">
<div class="aside">
<!--{template tp_search}-->
 </div> <div class="col-xs-16 col-xs-offset-8 main">
 <div class="search-content"><!----> <div class="result">检索到{$rownum} 个结果</div>

  <!--{if $questionlist}-->
   <ul class="note-list">
       <!--{loop $questionlist $question}-->
 <li><div class="content"><div class="author"><a href="{url user/space/$question['authorid']}" target="_blank" class="avatar">
 <img src=" {$question['avatar']}">
 </a> <div class="name"><a href="{url user/space/$question['authorid']}">
 {$question['author']}
  {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
 </a> <span class="time">
            {$question['format_time']}
          </span></div></div> <a href="{url question/view/$question['id']}" target="_blank" class="title">
{$question['title']}
          </a>
          <p class="abstract">

           {eval echo clearhtml($question['description']);}
          </p> <div class="meta"><a href="{url question/view/$question['id']}" target="_blank"><i class="fa fa-eye"></i> {$question['views']}
        </a> <a href="{url question/view/$question['id']}#comments" target="_blank"><i class="fa fa-comment-o"></i>  {$question['answers']}
        </a> <span><i class=" fa fa-heart-o"></i> {$question['attentions']}
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

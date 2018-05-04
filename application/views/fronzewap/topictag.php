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

    <!--导航提示-->
    <div class="ws_s_au_brif">
        <span class="ws_s_au_bref_item "><a href="{url question/search/$word}">问题</a></span>

        <span class="ws_s_au_bref_item current"><a href="{url topictag-$word}">文章</a></span>
        <span class="ws_s_au_bref_item"><a href="{url user/search/$word}">用户</a></span>
        <span class="ws_s_au_bref_item"><a href="{url category/search/$word}">话题</a></span>

    </div>
   <!--列表部分-->
                    <div class="au_resultitems au_searchlist">
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
        <div class="pages">  {$departstr}</div>
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

                    </div>
   <script>
   
   el2=$.tips({
        content:' 为您找到相关结果约{$rownum}个',
        stayTime:3000,
        type:"info"
    });
   </script>
<!--{template footer}-->
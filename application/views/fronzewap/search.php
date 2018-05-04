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
        <span class="ws_s_au_bref_item current"><a href="{url question/search/$word}">问题</a></span>

        <span class="ws_s_au_bref_item"><a href="{url topictag-$word}">文章</a></span>
        <span class="ws_s_au_bref_item"><a href="{url user/search/$word}">用户</a></span>
        <span class="ws_s_au_bref_item"><a href="{url category/search/$word}">话题</a></span>

    </div>
 <!--列表部分-->
                    <div class="au_resultitems au_searchlist">
                      <!--{if $questionlist}-->
                        <!--{loop $questionlist $question}-->
                        <div class="au_item">
                          <div class="au_question_title"> <a href="{url question/view/$question['id']}" >
{$question['title']}
          </a> <span class="au_cat"><a href="{url category/view/$question['cid']}">{$question['category_name']}</a></span></div>
                          <div class="au_question_user_info">
                              
                              {if $question['hidden']==1}
        <a class="avatar" >
             <img  class="au_question_user_info_avatar" src="{SITE_URL}static/css/default/avatar.gif"/>
        </a>
        <span>匿名用户</span>
        {else}
        
           <img onmouseover="pop_user_on(this, '{$question['authorid']}', 'text');"  onmouseout="pop_user_out();"  class="au_question_user_info_avatar" src="{$question['avatar']}"/><span><a class="fn" href="{url user/space/$question['authorid']}" >
           {$question['author']}
           {if $question['author_has_vertify']!=false}<img src="{SITE_URL}static/css/aozhou/dist/images/renzheng.png"/>{/if}
           </a></span>
                             
  
         
        {/if}
      
           
                              <span><i class="fa fa-twitch"></i>  {$question['answers']}回答 </span>
                            
                              {if $question['shangjin']!=0}
                              <span class="icon_rmb" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" ><img src="{SITE_URL}static/css/aozhou/dist/images/rmb.png" />悬赏$question['shangjin']元</span>
                               {/if}
                                 {if $question['askuid']>0}
                               <span class="au_q_yaoqing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="邀请{$question['askuser']['username']}回答" ><i class="fa fa-twitch"></i>邀请回答</span>
                                 {/if}
                                  {if $question['hasvoice']!=0}
                                    <span class="au_q_yuyin"><i class="fa fa-microphone"></i>语音回答</span>
                                     {/if}
                          </div>
                           <div class="au_question_info_content">
                              {eval echo clearhtml($question['description']);}
                           </div>
                          
                        </div>
                    
                 <!--{/loop}-->
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
          

   <script>
   
   el2=$.tips({
        content:' 为您找到相关结果约{$rownum}个',
        stayTime:3000,
        type:"info"
    });
   </script>
<!--{template footer}-->
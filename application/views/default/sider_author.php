  <div class="recommend"><div class="title">
  <i class="fa fa-zuozhe"></i>
  <span class="title_text">推荐作者</span>
<span class="morelink">
     <a href="{url user/activelist}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
        <ul class="list">

       <!--{loop $userarticle $index $uarticle}-->
        <li>
        <a href="{url user/space/$uarticle['uid']}" target="_self" class="avatar">
        <img src="{$uarticle['avatar']}">
        </a>

          {if  $uarticle['hasfollower']}
   <a class="following" id="attenttouser_{$uarticle['uid']}" onclick="attentto_user_index($uarticle['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>
  {else}
    <a class="follow" id="attenttouser_{$uarticle['uid']}" onclick="attentto_user_index($uarticle['uid'])"><i class="fa fa-plus"></i>关注
        </a>

  {/if}


        <a href="{url user/space/$uarticle['uid']}" target="_self" class="name">
            {$uarticle['username']}{if $uarticle['author_has_vertify']!=false}<i class="fa fa-vimeo {if $uarticle['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $uarticle['author_has_vertify'][0]=='0'}data-original-title="认证用户" {else}data-original-title="认证用户" {/if} ></i>{/if}
        </a>
         <p>
             <span class="dotgreen">{$uarticle['followers']}</span>关注·  <span class="dotgreen">{$uarticle['answers']}</span>回答 · 写了 <span class="dotgreen">{$uarticle['num']}</span>文章
        </p></li>
         <!--{/loop}-->
        </ul>
   </div>
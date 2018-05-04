
            {if $user['vertify']['status']==1}
            <div class="recommend">
   <div class="title">
     <i class="fa fa-renzheng"></i>
   <span  class="title_text">认证信息</span>

   </div>

  <div class="description">

    <div class="js-intro"  style="color:#908d08">
    {$user['vertify']['jieshao']}
    </div>


  </div>
  </div>
   {/if}
            <div class="recommend">
   <div class="title">
     <i class="fa fa-jieshao"></i>
   <span  class="title_text">个人介绍</span>

   </div>

  <div class="description">
    <div class="js-intro">
{if $user['signature']}{$user['signature']}{else}暂无介绍{/if}
    </div>


  </div>
  </div>



  <ul class="list user-dynamic">
    <li>
      <a href="{url user/default}">
        <i class="fa fa-home"></i> <span>我的首页</span>
</a>    </li>
   <li>
      <a href="{url user/invatelist}">
        <i class="fa fa-heart-o"></i> <span>我的邀请</span>
</a>    </li>

  <li>
      <a href="{url user/level}">
        <i class="fa fa-sort-amount-desc"></i> <span>我的等级</span>
</a>    </li>
  <li>
      <a href="{url user/myjifen}">
        <i class="fa fa-registered"></i> <span>我的积分</span>
</a>    </li>

                      <li>
      <a href="{url user/recommend}">
        <i class="fa fa-newspaper-o"></i> <span>为我推荐</span>
</a>    </li>
    <li>
      <a href="{url user/ask}">
        <i class="fa fa-question-circle-o"></i> <span>我的提问</span>
</a>    </li>

   <li>
      <a href="{url user/answer}">
        <i class="fa fa-commenting-o"></i> <span>我的回答</span>
</a>    </li>

   <li>
      <a href="{url topic/userxinzhi/$user['uid']}">
        <i class=" fa fa-rss-square"></i> <span>我的文章</span>
</a>    </li>
<li>
      <a href="{url user/attention/article}">
        <i class="fa fa-sticky-note-o"></i> <span>我关注的文章</span>
</a>    </li>
<li>
      <a href="{url user/attention/question}">
        <i class="fa fa-star-o"></i> <span>我关注的问题</span>
</a>    </li>
<li>
      <a href="{url user/attention}">
        <i class="fa fa-user-circle"></i> <span>我关注的用户</span>
</a>    </li>
<li>
      <a href="{url user/attention/topic}">
        <i class="fa fa-twitch"></i> <span>我关注的话题</span>
</a>    </li>
  <li>
      <a href="{url user/invateme}">
        <i class="fa fa-envelope-open"></i> <span>邀请我回答的问题</span>
</a>    </li>
  </ul>

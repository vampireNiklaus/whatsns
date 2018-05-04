<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />
<div class="container person">
  <div class="row">
    <div class="col-xs-17 main">
          <!-- 用户title部分导航 -->
              <!--{template user_title}-->
 <ul class="trigger-menu" data-pjax-container="#list-container">
 <liclass=""><a href="{url user/default}"><i class="fa fa-clipboard"></i> 动态</a></li>
<li class=""><a href="{url user/ask}"><i class="fa fa-question-circle-o"></i> 提问</a></li>
<li class="active"><a href="{url user/answer}"><i class="fa fa-comments"></i>回答</a></li>
<li class=""><a href="{url ut-$user['uid']}"><i class="fa fa-rss"></i>文章</a></li>
<li class=""><a href="{url user/recommend}"><i class="fa fa-newspaper-o"></i>推荐</a></li>
 </ul>

      <div id="list-container">
        <!-- 回答列表模块 -->
<ul class="note-list">
   <!--{if $answerlist}-->

      <!--{loop $answerlist $question}-->

    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $question['image']!=null}
      <a class="wrap-img"  href="{url question/view/$question['qid']}"  target="_blank">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">





        {if isset($question['hidden'])&&$question['hidden']==1}

          <a class="avatar"  href="javascript:void(0)">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>


        {else}
        <a class="avatar" target="_blank" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$question['authorid']}">{$question['author']}</a>

        {/if}


                <span class="time" data-shared-at="{$question['time']}">{$question['time']}</span>
            </div>
            </div>
            <a class="title" target="_blank"   href="{url question/view/$question['qid']}"  >{$question['title']}</a>
            <p class="abstract">
                {eval echo strip_tags($question['description']);}

            </p>
            <div class="meta">

                    <a target="_blank"   href="{url question/view/$question['qid']}#comments" >
                <i class="fa fa-comment-o"></i> {$question['comments']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$question['supports']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->
      <!--{else}-->
        <div class="text">
            您还没有回答过别人的问题~
          </div>
          <!--{/if}-->














</ul>
  <div class="pages" >{$departstr}</div>
      </div>
    </div>

<div class="col-xs-7  aside">
   <!--{template user_menu}-->
</div>

  </div>
</div>
<!--{template footer}-->
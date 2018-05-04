<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/activelist.css" />
<div class="container recommend ">
 <div class="expertcatlist">
<div class="tabs-wrapper">
        <div class="tabs-mark-group plm ptm">
            <div class="title">所有分类：</div>

            <ul class="content list-unstyled list-inline" style="text-align:left;">
                <li class="classify">
                  <label class="label">{$category['name']}</label>
                </li>

                <li class="classify">
                </li>

                <li class="classify">
                </li>

            </ul>

        </div>

        <div class="tabs-group">
            <div class="title">分类:</div>
            <ul class="content clearfix">
             <li {if $category['id']=='all'}class="active" {/if}><a class="nav-link" href="{url expert/default/all/all}">全部</a></li>


          <!--{loop $sublist $index $cat}-->



           <li {if $category['id']==$cat['id']}class="active" {/if}><a class="nav-link" href="{url expert/default/$cat['id']/all}">{$cat['name']}</a></li>


                <!--{/loop}-->







            </ul>
        </div>





        <div class="tabs-group">
            <div class="title">条件:</div>
            <ul class="content clearfix">
                <li {if $status=='all'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/all}">全部</a></li>
                <li {if $status=='1'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/1}">付费</a></li>
                <li {if $status=='2'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/2}">免费</a></li>

            </ul>
        </div>
    </div>
 </div>
  <div class="row userlist">





        <!--{loop $expertlist $expert}-->


                <div class="col-xs-8 user">
  <div class="wrap expert-list">
    <a class="avatar" target="_blank" href="{url user/space/$expert['uid']}">
      <img src="{$expert['avatar']}" alt="180">
</a>    <h4>
      <a target="_blank" href="{url user/space/$expert['uid']}">
      {$expert['username']}
        {if $expert['author_has_vertify']!=false}<i class="fa fa-vimeo {if $expert['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $expert['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
      </a>

    </h4>
    <p class="description">{eval echo clearhtml($expert['signature'],40);}</p>

{if $expert['hasfollower']==1}
      <a class="btn btn-default following" id="attenttouser_{$expert['uid']}" onclick="attentto_user($expert['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>
{else}
      <a class="btn btn-success follow" id="attenttouser_{$expert['uid']}" onclick="attentto_user($expert['uid'])"><i class="fa fa-check"></i><span>关注</span></a>
{/if}
  {if $expert['mypay']>0}
   <a data-placement="bottom" data-toggle="tooltip" data-original-title="付费{$expert['mypay']}元咨询" class="btn  btn-ask-pay" {if $user['uid']==0} href="javascript:login()" {else} href="{url question/add/$expert[uid]}" {/if}>
                                            <i class="fa fa-twitch"></i><span>付费咨询</span>
 </a>
    {else}
     <a class="btn  btn-ask" {if $user['uid']==0} href="javascript:login()" {else} href="{url question/add/$expert[uid]}" {/if}>
                                            <i class="fa fa-twitch"></i><span>免费咨询</span>

 </a>
      {/if}
  <hr>
   <div class="meta ">擅长分类</div>
    <div class="recent-update-expert ">
           <!--{loop $expert['category'] $category}-->
           {if $category['categoryname']!=''}
                        <a target="_blank" href="{url category/view/$category['cid']}">

                        <label class="label"> {$category['categoryname']}</label>
                        </a>
                        {/if}
                        <!--{/loop}-->

    </div>
    <hr>
    <div class="meta ">精选解答</div>
    <div class="recent-update ">
        <!--{loop $expert['bestanswer'] $index $question}-->
                          {if $index<=2}
                          <a class="new new-question" target="_blank" title="{$question['title']}" href="{url question/view/$question['qid']}">{$question['title']}</a>
                          {/if}
                        <!--{/loop}-->

    </div>
  </div>
</div>
                <!--{/loop}-->



  </div>

    <div class="pages">{$departstr}</div>
</div>
{if $user['uid']>0}
<!-- 专家申请入口 -->
<a href="{url user/vertify}" class="ab_expert_block animated  rubberBand "><div class="icon_expert" ></div><span>{eval echo trim($setting['vertify_gerentip']);}认证</span></a>
{/if}
<!--{template footer}-->
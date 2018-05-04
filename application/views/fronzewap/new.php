<!--{template header}-->
<!--最新问题-->
<div class="au_side_box" style="padding-top:.19rem;">

    <div class="au_box_title ws_mynewquestion">

        <div>
            <i class="fa fa-question-circle lv"></i>最新问题

        </div>

    </div>
     <div class="au_side_box_content">
         <!--列表部分-->
<div class="au_resultitems ">
 <!--{loop $questionlist $index $question}-->
<div class="au_item">
<div class="au_question_title"><a
	href="{url question/view/$question['id']}">{$question['title']}</a><span
	class="au_cat"><a href="{url category/view/$question['cid']}">{$question['category_name']}</a></span></div>
<div class="au_question_user_info">{if $question['hidden']==1} <a
	class="avatar"> <img class="au_question_user_info_avatar"
	src="{SITE_URL}static/css/default/avatar.gif" /> </a> <span>匿名用户</span>
{else} <img
	onmouseover="pop_user_on(this, '{$question['authorid']}', 'text');"
	onmouseout="pop_user_out();" class="au_question_user_info_avatar"
	src="{$question['avatar']}" /><span><a class="fn"
	href="{url user/space/$question['authorid']}">
{$question['author']} {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]==0}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if} </a></span>{/if} <span><i
	class="fa fa-twitch"></i>{$question['answers']} 回答</span> {if
$question['price']!=0} <span class="icon_price" data-toggle="tooltip"
	data-placement="bottom" title=""
	data-original-title="如果回答被采纳将获得 {$question['price']}财富值"><i
	class="fa fa-database"></i>$question['price']财富值</span> {/if} {if
$question['shangjin']!=0} <span class="icon_rmb" data-toggle="tooltip"
	data-placement="bottom" title=""
	data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现"><img
	src="{SITE_URL}static/css/aozhou/dist/images/rmb.png" />悬赏$question['shangjin']元</span>
{/if} {if $question['askuid']>0} <span class="au_q_yaoqing"
	data-toggle="tooltip" data-placement="bottom" title=""
	data-original-title="邀请{$question['askuser']['username']}回答"><i
	class="fa fa-twitch"></i>邀请回答</span> {/if} {if $question['hasvoice']!=0} <span
	class="au_q_yuyin"><i class="fa fa-microphone"></i>语音回答</span> {/if}</div>
<div class="au_question_info_content">{if
$question['articleclassid']!=null&&$question['price']!=0}
<div class="box_toukan "><a class="thiefbox font-12"><i
	class="icon icon-lock font-12"></i>
&nbsp;阅读需支付&nbsp;$question['price']&nbsp;&nbsp;积分……</a></div>
{else} {eval echo clearhtml($question['description']);} {/if}</div>

</div>
<!--{/loop}--></div>
    </div>
      <div class="pages">
                           {$departstr}
                        </div>
    </div>




<!--{template footer}-->
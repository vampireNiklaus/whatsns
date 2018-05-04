<!--{template header}-->
<!--{eval $expertlist=$this->fromcache('expertlist');}-->
<!--专家列表-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
<!--{if $expertlist}-->

<div class="au_expert_list">
     <div class="ws_expert_title">
         <i class="fa fa-user"></i>专家推荐
     </div>
        <div class="swiper-container">
<div class="swiper-wrapper"><!--{loop $expertlist $expert}-->
<div class="swiper-slide" data-swiper-autoplay="2000">
<div class="row">
<div class="col col-md-8">
<div class="au_expert_info"><!--头像-->
<div class="au_expert_info_avatar"><a
	href="{url user/space/$expert['uid']}"><img
	src="{$expert['avatar']}" class="" /></a></div>
<!--个人名称-->
<p class="au_expert_info_author"><a
	href="{url user/space/$expert['uid']}">{$expert['username']} {if $expert['author_has_vertify']!=false}<i class="fa fa-vimeo {if $expert['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $expert['author_has_vertify'][0]==0}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if} </a></p>
<!--个人简介-->
<p class="au_expert_info_text">{$expert['signature']}</p>

<div class="au_expert_btn_roup">{if $expert['hasfollower']==1}
<div id="attenttouser_{$expert['uid']}"
	onclick="attentto_user($expert['uid'])"
	class="au_btn_guanzhu button_followed following"><i class="fa fa-check"></i> 已关注
</div>
{else}
<div id="attenttouser_{$expert['uid']}"
	onclick="attentto_user($expert['uid'])" class="au_btn_guanzhu button_attention follow">
+关注</div>
{/if}

<div class="au_btn_fufei" data-placement="right" data-toggle="tooltip"
	data-original-title="付费{$expert['mypay']}元咨询" {if $user['uid']==0}
	onclick="window.location.href='{url user/login}'"
	{else} onclick="window.location.href='{url question/add/$expert[uid]}'"{/if}><i
	class="fa fa-twitch"></i>付费咨询</div>
</div>
<!--{if $expert['category']}--> <!--擅长领域-->
<p class="au_expert_shanchang">擅长领域: <!--{loop $expert['category'] $category}-->
<span> <a href="{url category/view/$category['cid']}">{$category['categoryname']}</a></span>
<!--{/loop}--></p>
<!--{/if}--></div>
</div>
</div>
</div>

<!--{/loop}--></div>

</div>

    <!-- 如果需要分页器 -->
   <div class="myswiper-pagination">  <div class="swiper-pagination"></div></div>

</div>
<!--{/if}-->
<!--热门主题-->
<!--{template sider_hottopic}-->

<!--最新问题-->
<div class="au_side_box">

    <div class="au_box_title ws_mynewquestion">

        <div>
            <i class="fa fa-question-circle lv"></i>最新问题

        </div>

    </div>
    <div class="au_side_box_content">
        <!--导航-->
        <ul class="tab-head au_tabs">
            <li class="tab-head-item au_tab current" data-tag="tag-nosolve"><a>最新问题</a></li>
            <li class="tab-head-item au_tab" data-tag="tag-score"><a>积分悬赏问题</a></li>
            <li class="tab-head-item au_tab" data-tag="tag-shangjinscore"><a>现金悬赏问题</a></li>
            <li class="tab-head-item au_tab" data-tag="tag-hasvoice"><a>语音回答问题</a></li>
            <li class="tab-head-item au_tab" data-tag="tag-solvelist"><a>已解决问题</a></li>

        </ul>
      <!--列表部分-->
<div class="au_resultitems "><!--{eval $topdatalist=$this->fromcache('topdata');}-->
<!--{loop $topdatalist  $topdata}-->


<div class="au_item">
<div class="au_question_title"><a href="{$topdata['url']}">{$topdata['title']}</a></div>
<div class="au_question_user_info"><img
	onmouseover="pop_user_on(this, '{$topdata['model']['authorid']}', 'text');"
	onmouseout="pop_user_out();" class="au_question_user_info_avatar"
	src="{$topdata['model']['avatar']}" /><span><a class="fn"
	href="{url user/space/$topdata['model']['authorid']}">
{$topdata['model']['author']}{if $topdata['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topdata['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topdata['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}</a></span> <span><i
	class="fa fa-twitch"></i>{$topdata['answers']} </span>  <!--{if $user['grouptype']==1}-->
<a
	href="{url topicdata/cancelindex/$topdata['typeid']/$topdata['type']}">
<span>取消顶置</span> </a> <!--{/if}--></div>
<div class="au_question_info_content">{eval echo clearhtml($topdata['description']);}</div>
<div class="au_zhiding">置顶</div>
</div>




<!--{/loop}--></div>
      <!--最新问题列表部分-->
<div class="au_resultitems ask_item_main_item xm-tag tag-nosolve">

<!--{eval $vnosolvelist=$this->fromcache('nosolvelist');}--> <!--{loop $vnosolvelist $index $question}-->
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
<!--{/loop}-->
  <a href="{url new/default}"><div class="ws_view_more">查看更多></div></a>
</div>
<!--积分问题列表部分-->
<div class="au_resultitems ask_item_main_item xm-tag tag-score hide">

<!--{eval $vnosolvelist=$this->fromcache('rewardlist');}--> <!--{loop $vnosolvelist $index $question}-->
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
<!--{/loop}-->   <a href="{url new/default/0/1}"><div class="ws_view_more">查看更多></div></a>
</div>
<!--现金问题列表部分-->
<div
	class="au_resultitems ask_item_main_item xm-tag tag-shangjinscore hide">

<!--{eval $vnosolvelist=$this->fromcache('shangjinlist');}--> <!--{loop $vnosolvelist $index $question}-->
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
{$question['author']} {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]==0}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}</a></span>{/if} <span><i
	class="fa fa-twitch"></i>{$question['answers']}回答 </span>  {if
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
&nbsp;阅读需支付&nbsp;$question['price']&nbsp;&nbsp;财富值……</a></div>
{else} {eval echo clearhtml($question['description']);} {/if}</div>

</div>
<!--{/loop}-->  <a href="{url new/default/0/2}"><div class="ws_view_more">查看更多></div></a>
</div>
<!--语音问题列表部分-->
<div class="au_resultitems ask_item_main_item xm-tag tag-hasvoice hide">

<!--{eval $vnosolvelist=$this->fromcache('yuyinlist');}--> <!--{loop $vnosolvelist $index $question}-->
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
<!--{/loop}-->   <a href="{url new/default/0/3}"><div class="ws_view_more">查看更多></div></a>
</div>
<!--已解决问题列表部分-->
<div class="au_resultitems ask_item_main_item xm-tag tag-solvelist hide">

<!--{eval $vnosolvelist=$this->fromcache('solvelist');}--> <!--{loop $vnosolvelist $index $question}-->
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
{$question['author']}{if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]==0}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if} </a></span>{/if}  <span><i
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
<!--{/loop}-->   <a href="{url new/default/0/4}"><div class="ws_view_more">查看更多></div></a>


        
       


    </div>
</div>

<!--赏金猎人-->
<!--{template sider_duizhang}-->
</section>

{if $signPackage!=null}
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>

<script>

  wx.config({
      debug: false,
      appId: '{$signPackage["appId"]}',
      timestamp: {$signPackage["timestamp"]},
      nonceStr: '{$signPackage["nonceStr"]}',
      signature: '{$signPackage["signature"]}',
      jsApiList: [
                  'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems'
        
      ]
  });

</script>

<script>


var _topictitle="{$setting['site_name']}";
var imgurl="{$setting['share_index_logo']}"; 	
var topicdescription="{$setting['seo_index_description']}";
var topiclink="{url index}";
wx.ready(function () {
    wx.checkJsApi({
	      jsApiList: [
	       
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ],
	      success: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.hideMenuItems({
	    menuList: ['menuItem:copyUrl','menuItem:openWithQQBrowser','menuItem:openWithSafari','menuItem:originPage','menuItem:share:email']
	});
    wx.onMenuShareAppMessage({
	      title:_topictitle ,
	      desc:topicdescription ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	      //  alert('用户点击发送给朋友');
	      },
	      success: function (res) {
	    
	
	      },
	      cancel: function (res) {
	    	  el2=$.tips({
	   	            content:'取消分享',
	   	            stayTime:1000,
	   	            type:"info"
	   	        });
	       // alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareTimeline({
	      title:_topictitle,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
	    	
	      //  alert('已分享');
	      },
	      cancel: function (res) {
	    	  el2=$.tips({
	   	            content:'取消分享',
	   	            stayTime:1000,
	   	            type:"info"
	   	        });
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });
    wx.onMenuShareQZone({
   	      title: _topictitle,
	      desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
		       // alert('用户点击分享到朋友圈');
		      },
		      success: function (res) {
		    	  el2=$.tips({
		   	            content:'已分享',
		   	            stayTime:1000,
		   	            type:"success"
		   	        });
		      //  alert('已分享');
		      },
		      cancel: function (res) {
		    	  el2=$.tips({
		   	            content:'取消分享',
		   	            stayTime:1000,
		   	            type:"info"
		   	        });
		      //  alert('已取消');
		      },
		      fail: function (res) {
		       // alert(JSON.stringify(res));
		      }
   });
    wx.onMenuShareQQ({
	      title: _topictitle,
	      desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到QQ');
	      },
	      complete: function (res) {
	      //  alert(JSON.stringify(res));
	      },
	      success: function (res) {
	       // alert('已分享');
	      },
	      cancel: function (res) {
	    	   el2=$.tips({
	  	            content:'取消分享',
	  	            stayTime:1000,
	  	            type:"info"
	  	        });
	      //  alert('已取消');
	      },
	      fail: function (res) {
	       // alert(JSON.stringify(res));
	      }
	    });

    wx.onMenuShareWeibo({
    	 title:_topictitle,
    	 desc:'来自微信分享' ,
	      link:topiclink,
	      imgUrl: imgurl,
	      trigger: function (res) {
	       // alert('用户点击分享到微博');
	      },
	      complete: function (res) {
	       // alert(JSON.stringify(res));
	      },
	      success: function (res) {
	       // alert('已分享');
	      },
	      cancel: function (res) {
	       // alert('已取消');
	      },
	      fail: function (res) {
	      //  alert(JSON.stringify(res));
	      }
	    });
});
</script>
{/if}
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script>$.noConflict();</script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop:true,
        autoplay:2000,
        slidesPerView: 2,
        paginationClickable: true,
        spaceBetween: 10,
        // 如果需要分页器
        pagination: {
            el: '.swiper-pagination',
        }
    });
    var intswper=setInterval("swiper.slideNext()", 2000);
    jQuery(".au_tabs .au_tab").click(function(){

    	jQuery(".xm-tag").addClass("hide");
    	jQuery(".au_tabs .au_tab").removeClass("current");
    	jQuery(this).addClass("current");
    	jQuery("."+$(this).attr("data-tag")).removeClass("hide");
    })
</script>
<!--{template footer}-->

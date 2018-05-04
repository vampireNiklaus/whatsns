<!--{template header}-->
  <!--{eval $adlist = $this->fromcache("adlist");}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/detail.css" />

   <script type="text/javascript" src="{SITE_URL}static/js/jquery.qrcode.min.js"></script>
<div class="container index">
<div class="row">
   <div class="col-xs-17 main">
   <div class="note">
    <div class="post">
        <div class="article">
            <h1 class="title"> {$topicone['title']} </h1>
<div class="tag_selects">

 <!--{if $topicone['tags']}-->
                                    <!--{loop $topicone['tags'] $tag}-->


                    <div class="tag_s"><a href="{url topic/search}?word=$tag"><span>{$tag}</span></a></div>
                <!--{/loop}--><!--{else}--><!--{/if}-->
</div>

            <!-- 作者区域 -->
            <div class="author">
                <a class="avatar" href="{url user/space/$member['uid']}">
                    <img src="{$member['avatar']}" alt="144">
                </a>          <div class="info">
                <span class="tag">作者</span>
                <span class="name"><a href="{url user/space/$member['uid']}">
                {$topicone['author']}
                  {if $topicone['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topicone['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topicone['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a></span>
                <!-- 关注用户按钮 -->
                             {if  $is_followedauthor}

  <a class="btn btn-default following" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-check"></i><span>已关注</span></a>

  {else}

         <a class="btn btn-success follow" id="attenttouser_{$member['uid']}" onclick="attentto_user($member['uid'])"><i class="fa fa-plus"></i><span>关注</span></a>

  {/if}

                <!-- 文章数据信息 -->
                <div class="meta">
                    <!-- 如果文章更新时间大于发布时间，那么使用 tooltip 显示更新时间 -->
                    <span class="publish-time" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="最后编辑于 {$topicone['viewtime']}">{$topicone['viewtime']}</span>
                    <span class="wordage">字数 {$topicone['artlen']}</span>
                    <span class="views-count">阅读 {$topicone['views']}</span><span class="comments-count">评论 {$topicone['articles']}</span><span class="likes-count">喜欢 {$topicone['likes']}</span></div>
            </div>
            <!--{if $user['grouptype']==1||$user['uid']==$member['uid']}-->
                <!-- 如果是当前作者，加入编辑按钮 -->
                <a href="javascript:void(0)"  data-toggle="dropdown" class="edit dropdown-toggle">操作 <i class="fa fa-angle-down mar-lr-05"></i> </a>
                 <ul class="dropdown-menu" role="menu">
                {if $user['grouptype']==1}
                       <li>


                    <a href="{url topic/pushhot/$topicone['id']}" data-toggle="tooltip" data-html="true" data-original-title="被推荐文章将会在首页展示">
                        <i class="fa fa-star-o"></i><span>推荐文章</span>
                    </a>
                      </li>
                        <li>


                    <a href="{url topicdata/pushindex/$topicone['id']/topic}" data-toggle="tooltip" data-html="true" data-original-title="被顶置的文章将会在首页列表展示">
                        <i class="fa fa-star-o"></i><span>首页顶置</span>
                    </a>
                      </li>
                      {/if}
                           <li>

                    <a href="{url user/editxinzhi/$topicone['id']}">
                        <i class="fa fa-edit"></i><span>编辑文章</span>
                    </a>
                      </li>
                        <li>

                    <a href="{url user/deletexinzhi/$topicone['id']}">
                        <i class="fa fa-trash-o"></i><span>删除文章</span>
                    </a>
                      </li>

                             </ul>
                               <!--{/if}-->
            </div>
            <!-- -->

            <!-- 文章内容 -->
            <div class="show-content art-content">

                {if $topicone['price']!=0&&$haspayprice==0&&$user['uid']!=$topicone['authorid']}

                         <div class="box_toukan ">

										{if $user['uid']==0}
											<a onclick="login()" class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;积分……</a>
											{else}
											<a onclick="viewtopic($topicone['id'])"  class="thiefbox font-12" style="color:#fff;text-decoration:none;" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topicone['price']&nbsp;&nbsp;积分……</a>
											{/if}


										</div>
                   {else}
                    <p>
                {eval    echo replacewords($topicone['describtion']);    }
                </p>
                    {/if}


            </div>
            <!--  -->

            <div class="show-foot">
                <a class="notebook" href="{url cat-$cat_model['id']}" data-toggle="tooltip" data-html="true" data-original-title="问题归属分类">
                    <i class="fa fa-file-text"></i> <span>{$cat_model['name']}</span>
                </a>          <div class="copyright" data-toggle="tooltip" data-html="true" data-original-title="转载请联系作者获得授权，并标注“文章作者”。">
                © 著作权归作者所有
            </div>
                <div class="modal-wrap" data-report-note="">
<a onclick="openinform(0,'{$topicone['title']}',{$topicone['id']})"  id="report-modal">举报文章</a>
                </div>
            </div>
        </div>
         {if $setting['openwxpay']==1}
<div class="support-author"> <div class="btn-shangta" data-toggle="tooltip" data-placement="top" title="" data-original-title="一共获得了{$totalmoney}元" onclick="wxpay('tid',{$topicone['id']},{$topicone['authorid']} );">打赏支持</div>
{if $shanglist}
 <!--打赏列表-->
   <div class="supporter">
   <ul class="support-list">
       <!--{loop $shanglist  $shang}-->
   <li>
   <a  href="{$shang['url']}" class="avatar"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$shang['operation']}">
   <img src="{$shang['avatar']}">
   </a>
   </li>
    <!--{/loop}-->
   </ul> </div>

{/if}

 </div>
 {/if}

    <div class="meta-bottom">
      <div class="like"><div class="btn like-group"><div class="btn-like"><a href="{url favorite/topicadd/$topicone['id']}"><i class="fa fa-heart-o"></i>关注</a></div> <div class="modal-wrap"><a> {$topicone['likes']}</a></div></div> <!----></div>
      <div class="share-group">
        <a class="share-circle share-weixin" data-action="weixin-share" data-toggle="tooltip" data-original-title="分享到微信">
          <i class="fa fa-wechat"></i>
        </a>
        <a class="share-circle" data-toggle="tooltip" href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=1515056452',u=z||d.location,p=['&amp;url=',e(u),'&amp;title=',e(t||d.title),'&amp;source=',e(r),'&amp;sourceUrl=',e(l),'&amp;content=',c||'gb2312','&amp;pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','{$topicone['image']}', '推荐 {$topicone['author']} 的文章《{$topicone['title']}》','{url topic/getone/$topicone['id']}','页面编码gb2312|utf-8默认gb2312'));" data-original-title="分享到微博">
          <i class="fa fa-weibo"></i>
        </a>




  <script type="text/javascript">document.write(['<a class="share-circle" data-toggle="tooltip"  target="_self" data-original-title="分享到qq空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=',encodeURIComponent(location.href),'&title=',encodeURIComponent(document.title),'" target="_self"   title="分享到QQ空间"> <i class="fa fa-qq"></i><\/a>'].join(''));</script>

      </div>
    </div>

         <!--{if (isset($adlist['question_view']['inner1']) && trim($adlist['question_view']['inner1']))}-->
            <div style="margin-top:5px;">{$adlist['question_view']['inner1']}</div>
            <!--{/if}-->

        <div><div id="comment-list" class="comment-list"><div>
            {if $user['uid']!=0}
 <form class="new-comment">
  <input type="hidden" id="artitle" value="{$topicone['title']}" />
    <input type="hidden" id="artid" value="{$topicone['id']}" />
 <a class="avatar">
 <img src="{$user['avatar']}">
 </a>
 <textarea onkeydown="return topickeydownlistener(event)"  placeholder="写下你的评论..." class="comment-area"></textarea>
 <div class="write-function-block"> <div class="hint">Ctrl+Enter 发表</div>
 <a class="btn btn-send btn-cm-submit" name="comments" id="comments">发送</a> <a class="cancel">取消</a></div>
 </form>
   {else}
  <form class="new-comment"><a class="avatar"><img src="{$user['avatar']}"></a> <div class="sign-container"><a href="{url user/login}" class="btn btn-sign">登录</a> <span>后发表评论</span></div></form>

            {/if}

        </div>
        <div id="normal-comment-list" class="normal-comment-list">
        <div>
        <div>
        <div class="top">
        <span>{$topicone['articles']}条评论</span>


           </div>
           </div>
           <!----> <!---->
            <!--{if $commentlist==null}-->
            <div class="no-comment"></div>

               <div class="text">
           还没有人评论过~
          </div>

              <!--{/if}-->
          <!--{loop $commentlist $index $comment}-->
            <div id="comment-{$comment['id']}" class="comment">
            <div>
            <div class="author">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="avatar">
            <img src="{$comment['avatar']}">
            </a>
            <div class="info">
            <a href="{url user/space/$comment['authorid']}" target="_self" class="name">
            {$comment['author']}
              {if $comment['author_has_vertify']!=false}<i class="fa fa-vimeo {if $comment['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $comment['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
            </a>
            <!---->
             <div class="meta">
             <span>{eval echo ++$index;}楼 · {$comment['time']}</span>
             </div>
             </div>
             </div>
             <div class="comment-wrap">
             <p>
              {$comment['content']}
             </p>

                </div>
                </div>
                 <div class="tool-group">
             <a class="button_agree" id='{$comment['id']}'><i class="fa fa-thumbs-o-up"></i> <span>{$comment['supports']}人赞</span></a>

<a class="getcommentlist" dataid='{$comment['id']}' datatid="{$topicone['id']}"><i class="fa fa-comment"></i> <span>回复{$comment['comments']}</span></a>

                <!--{if 1==$user['grouptype'] ||$user['uid']==$comment['authorid']}-->

    <a data-placement="bottom" title="" data-toggle="tooltip" data-original-title="删除评论"   href="javascript:void(0);" onclick="deletewenzhang($comment['id'])"><i class="fa fa-bookmark-o"></i> <span>删除</span></a>
     <!--{/if}-->

                <!---->
                </div>
               <div class="sub-comment-list  hide" dataflag="0" id="articlecommentlist{$comment['id']}">
              <div class="commentlist{$comment['id']}">

              </div>
              <div class="sub-comment more-comment">
              <a class="add-comment-btn" dataid="{$comment['id']}"><i class="fa fa-edit"></i>
               <span>添加新评论</span></a>
               <!----> <!----> <!---->
               </div>
                <div class="formcomment{$comment['id']} hide">
                <form class="new-comment">
                <!---->
                <textarea placeholder="写下你的评论..." class="commenttext{$comment['id']}"></textarea>
                 <div class="write-function-block">


                  <a class="btn btn-send  btn-sendartcomment" id="btnsendcomment{$comment['id']}"  dataid="{$comment['id']}" datatid="{$topicone['id']}">发送</a>

                  </div>
                  </form>
                   <!---->
                   </div>
                   </div>
                </div>
 <!--{/loop}-->
  <div class="pages" >{$departstr}</div>
             <div class="comments-placeholder" style="display: none;"><div class="author"><div class="avatar"></div> <div class="info"><div class="name"></div> <div class="meta"></div></div></div> <div class="text"></div> <div class="text animation-delay"></div> <div class="tool-group"><i class="iconfont ic-zan-active"></i><div class="zan"></div> <i class="iconfont ic-list-comments"></i><div class="zan"></div></div></div></div></div> <!----> <!---->
             </div>
             </div>
    </div>

    <div class="side-tool"><ul><li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="回到顶部" >
    <a href="#" class="function-button"><i class="fa fa-angle-up"></i></a>
    </li>

      <li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="收藏文章"><a href="{url favorite/topicadd/$topicone['id']}" class="function-button"><i class="fa fa-star"></i></a></li>
      </ul></div>
</div>



   </div>
   <div class="col-xs-7  aside ">
   <div class="recommend">

   <div class="title">
    <i class="fa fa-wenzhang"></i>
   <span  class="title_text">Ta的文章</span>
      <span class="morelink">
     <a href="{url topic/userxinzhi/$member['uid']}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
   <ul class="list">




         <!--{loop $topiclist1 $index $topic}-->
                       <li ><a  class="li-a-title" target="_self" href="{url topic/getone/$topic['id']}" title="{$topic['title']}">{$topic['title']}</a></li>
                       <!--{/loop}-->


      </ul>


    </div>

 <!--{template sider_hotarticle}-->


          {if $topicone['likes']>0}
             <div style="margin:40px auto"><div class="title">收藏的人({$topicone['likes']})</div> <ul class="list collection-follower">

               <!--{loop $followerlist $fuser}-->
             <li><a href="{url user/space/$fuser['uid']}" target="_self" class="avatar">
             <img src="{$fuser['avatar']}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$fuser['username']} · {$fuser['format_time']} 关注"></a>
             </li>
             <!--{/loop}-->

             <a class="function-btn"><i class="fa fa-ellipsis-h"></i></a> <!----></ul>
     </div>
     {/if}
        <!--广告位5-->
        <!--{if (isset($adlist['question_view']['right1']) && trim($adlist['question_view']['right1']))}-->

        <div class="right_ad">{$adlist['question_view']['right1']}</div>


        <!--{/if}-->
   </div>
</div>
</div>
<!-- 举报 -->
<div class="modal fade panel-report" id="dialog_inform">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">举报内容</h4>
    </div>
    <div class="modal-body">

<form id="rp_form" class="rp_form"  action="{url inform/add}" method="post">
<input value="" type="hidden" name="qid" id="myqid">
<input value="" type="hidden" name="aid" id="myaid">
<input value="" type="hidden" name="qtitle" id="myqtitle">
<div class="js-group-type group group-2">
<h4>检举类型</h4><ul>
<li class="js-report-con">
<label><input type="radio" name="group-type" value="1"><span>检举内容</span></label>
</li>
<li class="js-report-user">
<label><input type="radio" name="group-type" value="2"><span>检举用户</span></label>
</li>
</ul>
</div>
<div class="group group-2">
<h4>检举原因</h4><div class="list">
<ul>
<li>
<label class="reason-btn"><input type="radio" name="type" value="4"><span>广告推广</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="5"><span>恶意灌水</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="6"><span>回答内容与提问无关</span>
</label>
</li>
<li>
<label class="copy-ans-btn"><input type="radio" name="type" value="7"><span>抄袭答案</span></label>
</li>
<li>
<label class="reason-btn"><input type="radio" name="type" value="8"><span>其他</span></label>
</li>
</ul>
</div>
</div>
<div class="group group-3">
<h4>检举说明(必填)</h4>
<div class="textarea">
<ul class="anslist" style="display:none;line-height:20px;overflow:auto;height:171px;">
</ul>
<textarea name="content" maxlength="200" placeholder="请输入描述200个字以内">
</textarea>
</div>
</div>
    <div class="mar-t-1">

                <button type="submit" id="btninform" class="btn btn-success">提交</button>
                 <button type="button" class="btn btn-default mar-ly-1" data-dismiss="modal">关闭</button>
      </div>
</form>


    </div>

  </div>
</div>
</div>
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url topic/getone/$topicone['id']}" class="qrcode" title="{url topic/getone/$topicone['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript" src="{SITE_URL}static/ckplayer/video.js" charset="utf-8"></script>
<script>
//投诉
function openinform(qid ,qtitle,aid) {
	  $("#myqid").val(qid);
	  $("#myqtitle").val(qtitle);
	  $("#myaid").val(aid);
	 $('#dialog_inform').modal('show');

}
if(typeof($(".art-content").find("img").attr("data-original"))!="undefined"){
	var imgurl=$(".art-content").find("img").attr("data-original");
	$(".art-content").find("img").attr("src",imgurl);
}
$(".art-content").find("img").attr("data-toggle","lightbox");

function deletewenzhang(current_aid){
	window.location.href=g_site_url + "index.php" + query + "topic/deletearticlecomment/"+current_aid+"/$topicone['id']";

}

$(function(){

		//微信二维码生成
		$('#qr_wxcode').qrcode("{url topic/getone/$topicone['id']}");
	     //显示微信二维码
	     $(".share-weixin").click(function(){
	    	 $(".share-wechat").show();
	     });
	     //关闭微信二维码
	     $(".close").click(function(){
	    	 $(".share-wechat").hide();
	     })
})
 $(".button_agree").click(function(){
             var supportobj = $(this);
                     var tid = $(this).attr("id");
                     $.ajax({
                     type: "GET",
                             url:"{SITE_URL}index.php?topic/ajaxhassupport/" + tid,
                             cache: false,
                             success: function(hassupport){
                             if (hassupport != '1'){






                                     $.ajax({
                                     type: "GET",
                                             cache:false,
                                             url: "{SITE_URL}index.php?topic/ajaxaddsupport/" + tid,
                                             success: function(comments) {

                                             supportobj.find("span").html(comments+"人赞");
                                             }
                                     });
                             }else{
                            	 alert("您已经赞过");
                             }
                             }
                     });
             });
</script>
<!--{template footer}-->
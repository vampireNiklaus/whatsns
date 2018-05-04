<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/category.css" />
<!--{eval $adlist = $this->fromcache("adlist");}-->
<div class="container collection index">
  <div class="row">
    <div class="col-xs-24 col-sm-24 main">
      <!-- 专题头部模块 -->
      <div class="main-top">
        <a class="avatar-collection" href="{url topic/catlist/$catmodel['id']}">
  <img src="$catmodel['bigimage']" alt="240">
</a>       
{if  $is_followed}
 <a class="btn btn-default following" id="attenttouser_{$catmodel['id']}" onclick="attentto_cat($catmodel['id'])"><i class="fa fa-check"></i><span>已关注</span></a>
    
{else}
 <a class="btn btn-success follow" id="attenttouser_{$catmodel['id']}" onclick="attentto_cat($catmodel['id'])"><i class="fa fa-plus"></i><span>关注</span></a>
    
{/if}
 
 
      

        <div class="title">
          <a class="name" href="{url topic/catlist/$catmodel['id']}"> {$catmodel['name']}</a>
        </div>
        <div class="info">
          收录了{$rownum}篇文章 ·{$catmodel['questions']}个问题 · {$catmodel['followers']}人关注
        </div>
      </div>
       <div class="recommend-collection">
            
        
        
          <!--{loop $catlist $index $cat}-->
            
                
                   <a class="collection" href="{url topic/catlist/$cat['id']}">
            <img src="$cat['image']" alt="195" style="height:32px;width:32px;">
            <div class="name">{$cat['name']}</div>
        </a>   
                <!--{/loop}--> 
        
        
        {if $catmodel['pid']}
             <a class="more-hot-collection"  href="{url topic/catlist/$catmodel['pid']}">
        返回上级 <i class="fa fa-angle-right mar-ly-1"></i>
    </a>  
        {/if}
                </div>
      <ul class="trigger-menu" data-pjax-container="#list-container">
      <li class="active"><a href="{url topic/catlist/$catmodel['id']}">
      <i class="fa fa-sticky-note-o"></i> 全部文章</a>
      </li>
        {if $catmodel['isuseask']}
    <li >
      <a href="{url category/view/$catmodel['id']}"><i class="fa fa-sticky-note-o"></i> 相关问题</a>
      </li>
        {/if}
      </ul>
      <div id="list-container">
        <!-- 文章列表模块 -->
          <!--{if $topiclist==null}-->
         <div class="no-comment"></div>
            <div class="text">
           还没有相关文章
          </div>
          <!--{/if}-->
          <div class="row note-list article-list">
           <!--{loop $topiclist $index $topic}-->    
             <div class="col-xs-8  card-box">
               <a class="" target="_blank" title="{$topic['title']}"  href="{url topic/getone/$topic['id']}"   >{eval echo ++$index;}.{$topic['title']}</a>
             </div>
              <!--{/loop}-->
          </div>

      </div>
       <div class="pages">{$departstr}</div>
    </div>
   
  
  </div>
</div>
<!-- 微信分享 -->
<div class="modal share-wechat animated" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" class="close">×</button></div> <div class="modal-body"><h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5> <div data-url="{url question/view/$question['id']}" class="qrcode" title="{url question/view/$question['id']}"><canvas width="170" height="170" style="display: none;"></canvas>
<div id="qr_wxcode">
</div></div></div> <div class="modal-footer"></div></div></div></div>
<script>
var qrurl="{url topic/catlist/$catmodel['id']}";
$(function(){
	//微信二维码生成
	$('#qr_wxcode').qrcode(qrurl);
	 //显示微信二维码
	 $(".share-weixin").click(function(){
	
		 $(".share-wechat").show();
	 });
	 //关闭微信二维码
	 $(".close").click(function(){
		 $(".share-wechat").hide();
		 $(".pay-money").hide();
	 });
});

</script>
<!--{template footer }-->
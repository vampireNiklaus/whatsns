</section>
<script src="{SITE_URL}static/css/fronze/js/main.js"></script>
  <a style="display:none;">{eval echo decode($setting['site_statcode'],'tongji');}</a>
<style>
  .ui-footer-btn .ui-tiled .current, .ui-footer-btn .ui-tiled i.current {
        color:#31b7ad;
    }
    .ui-footer li i{
        font-size: .18rem;
        color: #333333;
    }
    .ui-footer li h6{
        font-size: .13rem;
    }
</style>
<footer class="ui-footer ui-footer-btn {if $hidefooter} hide {/if}">
    <ul class="ui-tiled ui-border-t">
        <li class="<!--{if $regular=='index/default'}--> current<!--{/if}-->">
            <a href="{SITE_URL}" class="">

                <i class="fa fa-home <!--{if $regular=='index/default'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div class="ui-txt-muted <!--{if $regular=='index/default'}--> current<!--{/if}-->"><h6>首页</h6></div>
            </a>

        </li>
        <li>
            <a href="{url question/add}">
                <i class="fa fa-question-circle-o <!--{if $regular=='question/add'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div val="note/list" class="ui-txt-muted <!--{if $regular=='question/add'}--> current<!--{/if}-->"><h6>提问</h6></div>

            </a>
        </li>
        <li>
            <a href="{url user/addxinzhi}">
                <i class="fa fa-file-text-o <!--{if $regular=='user/addxinzhi'}--> current<!--{/if}-->" style="line-height: 34px;"></i>
                <div class="ui-txt-muted <!--{if $regular=='user/addxinzhi'}--> current<!--{/if}-->"><h6>发布文章</h6></div>

            </a>
        </li>
        <li>
         <!--{if $user['uid']!=0}-->

          <a onclick="togglenav()" >
                <img src="{$user['avatar']}" style="width:.3rem;height:.3rem;border-radius:50%;position:relative;top:.03rem;"/>

                <div class="ui-txt-muted "><h6>我的</h6></div>

            </a>
             <div class="navbar-collapse in hide togglemenu"  style="height: auto;width:100%;position:fixed;top:0px;margin-top:0px;right:0px;background:#fff;">
             <ul class="nav navbar-nav">
                    <!--{if $user['groupid']<=3}-->


                                     <li>
                    <a href="{SITE_URL}index.php?admin_main">
                        <span>后台管理</span>
                    </a>          </li>


                                    <!--{/if}-->
                                                <li class="">
                        <a href="{url user/default}" target="_self">
                            <span class="menu-text">个人中心</span>
                        </a>            </li>
                        <li>
              <a class="app-download-btn" href="{url user/recommend}" >
              <span class="menu-text">为我推荐</span></a>
            </li>

                         <li class="" >
                        <a href="{url message/personal}" target="_self" style="position:relative">
                            <span class="menu-text">我的消息</span><span style="position:relative;left:10px;" class="ui-badge-cornernum msg-count"></span>
                        </a>            </li>



             <li>
              <a class="app-download-btn" href="{url user/myjifen}" >
              <span class="menu-text">我的积分</span></a>
            </li>
                <li>
              <a class="app-download-btn" href="{url topic/userxinzhi/$user['uid']}" >
              <span class="menu-text">我的文章</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/ask}" >
              <span class="menu-text">我的提问</span></a>
            </li>

            <li>
              <a class="app-download-btn" href="{url user/answer}" >
              <span class="menu-text">我的回答</span></a>
            </li>
               <li>
              <a class="app-download-btn" href="{url user/attention}" >
              <span class="menu-text">我关注的用户</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/attention/article}" >
              <span class="menu-text">我关注的文章</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/attention/question}" >
              <span class="menu-text">我关注的问题</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/attention/topic}" >
              <span class="menu-text">我关注的话题</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/follower}" >
              <span class="menu-text">我的粉丝</span></a>
            </li>
              <li>
              <a class="app-download-btn" href="{url user/invateme}" >
              <span class="menu-text">邀请我回答的问题</span></a>
            </li>
               <li>
              <a class="app-download-btn" href="{url user/logout}" >
              <span class="menu-text">退出</span></a>
            </li>




                </ul>
            </div>
            <div onclick="togglenav()" class="togglemenu hide" style="background:#000;opacity:0.5;height:100%;width:100%;position:fixed;top:0px;right:0px;z-index:-1;"></div>

            <script type="text/javascript">
            function togglenav(){
            	$(".togglemenu").toggle();
}</script>
         <!--{/if}-->

            {if $user['uid']==0}
             <a href="{url user/login}" >

                <i class="fa fa-user-o " style="line-height: 34px;"></i>
                <div class="ui-txt-muted "><h6>我的</h6></div>

            </a>
            {/if}
        </li>

    </ul>

</footer>
<div id="to_top">返回顶部</div>
<style>
body{margin:0; padding:0}
#to_top{width:30px;display:none; height:40px;bottom:10%;right:0px; padding:10px; font:14px/20px arial; text-align:center;  background:#333; position:fixed; cursor:pointer; color:#fff}
</style>
<script>
$(document).ready(function(){
    var p=0,t=0;
    var oTop = document.getElementById("to_top");
    var screenw = document.documentElement.clientWidth || document.body.clientWidth;
    var screenh = document.documentElement.clientHeight || document.body.clientHeight;
    $(window).scroll(function(e){
            p = $(this).scrollTop();
            var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
            if(scrolltop<=screenh){
            	oTop.style.display="none";
            }else{
            	oTop.style.display="block";
            }
            if(t<=p){//下滚
            	if(scrolltop>50){
            		 $(".nav_top").hide();
            	}

            }

            else{//上滚
            	$(".nav_top").show();
            }
            setTimeout(function(){t = p;},0);
    });
    oTop.onclick = function(){
        document.documentElement.scrollTop = document.body.scrollTop =0;
      }
});


</script>
</body>
</html>
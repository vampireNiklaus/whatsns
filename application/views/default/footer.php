

</div>


   <!--{if $setting['cancopy']==1}-->
              <script src="{SITE_URL}static/js/nocopy.js"></script>
                <!--{/if}-->

<script src="{SITE_URL}static/js/jquery.lazyload.min.js"></script>
<script>

 <!--{if $setting['opensinglewindow']==1}-->
 $("a").attr("target","_self");

                <!--{/if}-->

</script>
<div class="display:none;">
 <!--{if $setting['site_statcode']}--> {eval echo decode($setting['site_statcode'],'tongji');}<!--{/if}-->

</div>
  <div class="side-tool" id="to_top"><ul><li data-placement="left" data-toggle="tooltip" data-container="body" data-original-title="回到顶部" >
    <a href="#" class="function-button"><i class="fa fa-angle-up"></i></a>
    </li>



      </ul></div>
      <script>
window.onload = function(){
  var oTop = document.getElementById("to_top");
  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
  window.onscroll = function(){
    var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;

    if(scrolltop<=screenh){
    	oTop.style.display="none";
    }else{
    	oTop.style.display="block";
    }
  }
  oTop.onclick = function(){
    document.documentElement.scrollTop = document.body.scrollTop =0;
  }
}

</script>

<div class="ws_footer">
    <div class="container">
  <div class="row">
     <div class="col-xs-20">
         <div class="tab-pane in active" id="tab11">
             友情链接:
               <!--{eval $links=$this->fromcache('link');}-->

         <!--{if $links }-->


              <!--{loop $links $link}-->
              <a target="_blank" href="{$link['url']}" title="{$link['description']}">
                <!--{if $link['logo']}-->
                <img src="{$link['logo']}" style="width:140px;height:50px" alt="{$link['name']}" />
                <!--{else}-->
                {$link['name']}
                <!--{/if}-->
            </a>
                <!--{/loop}-->
   <!--{/if}-->
         </div>
        <p class="copyright ">
        Powered by<a target="_blank" href="http://www.whatsns.cn/">whatsns_Ask2V3.7</a>服务
        <a target="_blank" href="{url rss/list}">问题RSS订阅</a>
              <a target="_blank" href="{url rss/articlelist}">文章RSS订阅</a>
        <a target="_blank" href="{url tags}">网站标签</a>
        <a target="_blank" href="{url new}">最新问题</a>
        </p>
         <p class="copyright ">
             Copy  2018  <a>whatsns.com</a>  All  Rright  Reserved.   {$setting['site_icp']}
         </p>


     </div>
      <div class="col-xs-4">
           <div class="ws_qrcode">
               <img src="https://www.ask2.cn/data/attach/logo/wxlogo.jpg">
           </div>
          <p class="text-center">扫一扫</p>
          <p  class="text-center">关注微信公众号</p>
      </div>
  </div>
    </div>
</div>


</body>
</html>

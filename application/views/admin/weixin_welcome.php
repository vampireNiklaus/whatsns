<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置关注回复</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-info">
{$message}
</div>
<!--{/if}-->
<div class="alert alert-success">
<b>欢迎提示语:</b><br><span class="smalltxt">当用户关注时候自动回复设置的话</span>
</div>
<form  class="form-horizontal" action="index.php?admin_weixin/addwelcome{$setting['seo_suffix']}" method="post">
 <div class="form-group">
          <p class="col-md-12 text-left mar-b-1">关注公众号时欢迎提示语:</p>


           <div class="col-md-10">
            <textarea name="word" style="width:600px;height:200px;" id="txtcontent" rows="3" class="form-control">	{$wx['msg']}</textarea>
          </div>

        </div>
         <div class="form-group">
          <p class="col-md-12 text-left mar-b-1">回答不上来配置:</p>


           <div class="col-md-10">
            <textarea name="unword" style="width:600px;height:200px;" id="txtnocontent" rows="3" class="form-control">	{$setting['unword']}</textarea>
          </div>

        </div>

			<input type="submit" class="button" name="submit" value="提 交"></center>
		</form>
<br />


<!--{template footer}-->
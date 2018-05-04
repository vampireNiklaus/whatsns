<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;短信设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<div class="alert  alert-success"><a href="https://www.juhe.cn/docs/api/id/54">点击申请聚合短信应用</a>,50元起，3.7分一条，低门槛，实时到。</div>
		<form action="index.php?admin_setting/sms{$setting['seo_suffix']}" method="post">
			<table class="table">
				<tr class="header">
					<td colspan="2">短信参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码key:</b><br><span class="smalltxt">你在聚合申请的验证码接口都要唯一Key，复制过来就行</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="password" value="{if isset($setting['smskey'])}$setting['smskey']{/if}" name="smskey" /></td>
				</tr>

				<tbody >
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码模板id:</b><br><span class="smalltxt">你创建短信模板的时候的模板ID</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{if isset($setting['smstmpid'])}$setting['smstmpid']{/if}" name="smstmpid" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>短信验证码模板变量:</b><br><span class="smalltxt">您设置的模板变量，根据实际情况修改</span></td>
					<td class="altbg2"><input class="form-control shortinput" value="{if isset($setting['smstmpvalue'])}$setting['smstmpvalue']{/if}" name="smstmpvalue"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>是否启用短信验证码注册:</b><br><span class="smalltxt">开启后没有手机注册的用户登录后会提示验证手机号，同时注册入口取消图形验证码启用短信验证码</span></td>
					<td class="altbg2"><input type="checkbox" class=" " {if isset($setting['smscanuse'])&&$setting['smscanuse']==1} checked {/if} name="smscanuse">启用手机验证码</td>
				</tr>




				</tbody>



			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />
<hr >
<h4>短信验证码发送测试</h4>
<form class="form-horizontal" role="form" method="post" action="index.php?admin_setting/testsms{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">对方手机号码</label>
          <div class="col-md-4">
             <input type="text" name="userphone" id="userphone" value="" placeholder="测试人手机号码，用于接收短信" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-danger" value="发送测试" data-loading="稍候...">
          </div>
        </div>
</form>
<style>

html,body{
	overflow:scroll;
}
</style>
<!--{template footer}-->
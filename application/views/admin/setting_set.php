<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置列表</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

		<form action="{SITE_URL}index.php?admin_totalset/index{$setting['seo_suffix']}" method="post" enctype="multipart/form-data">
			<table class="table">
				<tr class="header">
					<td colspan="2">全局参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>编辑器默认提示语:</b><br><span class="smalltxt">设置编辑器默认提示语!</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['editor_defaulttip']}" name="editor_defaulttip" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>个人认证名称:</b><br><span class="smalltxt">默认显示个人认证</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['vertify_gerentip']}" name="vertify_gerentip" /></td>
				</tr>
			    <tr>
					<td class="altbg1" width="45%"><b>企业认证名称:</b><br><span class="smalltxt">默认显示企业认证</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['vertify_qiyetip']}" name="vertify_qiyetip" /></td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>前端不显示提问和发布文章按钮:</b><br><span class="smalltxt">默认头部显示发布文章和提问按钮</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['shoubuttonindex']==1}checked{/if} name="shoubuttonindex" />勾选不显示
					</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>用户允许设置的擅长分类数目:</b><br><span class="smalltxt">默认能设置三个，建议不超过三个</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['cansetcatnum']}" name="cansetcatnum" /></td>
				</tr>

				<tr>
					<td class="altbg1" width="45%"><b>是否允许重复提问:</b><br><span class="smalltxt">如果标题一样视为同一个问题，不允许入库，默认是不支持重复标题提问</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['canrepeatquestion']==1}checked{/if} name="canrepeatquestion" />允许重复提问
					</td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>是否全站单窗口打开:</b><br><span class="smalltxt">如果开启后打开网页不会新增窗口，在同一个窗口打开</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['opensinglewindow']==1}checked{/if} name="opensinglewindow" />开启单窗口打开模式
					</td>
				</tr>

				<tr>
					<td class="altbg1" width="45%"><b>前台首页顶置数目:</b><br><span class="smalltxt">默认3条，不建议很多，首页顶置内容功能属于社交版，其它模板配置无效</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['list_topdatanum']}" name="list_topdatanum" /></td>
				</tr>
			    <tr>
					<td class="altbg1" width="45%"><b>后台问题管理显示数目:</b><br><span class="smalltxt">默认启用站点设置里全局列表数目设置项，此处如果配置会应用当前显示的设置</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['admin_list_default']}" name="admin_list_default" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>问题详情页面回答数显示:</b><br><span class="smalltxt">默认3条，超过3条会分页</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['list_answernum']}" name="list_answernum" /></td>
				</tr>
			  <tr>
            <td class="altbg1" width="45%"><b>等级经验特权:</b><br><span class="smalltxt text-danger">如果经验值达到这个数值可以免去提问和回答还有发布文章还有站内评论验证码</span></td>
            <td class="altbg2"><input type="text" class="form-control shortinput" value="{if $setting['jingyan']<=0}0 {else}$setting['jingyan']{/if}" name="jingyan"></td>
        </tr>
				  <tr>
            <td class="altbg1" width="45%"><b>禁用右键和复制内容:</b><br>
                <span class="smalltxt">要保护网站知识可以禁用鼠标右键和禁止选择内容复制</span></td>
            <td class="altbg2">
                <input class="radio inline" type="radio" {if 0==$setting['cancopy']}checked{/if} value="0" name="cancopy" >&nbsp;否-不禁用&nbsp;&nbsp;
                       <input class="radio inline" type="radio" {if 1==$setting['cancopy']}checked{/if} value="1" name="cancopy" >&nbsp;是-禁用复制&nbsp;&nbsp;

            </td>
        </tr>
						  <tr>
            <td class="altbg1" width="45%"><b>开启百度分词:</b><br>
                <span class="smalltxt">默认不开启，开启百度分词后会调用百度分词接口生成若干关键词</span></td>
            <td class="altbg2">
                <input class="radio inline" type="radio" {if 0==$setting['baidufenci']}checked{/if} value="0" name="baidufenci" >&nbsp;不开启&nbsp;&nbsp;
             <input class="radio inline" type="radio" {if 1==$setting['baidufenci']}checked{/if} value="1" name="baidufenci" >&nbsp;开启分词&nbsp;&nbsp;
            </td>
        </tr>
           <tr>
            <td class="altbg1" width="45%"><b>微信端首页分享图片:</b><br>
                <span class="smalltxt">微信要求分享图片尺寸200*200，否则超出部分显示看不到</span></td>
            <td class="altbg2"><input type="text" readonly class="form-control" value="{if isset($setting['share_index_logo'])}$setting['share_index_logo']{/if}" name="site_logo">
              <input id="file_upload" name="file_upload_indexlogo" type="file"/>
            </td>
        </tr>
          <tr>
            <td class="altbg1" width="45%"><b>微信公众号二维码:</b><br>
                <span class="smalltxt">上传二维码后，用户可以在用户中心-用户钱包页面关注公众号</span></td>
            <td class="altbg2"><input type="text" readonly class="form-control" value="{if isset($setting['weixin_logo'])}$setting['weixin_logo']{/if}" name="site_logo">
              <input id="file_upload" name="file_upload_weixinlogo" type="file"/>
            </td>
        </tr>
			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />

<style>

html,body{
	overflow:scroll;
}
</style>

<!--{template footer}-->
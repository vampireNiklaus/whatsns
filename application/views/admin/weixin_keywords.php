<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置关注回复</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->

<div class="row">
<div class="col-sm-6">

<form name="wordform" id="wordform" class="form-horizontal" method="post" action="index.php?admin_weixin/addtext{$setting['seo_suffix']}">
<div class="form-group">
          <label class="col-md-2 control-label">自定义关键词</label>
          <div class="col-md-4">
             <input type="text" name="txtname" id="txtname" value="你好" class="form-control">
              <button type="button" class="btn  btn-success mar-t-1" data-toggle="modal" data-target="#showsyskeyword">选择系统关键词</button>
          </div>

        </div>
     <div class="form-group">
          <label class="col-md-2 control-label">触发类型</label>
          <div class="col-md-10">
            <label class="radio-inline"> <input type="radio" name="showtype" value="1" checked=""> 精确匹配 </label>
            <label class="radio-inline"> <input type="radio" name="showtype" value="0"> 模糊匹配 </label>

          </div>
        </div>

<div class="form-group">
          <label class="col-md-2 control-label">回复内容</label>
          <div class="col-md-10">
            <textarea name="txtcontent" style="width:600px;" id="txtcontent" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
          <input type="hidden" name="caozuo" id="caozuo" value="0">
            <input type="hidden" name="systype" id="systype" value="0">
             <input type="submit" id="btnup" name="btnup" class="btn btn-primary" value="保存" data-loading="稍候...">
          </div>
        </div>
</form>
</div>

</div>
<form action="index.php?admin_weixin/del{$setting['seo_suffix']}" method="post" name="wordform">
<table class="table">
<thead>
 <th  ><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></th>
<th>自定义关键词</th>
<th>回复内容</th>
<th>触发方式</th>
<th>是否是系统关键词</th>
<th>操作</th>
</thead>
<tbody>
  <!--{loop $keywordlist $word}-->
  <tr>

  <td ><input type="checkbox" name="id[]" value="{$word['id']}"/><input type="hidden" name="wid[]" value="{$word['id']}" /></td>

<td>
$word['txtname']
</td>
<td>
$word['txtcontent']
</td>
<td>
{if $word['showtype']==1}
精确匹配
{else}
模糊匹配
{/if}
</td>
<td>
{if $word['txttype']==1}
系统关键词
{else}
自定义关键词
{/if}
</td>
<td><a>编辑</a></td>
</tr>

    <!--{/loop}-->

</tbody>
</table>
<div class="pages">{$departstr}</div>
<button type="submit" class="btn btn-danger">提交</button>
</form>
<div class="modal fade" id="showsyskeyword">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">系统关键词</h4>
    </div>
    <div class="modal-body">
     <div class="list-group">
  <a href="javascript:void(0);" class="list-group-item">#最新问题#</a>
  <a href="javascript:void(0);" class="list-group-item">#热门问题#</a>
  <a href="javascript:void(0);" class="list-group-item">#最新文章#</a>
  <a href="javascript:void(0);" class="list-group-item">#站长推荐#</a>
  <a href="javascript:void(0);" class="list-group-item">#附近的人#</a>
  <a href="javascript:void(0);" class="list-group-item">#附近的问题#</a>
</div>
    </div>

  </div>
</div>
</div>

<script>

$(".list-group a").click(function(){
	$("#txtcontent").val($(this).html());
	$("#showsyskeyword").modal("hide");
	$("#systype").val('1');
    var speed=200;//滑动的速度
    $('body,html').animate({ scrollTop: 0 }, speed);
});
$("#btnup").click(function(){
	var name=$("#txtname").val();
	if($.trim(name)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('自定义关键词不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	var content=$("#txtcontent").val();
	if($.trim(content)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('回复内容不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	$("#wordform").attr("action","index.php?admin_weixin/addtext{$setting['seo_suffix']}");
	$("#wordform").submit();
});
</script>
<!--{template footer}-->
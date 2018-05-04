<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
  <script src='{SITE_URL}static/js/common.js' language='javascript'></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置关注回复</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert alert-info">
	{$message}

</div>
<!--{/if}-->

<div class="row">
<div class="col-sm-10">

<form name="wordform" id="wordform" class="form-horizontal" method="post" action="index.php?admin_weixin/addtuwen{$setting['seo_suffix']}" enctype="multipart/form-data">
 <input type="hidden" name="topicclass" id="topicclass"/>
<div class="form-group">
          <label class="col-md-2 control-label">自定义关键词</label>
          <div class="col-md-3">
             <input type="text" name="txtname" id="txtname" value="你好" class="form-control">

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
          <label class="col-md-2 control-label">图文标题</label>
          <div class="col-md-7">
           <input type="text" name="title" id="title" value="{if isset($title)}$title{/if}" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <label class="col-md-2 control-label">封面图片</label>
          <div class="col-md-3">
           <input type="file" name="fmtu" id="fmtu" value="" accept="image/jpeg,image/x-png,image/jpg"  class="form-control">
          </div>
          <div class="col-md-3 text-danger">最好是360*240标准尺寸</div>
        </div>

<div class="form-group">
          <label class="col-md-2 control-label">图文描述</label>
          <div class="col-md-10">
            <textarea name="txtcontent" style="width:800px;" id="txtcontent" rows="3" class="form-control">{if isset($content)}$content{/if}</textarea>
          </div>
        </div>

       <div class="form-group">
         <label class="col-md-2 control-label">图文分类</label>
           <div class="col-md-10">



     <div class="bar_l" style="position:relative;top:6px;">
                        <span id="selectedcate" class="selectedcate"></span>
                        <span><a  class="btn btn-primary" data-toggle="modal" data-target="#myLgModal" id="changecategory" href="javascript:void(0)">选择分类</a>

 </span>
   </div>

            </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">图文详情</label>
          <div class="col-md-10">

              <script type="text/plain" id="mycontent" name="content" style="width:810px;height:300px;">{if isset($neirong)}$neirong{/if}</script>
                                                <script type="text/javascript">UE.getEditor('mycontent');</script>


          </div>
        </div>

              <div class="form-group">
          <label class="col-md-2 control-label">外部链接</label>
          <div class="col-md-6">
           <input type="text" name="wburl" id="wburl" value="{if isset($wburl)}$wburl{/if}" class="form-control">
          </div>
           <div class="col-md-4 text-danger">
              填写外部链接后，图文详情会失效，直接跳转外部链接，务必 http/https开头
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
  <div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div id="dialogcate">
        <form name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{if isset($question['id'])}$question['id']{/if}" />
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{if isset($question['cid1'])}{$question['cid1']}{/if}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{if isset($question['cid2'])}{$question['cid2']}{/if}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{if isset($question['cid3'])}{$question['cid3']}{/if}" />
            <table class="table table-striped">
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" size="8" name="category2" ></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                    <td width="125px">
                        <select id="category3"  class="catselect" size="8"  name="category3" ></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                    <span>
                    <input  type="button" id="layer-submit" class="btn btn-danger" value="确&nbsp;认" onclick="selectcate();"/></span>
                    <span>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                    </span>
                    </td>

                </tr>
            </table>
        </form>
    </div>
    </div>
  </div>
</div>


</div>
<form action="index.php?admin_weixin/deltuwen{$setting['seo_suffix']}" method="post" name="wordform">
<table class="table">
<thead>
 <th  ><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall"><label for="chkall">删除</label></th>
<th>自定义关键词</th>
<th>图文标题</th>

<th>图文描述</th>
<th>触发方式</th>
<th>操作</th>
</thead>
<tbody>
  <!--{loop $keywordlist $word}-->
  <tr>

  <td ><input type="checkbox" name="id[]" value="{$word['id']}"/><input type="hidden" name="wid[]" value="{$word['wzid']}" /></td>

<td>
$word['txtname']
</td>
<td>
$word['title']
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
{if $word['wburl']!=''}
<p class="text-danger">外部链接不支持编辑</p>
{else}
<a class="hand" href="index.php?admin_topic/edit/$word['wzid']{$setting['seo_suffix']}">编辑</a>
{/if}



</td>
</tr>

    <!--{/loop}-->

</tbody>
</table>
<div class="pages">{$departstr}</div>
<button type="submit" class="btn btn-danger">提交</button>
</form>


<!--用户中心结束-->
<script type="text/javascript">
    var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};
        $(document).ready(function() {
        initcategory(category1);




        });
        function selectcate() {
            var selectedcatestr = '';
            var category1 = $("#category1 option:selected").val();
            var category2 = $("#category2 option:selected").val();
            var category3 = $("#category3 option:selected").val();
            if (category1 > 0) {
                selectedcatestr = $("#category1 option:selected").html();
                $("#topicclass").val(category1);

            }
            if (category2 > 0) {
                selectedcatestr += " > " + $("#category2 option:selected").html();
                $("#topicclass").val(category2);

            }
            if (category3 > 0) {
                selectedcatestr += " > " + $("#category3 option:selected").html();
                $("#topicclass").val(category3);

            }
            $("#selectedcate").html(selectedcatestr);
            $("#changecategory").html("更改");
            $("#myLgModal").modal("hide");
        }
</script>
<script>

$("#btnup").click(function(){
	var name=$("#txtname").val();
	if($.trim(name)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('自定义关键词不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	var titlename=$("#title").val();
	if($.trim(titlename)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('图文标题不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	var _fmtu=$("#fmtu").val();
	if($.trim(_fmtu)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('封面图片务必上传', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}

	var _wburl=$("#wburl").val();



	var content=$("#txtcontent").val();
	if($.trim(content)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('图文描述', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	var content=$("#topicclass").val();
	if($.trim(content)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('图文分类必须选择', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}


	$("#wordform").attr("action","index.php?admin_weixin/addtuwen{$setting['seo_suffix']}");
	$("#wordform").submit();
});
</script>
<!--{template footer}-->
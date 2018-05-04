<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置关注回复</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->


{if $type=='errormsg'}
<div class="alert alert-warning">{$message}</div>
{else}
<div class="alert alert-success">{$message}</div>
{/if}

<!--{/if}-->

<hr>
<div class="alert alert-info font-18 bold">只有认证得服务号才能生成自定义菜单，一级菜单最多三个，二级菜单最多5个，微信规定!!!</div>
<a class="btn btn-success mar-b-1"  data-toggle="modal" data-target="#menu_model">添加菜单</a>
<div class="alert alert-warning font-18">如果同时填写关键词和外部url则点击菜单会直接跳转到url指向的页面</div>
<table class="table table-bordered  table-hover">
  <tr>
     <td  class="bold font-15">
             菜单名
     </td>
   <td  class="bold font-15">
     菜单类型
     </td>
   <td  class="bold font-15">
     关键词
     </td>
   <td  class="bold font-15">
     外链
     <td  class="bold font-15">

      操作</td>
  </tr>
   <!--{loop $modellist $model}-->


           <tr>

           <td>
  $model['menu_name']
   </td>
  <td>
    {if $model['menu_type']=='CLICK'}
       关键词触发
    {else}
    外部链接，点击会跳转网页
    {/if}
  </td>
  <td>
 $model['menu_keyword']
  </td>
   <td>
    $model['menu_link']
   </td>
  <td>

    <a href="{url admin_weixin/delmenu/$model['id']}" class="text-danger mar-lr-1 hand" >删除</a>
  </td>
    </tr>
    {if $model['sublist']}
     <!--{loop $model['sublist'] $submodel}-->

           <tr>

           <td>
  ------.$submodel['menu_name']
   </td>
  <td>
    {if $submodel['menu_type']=='CLICK'}
       关键词触发
    {else}
    外部链接，点击会跳转网页
    {/if}
  </td>
  <td>
 $submodel['menu_keyword']
  </td>
   <td>
    $submodel['menu_link']
   </td>
  <td>

    <a href="{url admin_weixin/delmenu/$submodel['id']}" class="text-danger mar-lr-1 hand" >删除</a>
  </td>
    </tr>
       <!--{/loop}-->
    {/if}
               <!--{/loop}-->



</table>

<hr>
<a class="btn btn-danger mar-t-1" id="btnmakemenu">生成公众号菜单</a>

<form name="menuform" id="menuform" class="form-horizontal" action="index.php?admin_weixin/addnav{$setting['seo_suffix']}" role="form" method="post">
<div class="modal fade" id="menu_model">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">微信公众号菜单配置</h4>
    </div>
    <div class="modal-body">
      <div class="form-group">
          <label class="col-md-2 control-label">菜单名</label>
          <div class="col-md-4">
             <input type="text" name="menu_name" id="menu_name" value="" placeholder="公众号菜单名字" class="form-control">
          </div>
        </div>
          <div class="form-group">
          <label class="col-md-2 control-label">父级菜单</label>
          <div class="col-md-4">
           <select name="menu_pid" id="menu_pid" class="form-control">
            <option value="0">不选择</option>
             <!--{loop $menulist $menu}-->
              <option value="{$menu['id']}" >{$menu['menu_name']}</option>
               <!--{/loop}-->

            </select>
          </div>
        </div>
          <div class="form-group">
          <label class="col-md-2 control-label">菜单类型</label>
          <div class="col-md-4">
           <select name="menu_type" id="menu_type" class="form-control">
            <option value="CLICK" selected="selected">关键词触发</option>
              <option value="VIEW" >外部链接</option>

            </select>
          </div>
        </div>
           <div class="form-group keywordtype">
          <label class="col-md-2 control-label">关键词</label>
          <div class="col-md-4">
             <input type="text" name="menu_keyword" id="menu_keyword" value="" placeholder="公众号菜单关键词" class="form-control">
          </div>
        </div>
           <div class="form-group linktype hide">
          <label class="col-md-2 control-label">外部链接</label>
          <div class="col-md-8">
             <input type="text" name="menu_link" id="menu_link" value="" placeholder="公众号菜单外链,带上http" class="form-control">
          </div>
        </div>
    </div>
    <div class="modal-footer">

      <button type="button" class="btn btn-primary" name="btnsave" id="btnsave">保存</button>

         <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
  </div>
</div>
</div>
</form>
<script>


$("#menu_type").change(function(){
	switch($(this).val()){
	case 'CLICK':
		$(".keywordtype").css("display","").removeClass("hide");
		$(".linktype").css("display","none").addClass("hide");
		break;
	case 'VIEW':
		$(".keywordtype").css("display","none").addClass("hide");
		$(".linktype").css("display","").removeClass("hide");
		break

	}
})
$("#btnsave").click(function(){
	var menu_name=$("#menu_name").val();
	var menu_type=$("#menu_type").val();
	var menu_keyword=$("#menu_keyword").val();
	var menu_link=$("#menu_link").val();
	if($.trim(menu_name)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('菜单名称不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}
	switch(menu_type){
	case 'CLICK':
		if($.trim(menu_keyword)==""){
			// 使用jQuery对象
			var msg = new $.zui.Messager('关键词不能为空', {placement: 'center',time:'1000'});
			// 显示消息
	        msg.show();
			return false;
		}
		break;
	case 'VIEW':
		if($.trim(menu_link)==""){
			// 使用jQuery对象
			var msg = new $.zui.Messager('外部链接不能为空', {placement: 'center',time:'1000'});
			// 显示消息
	        msg.show();
			return false;
		}
		break

	}

	$("#menuform").submit();
})
$("#btnmakemenu").click(function(){
	  $.ajax({
          type: "POST",
          url: "{SITE_URL}index.php?admin_weixin/makemenu{$setting['seo_suffix']}",
          success: function(data) {
             // 使用jQuery对象
  			var msg = new $.zui.Messager(data, {placement: 'center',time:'1000'});
  			// 显示消息
  	        msg.show();
  		console.log(data);
          }
      });
});

</script>
<!--{template footer}-->
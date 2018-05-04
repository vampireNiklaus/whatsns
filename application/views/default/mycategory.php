<!--{template header}-->

<link rel="stylesheet" media="all" href="{SITE_URL}static/css/bianping/css/space.css" />





<!--用户中心-->


    <div class="container person">

        <div class="row ">
            <div class="col-xs-17 main">
  <!--{template user_title}-->
       <!-- 内容页面 -->
    <div class="row">
                 <div class="col-sm-24">
                     <div class="dongtai">


                      <ul class="trigger-menu" data-pjax-container="#list-container">
        <li><a href="{url user/profile}">个人资料</a></li>
                    <li ><a href="{url user/uppass}">修改密码</a></li>
                 <li class=""><a href="{url user/editemail}">激活</a></li>
                    <li ><a href="{url user/editimg}">修改头像</a></li>
                    <li class="active">
                    <a href="{url user/mycategory}">我的设置</a>
                    </li>
                      <li>
                    <a href="{url user/vertify}">申请认证</a>
                    </li>
             </ul>
                          {eval if ($setting['cansetcatnum']==null||trim($setting['cansetcatnum'])=='')$setting['cansetcatnum']='1';}
                         <div class=" alert alert-warning">您最多可添加{$setting['cansetcatnum']}个分类</div>
                    <div class="row" style="padding-top:0px;">
                    <div class="col-sm-16">

                    <div>为更好推荐您擅长的问题，请设置您的擅长分类</div>
                    <div>

                                <input type="hidden" value="" name="cids" id="cate_value" />

                            </div>
                              <div><button {if count($user['category'])>=$setting['cansetcatnum']}class="btn disabled  btn-danger"{else} class="btn btn-danger" {/if}  id="changecategory" onclick="checkcategory()" ><span>添加擅长分类+</span></button></div>
                    <div class="modal fade" id="myLgModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div id="dialogcate">
        <form name="editcategoryForm" action="{url question/movecategory}" method="post">
            <input type="hidden" name="qid" value="{$question['id']}" />
            <input type="hidden" name="category" id="categoryid" />
            <input type="hidden" name="selectcid1" id="selectcid1" value="{$question['cid1']}" />
            <input type="hidden" name="selectcid2" id="selectcid2" value="{$question['cid2']}" />
            <input type="hidden" name="selectcid3" id="selectcid3" value="{$question['cid3']}" />
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
                    <input  type="button" class="btn btn-success" value="确&nbsp;认" onclick="add_category();"/></span>
                    <span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </span>
                    </td>

                </tr>
                 <tr>
                    <td colspan="5">
                     <ul class="taglist tag">

                     </ul>
                    </td>

                </tr>
            </table>
        </form>
    </div>
    </div>
  </div>
</div>

                    </div>

                   <div class="col-sm-8">
                        您的擅长领域：
                            <ul id="cate_view" class="tag">
                                <!--{loop $user['category'] $category}-->
                                <li class="item" id="{$category['cid']}">{$category['categoryname']}<i class="icon icon-times text-danger hand"></i></li>
                                <!--{/loop}-->
                            </ul>
                   </div>
                    </div>
                   <div class="row">
                   <div class="col-sm-24">

                    <p class="mar-t-1 font-18">外部账号绑定</p>
                    <hr>
                     <table class="table table-striped">
                                <tbody>
                                    <tr><th class="s0">登录方式</th><th class="s2">状态</th><th class="s3">管理</th></tr>
                                    <!--{if $qqlogin}-->
                                    <tr>
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/qq}">解除绑定</a></td>
                                    </tr>
                                    <!--{else}-->
                                    <tr>
                                        <td><i class="fa fa-qq mar-ly-1"></i>QQ账号</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/qqlogin/index.php">点击绑定</a></td>
                                    </tr>
                                    <!--{/if}-->
                                    <!--{if $sinalogin}-->
                                    <tr>
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td><font color="green">已绑定</font></td>
                                        <td><a href="{url user/unchainauth/sina}">解除绑定</a></td>
                                    </tr>
                                    <!--{else}-->
                                    <tr>
                                        <td><i class="fa fa-weibo mar-ly-1"></i>sina微博</td>
                                        <td>未绑定</td>
                                        <td><a href="{SITE_URL}plugin/sinalogin/index.php">点击绑定</a></td>
                                    </tr>
                                    <!--{/if}-->
                                </tbody>
                            </table>
                   </div>
                   <div class="col-sm-24">
                     <p class="mar-t-1 font-18">付费对我提问(最高不超过2w人民币)，单位：元</p>
                    <hr>
                   <form>
                      {if $user['category']!='' }
   <div class="alert alert-info-inverse mar-t-05">没有设置分类,设置擅长分类能获得更多展示机会，增加曝光率</div>

   {/if}
                     <div class="form-group">

    <input  type="number" oninput="change()" onpropertychange="change()" value="{$user['mypay']}"  class="form-control" id="mypay" placeholder="设置付费提问金额，最高不超过2W">
  </div>
   <button type="button" id="btnsubmit" class="btn btn-success">提交</button>

                    </form>
                   </div>
                   </div>
                     </div>
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside ">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>



<!--用户中心结束-->

<script type="text/javascript">
var catsetnum={$setting['cansetcatnum']};
function change(){
	var _val=$("#mypay").val();
	if(parseInt(_val)<1){
		new $.zui.Messager('最小金额不低于一元。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
	if(parseInt(_val)>20000){
		new $.zui.Messager('最大金额不超过2W人民币。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
}
$("#btnsubmit").click(function(){
	var _val=$("#mypay").val();
	if(parseInt(_val)<1){
		new $.zui.Messager('最小金额不低于一元。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}
	if(parseInt(_val)>20000){
		new $.zui.Messager('最大金额不超过2W人民币。', {
		    icon: 'heart',
		    placement: 'bottom' // 定义显示位置
		}).show();

		return false;
	}

	   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:"{SITE_URL}/?user/ajaxsetmypay",
		        //提交的数据
		        data:{mypay:_val},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){

		          if(data=='1'){
		        	  new $.zui.Messager('设置成功!', {
			    		    icon: 'heart',
			    		    placement: 'bottom' // 定义显示位置
			    		}).show();
		          }else{
		        	  new $.zui.Messager('设置失败!', {
			    		    icon: 'heart',
			    		    placement: 'bottom' // 定义显示位置
			    		}).show();
		          }


		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
})
$(".taglist").html($("#cate_view").html());
    var category1 = {$categoryjs[category1]};
            var category2 = {$categoryjs[category2]};
            var category3 = {$categoryjs[category3]};

        initcategory(category1);
        fillcategory(category2, $("#category1 option:selected").val(), "category2");
        fillcategory(category3, $("#category2 option:selected").val(), "category3");
        $("#cate_view .icon-times,.taglist .icon-times").click(function() {
            var cid = $(this).parent().attr("id");

            $.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});

            $(this).parent().remove();

            if ($('#cate_view li').size() < catsetnum) {
                $("#changecategory").removeClass("disabled");
            }


        });
    function deletemycat(cid){

    }
    function checkcategory(){
    	  $(".taglist").html($("#cate_view").html());
    	  $('#myLgModal').modal("show");
    }
    function add_category() {

        var selected_category1 = $("#category1 option:selected");
        var selected_category2 = $("#category2 option:selected");
        var selected_category3 = $("#category3 option:selected");
        if ($('#cate_view li').size() >= catsetnum) {
        	$('#myLgModal').modal("hide");
            return false;
        }
        var selected_cid = 0;
        if (selected_category3.val() > 0) {
            selected_cid = selected_category3.val();
            $("#cate_view").append('<li class="item">' + selected_category3.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        } else if (selected_category2.val() > 0) {
            selected_cid = selected_category2.val();
            $("#cate_view").append('<li class="item">' + selected_category2.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        } else if (selected_category1.val() > 0) {
            selected_cid = selected_category1.val();
            $("#cate_view").append('<li class="item">' + selected_category1.html() + '<i class="icon icon-times text-danger hand"></i></li>');
        }
        if (selected_cid > 0) {
            $.post("{SITE_URL}index.php?user/ajaxcategory", {cid: selected_cid});
        }
        $(".taglist").html($("#cate_view").html());
        $("#cate_view .icon-times,.taglist .icon-times").click(function() {
            var cid = $(this).parent().attr("id");

            $.post("{SITE_URL}index.php?user/ajaxdeletecategory", {cid: cid});

            $(this).parent().remove();

            if ($('#cate_view li').size() < catsetnum) {
                $("#changecategory").removeClass("disabled");
            }


        });
        if ($('#cate_view li').size() >= catsetnum) {
            $("#changecategory").addClass("disabled");

        }
        $('#myLgModal').modal("hide");
    }

</script>
<!--{template footer}-->
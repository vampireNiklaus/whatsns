<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置关注回复</div>
</div>
<div class="alert alert-danger font-18 text-danger">

共{$rownum}个粉丝
</div>
<hr>
<button class="btn btn-info" id="updatefensi" >更新粉丝信息</button>

<table class="table mar-t-1">
<thead>
<th>
用户头像
</th>
<th>
用户昵称
</th>
<th>
国家
</th>
<th>
省份
</th>
<th>
城市
</th>
<th>
性别
</th>
</thead>
<tbody>

  <!--{loop $muserlist $muser}-->
<tr>
<td>
<img  width="35" height="35" data-toggle="lightbox" src="{$muser['headimgurl']}" data-image="{$muser['headimgurl']}" data-caption="姓名：{$muser['nickname']} &nbsp;&nbsp;省份：{$muser['province']}&nbsp;&nbsp;性别：{$muser['sex']} &nbsp;&nbsp;城市：{$muser['city']}" class="img-rounded" alt="" width="200">

</td>
<td>
{$muser['nickname']}
</td>
<td>
{$muser['country']}
</td>
<td>
{$muser['province']}
</td>
<td>
{$muser['city']}
</td>
<td>
{$muser['sex']}
</td>
</tr>
    <!--{/loop}-->
</tbody>
</table>
   <div class="pages">{$departstr}</div>
<script>
var count=0;
var openids;
var d_l;
function getuserinfo(_openid){
    $.ajax({
        type: "POST",
        data:{getuserinfo:'getuserinfo',openid:_openid},
        datatype:'text',
        url: "{SITE_URL}index.php?admin_weixin/getuserinfo{$setting['seo_suffix']}",
        success: function(data) {


        	 count++;

        	 var msg = new $.zui.Messager("第"+count+"条信息"+data, {placement: 'center',time:'1000'});
     		// 显示消息
             msg.show();
        	 if(count<d_l){
        		 getuserinfo(openids[count]);
        	 }else{

        		 var msg = new $.zui.Messager("全部更新完毕", {placement: 'center',time:'1000'});
          		// 显示消息
                  msg.show();
                  setTimeout(function(){
                	  window.location.href="{SITE_URL}index.php?admin_weixin/getfollowers{$setting['seo_suffix']}";
                  },300);
        	 }
        }
    });
}
$("#updatefensi").click(function(){
    $.ajax({
        type: "POST",
        data:{updatefensi:'updatefensi'},
        datatype:'json',
        url: "{SITE_URL}index.php?admin_weixin/getfollowers{$setting['seo_suffix']}",
        success: function(data) {
        	  var data = JSON.parse(data); // 解析成json对象

        	   openids=data.data.openid;

        	   d_l=openids.length;


        	  getuserinfo(openids[0]);
        }
    });
});

</script>
<!--{template footer}-->
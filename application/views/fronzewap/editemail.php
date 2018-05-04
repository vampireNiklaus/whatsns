<!--{template header}-->
<style>
.ui-panel {
    overflow: visible;
    margin-bottom: 10px;
clear:both;
}
</style>
<section class="ui-container">
<!--{template user_title}-->
    <ul class="ui-tab-nav ui-border-b">
        <li ><a href="{url user/profile}">个人资料</a></li>
        <li class="current"><a href="{url user/editemail}">激活账号</a></li>
        <li > <a href="{url user/mycategory}">我的设置</a></li>

    </ul>
    <section class="ui-panel ui-panel-pure ui-border-t">
    <h3>激活邮箱：</h3>
 {if $user['active']==0}
              <div class="ui-tips ui-tips-warn">
    <i></i><span> 邮箱没有激活</span>
</div>
               {else}
               <div class="ui-tips ui-tips-success">
    <i></i><span>邮箱已经激活</span>
</div>
       
               {/if}
                 <form class="profileform ui-form"  method="POST" name="upinfoForm"  action="{url user/editemail}" >
      <input type="hidden" name="formkey" id="formkey" value="{$_SESSION['formkey']}" >

     
       
           <div class="ui-row">
          <p class="ui-col ui-col-25 text-left " style="position:relative;top:12px;">邮箱地址：</p>
          <div class="ui-col ui-col-50 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" name="email" id="email"  value="{$user['email']}" placeholder="输入个人邮箱账号" class="form-control">
            
          </div>
           {if $user['active']==0}
           <div class="ui-col ui-col-25">
             <button type="button" id="sendvertifile"  class="ui-btn ui-btn-primary">邮箱激活验证发送</button>
           </div>
            {/if}
        </div>
        
       
             <div class="ui-row">
        
          <div class="ui-col ui-col-50 ui-form-item ui-form-item-pure ui-border-b">
               <input type="text" id="code" name="code" placeholder="输入验证码">
          </div>
        
        
             <div class="ui-col ui-col-25">
             <!-- 若按钮不可点击则添加 disabled 类 -->
                <button type="button" class="ui-border-l"><img class="ui-border-l" src="{url user/code}" onclick="javascript:updatecode();" id="verifycode"></button>
         
           </div>
        </div>
         
        
        <div class="ui-row">
          <div class=" ui-col ui-col-100">
            
              {if $user['active']==0}
                <input type="submit" name="submit" id="submit" class="ui-btn-lg ui-btn-success" value="保存并激活" data-loading="稍候..."> 
               {else}
               <input type="submit" name="submit" id="submit" class="ui-btn-lg ui-btn-success" value="修改并重新激活" data-loading="稍候..."> 
               {/if}
          </div>
        </div>
 </form>
 
</section>
              
         
  
   <section class="ui-panel ui-panel-pure ui-border-t">
    <h3>激活手机号：</h3>
    {if $user['phoneactive']==0}
                <div class="ui-tips ui-tips-warn">
                 <i></i><span>     手机号没有激活</span>
                 </div>
              
                          
               {else}
                
            <div class="ui-tips ui-tips-success">
    <i></i><span>  手机号已经激活</span>
</div>
   
               {/if}
                   <form class="profileform ui-form"  method="POST" name="upinfoForm"  action="{url user/editphone}" >
                 
           <div class="ui-row">
          <p class="ui-col ui-col-25 text-left " style="position:relative;top:12px;">手机号码：</p>
          <div class="ui-col ui-col-50 ui-form-item ui-form-item-pure ui-border-b">
             <input type="text" name="userphone" id="userphone"  value="{$user['phone']}" placeholder="输入个人手机号" class="form-control">
          
          </div>
        
           <div class="ui-col ui-col-25">
             <button type="button" style="position:relative;top:5px;" id="testbtn"  class="ui-btn ui-btn-primary" onclick="gosms()" >发送短信验证码</button>
           </div>
          
        </div>
             <div class="ui-row">
      
          <div class="ui-col ui-col-50 ui-form-item ui-form-item-pure ui-border-b">
              <input type="text" id="code" name="code" placeholder="输入短信验证码">
          </div>
        
         
          
        </div>
        
       <div class="ui-row">
          <div class=" ui-col ui-col-100">
            
           {if $user['phoneactive']==0}
              <input type="submit" name="submit" id="submit" class="ui-btn-lg ui-btn-success" value="激活验证" data-loading="稍候..."> 
              
                          
               {else}
                
          
       <input type="submit" name="submit" id="submit" class="ui-btn-lg ui-btn-success" value="重新激活短信验证" data-loading="稍候..."> 
               {/if}
               
          </div>
        </div>
        
                </form>
</section>
        
         
           
             
            
</section>
 <!--用户中心结束-->
  {if $user['active']==0}
<script>
$("#sendvertifile").click(function(){
	
   var _formkey=$("#formkey").val();
   var email='{$user['email']}';
   if($.trim(email)==''||$.trim(email)=='null'||email=='undefined'){
	   alert("您还没设置过邮箱，请先点击保存按钮保存邮箱");
	   return false;
   }
   if(confirm("您将要激活{$user['email']},如果不想激活当前邮箱，请先修改保存在激活，系统将会发送激活邮件")){
    $.ajax({
        //提交数据的类型 POST GET
        type:"POST",
        //提交的网址
        url:'{url user/sendcheckmail}',
        data:{formkey:_formkey},
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
        
        //成功返回之后调用的函数
        success:function(data){
        	$(".messagetip").html(data);
          $("#modeltip").modal("show");
      
        }   ,
       
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }
    });	
   }
})
</script>
{/if}
 
<!--{template footer}-->
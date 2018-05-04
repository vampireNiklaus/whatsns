<!--{template meta}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>
    <div class="ws_header">
    <i onclick="window.history.go(-1)" class="fa fa-angle-left"></i>
    <div class="ws_h_title">用户注册</div>
<span class="ws_ab_reg" onclick="window.location.href='{url user/login}'"><i class="fa fa-user-o"></i>登录</span>
</div>
  <div class="au_login_panelform sign">
        <form class="new_user" method="post">
         <input type="hidden" id="tokenkey" name="tokenkey" value='{$_SESSION["registrtokenid"]}'/>
            <div class="input-prepend ">
                <input placeholder="你的昵称" type="text" value="" id="username" name="user_name" onblur="check_username();">
                <i class="fa fa-user"></i>
            </div>
            <div class="input-prepend ">
                <input placeholder="你的邮箱" type="text" value="" id="email" name="email" onblur="check_email();">
                <i class="fa fa-envelope"></i>
            </div>
              {if $setting['smscanuse']==1}
            <div class="input-prepend  no-radius js-normal ">

                <input placeholder="手机号" type="tel"  onblur="check_phone();" maxlength="11" id="userphone" name="userphone">
                <i class="fa fa-phone"></i>
            </div>

            <div class="input-prepend  no-radius security-up-code js-security-number ">
                <input type="text" id="seccode_verify" name="seccode_verify" placeholder="手机验证码" onblur="check_phone();">
                <i class="fa fa-get-pocket"></i>
                <a id="testbtn" onclick="gosms()" class="btn-up-resend js-send-code-button" href="javascript:;">发送验证码</a>

            </div>
             {else}

            <div class="input-prepend  no-radius js-normal ">
                    <img src="{url user/code}" onclick="javascript:updatecode();" id="verifycode">

                    <input autocomplete="OFF" type="text" class="form-control" id="seccode_verify" name="seccode_verify" placeholder="验证码">
              <i class="fa fa fa-get-pocket"></i>
                  </div>
                {/if}
            <div class="input-prepend ">
                <input placeholder="设置密码" type="password" id="password" name="password" autocomplete="OFF" onblur="check_passwd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
            <div class="input-prepend">
                <input placeholder="确认密码" type="password" id="repassword" name="repassword" autocomplete="OFF"  onblur="check_repasswd();" maxlength="20">
                <i class="fa fa-lock"></i>
            </div>
  <div class="input-prepend ">
                <input placeholder="邀请码，非必填" type="text" {if $invatecode}readonly{/if} value="{if $invatecode}$invatecode{/if}" id="frominvatecode"  name="frominvatecode" >
                <i class="fa fa-envelope"></i>
            </div>
            <input type="button" id="regsubmit" onclick="cheklogin()" value="注册" class="sign-up-button">
            <p class="sign-up-msg">点击 “注册” 即表示您同意并愿意遵守协议<br> <a target="_blank" href="#">用户协议</a> 和 <a target="_blank" href="#">隐私政策</a> 。</p>
        </form>
            <!--{if $setting['sinalogin_open']||$wxbrower||$setting['qqlogin_open']}-->
        <!-- 更多登录方式 -->
        <div class="more-sign">

            <h6>第三方登录</h6>
            <ul>
                <!--{if $setting['sinalogin_open']}-->
                <li><a class="weibo" href="{SITE_URL}plugin/sinalogin/index.php"><i class="fa fa-weibo"></i></a></li>
                <!--{/if}-->
               <!--{if $wxbrower}-->
                <li><a class="weixin" href="{SITE_URL}?plugin_weixin/wxauth"><i class="fa fa-wechat"></i></a></li>
                <!--{/if}-->
                <!--{if $setting['qqlogin_open']}-->
                <li><a class="qq" href="{SITE_URL}plugin/qqlogin/index.php"><i class="fa fa-qq"></i></a></li>
                <!--{/if}-->



            </ul>

        </div>
         <!--{/if}-->
    </div>


    <section id="scripts">






      <script type="text/javascript">
    var usernameok = 1;
    var password = 1;
    var repasswdok = 1;
    var emailok = 1;
    var codeok = 1;
    function check_username() {
        var username = $.trim($('#username').val());
        var length = bytes(username);

        if (length < 3 || length > 15) {

        	el2=$.tips({
                content:'用户名请使用3到15个字符',
                stayTime:1000,
                type:"info"
            });


            usernameok = false;
        } else {
            $.post("{url user/ajaxusername}", {username: username}, function(flag) {
                if (-1 == flag) {


                	 el2=$.tips({
                         content:'此用户名已经存在',
                         stayTime:2000,
                         type:"info"
                     });

                    usernameok = false;
                } else if (-2 == flag) {


                	 el2=$.tips({
                         content:'用户名含有禁用字符',
                         stayTime:2000,
                         type:"info"
                     });
                    usernameok = false;
                } else {

                	 el2=$.tips({
                         content:'用户名可以使用',
                         stayTime:1000,
                         type:"success"
                     });

                    usernameok = true;
                }
            });
        }
    }

    function check_passwd() {
        var passwd = $('#password').val();
        if (bytes(passwd) < 6 || bytes(passwd) > 16) {




        	 el2=$.tips({
                 content:'密码最少6个字符，最长不得超过16个字符',
                 stayTime:2000,
                 type:"info"
             });
            password = false;
        } else {


            password = 1;
        }
    }

    function check_repasswd() {
        repasswdok = 1;
        var repassword = $('#repassword').val();
        if (bytes(repassword) < 6 || bytes(repassword) > 16) {
        	 el2=$.tips({
                 content:'密码最少6个字符，最长不得超过16个字符',
                 stayTime:2000,
                 type:"info"
             });

            repasswdok = false;
        } else {
            if ($('#password').val() == $('#repassword').val()) {


                repasswdok = true;
            } else {
            	 el2=$.tips({
                     content:'两次密码输入不一致',
                     stayTime:2000,
                     type:"info"
                 });

                repasswdok = false;
            }
        }
    }

    function check_email() {
        var email = $.trim($('#email').val());
        if (!email.match(/^[\w\.\-]+@([\w\-]+\.)+[a-z]{2,4}$/ig)) {



        	 el2=$.tips({
                 content:'邮件格式不正确',
                 stayTime:1000,
                 type:"info"
             });

            usernameok = false;
        } else {
            $.post("{url user/ajaxemail}", {email: email}, function(flag) {
                if (-1 == flag) {
                	 el2=$.tips({
                         content:'此邮件地址已经注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else if (-2 == flag) {
                	 el2=$.tips({
                         content:'邮件地址被禁止注册',
                         stayTime:1000,
                         type:"info"
                     });

                    emailok = false;
                } else {
                    emailok = true;

                	 el2=$.tips({
                         content:'邮箱名可以注册',
                         stayTime:1500,
                         type:"success"
                     });
                }
            });
        }
    }




    function cheklogin(){


        var _uname=$("#username").val();
        var _upwd=$("#password").val();
        var _rupwd=$("#repassword").val();
        var _code=$("#seccode_verify").val();
        var _email=$("#email").val();
        var _frominvatecode=$("#frominvatecode").val();
        var _apikey=$("#tokenkey").val();
        var el='';
        {if $setting['smscanuse']==1}
        var _phone=$("#userphone").val();

      	  var _rs=check_phone(_phone);
      	if(!_rs){
      		 alert("手机号码有误");
      		 return false;
      	}
        var _data={phone:_phone,uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,apikey:_apikey,seccode_verify:_code};
        {else}
        var _data={uname:_uname,upwd:_upwd,rupwd:_rupwd,email:_email,frominvatecode:_frominvatecode,apikey:_apikey,seccode_verify:_code};
        {/if}
        $.ajax({
            //提交数据的类型 POST GET
            type:"POST",
            //提交的网址
            url:"{url api_user/registerapi}",
            //提交的数据
            data:_data,
            //返回数据的格式
            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend:function(){
         	    el=$.loading({
         	        content:'加载中...',
         	    })
            },
            //成功返回之后调用的函数
            success:function(data){
            	 el.loading("hide");

                if(data=='reguser_ok'){





                  window.location.href="{SITE_URL}?user/default";



                }else if(data=='reguser_ok1'){
                	 el2=$.tips({
                         content:'注册成功，系统已发送注册邮件，24小时之内请进行邮箱验证，在您没激活邮件之前你不能发布问题和文章等操作！',
                         stayTime:1500,
                         type:"success"
                     });

                	   window.location.href="{SITE_URL}?user/default";
                }else{
                	switch(data){


                	case 'reguser_cant_null':

                		 el2=$.tips({
                             content:'用户名或者密码不能为空',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_Illegal':
                		 el2=$.tips({
                             content:'注册邮箱不合法',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_has_exits':
                		 el2=$.tips({
                             content:'邮箱已注册',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'regemail_cant_use':
                		 el2=$.tips({
                             content:'此邮箱不能注册使用',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'reguser_has_exits':
                		 el2=$.tips({
                             content:'注册用户名已经存在',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	case 'Illegal':
                		 el2=$.tips({
                             content:'用户名或者密码包含特殊字符',
                             stayTime:1000,
                             type:"info"
                         });

                		break;
                	default:

                		 el2=$.tips({
                             content:data,
                             stayTime:1000,
                             type:"info"
                         });
                		break;
                	}
                }
            }   ,
            //调用执行后调用的函数
            complete: function(XMLHttpRequest, textStatus){
         	    el.loading("hide");
            },
            //调用出错执行的函数
            error: function(){
                //请求出错处理
            }
        });
        return false;
    }



      //验证码
        function updatecode() {
            var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
            $('#verifycode').attr("src", img);
        }

</script>
    </section>

<script src="{SITE_URL}static/css/fronze/js/main.js"></script>

<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">



<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->
 <script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>
<script>
$.noConflict()
</script>
<style>
	.editor_container {
			 
			height:160px; 
			
			background-color: #fff;
			text-align: left;
			box-shadow: 0 0 10px #ccc;
			text-shadow: none; 
            margin:10px 10px;
		}
		.wangEditor-drop-panel{
			left:0px;
		margin-left:0px;
		width:100%;
		     
}
</style>
<div class="editor_container">
  <textarea  id="editor" name="content"  style="width:100%;height:100px;">
 
                    {if $this->get[1]!='view'&&$this->get[0]=='question'||$this->get[1]=='editxinzhi'}
               
             <p>
        
           {if $navtitle=='编辑问题'}  {$question['description']} {/if}
             {$topic['describtion']}
            
           {if $user['groupid']==1||$user['uid']==$answer['authorid']&&$this->get[1]=='editanswer'&&$this->get[0]=='question'}    {$answer['content']} {/if}</p>
           {/if}
                  {if $this->get[0]=='question'&&$this->get[1]=='add'}
{$setting['editor_defaulttip']}
{/if}
            </textarea>
</div>
<script type="text/javascript">
var testeditor='999';
var editor=null;


		// 初始化编辑器的内容
		   editor = new wangEditor('editor');
		// 自定义配置
			editor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
			editor.config.uploadImgFileName = 'wangEditorMobileFile';
			// 阻止输出log
		    	editor.config.printLog = true;
		
		    	editor.config.hideLinkImg = true;
			  // 普通的自定义菜单
		    // 普通的自定义菜单
    editor.config.menus = [
                       
	                           

	                          
	                           'eraser',
	                     
	                           'quote',
	                         
	                  
	                          
	                           '|',
	                           'img',
	                       
	                        
	                           'undo',
	                           'redo',
	                           'fullscreen'     ];

		    // 将全屏时z-index修改为20000
		   // editor.config.zindex =-1;
	    editor.create();
	    $(".wangEditor-container").css("z-index","1");

	 
	   
	</script>
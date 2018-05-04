<!--{template header}-->
<script src="js/admin.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;标签管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<input type="button" class="btn btn-success" value="批量转拼音" onclick="getpinyin()" />
<div class="alert alert-info"><p class="pinyintip"></p></div>
    <!--{if $departstr}-->

          <div class="pages">{$departstr}</div>

        <!--{/if}-->
<form onsubmit="return confirm('该操作不可恢复，您确认要删除选中的标签吗？');"  action="index.php?admin_tag/delete{$setting['seo_suffix']}"  method=post>
    <table class="table" >
        <tr class="header"><td colspan="3">标签列表</td></tr>
        <tr class="header" align="center">
            <td width="6%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('delete[]')" type="checkbox" name="chkall"><label for="chkall">&nbsp;操作</label></td>
            <td  width="20%">标签名称</td>
            <td  width="55%">问题数</td>
             <td  width="20%">拼音标记</td>
        </tr>
        <!--{loop $taglist $tag}-->
        <tr align="center" class="smalltxt">
            <td class="altbg2">&nbsp;
            <input class="checkbox" type="checkbox" id="{$tag['qid']}" value="{$tag['name']}" name="delete[]"></td>
            <td  class="altbg2"><a href="{url tag-$tag['name']}" target="_blank">{$tag['name']}</a></td>
            <td  class="altbg2">{if isset($tag['questions'])}$tag['questions']{/if}</td>
            <td  class="altbg2"><span class="{$tag['name']}">{$tag['pinyin']}</span></td>
        </tr>
        <!--{/loop}-->
      <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg1" colspan="3" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr><td colspan="3" class="altbg1"><input type="submit" class="btn btn-success" value="删除" /></td></tr>
    </table>
</form>
<script>
var _count=0;
function getpinyin(){
	  if ($("input[name='delete[]']:checked").length == 0) {
          alert('你没有选择任何标签');
          return false;
      }
	  _count=0;
	   var tags = document.getElementsByName('delete[]');

       for (var i = 0; i < tags.length; i++) {
           if (tags[i].checked == true) {

        	   postpinyintag(tags[i].value,tags[i].id)
           }
       }
}
function postpinyintag(_name,_id){

	var _charstr='';
	for(i=0;i<_name.length;i++){

		_charstr=_charstr+","+_name.charAt(i);

	}



	var datajson={name:_name,spname:_charstr,id:_id};
	var url="{SITE_URL}index.php?admin_tag/changepinyin{$setting['seo_suffix']}";

	 $.ajax({
         type: "POST",
         url: url,
         data:datajson,
         success:function(data) {
        	 _count++;
        	 $("."+_name).html(data);
             $(".pinyintip").html("成功转换"+_count+"个标签");
         }
     });
}
</script>
<!--{template footer}-->
